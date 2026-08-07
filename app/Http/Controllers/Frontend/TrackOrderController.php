<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\SEOService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TrackOrderController extends Controller
{
    public function show(Request $request, SEOService $seo, ?string $orderNumber = null): View
    {
        if (!$orderNumber) {
            $orderNumber = $request->input('order_number');
        }

        $order = null;
        if ($orderNumber) {
            $order = Order::with(['items', 'payment'])
                ->where('order_number', $orderNumber)
                ->first();
        }

        $seo->setTitle('Track Order');
        $seo->setDescription('Track your order status and delivery progress.');
        $seoData = $seo->build();

        return view('frontend.track-order', compact('order', 'orderNumber', 'seoData'));
    }
}
