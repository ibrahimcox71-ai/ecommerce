<?php

namespace App\Models;

use App\Traits\HasCreatedBy;
use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes, LogsActivity, HasCreatedBy;

    protected $fillable = [
        'transaction_number',
        'type',
        'amount',
        'fee',
        'net_amount',
        'currency',
        'payment_method',
        'reference_number',
        'description',
        'transaction_date',
        'direction',
        'status',
        'reference_type',
        'reference_id',
        'chart_of_account_id',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'fee' => 'decimal:2',
            'net_amount' => 'decimal:2',
            'transaction_date' => 'date',
        ];
    }

    public function chartOfAccount(): BelongsTo
    {
        return $this->belongsTo(ChartOfAccount::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function scopeInflow($query)
    {
        return $query->where('direction', 'inflow');
    }

    public function scopeOutflow($query)
    {
        return $query->where('direction', 'outflow');
    }

    public function scopeByDateRange($query, $start, $end)
    {
        return $query->whereBetween('transaction_date', [$start, $end]);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public static function generateTransactionNumber(): string
    {
        $prefix = 'TXN';
        $year = now()->format('Y');
        $month = now()->format('m');

        $last = self::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->lockForUpdate()
            ->orderBy('id', 'desc')
            ->first();

        $sequence = $last ? (int) substr($last->transaction_number, -4) + 1 : 1;

        return sprintf('%s-%s%s-%04d', $prefix, $year, $month, $sequence);
    }

    public function activityLogTitle(): string
    {
        return $this->transaction_number;
    }
}
