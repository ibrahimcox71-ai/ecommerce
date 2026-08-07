<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoryRepository extends BaseRepository
{
    protected function model(): Category
    {
        return new Category;
    }

    public function paginateWithFilters(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return $this->applyFilters($filters)
            ->sorted()
            ->paginate($perPage);
    }

    public function trashedPaginate(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return Category::onlyTrashed()
            ->when($filters['search'] ?? null, fn($q, $v) => $q->search($v))
            ->orderBy('deleted_at', 'desc')
            ->paginate($perPage);
    }

    public function getTree(): Collection
    {
        return Category::with(['childrenRecursive'])
            ->parents()
            ->sorted()
            ->get();
    }

    public function getParentOptions(?int $excludeId = null): Collection
    {
        return Category::parents()
            ->active()
            ->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId))
            ->sorted()
            ->get();
    }

    public function bulkDelete(array $ids): array
    {
        $categories = Category::whereIn('id', $ids)->get();
        $deleted = 0;
        $skipped = [];

        foreach ($categories as $category) {
            if ($category->children()->exists() || $category->products()->exists()) {
                $skipped[] = $category->name;
                continue;
            }
            $category->delete();
            $deleted++;
        }

        return ['deleted' => $deleted, 'skipped' => $skipped];
    }

    public function bulkRestore(array $ids): int
    {
        return Category::onlyTrashed()
            ->whereIn('id', $ids)
            ->restore();
    }

    public function bulkForceDelete(array $ids): int
    {
        $count = 0;
        Category::onlyTrashed()->whereIn('id', $ids)->each(function ($category) use (&$count) {
            $category->forceDelete();
            $count++;
        });
        return $count;
    }

    public function bulkUpdateStatus(array $ids, string $status): int
    {
        return Category::whereIn('id', $ids)->update(['status' => $status]);
    }

    public function getChildCategories(int $parentId): Collection
    {
        return Category::where('parent_id', $parentId)->sorted()->get();
    }

    public function duplicate(int $id): ?Category
    {
        $original = Category::findOrFail($id);
        $copy = $original->replicate();
        $copy->name = $original->name . ' (Copy)';
        $copy->slug = $original->slug . '-copy-' . uniqid();
        $copy->status = 'draft';
        $copy->save();
        return $copy;
    }

    public function updateSortOrder(array $items): void
    {
        foreach ($items as $item) {
            Category::where('id', $item['id'])
                ->update([
                    'sort_order' => $item['sort_order'],
                    'parent_id' => $item['parent_id'] ?? null,
                ]);
        }
    }

    public function getStats(): array
    {
        return [
            'total' => Category::count(),
            'active' => Category::where('status', 'active')->count(),
            'inactive' => Category::where('status', 'inactive')->count(),
            'draft' => Category::where('status', 'draft')->count(),
            'hidden' => Category::where('status', 'hidden')->count(),
            'parents' => Category::whereNull('parent_id')->count(),
            'children' => Category::whereNotNull('parent_id')->count(),
            'featured' => Category::where('featured', true)->count(),
            'popular' => Category::where('popular', true)->count(),
            'trashed' => Category::onlyTrashed()->count(),
        ];
    }

    protected function applyFilters(array $filters): Builder
    {
        return Category::with(['parent', 'children'])
            ->withCount('products')
            ->when($filters['search'] ?? null, fn($q, $v) => $q->search($v))
            ->when($filters['status'] ?? null, fn($q, $v) => $q->status($v))
            ->when(isset($filters['parent']), function ($q) use ($filters) {
                $filters['parent'] === '0'
                    ? $q->whereNull('parent_id')
                    : $q->where('parent_id', $filters['parent']);
            })
            ->when(isset($filters['featured']), fn($q) => $q->where('featured', $filters['featured']))
            ->when($filters['date_from'] ?? null, fn($q, $v) => $q->whereDate('created_at', '>=', $v))
            ->when($filters['date_to'] ?? null, fn($q, $v) => $q->whereDate('created_at', '<=', $v));
    }
}
