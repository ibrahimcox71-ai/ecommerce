<?php

namespace App\Services;

use App\Models\Setting;
use App\Models\Page;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Blog;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

class SEOService
{
    protected ?Setting $settings;
    protected string $title = '';
    protected string $description = '';
    protected string $canonical = '';
    protected string $ogType = 'website';
    protected ?string $ogImage = null;
    protected ?string $robots = null;
    protected array $schema = [];
    protected array $breadcrumbs = [];
    protected ?object $entity = null;

    public function __construct()
    {
        $this->settings = Setting::getSeoDefaults();
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function setCanonical(string $url): self
    {
        $this->canonical = $url;
        return $this;
    }

    public function setOgType(string $type): self
    {
        $this->ogType = $type;
        return $this;
    }

    public function setOgImage(?string $url): self
    {
        $this->ogImage = $url;
        return $this;
    }

    public function setRobots(string $robots): self
    {
        $this->robots = $robots;
        return $this;
    }

    public function addSchema(array $schema): self
    {
        $this->schema[] = $schema;
        return $this;
    }

    public function setEntity(object $entity): self
    {
        $this->entity = $entity;
        return $this;
    }

    public function addBreadcrumb(string $label, ?string $url = null): self
    {
        $this->breadcrumbs[] = ['label' => $label, 'url' => $url];
        return $this;
    }

    public function forPage(Page $page): self
    {
        $this->title = $page->meta_title ?: $page->title;
        $this->description = $page->meta_description ?: '';
        $this->canonical = $page->canonical_url ?: request()->url();
        $this->ogImage = $page->og_image ? asset("storage/{$page->og_image}") : null;
        if ($page->schema_markup) {
            $this->schema[] = json_decode($page->schema_markup, true) ?: [];
        }
        $this->entity = $page;
        return $this;
    }

    public function forProduct(Product $product): self
    {
        $this->title = $product->meta_title ?: $product->name;
        $this->description = $product->meta_description ?: ($product->short_description ?: '');
        $this->canonical = $product->canonical_url ?: route('product.show', $product->slug);
        $this->ogType = 'product';
        $this->ogImage = $product->thumbnail ? asset("storage/{$product->thumbnail}") : null;
        $this->entity = $product;
        return $this;
    }

    public function forCategory(Category $category): self
    {
        $this->title = $category->meta_title ?: $category->name;
        $this->description = $category->meta_description ?: ($category->description ?: '');
        $this->canonical = route('category.show', $category->slug);
        $this->ogImage = $category->image ? asset("storage/{$category->image}") : null;
        $this->entity = $category;
        return $this;
    }

    public function forBrand(Brand $brand): self
    {
        $this->title = $brand->meta_title ?: $brand->name;
        $this->description = $brand->meta_description ?: ($brand->description ?: '');
        $this->canonical = route('brand.show', $brand->slug);
        $this->ogImage = $brand->image ? asset("storage/{$brand->image}") : null;
        $this->entity = $brand;
        return $this;
    }

    public function forBlog(Blog $blog): self
    {
        $this->title = $blog->meta_title ?: $blog->title;
        $this->description = $blog->meta_description ?: '';
        $this->canonical = route('blog.show', $blog->slug);
        $this->ogType = 'article';
        $this->ogImage = $blog->image ? asset("storage/{$blog->image}") : null;
        $this->entity = $blog;
        return $this;
    }

    public function build(): array
    {
        $siteName = $this->settings->site_name ?: config('app.name');
        $fullTitle = $this->title ? "{$this->title} | {$siteName}" : $siteName;
        $description = $this->description ?: ($this->settings->meta_description ?: '');
        $canonical = $this->canonical ?: request()->url();
        $ogImage = $this->ogImage ?: ($this->settings->og_image ? asset("storage/{$this->settings->og_image}") : null);
        $robots = $this->robots ?: ($this->settings->robots ?? 'index,follow');

        $schemas = $this->buildSchemas($fullTitle, $description, $canonical, $ogImage);

        return [
            'metaTitle' => $fullTitle,
            'metaDescription' => $description,
            'canonicalUrl' => $canonical,
            'ogType' => $this->ogType,
            'ogTitle' => $fullTitle,
            'ogDescription' => $description,
            'ogImage' => $ogImage,
            'ogSiteName' => $siteName,
            'ogUrl' => $canonical,
            'robots' => $robots,
            'schemas' => $schemas,
        ];
    }

    protected function buildSchemas(string $fullTitle, string $description, string $canonical, ?string $ogImage): array
    {
        $schemas = $this->schema;

        $orgName = $this->settings->site_name ?: config('app.name');

        $websiteSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => $orgName,
            'url' => url('/'),
        ];

        if ($description) {
            $websiteSchema['description'] = $description;
        }

        $schemas[] = $websiteSchema;

        if ($this->entity) {
            $entitySchema = $this->buildEntitySchema($fullTitle, $description, $canonical, $ogImage);
            if ($entitySchema) {
                $schemas[] = $entitySchema;
            }
        }

        $schemas[] = [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => $orgName,
            'url' => url('/'),
        ];

        if (!empty($this->breadcrumbs)) {
            $schemas[] = $this->buildBreadcrumbSchema();
        }

        return $schemas;
    }

    protected function buildEntitySchema(string $title, string $description, string $canonical, ?string $ogImage): ?array
    {
        if (!$this->entity) return null;

        $entity = $this->entity;

        if ($entity instanceof Product) {
            $schema = [
                '@context' => 'https://schema.org',
                '@type' => 'Product',
                'name' => $entity->name,
                'url' => $canonical,
                'description' => $description ?: $entity->short_description,
            ];

            if ($ogImage) {
                $schema['image'] = $ogImage;
            }

            if ($entity->brand) {
                $schema['brand'] = [
                    '@type' => 'Brand',
                    'name' => $entity->brand->name,
                ];
            }

            $schema['offers'] = [
                '@type' => 'Offer',
                'url' => $canonical,
                'priceCurrency' => 'USD',
                'price' => number_format($entity->current_price, 2, '.', ''),
                'availability' => $entity->is_in_stock
                    ? 'https://schema.org/InStock'
                    : 'https://schema.org/OutOfStock',
            ];

            if ($entity->average_rating > 0) {
                $schema['aggregateRating'] = [
                    '@type' => 'AggregateRating',
                    'ratingValue' => number_format($entity->average_rating, 1),
                    'reviewCount' => $entity->review_count,
                ];
            }

            return $schema;
        }

        if ($entity instanceof Category) {
            return [
                '@context' => 'https://schema.org',
                '@type' => 'CollectionPage',
                'name' => $entity->name,
                'url' => $canonical,
                'description' => $description ?: $entity->description,
            ];
        }

        if ($entity instanceof Brand) {
            return [
                '@context' => 'https://schema.org',
                '@type' => 'Brand',
                'name' => $entity->name,
                'url' => $canonical,
                'description' => $description ?: $entity->description,
            ];
        }

        if ($entity instanceof Page || $entity instanceof Blog) {
            return [
                '@context' => 'https://schema.org',
                '@type' => $entity instanceof Blog ? 'Article' : 'WebPage',
                'name' => $title,
                'url' => $canonical,
                'description' => $description,
                'datePublished' => $entity->created_at?->toIso8601String(),
                'dateModified' => $entity->updated_at?->toIso8601String(),
            ];
        }

        return null;
    }

    protected function buildBreadcrumbSchema(): array
    {
        $items = [];
        $position = 1;

        foreach ($this->breadcrumbs as $crumb) {
            $item = [
                '@type' => 'ListItem',
                'position' => $position,
                'name' => $crumb['label'],
            ];

            if ($crumb['url']) {
                $item['item'] = $crumb['url'];
            }

            $items[] = $item;
            $position++;
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $items,
        ];
    }

    public function shareWithView(View $view): void
    {
        $seo = $this->build();
        $view->with('seo', $seo);
        $view->with('metaTitle', $seo['metaTitle']);
        $view->with('metaDescription', $seo['metaDescription']);
    }
}
