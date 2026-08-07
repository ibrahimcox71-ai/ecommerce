<?php

namespace App\Models;

use App\Enums\ProductStatus;
use App\Traits\HasCache;
use App\Traits\HasImageAccessors;
use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory, SoftDeletes, HasImageAccessors, LogsActivity, HasCache;

    protected static array $cacheKeys = ['category_tree', 'category_parents', 'category_options'];

    protected $fillable = [
        'name',
        'slug',
        'category_code',
        'description',
        'short_description',
        'full_description',
        'image',
        'banner',
        'thumbnail',
        'icon',
        'parent_id',
        'sort_order',
        'status',
        'featured',
        'popular',
        'show_on_homepage',
        'show_in_mega_menu',
        'show_in_mobile_menu',
        'show_in_sidebar',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'seo_image',
        'canonical_url',
        'json_ld',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
            'featured' => 'boolean',
            'popular' => 'boolean',
            'show_on_homepage' => 'boolean',
            'show_in_mega_menu' => 'boolean',
            'show_in_mobile_menu' => 'boolean',
            'show_in_sidebar' => 'boolean',
        ];
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function childrenRecursive(): HasMany
    {
        return $this->children()->with('childrenRecursive');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    public function activeProducts(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id')->where('status', ProductStatus::Active);
    }

    public function outOfStockProducts(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id')
            ->where(function ($q) {
                $q->where('stock', '<=', 0)->orWhereNull('stock');
            });
    }

    public function activityLogs(): MorphMany
    {
        return $this->morphMany(ActivityLog::class, 'subject');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeHidden($query)
    {
        return $query->where('status', 'hidden');
    }

    public function scopeSorted($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('name', 'like', "%{$term}%")
                ->orWhere('short_description', 'like', "%{$term}%")
                ->orWhere('description', 'like', "%{$term}%")
                ->orWhere('slug', 'like', "%{$term}%")
                ->orWhere('category_code', 'like', "%{$term}%");
        });
    }

    public function scopeParents($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopePopular($query)
    {
        return $query->where('popular', true);
    }

    public function scopeHomepage($query)
    {
        return $query->where('show_on_homepage', true);
    }

    public function scopeMegaMenu($query)
    {
        return $query->where('show_in_mega_menu', true);
    }

    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    public function scopeParentId($query, ?int $parentId)
    {
        if ($parentId === null) {
            return $query->whereNull('parent_id');
        }
        return $query->where('parent_id', $parentId);
    }

    public function scopeHasProducts($query)
    {
        return $query->has('products', '>', 0);
    }

    public function scopeDateBetween($query, $start, $end)
    {
        return $query->whereBetween('created_at', [$start, $end]);
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'active' => '<span class="badge bg-success-subtle text-success">Active</span>',
            'inactive' => '<span class="badge bg-secondary-subtle text-secondary">Inactive</span>',
            'draft' => '<span class="badge bg-warning-subtle text-warning">Draft</span>',
            'hidden' => '<span class="badge bg-dark-subtle text-dark">Hidden</span>',
            default => '<span class="badge bg-secondary">' . ucfirst($this->status) . '</span>',
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'active' => 'success',
            'inactive' => 'secondary',
            'draft' => 'warning',
            'hidden' => 'dark',
            default => 'secondary',
        };
    }

    public function getBannerUrlAttribute(): ?string
    {
        return $this->banner ? asset("storage/{$this->banner}") : null;
    }

    public function getThumbnailUrlAttribute(): ?string
    {
        return $this->thumbnail ? asset("storage/{$this->thumbnail}") : null;
    }

    public function getSeoImageUrlAttribute(): ?string
    {
        return $this->seo_image ? asset("storage/{$this->seo_image}") : null;
    }

    public function getProductCountAttribute(): int
    {
        return $this->products()->count();
    }

    public function getActiveProductCountAttribute(): int
    {
        return $this->activeProducts()->count();
    }

    public function getOutOfStockCountAttribute(): int
    {
        return $this->outOfStockProducts()->count();
    }

    public function getChildrenCountAttribute(): int
    {
        return $this->children()->count();
    }

    public function getFullSlugAttribute(): string
    {
        if ($this->parent) {
            return $this->parent->full_slug . '/' . $this->slug;
        }
        return $this->slug;
    }

    public function getAncestorsAttribute()
    {
        $ancestors = collect();
        $parent = $this->parent;
        while ($parent) {
            $ancestors->push($parent);
            $parent = $parent->parent;
        }
        return $ancestors->reverse();
    }

    public function getDescendantIdsAttribute(): array
    {
        $ids = [];
        foreach ($this->children as $child) {
            $ids[] = $child->id;
            $ids = array_merge($ids, $child->descendant_ids);
        }
        return $ids;
    }

    public function getBreadcrumbAttribute(): array
    {
        $crumbs = [];
        $ancestors = $this->ancestors;
        foreach ($ancestors as $ancestor) {
            $crumbs[] = [
                'name' => $ancestor->name,
                'url' => route('admin.categories.show', $ancestor->id),
            ];
        }
        $crumbs[] = [
            'name' => $this->name,
            'url' => route('admin.categories.show', $this->id),
        ];
        return $crumbs;
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isParent(): bool
    {
        return $this->parent_id === null;
    }

    public function hasChildren(): bool
    {
        return $this->children()->exists();
    }

    public function hasProducts(): bool
    {
        return $this->products()->exists();
    }

    public function moveProductsTo(int $targetCategoryId): void
    {
        Product::where('category_id', $this->id)
            ->orWhere('sub_category_id', $this->id)
            ->orWhere('child_category_id', $this->id)
            ->update(['category_id' => $targetCategoryId]);
    }

    public function syncJsonLd(): static
    {
        $jsonLd = [
            '@context' => 'https://schema.org',
            '@type' => 'CategoryCodeSet',
            'name' => $this->name,
            'description' => $this->short_description ?? $this->description,
            'url' => $this->canonical_url ?? url('category/' . $this->slug),
            'identifier' => $this->category_code,
        ];

        if ($this->seo_image) {
            $jsonLd['image'] = $this->seo_image_url;
        }

        $this->json_ld = json_encode($jsonLd, JSON_UNESCAPED_SLASHES);
        return $this;
    }

    public static function getTree(): array
    {
        return Cache::remember('category_tree', config('ecommerce.cache.category_ttl', 3600), function () {
            return static::withCount('products')
                ->with(['childrenRecursive', 'parent'])
                ->parents()
                ->sorted()
                ->get()
                ->map(fn($cat) => static::formatTreeNode($cat))
                ->toArray();
        });
    }

    protected static function formatTreeNode($category): array
    {
        return [
            'id' => $category->id,
            'name' => $category->name,
            'slug' => $category->slug,
            'status' => $category->status,
            'sort_order' => $category->sort_order,
            'product_count' => $category->products_count ?? $category->products()->count(),
            'children' => $category->relationLoaded('childrenRecursive')
                ? $category->childrenRecursive->map(fn($child) => static::formatTreeNode($child))->toArray()
                : [],
        ];
    }

    public static function getParentsCached()
    {
        return Cache::remember('category_parents', config('ecommerce.cache.category_ttl', 3600), function () {
            return static::parents()->active()->sorted()->get();
        });
    }

    public static function getOptionsCached()
    {
        return Cache::remember('category_options', config('ecommerce.cache.category_ttl', 3600), function () {
            return static::active()->sorted()->pluck('name', 'id');
        });
    }

    protected static function booted(): void
    {
        static::creating(function (Category $category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
            if (empty($category->status)) {
                $category->status = 'active';
            }
        });
    }
}
