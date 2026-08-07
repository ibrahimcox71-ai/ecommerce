<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'payment_method',
        'payment_status',
        'amount',
        'paid_at',
        'transaction_id',
        'gateway_response',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'paid_at' => 'datetime',
            'gateway_response' => 'array',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function isPaid(): bool
    {
        return $this->payment_status === 'paid';
    }

    public function isPending(): bool
    {
        return $this->payment_status === 'pending';
    }

    public function isFailed(): bool
    {
        return $this->payment_status === 'failed';
    }

    public function isRefunded(): bool
    {
        return $this->payment_status === 'refunded';
    }

    public function methodLabel(): string
    {
        return match ($this->payment_method) {
            'cod' => 'Cash on Delivery',
            'bank_transfer' => 'Bank Transfer',
            'stripe' => 'Credit Card (Stripe)',
            'paypal' => 'PayPal',
            'manual' => 'Manual',
            default => ucfirst($this->payment_method),
        };
    }

    public function statusBadge(): string
    {
        return match ($this->payment_status) {
            'paid' => 'bg-success',
            'processing' => 'bg-info',
            'pending' => 'bg-warning text-dark',
            'failed' => 'bg-danger',
            'refunded' => 'bg-secondary',
            'cancelled' => 'bg-dark',
            default => 'bg-light text-dark',
        };
    }

    public function scopePaid($query)
    {
        return $query->where('payment_status', 'paid');
    }

    public function scopePending($query)
    {
        return $query->where('payment_status', 'pending');
    }

    public function scopeFailed($query)
    {
        return $query->where('payment_status', 'failed');
    }

    public function scopeByMethod($query, string $method)
    {
        return $query->where('payment_method', $method);
    }
}

