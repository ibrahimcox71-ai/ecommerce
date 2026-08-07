<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    protected $fillable = [
        'cart_id',
        'product_id',
        'product_variant_id',
        'quantity',
        'unit_price',
        'discount',
        'subtotal',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'unit_price' => 'decimal:2',
            'discount' => 'decimal:2',
            'subtotal' => 'decimal:2',
        ];
    }

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

    public function getProductTitle(): string
    {
        $name = $this->product->name ?? 'Deleted Product';
        if ($this->variant) {
            $name .= ' (' . $this->variant->getAttributesList() . ')';
        }
        return $name;
    }

    public function getProductImage(): ?string
    {
        if ($this->variant?->image) {
            return asset('storage/' . $this->variant->image);
        }
        if ($this->product?->thumbnail) {
            return asset('storage/' . $this->product->thumbnail);
        }
        return $this->product?->images->first()?->image_url;
    }
}
