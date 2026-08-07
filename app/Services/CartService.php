<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Repositories\CartRepository;
use Illuminate\Support\Str;

class CartService extends BaseService
{
    protected string $repositoryClass = CartRepository::class;

    protected function cartRepo(): CartRepository
    {
        return $this->repository();
    }

    public function getCart(?string $sessionId = null, ?int $userId = null): ?Cart
    {
        if ($userId) {
            return $this->cartRepo()->getCartWithItemsByUser($userId);
        }
        if ($sessionId) {
            return $this->cartRepo()->getCartWithItemsBySession($sessionId);
        }
        return null;
    }

    public function getOrCreateCart(?string $sessionId = null, ?int $userId = null): Cart
    {
        if ($userId) {
            $cart = $this->cartRepo()->getOrCreateForUser($userId);
        } elseif ($sessionId) {
            $cart = $this->cartRepo()->getOrCreateForSession($sessionId);
        } else {
            $sessionId = (string) Str::uuid();
            $cart = $this->cartRepo()->create(['session_id' => $sessionId]);
        }

        return $this->cartRepo()->getCartWithItems($cart->id);
    }

    public function addItem(int $cartId, int $productId, int $quantity = 1, ?int $variantId = null, ?float $unitPrice = null, ?float $discount = null): CartItem
    {
        $existing = $this->cartRepo()->findItem($cartId, $productId, $variantId);

        if ($existing) {
            $newQty = $existing->quantity + $quantity;
            $this->cartRepo()->updateItem($existing->id, [
                'quantity' => $newQty,
                'subtotal' => ($unitPrice ?? $existing->unit_price) * $newQty,
            ]);
            $item = $existing->fresh();
        } else {
            $item = $this->cartRepo()->addItem([
                'cart_id' => $cartId,
                'product_id' => $productId,
                'product_variant_id' => $variantId,
                'quantity' => $quantity,
                'unit_price' => $unitPrice ?? 0,
                'discount' => $discount ?? 0,
                'subtotal' => ($unitPrice ?? 0) * $quantity,
            ]);
        }

        $this->recalculateCart($cartId);
        return $item;
    }

    public function updateQuantity(int $cartId, int $itemId, int $quantity): ?CartItem
    {
        $item = CartItem::where('id', $itemId)->where('cart_id', $cartId)->first();
        if (!$item) {
            return null;
        }

        if ($quantity <= 0) {
            $this->cartRepo()->removeItem($itemId);
            $this->recalculateCart($cartId);
            return null;
        }

        $subtotal = ($item->unit_price - $item->discount) * $quantity;
        $this->cartRepo()->updateItem($itemId, [
            'quantity' => $quantity,
            'subtotal' => $subtotal,
        ]);

        $this->recalculateCart($cartId);
        return $item->fresh();
    }

    public function removeItem(int $cartId, int $itemId): bool
    {
        $removed = $this->cartRepo()->removeItem($itemId);
        if ($removed) {
            $this->recalculateCart($cartId);
        }
        return $removed;
    }

    public function clearCart(int $cartId): void
    {
        $this->cartRepo()->clearCart($cartId);

        $this->cartRepo()->update($cartId, [
            'coupon_id' => null,
            'coupon_discount' => 0,
            'shipping_cost' => 0,
            'tax_rate' => 0,
            'tax_amount' => 0,
            'subtotal' => 0,
            'total' => 0,
        ]);
    }

    public function recalculateCart(int $cartId): void
    {
        $cart = Cart::with('items')->find($cartId);
        if (!$cart) {
            return;
        }

        $subtotal = $cart->items->sum('subtotal');
        $couponDiscount = 0;

        if ($cart->coupon_id) {
            $coupon = Coupon::find($cart->coupon_id);
            if ($coupon && $coupon->isValid()) {
                $couponDiscount = $coupon->calculateDiscount($subtotal);
            } else {
                $cart->coupon_id = null;
            }
        }

        $afterCoupon = $subtotal - $couponDiscount;
        $taxAmount = $afterCoupon * ($cart->tax_rate / 100);
        $total = $afterCoupon + $cart->shipping_cost + $taxAmount;

        $cart->update([
            'subtotal' => max(0, $subtotal),
            'coupon_discount' => max(0, $couponDiscount),
            'tax_amount' => max(0, $taxAmount),
            'total' => max(0, $total),
        ]);
    }

    public function applyCoupon(int $cartId, string $code): array
    {
        $cart = Cart::with('items')->find($cartId);
        if (!$cart || $cart->items->isEmpty()) {
            return ['success' => false, 'message' => 'Cart is empty.'];
        }

        $coupon = Coupon::where('code', $code)->first();
        if (!$coupon) {
            return ['success' => false, 'message' => 'Invalid coupon code.'];
        }

        if (!$coupon->isValid()) {
            return ['success' => false, 'message' => 'Coupon has expired or is no longer valid.'];
        }

        if ($coupon->min_order_amount > 0 && $cart->items->sum('subtotal') < $coupon->min_order_amount) {
            return ['success' => false, 'message' => "Minimum order amount of \${$coupon->min_order_amount} required."];
        }

        $cart->update(['coupon_id' => $coupon->id]);
        $this->recalculateCart($cartId);

        $cart->refresh();
        return [
            'success' => true,
            'message' => 'Coupon applied successfully!',
            'discount' => $cart->coupon_discount,
            'total' => $cart->total,
        ];
    }

    public function removeCoupon(int $cartId): array
    {
        $cart = Cart::find($cartId);
        if (!$cart) {
            return ['success' => false, 'message' => 'Cart not found.'];
        }

        $cart->update(['coupon_id' => null, 'coupon_discount' => 0]);
        $this->recalculateCart($cartId);

        return ['success' => true, 'message' => 'Coupon removed.'];
    }

    public function setShipping(int $cartId, float $cost): void
    {
        $this->cartRepo()->update($cartId, ['shipping_cost' => max(0, $cost)]);
        $this->recalculateCart($cartId);
    }

    public function setTaxRate(int $cartId, float $rate): void
    {
        $this->cartRepo()->update($cartId, ['tax_rate' => max(0, $rate)]);
        $this->recalculateCart($cartId);
    }

    public function getCartSummary(?string $sessionId = null, ?int $userId = null): array
    {
        $cart = $this->getCart($sessionId, $userId);

        if (!$cart) {
            return [
                'items_count' => 0,
                'subtotal' => 0,
                'total' => 0,
            ];
        }

        return [
            'items_count' => $cart->items->sum('quantity'),
            'subtotal' => (float) $cart->subtotal,
            'total' => (float) $cart->total,
        ];
    }

    public function mergeGuestCartToUser(string $sessionId, int $userId): void
    {
        $guestCart = $this->cartRepo()->findBySession($sessionId);
        $userCart = $this->cartRepo()->findByUser($userId);

        if (!$guestCart || $guestCart->items->isEmpty()) {
            return;
        }

        if (!$userCart) {
            $this->cartRepo()->update($guestCart->id, [
                'user_id' => $userId,
                'session_id' => null,
            ]);
            return;
        }

        foreach ($guestCart->items as $guestItem) {
            $existing = $this->cartRepo()->findItem(
                $userCart->id,
                $guestItem->product_id,
                $guestItem->product_variant_id
            );

            if ($existing) {
                $newQty = $existing->quantity + $guestItem->quantity;
                $this->cartRepo()->updateItem($existing->id, [
                    'quantity' => $newQty,
                    'subtotal' => ($existing->unit_price - $existing->discount) * $newQty,
                ]);
            } else {
                $this->cartRepo()->addItem([
                    'cart_id' => $userCart->id,
                    'product_id' => $guestItem->product_id,
                    'product_variant_id' => $guestItem->product_variant_id,
                    'quantity' => $guestItem->quantity,
                    'unit_price' => $guestItem->unit_price,
                    'discount' => $guestItem->discount,
                    'subtotal' => $guestItem->subtotal,
                ]);
            }
        }

        $this->cartRepo()->delete($guestCart->id);
        $this->recalculateCart($userCart->id);
    }

    public function recordCouponUsage(int $cartId, ?int $orderId = null): void
    {
        $cart = Cart::with('coupon')->find($cartId);
        if (!$cart?->coupon) {
            return;
        }

        CouponUsage::create([
            'coupon_id' => $cart->coupon_id,
            'user_id' => $cart->user_id,
            'order_id' => $orderId,
            'cart_id' => $cartId,
            'discount_amount' => $cart->coupon_discount,
        ]);

        $cart->coupon->increment('used_count');
    }
}
