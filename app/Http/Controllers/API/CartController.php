<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\AddToCartRequest;
use App\Http\Requests\Cart\UpdateCartRequest;
use App\Http\Requests\Cart\ApplyCouponRequest;
use App\Http\Resources\CartResource;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function __construct(
        protected CartService $cartService
    ) {}

    protected function getCartSession(): array
    {
        $sessionId = request()->header('X-Session-Id');
        $userId = Auth::guard('web')->id();

        return [$sessionId, $userId];
    }

    public function index(): CartResource|JsonResponse
    {
        [$sessionId, $userId] = $this->getCartSession();
        $cart = $this->cartService->getCart($sessionId, $userId);

        if (!$cart) {
            return response()->json(['message' => 'Cart is empty.', 'data' => null]);
        }

        return new CartResource($cart);
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

        return response()->json([
            'message' => 'Item added to cart.',
            'cart' => new CartResource($cart->fresh()->load(['items.product.images', 'items.variant', 'coupon'])),
        ]);
    }

    public function update(UpdateCartRequest $request): JsonResponse
    {
        [$sessionId, $userId] = $this->getCartSession();
        $cart = $this->cartService->getCart($sessionId, $userId);

        if (!$cart) {
            return response()->json(['message' => 'Cart not found.'], 404);
        }

        $this->cartService->updateQuantity(
            $cart->id,
            $request->input('item_id'),
            $request->input('quantity')
        );

        return response()->json([
            'message' => 'Cart updated.',
            'cart' => new CartResource($cart->fresh()->load(['items.product.images', 'items.variant', 'coupon'])),
        ]);
    }

    public function remove(Request $request): JsonResponse
    {
        [$sessionId, $userId] = $this->getCartSession();
        $cart = $this->cartService->getCart($sessionId, $userId);

        if (!$cart) {
            return response()->json(['message' => 'Cart not found.'], 404);
        }

        $this->cartService->removeItem($cart->id, $request->input('item_id'));

        return response()->json([
            'message' => 'Item removed from cart.',
            'cart' => new CartResource($cart->fresh()->load(['items.product.images', 'items.variant', 'coupon'])),
        ]);
    }

    public function clear(): JsonResponse
    {
        [$sessionId, $userId] = $this->getCartSession();
        $cart = $this->cartService->getCart($sessionId, $userId);

        if ($cart) {
            $this->cartService->clearCart($cart->id);
        }

        return response()->json(['message' => 'Cart cleared.']);
    }

    public function applyCoupon(ApplyCouponRequest $request): JsonResponse
    {
        [$sessionId, $userId] = $this->getCartSession();
        $cart = $this->cartService->getCart($sessionId, $userId);

        if (!$cart) {
            return response()->json(['message' => 'Cart not found.'], 404);
        }

        $result = $this->cartService->applyCoupon($cart->id, $request->input('code'));

        if (!$result['success']) {
            return response()->json($result, 422);
        }

        return response()->json([
            'message' => $result['message'],
            'cart' => new CartResource($cart->fresh()->load(['items.product.images', 'items.variant', 'coupon'])),
        ]);
    }

    public function removeCoupon(): JsonResponse
    {
        [$sessionId, $userId] = $this->getCartSession();
        $cart = $this->cartService->getCart($sessionId, $userId);

        if (!$cart) {
            return response()->json(['message' => 'Cart not found.'], 404);
        }

        $this->cartService->removeCoupon($cart->id);

        return response()->json([
            'message' => 'Coupon removed.',
            'cart' => new CartResource($cart->fresh()->load(['items.product.images', 'items.variant', 'coupon'])),
        ]);
    }

    public function summary(): JsonResponse
    {
        [$sessionId, $userId] = $this->getCartSession();
        $summary = $this->cartService->getCartSummary($sessionId, $userId);

        return response()->json($summary);
    }
}
