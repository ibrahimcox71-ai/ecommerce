<?php

namespace App\Services;

use App\Enums\ProductStatus;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\Inventory;
use App\Models\InventoryLog;
use App\Models\Warehouse;
use App\Repositories\ProductRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class ProductService extends BaseService
{
    protected string $repositoryClass = ProductRepository::class;

    public function create(array $data): Model
    {
        return DB::transaction(function () use ($data) {
            if (!empty($data['thumbnail']) && empty($data['images'])) {
                $data['images'] = [
                    [
                        'image' => $data['thumbnail'],
                        'is_primary' => true,
                        'sort_order' => 0,
                    ]
                ];
            }

            $images = $data['images'] ?? [];
            $variants = $data['variants'] ?? [];
            $warehouses = $data['warehouses'] ?? [];
            $specifications = $data['specifications'] ?? [];

            unset($data['images'], $data['variants'], $data['warehouses'], $data['specifications']);

            if (empty($data['slug'])) {
                $data['slug'] = Str::slug($data['name']);
            }

            if (empty($data['sku'])) {
                $data['sku'] = $this->generateSku($data['name']);
            }

            if (($data['status'] ?? '') === 'active' && empty($data['published_at'])) {
                $data['published_at'] = now();
            }

            $product = Product::create($data);

            $this->syncImages($product, $images);
            $this->syncVariants($product, $variants);
            $this->syncWarehouses($product, $warehouses);

            if (!empty($variants)) {
                $totalVariantStock = collect($variants)->sum('stock');
                if ($totalVariantStock > 0) {
                    $product->update(['stock' => $totalVariantStock]);
                }
            }

            $this->initializeInventory($product);

            return $product->load(['images', 'variants', 'inventories', 'warehouses']);
        });
    }

    public function update(int $id, array $data): Model
    {
        return DB::transaction(function () use ($id, $data) {
            $product = Product::findOrFail($id);

            if (array_key_exists('images', $data)) {
                $this->syncImages($product, $data['images']);
                unset($data['images']);
            }

            if (array_key_exists('variants', $data)) {
                $this->syncVariants($product, $data['variants']);
                unset($data['variants']);
            }

            if (array_key_exists('warehouses', $data)) {
                $this->syncWarehouses($product, $data['warehouses']);
                unset($data['warehouses']);
            }

            if (isset($data['name']) && !isset($data['slug'])) {
                $data['slug'] = Str::slug($data['name']);
            }

            if (isset($data['status']) && $data['status'] === 'active') {
                if (!$product->published_at) {
                    $data['published_at'] = now();
                }
            }

            if (isset($data['specifications']) && empty($data['specifications'])) {
                unset($data['specifications']);
            }

            $product->update($data);

            return $product->fresh(['images', 'variants', 'inventories', 'warehouses']);
        });
    }

    public function syncImages(Product $product, array $images): void
    {
        $existingIds = $product->images()->pluck('id')->toArray();
        $newIds = collect($images)->where('id', '!=', 0)->pluck('id')->toArray();

        $toDelete = array_diff($existingIds, $newIds);
        foreach ($toDelete as $imageId) {
            $image = ProductImage::find($imageId);
            if ($image) {
                $this->deleteImageFile($image->image);
                $image->delete();
            }
        }

        $hasPrimary = false;
        $sortOrder = 0;

        foreach ($images as $imageData) {
            $imageData['product_id'] = $product->id;
            $imageData['sort_order'] = $imageData['sort_order'] ?? $sortOrder++;

            if (!empty($imageData['is_primary'])) {
                $hasPrimary = true;
            }

            if (!empty($imageData['id']) && $imageData['id'] > 0) {
                $image = ProductImage::find($imageData['id']);
                if ($image) {
                    $image->update(Arr::only($imageData, ['image', 'alt_text', 'title', 'sort_order', 'is_primary']));
                }
            } else {
                ProductImage::create(Arr::only($imageData, ['product_id', 'image', 'alt_text', 'title', 'sort_order', 'is_primary']));
            }
        }

        if (!$hasPrimary && $product->images()->count() > 0) {
            $product->images()->first()->update(['is_primary' => true]);
        }

        $primaryImage = $product->images()->primary()->first();
        if ($primaryImage && $product->thumbnail !== $primaryImage->image) {
            $product->update(['thumbnail' => $primaryImage->image]);
        }
    }

    public function syncVariants(Product $product, array $variants): void
    {
        $existingIds = $product->variants()->pluck('id')->toArray();
        $newIds = collect($variants)->where('id', '!=', 0)->pluck('id')->toArray();

        $toDelete = array_diff($existingIds, $newIds);
        foreach ($toDelete as $variantId) {
            ProductVariant::find($variantId)?->delete();
        }

        foreach ($variants as $variantData) {
            $variantData['product_id'] = $product->id;

            if (!empty($variantData['id']) && $variantData['id'] > 0) {
                $variant = ProductVariant::find($variantData['id']);
                if ($variant) {
                    if (isset($variantData['attribute_values'])) {
                        $variant->attributeValues()->sync($variantData['attribute_values']);
                        unset($variantData['attribute_values']);
                    }

                    $variant->update(Arr::only($variantData, [
                        'name', 'sku', 'barcode', 'price', 'discount',
                        'cost_price', 'stock', 'unlimited_stock',
                        'image', 'status', 'weight', 'sort_order'
                    ]));
                }
            } else {
                $variant = ProductVariant::create(Arr::only($variantData, [
                    'product_id', 'name', 'sku', 'barcode', 'price', 'discount',
                    'cost_price', 'stock', 'unlimited_stock', 'image',
                    'status', 'weight', 'sort_order'
                ]));

                if (!empty($variantData['attribute_values'])) {
                    $variant->attributeValues()->attach($variantData['attribute_values']);
                }
            }
        }
    }

    public function syncWarehouses(Product $product, array $warehouses): void
    {
        $syncData = [];

        foreach ($warehouses as $warehouseData) {
            if (isset($warehouseData['warehouse_id'])) {
                $syncData[$warehouseData['warehouse_id']] = [
                    'is_default' => $warehouseData['is_default'] ?? false,
                    'lead_time' => $warehouseData['lead_time'] ?? null,
                ];
            }
        }

        $product->warehouses()->sync($syncData);
    }

    public function initializeInventory(Product $product): void
    {
        $defaultWarehouse = Warehouse::getDefault();

        if (!$defaultWarehouse) {
            return;
        }

        $exists = Inventory::where('product_id', $product->id)
            ->whereNull('product_variant_id')
            ->where('warehouse_id', $defaultWarehouse->id)
            ->exists();

        if (!$exists) {
            Inventory::create([
                'product_id' => $product->id,
                'product_variant_id' => null,
                'warehouse_id' => $defaultWarehouse->id,
                'quantity' => $product->stock,
                'reserved_quantity' => 0,
                'low_stock_threshold' => $product->low_stock_threshold ?? 10,
            ]);
        }
    }

    public function delete(int $id): bool
    {
        $product = Product::findOrFail($id);

        foreach ($product->images as $image) {
            $this->deleteImageFile($image->image);
        }

        return $product->delete();
    }

    public function forceDelete(int $id): bool
    {
        $product = Product::withTrashed()->findOrFail($id);

        foreach ($product->images as $image) {
            $this->deleteImageFile($image->image);
        }

        foreach ($product->variants as $variant) {
            if ($variant->image) {
                $this->deleteImageFile($variant->image);
            }
        }

        return $product->forceDelete();
    }

    public function restore(int $id): Model
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();

        return $product->load(['images', 'variants', 'inventories']);
    }

    public function toggleStatus(int $id): Model
    {
        $product = Product::findOrFail($id);

        if ($product->status === ProductStatus::Active) {
            $product->update(['status' => ProductStatus::Inactive]);
        } else {
            $product->update(['status' => ProductStatus::Active, 'published_at' => now()]);
        }

        return $product->fresh();
    }

    public function toggleFeatured(int $id): Model
    {
        $product = Product::findOrFail($id);
        $product->update(['featured' => !$product->featured]);

        return $product->fresh();
    }

    public function toggleTrending(int $id): Model
    {
        $product = Product::findOrFail($id);
        $product->update(['trending' => !$product->trending]);

        return $product->fresh();
    }

    public function toggleBestSeller(int $id): Model
    {
        $product = Product::findOrFail($id);
        $product->update(['best_seller' => !$product->best_seller]);

        return $product->fresh();
    }

    public function toggleNewArrival(int $id): Model
    {
        $product = Product::findOrFail($id);
        $product->update(['is_new_arrival' => !$product->is_new_arrival]);

        return $product->fresh();
    }

    public function duplicate(int $id): ?Model
    {
        return $this->repository()->duplicate($id);
    }

    public function bulkUpdateStatus(array $ids, string $status): int
    {
        return $this->repository()->bulkUpdateStatus($ids, $status);
    }

    public function bulkDelete(array $ids): int
    {
        return $this->repository()->bulkDelete($ids);
    }

    public function bulkRestore(array $ids): int
    {
        return $this->repository()->bulkRestore($ids);
    }

    public function bulkForceDelete(array $ids): int
    {
        $products = Product::withTrashed()->whereIn('id', $ids)->get();

        foreach ($products as $product) {
            foreach ($product->images as $image) {
                $this->deleteImageFile($image->image);
            }
        }

        return $this->repository()->bulkForceDelete($ids);
    }

    public function bulkEdit(array $ids, array $fields): int
    {
        return $this->repository()->bulkEdit($ids, $fields);
    }

    public function updateSortOrder(array $items): void
    {
        $this->repository()->updateSortOrder($items);
    }

    public function getStatistics(): array
    {
        return $this->repository()->getStatistics();
    }

    public function getExportQuery(array $filters = [])
    {
        return $this->repository()->getExportQuery($filters);
    }

    public function getStockHistory(int $productId, int $limit = 50)
    {
        return InventoryLog::whereHas('inventory', function ($q) use ($productId) {
            $q->where('product_id', $productId);
        })
        ->orWhereHas('inventory.product', function ($q) use ($productId) {
            $q->where('id', $productId);
        })
        ->with(['inventory.warehouse', 'causer'])
        ->latest()
        ->limit($limit)
        ->get();
    }

    public function searchSuggestions(string $term): Collection
    {
        return Product::active()
            ->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                  ->orWhere('sku', 'like', "%{$term}%")
                  ->orWhere('barcode', 'like', "%{$term}%");
            })
            ->with(['category', 'primaryImage'])
            ->limit(10)
            ->get(['id', 'name', 'sku', 'price', 'stock', 'thumbnail']);
    }

    protected function generateSku(string $name): string
    {
        $prefix = strtoupper(substr(Str::slug($name), 0, 3));
        $random = strtoupper(Str::random(6));
        $timestamp = now()->format('ymd');

        $sku = "{$prefix}-{$timestamp}-{$random}";

        while (Product::withTrashed()->where('sku', $sku)->exists()) {
            $random = strtoupper(Str::random(6));
            $sku = "{$prefix}-{$timestamp}-{$random}";
        }

        return $sku;
    }

    protected function deleteImageFile(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
