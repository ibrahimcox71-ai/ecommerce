<?php

namespace App\Models;

use App\Traits\HasCreatedBy;
use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use HasFactory, SoftDeletes, LogsActivity, HasCreatedBy;

    protected $fillable = [
        'expense_number',
        'expense_category_id',
        'amount',
        'tax_amount',
        'total_amount',
        'currency',
        'exchange_rate',
        'expense_date',
        'payee',
        'payment_method',
        'reference_number',
        'description',
        'notes',
        'receipt',
        'status',
        'reference_type',
        'reference_id',
        'chart_of_account_id',
        'created_by',
        'approved_by',
        'approved_at',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'tax_amount' => 'decimal:2',
            'total_amount' => 'decimal:2',
            'exchange_rate' => 'decimal:4',
            'expense_date' => 'date',
            'approved_at' => 'datetime',
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

    public function approver(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'approved_by');
    }

    public function scopeByDateRange($query, $start, $end)
    {
        return $query->whereBetween('expense_date', [$start, $end]);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    public function isApprovable(): bool
    {
        return $this->status === 'pending';
    }

    public function isEditable(): bool
    {
        return in_array($this->status, ['pending']);
    }

    public static function generateExpenseNumber(): string
    {
        $prefix = 'EXP';
        $year = now()->format('Y');
        $month = now()->format('m');

        $last = self::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->lockForUpdate()
            ->orderBy('id', 'desc')
            ->first();

        $sequence = $last ? (int) substr($last->expense_number, -4) + 1 : 1;

        return sprintf('%s-%s%s-%04d', $prefix, $year, $month, $sequence);
    }

    public function activityLogTitle(): string
    {
        return $this->expense_number;
    }
}
