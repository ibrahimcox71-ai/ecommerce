<?php

namespace App\Services;

use App\Enums\PurchaseStatus;
use App\Models\Admin;
use App\Models\GoodsReceipt;
use App\Models\GoodsReceiptItem;
use App\Models\Inventory;
use App\Models\InventoryLog;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\StockMovement;
use App\Repositories\PurchaseRepository;
use Illuminate\Support\Facades\DB;

class GoodsReceiptService
{
    public function receiveFull(int $purchaseId, Admin $user, ?string $notes = null): GoodsReceipt
    {
        return $this->receive($purchaseId, $user, 'full', null, $notes);
    }

    public function receivePartial(int $purchaseId, Admin $user, array $items, ?string $notes = null): GoodsReceipt
    {
        return $this->receive($purchaseId, $user, 'partial', $items, $notes);
    }

    public function receiveRemaining(int $purchaseId, Admin $user, ?string $notes = null): GoodsReceipt
    {
        return $this->receive($purchaseId, $user, 'remaining', null, $notes);
    }

    protected function receive(int $purchaseId, Admin $user, string $type, ?array $partialItems = null, ?string $notes = null): GoodsReceipt
    {
        return DB::transaction(function () use ($purchaseId, $user, $type, $partialItems, $notes) {
            $purchase = app(PurchaseRepository::class)->findOrFail($purchaseId);
            $purchase->load('items');

            if (!$purchase->isReceivable()) {
                throw new \RuntimeException('Goods cannot be received for this purchase order in current status.');
            }

            $receipt = GoodsReceipt::create([
                'grn_number' => GoodsReceipt::generateGRNNumber(),
                'purchase_id' => $purchase->id,
                'receipt_type' => $type,
                'notes' => $notes,
                'received_by' => $user->id,
                'received_at' => now(),
            ]);

            $allFullyReceived = true;

            foreach ($purchase->items as $purchaseItem) {
                if ($type === 'full') {
                    $receiveQty = $purchaseItem->quantity - $purchaseItem->received_quantity;
                } elseif ($type === 'remaining') {
                    $pending = $purchaseItem->quantity - $purchaseItem->received_quantity;
                    $receiveQty = max(0, $pending);
                } else {
                    $key = $purchaseItem->id;
                    $receiveQty = ($partialItems[$key] ?? 0);
                }

                if ($receiveQty <= 0) {
                    continue;
                }

                GoodsReceiptItem::create([
                    'goods_receipt_id' => $receipt->id,
                    'purchase_item_id' => $purchaseItem->id,
                    'product_id' => $purchaseItem->product_id,
                    'product_variant_id' => $purchaseItem->product_variant_id,
                    'quantity' => $receiveQty,
                    'unit_price' => $purchaseItem->unit_price,
                    'subtotal' => $receiveQty * $purchaseItem->unit_price,
                ]);

                $purchaseItem->increment('received_quantity', $receiveQty);

                $this->updateInventory($purchase, $purchaseItem, $receiveQty, $user);

                if ($purchaseItem->received_quantity < $purchaseItem->quantity) {
                    $allFullyReceived = false;
                }
            }

            $newStatus = $allFullyReceived
                ? PurchaseStatus::Completed->value
                : PurchaseStatus::PartiallyReceived->value;

            $updateData = ['status' => $newStatus];
            if ($newStatus === PurchaseStatus::Completed->value) {
                $updateData['completed_at'] = now();
            }

            $purchase->update($updateData);

            $purchase->supplier()->update(['last_purchase_date' => now()]);

            return $receipt->load(['items.product', 'items.variant', 'receiver']);
        });
    }

    protected function updateInventory(Purchase $purchase, PurchaseItem $purchaseItem, float $quantity, Admin $user): void
    {
        $inventory = Inventory::firstOrCreate(
            [
                'product_id' => $purchaseItem->product_id,
                'product_variant_id' => $purchaseItem->product_variant_id,
                'warehouse_id' => $purchase->warehouse_id,
            ],
            [
                'quantity' => 0,
                'reserved_quantity' => 0,
                'incoming_stock' => 0,
                'damaged_stock' => 0,
                'returned_stock' => 0,
                'low_stock_threshold' => config('ecommerce.inventory.low_stock_threshold', 10),
            ]
        );

        $beforeQty = $inventory->quantity;
        $inventory->increment('quantity', $quantity);

        InventoryLog::create([
            'product_id' => $purchaseItem->product_id,
            'product_variant_id' => $purchaseItem->product_variant_id,
            'warehouse_id' => $purchase->warehouse_id,
            'reference_type' => 'purchase',
            'reference_id' => $purchase->id,
            'quantity_before' => $beforeQty,
            'quantity_after' => $beforeQty + $quantity,
            'quantity_change' => $quantity,
            'reason' => 'Goods Receipt - ' . $purchase->po_number,
            'note' => "Received via GRN from purchase order {$purchase->po_number}",
            'causer_type' => get_class($user),
            'causer_id' => $user->id,
        ]);

        StockMovement::create([
            'product_id' => $purchaseItem->product_id,
            'product_variant_id' => $purchaseItem->product_variant_id,
            'to_warehouse_id' => $purchase->warehouse_id,
            'movement_type' => 'stock_in',
            'quantity' => $quantity,
            'quantity_before' => $beforeQty,
            'quantity_after' => $beforeQty + $quantity,
            'reference_number' => $purchase->po_number,
            'reason' => 'Purchase Receipt',
            'notes' => "GRN for purchase order {$purchase->po_number}",
            'causer_type' => get_class($user),
            'causer_id' => $user->id,
        ]);
    }
}
