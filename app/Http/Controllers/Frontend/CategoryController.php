<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Services\SEOService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show($slug, Request $request, SEOService $seo)
    {
        $category = Category::active()->where('slug', $slug)->firstOrFail();

        $seo->forCategory($category);
        $seoData = $seo->build();

        $categoryIds = $category->children()->pluck('id')->push($category->id);

        $query = Product::published()
            ->whereIn('category_id', $categoryIds)
            ->with(['category', 'brand', 'images']);

        $sort = $request->get('sort', 'latest');
        match ($sort) {
            'price-low' => $query->orderBy('price'),
            'price-high' => $query->orderByDesc('price'),
            'name' => $query->orderBy('name'),
            default => $query->latest(),
        };

        $products = $query->paginate(12)->withQueryString();

        return view('frontend.category', compact('category', 'products', 'seoData'));
    }
}
