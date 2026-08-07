<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Product;
use App\Services\SEOService;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function show($slug, Request $request, SEOService $seo)
    {
        $brand = Brand::active()->where('slug', $slug)->firstOrFail();

        $seo->forBrand($brand);
        $seoData = $seo->build();

        $query = Product::published()
            ->where('brand_id', $brand->id)
            ->with(['category', 'brand', 'images']);

        $sort = $request->get('sort', 'latest');
        match ($sort) {
            'price-low' => $query->orderBy('price'),
            'price-high' => $query->orderByDesc('price'),
            'name' => $query->orderBy('name'),
            default => $query->latest(),
        };

        $products = $query->paginate(12)->withQueryString();

        return view('frontend.brand', compact('brand', 'products', 'seoData'));
    }
}
