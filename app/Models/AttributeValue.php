<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

class AttributeValue extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'attribute_id',
        'value',
        'slug',
        'color',
        'image',
        'sort_order',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    // ==================== Relationships ====================

    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class);
    }

    public function variants(): BelongsToMany
    {
        return $this->belongsToMany(ProductVariant::class, 'product_variant_attribute_values')
            ->withPivot(['custom_value'])
            ->withTimestamps();
    }

    // ==================== Accessors ====================

    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->image ? asset("storage/{$this->image}") : null
        );
    }

    protected function colorHex(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->color ?? '#000000'
        );
    }

    // ==================== Scopes ====================

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeSorted($query)
    {
        return $query->orderBy('sort_order');
    }

    // ==================== Boot ====================

    protected static function booted(): void
    {
        static::creating(function (AttributeValue $value) {
            if (empty($value->slug)) {
                $value->slug = Str::slug($value->value);
            }
            
            // Ensure unique slug within attribute
            $originalSlug = $value->slug;
            $counter = 1;
            while (
                self::where('attribute_id', $value->attribute_id)
                    ->where('slug', $value->slug)
                    ->exists()
            ) {
                $value->slug = $originalSlug . '-' . $counter++;
            }
        });
    }
}
