<?php

namespace App\Repositories;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Database\Eloquent\Model;

class CartRepository extends BaseRepository
{
    protected function model(): Model
    {
        return new Cart();
    }

    public function findBySession(string $sessionId): ?Cart
    {
        return Cart::bySession($sessionId)->active()->first();
    }

    public function findByUser(int $userId): ?Cart
    {
        return Cart::byUser($userId)->active()->first();
    }

    public function getOrCreateForSession(string $sessionId): Cart
    {
        $cart = $this->findBySession($sessionId);
        if (!$cart) {
            $cart = $this->create(['session_id' => $sessionId]);
        }
        return $cart;
    }

    public function getOrCreateForUser(int $userId): Cart
    {
        $cart = $this->findByUser($userId);
        if (!$cart) {
            $cart = $this->create(['user_id' => $userId]);
        }
        return $cart;
    }

    public function findItem(int $cartId, int $productId, ?int $variantId = null): ?CartItem
    {
        $query = CartItem::where('cart_id', $cartId)
            ->where('product_id', $productId);

        if ($variantId === null) {
            $query->whereNull('product_variant_id');
        } else {
            $query->where('product_variant_id', $variantId);
        }

        return $query->first();
    }

    public function addItem(array $data): CartItem
    {
        return CartItem::create($data);
    }

    public function updateItem(int $itemId, array $data): bool
    {
        return CartItem::where('id', $itemId)->update($data);
    }

    public function removeItem(int $itemId): bool
    {
        return CartItem::where('id', $itemId)->delete() > 0;
    }

    public function clearCart(int $cartId): void
    {
        CartItem::where('cart_id', $cartId)->delete();
    }

    public function getCartWithItems(int $cartId): ?Cart
    {
        return Cart::with(['items.product.images', 'items.variant', 'coupon'])
            ->find($cartId);
    }

    public function getCartWithItemsBySession(string $sessionId): ?Cart
    {
        return Cart::bySession($sessionId)
            ->active()
            ->with(['items.product.images', 'items.variant', 'coupon'])
            ->first();
    }

    public function getCartWithItemsByUser(int $userId): ?Cart
    {
        return Cart::byUser($userId)
            ->active()
            ->with(['items.product.images', 'items.variant', 'coupon'])
            ->first();
    }
}
