<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Warehouse extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'manager_name',
        'code',
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        'phone',
        'email',
        'is_default',
        'status',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_default' => 'boolean',
            'status' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    // ==================== Relationships ====================

    public function inventories(): HasMany
    {
        return $this->hasMany(Inventory::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)
            ->withPivot(['is_default', 'lead_time'])
            ->withTimestamps();
    }

    public function stockMovementsFrom(): HasMany
    {
        return $this->hasMany(StockMovement::class, 'from_warehouse_id');
    }

    public function stockMovementsTo(): HasMany
    {
        return $this->hasMany(StockMovement::class, 'to_warehouse_id');
    }

    // ==================== Accessors ====================

    protected function fullAddressAttribute(): string
    {
        $parts = array_filter([
            $this->address,
            $this->city,
            $this->state,
            $this->postal_code,
            $this->country,
        ]);

        return implode(', ', $parts);
    }

    // ==================== Methods ====================

    public static function getDefault(): ?self
    {
        return self::where('is_default', true)->first();
    }

    public function getTotalStock(?int $productId = null, ?int $variantId = null): int
    {
        $query = $this->inventories();
        
        if ($productId) {
            $query->where('product_id', $productId);
        }
        
        if ($variantId) {
            $query->where('product_variant_id', $variantId);
        } elseif ($productId) {
            $query->whereNull('product_variant_id');
        }
        
        return $query->sum('quantity');
    }

    public function getAvailableStock(?int $productId = null, ?int $variantId = null): int
    {
        $query = $this->inventories();
        
        if ($productId) {
            $query->where('product_id', $productId);
        }
        
        if ($variantId) {
            $query->where('product_variant_id', $variantId);
        } elseif ($productId) {
            $query->whereNull('product_variant_id');
        }
        
        return $query->sum(\DB::raw('quantity - reserved_quantity'));
    }

    // ==================== Scopes ====================

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    public function scopeSorted($query)
    {
        return $query->orderBy('is_default', 'desc')
                     ->orderBy('sort_order')
                     ->orderBy('name');
    }
}
