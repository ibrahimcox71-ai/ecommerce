<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        $userId = Auth::guard('web')->id();
        $orders = Order::with(['items', 'payment'])
            ->where('user_id', $userId)
            ->latest()
            ->paginate(15);

        return view('customer.orders', compact('orders'));
    }

    public function show(Order $order): View
    {
        $userId = Auth::guard('web')->id();

        if ($order->user_id !== $userId) {
            abort(403);
        }

        $order->load(['items', 'payment.transactions']);

        return view('customer.order-detail', compact('order'));
    }
}
