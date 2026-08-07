<?php

namespace App\Repositories;

use App\Models\Purchase;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class PurchaseRepository extends BaseRepository
{
    protected function model(): Purchase
    {
        return new Purchase;
    }

    public function query(): Builder
    {
        return $this->model->newQuery();
    }

    public function paginateWithFilters(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return $this->applyFilters($filters)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    public function getStats(): array
    {
        return [
            'total' => Purchase::count(),
            'draft' => Purchase::where('status', 'draft')->count(),
            'pending' => Purchase::where('status', 'pending')->count(),
            'approved' => Purchase::where('status', 'approved')->count(),
            'ordered' => Purchase::where('status', 'ordered')->count(),
            'partially_received' => Purchase::where('status', 'partially_received')->count(),
            'completed' => Purchase::where('status', 'completed')->count(),
            'cancelled' => Purchase::where('status', 'cancelled')->count(),
            'returned' => Purchase::where('status', 'returned')->count(),
            'total_amount' => Purchase::sum('total_amount'),
            'total_paid' => Purchase::sum('paid_amount'),
            'total_due' => Purchase::sum('due_amount'),
        ];
    }

    public function getReportData(array $filters = []): Builder
    {
        return $this->applyFilters($filters)
            ->with(['supplier', 'warehouse', 'items', 'payments']);
    }

    protected function applyFilters(array $filters): Builder
    {
        return Purchase::with(['supplier', 'warehouse', 'items'])
            ->when($filters['search'] ?? null, function ($q, $v) {
                $q->where(function ($sq) use ($v) {
                    $sq->where('po_number', 'like', "%{$v}%")
                        ->orWhere('reference_number', 'like', "%{$v}%")
                        ->orWhereHas('supplier', fn($sq) => $sq->where('name', 'like', "%{$v}%"))
                        ->orWhereHas('warehouse', fn($sq) => $sq->where('name', 'like', "%{$v}%"));
                });
            })
            ->when($filters['status'] ?? null, fn($q, $v) => $q->where('status', $v))
            ->when($filters['payment_status'] ?? null, fn($q, $v) => $q->where('payment_status', $v))
            ->when($filters['supplier_id'] ?? null, fn($q, $v) => $q->where('supplier_id', $v))
            ->when($filters['warehouse_id'] ?? null, fn($q, $v) => $q->where('warehouse_id', $v))
            ->when($filters['date_from'] ?? null, fn($q, $v) => $q->whereDate('purchase_date', '>=', $v))
            ->when($filters['date_to'] ?? null, fn($q, $v) => $q->whereDate('purchase_date', '<=', $v))
            ->when($filters['po_number'] ?? null, fn($q, $v) => $q->where('po_number', 'like', "%{$v}%"));
    }
}
