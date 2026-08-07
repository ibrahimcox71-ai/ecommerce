<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Page;
use App\Models\Blog;

class SitemapController extends Controller
{
    public function index()
    {
        $staticPages = [
            ['loc' => route('home'), 'priority' => '1.0', 'changefreq' => 'daily'],
            ['loc' => route('shop'), 'priority' => '0.9', 'changefreq' => 'daily'],
            ['loc' => route('about'), 'priority' => '0.5', 'changefreq' => 'monthly'],
            ['loc' => route('contact'), 'priority' => '0.5', 'changefreq' => 'monthly'],
            ['loc' => route('faq'), 'priority' => '0.5', 'changefreq' => 'monthly'],
            ['loc' => route('blog'), 'priority' => '0.7', 'changefreq' => 'weekly'],
            ['loc' => route('terms'), 'priority' => '0.3', 'changefreq' => 'yearly'],
            ['loc' => route('privacy-policy'), 'priority' => '0.3', 'changefreq' => 'yearly'],
            ['loc' => route('shipping-policy'), 'priority' => '0.3', 'changefreq' => 'yearly'],
            ['loc' => route('refund-policy'), 'priority' => '0.3', 'changefreq' => 'yearly'],
            ['loc' => route('flash-sale'), 'priority' => '0.6', 'changefreq' => 'daily'],
        ];

        $categories = Category::active()->get()->map(fn($c) => [
            'loc' => route('category.show', $c->slug),
            'priority' => '0.8',
            'changefreq' => 'weekly',
            'lastmod' => $c->updated_at,
        ]);

        $brands = Brand::active()->get()->map(fn($b) => [
            'loc' => route('brand.show', $b->slug),
            'priority' => '0.7',
            'changefreq' => 'weekly',
            'lastmod' => $b->updated_at,
        ]);

        $products = Product::published()->get()->map(fn($p) => [
            'loc' => route('product.show', $p->slug),
            'priority' => '0.9',
            'changefreq' => 'weekly',
            'lastmod' => $p->updated_at,
        ]);

        $pages = Page::active()->get()->map(fn($p) => [
            'loc' => url($p->slug),
            'priority' => '0.6',
            'changefreq' => 'monthly',
            'lastmod' => $p->updated_at,
        ]);

        $urls = collect($staticPages)
            ->concat($categories)
            ->concat($brands)
            ->concat($products)
            ->concat($pages);

        return response()
            ->view('sitemap', compact('urls'))
            ->header('Content-Type', 'application/xml');
    }
}
