<?php

namespace App\Services;

use App\Models\ChartOfAccount;
use App\Models\Expense;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\CashFlow;
use App\Models\Budget;
use Illuminate\Support\Facades\DB;

class FinanceReportService
{
    public function profitLossReport(?string $startDate = null, ?string $endDate = null): array
    {
        $revenue = Order::whereNotIn('status', ['cancelled', 'refunded', 'returned'])
            ->when($startDate, fn($q) => $q->whereDate('created_at', '>=', $startDate))
            ->when($endDate, fn($q) => $q->whereDate('created_at', '<=', $endDate))
            ->sum('total');

        $expenses = Expense::where('status', 'approved')
            ->when($startDate, fn($q) => $q->whereDate('expense_date', '>=', $startDate))
            ->when($endDate, fn($q) => $q->whereDate('expense_date', '<=', $endDate))
            ->sum('total_amount');

        $expenseByCategory = Expense::where('status', 'approved')
            ->when($startDate, fn($q) => $q->whereDate('expense_date', '>=', $startDate))
            ->when($endDate, fn($q) => $q->whereDate('expense_date', '<=', $endDate))
            ->select('expense_category_id', DB::raw('SUM(total_amount) as total'))
            ->with('category:id,name')
            ->groupBy('expense_category_id')
            ->get()
            ->map(fn($e) => [
                'category' => $e->category?->name ?? 'Uncategorized',
                'amount' => (float) $e->total,
            ]);

        return [
            'total_revenue' => $revenue,
            'total_expenses' => $expenses,
            'gross_profit' => $revenue,
            'net_profit' => $revenue - $expenses,
            'expense_breakdown' => $expenseByCategory,
            'profit_margin' => $revenue > 0 ? round(($revenue - $expenses) / $revenue * 100, 2) : 0,
        ];
    }

    public function cashFlowReport(?string $startDate = null, ?string $endDate = null): array
    {
        $inflows = Transaction::completed()->inflow()
            ->when($startDate, fn($q) => $q->whereDate('transaction_date', '>=', $startDate))
            ->when($endDate, fn($q) => $q->whereDate('transaction_date', '<=', $endDate))
            ->sum('net_amount');

        $outflows = Transaction::completed()->outflow()
            ->when($startDate, fn($q) => $q->whereDate('transaction_date', '>=', $startDate))
            ->when($endDate, fn($q) => $q->whereDate('transaction_date', '<=', $endDate))
            ->sum('net_amount');

        $operating = CashFlow::where('type', 'operating')
            ->when($startDate, fn($q) => $q->whereDate('entry_date', '>=', $startDate))
            ->when($endDate, fn($q) => $q->whereDate('entry_date', '<=', $endDate))
            ->selectRaw("SUM(CASE WHEN direction = 'inflow' THEN amount ELSE 0 END) as inflow")
            ->selectRaw("SUM(CASE WHEN direction = 'outflow' THEN amount ELSE 0 END) as outflow")
            ->first();

        $investing = CashFlow::where('type', 'investing')
            ->when($startDate, fn($q) => $q->whereDate('entry_date', '>=', $startDate))
            ->when($endDate, fn($q) => $q->whereDate('entry_date', '<=', $endDate))
            ->selectRaw("SUM(CASE WHEN direction = 'inflow' THEN amount ELSE 0 END) as inflow")
            ->selectRaw("SUM(CASE WHEN direction = 'outflow' THEN amount ELSE 0 END) as outflow")
            ->first();

        $financing = CashFlow::where('type', 'financing')
            ->when($startDate, fn($q) => $q->whereDate('entry_date', '>=', $startDate))
            ->when($endDate, fn($q) => $q->whereDate('entry_date', '<=', $endDate))
            ->selectRaw("SUM(CASE WHEN direction = 'inflow' THEN amount ELSE 0 END) as inflow")
            ->selectRaw("SUM(CASE WHEN direction = 'outflow' THEN amount ELSE 0 END) as outflow")
            ->first();

        return [
            'total_inflow' => $inflows,
            'total_outflow' => $outflows,
            'net_cash_flow' => $inflows - $outflows,
            'operating' => [
                'inflow' => (float) ($operating->inflow ?? 0),
                'outflow' => (float) ($operating->outflow ?? 0),
                'net' => (float) (($operating->inflow ?? 0) - ($operating->outflow ?? 0)),
            ],
            'investing' => [
                'inflow' => (float) ($investing->inflow ?? 0),
                'outflow' => (float) ($investing->outflow ?? 0),
                'net' => (float) (($investing->inflow ?? 0) - ($investing->outflow ?? 0)),
            ],
            'financing' => [
                'inflow' => (float) ($financing->inflow ?? 0),
                'outflow' => (float) ($financing->outflow ?? 0),
                'net' => (float) (($financing->inflow ?? 0) - ($financing->outflow ?? 0)),
            ],
        ];
    }

    public function budgetVsActualReport(?int $budgetId = null): array
    {
        $query = Budget::with('items.expenseCategory');

        if ($budgetId) {
            $query->where('id', $budgetId);
        }

        return $query->get()->map(function ($budget) {
            return [
                'id' => $budget->id,
                'name' => $budget->name,
                'period' => $budget->period,
                'start_date' => $budget->start_date?->format('Y-m-d'),
                'end_date' => $budget->end_date?->format('Y-m-d'),
                'total_budget' => (float) $budget->total_budget,
                'total_spent' => (float) $budget->total_spent,
                'total_remaining' => (float) $budget->total_remaining,
                'usage_percentage' => $budget->total_budget > 0
                    ? round($budget->total_spent / $budget->total_budget * 100, 2)
                    : 0,
                'items' => $budget->items->map(fn($item) => [
                    'category' => $item->category_name,
                    'budgeted' => (float) $item->budgeted_amount,
                    'spent' => (float) $item->spent_amount,
                    'remaining' => (float) $item->remaining_amount,
                    'usage' => $item->getUsagePercentage(),
                    'over_budget' => $item->isOverBudget(),
                ]),
            ];
        })->toArray();
    }

    public function taxSummaryReport(?string $startDate = null, ?string $endDate = null): array
    {
        $taxes = \App\Models\TaxItem::select(
            'tax_rate_id',
            DB::raw('SUM(amount) as total_amount'),
            DB::raw('COUNT(*) as transaction_count')
        )
            ->with('taxRate')
            ->when($startDate, fn($q) => $q->whereHasMorph('taxable', '*', fn($sq) => $sq->whereDate('created_at', '>=', $startDate)))
            ->when($endDate, fn($q) => $q->whereHasMorph('taxable', '*', fn($sq) => $sq->whereDate('created_at', '<=', $endDate)))
            ->groupBy('tax_rate_id')
            ->get()
            ->map(fn($t) => [
                'rate_name' => $t->taxRate?->name ?? 'Unknown',
                'rate' => $t->taxRate?->rate ?? 0,
                'total_amount' => (float) $t->total_amount,
                'transaction_count' => $t->transaction_count,
            ]);

        return [
            'taxes' => $taxes,
            'grand_total' => $taxes->sum('total_amount'),
        ];
    }

    public function accountsPayableReport(): array
    {
        $orders = Order::where('payment_status', '!=', 'paid')
            ->whereNotIn('status', ['cancelled', 'refunded'])
            ->get(['total', 'paid_amount', 'created_at']);

        $totalDue = 0;
        $overdue = 0;

        foreach ($orders as $order) {
            $due = $order->total - $order->paid_amount;
            $totalDue += $due;
            if ($order->created_at && $order->created_at->diffInDays(now()) > 30) {
                $overdue += $due;
            }
        }

        return [
            'total_due' => $totalDue,
            'invoice_count' => $orders->count(),
            'overdue' => $overdue,
        ];
    }

    public function accountsReceivableReport(): array
    {
        $orders = Order::where('payment_status', '!=', 'paid')
            ->whereNotIn('status', ['cancelled', 'refunded'])
            ->get(['total', 'paid_amount']);

        $totalReceivable = $orders->sum(fn($o) => $o->total - $o->paid_amount);

        return [
            'total_receivable' => $totalReceivable,
            'invoice_count' => $orders->count(),
        ];
    }
}
