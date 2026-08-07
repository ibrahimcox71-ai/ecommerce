<?php

namespace App\Models;

use App\Traits\HasImageAccessors;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

class ProductImage extends Model
{
    use HasImageAccessors;
    protected $fillable = [
        'product_id',
        'image',
        'alt_text',
        'title',
        'sort_order',
        'is_primary',
    ];

    protected function casts(): array
    {
        return [
            'is_primary' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    // ==================== Relationships ====================

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // ==================== Accessors ====================

    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->image ? asset("storage/{$this->image}") : null
        );
    }

    protected function thumbUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->image ? asset("storage/{$this->image}") : null
        );
    }

    // ==================== Methods ====================

    public static function setPrimary($productId, $imageId): void
    {
        // Unset all primary for this product
        self::where('product_id', $productId)->update(['is_primary' => false]);
        
        // Set new primary
        self::where('id', $imageId)->update(['is_primary' => true]);
    }

    // ==================== Scopes ====================

    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}
