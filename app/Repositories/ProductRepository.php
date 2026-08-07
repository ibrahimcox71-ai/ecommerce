<?php

namespace App\Repositories;

use App\Enums\ProductStatus;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductRepository extends BaseRepository
{
    protected function model(): Model
    {
        return new Product();
    }

    public function getWithAllRelations(array $relations = []): Collection
    {
        $defaultRelations = ['category', 'brand', 'images', 'variants'];
        $relations = array_unique(array_merge($defaultRelations, $relations));

        return $this->model->with($relations)->get();
    }

    public function paginateWithFilters(
        int $perPage = 15,
        array $filters = [],
        array $relations = [],
        array $orderBy = ['sort_order', 'asc']
    ): LengthAwarePaginator {
        $query = $this->model->with($relations);

        $query = $this->applyFilters($query, $filters);

        $query->orderBy($orderBy[0], $orderBy[1]);

        return $query->paginate($perPage);
    }

    protected function applyFilters(Builder $query, array $filters): Builder
    {
        if (!empty($filters['search'])) {
            $query->search($filters['search']);
        }

        if (!empty($filters['status'])) {
            if ($filters['status'] === 'active') {
                $query->active();
            } elseif ($filters['status'] === 'draft') {
                $query->draft();
            } elseif ($filters['status'] === 'archived') {
                $query->archived();
            } elseif ($filters['status'] === 'hidden') {
                $query->hidden();
            } else {
                $query->where('status', $filters['status']);
            }
        }

        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (!empty($filters['sub_category_id'])) {
            $query->where('sub_category_id', $filters['sub_category_id']);
        }

        if (!empty($filters['brand_id'])) {
            $query->where('brand_id', $filters['brand_id']);
        }

        if (!empty($filters['product_type'])) {
            $query->where('product_type', $filters['product_type']);
        }

        if (!empty($filters['min_price'])) {
            $query->where('price', '>=', $filters['min_price']);
        }
        if (!empty($filters['max_price'])) {
            $query->where('price', '<=', $filters['max_price']);
        }

        if (!empty($filters['date_from'])) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }
        if (!empty($filters['date_to'])) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }

        if (isset($filters['featured']) && $filters['featured']) {
            $query->featured();
        }

        if (isset($filters['trending']) && $filters['trending']) {
            $query->trending();
        }

        if (isset($filters['best_seller']) && $filters['best_seller']) {
            $query->bestSeller();
        }

        if (!empty($filters['in_stock'])) {
            $query->inStock();
        }

        if (!empty($filters['low_stock'])) {
            $query->lowStock();
        }

        if (!empty($filters['out_of_stock'])) {
            $query->outOfStock();
        }

        if (!empty($filters['with_discount'])) {
            $query->withDiscount();
        }

        return $query;
    }

    public function getTrashed(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = $this->model->onlyTrashed();

        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', "%{$filters['search']}%")
                  ->orWhere('sku', 'like', "%{$filters['search']}%");
            });
        }

        return $query->orderBy('deleted_at', 'desc')->paginate($perPage);
    }

    public function findWithVariants(int $id): ?Model
    {
        return $this->model->with(['category', 'brand', 'images', 'variants.attributeValues.attribute', 'inventories.warehouse'])
            ->find($id);
    }

    public function findBySku(string $sku): ?Model
    {
        return $this->model->where('sku', $sku)->first();
    }

    public function findByBarcode(string $barcode): ?Model
    {
        return $this->model->where('barcode', $barcode)->first();
    }

    public function getFeatured(int $limit = 10): Collection
    {
        return $this->model->active()
            ->featured()
            ->inStock()
            ->with(['images', 'brand'])
            ->limit($limit)
            ->get();
    }

    public function getTrending(int $limit = 10): Collection
    {
        return $this->model->active()
            ->trending()
            ->inStock()
            ->with(['images', 'brand'])
            ->limit($limit)
            ->get();
    }

    public function getBestSellers(int $limit = 10): Collection
    {
        return $this->model->active()
            ->bestSeller()
            ->inStock()
            ->with(['images', 'brand'])
            ->limit($limit)
            ->get();
    }

    public function getRelatedProducts(int $productId, int $limit = 10): Collection
    {
        $product = $this->findById($productId);

        if (!$product) {
            return collect();
        }

        return $this->model->active()
            ->inStock()
            ->where('id', '!=', $productId)
            ->where(function ($query) use ($product) {
                $query->where('category_id', $product->category_id)
                      ->orWhere('brand_id', $product->brand_id);
            })
            ->with(['images'])
            ->limit($limit)
            ->get();
    }

    public function getByCategory(int $categoryId, array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = $this->model->active()
            ->where('category_id', $categoryId);

        $query = $this->applyFilters($query, $filters);

        return $query->paginate($perPage);
    }

    public function bulkUpdateStatus(array $ids, string $status): int
    {
        return $this->model->whereIn('id', $ids)
            ->update(['status' => $status]);
    }

    public function bulkToggleFeatured(array $ids): int
    {
        $products = $this->model->whereIn('id', $ids)->get();
        $count = 0;
        foreach ($products as $product) {
            $product->update(['featured' => !$product->featured]);
            $count++;
        }
        return $count;
    }

    public function bulkToggleTrending(array $ids): int
    {
        $products = $this->model->whereIn('id', $ids)->get();
        $count = 0;
        foreach ($products as $product) {
            $product->update(['trending' => !$product->trending]);
            $count++;
        }
        return $count;
    }

    public function bulkToggleBestSeller(array $ids): int
    {
        $products = $this->model->whereIn('id', $ids)->get();
        $count = 0;
        foreach ($products as $product) {
            $product->update(['best_seller' => !$product->best_seller]);
            $count++;
        }
        return $count;
    }

    public function bulkEdit(array $ids, array $fields): int
    {
        $clean = array_filter($fields, function ($value) {
            return $value !== null && $value !== '' && $value !== [];
        });

        if (empty($clean)) {
            return 0;
        }

        return $this->model->whereIn('id', $ids)->update($clean);
    }

    public function bulkDelete(array $ids): int
    {
        return $this->model->whereIn('id', $ids)->delete();
    }

    public function bulkForceDelete(array $ids): int
    {
        return $this->model->withTrashed()->whereIn('id', $ids)->forceDelete();
    }

    public function bulkRestore(array $ids): int
    {
        return $this->model->onlyTrashed()->whereIn('id', $ids)->restore();
    }

    public function getExportQuery(array $filters = []): Builder
    {
        $query = $this->model->with(['category', 'brand', 'subCategory']);

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (!empty($filters['brand_id'])) {
            $query->where('brand_id', $filters['brand_id']);
        }

        if (!empty($filters['product_type'])) {
            $query->where('product_type', $filters['product_type']);
        }

        if (!empty($filters['search'])) {
            $query->search($filters['search']);
        }

        if (!empty($filters['date_from'])) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }

        return $query->latest();
    }

    public function dataTable(array $params = []): array
    {
        $query = $this->model->with(['category', 'brand']);

        $total = $this->model->count();

        if (!empty($params['search']['value'])) {
            $query->search($params['search']['value']);
        }

        if (!empty($params['status'])) {
            $query->where('status', $params['status']);
        }

        if (!empty($params['category_id'])) {
            $query->where('category_id', $params['category_id']);
        }

        if (!empty($params['brand_id'])) {
            $query->where('brand_id', $params['brand_id']);
        }

        $order = $params['order'][0] ?? [];
        $sortColumn = $order['column'] ?? 'sort_order';
        $sortDir = $order['dir'] ?? 'asc';
        $columns = ['id', 'name', 'sku', 'price', 'stock', 'status', 'featured', 'sort_order', 'created_at'];
        if (in_array($sortColumn, $columns)) {
            $query->orderBy($sortColumn, $sortDir);
        }

        $perPage = max(1, $params['length'] ?? 15);
        $page = ($params['start'] ?? 0) / $perPage + 1;

        $products = $query->paginate($perPage, ['*'], 'page', $page);

        return [
            'draw' => $params['draw'] ?? 0,
            'recordsTotal' => $total,
            'recordsFiltered' => $products->total(),
            'data' => $products->items(),
            'current_page' => $products->currentPage(),
            'last_page' => $products->lastPage(),
            'from' => $products->firstItem(),
            'to' => $products->lastItem(),
        ];
    }

    public function updateSortOrder(array $items): void
    {
        foreach ($items as $item) {
            $this->model->where('id', $item['id'])->update(['sort_order' => $item['sort_order']]);
        }
    }

    public function duplicate(int $id): ?Model
    {
        $product = $this->findById($id, ['*'], ['images', 'variants']);

        if (!$product) {
            return null;
        }

        $newProduct = $product->replicate();
        $newProduct->name = $product->name . ' (Copy)';
        $newProduct->sku = $product->sku . '-COPY-' . time();
        $newProduct->slug = $product->slug . '-copy-' . time();
        $newProduct->status = ProductStatus::Draft;
        $newProduct->published_at = null;
        $newProduct->save();

        foreach ($product->images as $image) {
            $newImage = $image->replicate();
            $newImage->product_id = $newProduct->id;
            $newImage->save();
        }

        return $newProduct->load(['images', 'variants']);
    }

    public function getStatistics(): array
    {
        $query = $this->model;

        return [
            'total' => $query->count(),
            'active' => $query->active()->count(),
            'draft' => $query->draft()->count(),
            'archived' => $query->archived()->count(),
            'hidden' => $query->hidden()->count(),
            'featured' => $query->featured()->count(),
            'trending' => $query->trending()->count(),
            'best_sellers' => $query->bestSeller()->count(),
            'new_arrivals' => $query->newArrival()->count(),
            'in_stock' => $query->inStock()->count(),
            'low_stock' => $query->lowStock()->count(),
            'out_of_stock' => $query->outOfStock()->count(),
            'with_discount' => $query->withDiscount()->count(),
            'simple' => $query->simple()->count(),
            'variable' => $query->variable()->count(),
            'digital' => $query->digital()->count(),
        ];
    }
}
