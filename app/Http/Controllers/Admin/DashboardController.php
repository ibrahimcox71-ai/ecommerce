<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Purchase;
use App\Models\ActivityLog;
use App\Models\Inventory;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private const STATUS_EXCLUDED = ['cancelled', 'returned', 'refunded'];
    private const PURCHASE_STATUS_EXCLUDED = ['draft', 'cancelled', 'returned'];

    public function index()
    {
        return view('admin.dashboard', [
            'latestOrders'        => $this->latestOrders(),
            'latestCustomers'     => $this->latestCustomers(),
            'recentActivity'      => $this->recentActivity(),
            'lowStockAlerts'      => $this->lowStockAlerts(),
            'recentNotifications' => $this->recentNotifications(),
        ]);
    }

    public function data(Request $request): JsonResponse
    {
        $period = in_array($request->input('period'), ['week', 'month', 'year'], true)
            ? $request->input('period')
            : 'month';

        return response()->json([
            'success' => true,
            'data' => [
                'period' => $period,
                'kpis' => $this->kpis(),
                'revenue' => $this->revenueSeries($period),
                'order_status' => $this->orderStatus(),
                'categories' => $this->categorySales(),
                'customer_growth' => $this->customerGrowth(),
            ],
        ]);
    }

    private function kpis(): array
    {
        $monthStart = Carbon::now()->startOfMonth();
        $lastMonthStart = (clone $monthStart)->subMonth();
        $lastMonthEnd = (clone $monthStart)->subSecond();

        $revenue = $this->revenueBetween(null, null);
        $revenueMonth = $this->revenueBetween($monthStart, Carbon::now());
        $revenuePrevMonth = $this->revenueBetween($lastMonthStart, $lastMonthEnd);

        $purchases = $this->purchasesBetween(null, null);
        $purchasesMonth = $this->purchasesBetween($monthStart, Carbon::now());
        $purchasesPrevMonth = $this->purchasesBetween($lastMonthStart, $lastMonthEnd);

        $profit = max(0, $revenue - $purchases);
        $profitMonth = max(0, $revenueMonth - $purchasesMonth);
        $profitPrevMonth = max(0, $revenuePrevMonth - $purchasesPrevMonth);

        $weekStart = Carbon::now()->subWeek();
        $prevWeekStart = Carbon::now()->subWeeks(2);
        $pendingNow = Order::whereIn('status', ['pending', 'confirmed', 'processing'])->count();
        $pendingWeek = Order::whereIn('status', ['pending', 'confirmed', 'processing'])
            ->whereBetween('created_at', [$weekStart, Carbon::now()])
            ->count();
        $pendingPrevWeek = Order::whereIn('status', ['pending', 'confirmed', 'processing'])
            ->whereBetween('created_at', [$prevWeekStart, $weekStart])
            ->count();

        $customersTotal = Customer::count();
        $paidOrders = Order::whereIn('payment_status', ['paid', 'partial'])
            ->whereNotIn('status', self::STATUS_EXCLUDED)
            ->count();
        $conversion = $customersTotal > 0 ? round($paidOrders / $customersTotal * 100, 2) : 0;

        $customersMonth = Customer::whereBetween('created_at', [$monthStart, Carbon::now()])->count();
        $customersPrevMonth = Customer::whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])->count();
        $paidOrdersMonth = Order::whereIn('payment_status', ['paid', 'partial'])
            ->whereNotIn('status', self::STATUS_EXCLUDED)
            ->whereBetween('created_at', [$monthStart, Carbon::now()])
            ->count();
        $paidOrdersPrevMonth = Order::whereIn('payment_status', ['paid', 'partial'])
            ->whereNotIn('status', self::STATUS_EXCLUDED)
            ->whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])
            ->count();
        $conversionPrevMonth = $customersPrevMonth > 0
            ? round($paidOrdersPrevMonth / $customersPrevMonth * 100, 2)
            : 0;

        return [
            'total_revenue' => round($revenue, 2),
            'revenue_trend' => $this->trend($revenueMonth, $revenuePrevMonth),
            'total_profit' => round($profit, 2),
            'profit_trend' => $this->trend($profitMonth, $profitPrevMonth),
            'pending_orders' => $pendingNow,
            'pending_trend' => $this->trend($pendingWeek, $pendingPrevWeek, true),
            'conversion_rate' => $conversion,
            'conversion_trend' => $this->trend($conversion, $conversionPrevMonth),
        ];
    }

    private function revenueSeries(string $period): array
    {
        if ($period === 'year') {
            $labels = [];
            $values = [];
            for ($i = 11; $i >= 0; $i--) {
                $start = Carbon::now()->startOfMonth()->subMonths($i);
                $end = (clone $start)->copy()->endOfMonth();
                $labels[] = $start->format('M');
                $values[] = $this->revenueBetween($start, $end);
            }

            return ['labels' => $labels, 'values' => $values];
        }

        $days = $period === 'week' ? 7 : 30;
        $start = Carbon::now()->subDays($days - 1)->startOfDay();

        $rows = Order::whereNotIn('status', self::STATUS_EXCLUDED)
            ->where('created_at', '>=', $start)
            ->selectRaw('DATE(created_at) as day, SUM(total) as total')
            ->groupBy('day')
            ->pluck('total', 'day');

        $labels = [];
        $values = [];
        for ($i = 0; $i < $days; $i++) {
            $day = (clone $start)->addDays($i);
            $labels[] = $day->format('M d');
            $values[] = round((float) ($rows[$day->format('Y-m-d')] ?? 0), 2);
        }

        return ['labels' => $labels, 'values' => $values];
    }

    private function orderStatus(): array
    {
        $counts = Order::getStatusCounts();

        $groups = [
            'Pending' => $counts['pending'] + $counts['confirmed'] + $counts['processing'],
            'Shipping' => $counts['packing'] + $counts['ready_to_ship'] + $counts['shipping'] + $counts['out_for_delivery'],
            'Completed' => $counts['delivered'] + $counts['completed'],
            'Cancelled' => $counts['cancelled'] + $counts['returned'] + $counts['refunded'],
        ];

        return [
            'labels' => array_keys($groups),
            'values' => array_values($groups),
        ];
    }

    private function categorySales(): array
    {
        $rows = OrderItem::join('orders', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->whereNotIn('orders.status', self::STATUS_EXCLUDED)
            ->selectRaw('categories.name as name, SUM(order_items.subtotal) as total')
            ->groupBy('categories.name')
            ->orderByDesc('total')
            ->limit(6)
            ->get();

        return [
            'labels' => $rows->pluck('name')->values()->all(),
            'values' => $rows->map(fn ($r) => round((float) $r->total, 2))->values()->all(),
        ];
    }

    private function customerGrowth(): array
    {
        $labels = [];
        $values = [];
        for ($i = 11; $i >= 0; $i--) {
            $start = Carbon::now()->startOfMonth()->subMonths($i);
            $end = (clone $start)->copy()->endOfMonth();
            $labels[] = $start->format('M');
            $values[] = Customer::whereBetween('created_at', [$start, $end])->count();
        }

        return ['labels' => $labels, 'values' => $values];
    }

    private function revenueBetween(?Carbon $start, ?Carbon $end): float
    {
        return (float) Order::whereNotIn('status', self::STATUS_EXCLUDED)
            ->when($start && $end, fn ($q) => $q->whereBetween('created_at', [$start, $end]))
            ->sum('total');
    }

    private function purchasesBetween(?Carbon $start, ?Carbon $end): float
    {
        return (float) Purchase::whereNotIn('status', self::PURCHASE_STATUS_EXCLUDED)
            ->when($start && $end, fn ($q) => $q->whereBetween('created_at', [$start, $end]))
            ->sum('total_amount');
    }

    private function trend(float $current, float $previous, bool $invert = false): float
    {
        if ($previous == 0) {
            return 0;
        }

        $pct = round(($current - $previous) / $previous * 100, 1);

        return $invert ? round(-$pct, 1) : $pct;
    }

    private function latestOrders()
    {
        return Order::with('user')->latest()->take(5)->get();
    }

    private function latestCustomers()
    {
        return Customer::latest()
            ->withCount(['orders' => fn ($q) => $q->whereIn('orders.status', ['completed', 'delivered'])])
            ->withSum(['orders as total_spend_sum' => fn ($q) => $q->whereIn('orders.status', ['completed', 'delivered'])], 'total')
            ->take(5)
            ->get();
    }

    private function recentActivity()
    {
        return ActivityLog::with(['subject', 'causer'])->latest()->take(6)->get();
    }

    private function lowStockAlerts()
    {
        return Inventory::lowStock()
            ->with('product')
            ->orderByRaw('(quantity - reserved_quantity) ASC')
            ->take(5)
            ->get();
    }

    private function recentNotifications()
    {
        return Notification::latest()->take(6)->get();
    }
}
