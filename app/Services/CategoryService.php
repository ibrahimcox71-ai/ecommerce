<?php

namespace App\Services;

use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryService extends BaseService
{
    protected string $repositoryClass = CategoryRepository::class;

    public function paginateWithFilters(array $filters = []): LengthAwarePaginator
    {
        $perPage = $filters['per_page'] ?? config('ecommerce.pagination.admin_per_page', 20);
        return $this->repository()->paginateWithFilters($filters, $perPage);
    }

    public function trashedPaginate(array $filters = []): LengthAwarePaginator
    {
        $perPage = $filters['per_page'] ?? config('ecommerce.pagination.admin_per_page', 20);
        return $this->repository()->trashedPaginate($filters, $perPage);
    }

    public function createCategory(array $data): Category
    {
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        if (empty($data['status'])) {
            $data['status'] = 'active';
        }

        /** @var Category $category */
        $category = $this->repository()->create($data);

        if (!empty($data['meta_title']) || !empty($data['canonical_url'])) {
            $category->syncJsonLd()->save();
        }

        return $category;
    }

    public function updateCategory(int $id, array $data): Category
    {
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $this->repository()->update($id, $data);
        $category = $this->repository()->findOrFail($id);

        if (!empty($data['meta_title']) || !empty($data['canonical_url'])) {
            $category->syncJsonLd()->save();
        }

        return $category;
    }

    public function uploadImage(UploadedFile $file, string $type = 'image'): string
    {
        $path = 'categories/' . date('Y/m');
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        Storage::disk('public')->putFileAs($path, $file, $filename);
        return $path . '/' . $filename;
    }

    public function deleteImage(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    public function getTree(): Collection
    {
        return $this->repository()->getTree();
    }

    public function getParentOptions(?int $excludeId = null): Collection
    {
        return $this->repository()->getParentOptions($excludeId);
    }

    public function duplicate(int $id): Category
    {
        return $this->repository()->duplicate($id);
    }

    public function bulkDelete(array $ids): array
    {
        return $this->repository()->bulkDelete($ids);
    }

    public function bulkRestore(array $ids): int
    {
        return $this->repository()->bulkRestore($ids);
    }

    public function bulkForceDelete(array $ids): int
    {
        return $this->repository()->bulkForceDelete($ids);
    }

    public function bulkUpdateStatus(array $ids, string $status): int
    {
        return $this->repository()->bulkUpdateStatus($ids, $status);
    }

    public function updateSortOrder(array $items): void
    {
        $this->repository()->updateSortOrder($items);
    }

    public function getStats(): array
    {
        return $this->repository()->getStats();
    }

    public function getChildCategories(int $parentId): Collection
    {
        return $this->repository()->getChildCategories($parentId);
    }

    public function moveProducts(?int $fromCategoryId, ?int $toCategoryId): void
    {
        if ($fromCategoryId && $toCategoryId) {
            Category::find($fromCategoryId)?->moveProductsTo($toCategoryId);
        }
    }

    public function checkDeletable(int $id): array
    {
        $category = Category::findOrFail($id);
        return [
            'deletable' => !$category->children()->exists() && !$category->products()->exists(),
            'has_children' => $category->children()->exists(),
            'has_products' => $category->products()->exists(),
            'children_count' => $category->children()->count(),
            'product_count' => $category->products()->count(),
        ];
    }
}
