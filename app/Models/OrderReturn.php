<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderReturn extends Model
{
    protected $fillable = [
        'order_id',
        'order_item_id',
        'return_number',
        'reason',
        'customer_notes',
        'staff_notes',
        'status',
        'refund_status',
        'refund_amount',
        'quantity',
        'created_by',
        'approved_by',
        'approved_at',
        'rejected_at',
        'refunded_at',
        'rejection_reason',
    ];

    protected function casts(): array
    {
        return [
            'refund_amount' => 'decimal:2',
            'quantity' => 'integer',
            'approved_at' => 'datetime',
            'rejected_at' => 'datetime',
            'refunded_at' => 'datetime',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'approved_by');
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    public function isRefunded(): bool
    {
        return $this->refund_status === 'refunded';
    }

    public function statusBadge(): string
    {
        return match ($this->status) {
            'pending' => 'bg-warning text-dark',
            'approved' => 'bg-success',
            'rejected' => 'bg-danger',
            'refunded' => 'bg-secondary',
            default => 'bg-light text-dark',
        };
    }
}
