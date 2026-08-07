<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute as CastAttribute;
use Illuminate\Support\Str;

class Attribute extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'type',
        'is_filterable',
        'is_required',
        'is_searchable',
        'sort_order',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'is_filterable' => 'boolean',
            'is_required' => 'boolean',
            'is_searchable' => 'boolean',
            'status' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    // ==================== Relationships ====================

    public function values(): HasMany
    {
        return $this->hasMany(AttributeValue::class)->orderBy('sort_order');
    }

    public function activeValues(): HasMany
    {
        return $this->hasMany(AttributeValue::class)->where('status', true)->orderBy('sort_order');
    }

    // ==================== Types ====================

    public const TYPE_TEXT = 'text';
    public const TYPE_SELECT = 'select';
    public const TYPE_MULTISELECT = 'multiselect';
    public const TYPE_BOOLEAN = 'boolean';
    public const TYPE_DATE = 'date';
    public const TYPE_DATETIME = 'datetime';
    public const TYPE_NUMBER = 'number';
    public const TYPE_COLOR = 'color';

    public static function types(): array
    {
        return [
            self::TYPE_TEXT => 'Text',
            self::TYPE_SELECT => 'Select',
            self::TYPE_MULTISELECT => 'Multi Select',
            self::TYPE_BOOLEAN => 'Yes/No',
            self::TYPE_DATE => 'Date',
            self::TYPE_DATETIME => 'Date & Time',
            self::TYPE_NUMBER => 'Number',
            self::TYPE_COLOR => 'Color',
        ];
    }

    // ==================== Scopes ====================

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeFilterable($query)
    {
        return $query->where('is_filterable', true);
    }

    public function scopeSearchable($query)
    {
        return $query->where('is_searchable', true);
    }

    public function scopeSorted($query)
    {
        return $query->orderBy('sort_order');
    }

    // ==================== Boot ====================

    protected static function booted(): void
    {
        static::creating(function (Attribute $attribute) {
            if (empty($attribute->slug)) {
                $attribute->slug = Str::slug($attribute->name);
            }
        });
    }
}
