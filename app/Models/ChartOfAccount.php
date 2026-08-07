<?php

namespace App\Models;

use App\Traits\HasCache;
use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChartOfAccount extends Model
{
    use HasFactory, SoftDeletes, LogsActivity, HasCache;

    protected $fillable = [
        'code',
        'name',
        'type',
        'normal_balance',
        'category',
        'description',
        'is_active',
        'is_default',
        'opening_balance',
        'current_balance',
        'parent_id',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'is_default' => 'boolean',
            'opening_balance' => 'decimal:2',
            'current_balance' => 'decimal:2',
        ];
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function journalEntryItems(): HasMany
    {
        return $this->hasMany(JournalEntryItem::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function scopeParents($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeIncomeStatement($query)
    {
        return $query->whereIn('type', ['revenue', 'contra_revenue', 'expense', 'contra_expense']);
    }

    public function scopeBalanceSheet($query)
    {
        return $query->whereIn('type', ['asset', 'contra_asset', 'liability', 'contra_liability', 'equity', 'contra_equity']);
    }

    public function activityLogTitle(): string
    {
        return $this->name . ' (' . $this->code . ')';
    }
}
