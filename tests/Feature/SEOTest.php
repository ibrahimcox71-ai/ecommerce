<?php

namespace Tests\Feature;

use App\Models\Setting;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Page;
use App\Services\SEOService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class SEOTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Cache::forget('seo_settings');

        Setting::create([
            'site_name' => 'Test Store',
            'meta_title' => 'Test Store - Best Deals',
            'meta_description' => 'Your one-stop shop for everything.',
            'og_image' => 'seo/og-default.jpg',
            'robots' => 'index,follow',
        ]);
    }

    // ========== Meta Tags ==========

    public function test_home_page_has_meta_title(): void
    {
        $response = $this->get('/');

        $response->assertSee('<title>', false);
    }

    public function test_home_page_has_meta_description(): void
    {
        $response = $this->get('/');

        $response->assertSee('name="description"', false);
    }

    public function test_static_pages_have_unique_meta_titles(): void
    {
        $pages = ['about', 'contact', 'faq', 'blog', 'terms', 'privacy-policy', 'shipping-policy', 'refund-policy'];

        foreach ($pages as $page) {
            $response = $this->get(route($page));
            $response->assertStatus(200);
            $response->assertSee('<title>', false);
        }
    }

    // ========== Canonical ==========

    public function test_home_page_has_canonical_tag(): void
    {
        $response = $this->get('/');

        $response->assertSee('rel="canonical"', false);
    }

    // ========== Schema ==========

    public function test_home_page_has_website_schema(): void
    {
        $response = $this->get('/');

        $response->assertSee('application/ld+json', false);
        $response->assertSee('WebSite', false);
    }

    public function test_home_page_has_organization_schema(): void
    {
        $response = $this->get('/');

        $response->assertSee('Organization', false);
    }

    // ========== Open Graph ==========

    public function test_home_page_has_open_graph_tags(): void
    {
        $response = $this->get('/');

        $response->assertSee('og:title', false);
        $response->assertSee('og:description', false);
        $response->assertSee('og:type', false);
        $response->assertSee('og:url', false);
        $response->assertSee('og:site_name', false);
    }

    public function test_home_page_has_twitter_card_tags(): void
    {
        $response = $this->get('/');

        $response->assertSee('twitter:card', false);
        $response->assertSee('twitter:title', false);
    }

    // ========== Robots ==========

    public function test_home_page_has_robots_meta(): void
    {
        $response = $this->get('/');

        $response->assertSee('name="robots"', false);
    }

    // ========== Sitemap ==========

    public function test_sitemap_xml_returns_successfully(): void
    {
        $response = $this->get('/sitemap.xml');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/xml');
        $response->assertSee('urlset', false);
        $response->assertSee('priority', false);
    }

    public function test_sitemap_contains_static_pages(): void
    {
        $response = $this->get('/sitemap.xml');

        $response->assertSee(route('home'), false);
        $response->assertSee(route('shop'), false);
        $response->assertSee(route('about'), false);
    }

    public function test_sitemap_includes_products(): void
    {
        $category = Category::factory()->create(['status' => true]);
        $product = Product::factory()->create([
            'status' => 'active',
            'category_id' => $category->id,
        ]);

        $response = $this->get('/sitemap.xml');

        $response->assertSee(route('product.show', $product->slug), false);
    }

    public function test_sitemap_includes_categories(): void
    {
        $category = Category::factory()->create(['status' => true]);

        $response = $this->get('/sitemap.xml');

        $response->assertSee(route('category.show', $category->slug), false);
    }

    public function test_sitemap_includes_brands(): void
    {
        $brand = Brand::factory()->create(['status' => true]);

        $response = $this->get('/sitemap.xml');

        $response->assertSee(route('brand.show', $brand->slug), false);
    }

    // ========== Robots.txt ==========

    public function test_robots_txt_returns_successfully(): void
    {
        $response = $this->get('/robots.txt');

        $response->assertStatus(200);
        $this->assertStringContainsString('text/plain', $response->headers->get('Content-Type'));
        $response->assertSee('User-agent', false);
        $response->assertSee('Sitemap', false);
    }

    public function test_robots_txt_contains_sitemap_url(): void
    {
        $response = $this->get('/robots.txt');

        $response->assertSee(route('sitemap'), false);
    }

    // ========== SEOService ==========

    public function test_seo_service_builds_default_data(): void
    {
        $seo = app(SEOService::class);
        $data = $seo->build();

        $this->assertArrayHasKey('metaTitle', $data);
        $this->assertArrayHasKey('metaDescription', $data);
        $this->assertArrayHasKey('canonicalUrl', $data);
        $this->assertArrayHasKey('ogType', $data);
        $this->assertArrayHasKey('ogTitle', $data);
        $this->assertArrayHasKey('robots', $data);
        $this->assertArrayHasKey('schemas', $data);
    }

    public function test_seo_service_sets_custom_title(): void
    {
        $seo = app(SEOService::class);
        $data = $seo->setTitle('Custom Page Title')->build();

        $this->assertStringContainsString('Custom Page Title', $data['metaTitle']);
    }

    public function test_seo_service_builds_website_and_organization_schemas(): void
    {
        $seo = app(SEOService::class);
        $data = $seo->build();

        $types = array_column($data['schemas'], '@type');
        $this->assertContains('WebSite', $types);
        $this->assertContains('Organization', $types);
    }

    public function test_seo_service_for_product_builds_product_schema(): void
    {
        $category = Category::factory()->create(['status' => true]);
        $product = Product::factory()->create([
            'name' => 'Test Product',
            'price' => 99.99,
            'status' => 'active',
            'category_id' => $category->id,
        ]);

        $seo = app(SEOService::class);
        $data = $seo->forProduct($product)->build();

        $types = array_column($data['schemas'], '@type');
        $this->assertContains('Product', $types);

        $productSchema = collect($data['schemas'])->firstWhere('@type', 'Product');
        $this->assertEquals('Test Product', $productSchema['name']);
        $this->assertEquals('99.99', $productSchema['offers']['price']);
    }

    public function test_seo_service_og_type_is_product_for_products(): void
    {
        $category = Category::factory()->create(['status' => true]);
        $product = Product::factory()->create([
            'status' => 'active',
            'category_id' => $category->id,
        ]);

        $seo = app(SEOService::class);
        $data = $seo->forProduct($product)->build();

        $this->assertEquals('product', $data['ogType']);
    }

    public function test_category_page_has_canonical_tag(): void
    {
        $category = Category::factory()->create(['status' => true]);

        $response = $this->get(route('category.show', $category->slug));

        $response->assertStatus(200);
        $response->assertSee('rel="canonical"', false);
    }

    public function test_brand_page_has_meta_tags(): void
    {
        $brand = Brand::factory()->create(['status' => true]);

        $response = $this->get(route('brand.show', $brand->slug));

        $response->assertStatus(200);
        $response->assertSee('<title>', false);
    }

    public function test_home_page_includes_global_schema_markup(): void
    {
        $response = $this->get('/');

        $response->assertSee('application/ld+json', false);
    }
}
