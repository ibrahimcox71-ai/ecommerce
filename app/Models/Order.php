<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Models\Scopes\OrderScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Cache;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'cart_id',
        'coupon_id',
        'order_number',
        'order_origin',
        'status',
        'subtotal',
        'coupon_discount',
        'shipping_cost',
        'tax_rate',
        'tax_amount',
        'total',
        'paid_amount',
        'payment_status',
        'shipping_method',
        'shipping_address',
        'billing_address',
        'notes',
        'currency',
        'invoice_number',
        'invoice_at',
        'paid_at',
        'shipped_at',
        'shipping_at',
        'delivered_at',
        'cancelled_at',
        'cancel_reason',
        'confirmed_at',
        'packing_at',
        'returned_at',
        'refunded_at',
        'tracking_number',
        'tracking_url',
        'carrier',
        'ready_to_ship_at',
        'out_for_delivery_at',
        'completed_at',
        'estimated_delivery',
    ];

    protected function casts(): array
    {
        return [
            'subtotal' => 'decimal:2',
            'coupon_discount' => 'decimal:2',
            'shipping_cost' => 'decimal:2',
            'tax_rate' => 'decimal:2',
            'tax_amount' => 'decimal:2',
            'total' => 'decimal:2',
            'paid_amount' => 'decimal:2',
            'shipping_address' => 'array',
            'billing_address' => 'array',
            'invoice_at' => 'datetime',
            'paid_at' => 'datetime',
            'shipped_at' => 'datetime',
            'shipping_at' => 'datetime',
            'delivered_at' => 'datetime',
            'cancelled_at' => 'datetime',
            'confirmed_at' => 'datetime',
            'packing_at' => 'datetime',
            'returned_at' => 'datetime',
            'refunded_at' => 'datetime',
            'ready_to_ship_at' => 'datetime',
            'out_for_delivery_at' => 'datetime',
            'completed_at' => 'datetime',
            'estimated_delivery' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    public function returns(): HasMany
    {
        return $this->hasMany(OrderReturn::class);
    }

    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class, 'subject_id')
            ->where('subject_type', static::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeProcessing($query)
    {
        return $query->where('status', 'processing');
    }

    public function scopePacking($query)
    {
        return $query->where('status', 'packing');
    }

    public function scopeReadyToShip($query)
    {
        return $query->where('status', 'ready_to_ship');
    }

    public function scopeShipping($query)
    {
        return $query->where('status', 'shipping');
    }

    public function scopeOutForDelivery($query)
    {
        return $query->where('status', 'out_for_delivery');
    }

    public function scopeDelivered($query)
    {
        return $query->where('status', 'delivered');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    public function scopeReturned($query)
    {
        return $query->where('status', 'returned');
    }

    public function scopeRefunded($query)
    {
        return $query->where('status', 'refunded');
    }

    public function scopeByUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByOrigin($query, string $origin)
    {
        return $query->where('order_origin', $origin);
    }

    public function scopeByDateRange($query, $start, $end)
    {
        return $query->whereBetween('created_at', [$start, $end]);
    }

    public function scopeSearch($query, string $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('order_number', 'LIKE', "%{$term}%")
              ->orWhere('invoice_number', 'LIKE', "%{$term}%")
              ->orWhere('tracking_number', 'LIKE', "%{$term}%")
              ->orWhere('shipping_address->name', 'LIKE', "%{$term}%")
              ->orWhere('shipping_address->email', 'LIKE', "%{$term}%")
              ->orWhere('shipping_address->phone', 'LIKE', "%{$term}%");
        });
    }

    public function scopePaymentPending($query)
    {
        return $query->where('payment_status', 'pending');
    }

    public function scopePaymentPaid($query)
    {
        return $query->where('payment_status', 'paid');
    }

    public function scopePaymentFailed($query)
    {
        return $query->where('payment_status', 'failed');
    }

    public function scopePaymentPartial($query)
    {
        return $query->where('payment_status', 'partial');
    }

    public function scopePaymentRefunded($query)
    {
        return $query->where('payment_status', 'refunded');
    }

    public function isPaid(): bool
    {
        return $this->payment_status === 'paid';
    }

    public function isPartialPaid(): bool
    {
        return $this->payment_status === 'partial';
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

    public function isCancellable(): bool
    {
        return in_array($this->status, ['pending', 'confirmed', 'processing']);
    }

    public function isReturnable(): bool
    {
        return in_array($this->status, ['delivered', 'completed']);
    }

    public function isEditable(): bool
    {
        return in_array($this->status, ['pending', 'confirmed']);
    }

    public function isDeletable(): bool
    {
        return in_array($this->status, ['pending', 'cancelled']);
    }

    public function isHoldable(): bool
    {
        return in_array($this->status, ['pending', 'confirmed', 'processing']);
    }

    public function isDuplicateable(): bool
    {
        return true;
    }

    public function statusBadge(): string
    {
        return OrderStatus::tryFrom($this->status)?->badgeClass() ?? 'bg-light text-dark';
    }

    public function paymentStatusBadge(): string
    {
        return match ($this->payment_status) {
            'paid' => 'bg-success',
            'partial' => 'bg-info',
            'pending' => 'bg-warning text-dark',
            'failed' => 'bg-danger',
            'refunded' => 'bg-secondary',
            default => 'bg-light text-dark',
        };
    }

    public function hasTracking(): bool
    {
        return !is_null($this->tracking_number);
    }

    public function getTrackingUrlAttribute($value): ?string
    {
        return $value;
    }

    public function getItemCount(): int
    {
        return $this->items->sum('quantity');
    }

    public function getDueAmount(): float
    {
        return max(0, $this->total - $this->paid_amount);
    }

    public function isOverdue(): bool
    {
        return $this->payment_status === 'pending' && $this->created_at->diffInDays(now()) > 7;
    }

    public static function getStatusCounts(): array
    {
        return Cache::remember('order_status_counts', 300, function () {
            $counts = static::selectRaw("
                COUNT(*) as all_count,
                SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN status = 'confirmed' THEN 1 ELSE 0 END) as confirmed,
                SUM(CASE WHEN status = 'processing' THEN 1 ELSE 0 END) as processing,
                SUM(CASE WHEN status = 'packing' THEN 1 ELSE 0 END) as packing,
                SUM(CASE WHEN status = 'ready_to_ship' THEN 1 ELSE 0 END) as ready_to_ship,
                SUM(CASE WHEN status = 'shipping' THEN 1 ELSE 0 END) as shipping,
                SUM(CASE WHEN status = 'out_for_delivery' THEN 1 ELSE 0 END) as out_for_delivery,
                SUM(CASE WHEN status = 'delivered' THEN 1 ELSE 0 END) as delivered,
                SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed,
                SUM(CASE WHEN status = 'cancelled' THEN 1 ELSE 0 END) as cancelled,
                SUM(CASE WHEN status = 'returned' THEN 1 ELSE 0 END) as returned,
                SUM(CASE WHEN status = 'refunded' THEN 1 ELSE 0 END) as refunded,
                SUM(CASE WHEN payment_status = 'pending' THEN 1 ELSE 0 END) as payment_pending,
                SUM(CASE WHEN payment_status = 'paid' THEN 1 ELSE 0 END) as payment_paid,
                SUM(CASE WHEN payment_status = 'failed' THEN 1 ELSE 0 END) as payment_failed,
                SUM(CASE WHEN payment_status = 'partial' THEN 1 ELSE 0 END) as payment_partial
            ")->first();

            return [
                'all' => (int) ($counts->all_count ?? 0),
                'pending' => (int) ($counts->pending ?? 0),
                'confirmed' => (int) ($counts->confirmed ?? 0),
                'processing' => (int) ($counts->processing ?? 0),
                'packing' => (int) ($counts->packing ?? 0),
                'ready_to_ship' => (int) ($counts->ready_to_ship ?? 0),
                'shipping' => (int) ($counts->shipping ?? 0),
                'out_for_delivery' => (int) ($counts->out_for_delivery ?? 0),
                'delivered' => (int) ($counts->delivered ?? 0),
                'completed' => (int) ($counts->completed ?? 0),
                'cancelled' => (int) ($counts->cancelled ?? 0),
                'returned' => (int) ($counts->returned ?? 0),
                'refunded' => (int) ($counts->refunded ?? 0),
                'payment_pending' => (int) ($counts->payment_pending ?? 0),
                'payment_paid' => (int) ($counts->payment_paid ?? 0),
                'payment_failed' => (int) ($counts->payment_failed ?? 0),
                'payment_partial' => (int) ($counts->payment_partial ?? 0),
            ];
        });
    }
}
