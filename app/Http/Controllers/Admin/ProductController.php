<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ProductStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\BulkEditRequest;
use App\Http\Requests\Product\QuickEditRequest;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\Warehouse;
use App\Services\ExportService;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct(
        protected ProductService $productService,
        protected ExportService $exportService
    ) {}

    public function index(Request $request): View
    {
        $filters = $request->only(['search', 'status', 'category_id', 'brand_id', 'product_type', 'featured', 'trending', 'best_seller', 'in_stock', 'low_stock', 'out_of_stock', 'with_discount', 'date_from', 'date_to']);
        $perPage = $request->get('per_page', 15);

        $products = Product::with(['category', 'brand', 'images', 'variants'])
            ->when($request->filled('search'), fn($q) => $q->search($request->search))
            ->when($request->filled('status'), function ($q) use ($request) {
                match ($request->status) {
                    'active' => $q->active(),
                    'draft' => $q->draft(),
                    'archived' => $q->archived(),
                    'hidden' => $q->hidden(),
                    default => $q->where('status', $request->status),
                };
            })
            ->when($request->filled('category_id'), fn($q) => $q->where('category_id', $request->category_id))
            ->when($request->filled('brand_id'), fn($q) => $q->where('brand_id', $request->brand_id))
            ->when($request->filled('product_type'), fn($q) => $q->where('product_type', $request->product_type))
            ->when($request->boolean('featured'), fn($q) => $q->featured())
            ->when($request->boolean('trending'), fn($q) => $q->trending())
            ->when($request->boolean('best_seller'), fn($q) => $q->bestSeller())
            ->when($request->boolean('in_stock'), fn($q) => $q->inStock())
            ->when($request->boolean('low_stock'), fn($q) => $q->lowStock())
            ->when($request->boolean('out_of_stock'), fn($q) => $q->outOfStock())
            ->when($request->boolean('with_discount'), fn($q) => $q->withDiscount())
            ->when($request->filled('date_from'), fn($q) => $q->whereDate('created_at', '>=', $request->date_from))
            ->when($request->filled('date_to'), fn($q) => $q->whereDate('created_at', '<=', $request->date_to))
            ->sorted()
            ->paginate($perPage)
            ->withQueryString();

        return view('admin.products.index', [
            'products' => $products,
            'categories' => Category::active()->parents()->with('children')->get(),
            'brands' => Brand::active()->get(),
            'statuses' => ProductStatus::cases(),
            'filters' => $filters,
            'statistics' => $this->productService->getStatistics(),
        ]);
    }

    public function create(): View
    {
        return view('admin.products.create', [
            'categories' => Category::active()->parents()->with('children')->get(),
            'brands' => Brand::active()->get(),
            'warehouses' => Warehouse::active()->get(),
            'attributes' => Attribute::active()->filterable()->with('values')->get(),
        ]);
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $this->uploadImage($request->file('thumbnail'));
        }

        if ($request->hasFile('og_image')) {
            $data['og_image'] = $this->uploadImage($request->file('og_image'));
        }

        if ($request->hasFile('gallery')) {
            $data['images'] = $this->processGalleryImages($request->file('gallery'), $request->input('is_primary', []));
        }

        if (!empty($data['variants'])) {
            $data['variants'] = $this->processVariants($data['variants']);
        }

        $product = $this->productService->create($data);

        $redirect = $request->boolean('continue_editing')
            ? route('admin.products.edit', $product->id)
            : route('admin.products.index');

        return redirect($redirect)
            ->with('success', "Product '{$product->name}' created successfully!");
    }

    public function show(Product $product): View
    {
        $product->load([
            'category',
            'subCategory',
            'childCategory',
            'brand',
            'images',
            'variants.attributeValues.attribute',
            'variants.attributeValues.attributeValue',
            'inventories.warehouse',
            'warehouses',
            'reviews',
        ]);

        $stockHistory = $this->productService->getStockHistory($product->id);

        return view('admin.products.show', [
            'product' => $product,
            'stockHistory' => $stockHistory,
            'activityLogs' => $product->activityLogs()
                ->with('causer')
                ->latest()
                ->paginate(20),
        ]);
    }

    public function edit(Product $product): View
    {
        $product->load([
            'category',
            'subCategory',
            'childCategory',
            'brand',
            'images',
            'variants.attributeValues',
            'warehouses',
        ]);

        return view('admin.products.edit', [
            'product' => $product,
            'categories' => Category::active()->parents()->with('children')->get(),
            'brands' => Brand::active()->get(),
            'warehouses' => Warehouse::active()->get(),
            'attributes' => Attribute::active()->filterable()->with('values')->get(),
        ]);
    }

    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('thumbnail')) {
            $this->deleteImage($product->thumbnail);
            $data['thumbnail'] = $this->uploadImage($request->file('thumbnail'));
        } elseif ($request->boolean('remove_thumbnail')) {
            $this->deleteImage($product->thumbnail);
            $data['thumbnail'] = null;
        }

        if ($request->hasFile('og_image')) {
            $this->deleteImage($product->og_image);
            $data['og_image'] = $this->uploadImage($request->file('og_image'));
        } elseif ($request->boolean('remove_og_image')) {
            $this->deleteImage($product->og_image);
            $data['og_image'] = null;
        }

        if ($request->hasFile('gallery')) {
            $data['images'] = $this->processGalleryImages($request->file('gallery'), $request->input('is_primary', []));
        } elseif ($request->has('images')) {
            $data['images'] = $request->input('images');
        }

        if (array_key_exists('variants', $data)) {
            $data['variants'] = $this->processVariants($data['variants']);
        }

        $product = $this->productService->update($product->id, $data);

        $redirect = $request->boolean('continue_editing')
            ? route('admin.products.edit', $product->id)
            : route('admin.products.index');

        return redirect($redirect)
            ->with('success', "Product '{$product->name}' updated successfully!");
    }

    public function destroy(Product $product): RedirectResponse
    {
        $name = $product->name;

        $this->deleteImage($product->thumbnail);
        $this->deleteImage($product->og_image);

        $this->productService->delete($product->id);

        return redirect()
            ->route('admin.products.index')
            ->with('success', "Product '{$name}' deleted successfully!");
    }

    public function trashed(Request $request): View
    {
        $products = Product::onlyTrashed()
            ->with(['category', 'brand', 'images'])
            ->when($request->filled('search'), fn($q) => $q->where(fn($q) => $q
                ->where('name', 'like', "%{$request->search}%")
                ->orWhere('sku', 'like', "%{$request->search}%")
            ))
            ->orderBy('deleted_at', 'desc')
            ->paginate($request->get('per_page', 15))
            ->withQueryString();

        return view('admin.products.trashed', [
            'products' => $products,
        ]);
    }

    public function restore(int $id): RedirectResponse
    {
        $product = $this->productService->restore($id);

        return redirect()
            ->route('admin.products.trashed')
            ->with('success', "Product '{$product->name}' restored successfully!");
    }

    public function forceDelete(int $id): RedirectResponse
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $name = $product->name;

        $this->deleteImage($product->thumbnail);
        $this->deleteImage($product->og_image);

        $this->productService->forceDelete($id);

        return redirect()
            ->route('admin.products.trashed')
            ->with('success', "Product '{$name}' permanently deleted!");
    }

    public function bulkRestore(Request $request): RedirectResponse
    {
        $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['required', 'integer', 'exists:products,id'],
        ]);

        $count = $this->productService->bulkRestore($request->ids);

        return redirect()
            ->route('admin.products.trashed')
            ->with('success', "{$count} products restored successfully!");
    }

    public function bulkDelete(Request $request): RedirectResponse
    {
        $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['required', 'integer', 'exists:products,id'],
        ]);

        Product::whereIn('id', $request->ids)->get()->each(function ($product) {
            $this->deleteImage($product->thumbnail);
        });

        $count = $this->productService->bulkDelete($request->ids);

        return redirect()
            ->route('admin.products.index')
            ->with('success', "{$count} products deleted successfully!");
    }

    public function bulkForceDelete(Request $request): RedirectResponse
    {
        $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['required', 'integer', 'exists:products,id'],
        ]);

        $count = $this->productService->bulkForceDelete($request->ids);

        return redirect()
            ->route('admin.products.trashed')
            ->with('success', "{$count} products permanently deleted!");
    }

    public function bulkUpdateStatus(Request $request): RedirectResponse
    {
        $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['required', 'integer', 'exists:products,id'],
            'status' => ['required', 'string', 'in:active,inactive,draft,archived,hidden'],
        ]);

        $statusMap = [
            'active' => ProductStatus::Active,
            'inactive' => ProductStatus::Inactive,
            'draft' => ProductStatus::Draft,
            'archived' => ProductStatus::Archived,
            'hidden' => ProductStatus::Hidden,
        ];

        $count = $this->productService->bulkUpdateStatus($request->ids, $statusMap[$request->status]->value);

        return redirect()
            ->route('admin.products.index')
            ->with('success', "{$count} products updated to '{$request->status}'!");
    }

    public function bulkEdit(BulkEditRequest $request): RedirectResponse
    {
        $fields = array_filter($request->validated('fields'), function ($value) {
            return $value !== null && $value !== '' && $value !== [];
        });

        if (empty($fields)) {
            return redirect()
                ->back()
                ->with('error', 'No fields to update.');
        }

        $count = $this->productService->bulkEdit($request->ids, $fields);

        return redirect()
            ->route('admin.products.index')
            ->with('success', "{$count} products updated successfully!");
    }

    public function quickEdit(Product $product): JsonResponse
    {
        $product->load(['category', 'brand']);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $product->id,
                'name' => $product->name,
                'sku' => $product->sku,
                'price' => $product->price,
                'cost_price' => $product->cost_price,
                'stock' => $product->stock,
                'status' => $product->status->value,
                'featured' => $product->featured,
                'trending' => $product->trending,
                'best_seller' => $product->best_seller,
                'category_id' => $product->category_id,
                'brand_id' => $product->brand_id,
                'category_name' => $product->category?->name,
                'brand_name' => $product->brand?->name,
                'thumbnail_url' => $product->thumbnail_url,
                'image_url' => $product->thumbnail_url,
            ]
        ]);
    }

    public function quickUpdate(QuickEditRequest $request, Product $product): JsonResponse
    {
        $data = $request->validated();

        $product->update($data);

        return response()->json([
            'success' => true,
            'message' => "Product '{$product->name}' updated!",
            'data' => [
                'price' => $product->fresh()->current_price,
                'stock' => $product->stock,
                'status' => $product->status->value,
                'status_label' => $product->status->label(),
                'featured' => $product->featured,
            ]
        ]);
    }

    public function duplicate(int $id): RedirectResponse
    {
        $newProduct = $this->productService->duplicate($id);

        if (!$newProduct) {
            return redirect()
                ->route('admin.products.index')
                ->with('error', 'Product not found!');
        }

        return redirect()
            ->route('admin.products.edit', $newProduct->id)
            ->with('success', "Product duplicated! Edit the new product below.");
    }

    public function toggleStatus(Product $product): JsonResponse
    {
        $product = $this->productService->toggleStatus($product->id);

        return response()->json([
            'success' => true,
            'status' => $product->status->value,
            'message' => $product->status->label() . '!',
        ]);
    }

    public function toggleFeatured(Product $product): JsonResponse
    {
        $product = $this->productService->toggleFeatured($product->id);

        return response()->json([
            'success' => true,
            'featured' => $product->featured,
            'message' => $product->featured ? 'Marked as featured!' : 'Removed from featured',
        ]);
    }

    public function toggleTrending(Product $product): JsonResponse
    {
        $product = $this->productService->toggleTrending($product->id);

        return response()->json([
            'success' => true,
            'trending' => $product->trending,
            'message' => $product->trending ? 'Marked as trending!' : 'Removed from trending',
        ]);
    }

    public function toggleBestSeller(Product $product): JsonResponse
    {
        $product = $this->productService->toggleBestSeller($product->id);

        return response()->json([
            'success' => true,
            'best_seller' => $product->best_seller,
            'message' => $product->best_seller ? 'Marked as best seller!' : 'Removed from best sellers',
        ]);
    }

    public function toggleNewArrival(Product $product): JsonResponse
    {
        $product = $this->productService->toggleNewArrival($product->id);

        return response()->json([
            'success' => true,
            'is_new_arrival' => $product->is_new_arrival,
            'message' => $product->is_new_arrival ? 'Marked as new arrival!' : 'Removed from new arrivals',
        ]);
    }

    public function updateSort(Request $request): JsonResponse
    {
        $request->validate([
            'items' => ['required', 'array'],
            'items.*.id' => ['required', 'integer', 'exists:products,id'],
            'items.*.sort_order' => ['required', 'integer', 'min:0'],
        ]);

        $this->productService->updateSortOrder($request->items);

        return response()->json(['success' => true, 'message' => 'Sort order updated!']);
    }

    public function dataTable(Request $request): JsonResponse
    {
        $result = app(\App\Repositories\ProductRepository::class)->dataTable($request->all());

        return response()->json($result);
    }

    public function getSubCategories(int $categoryId): JsonResponse
    {
        $subCategories = SubCategory::where('category_id', $categoryId)
            ->active()
            ->sorted()
            ->get(['id', 'name', 'slug']);

        return response()->json([
            'success' => true,
            'data' => $subCategories,
        ]);
    }

    public function removeImage(Product $product, int $imageId): RedirectResponse
    {
        $image = $product->images()->findOrFail($imageId);
        $this->deleteImage($image->image);
        $image->delete();

        return redirect()
            ->back()
            ->with('success', 'Image removed successfully!');
    }

    public function setPrimaryImage(Product $product, int $imageId): JsonResponse
    {
        $product->images()->update(['is_primary' => false]);
        $product->images()->where('id', $imageId)->update(['is_primary' => true]);

        $primaryImage = $product->images()->primary()->first();
        if ($primaryImage) {
            $product->update(['thumbnail' => $primaryImage->image]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Primary image set!',
        ]);
    }

    public function exportCsv(Request $request)
    {
        $filters = $request->only(['status', 'category_id', 'brand_id', 'product_type', 'search', 'date_from', 'date_to']);

        return $this->exportService->exportCsv($filters);
    }

    public function exportExcel(Request $request)
    {
        $filters = $request->only(['status', 'category_id', 'brand_id', 'product_type', 'search', 'date_from', 'date_to']);

        return $this->exportService->exportExcel($filters);
    }

    public function searchSuggestions(Request $request): JsonResponse
    {
        $term = $request->get('q', '');

        if (strlen($term) < 2) {
            return response()->json(['success' => true, 'data' => []]);
        }

        $products = $this->productService->searchSuggestions($term);

        return response()->json([
            'success' => true,
            'data' => $products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'sku' => $product->sku,
                    'price' => $product->price,
                    'stock' => $product->stock,
                    'image' => $product->thumbnail_url,
                ];
            }),
        ]);
    }

    private function uploadImage($file): string
    {
        $path = 'products/' . date('Y/m');
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();

        Storage::disk('public')->putFileAs($path, $file, $filename);

        return $path . '/' . $filename;
    }

    private function deleteImage(?string $image): void
    {
        if ($image && Storage::disk('public')->exists($image)) {
            Storage::disk('public')->delete($image);
        }
    }

    private function processGalleryImages($files, array $isPrimary = []): array
    {
        $images = [];
        $primarySet = false;
        $sortOrder = 0;

        foreach ($files as $index => $file) {
            if ($file instanceof \Illuminate\Http\UploadedFile) {
                $path = $this->uploadImage($file);
                $isPrimaryImage = !$primarySet && in_array($index, $isPrimary);

                if ($isPrimaryImage) {
                    $primarySet = true;
                }

                $images[] = [
                    'image' => $path,
                    'is_primary' => $isPrimaryImage,
                    'sort_order' => $sortOrder++,
                ];
            }
        }

        return $images;
    }

    private function processVariants(array $variants): array
    {
        return collect($variants)->map(function ($variant) {
            $processed = [
                'name' => $variant['name'] ?? '',
                'sku' => $variant['sku'] ?? '',
                'barcode' => $variant['barcode'] ?? null,
                'price' => $variant['price'] ?? null,
                'discount' => $variant['discount'] ?? null,
                'cost_price' => $variant['cost_price'] ?? null,
                'stock' => $variant['stock'] ?? 0,
                'unlimited_stock' => !empty($variant['unlimited_stock']),
                'status' => !empty($variant['status']),
                'weight' => $variant['weight'] ?? null,
                'sort_order' => $variant['sort_order'] ?? 0,
            ];

            if (!empty($variant['image_file'])) {
                $processed['image'] = $this->uploadImage($variant['image_file']);
            } elseif (!empty($variant['image'])) {
                $processed['image'] = $variant['image'];
            }

            if (!empty($variant['attribute_values'])) {
                $processed['attribute_values'] = $variant['attribute_values'];
            }

            return $processed;
        })->toArray();
    }
}
