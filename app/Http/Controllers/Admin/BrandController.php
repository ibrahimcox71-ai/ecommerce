<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Brand\BulkUpdateStatusRequest;
use App\Http\Requests\Brand\StoreBrandRequest;
use App\Http\Requests\Brand\UpdateBrandRequest;
use App\Models\Brand;
use App\Services\BrandService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class BrandController extends Controller
{
    public function __construct(
        protected BrandService $brandService
    ) {}

    public function index(Request $request): View
    {
        $filters = $request->only(['search', 'status', 'featured', 'popular', 'country', 'date_from', 'date_to', 'per_page']);
        $brands = $this->brandService->paginateWithFilters($filters);
        $stats = $this->brandService->getStats();

        return view('admin.brands.index', compact('brands', 'stats'));
    }

    public function create(): View
    {
        return view('admin.brands.create');
    }

    public function store(StoreBrandRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $this->brandService->uploadImage($request->file('image'), 'image');
        }
        if ($request->hasFile('logo')) {
            $data['logo'] = $this->brandService->uploadImage($request->file('logo'), 'logo');
        }
        if ($request->hasFile('banner')) {
            $data['banner'] = $this->brandService->uploadImage($request->file('banner'), 'banner');
        }
        if ($request->hasFile('og_image')) {
            $data['og_image'] = $this->brandService->uploadImage($request->file('og_image'), 'og_image');
        }

        $brand = $this->brandService->createBrand($data);

        return redirect()
            ->route('admin.brands.index')
            ->with('success', "Brand '{$brand->name}' created successfully!");
    }

    public function show(Brand $brand): View
    {
        $brand->loadCount(['products', 'products as active_products_count' => fn($q) => $q->where('status', 'active')]);
        $brand->load('activityLogs.causer');

        return view('admin.brands.show', compact('brand'));
    }

    public function edit(Brand $brand): View
    {
        $brand->loadCount('products');
        return view('admin.brands.edit', compact('brand'));
    }

    public function update(UpdateBrandRequest $request, Brand $brand): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $this->brandService->deleteImage($brand->image);
            $data['image'] = $this->brandService->uploadImage($request->file('image'), 'image');
        } elseif ($request->boolean('remove_image')) {
            $this->brandService->deleteImage($brand->image);
            $data['image'] = null;
        }
        unset($data['remove_image']);

        if ($request->hasFile('logo')) {
            $this->brandService->deleteImage($brand->logo);
            $data['logo'] = $this->brandService->uploadImage($request->file('logo'), 'logo');
        } elseif ($request->boolean('remove_logo')) {
            $this->brandService->deleteImage($brand->logo);
            $data['logo'] = null;
        }
        unset($data['remove_logo']);

        if ($request->hasFile('banner')) {
            $this->brandService->deleteImage($brand->banner);
            $data['banner'] = $this->brandService->uploadImage($request->file('banner'), 'banner');
        } elseif ($request->boolean('remove_banner')) {
            $this->brandService->deleteImage($brand->banner);
            $data['banner'] = null;
        }
        unset($data['remove_banner']);

        if ($request->hasFile('og_image')) {
            $this->brandService->deleteImage($brand->og_image);
            $data['og_image'] = $this->brandService->uploadImage($request->file('og_image'), 'og_image');
        } elseif ($request->boolean('remove_og_image')) {
            $this->brandService->deleteImage($brand->og_image);
            $data['og_image'] = null;
        }
        unset($data['remove_og_image']);

        $brand = $this->brandService->updateBrand($brand->id, $data);

        return redirect()
            ->route('admin.brands.index')
            ->with('success', "Brand '{$brand->name}' updated successfully!");
    }

    public function destroy(Brand $brand): RedirectResponse
    {
        if ($brand->products()->exists()) {
            return redirect()
                ->route('admin.brands.index')
                ->with('error', 'Cannot delete brand with products. Please remove products first.');
        }

        $name = $brand->name;
        $this->brandService->deleteImage($brand->image);
        $this->brandService->deleteImage($brand->logo);
        $this->brandService->deleteImage($brand->banner);
        $this->brandService->deleteImage($brand->og_image);
        $brand->delete();

        return redirect()
            ->route('admin.brands.index')
            ->with('success', "Brand '{$name}' deleted successfully!");
    }

    public function bulkDelete(Request $request): RedirectResponse
    {
        $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['required', 'integer', 'exists:brands,id'],
        ]);

        $result = $this->brandService->bulkDelete($request->ids);
        $deleted = $result['deleted'];
        $skipped = $result['skipped'];

        $message = "{$deleted} brands deleted successfully!";
        if (!empty($skipped)) {
            $message .= ' Skipped: ' . implode(', ', $skipped) . ' (have products).';
        }

        return redirect()
            ->route('admin.brands.index')
            ->with($deleted > 0 ? 'success' : 'error', $message);
    }

    public function trashed(Request $request): View
    {
        $filters = $request->only(['search', 'per_page']);
        $brands = $this->brandService->trashedPaginate($filters);

        return view('admin.brands.trashed', compact('brands'));
    }

    public function restore(int $id): RedirectResponse
    {
        $brand = Brand::onlyTrashed()->findOrFail($id);
        $brand->restore();

        return redirect()
            ->route('admin.brands.trashed')
            ->with('success', "Brand '{$brand->name}' restored successfully!");
    }

    public function forceDelete(int $id): RedirectResponse
    {
        $brand = Brand::onlyTrashed()->findOrFail($id);
        $name = $brand->name;

        $this->brandService->deleteImage($brand->image);
        $this->brandService->deleteImage($brand->logo);
        $this->brandService->deleteImage($brand->banner);
        $this->brandService->deleteImage($brand->og_image);
        $brand->forceDelete();

        return redirect()
            ->route('admin.brands.trashed')
            ->with('success', "Brand '{$name}' permanently deleted!");
    }

    public function bulkRestore(Request $request): RedirectResponse
    {
        $request->validate([
            'ids' => ['required', 'array', 'min:1'],
        ]);

        $validIds = Brand::onlyTrashed()->whereIn('id', $request->ids)->pluck('id')->toArray();
        $invalidIds = array_diff($request->ids, $validIds);

        if (!empty($invalidIds)) {
            throw ValidationException::withMessages([
                'ids' => 'The following IDs are not valid trashed brands: ' . implode(', ', $invalidIds),
            ]);
        }

        $restored = $this->brandService->bulkRestore($request->ids);

        return redirect()
            ->route('admin.brands.trashed')
            ->with('success', "{$restored} brands restored successfully!");
    }

    public function bulkUpdateStatus(BulkUpdateStatusRequest $request): RedirectResponse
    {
        $updated = $this->brandService->bulkUpdateStatus($request->ids, $request->status);

        return redirect()
            ->route('admin.brands.index')
            ->with('success', "{$updated} brands status updated to '{$request->status}'!");
    }

    public function bulkForceDelete(Request $request): RedirectResponse
    {
        $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['required', 'integer', 'exists:brands,id'],
        ]);

        $deleted = $this->brandService->bulkForceDelete($request->ids);

        return redirect()
            ->route('admin.brands.trashed')
            ->with('success', "{$deleted} brands permanently deleted!");
    }

    public function updateSort(Request $request): JsonResponse
    {
        $request->validate([
            'items' => ['required', 'array'],
            'items.*.id' => ['required', 'integer', 'exists:brands,id'],
            'items.*.sort_order' => ['required', 'integer', 'min:0'],
        ]);

        foreach ($request->items as $item) {
            Brand::where('id', $item['id'])->update(['sort_order' => $item['sort_order']]);
        }

        return response()->json(['success' => true, 'message' => 'Sort order updated successfully!']);
    }

    public function toggleStatus(Brand $brand): JsonResponse
    {
        $newStatus = $brand->status === 'active' ? 'inactive' : 'active';
        $brand->update(['status' => $newStatus]);

        return response()->json([
            'success' => true,
            'status' => $newStatus,
            'message' => $newStatus === 'active' ? 'Brand activated!' : 'Brand deactivated!',
        ]);
    }

    public function toggleFeatured(Brand $brand): JsonResponse
    {
        $brand->update(['featured' => !$brand->featured]);

        return response()->json([
            'success' => true,
            'featured' => $brand->featured,
            'message' => $brand->featured ? 'Brand marked as featured!' : 'Brand unmarked as featured!',
        ]);
    }

    public function togglePopular(Brand $brand): JsonResponse
    {
        $brand->update(['popular' => !$brand->popular]);

        return response()->json([
            'success' => true,
            'popular' => $brand->popular,
            'message' => $brand->popular ? 'Brand marked as popular!' : 'Brand unmarked as popular!',
        ]);
    }

    public function removeImage(Brand $brand): RedirectResponse
    {
        $type = request('type', 'image');

        $column = match ($type) {
            'logo' => 'logo',
            'banner' => 'banner',
            'og_image' => 'og_image',
            default => 'image',
        };

        $this->brandService->deleteImage($brand->{$column});
        $brand->update([$column => null]);

        return redirect()
            ->back()
            ->with('success', ucfirst(str_replace('_', ' ', $column)) . ' removed successfully!');
    }

    public function dataTable(Request $request): JsonResponse
    {
        $query = Brand::withCount([
            'products',
            'products as active_products_count' => fn($q) => $q->where('status', 'active'),
            'products as out_of_stock_products_count' => fn($q) => $q->where('stock', '<=', 0),
        ]);

        if ($request->filled('search')) {
            $query->search($request->search);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('featured')) {
            $query->where('featured', $request->featured === '1');
        }
        if ($request->filled('country')) {
            $query->where('country', $request->country);
        }

        $total = $query->count();

        $sortColumn = $request->get('sort_column', 'sort_order');
        $sortDirection = $request->get('sort_direction', 'asc');
        $query->orderBy($sortColumn, $sortDirection);

        $perPage = $request->get('per_page', 15);
        $brands = $query->paginate($perPage);

        return response()->json([
            'draw' => $request->get('draw'),
            'recordsTotal' => $total,
            'recordsFiltered' => $brands->total(),
            'data' => $brands->items(),
            'current_page' => $brands->currentPage(),
            'last_page' => $brands->lastPage(),
            'from' => $brands->firstItem(),
            'to' => $brands->lastItem(),
        ]);
    }

    public function duplicate(Brand $brand): RedirectResponse
    {
        $copy = $this->brandService->duplicate($brand->id);

        return redirect()
            ->route('admin.brands.edit', $copy->id)
            ->with('success', "Brand '{$brand->name}' duplicated successfully!");
    }

    public function checkDeletable(Brand $brand): JsonResponse
    {
        return response()->json($this->brandService->checkDeletable($brand->id));
    }

    public function stats(): JsonResponse
    {
        return response()->json($this->brandService->getStats());
    }

    public function searchSuggestions(Request $request): JsonResponse
    {
        $request->validate(['q' => 'required|string|min:2']);

        return response()->json($this->brandService->searchSuggestions($request->q));
    }
}
