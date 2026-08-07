<?php

namespace App\Services;

use App\Enums\PurchaseStatus;
use App\Models\Admin;
use App\Models\Inventory;
use App\Models\InventoryLog;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\PurchaseReturn;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;

class PurchaseReturnService
{
    public function returnItems(int $purchaseId, array $items, Admin $user): array
    {
        return DB::transaction(function () use ($purchaseId, $items, $user) {
            $purchase = Purchase::with('items')->findOrFail($purchaseId);

            if (!in_array($purchase->status->value, ['completed', 'partially_received'])) {
                throw new \RuntimeException('Cannot return items for this purchase order.');
            }

            $returns = [];

            foreach ($items as $itemData) {
                $purchaseItem = PurchaseItem::findOrFail($itemData['purchase_item_id']);
                $returnQty = $itemData['quantity'];

                $returnable = $purchaseItem->received_quantity - $purchaseItem->returned_quantity;
                if ($returnQty > $returnable) {
                    throw new \RuntimeException(
                        "Cannot return more than received quantity for item {$purchaseItem->product_name}."
                    );
                }

                $purchaseReturn = PurchaseReturn::create([
                    'return_number' => PurchaseReturn::generateReturnNumber(),
                    'purchase_id' => $purchase->id,
                    'purchase_item_id' => $purchaseItem->id,
                    'product_id' => $purchaseItem->product_id,
                    'product_variant_id' => $purchaseItem->product_variant_id,
                    'quantity' => $returnQty,
                    'unit_price' => $purchaseItem->unit_price,
                    'total_amount' => $returnQty * $purchaseItem->unit_price,
                    'reason' => $itemData['reason'] ?? null,
                    'refund_status' => 'pending',
                    'refund_amount' => 0,
                    'return_date' => now(),
                    'notes' => $itemData['notes'] ?? null,
                    'created_by' => $user->id,
                ]);

                $purchaseItem->increment('returned_quantity', $returnQty);

                $this->adjustInventoryForReturn($purchaseItem, $returnQty, $user);

                $returns[] = $purchaseReturn;
            }

            $allReturned = $purchase->items->every(fn($item) => $item->returned_quantity >= $item->received_quantity);
            if ($allReturned) {
                $purchase->update(['status' => PurchaseStatus::Returned->value]);
            } else {
                $purchase->update(['status' => PurchaseStatus::PartiallyReceived->value]);
            }

            return $returns;
        });
    }

    protected function adjustInventoryForReturn(PurchaseItem $purchaseItem, float $quantity, Admin $user): void
    {
        $inventory = Inventory::where('product_id', $purchaseItem->product_id)
            ->where('product_variant_id', $purchaseItem->product_variant_id)
            ->first();

        if (!$inventory) {
            return;
        }

        $beforeQty = $inventory->quantity;
        $inventory->decrement('quantity', $quantity);

        InventoryLog::create([
            'product_id' => $purchaseItem->product_id,
            'product_variant_id' => $purchaseItem->product_variant_id,
            'warehouse_id' => $inventory->warehouse_id,
            'reference_type' => 'purchase_return',
            'reference_id' => $purchaseItem->purchase_id,
            'quantity_before' => $beforeQty,
            'quantity_after' => $beforeQty - $quantity,
            'quantity_change' => -$quantity,
            'reason' => 'Purchase Return',
            'note' => "Stock deducted for purchase return",
            'causer_type' => get_class($user),
            'causer_id' => $user->id,
        ]);

        StockMovement::create([
            'product_id' => $purchaseItem->product_id,
            'product_variant_id' => $purchaseItem->product_variant_id,
            'from_warehouse_id' => $inventory->warehouse_id,
            'movement_type' => 'return',
            'quantity' => $quantity,
            'quantity_before' => $beforeQty,
            'quantity_after' => $beforeQty - $quantity,
            'reference_number' => $purchaseItem->purchase->po_number ?? null,
            'reason' => 'Purchase Return',
            'notes' => 'Stock returned to supplier',
            'causer_type' => get_class($user),
            'causer_id' => $user->id,
        ]);
    }
}
