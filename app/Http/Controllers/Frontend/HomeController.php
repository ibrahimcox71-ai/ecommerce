<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Services\SEOService;

class HomeController extends Controller
{
    public function index(SEOService $seo)
    {
        $featuredProducts = Product::published()
            ->featured()
            ->with(['category', 'brand', 'images'])
            ->latest()
            ->take(8)
            ->get();

        $bestSellers = Product::published()
            ->bestSeller()
            ->with(['category', 'brand', 'images'])
            ->latest()
            ->take(8)
            ->get();

        $flashSaleProducts = Product::published()
            ->withDiscount()
            ->with(['category', 'brand', 'images'])
            ->latest()
            ->take(6)
            ->get();

        $latestProducts = Product::published()
            ->with(['category', 'brand', 'images'])
            ->latest()
            ->take(10)
            ->get();

        $trendingProducts = Product::published()
            ->trending()
            ->with(['category', 'brand', 'images'])
            ->latest()
            ->take(8)
            ->get();

        $todaysDeals = Product::published()
            ->withDiscount()
            ->with(['category', 'brand', 'images'])
            ->inRandomOrder()
            ->take(8)
            ->get();

        $collections = Category::active()
            ->featured()
            ->withCount('products')
            ->sorted()
            ->take(4)
            ->get();

        $categories = Category::active()
            ->withCount('products')
            ->sorted()
            ->take(8)
            ->get();

        $featuredCategories = Category::active()
            ->featured()
            ->withCount('products')
            ->sorted()
            ->take(8)
            ->get();

        $brands = Brand::active()
            ->withCount('products')
            ->sorted()
            ->get();

        $recentlyViewed = collect();
        $recentIds = request()->cookie('recently_viewed');
        if ($recentIds) {
            $ids = array_filter(explode(',', $recentIds));
            if (!empty($ids)) {
                $recentlyViewed = Product::published()
                    ->with(['category', 'brand', 'images'])
                    ->whereIn('id', $ids)
                    ->orderByRaw('FIELD(id, ' . implode(',', $ids) . ')')
                    ->take(6)
                    ->get();
            }
        }
        if ($recentlyViewed->isEmpty()) {
            $recentlyViewed = $trendingProducts->take(6);
        }

        $seoData = $seo->build();

        return view('frontend.home', compact(
            'featuredProducts',
            'trendingProducts',
            'bestSellers',
            'flashSaleProducts',
            'latestProducts',
            'todaysDeals',
            'categories',
            'featuredCategories',
            'collections',
            'brands',
            'recentlyViewed',
            'seoData'
        ));
    }
}
