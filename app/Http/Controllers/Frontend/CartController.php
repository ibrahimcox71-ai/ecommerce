<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\AddToCartRequest;
use App\Http\Requests\Cart\UpdateCartRequest;
use App\Http\Requests\Cart\ApplyCouponRequest;
use App\Services\CartService;
use App\Services\SEOService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CartController extends Controller
{
    public function __construct(
        protected CartService $cartService
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

    public function index(SEOService $seo): View|JsonResponse
    {
        [$sessionId, $userId] = $this->getCartSession();
        $cart = $this->cartService->getCart($sessionId, $userId);

        if (request()->ajax() && request()->has('mini')) {
            return response()->json([
                'html' => view('components.mini-cart-content', compact('cart'))->render(),
                'cart' => $this->cartService->getCartSummary($sessionId, $userId),
            ]);
        }

        $seo->setTitle('Shopping Cart');
        $seo->setDescription('View and manage items in your shopping cart.');
        $seoData = $seo->build();

        return view('frontend.cart', compact('cart', 'seoData'));
    }

    public function add(AddToCartRequest $request): JsonResponse
    {
        [$sessionId, $userId] = $this->getCartSession();
        $cart = $this->cartService->getOrCreateCart($sessionId, $userId);

        $product = $request->getProduct();
        $variant = $request->getVariant();

        $unitPrice = $variant ? ($variant->current_price ?? $variant->price) : $product->current_price;
        $discount = $variant ? ($variant->discount ?? 0) : $product->discount;

        $this->cartService->addItem(
            $cart->id,
            $product->id,
            $request->input('quantity', 1),
            $variant?->id,
            $unitPrice,
            $discount
        );

        $summary = $this->cartService->getCartSummary($sessionId, $userId);

        return response()->json([
            'success' => true,
            'message' => 'Item added to cart!',
            'cart' => $summary,
        ]);
    }

    public function update(UpdateCartRequest $request): JsonResponse
    {
        [$sessionId, $userId] = $this->getCartSession();
        $cart = $this->cartService->getCart($sessionId, $userId);

        if (!$cart) {
            return response()->json(['success' => false, 'message' => 'Cart not found.'], 404);
        }

        $item = $this->cartService->updateQuantity(
            $cart->id,
            $request->input('item_id'),
            $request->input('quantity')
        );

        $cart->refresh();
        $summary = $this->cartService->getCartSummary($sessionId, $userId);

        return response()->json([
            'success' => true,
            'message' => $item ? 'Cart updated!' : 'Item removed.',
            'cart' => $summary,
            'item_subtotal' => $item ? (float) $item->subtotal : null,
        ]);
    }

    public function remove(Request $request): JsonResponse
    {
        $request->validate([
            'item_id' => ['required', 'integer', 'exists:cart_items,id'],
        ]);

        [$sessionId, $userId] = $this->getCartSession();
        $cart = $this->cartService->getCart($sessionId, $userId);

        if (!$cart) {
            return response()->json(['success' => false, 'message' => 'Cart not found.'], 404);
        }

        $this->cartService->removeItem($cart->id, $request->input('item_id'));
        $summary = $this->cartService->getCartSummary($sessionId, $userId);

        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart.',
            'cart' => $summary,
        ]);
    }

    public function clear(): JsonResponse
    {
        [$sessionId, $userId] = $this->getCartSession();
        $cart = $this->cartService->getCart($sessionId, $userId);

        if ($cart) {
            $this->cartService->clearCart($cart->id);
        }

        return response()->json([
            'success' => true,
            'message' => 'Cart cleared.',
        ]);
    }

    public function applyCoupon(ApplyCouponRequest $request): JsonResponse
    {
        [$sessionId, $userId] = $this->getCartSession();
        $cart = $this->cartService->getCart($sessionId, $userId);

        if (!$cart) {
            return response()->json(['success' => false, 'message' => 'Cart not found.'], 404);
        }

        $result = $this->cartService->applyCoupon($cart->id, $request->input('code'));
        $result['success'] ? $result['message'] = 'Coupon applied!' : null;

        return response()->json($result);
    }

    public function removeCoupon(): JsonResponse
    {
        [$sessionId, $userId] = $this->getCartSession();
        $cart = $this->cartService->getCart($sessionId, $userId);

        if (!$cart) {
            return response()->json(['success' => false, 'message' => 'Cart not found.'], 404);
        }

        $result = $this->cartService->removeCoupon($cart->id);
        return response()->json($result);
    }

    public function summary(): JsonResponse
    {
        [$sessionId, $userId] = $this->getCartSession();
        $summary = $this->cartService->getCartSummary($sessionId, $userId);

        return response()->json($summary);
    }
}
