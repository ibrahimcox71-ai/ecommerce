<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductVariantAttributeValue extends Model
{
    protected $fillable = [
        'product_variant_id',
        'attribute_id',
        'attribute_value_id',
        'custom_value',
    ];

    // ==================== Relationships ====================

    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class);
    }

    public function attributeValue(): BelongsTo
    {
        return $this->belongsTo(AttributeValue::class);
    }

    // ==================== Accessors ====================

    public function getDisplayValueAttribute(): string
    {
        if ($this->custom_value) {
            return $this->custom_value;
        }
        
        return $this->attributeValue?->value ?? '';
    }
}
