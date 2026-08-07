<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Models\ChartOfAccount;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\RecurringExpense;
use App\Services\ExpenseService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RecurringExpenseController extends Controller
{
    public function __construct(
        protected ExpenseService $expenseService,
    ) {}

    public function index(): View
    {
        $recurrings = RecurringExpense::with('category')
            ->latest()
            ->paginate(15);

        return view('admin.finance.recurring-expenses.index', compact('recurrings'));
    }

    public function create(): View
    {
        $categories = ExpenseCategory::active()->orderBy('name')->get(['id', 'name']);
        $accounts = ChartOfAccount::active()->whereIn('type', ['expense', 'contra_expense'])->orderBy('code')->get(['id', 'code', 'name']);

        return view('admin.finance.recurring-expenses.create', compact('categories', 'accounts'));
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            $data = $request->validate([
                'expense_category_id' => ['required', 'integer', 'exists:expense_categories,id'],
                'amount' => ['required', 'numeric', 'min:0.01'],
                'currency' => ['nullable', 'string', 'max:3'],
                'interval' => ['required', 'string', 'in:daily,weekly,bi_weekly,monthly,quarterly,semi_annually,annually'],
                'interval_count' => ['nullable', 'integer', 'min:1'],
                'start_date' => ['required', 'date'],
                'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
                'payee' => ['nullable', 'string', 'max:255'],
                'payment_method' => ['nullable', 'string', 'max:100'],
                'description' => ['nullable', 'string', 'max:500'],
                'notes' => ['nullable', 'string', 'max:2000'],
                'max_occurrences' => ['nullable', 'integer', 'min:1'],
                'chart_of_account_id' => ['nullable', 'integer', 'exists:chart_of_accounts,id'],
            ]);

            $data['created_by'] = auth()->guard('admin')->id();
            $data['next_due_date'] = $data['start_date'];

            RecurringExpense::create($data);

            return redirect()
                ->route('admin.finance.recurring-expenses.index')
                ->with('success', 'Recurring expense created!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function edit(RecurringExpense $recurring_expense): View
    {
        $categories = ExpenseCategory::active()->orderBy('name')->get(['id', 'name']);
        $accounts = ChartOfAccount::active()->whereIn('type', ['expense', 'contra_expense'])->orderBy('code')->get(['id', 'code', 'name']);

        return view('admin.finance.recurring-expenses.edit', [
            'recurring' => $recurring_expense,
            'categories' => $categories,
            'accounts' => $accounts,
        ]);
    }

    public function update(Request $request, RecurringExpense $recurring_expense): RedirectResponse
    {
        try {
            $data = $request->validate([
                'expense_category_id' => ['required', 'integer', 'exists:expense_categories,id'],
                'amount' => ['required', 'numeric', 'min:0.01'],
                'currency' => ['nullable', 'string', 'max:3'],
                'interval' => ['required', 'string', 'in:daily,weekly,bi_weekly,monthly,quarterly,semi_annually,annually'],
                'interval_count' => ['nullable', 'integer', 'min:1'],
                'start_date' => ['required', 'date'],
                'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
                'payee' => ['nullable', 'string', 'max:255'],
                'payment_method' => ['nullable', 'string', 'max:100'],
                'description' => ['nullable', 'string', 'max:500'],
                'notes' => ['nullable', 'string', 'max:2000'],
                'max_occurrences' => ['nullable', 'integer', 'min:1'],
                'chart_of_account_id' => ['nullable', 'integer', 'exists:chart_of_accounts,id'],
                'status' => ['nullable', 'string', 'in:active,paused'],
            ]);

            $recurring_expense->update($data);

            return redirect()
                ->route('admin.finance.recurring-expenses.index')
                ->with('success', 'Recurring expense updated!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function destroy(RecurringExpense $recurring_expense): RedirectResponse
    {
        try {
            $recurring_expense->update(['status' => 'cancelled']);

            return redirect()
                ->route('admin.finance.recurring-expenses.index')
                ->with('success', 'Recurring expense cancelled.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function toggleStatus(RecurringExpense $recurring_expense): RedirectResponse
    {
        $newStatus = $recurring_expense->isActive() ? 'paused' : 'active';
        $recurring_expense->update(['status' => $newStatus]);

        return redirect()->back()->with('success', 'Recurring expense ' . $newStatus . '!');
    }
}
