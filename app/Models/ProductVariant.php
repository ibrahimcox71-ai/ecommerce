<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

class ProductVariant extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'product_id',
        'name',
        'sku',
        'barcode',
        'price',
        'discount',
        'cost_price',
        'stock',
        'unlimited_stock',
        'image',
        'status',
        'weight',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
            'unlimited_stock' => 'boolean',
            'price' => 'decimal:2',
            'discount' => 'decimal:2',
            'cost_price' => 'decimal:2',
            'weight' => 'decimal:2',
            'stock' => 'integer',
            'sort_order' => 'integer',
        ];
    }

    // ==================== Relationships ====================

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function attributeValues(): BelongsToMany
    {
        return $this->belongsToMany(AttributeValue::class, 'product_variant_attribute_values')
            ->withPivot(['attribute_id', 'custom_value'])
            ->withTimestamps();
    }
        
    public function variantAttributes(): HasMany
    {
        return $this->hasMany(ProductVariantAttributeValue::class);
    }

    // ==================== Accessors ====================

    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->image ? asset("storage/{$this->image}") : null
        );
    }

    protected function currentPrice(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->price !== null) {
                    $price = $this->price;
                } else {
                    $price = $this->product->price;
                }
                
                if ($this->discount > 0) {
                    return $price - $this->discount;
                }
                
                return $price;
            }
        );
    }

    protected function isInStock(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->unlimited_stock || $this->stock > 0
        );
    }

    // ==================== Methods ====================

    public function getFinalPrice(): float
    {
        return $this->current_price;
    }

    public function hasStock(int $quantity = 1): bool
    {
        if ($this->unlimited_stock) {
            return true;
        }
        
        return $this->stock >= $quantity;
    }

    public function getAttributesList(): string
    {
        return $this->attributeValues
            ->map(fn ($av) => $av->value)
            ->join(' / ');
    }

    public function generateSku(): string
    {
        $productSku = $this->product->sku ?? 'VAR';
        $attrs = $this->attributeValues->pluck('slug')->join('-');
        
        return "{$productSku}-" . strtoupper($attrs ?: Str::random(4));
    }

    // ==================== Scopes ====================

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeInStock($query)
    {
        return $query->where(function ($q) {
            $q->where('unlimited_stock', true)
              ->orWhere('stock', '>', 0);
        });
    }

    public function scopeSorted($query)
    {
        return $query->orderBy('sort_order');
    }
}
