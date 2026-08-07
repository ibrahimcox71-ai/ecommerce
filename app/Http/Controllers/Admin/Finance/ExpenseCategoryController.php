<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Models\ExpenseCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExpenseCategoryController extends Controller
{
    public function index(): View
    {
        $categories = ExpenseCategory::withCount('expenses')
            ->with('parent')
            ->orderBy('name')
            ->paginate(15);

        return view('admin.finance.expense-categories.index', compact('categories'));
    }

    public function create(): View
    {
        $parentCategories = ExpenseCategory::whereNull('parent_id')->orderBy('name')->get(['id', 'name']);

        return view('admin.finance.expense-categories.create', compact('parentCategories'));
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            $data = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'type' => ['nullable', 'string'],
                'description' => ['nullable', 'string', 'max:1000'],
                'is_active' => ['boolean'],
                'parent_id' => ['nullable', 'integer', 'exists:expense_categories,id'],
            ]);

            ExpenseCategory::create($data);

            return redirect()
                ->route('admin.finance.expense-categories.index')
                ->with('success', 'Expense category created!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function edit(ExpenseCategory $expense_category): View
    {
        $parentCategories = ExpenseCategory::whereNull('parent_id')
            ->where('id', '!=', $expense_category->id)
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('admin.finance.expense-categories.edit', [
            'category' => $expense_category,
            'parentCategories' => $parentCategories,
        ]);
    }

    public function update(Request $request, ExpenseCategory $expense_category): RedirectResponse
    {
        try {
            $data = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'type' => ['nullable', 'string'],
                'description' => ['nullable', 'string', 'max:1000'],
                'is_active' => ['boolean'],
                'parent_id' => ['nullable', 'integer', 'exists:expense_categories,id'],
            ]);

            $expense_category->update($data);

            return redirect()
                ->route('admin.finance.expense-categories.index')
                ->with('success', 'Expense category updated!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function destroy(ExpenseCategory $expense_category): RedirectResponse
    {
        try {
            if ($expense_category->expenses()->exists()) {
                return redirect()->back()->with('error', 'Cannot delete category with associated expenses.');
            }

            $expense_category->delete();

            return redirect()
                ->route('admin.finance.expense-categories.index')
                ->with('success', 'Expense category deleted!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
