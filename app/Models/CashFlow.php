<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashFlow extends Model
{
    protected $fillable = [
        'type',
        'amount',
        'direction',
        'entry_date',
        'description',
        'reference_type',
        'reference_id',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'entry_date' => 'date',
        ];
    }

    public function scopeInflow($query)
    {
        return $query->where('direction', 'inflow');
    }

    public function scopeOutflow($query)
    {
        return $query->where('direction', 'outflow');
    }

    public function scopeByType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByDateRange($query, $start, $end)
    {
        return $query->whereBetween('entry_date', [$start, $end]);
    }
}
