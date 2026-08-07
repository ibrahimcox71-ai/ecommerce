<?php

namespace App\Models;

use App\Enums\ProductStatus;
use App\Traits\HasImageAccessors;
use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory, SoftDeletes, HasImageAccessors, LogsActivity;

    protected bool $logForceDelete = true;

    protected $fillable = [
        'name',
        'slug',
        'sku',
        'barcode',
        'product_type',
        'category_id',
        'sub_category_id',
        'child_category_id',
        'brand_id',
        'description',
        'short_description',
        'thumbnail',
        'video_url',
        'price',
        'cost_price',
        'tax',
        'tax_type',
        'currency',
        'discount',
        'discount_type',
        'discount_start',
        'discount_end',
        'stock',
        'unlimited_stock',
        'low_stock_threshold',
        'min_stock',
        'status',
        'featured',
        'trending',
        'best_seller',
        'is_hidden',
        'is_new_arrival',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical_url',
        'og_image',
        'schema_markup',
        'tags',
        'specifications',
        'weight',
        'weight_unit',
        'length',
        'width',
        'height',
        'dimension_unit',
        'warranty_type',
        'warranty_period',
        'is_virtual',
        'download_link',
        'min_order_quantity',
        'max_order_quantity',
        'seo_score',
        'sort_order',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'status' => ProductStatus::class,
            'featured' => 'boolean',
            'trending' => 'boolean',
            'best_seller' => 'boolean',
            'is_hidden' => 'boolean',
            'is_new_arrival' => 'boolean',
            'unlimited_stock' => 'boolean',
            'is_virtual' => 'boolean',
            'price' => 'decimal:2',
            'cost_price' => 'decimal:2',
            'tax' => 'decimal:2',
            'discount' => 'decimal:2',
            'discount_type' => 'string',
            'tax_type' => 'string',
            'currency' => 'string',
            'product_type' => 'string',
            'discount_start' => 'datetime',
            'discount_end' => 'datetime',
            'tags' => 'array',
            'specifications' => 'array',
            'weight' => 'decimal:2',
            'length' => 'decimal:2',
            'width' => 'decimal:2',
            'height' => 'decimal:2',
            'warranty_period' => 'integer',
            'min_order_quantity' => 'integer',
            'max_order_quantity' => 'integer',
            'min_stock' => 'integer',
            'seo_score' => 'integer',
            'sort_order' => 'integer',
            'published_at' => 'datetime',
            'low_stock_threshold' => 'integer',
        ];
    }

    // ==================== Relationships ====================

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function subCategory(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }

    public function childCategory(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class, 'child_category_id');
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function primaryImage(): HasMany
    {
        return $this->hasMany(ProductImage::class)->where('is_primary', true);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class)->orderBy('sort_order');
    }

    public function warehouses(): BelongsToMany
    {
        return $this->belongsToMany(Warehouse::class)
            ->withPivot(['is_default', 'lead_time'])
            ->withTimestamps();
    }

    public function inventories(): HasMany
    {
        return $this->hasMany(Inventory::class);
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'order_items')
            ->withPivot(['quantity', 'price', 'discount'])
            ->withTimestamps();
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    public function activityLogs(): MorphMany
    {
        return $this->morphMany(ActivityLog::class, 'subject');
    }

    // ==================== Accessors ====================

    protected function thumbnailUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->thumbnail ? asset("storage/{$this->thumbnail}") : null
        );
    }

    protected function ogImageUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->og_image ? asset("storage/{$this->og_image}") : $this->thumbnail_url
        );
    }

    protected function currentPrice(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (!$this->discount || !$this->isDiscountActive()) {
                    return $this->price;
                }

                if ($this->discount_type === 'percentage') {
                    return round($this->price - ($this->price * $this->discount / 100), 2);
                }

                return round($this->price - $this->discount, 2);
            }
        );
    }

    protected function salePrice(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->current_price
        );
    }

    protected function discountPercentage(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (!$this->discount || !$this->isDiscountActive()) {
                    return 0;
                }

                if ($this->discount_type === 'percentage') {
                    return $this->discount;
                }

                return $this->price > 0 ? round(($this->discount / $this->price) * 100, 1) : 0;
            }
        );
    }

    protected function isInStock(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->unlimited_stock || $this->stock > 0
        );
    }

    protected function hasDiscount(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->discount > 0 && $this->isDiscountActive()
        );
    }

    protected function isLowStock(): Attribute
    {
        return Attribute::make(
            get: fn () => !$this->unlimited_stock &&
                         $this->stock > 0 &&
                         $this->stock <= $this->low_stock_threshold
        );
    }

    protected function isOutOfStock(): Attribute
    {
        return Attribute::make(
            get: fn () => !$this->unlimited_stock && $this->stock <= 0
        );
    }

    protected function stockQuantity(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->total_stock ?? $this->stock
        );
    }

    protected function isNew(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->is_new_arrival
        );
    }

    protected function isBestSeller(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->best_seller
        );
    }

    protected function isBelowMinStock(): Attribute
    {
        return Attribute::make(
            get: fn () => !$this->unlimited_stock && $this->min_stock > 0 && $this->stock < $this->min_stock
        );
    }

    protected function profit(): Attribute
    {
        return Attribute::make(
            get: fn () => round($this->current_price - $this->cost_price, 2)
        );
    }

    protected function profitMargin(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->cost_price <= 0 || $this->current_price <= 0) {
                    return 0;
                }
                return round((($this->current_price - $this->cost_price) / $this->current_price) * 100, 1);
            }
        );
    }

    protected function priceAfterTax(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->tax <= 0) return $this->current_price;
                if ($this->tax_type === 'inclusive') return $this->current_price;
                return round($this->current_price + ($this->current_price * $this->tax / 100), 2);
            }
        );
    }

    protected function averageRating(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->relationLoaded('reviews')) {
                    $avgRating = $this->reviews->avg('rating');
                } else {
                    $avgRating = $this->reviews()->approved()->avg('rating');
                }
                return $avgRating ? round($avgRating, 1) : 0;
            }
        );
    }

    protected function reviewCount(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->relationLoaded('reviews')) {
                    return $this->reviews->count();
                }
                return $this->reviews()->approved()->count();
            }
        );
    }

    protected function totalStock(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->unlimited_stock) {
                    return null;
                }

                $variantStock = $this->variants()->where('status', true)->sum('stock');
                return $this->stock + $variantStock;
            }
        );
    }

    protected function stockValue(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->cost_price > 0 ? round(($this->total_stock ?? 0) * $this->cost_price, 2) : 0
        );
    }

    // ==================== Methods ====================

    public function isDiscountActive(): bool
    {
        $now = now();

        if ($this->discount_start && $now->lt($this->discount_start)) {
            return false;
        }

        if ($this->discount_end && $now->gt($this->discount_end)) {
            return false;
        }

        return true;
    }

    public function getFinalPrice(): float
    {
        return $this->current_price;
    }

    public function getProfitMargin(): float
    {
        if ($this->cost_price <= 0) {
            return 0;
        }

        return (($this->current_price - $this->cost_price) / $this->current_price) * 100;
    }

    public function hasVariantStock(string $variantId, int $quantity): bool
    {
        $variant = $this->variants()->find($variantId);

        if (!$variant || !$variant->status) {
            return false;
        }

        if ($variant->unlimited_stock) {
            return true;
        }

        return $variant->stock >= $quantity;
    }

    public function hasStock(int $quantity = 1): bool
    {
        if ($this->unlimited_stock) {
            return true;
        }

        return $this->stock >= $quantity;
    }

    public function reserveStock(int $quantity): bool
    {
        if (!$this->hasStock($quantity)) {
            return false;
        }

        $this->decrement('stock', $quantity);
        return true;
    }

    public function releaseStock(int $quantity): void
    {
        $this->increment('stock', $quantity);
    }

    public function generateSku(): string
    {
        $prefix = strtoupper(substr($this->category->slug ?? 'PRD', 0, 3));
        $random = strtoupper(Str::random(6));
        $timestamp = now()->format('ymd');

        return "{$prefix}-{$timestamp}-{$random}";
    }

    public function isVariable(): bool
    {
        return $this->product_type === 'variable';
    }

    public function isDigital(): bool
    {
        return $this->product_type === 'digital' || $this->is_virtual;
    }

    public function isSimple(): bool
    {
        return $this->product_type === 'simple';
    }

    // ==================== Scopes ====================

    public function scopeActive($query)
    {
        return $query->where('status', ProductStatus::Active);
    }

    public function scopeDraft($query)
    {
        return $query->where('status', ProductStatus::Draft);
    }

    public function scopeArchived($query)
    {
        return $query->where('status', ProductStatus::Archived);
    }

    public function scopeHidden($query)
    {
        return $query->where('status', ProductStatus::Hidden);
    }

    public function scopePublished($query)
    {
        return $query->where('status', ProductStatus::Active)
            ->where(function ($q) {
                $q->whereNull('published_at')
                  ->orWhere('published_at', '<=', now());
            });
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeTrending($query)
    {
        return $query->where('trending', true);
    }

    public function scopeBestSeller($query)
    {
        return $query->where('best_seller', true);
    }

    public function scopeNewArrival($query)
    {
        return $query->where('is_new_arrival', true);
    }

    public function scopeSimple($query)
    {
        return $query->where('product_type', 'simple');
    }

    public function scopeVariable($query)
    {
        return $query->where('product_type', 'variable');
    }

    public function scopeDigital($query)
    {
        return $query->where('product_type', 'digital');
    }

    public function scopeInStock($query)
    {
        return $query->where(function ($q) {
            $q->where('unlimited_stock', true)
              ->orWhere('stock', '>', 0)
              ->orWhereHas('variants', function ($vq) {
                  $vq->where('status', true)
                     ->where(function ($svq) {
                         $svq->where('unlimited_stock', true)
                             ->orWhere('stock', '>', 0);
                     });
              });
        });
    }

    public function scopeLowStock($query)
    {
        return $query->where('unlimited_stock', false)
            ->whereColumn('stock', '<=', 'low_stock_threshold')
            ->where('stock', '>', 0);
    }

    public function scopeOutOfStock($query)
    {
        return $query->where('unlimited_stock', false)
            ->where('stock', '<=', 0)
            ->whereDoesntHave('variants', function ($vq) {
                $vq->where('status', true)
                   ->where(function ($svq) {
                       $svq->where('unlimited_stock', true)
                           ->orWhere('stock', '>', 0);
                   });
            });
    }

    public function scopeWithDiscount($query)
    {
        return $query->whereNotNull('discount')
            ->where('discount', '>', 0)
            ->where(function ($q) {
                $q->where(function ($dq) {
                    $dq->where('discount_start', '<=', now())
                       ->orWhereNull('discount_start');
                })
                ->where(function ($dq) {
                    $dq->where('discount_end', '>=', now())
                       ->orWhereNull('discount_end');
                });
            });
    }

    public function scopeSorted($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    public function scopeLatest($query)
    {
        return $query->orderByDesc('created_at');
    }

    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('name', 'like', "%{$term}%")
              ->orWhere('sku', 'like', "%{$term}%")
              ->orWhere('barcode', 'like', "%{$term}%")
              ->orWhere('description', 'like', "%{$term}%")
              ->orWhere('short_description', 'like', "%{$term}%")
              ->orWhereHas('brand', fn ($bq) => $bq->where('name', 'like', "%{$term}%"))
              ->orWhereHas('category', fn ($cq) => $cq->where('name', 'like', "%{$term}%"));
        });
    }

    public function scopeFilterByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeFilterByBrand($query, $brandId)
    {
        return $query->where('brand_id', $brandId);
    }

    public function scopeFilterByPrice($query, $min = null, $max = null)
    {
        if ($min !== null) {
            $query->where('price', '>=', $min);
        }

        if ($max !== null) {
            $query->where('price', '<=', $max);
        }

        return $query;
    }

    public function scopeFilterByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopePriceRange($query, $min, $max)
    {
        return $query->whereBetween('price', [$min, $max]);
    }

    // ==================== Boot ====================

    protected static function booted(): void
    {
        static::creating(function (Product $product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }

            if (empty($product->sku)) {
                $product->sku = $product->generateSku();
            }

            $originalSlug = $product->slug;
            $counter = 1;
            while (Product::withTrashed()->where('slug', $product->slug)->exists()) {
                $product->slug = $originalSlug . '-' . $counter++;
            }

            if ($product->status === ProductStatus::Active && !$product->published_at) {
                $product->published_at = now();
            }
        });

        static::updated(function (Product $product) {
            if ($product->wasChanged('status')) {
                cache()->forget("product_{$product->id}");
            }
        });
    }

    public function activityLogTitle(): string
    {
        return $this->name;
    }
}
