<?php

namespace App\Repositories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class BrandRepository extends BaseRepository
{
    protected function model(): Brand
    {
        return new Brand;
    }

    public function paginateWithFilters(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return $this->applyFilters($filters)
            ->sorted()
            ->paginate($perPage);
    }

    public function trashedPaginate(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return Brand::onlyTrashed()
            ->when($filters['search'] ?? null, fn($q, $v) => $q->search($v))
            ->orderBy('deleted_at', 'desc')
            ->paginate($perPage);
    }

    public function duplicate(int $id): Brand
    {
        $original = Brand::findOrFail($id);
        $copy = $original->replicate();
        $copy->name = $original->name . ' (Copy)';
        $copy->slug = $original->slug . '-copy-' . uniqid();
        $copy->status = \App\Enums\BrandStatus::from('inactive');
        $copy->save();

        return $copy;
    }

    public function bulkDelete(array $ids): array
    {
        $brands = Brand::whereIn('id', $ids)->get();
        $deleted = 0;
        $skipped = [];

        foreach ($brands as $brand) {
            if ($brand->products()->exists()) {
                $skipped[] = $brand->name;
                continue;
            }
            $brand->delete();
            $deleted++;
        }

        return ['deleted' => $deleted, 'skipped' => $skipped];
    }

    public function bulkRestore(array $ids): int
    {
        return Brand::onlyTrashed()
            ->whereIn('id', $ids)
            ->restore();
    }

    public function bulkForceDelete(array $ids): int
    {
        $count = 0;
        Brand::onlyTrashed()->whereIn('id', $ids)->each(function ($brand) use (&$count) {
            $brand->forceDelete();
            $count++;
        });
        return $count;
    }

    public function bulkUpdateStatus(array $ids, string $status): int
    {
        return Brand::whereIn('id', $ids)->update(['status' => $status]);
    }

    public function getStats(): array
    {
        return [
            'total' => Brand::count(),
            'active' => Brand::where('status', 'active')->count(),
            'inactive' => Brand::where('status', 'inactive')->count(),
            'hidden' => Brand::where('status', 'hidden')->count(),
            'featured' => Brand::where('featured', true)->count(),
            'popular' => Brand::where('popular', true)->count(),
            'with_products' => Brand::has('products')->count(),
            'trashed' => Brand::onlyTrashed()->count(),
        ];
    }

    public function searchSuggestions(string $query): array
    {
        return Brand::search($query)
            ->active()
            ->withCount('products')
            ->take(10)
            ->get()
            ->map(fn($brand) => [
                'id' => $brand->id,
                'name' => $brand->name,
                'slug' => $brand->slug,
                'logo' => $brand->logo_url,
                'product_count' => $brand->products_count,
            ])
            ->toArray();
    }

    public function checkDeletable(int $id): array
    {
        $brand = Brand::findOrFail($id);
        return [
            'deletable' => !$brand->products()->exists(),
            'has_products' => $brand->products()->exists(),
            'product_count' => $brand->products()->count(),
            'active_products' => $brand->products()->where('status', 'active')->count(),
            'out_of_stock_products' => $brand->products()->where('stock', '<=', 0)->count(),
        ];
    }

    protected function applyFilters(array $filters): Builder
    {
        return Brand::withCount([
            'products',
            'products as active_products_count' => fn($q) => $q->where('status', 'active'),
            'products as out_of_stock_products_count' => fn($q) => $q->where('stock', '<=', 0),
        ])
            ->when($filters['search'] ?? null, fn($q, $v) => $q->search($v))
            ->when($filters['status'] ?? null, fn($q, $v) => $q->where('status', $v))
            ->when(isset($filters['featured']), fn($q) => $q->where('featured', $filters['featured']))
            ->when(isset($filters['popular']), fn($q) => $q->where('popular', $filters['popular']))
            ->when($filters['country'] ?? null, fn($q, $v) => $q->where('country', $v))
            ->when($filters['date_from'] ?? null, fn($q, $v) => $q->whereDate('created_at', '>=', $v))
            ->when($filters['date_to'] ?? null, fn($q, $v) => $q->whereDate('created_at', '<=', $v));
    }
}
