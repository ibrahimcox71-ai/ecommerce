<?php

namespace App\Services;

use App\Models\Brand;
use App\Repositories\BrandRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BrandService extends BaseService
{
    protected string $repositoryClass = BrandRepository::class;

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

    public function createBrand(array $data): Brand
    {
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }
        if (empty($data['status'])) {
            $data['status'] = 'active';
        }

        /** @var Brand $brand */
        $brand = $this->repository()->create($data);

        return $brand;
    }

    public function updateBrand(int $id, array $data): Brand
    {
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $this->repository()->update($id, $data);
        return $this->repository()->findOrFail($id);
    }

    public function uploadImage(UploadedFile $file, string $type = 'image'): string
    {
        $directory = match ($type) {
            'logo' => 'brands/logos',
            'banner' => 'brands/banners',
            'og_image' => 'brands/og-images',
            default => 'brands/' . date('Y/m'),
        };

        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        Storage::disk('public')->putFileAs($directory, $file, $filename);

        return $directory . '/' . $filename;
    }

    public function deleteImage(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    public function duplicate(int $id): Brand
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

    public function getStats(): array
    {
        return $this->repository()->getStats();
    }

    public function searchSuggestions(string $query): array
    {
        return $this->repository()->searchSuggestions($query);
    }

    public function checkDeletable(int $id): array
    {
        return $this->repository()->checkDeletable($id);
    }
}
