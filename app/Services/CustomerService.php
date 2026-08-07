<?php

namespace App\Services;

use App\Models\Customer;
use App\Repositories\CustomerRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CustomerService extends BaseService
{
    protected string $repositoryClass = CustomerRepository::class;

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

    public function createCustomer(array $data): Customer
    {
        return DB::transaction(function () use ($data) {
            $data['created_by'] = auth()->guard('admin')->id();

            if (empty($data['referral_code'])) {
                $data['referral_code'] = strtoupper(Str::random(8));
            }

            if (!empty($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            }

            /** @var Customer $customer */
            $customer = $this->repository()->create($data);

            if (!empty($data['addresses'])) {
                foreach ($data['addresses'] as $address) {
                    $customer->addresses()->create($address);
                }
            }

            return $customer;
        });
    }

    public function updateCustomer(int $id, array $data): Customer
    {
        return DB::transaction(function () use ($id, $data) {
            if (!empty($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']);
            }

            unset($data['referral_code']);

            $this->repository()->update($id, $data);
            /** @var Customer $customer */
            $customer = $this->repository()->findOrFail($id);
            return $customer;
        });
    }

    public function uploadAvatar(UploadedFile $file): string
    {
        $directory = 'customers/' . date('Y/m');
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        Storage::disk('public')->putFileAs($directory, $file, $filename);
        return $directory . '/' . $filename;
    }

    public function deleteAvatar(?string $path): void
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

    public function getStats(): array
    {
        return $this->repository()->getStats();
    }

    public function searchSuggestions(string $query): array
    {
        return $this->repository()->searchSuggestions($query);
    }

    public function toggleStatus(int $id): array
    {
        $customer = $this->repository()->findOrFail($id);

        if ($customer->isSuspended()) {
            $customer->activate();
            return ['status' => 'active', 'message' => 'Customer activated successfully!'];
        }

        $customer->suspend();
        return ['status' => 'suspended', 'message' => 'Customer suspended successfully!'];
    }

    public function getTopCustomers(int $limit = 10): array
    {
        return $this->repository()->getTopCustomers($limit);
    }

    public function getHighestSpendingCustomers(int $limit = 10): array
    {
        return $this->repository()->getHighestSpendingCustomers($limit);
    }

    public function getInactiveCustomers(int $days = 90): array
    {
        return $this->repository()->getInactiveCustomers($days);
    }

    public function getGrowthData(string $startDate, string $endDate, string $groupBy = 'month'): array
    {
        return $this->repository()->getGrowthData($startDate, $endDate, $groupBy);
    }
}
