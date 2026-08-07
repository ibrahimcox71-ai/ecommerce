<?php

namespace App\Repositories;

use App\Models\CustomerGroup;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class CustomerGroupRepository extends BaseRepository
{
    protected function model(): CustomerGroup
    {
        return new CustomerGroup;
    }

    public function paginateWithFilters(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return $this->applyFilters($filters)
            ->sorted()
            ->paginate($perPage);
    }

    public function trashedPaginate(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return CustomerGroup::onlyTrashed()
            ->when($filters['search'] ?? null, fn($q, $v) => $q->search($v))
            ->orderBy('deleted_at', 'desc')
            ->paginate($perPage);
    }

    public function bulkDelete(array $ids): array
    {
        $groups = CustomerGroup::whereIn('id', $ids)->get();
        $deleted = 0;
        $skipped = [];

        foreach ($groups as $group) {
            if ($group->customers()->exists()) {
                $skipped[] = $group->name;
                continue;
            }
            $group->delete();
            $deleted++;
        }

        return ['deleted' => $deleted, 'skipped' => $skipped];
    }

    public function bulkRestore(array $ids): int
    {
        return CustomerGroup::onlyTrashed()
            ->whereIn('id', $ids)
            ->restore();
    }

    public function bulkForceDelete(array $ids): int
    {
        $count = 0;
        CustomerGroup::onlyTrashed()->whereIn('id', $ids)->each(function ($group) use (&$count) {
            $group->forceDelete();
            $count++;
        });
        return $count;
    }

    public function getStats(): array
    {
        return [
            'total' => CustomerGroup::count(),
            'active' => CustomerGroup::where('status', true)->count(),
            'inactive' => CustomerGroup::where('status', false)->count(),
            'trashed' => CustomerGroup::onlyTrashed()->count(),
        ];
    }

    public function searchSuggestions(string $query): array
    {
        return CustomerGroup::search($query)
            ->active()
            ->take(10)
            ->get()
            ->map(fn($group) => [
                'id' => $group->id,
                'name' => $group->name,
                'customer_count' => $group->customers()->count(),
            ])
            ->toArray();
    }

    protected function applyFilters(array $filters): Builder
    {
        return CustomerGroup::withCount('customers')
            ->when($filters['search'] ?? null, fn($q, $v) => $q->search($v))
            ->when(isset($filters['status']), fn($q, $v) => $q->where('status', $v === 'active'))
            ->when($filters['date_from'] ?? null, fn($q, $v) => $q->whereDate('created_at', '>=', $v))
            ->when($filters['date_to'] ?? null, fn($q, $v) => $q->whereDate('created_at', '<=', $v));
    }
}
