<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Services\SEOService;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request, SEOService $seo)
    {
        $query = Product::published()->with(['category', 'brand', 'images']);

        if ($request->filled('category')) {
            $cat = Category::where('slug', $request->category)->first();
            if ($cat) {
                $categoryIds = $cat->children()->pluck('id')->push($cat->id);
                $query->whereIn('category_id', $categoryIds);
            }
        }

        if ($request->filled('brand')) {
            $query->whereHas('brand', function ($q) use ($request) {
                $q->where('slug', $request->brand);
            });
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->filled('q')) {
            $query->search($request->q);
            $q = $request->q;
            $seo->setTitle("Search: {$q}");
            $seo->setDescription("Search results for \"{$q}\" in our store");
        } else {
            $seo->setTitle('Shop');
            $seo->setDescription('Browse our complete collection of products');
        }

        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price-low':
                $query->orderBy('price');
                break;
            case 'price-high':
                $query->orderByDesc('price');
                break;
            case 'name':
                $query->orderBy('name');
                break;
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::active()->withCount('products')->sorted()->get();
        $brands = Brand::active()->withCount('products')->sorted()->get();

        $maxPrice = Product::published()->max('price');

        $seoData = $seo->build();

        return view('frontend.shop', compact(
            'products',
            'categories',
            'brands',
            'maxPrice',
            'seoData'
        ));
    }
}
