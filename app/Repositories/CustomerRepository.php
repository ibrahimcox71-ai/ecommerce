<?php

namespace App\Repositories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class CustomerRepository extends BaseRepository
{
    protected function model(): Customer
    {
        return new Customer;
    }

    public function paginateWithFilters(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return $this->applyFilters($filters)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    public function trashedPaginate(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return Customer::onlyTrashed()
            ->when($filters['search'] ?? null, fn($q, $v) => $q->search($v))
            ->orderBy('deleted_at', 'desc')
            ->paginate($perPage);
    }

    public function bulkDelete(array $ids): array
    {
        $customers = Customer::whereIn('id', $ids)->get();
        $deleted = 0;

        foreach ($customers as $customer) {
            $customer->delete();
            $deleted++;
        }

        return ['deleted' => $deleted, 'skipped' => []];
    }

    public function bulkRestore(array $ids): int
    {
        return Customer::onlyTrashed()
            ->whereIn('id', $ids)
            ->restore();
    }

    public function bulkForceDelete(array $ids): int
    {
        $count = 0;
        Customer::onlyTrashed()->whereIn('id', $ids)->each(function ($customer) use (&$count) {
            $customer->forceDelete();
            $count++;
        });
        return $count;
    }

    public function getStats(): array
    {
        return [
            'total' => Customer::count(),
            'active' => Customer::where('status', 'active')->count(),
            'suspended' => Customer::where('status', 'suspended')->count(),
            'trashed' => Customer::onlyTrashed()->count(),
            'individual' => Customer::where('customer_type', 'individual')->count(),
            'business' => Customer::where('customer_type', 'business')->count(),
            'with_orders' => Customer::whereHas('user.orders')->count(),
            'with_reward_points' => Customer::where('reward_points', '>', 0)->count(),
        ];
    }

    public function searchSuggestions(string $query): array
    {
        return Customer::search($query)
            ->active()
            ->take(10)
            ->get()
            ->map(fn($customer) => [
                'id' => $customer->id,
                'name' => $customer->name,
                'email' => $customer->email,
                'phone' => $customer->phone,
                'avatar' => $customer->avatar_url,
                'type' => $customer->customer_type->label(),
            ])
            ->toArray();
    }

    public function getTopCustomers(int $limit = 10): array
    {
        return Customer::topCustomers($limit)
            ->get()
            ->map(fn($customer) => [
                'id' => $customer->id,
                'name' => $customer->name,
                'email' => $customer->email,
                'avatar' => $customer->avatar_url,
                'orders_count' => $customer->orders_count ?? 0,
                'total_spend' => (float) ($customer->user?->orders()->whereIn('order_status', ['completed', 'delivered'])->sum('total') ?? 0),
                'last_order_date' => $customer->user?->orders()->latest()?->first()?->created_at,
            ])
            ->toArray();
    }

    public function getHighestSpendingCustomers(int $limit = 10): array
    {
        return Customer::highestSpending($limit)
            ->get()
            ->map(fn($customer) => [
                'id' => $customer->id,
                'name' => $customer->name,
                'email' => $customer->email,
                'avatar' => $customer->avatar_url,
                'total_spend' => (float) ($customer->total_spend_sum ?? 0),
                'orders_count' => $customer->user?->orders()->whereIn('order_status', ['completed', 'delivered'])->count() ?? 0,
                'wallet_balance' => (float) $customer->wallet_balance,
            ])
            ->toArray();
    }

    public function getInactiveCustomers(int $days = 90): array
    {
        $date = now()->subDays($days);
        return Customer::inactiveSince($date)
            ->get()
            ->map(fn($customer) => [
                'id' => $customer->id,
                'name' => $customer->name,
                'email' => $customer->email,
                'phone' => $customer->phone,
                'avatar' => $customer->avatar_url,
                'last_login' => $customer->last_login_at,
                'total_orders' => $customer->total_orders,
                'total_spend' => $customer->total_spend,
            ])
            ->toArray();
    }

    public function getGrowthData(string $startDate, string $endDate, string $groupBy = 'month'): array
    {
        $query = Customer::whereBetween('created_at', [$startDate, $endDate]);

        return match ($groupBy) {
            'day' => $query->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                ->groupBy('date')
                ->orderBy('date')
                ->get()
                ->toArray(),
            'week' => $query->selectRaw('YEARWEEK(created_at) as period, COUNT(*) as count')
                ->groupBy('period')
                ->orderBy('period')
                ->get()
                ->toArray(),
            default => $query->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as period, COUNT(*) as count")
                ->groupBy('period')
                ->orderBy('period')
                ->get()
                ->toArray(),
        };
    }

    protected function applyFilters(array $filters): Builder
    {
        return Customer::with(['group', 'user'])->withCount(['addresses'])
            ->when($filters['search'] ?? null, fn($q, $v) => $q->search($v))
            ->when($filters['status'] ?? null, fn($q, $v) => $q->where('status', $v))
            ->when($filters['customer_type'] ?? null, fn($q, $v) => $q->where('customer_type', $v))
            ->when($filters['customer_group_id'] ?? null, fn($q, $v) => $q->where('customer_group_id', $v))
            ->when($filters['city'] ?? null, fn($q, $v) => $q->byCity($v))
            ->when($filters['date_from'] ?? null, fn($q, $v) => $q->whereDate('created_at', '>=', $v))
            ->when($filters['date_to'] ?? null, fn($q, $v) => $q->whereDate('created_at', '<=', $v));
    }
}
