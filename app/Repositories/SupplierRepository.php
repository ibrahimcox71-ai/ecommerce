<?php

namespace App\Repositories;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class SupplierRepository extends BaseRepository
{
    protected function model(): Supplier
    {
        return new Supplier;
    }

    public function paginateWithFilters(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return $this->applyFilters($filters)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    public function trashedPaginate(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return Supplier::onlyTrashed()
            ->when($filters['search'] ?? null, fn($q, $v) => $q->search($v))
            ->orderBy('deleted_at', 'desc')
            ->paginate($perPage);
    }

    public function bulkDelete(array $ids): array
    {
        $suppliers = Supplier::whereIn('id', $ids)->get();
        $deleted = 0;
        $skipped = [];

        foreach ($suppliers as $supplier) {
            if ($supplier->products()->exists()) {
                $skipped[] = $supplier->name;
                continue;
            }
            $supplier->delete();
            $deleted++;
        }

        return ['deleted' => $deleted, 'skipped' => $skipped];
    }

    public function bulkRestore(array $ids): int
    {
        return Supplier::onlyTrashed()
            ->whereIn('id', $ids)
            ->restore();
    }

    public function bulkForceDelete(array $ids): int
    {
        $count = 0;
        Supplier::onlyTrashed()->whereIn('id', $ids)->each(function ($supplier) use (&$count) {
            $supplier->forceDelete();
            $count++;
        });
        return $count;
    }

    public function bulkUpdateStatus(array $ids, string $status): int
    {
        return Supplier::whereIn('id', $ids)->update(['status' => $status]);
    }

    public function getStats(): array
    {
        return [
            'total' => Supplier::count(),
            'active' => Supplier::where('status', 'active')->count(),
            'inactive' => Supplier::where('status', 'inactive')->count(),
            'blacklisted' => Supplier::where('status', 'blacklisted')->count(),
            'with_products' => Supplier::has('products')->count(),
            'trashed' => Supplier::onlyTrashed()->count(),
            'total_outstanding' => Supplier::sum('outstanding_balance'),
        ];
    }

    public function searchSuggestions(string $query): array
    {
        return Supplier::search($query)
            ->active()
            ->take(10)
            ->get()
            ->map(fn($supplier) => [
                'id' => $supplier->id,
                'name' => $supplier->name,
                'supplier_code' => $supplier->supplier_code,
                'company' => $supplier->company_name,
                'logo' => $supplier->logo_url,
                'product_count' => $supplier->products_count ?? 0,
            ])
            ->toArray();
    }

    public function checkDeletable(int $id): array
    {
        $supplier = Supplier::findOrFail($id);
        return [
            'deletable' => !$supplier->products()->exists(),
            'has_products' => $supplier->products()->exists(),
            'product_count' => $supplier->products()->count(),
        ];
    }

    protected function applyFilters(array $filters): Builder
    {
        return Supplier::withCount('products')
            ->when($filters['search'] ?? null, fn($q, $v) => $q->search($v))
            ->when($filters['status'] ?? null, fn($q, $v) => $q->where('status', $v))
            ->when($filters['country'] ?? null, fn($q, $v) => $q->where('country', $v))
            ->when($filters['city'] ?? null, fn($q, $v) => $q->where('city', $v))
            ->when($filters['date_from'] ?? null, fn($q, $v) => $q->whereDate('created_at', '>=', $v))
            ->when($filters['date_to'] ?? null, fn($q, $v) => $q->whereDate('created_at', '<=', $v));
    }
}
