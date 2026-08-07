<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BudgetItem extends Model
{
    protected $fillable = [
        'budget_id',
        'expense_category_id',
        'category_name',
        'budgeted_amount',
        'spent_amount',
        'remaining_amount',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'budgeted_amount' => 'decimal:2',
            'spent_amount' => 'decimal:2',
            'remaining_amount' => 'decimal:2',
        ];
    }

    public function budget(): BelongsTo
    {
        return $this->belongsTo(Budget::class);
    }

    public function expenseCategory(): BelongsTo
    {
        return $this->belongsTo(ExpenseCategory::class);
    }

    public function getUsagePercentage(): float
    {
        if ($this->budgeted_amount <= 0) {
            return 0;
        }

        return round(($this->spent_amount / $this->budgeted_amount) * 100, 2);
    }

    public function isOverBudget(): bool
    {
        return $this->spent_amount > $this->budgeted_amount;
    }
}
