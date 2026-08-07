<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Http\Requests\Finance\StoreExpenseRequest;
use App\Http\Requests\Finance\UpdateExpenseRequest;
use App\Models\ChartOfAccount;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Services\ExpenseService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExpenseController extends Controller
{
    public function __construct(
        protected ExpenseService $expenseService,
    ) {}

    public function index(Request $request): View
    {
        $filters = $request->only(['search', 'status', 'category_id', 'date_from', 'date_to', 'payee']);

        $expenses = Expense::with(['category', 'creator'])
            ->when($filters['search'] ?? null, fn($q, $v) => $q->where(function($sq) use ($v) {
                $sq->where('expense_number', 'like', "%{$v}%")
                    ->orWhere('description', 'like', "%{$v}%")
                    ->orWhere('payee', 'like', "%{$v}%");
            }))
            ->when($filters['status'] ?? null, fn($q, $v) => $q->where('status', $v))
            ->when($filters['category_id'] ?? null, fn($q, $v) => $q->where('expense_category_id', $v))
            ->when($filters['payee'] ?? null, fn($q, $v) => $q->where('payee', 'like', "%{$v}%"))
            ->when($filters['date_from'] ?? null, fn($q, $v) => $q->whereDate('expense_date', '>=', $v))
            ->when($filters['date_to'] ?? null, fn($q, $v) => $q->whereDate('expense_date', '<=', $v))
            ->latest()
            ->paginate(15);

        $stats = [
            'total_approved' => Expense::where('status', 'approved')->sum('total_amount'),
            'total_pending' => Expense::where('status', 'pending')->sum('total_amount'),
            'approved_count' => Expense::where('status', 'approved')->count(),
            'pending_count' => Expense::where('status', 'pending')->count(),
        ];

        $categories = ExpenseCategory::active()->orderBy('name')->get(['id', 'name']);

        return view('admin.finance.expenses.index', compact('expenses', 'filters', 'stats', 'categories'));
    }

    public function create(): View
    {
        $categories = ExpenseCategory::active()->orderBy('name')->get(['id', 'name', 'type']);
        $accounts = ChartOfAccount::active()->whereIn('type', ['expense', 'contra_expense'])->orderBy('code')->get(['id', 'code', 'name']);

        return view('admin.finance.expenses.create', compact('categories', 'accounts'));
    }

    public function store(StoreExpenseRequest $request): RedirectResponse
    {
        try {
            $expense = $this->expenseService->createExpense($request->validated());

            return redirect()
                ->route('admin.finance.expenses.show', $expense->id)
                ->with('success', "Expense {$expense->expense_number} created successfully!");
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function show(Expense $expense): View
    {
        $expense->load(['category', 'creator', 'approver', 'chartOfAccount']);

        return view('admin.finance.expenses.show', compact('expense'));
    }

    public function edit(Expense $expense): View
    {
        if (!$expense->isEditable()) {
            abort(403, 'Expense cannot be edited.');
        }

        $categories = ExpenseCategory::active()->orderBy('name')->get(['id', 'name', 'type']);
        $accounts = ChartOfAccount::active()->whereIn('type', ['expense', 'contra_expense'])->orderBy('code')->get(['id', 'code', 'name']);

        return view('admin.finance.expenses.edit', compact('expense', 'categories', 'accounts'));
    }

    public function update(UpdateExpenseRequest $request, Expense $expense): RedirectResponse
    {
        try {
            $this->expenseService->updateExpense($expense->id, $request->validated());

            return redirect()
                ->route('admin.finance.expenses.show', $expense->id)
                ->with('success', 'Expense updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function destroy(Expense $expense): RedirectResponse
    {
        try {
            if (!$expense->isEditable()) {
                throw new \RuntimeException('Expense cannot be deleted.');
            }

            $expense->delete();

            return redirect()
                ->route('admin.finance.expenses.index')
                ->with('success', 'Expense deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function approve(Expense $expense): RedirectResponse
    {
        try {
            $this->expenseService->approve($expense->id);

            return redirect()
                ->route('admin.finance.expenses.show', $expense->id)
                ->with('success', 'Expense approved successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function cancel(Expense $expense): RedirectResponse
    {
        try {
            $this->expenseService->cancel($expense->id);

            return redirect()
                ->route('admin.finance.expenses.index')
                ->with('success', 'Expense cancelled.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function exportCsv(Request $request): \Illuminate\Http\Response
    {
        $filters = $request->only(['status', 'category_id', 'date_from', 'date_to']);
        $expenses = Expense::with('category')
            ->when($filters['status'] ?? null, fn($q, $v) => $q->where('status', $v))
            ->when($filters['category_id'] ?? null, fn($q, $v) => $q->where('expense_category_id', $v))
            ->when($filters['date_from'] ?? null, fn($q, $v) => $q->whereDate('expense_date', '>=', $v))
            ->when($filters['date_to'] ?? null, fn($q, $v) => $q->whereDate('expense_date', '<=', $v))
            ->latest()->get();

        $filename = 'expenses-' . now()->format('Y-m-d-His') . '.csv';
        $handle = fopen('php://temp', 'w+');
        fputcsv($handle, ['Expense #', 'Category', 'Amount', 'Tax', 'Total', 'Currency', 'Payee', 'Date', 'Status', 'Description']);

        foreach ($expenses as $e) {
            fputcsv($handle, [
                $e->expense_number, $e->category?->name, $e->amount, $e->tax_amount, $e->total_amount,
                $e->currency, $e->payee, $e->expense_date?->format('Y-m-d'), $e->status, $e->description,
            ]);
        }

        rewind($handle);
        $content = stream_get_contents($handle);
        fclose($handle);

        return response($content, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ]);
    }
}
