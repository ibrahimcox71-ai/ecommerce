<?php

namespace App\Services;

use App\Models\CustomerGroup;
use App\Repositories\CustomerGroupRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class CustomerGroupService extends BaseService
{
    protected string $repositoryClass = CustomerGroupRepository::class;

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

    public function createGroup(array $data): CustomerGroup
    {
        $data['created_by'] = auth()->guard('admin')->id();
        /** @var CustomerGroup $group */
        $group = $this->repository()->create($data);
        return $group;
    }

    public function updateGroup(int $id, array $data): CustomerGroup
    {
        $this->repository()->update($id, $data);
        return $this->repository()->findOrFail($id);
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

    public function getStats(): array
    {
        return $this->repository()->getStats();
    }

    public function searchSuggestions(string $query): array
    {
        return $this->repository()->searchSuggestions($query);
    }

    public function getAllActive(): array
    {
        return CustomerGroup::active()->sorted()->get()->toArray();
    }
}
