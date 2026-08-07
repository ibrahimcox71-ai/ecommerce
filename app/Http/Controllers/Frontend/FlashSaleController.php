<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\SEOService;

class FlashSaleController extends Controller
{
    public function index(SEOService $seo)
    {
        $products = Product::published()
            ->withDiscount()
            ->with(['category', 'brand', 'images'])
            ->latest()
            ->paginate(12);

        $seo->setTitle('Flash Sale');
        $seo->setDescription('Limited time offers with massive discounts. Shop our flash sale deals now!');
        $seoData = $seo->build();

        return view('frontend.flash-sale', compact('products', 'seoData'));
    }
}
