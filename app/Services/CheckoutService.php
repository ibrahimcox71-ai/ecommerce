<?php

namespace App\Services;

use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CouponUsage;
use Illuminate\Support\Facades\DB;

class CheckoutService
{
    public function __construct(
        protected CartService $cartService,
        protected PaymentService $paymentService
    ) {}

    public function getCheckoutData(?string $sessionId = null, ?int $userId = null): array
    {
        $cart = $this->cartService->getCart($sessionId, $userId);

        if (!$cart || $cart->items->isEmpty()) {
            return ['cart' => null, 'addresses' => [], 'error' => 'Your cart is empty.'];
        }

        $addresses = collect();
        if ($userId) {
            $addresses = Address::where('user_id', $userId)->get();
        }

        return compact('cart', 'addresses');
    }

    public function placeOrder(array $data, ?string $sessionId = null, ?int $userId = null): Order
    {
        $cart = $this->cartService->getCart($sessionId, $userId);

        if (!$cart || $cart->items->isEmpty()) {
            throw new \RuntimeException('Cart is empty.');
        }

        return DB::transaction(function () use ($data, $cart, $userId) {
            $shippingAddress = $this->formatAddress($data['shipping_address'] ?? []);
            $billingAddress = $data['billing_same'] ?? true
                ? $shippingAddress
                : $this->formatAddress($data['billing_address'] ?? []);

            $orderNumber = generateOrderNumber();
            $invoiceNumber = generateInvoiceNumber();

            $order = Order::create([
                'user_id' => $userId,
                'cart_id' => $cart->id,
                'coupon_id' => $cart->coupon_id,
                'order_number' => $orderNumber,
                'status' => 'pending',
                'subtotal' => $cart->subtotal,
                'coupon_discount' => $cart->coupon_discount,
                'shipping_cost' => $cart->shipping_cost,
                'tax_rate' => $cart->tax_rate,
                'tax_amount' => $cart->tax_amount,
                'total' => $cart->total,
                'paid_amount' => 0,
                'payment_status' => 'pending',
                'shipping_method' => $data['shipping_method'] ?? 'standard',
                'shipping_address' => $shippingAddress,
                'billing_address' => $billingAddress,
                'notes' => $data['notes'] ?? null,
                'currency' => 'USD',
                'invoice_number' => $invoiceNumber,
                'invoice_at' => now(),
            ]);

            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_variant_id' => $item->product_variant_id,
                    'product_name' => $item->product->name ?? 'Deleted Product',
                    'product_sku' => $item->variant?->sku ?? $item->product?->sku,
                    'product_image' => $item->getProductImage(),
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price,
                    'discount' => $item->discount,
                    'subtotal' => $item->subtotal,
                ]);
            }

            if ($userId) {
                $this->saveAddress($userId, $order->id, 'shipping', $shippingAddress);
                $this->saveAddress($userId, $order->id, 'billing', $billingAddress);
            }

            $this->paymentService->createPayment($order, $data['payment_method'] ?? 'cod');

            if ($cart->coupon_id) {
                CouponUsage::create([
                    'coupon_id' => $cart->coupon_id,
                    'user_id' => $userId,
                    'order_id' => $order->id,
                    'cart_id' => $cart->id,
                    'discount_amount' => $cart->coupon_discount,
                ]);
                $cart->coupon?->increment('used_count');
            }

            $this->cartService->clearCart($cart->id);

            return $order->load(['items', 'payment']);
        });
    }

    public function processPayment(Order $order, string $method): array
    {
        return $this->paymentService->processPayment($order, $method);
    }

    protected function formatAddress(array $data): array
    {
        return [
            'name' => $data['name'] ?? '',
            'email' => $data['email'] ?? '',
            'phone' => $data['phone'] ?? '',
            'address_line1' => $data['address_line1'] ?? '',
            'address_line2' => $data['address_line2'] ?? '',
            'city' => $data['city'] ?? '',
            'state' => $data['state'] ?? '',
            'zip' => $data['zip'] ?? '',
            'country' => $data['country'] ?? 'US',
        ];
    }

    protected function saveAddress(int $userId, int $orderId, string $type, array $addressData): Address
    {
        return Address::create(array_merge($addressData, [
            'user_id' => $userId,
            'order_id' => $orderId,
            'type' => $type,
        ]));
    }

    public function calculateShipping(array $items, string $method): array
    {
        $rates = [
            'standard' => ['label' => 'Standard Shipping', 'cost' => 5.99, 'estimate' => '5-7 business days'],
            'express' => ['label' => 'Express Shipping', 'cost' => 12.99, 'estimate' => '2-3 business days'],
            'overnight' => ['label' => 'Overnight Shipping', 'cost' => 24.99, 'estimate' => '1 business day'],
            'free' => ['label' => 'Free Shipping', 'cost' => 0, 'estimate' => '7-12 business days'],
        ];

        $totalQty = array_sum(array_column($items, 'quantity'));
        if ($totalQty > 5) {
            $rates['standard']['cost'] = 9.99;
            $rates['express']['cost'] = 19.99;
        }

        return $rates[$method] ?? $rates['standard'];
    }
}
