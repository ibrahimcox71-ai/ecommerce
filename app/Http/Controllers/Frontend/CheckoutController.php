<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Checkout\PlaceOrderRequest;
use App\Models\Order;
use App\Services\CartService;
use App\Services\CheckoutService;
use App\Services\SEOService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class CheckoutController extends Controller
{
    public function __construct(
        protected CartService $cartService,
        protected CheckoutService $checkoutService
    ) {}

    protected function getCartSession(): array
    {
        $sessionId = session()->get('cart_session_id');
        $userId = Auth::guard('web')->id();
        if (!$sessionId) {
            $sessionId = (string) Str::uuid();
            session()->put('cart_session_id', $sessionId);
        }
        return [$sessionId, $userId];
    }

    public function index(SEOService $seo): View|JsonResponse|RedirectResponse
    {
        [$sessionId, $userId] = $this->getCartSession();
        $data = $this->checkoutService->getCheckoutData($sessionId, $userId);

        if (!$data['cart']) {
            return redirect()->route('cart')->with('error', $data['error'] ?? 'Your cart is empty.');
        }

        $seo->setTitle('Checkout');
        $seo->setDescription('Review your cart and complete your purchase securely.');
        $seoData = $seo->build();

        $shippingMethods = [
            'free' => ['label' => 'Free Shipping', 'cost' => 0, 'estimate' => '7-12 business days'],
            'standard' => ['label' => 'Standard Shipping', 'cost' => 5.99, 'estimate' => '5-7 business days'],
            'express' => ['label' => 'Express Shipping', 'cost' => 12.99, 'estimate' => '2-3 business days'],
            'overnight' => ['label' => 'Overnight Shipping', 'cost' => 24.99, 'estimate' => '1 business day'],
        ];

        $cart = $data['cart'];
        $addresses = $data['addresses'];
        $isGuest = !$userId;

        return view('frontend.checkout', compact('cart', 'addresses', 'shippingMethods', 'isGuest', 'seoData'));
    }

    public function placeOrder(PlaceOrderRequest $request): JsonResponse
    {
        [$sessionId, $userId] = $this->getCartSession();

        try {
            $order = $this->checkoutService->placeOrder(
                $request->validated(),
                $sessionId,
                $userId
            );

            $paymentResult = $this->checkoutService->processPayment(
                $order,
                $request->input('payment_method', 'cod')
            );

            if (!$paymentResult['success']) {
                return response()->json([
                    'success' => false,
                    'message' => $paymentResult['message'] ?? 'Payment failed. Please try again.',
                ], 422);
            }

            session()->forget('cart_session_id');

            session()->put('last_order_id', $order->id);

            return response()->json([
                'success' => true,
                'message' => 'Order placed successfully!',
                'order' => [
                    'id' => $order->id,
                    'number' => $order->order_number,
                    'total' => (float) $order->total,
                    'payment_method' => $request->input('payment_method', 'cod'),
                ],
                'redirect' => route('checkout.success', $order->id),
            ]);
        } catch (\RuntimeException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while placing your order. Please try again.',
            ], 500);
        }
    }

    public function success($orderId, SEOService $seo): View
    {
        $order = Order::with(['items', 'payment'])
            ->where('id', $orderId)
            ->where(function ($q) {
                $userId = Auth::guard('web')->id();
                if ($userId) {
                    $q->where('user_id', $userId);
                } else {
                    $q->where('id', session('last_order_id'));
                }
            })
            ->firstOrFail();

        $seo->setTitle('Order Successful');
        $seo->setDescription('Your order has been placed successfully.');
        $seoData = $seo->build();

        return view('frontend.order-success', compact('order', 'seoData'));
    }

    public function failed($orderId, SEOService $seo): View
    {
        $seo->setTitle('Order Failed');
        $seo->setDescription('Your order could not be processed.');
        $seoData = $seo->build();

        return view('frontend.order-failed', compact('orderId', 'seoData'));
    }

    public function invoice($orderId, SEOService $seo): View
    {
        $order = Order::with(['items', 'payment'])
            ->where('id', $orderId)
            ->where(function ($q) {
                $userId = Auth::guard('web')->id();
                if ($userId) {
                    $q->where('user_id', $userId);
                } else {
                    $q->where('id', session('last_order_id'));
                }
            })
            ->firstOrFail();

        $seo->setTitle('Invoice');
        $seo->setDescription('View your order invoice.');
        $seoData = $seo->build();

        return view('frontend.invoice', compact('order', 'seoData'));
    }

    public function shippingRates(Request $request): JsonResponse
    {
        $method = $request->input('method', 'standard');
        $items = $request->input('items', []);

        $rates = $this->checkoutService->calculateShipping($items, $method);

        return response()->json($rates);
    }

    public function summary(): JsonResponse
    {
        [$sessionId, $userId] = $this->getCartSession();
        $cart = $this->cartService->getCart($sessionId, $userId);

        if (!$cart) {
            return response()->json(['error' => 'Cart is empty.'], 404);
        }

        return response()->json([
            'subtotal' => (float) $cart->subtotal,
            'coupon_discount' => (float) $cart->coupon_discount,
            'shipping_cost' => (float) $cart->shipping_cost,
            'tax_amount' => (float) $cart->tax_amount,
            'total' => (float) $cart->total,
            'items_count' => $cart->items->sum('quantity'),
        ]);
    }
}
