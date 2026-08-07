<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function __construct(
        protected CategoryService $categoryService
    ) {}

    public function index(Request $request): View
    {
        $filters = $request->only(['search', 'status', 'parent', 'featured', 'date_from', 'date_to', 'per_page']);
        $categories = $this->categoryService->paginateWithFilters($filters);
        $parentCategories = $this->categoryService->getParentOptions();
        $stats = $this->categoryService->getStats();

        return view('admin.categories.index', compact('categories', 'parentCategories', 'stats'));
    }

    public function create(): View
    {
        $parentCategories = $this->categoryService->getParentOptions();
        return view('admin.categories.create', compact('parentCategories'));
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $this->categoryService->uploadImage($request->file('image'), 'image');
        }
        if ($request->hasFile('banner')) {
            $data['banner'] = $this->categoryService->uploadImage($request->file('banner'), 'banner');
        }
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $this->categoryService->uploadImage($request->file('thumbnail'), 'thumbnail');
        }
        if ($request->hasFile('seo_image')) {
            $data['seo_image'] = $this->categoryService->uploadImage($request->file('seo_image'), 'seo_image');
        }

        $category = $this->categoryService->createCategory($data);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', "Category '{$category->name}' created successfully!");
    }

    public function show(Category $category): View
    {
        $category->loadMissing(['parent', 'children', 'children.children', 'products' => function ($q) {
            $q->latest()->take(10);
        }]);

        return view('admin.categories.show', compact('category'));
    }

    public function edit(Category $category): View
    {
        $parentCategories = Category::parents()
            ->where('id', '!=', $category->id)
            ->active()
            ->sorted()
            ->get();

        return view('admin.categories.edit', compact('category', 'parentCategories'));
    }

    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $this->categoryService->deleteImage($category->image);
            $data['image'] = $this->categoryService->uploadImage($request->file('image'), 'image');
        } elseif ($request->boolean('remove_image')) {
            $this->categoryService->deleteImage($category->image);
            $data['image'] = null;
        }

        if ($request->hasFile('banner')) {
            $this->categoryService->deleteImage($category->banner);
            $data['banner'] = $this->categoryService->uploadImage($request->file('banner'), 'banner');
        } elseif ($request->boolean('remove_banner')) {
            $this->categoryService->deleteImage($category->banner);
            $data['banner'] = null;
        }

        if ($request->hasFile('thumbnail')) {
            $this->categoryService->deleteImage($category->thumbnail);
            $data['thumbnail'] = $this->categoryService->uploadImage($request->file('thumbnail'), 'thumbnail');
        } elseif ($request->boolean('remove_thumbnail')) {
            $this->categoryService->deleteImage($category->thumbnail);
            $data['thumbnail'] = null;
        }

        if ($request->hasFile('seo_image')) {
            $this->categoryService->deleteImage($category->seo_image);
            $data['seo_image'] = $this->categoryService->uploadImage($request->file('seo_image'), 'seo_image');
        } elseif ($request->boolean('remove_seo_image')) {
            $this->categoryService->deleteImage($category->seo_image);
            $data['seo_image'] = null;
        }

        $category = $this->categoryService->updateCategory($category->id, $data);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', "Category '{$category->name}' updated successfully!");
    }

    public function destroy(Category $category): RedirectResponse
    {
        if ($category->children()->exists()) {
            return redirect()
                ->route('admin.categories.index')
                ->with('error', 'Cannot delete category with subcategories. Please move or delete subcategories first.');
        }

        if ($category->products()->exists()) {
            return redirect()
                ->route('admin.categories.index')
                ->with('error', 'Cannot delete category with products. Please move products to another category first.');
        }

        $name = $category->name;
        $this->categoryService->deleteImage($category->image);
        $this->categoryService->deleteImage($category->banner);
        $this->categoryService->deleteImage($category->thumbnail);
        $this->categoryService->deleteImage($category->seo_image);
        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', "Category '{$name}' deleted successfully!");
    }

    public function bulkDelete(Request $request): RedirectResponse
    {
        $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['required', 'integer', 'exists:categories,id'],
        ]);

        $result = $this->categoryService->bulkDelete($request->ids);
        $deleted = $result['deleted'];
        $skipped = $result['skipped'];

        $message = "{$deleted} categories deleted successfully!";
        if (!empty($skipped)) {
            $message .= ' Skipped: ' . implode(', ', $skipped) . ' (have subcategories or products).';
        }

        return redirect()
            ->route('admin.categories.index')
            ->with($deleted > 0 ? 'success' : 'error', $message);
    }

    public function trashed(Request $request): View
    {
        $filters = $request->only(['search', 'per_page']);
        $categories = $this->categoryService->trashedPaginate($filters);

        return view('admin.categories.trashed', compact('categories'));
    }

    public function restore(int $id): RedirectResponse
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();

        return redirect()
            ->route('admin.categories.trashed')
            ->with('success', "Category '{$category->name}' restored successfully!");
    }

    public function forceDelete(int $id): RedirectResponse
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $name = $category->name;

        $this->categoryService->deleteImage($category->image);
        $this->categoryService->deleteImage($category->banner);
        $this->categoryService->deleteImage($category->thumbnail);
        $this->categoryService->deleteImage($category->seo_image);
        $category->forceDelete();

        return redirect()
            ->route('admin.categories.trashed')
            ->with('success', "Category '{$name}' permanently deleted!");
    }

    public function bulkRestore(Request $request): RedirectResponse
    {
        $request->validate([
            'ids' => ['required', 'array', 'min:1'],
        ]);

        $validIds = Category::onlyTrashed()->whereIn('id', $request->ids)->pluck('id')->toArray();
        $invalidIds = array_diff($request->ids, $validIds);

        if (!empty($invalidIds)) {
            throw ValidationException::withMessages([
                'ids' => 'Invalid trashed category IDs: ' . implode(', ', $invalidIds),
            ]);
        }

        $restored = $this->categoryService->bulkRestore($request->ids);

        return redirect()
            ->route('admin.categories.trashed')
            ->with('success', "{$restored} categories restored successfully!");
    }

    public function updateSort(Request $request): JsonResponse
    {
        $request->validate([
            'items' => ['required', 'array'],
            'items.*.id' => ['required', 'integer', 'exists:categories,id'],
            'items.*.sort_order' => ['required', 'integer', 'min:0'],
            'items.*.parent_id' => ['nullable', 'integer', 'exists:categories,id'],
        ]);

        $this->categoryService->updateSortOrder($request->items);

        return response()->json(['success' => true, 'message' => 'Sort order updated successfully!']);
    }

    public function toggleStatus(Category $category): JsonResponse
    {
        $newStatus = $category->status === 'active' ? 'inactive' : 'active';
        $category->update(['status' => $newStatus]);

        return response()->json([
            'success' => true,
            'status' => $newStatus,
            'message' => $newStatus === 'active' ? 'Category activated!' : 'Category deactivated!',
        ]);
    }

    public function removeImage(Category $category): RedirectResponse
    {
        $type = request('type', 'image');

        $column = match ($type) {
            'banner' => 'banner',
            'thumbnail' => 'thumbnail',
            'seo_image' => 'seo_image',
            default => 'image',
        };

        $this->categoryService->deleteImage($category->{$column});
        $category->update([$column => null]);

        return redirect()
            ->back()
            ->with('success', ucfirst(str_replace('_', ' ', $column)) . ' removed successfully!');
    }

    public function dataTable(Request $request): JsonResponse
    {
        $query = Category::with(['parent', 'children'])->withCount('products');

        if ($request->filled('search')) {
            $query->search($request->search);
        }
        if ($request->filled('status')) {
            $query->status($request->status);
        }

        $total = $query->count();
        $sortColumn = $request->get('sort_column', 'sort_order');
        $sortDirection = $request->get('sort_direction', 'asc');
        $query->orderBy($sortColumn, $sortDirection);

        $perPage = $request->get('per_page', 15);
        $categories = $query->paginate($perPage);

        return response()->json([
            'draw' => $request->get('draw'),
            'recordsTotal' => $total,
            'recordsFiltered' => $categories->total(),
            'data' => $categories->items(),
            'current_page' => $categories->currentPage(),
            'last_page' => $categories->lastPage(),
            'from' => $categories->firstItem(),
            'to' => $categories->lastItem(),
        ]);
    }

    public function duplicate(Category $category): RedirectResponse
    {
        $copy = $this->categoryService->duplicate($category->id);

        return redirect()
            ->route('admin.categories.edit', $copy->id)
            ->with('success', "Category '{$category->name}' duplicated successfully!");
    }

    public function tree(): View
    {
        $tree = Category::getTree();
        return view('admin.categories.tree', compact('tree'));
    }

    public function bulkUpdateStatus(Request $request): RedirectResponse
    {
        $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['required', 'integer', 'exists:categories,id'],
            'status' => ['required', 'string', 'in:active,inactive,draft,hidden'],
        ]);

        $updated = $this->categoryService->bulkUpdateStatus($request->ids, $request->status);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', "{$updated} categories status updated to '{$request->status}'!");
    }

    public function bulkForceDelete(Request $request): RedirectResponse
    {
        $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['required', 'integer', 'exists:categories,id'],
        ]);

        $deleted = $this->categoryService->bulkForceDelete($request->ids);

        return redirect()
            ->route('admin.categories.trashed')
            ->with('success', "{$deleted} categories permanently deleted!");
    }

    public function checkDeletable(Category $category): JsonResponse
    {
        $result = $this->categoryService->checkDeletable($category->id);

        return response()->json($result);
    }

    public function getChildren(Category $category): JsonResponse
    {
        $children = $this->categoryService->getChildCategories($category->id);

        return response()->json([
            'success' => true,
            'data' => $children->map(fn($child) => [
                'id' => $child->id,
                'name' => $child->name,
                'slug' => $child->slug,
                'status' => $child->status,
                'product_count' => $child->products()->count(),
                'children_count' => $child->children()->count(),
            ]),
        ]);
    }

    public function stats(): JsonResponse
    {
        return response()->json($this->categoryService->getStats());
    }

    public function searchSuggestions(Request $request): JsonResponse
    {
        $request->validate(['q' => 'required|string|min:2']);

        $categories = Category::search($request->q)
            ->active()
            ->withCount('products')
            ->take(10)
            ->get()
            ->map(fn($cat) => [
                'id' => $cat->id,
                'name' => $cat->name,
                'slug' => $cat->slug,
                'product_count' => $cat->products_count,
                'parent' => $cat->parent?->name,
            ]);

        return response()->json($categories);
    }

    public function moveProducts(Request $request, Category $category): RedirectResponse
    {
        $request->validate([
            'target_category_id' => ['required', 'integer', 'exists:categories,id'],
        ]);

        $target = Category::findOrFail($request->target_category_id);
        $this->categoryService->moveProducts($category->id, $target->id);

        return redirect()
            ->route('admin.categories.edit', $category->id)
            ->with('success', "Products moved to '{$target->name}' successfully!");
    }
}
