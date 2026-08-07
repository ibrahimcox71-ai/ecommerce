<?php

namespace App\Models;

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Database\Eloquent\Relations\HasMany;
    use Illuminate\Database\Eloquent\Casts\Attribute;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'session_id',
        'coupon_id',
        'coupon_discount',
        'shipping_cost',
        'tax_rate',
        'tax_amount',
        'subtotal',
        'total',
        'notes',
        'expires_at',
    ];

    protected function casts(): array
    {
        return [
            'coupon_discount' => 'decimal:2',
            'shipping_cost' => 'decimal:2',
            'tax_rate' => 'decimal:2',
            'tax_amount' => 'decimal:2',
            'subtotal' => 'decimal:2',
            'total' => 'decimal:2',
            'expires_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function scopeBySession($query, string $sessionId)
    {
        return $query->where('session_id', $sessionId);
    }

    public function scopeByUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeActive($query)
    {
        return $query->whereNull('expires_at')->orWhere('expires_at', '>', now());
    }

    public function isEmpty(): bool
    {
        return $this->items->isEmpty();
    }

    public function itemCount(): int
    {
        return $this->items->sum('quantity');
    }

    protected function itemsCount(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->itemCount()
        );
    }
}
