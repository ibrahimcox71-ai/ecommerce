<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Inventory extends Model
{
    protected $fillable = [
        'product_id',
        'product_variant_id',
        'warehouse_id',
        'quantity',
        'reserved_quantity',
        'incoming_stock',
        'damaged_stock',
        'returned_stock',
        'low_stock_threshold',
        'minimum_stock',
        'maximum_stock',
        'reorder_level',
        'last_stock_adjustment',
        'last_stock_update',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'reserved_quantity' => 'integer',
            'incoming_stock' => 'integer',
            'damaged_stock' => 'integer',
            'returned_stock' => 'integer',
            'low_stock_threshold' => 'integer',
            'minimum_stock' => 'integer',
            'maximum_stock' => 'integer',
            'reorder_level' => 'integer',
            'last_stock_update' => 'datetime',
        ];
    }

    // ==================== Relationships ====================

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function stockMovements(): HasMany
    {
        return $this->hasMany(StockMovement::class, 'product_id', 'product_id');
    }

    // ==================== Accessors ====================

    protected function incomingQuantity(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->incoming_stock
        );
    }

    protected function damagedQuantity(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->damaged_stock
        );
    }

    protected function returnedQuantity(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->returned_stock
        );
    }

    protected function netStock(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->quantity - $this->reserved_quantity + $this->incoming_stock - $this->damaged_stock
        );
    }

    protected function needsReorder(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->reorder_level > 0 && $this->available_quantity <= $this->reorder_level
        );
    }

    protected function availableQuantity(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->quantity - $this->reserved_quantity
        );
    }

    protected function isLowStock(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->available_quantity <= $this->low_stock_threshold
        );
    }

    protected function isOutOfStock(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->available_quantity <= 0
        );
    }

    // ==================== Methods ====================

    public function reserve(int $quantity): bool
    {
        if ($this->available_quantity < $quantity) {
            return false;
        }

        $this->increment('reserved_quantity', $quantity);
        $this->logChange('reserve', $quantity, 'Reserved for order');
        
        return true;
    }

    public function release(int $quantity): void
    {
        $released = min($quantity, $this->reserved_quantity);
        $this->decrement('reserved_quantity', $released);
        $this->logChange('release', $released, 'Released from order');
    }

    public function add(int $quantity, string $reason = 'Manual adjustment', ?int $referenceId = null, ?string $note = null): void
    {
        $this->increment('quantity', $quantity);
        $this->update([
            'last_stock_adjustment' => $reason,
            'last_stock_update' => now(),
        ]);
        
        $this->logChange('add', $quantity, $reason, $referenceId, $note);
    }

    public function subtract(int $quantity, string $reason = 'Manual adjustment', ?int $referenceId = null, ?string $note = null): bool
    {
        if ($this->quantity < $quantity) {
            return false;
        }

        $this->decrement('quantity', $quantity);
        $this->update([
            'last_stock_adjustment' => $reason,
            'last_stock_update' => now(),
        ]);
        
        $this->logChange('subtract', -$quantity, $reason, $referenceId, $note);
        
        return true;
    }

    protected function logChange(string $type, int $quantity, string $reason, ?int $referenceId = null, ?string $note = null): void
    {
        InventoryLog::create([
            'product_id' => $this->product_id,
            'product_variant_id' => $this->product_variant_id,
            'warehouse_id' => $this->warehouse_id,
            'quantity_before' => $this->quantity - $quantity,
            'quantity_after' => $this->quantity,
            'quantity_change' => $quantity,
            'reason' => $reason,
            'note' => $note,
            'reference_type' => $type,
            'reference_id' => $referenceId,
            'causer_type' => auth()->guard('admin')->check() ? Admin::class : null,
            'causer_id' => auth()->guard('admin')->id(),
        ]);
    }

    // ==================== Scopes ====================

    public function scopeLowStock($query)
    {
        return $query->whereRaw('(quantity - reserved_quantity) <= low_stock_threshold')
            ->whereRaw('(quantity - reserved_quantity) > 0');
    }

    public function scopeOutOfStock($query)
    {
        return $query->whereRaw('(quantity - reserved_quantity) <= 0');
    }

    public function scopeInStock($query)
    {
        return $query->whereRaw('(quantity - reserved_quantity) > 0');
    }

    public function scopeForWarehouse($query, $warehouseId)
    {
        return $query->where('warehouse_id', $warehouseId);
    }

    public function scopeForProduct($query, $productId, $variantId = null)
    {
        $query->where('product_id', $productId);
        
        if ($variantId !== null) {
            $query->where('product_variant_id', $variantId);
        } else {
            $query->whereNull('product_variant_id');
        }
        
        return $query;
    }
}
