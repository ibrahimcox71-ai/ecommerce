<?php

namespace App\Models;

use App\Traits\HasCreatedBy;
use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class JournalEntry extends Model
{
    use HasFactory, SoftDeletes, LogsActivity, HasCreatedBy;

    protected $fillable = [
        'entry_number',
        'type',
        'description',
        'entry_date',
        'total_debit',
        'total_credit',
        'is_posted',
        'posted_at',
        'posted_by',
        'reference_type',
        'reference_id',
        'finance_period_id',
        'notes',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'entry_date' => 'date',
            'total_debit' => 'decimal:2',
            'total_credit' => 'decimal:2',
            'is_posted' => 'boolean',
            'posted_at' => 'datetime',
        ];
    }

    public function items(): HasMany
    {
        return $this->hasMany(JournalEntryItem::class);
    }

    public function postedBy(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'posted_by');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function financePeriod(): BelongsTo
    {
        return $this->belongsTo(FinancePeriod::class);
    }

    public function isBalanced(): bool
    {
        return $this->total_debit === $this->total_credit;
    }

    public function isPosted(): bool
    {
        return $this->is_posted;
    }

    public function scopePosted($query)
    {
        return $query->where('is_posted', true);
    }

    public function scopeUnposted($query)
    {
        return $query->where('is_posted', false);
    }

    public function scopeByDateRange($query, $start, $end)
    {
        return $query->whereBetween('entry_date', [$start, $end]);
    }

    public static function generateEntryNumber(): string
    {
        $prefix = 'JE';
        $year = now()->format('Y');
        $month = now()->format('m');

        $last = self::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->lockForUpdate()
            ->orderBy('id', 'desc')
            ->first();

        $sequence = $last ? (int) substr($last->entry_number, -4) + 1 : 1;

        return sprintf('%s-%s%s-%04d', $prefix, $year, $month, $sequence);
    }

    public function activityLogTitle(): string
    {
        return $this->entry_number;
    }
}
