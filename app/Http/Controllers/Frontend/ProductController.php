<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use App\Services\SEOService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show($slug, Request $request, SEOService $seo)
    {
        $product = Product::published()
            ->with([
                'category',
                'brand',
                'images',
                'variants' => fn($q) => $q->with('attributeValues'),
                'variants.attributeValues',
                'reviews' => fn($q) => $q->approved(),
            ])
            ->where('slug', $slug)
            ->firstOrFail();

        $seo->forProduct($product);
        $seoData = $seo->build();

        $reviews = $product->reviews()
            ->approved()
            ->with(['user', 'images', 'replies.admin'])
            ->when($request->filled('review_sort'), function ($q) use ($request) {
                match ($request->review_sort) {
                    'highest' => $q->orderByDesc('rating'),
                    'lowest' => $q->orderBy('rating'),
                    'oldest' => $q->oldest(),
                    default => $q->latest(),
                };
            }, fn($q) => $q->latest())
            ->paginate(10);

        $ratingBreakdown = $product->reviews()
            ->approved()
            ->selectRaw('rating, COUNT(*) as count')
            ->groupBy('rating')
            ->pluck('count', 'rating')
            ->toArray();

        for ($i = 5; $i >= 1; $i--) {
            $ratingBreakdown[$i] ??= 0;
        }

        krsort($ratingBreakdown);

        $relatedProducts = Product::published()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->with(['category', 'brand', 'images'])
            ->latest()
            ->take(4)
            ->get();

        $alsoBought = Product::published()
            ->whereHas('orders', fn($q) => $q->whereIn('order_id', function ($sub) use ($product) {
                $sub->select('order_id')
                    ->from('order_items')
                    ->where('product_id', $product->id);
            }))
            ->where('id', '!=', $product->id)
            ->with(['category', 'brand', 'images'])
            ->inRandomOrder()
            ->take(4)
            ->get();

        $totalSold = $product->orders()->sum('order_items.quantity');

        return view('frontend.product', compact(
            'product',
            'reviews',
            'ratingBreakdown',
            'relatedProducts',
            'alsoBought',
            'totalSold',
            'seoData'
        ));
    }
}
