<?php

namespace App\Services;

use App\Models\Budget;
use App\Models\BudgetItem;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\RecurringExpense;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ExpenseService
{
    public function createExpense(array $data): Expense
    {
        return DB::transaction(function () use ($data) {
            $data['expense_number'] = Expense::generateExpenseNumber();
            $data['created_by'] = auth()->guard('admin')->id();

            $data['total_amount'] = ($data['amount'] ?? 0) + ($data['tax_amount'] ?? 0);

            if (isset($data['receipt']) && $data['receipt'] instanceof \Illuminate\Http\UploadedFile) {
                $data['receipt'] = $data['receipt']->store('expenses/receipts', 'public');
            }

            $expense = Expense::create($data);

            $this->updateBudgets($expense);

            return $expense->fresh(['category', 'creator', 'chartOfAccount']);
        });
    }

    public function updateExpense(int $id, array $data): Expense
    {
        return DB::transaction(function () use ($id, $data) {
            $expense = Expense::findOrFail($id);

            if (!$expense->isEditable()) {
                throw new \RuntimeException('Expense cannot be edited in current status.');
            }

            $data['total_amount'] = ($data['amount'] ?? $expense->amount) + ($data['tax_amount'] ?? $expense->tax_amount);

            if (isset($data['receipt']) && $data['receipt'] instanceof \Illuminate\Http\UploadedFile) {
                if ($expense->receipt) {
                    Storage::disk('public')->delete($expense->receipt);
                }
                $data['receipt'] = $data['receipt']->store('expenses/receipts', 'public');
            }

            $expense->update($data);

            return $expense->fresh(['category', 'creator', 'chartOfAccount']);
        });
    }

    public function approve(int $id): Expense
    {
        return DB::transaction(function () use ($id) {
            $expense = Expense::findOrFail($id);

            if (!$expense->isApprovable()) {
                throw new \RuntimeException('Expense cannot be approved in current status.');
            }

            $expense->update([
                'status' => 'approved',
                'approved_by' => auth()->guard('admin')->id(),
                'approved_at' => now(),
            ]);

            $this->updateBudgets($expense);

            return $expense->fresh();
        });
    }

    public function cancel(int $id): Expense
    {
        return DB::transaction(function () use ($id) {
            $expense = Expense::findOrFail($id);

            if (!$expense->isEditable()) {
                throw new \RuntimeException('Expense cannot be cancelled in current status.');
            }

            $expense->update(['status' => 'cancelled']);

            return $expense->fresh();
        });
    }

    public function processRecurring(): array
    {
        $processed = [];

        RecurringExpense::due()->chunk(50, function ($recurrings) use (&$processed) {
            foreach ($recurrings as $recurring) {
                try {
                    DB::transaction(function () use ($recurring, &$processed) {
                        $expense = Expense::create([
                            'expense_number' => Expense::generateExpenseNumber(),
                            'expense_category_id' => $recurring->expense_category_id,
                            'amount' => $recurring->amount,
                            'total_amount' => $recurring->amount,
                            'currency' => $recurring->currency,
                            'expense_date' => now()->format('Y-m-d'),
                            'payee' => $recurring->payee,
                            'payment_method' => $recurring->payment_method,
                            'description' => $recurring->description . ' (Recurring)',
                            'notes' => $recurring->notes,
                            'status' => 'approved',
                            'chart_of_account_id' => $recurring->chart_of_account_id,
                            'created_by' => $recurring->created_by,
                            'approved_by' => $recurring->created_by,
                            'approved_at' => now(),
                        ]);

                        $occurrences = $recurring->occurrences + 1;
                        $updateData = ['occurrences' => $occurrences];

                        if ($recurring->max_occurrences && $occurrences >= $recurring->max_occurrences) {
                            $updateData['status'] = 'completed';
                            $updateData['end_date'] = now()->format('Y-m-d');
                        }

                        $intervalDays = (new \App\Enums\RecurringInterval($recurring->interval))->days() * $recurring->interval_count;
                        $updateData['next_due_date'] = now()->addDays($intervalDays)->format('Y-m-d');

                        $recurring->update($updateData);

                        $processed[] = $expense->id;
                    });
                } catch (\Exception $e) {
                    report($e);
                }
            }
        });

        return $processed;
    }

    protected function updateBudgets(Expense $expense): void
    {
        if ($expense->status !== 'approved') {
            return;
        }

        $budgets = Budget::active()
            ->where('start_date', '<=', $expense->expense_date)
            ->where('end_date', '>=', $expense->expense_date)
            ->get();

        foreach ($budgets as $budget) {
            $budgetItem = $budget->items()
                ->where('expense_category_id', $expense->expense_category_id)
                ->first();

            if ($budgetItem) {
                $newSpent = $budgetItem->spent_amount + $expense->total_amount;
                $budgetItem->update([
                    'spent_amount' => $newSpent,
                    'remaining_amount' => $budgetItem->budgeted_amount - $newSpent,
                ]);

                $totalSpent = $budget->items()->sum('spent_amount');
                $budget->update([
                    'total_spent' => $totalSpent,
                    'total_remaining' => $budget->total_budget - $totalSpent,
                ]);
            }
        }
    }
}
