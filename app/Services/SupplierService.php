<?php

namespace App\Services;

use App\Models\Supplier;
use App\Repositories\SupplierRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SupplierService extends BaseService
{
    protected string $repositoryClass = SupplierRepository::class;

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

    public function createSupplier(array $data): Supplier
    {
        if (empty($data['status'])) {
            $data['status'] = 'active';
        }

        /** @var Supplier $supplier */
        $supplier = $this->repository()->create($data);

        return $supplier;
    }

    public function updateSupplier(int $id, array $data): Supplier
    {
        $this->repository()->update($id, $data);
        return $this->repository()->findOrFail($id);
    }

    public function uploadImage(UploadedFile $file): string
    {
        $directory = 'suppliers/logos/' . date('Y/m');
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
