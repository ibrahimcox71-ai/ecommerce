<?php

namespace App\Services;

use App\Models\ChartOfAccount;
use App\Models\Expense;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class FinanceDashboardService
{
    public function getOverview(): array
    {
        $totalRevenue = Order::whereNotIn('status', ['cancelled', 'refunded', 'returned'])
            ->sum('total');

        $totalExpenses = Expense::where('status', 'approved')
            ->sum('total_amount');

        $pendingExpenses = Expense::where('status', 'pending')
            ->sum('total_amount');

        $totalTransactions = Transaction::completed()->count();

        $cashInflow = Transaction::completed()->inflow()->sum('net_amount');
        $cashOutflow = Transaction::completed()->outflow()->sum('net_amount');

        $accountBalances = ChartOfAccount::where('is_active', true)
            ->select('type', DB::raw('SUM(current_balance) as balance'))
            ->groupBy('type')
            ->pluck('balance', 'type')
            ->toArray();

        return [
            'total_revenue' => $totalRevenue,
            'total_expenses' => $totalExpenses,
            'pending_expenses' => $pendingExpenses,
            'net_profit' => $totalRevenue - $totalExpenses,
            'total_transactions' => $totalTransactions,
            'cash_inflow' => $cashInflow,
            'cash_outflow' => $cashOutflow,
            'net_cash' => $cashInflow - $cashOutflow,
            'account_balances' => $accountBalances,
        ];
    }

    public function getRevenueExpenseChart(string $period = 'monthly'): array
    {
        $sixMonthsAgo = now()->subMonths(5)->startOfMonth();

        $monthlyRevenue = Order::whereNotIn('status', ['cancelled', 'refunded', 'returned'])
            ->where('created_at', '>=', $sixMonthsAgo)
            ->selectRaw("strftime('%Y-%m', created_at) as month, SUM(total) as total")
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $monthlyExpenses = Expense::where('status', 'approved')
            ->where('created_at', '>=', $sixMonthsAgo)
            ->selectRaw("strftime('%Y-%m', created_at) as month, SUM(total_amount) as total")
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $months = collect(range(5, 0))->map(function ($i) {
            return now()->subMonths($i)->format('Y-m');
        });

        $labels = [];
        $revenueData = [];
        $expenseData = [];

        foreach ($months as $month) {
            $labels[] = \Carbon\Carbon::parse($month . '-01')->format('M Y');
            $revenueData[] = (float) ($monthlyRevenue[$month] ?? 0);
            $expenseData[] = (float) ($monthlyExpenses[$month] ?? 0);
        }

        return [
            'labels' => $labels,
            'revenue' => $revenueData,
            'expenses' => $expenseData,
        ];
    }

    public function getAccountSummary(): array
    {
        return ChartOfAccount::where('is_active', true)
            ->select('type', DB::raw('COUNT(*) as count'), DB::raw('SUM(current_balance) as total_balance'))
            ->groupBy('type')
            ->get()
            ->toArray();
    }

    public function getRecentTransactions(int $limit = 10): array
    {
        return Transaction::with(['chartOfAccount', 'creator'])
            ->latest()
            ->limit($limit)
            ->get()
            ->toArray();
    }

    public function getExpenseByCategory(): array
    {
        return Expense::where('status', 'approved')
            ->select('expense_category_id', DB::raw('SUM(total_amount) as total'))
            ->with('category:id,name')
            ->groupBy('expense_category_id')
            ->get()
            ->map(fn($e) => [
                'category' => $e->category?->name ?? 'Uncategorized',
                'total' => (float) $e->total,
            ])
            ->toArray();
    }
}
