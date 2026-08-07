<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Http\Requests\Finance\StoreBudgetRequest;
use App\Models\Budget;
use App\Models\BudgetItem;
use App\Models\ExpenseCategory;
use App\Services\FinanceReportService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class BudgetController extends Controller
{
    public function __construct(
        protected FinanceReportService $reportService,
    ) {}

    public function index(Request $request): View
    {
        $filters = $request->only(['status', 'period']);

        $budgets = Budget::withCount('items')
            ->when($filters['status'] ?? null, fn($q, $v) => $q->where('status', $v))
            ->when($filters['period'] ?? null, fn($q, $v) => $q->where('period', $v))
            ->latest()
            ->paginate(15);

        return view('admin.finance.budgets.index', compact('budgets', 'filters'));
    }

    public function create(): View
    {
        $categories = ExpenseCategory::active()->orderBy('name')->get(['id', 'name']);

        return view('admin.finance.budgets.create', compact('categories'));
    }

    public function store(StoreBudgetRequest $request): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request) {
                $data = $request->validated();
                $items = $data['items'] ?? [];
                unset($data['items']);

                $totalBudget = collect($items)->sum('budgeted_amount');

                $data['total_budget'] = $totalBudget;
                $data['total_remaining'] = $totalBudget;
                $data['created_by'] = auth()->guard('admin')->id();

                $budget = Budget::create($data);

                foreach ($items as $item) {
                    BudgetItem::create([
                        'budget_id' => $budget->id,
                        'expense_category_id' => $item['expense_category_id'] ?? null,
                        'category_name' => $item['category_name'] ?? ExpenseCategory::find($item['expense_category_id'])?->name ?? 'Unknown',
                        'budgeted_amount' => $item['budgeted_amount'],
                        'spent_amount' => 0,
                        'remaining_amount' => $item['budgeted_amount'],
                        'notes' => $item['notes'] ?? null,
                    ]);
                }
            });

            return redirect()
                ->route('admin.finance.budgets.index')
                ->with('success', 'Budget created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function show(Budget $budget): View
    {
        $budget->load(['items.expenseCategory', 'creator']);

        return view('admin.finance.budgets.show', compact('budget'));
    }

    public function destroy(Budget $budget): RedirectResponse
    {
        try {
            $budget->items()->delete();
            $budget->delete();

            return redirect()
                ->route('admin.finance.budgets.index')
                ->with('success', 'Budget deleted!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function report(Request $request): View
    {
        $budgetId = $request->get('budget_id');
        $data = $this->reportService->budgetVsActualReport($budgetId);
        $budgets = Budget::orderBy('name')->get(['id', 'name']);

        return view('admin.finance.budgets.report', compact('data', 'budgets'));
    }
}
