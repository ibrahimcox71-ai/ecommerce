<?php

namespace App\Models;

use App\Traits\HasCreatedBy;
use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class RecurringExpense extends Model
{
    use HasFactory, SoftDeletes, LogsActivity, HasCreatedBy;

    protected $fillable = [
        'expense_category_id',
        'amount',
        'currency',
        'interval',
        'interval_count',
        'start_date',
        'end_date',
        'next_due_date',
        'payee',
        'payment_method',
        'description',
        'notes',
        'status',
        'occurrences',
        'max_occurrences',
        'chart_of_account_id',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'interval_count' => 'integer',
            'start_date' => 'date',
            'end_date' => 'date',
            'next_due_date' => 'date',
            'occurrences' => 'integer',
            'max_occurrences' => 'integer',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ExpenseCategory::class, 'expense_category_id');
    }

    public function chartOfAccount(): BelongsTo
    {
        return $this->belongsTo(ChartOfAccount::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeDue($query)
    {
        return $query->where('status', 'active')
            ->where('next_due_date', '<=', now());
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isPaused(): bool
    {
        return $this->status === 'paused';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    public function activityLogTitle(): string
    {
        return $this->description ?? 'Recurring #' . $this->id;
    }
}
