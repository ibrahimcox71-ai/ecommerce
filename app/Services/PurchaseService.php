<?php

namespace App\Services;

use App\Enums\PurchasePaymentStatus;
use App\Enums\PurchaseStatus;
use App\Models\Admin;
use App\Models\Inventory;
use App\Models\InventoryLog;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Repositories\PurchaseRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class PurchaseService extends BaseService
{
    protected string $repositoryClass = PurchaseRepository::class;

    public function createPurchase(array $data, Admin $user): Purchase
    {
        return DB::transaction(function () use ($data, $user) {
            $data['po_number'] = Purchase::generatePONumber();
            $data['created_by'] = $user->id;
            $data['status'] = $data['status'] ?? PurchaseStatus::Draft->value;

            $items = $data['items'] ?? [];
            unset($data['items']);

            $calculated = $this->calculateTotals($items, $data);
            $data = array_merge($data, $calculated);

            $purchase = $this->create($data);

            $this->syncItems($purchase, $items);

            return $purchase->load(['supplier', 'warehouse', 'items.product', 'items.variant']);
        });
    }

    public function updatePurchase(int $id, array $data): Purchase
    {
        return DB::transaction(function () use ($id, $data) {
            $purchase = $this->findOrFail($id);

            if (!$purchase->isEditable()) {
                throw new \RuntimeException('Purchase order cannot be edited in current status.');
            }

            $items = $data['items'] ?? [];
            unset($data['items']);

            $calculated = $this->calculateTotals($items, $data);
            $data = array_merge($data, $calculated);

            $this->update($id, $data);

            $purchase->items()->delete();
            $this->syncItems($purchase, $items);

            return $purchase->fresh(['supplier', 'warehouse', 'items.product', 'items.variant']);
        });
    }

    public function approve(int $id, Admin $user): Purchase
    {
        return DB::transaction(function () use ($id, $user) {
            $purchase = $this->findOrFail($id);

            if (!$purchase->isApprovable()) {
                throw new \RuntimeException('Purchase order cannot be approved in current status.');
            }

            $purchase->update([
                'status' => PurchaseStatus::Approved->value,
                'approved_by' => $user->id,
                'approved_at' => now(),
            ]);

            $purchase->supplier()->update([
                'last_purchase_date' => now(),
            ]);

            return $purchase->fresh();
        });
    }

    public function reject(int $id, Admin $user): Purchase
    {
        return DB::transaction(function () use ($id, $user) {
            $purchase = $this->findOrFail($id);

            if (!$purchase->isApprovable()) {
                throw new \RuntimeException('Purchase order cannot be rejected in current status.');
            }

            $purchase->update([
                'status' => PurchaseStatus::Cancelled->value,
                'cancelled_at' => now(),
            ]);

            return $purchase->fresh();
        });
    }

    public function markAsOrdered(int $id, Admin $user): Purchase
    {
        return DB::transaction(function () use ($id, $user) {
            $purchase = $this->findOrFail($id);

            if ($purchase->status->value !== PurchaseStatus::Approved->value) {
                throw new \RuntimeException('Only approved purchase orders can be marked as ordered.');
            }

            $purchase->update([
                'status' => PurchaseStatus::Ordered->value,
                'ordered_at' => now(),
            ]);

            return $purchase->fresh();
        });
    }

    public function cancel(int $id): Purchase
    {
        return DB::transaction(function () use ($id) {
            $purchase = $this->findOrFail($id);

            if (!$purchase->isCancellable()) {
                throw new \RuntimeException('Purchase order cannot be cancelled in current status.');
            }

            $purchase->update([
                'status' => PurchaseStatus::Cancelled->value,
                'cancelled_at' => now(),
            ]);

            return $purchase->fresh();
        });
    }

    public function clonePurchase(int $id): Purchase
    {
        return DB::transaction(function () use ($id) {
            $original = $this->findOrFail($id);
            $original->load('items');

            $data = $original->toArray();
            unset($data['id'], $data['po_number'], $data['status'], $data['payment_status'],
                $data['paid_amount'], $data['due_amount'], $data['approved_by'], $data['approved_at'],
                $data['ordered_at'], $data['completed_at'], $data['cancelled_at'],
                $data['created_at'], $data['updated_at'], $data['deleted_at']);

            $items = $original->items->map(function ($item) {
                return $item->toArray();
            })->toArray();

            $data['items'] = $items;
            $data['status'] = PurchaseStatus::Draft->value;

            return $this->create($data);
        });
    }

    public function getReportData(array $filters = []): Collection
    {
        return app(PurchaseRepository::class)->getReportData($filters)->get();
    }

    public function getSupplierReport(int $supplierId, array $filters = []): Collection
    {
        return Purchase::with(['items', 'payments'])
            ->where('supplier_id', $supplierId)
            ->when($filters['date_from'] ?? null, fn($q, $v) => $q->whereDate('purchase_date', '>=', $v))
            ->when($filters['date_to'] ?? null, fn($q, $v) => $q->whereDate('purchase_date', '<=', $v))
            ->when($filters['status'] ?? null, fn($q, $v) => $q->where('status', $v))
            ->orderBy('purchase_date', 'desc')
            ->get();
    }

    public function getPaymentReport(array $filters = []): Collection
    {
        return \App\Models\PurchasePayment::with(['purchase.supplier', 'creator'])
            ->when($filters['date_from'] ?? null, fn($q, $v) => $q->whereDate('payment_date', '>=', $v))
            ->when($filters['date_to'] ?? null, fn($q, $v) => $q->whereDate('payment_date', '<=', $v))
            ->when($filters['payment_method'] ?? null, fn($q, $v) => $q->where('payment_method', $v))
            ->when($filters['supplier_id'] ?? null, fn($q, $v) => $q->whereHas('purchase', fn($sq) => $sq->where('supplier_id', $v)))
            ->orderBy('payment_date', 'desc')
            ->get();
    }

    public function getOutstandingReport(array $filters = []): Collection
    {
        return Purchase::with(['supplier', 'items'])
            ->where('payment_status', '!=', PurchasePaymentStatus::Paid->value)
            ->where('status', '!=', PurchaseStatus::Cancelled->value)
            ->where('status', '!=', PurchaseStatus::Draft->value)
            ->when($filters['supplier_id'] ?? null, fn($q, $v) => $q->where('supplier_id', $v))
            ->when($filters['date_from'] ?? null, fn($q, $v) => $q->whereDate('purchase_date', '>=', $v))
            ->when($filters['date_to'] ?? null, fn($q, $v) => $q->whereDate('purchase_date', '<=', $v))
            ->orderBy('due_amount', 'desc')
            ->get();
    }

    public function getReturnReport(array $filters = []): Collection
    {
        return \App\Models\PurchaseReturn::with(['purchase.supplier', 'product', 'variant', 'creator'])
            ->when($filters['date_from'] ?? null, fn($q, $v) => $q->whereDate('return_date', '>=', $v))
            ->when($filters['date_to'] ?? null, fn($q, $v) => $q->whereDate('return_date', '<=', $v))
            ->when($filters['supplier_id'] ?? null, fn($q, $v) => $q->whereHas('purchase', fn($sq) => $sq->where('supplier_id', $v)))
            ->when($filters['refund_status'] ?? null, fn($q, $v) => $q->where('refund_status', $v))
            ->orderBy('return_date', 'desc')
            ->get();
    }

    protected function syncItems(Purchase $purchase, array $items): void
    {
        foreach ($items as $item) {
            $product = Product::find($item['product_id']);
            $variant = null;

            if (!empty($item['product_variant_id'])) {
                $variant = ProductVariant::find($item['product_variant_id']);
            }

            $quantity = $item['quantity'] ?? 1;
            $unitPrice = $item['unit_price'] ?? 0;
            $discount = $item['discount'] ?? 0;
            $discountPct = $item['discount_percentage'] ?? 0;
            $taxRate = $item['tax_rate'] ?? 0;

            $lineSubtotal = $quantity * $unitPrice;
            $lineDiscount = $discount > 0 ? $discount : ($lineSubtotal * $discountPct / 100);
            $lineTax = ($lineSubtotal - $lineDiscount) * $taxRate / 100;
            $lineTotal = $lineSubtotal - $lineDiscount + $lineTax;

            PurchaseItem::create([
                'purchase_id' => $purchase->id,
                'product_id' => $item['product_id'],
                'product_variant_id' => $item['product_variant_id'] ?? null,
                'sku' => $item['sku'] ?? ($variant->sku ?? $product->sku ?? null),
                'product_name' => $item['product_name'] ?? ($variant ? $product->name . ' - ' . $variant->name : $product->name),
                'quantity' => $quantity,
                'received_quantity' => 0,
                'returned_quantity' => 0,
                'unit_price' => $unitPrice,
                'discount' => $lineDiscount,
                'discount_percentage' => $discountPct,
                'tax' => $lineTax,
                'tax_rate' => $taxRate,
                'subtotal' => $lineSubtotal,
                'total' => $lineTotal,
            ]);
        }
    }

    protected function calculateTotals(array $items, array $data): array
    {
        $subtotal = 0;
        foreach ($items as $item) {
            $qty = $item['quantity'] ?? 1;
            $price = $item['unit_price'] ?? 0;
            $subtotal += $qty * $price;
        }

        $discountPct = $data['discount_percentage'] ?? 0;
        $discountAmount = $data['discount_amount'] ?? 0;

        if ($discountPct > 0 && $discountAmount == 0) {
            $discountAmount = $subtotal * $discountPct / 100;
        }

        $taxAmount = $data['tax_amount'] ?? 0;
        $shippingCost = $data['shipping_cost'] ?? 0;
        $otherCost = $data['other_cost'] ?? 0;

        $total = $subtotal - $discountAmount + $taxAmount + $shippingCost + $otherCost;

        return [
            'subtotal' => $subtotal,
            'discount_amount' => $discountAmount,
            'tax_amount' => $taxAmount,
            'shipping_cost' => $shippingCost,
            'other_cost' => $otherCost,
            'total_amount' => $total,
        ];
    }
}
