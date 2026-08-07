<?php

namespace App\Repositories;

use App\Models\Order;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class OrderRepository
{
    public function __construct(
        protected Order $model
    ) {}

    public function getAll(array $filters = []): LengthAwarePaginator
    {
        $query = $this->model->with([
            'items',
            'payment',
            'user:id,name,email',
        ]);

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['payment_status'])) {
            $query->where('payment_status', $filters['payment_status']);
        }

        if (!empty($filters['search'])) {
            $query->search($filters['search']);
        }

        if (!empty($filters['date_from'])) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }

        if (!empty($filters['order_origin'])) {
            $query->where('order_origin', $filters['order_origin']);
        }

        if (!empty($filters['carrier'])) {
            $query->where('carrier', $filters['carrier']);
        }

        $sortField = $filters['sort'] ?? 'created_at';
        $sortDir = $filters['sort_dir'] ?? 'desc';
        $query->orderBy($sortField, $sortDir);

        $perPage = $filters['per_page'] ?? config('ecommerce.pagination.admin_per_page', 20);

        return $query->paginate($perPage);
    }

    public function findById(int $id): ?Order
    {
        return Cache::remember("order.{$id}", 300, function () use ($id) {
            return $this->model->with([
                'items',
                'payment',
                'transactions',
                'user:id,name,email,phone',
                'returns',
                'activityLogs',
            ])->find($id);
        });
    }

    public function findByOrderNumber(string $orderNumber): ?Order
    {
        return $this->model->where('order_number', $orderNumber)->first();
    }

    public function getRecentOrders(int $limit = 10): array
    {
        return $this->model->with(['items', 'user:id,name'])
            ->latest()
            ->limit($limit)
            ->get()
            ->toArray();
    }

    public function getSalesReport($startDate, $endDate): array
    {
        $query = $this->model->whereBetween('created_at', [$startDate, $endDate])
            ->whereNotIn('status', ['cancelled', 'returned', 'refunded']);

        return [
            'total_orders' => (clone $query)->count(),
            'total_revenue' => (clone $query)->sum('total'),
            'total_paid' => (clone $query)->sum('paid_amount'),
            'total_shipping' => (clone $query)->sum('shipping_cost'),
            'total_tax' => (clone $query)->sum('tax_amount'),
            'total_discount' => (clone $query)->sum('coupon_discount'),
            'avg_order_value' => (clone $query)->avg('total') ?? 0,
        ];
    }

    public function getDailyOrders(int $days = 30): array
    {
        return $this->model->selectRaw("
            DATE(created_at) as date,
            COUNT(*) as total_orders,
            SUM(CASE WHEN status != 'cancelled' THEN total ELSE 0 END) as revenue,
            SUM(CASE WHEN status = 'cancelled' THEN 1 ELSE 0 END) as cancelled
        ")
        ->where('created_at', '>=', now()->subDays($days))
        ->groupBy('date')
        ->orderBy('date')
        ->get()
        ->toArray();
    }

    public function getMonthlyOrders(int $months = 12): array
    {
        return $this->model->selectRaw("
            DATE_FORMAT(created_at, '%Y-%m') as month,
            COUNT(*) as total_orders,
            SUM(CASE WHEN status != 'cancelled' THEN total ELSE 0 END) as revenue,
            SUM(CASE WHEN status = 'cancelled' THEN 1 ELSE 0 END) as cancelled
        ")
        ->where('created_at', '>=', now()->subMonths($months))
        ->groupBy('month')
        ->orderBy('month')
        ->get()
        ->toArray();
    }

    public function getTopCustomers(int $limit = 10): array
    {
        return $this->model->selectRaw("
            user_id,
            COUNT(*) as order_count,
            SUM(total) as total_spent,
            MAX(created_at) as last_order_date
        ")
        ->whereNotNull('user_id')
        ->where('status', '!=', 'cancelled')
        ->groupBy('user_id')
        ->orderByDesc('total_spent')
        ->limit($limit)
        ->with('user:id,name,email')
        ->get()
        ->toArray();
    }

    public function getTopProducts(int $limit = 10): array
    {
        return \DB::table('order_items')
            ->selectRaw("
                product_id,
                product_name,
                product_sku,
                SUM(quantity) as total_qty,
                SUM(subtotal) as total_revenue
            ")
            ->whereNotNull('product_id')
            ->groupBy('product_id', 'product_name', 'product_sku')
            ->orderByDesc('total_revenue')
            ->limit($limit)
            ->get()
            ->toArray();
    }

    public function getCancelledOrders($startDate = null, $endDate = null): array
    {
        $query = $this->model->where('status', 'cancelled');
        if ($startDate) {
            $query->where('cancelled_at', '>=', $startDate);
        }
        if ($endDate) {
            $query->where('cancelled_at', '<=', $endDate);
        }
        return [
            'count' => (clone $query)->count(),
            'total_amount' => (clone $query)->sum('total'),
            'orders' => $query->with(['user:id,name'])->latest('cancelled_at')->limit(50)->get()->toArray(),
        ];
    }

    public function getReturnedOrders($startDate = null, $endDate = null): array
    {
        $query = $this->model->where('status', 'returned');
        if ($startDate) {
            $query->where('returned_at', '>=', $startDate);
        }
        if ($endDate) {
            $query->where('returned_at', '<=', $endDate);
        }
        return [
            'count' => (clone $query)->count(),
            'total_amount' => (clone $query)->sum('total'),
            'orders' => $query->with(['user:id,name'])->latest('returned_at')->limit(50)->get()->toArray(),
        ];
    }

    public function clearCache(int $orderId): void
    {
        Cache::forget("order.{$orderId}");
        Cache::forget('order_status_counts');
    }
}
