<?php

namespace App\Services;

use App\Models\Order;

class InvoiceService
{
    public function generateInvoiceNumber(): string
    {
        return generateInvoiceNumber();
    }

    public function generateInvoice(Order $order): Order
    {
        if (!$order->invoice_number) {
            $order->update([
                'invoice_number' => $this->generateInvoiceNumber(),
                'invoice_at' => now(),
            ]);

            return $order->fresh();
        }

        return $order;
    }

    public function getInvoiceData(Order $order): array
    {
        $order->load(['items', 'payment']);

        return [
            'store' => [
                'name' => config('app.name'),
                'address' => config('ecommerce.store_address', '123 Store Street, New York, NY 10001, United States'),
            ],
            'invoice' => [
                'number' => $order->invoice_number,
                'date' => $order->invoice_at ?? $order->created_at,
                'order_number' => $order->order_number,
            ],
            'customer' => [
                'billing' => $order->billing_address ?? $order->shipping_address,
                'shipping' => $order->shipping_address,
            ],
            'items' => $order->items,
            'summary' => [
                'subtotal' => $order->subtotal,
                'discount' => $order->coupon_discount,
                'shipping' => $order->shipping_cost,
                'shipping_method' => $order->shipping_method,
                'tax' => $order->tax_amount,
                'total' => $order->total,
            ],
            'payment' => [
                'method' => $order->payment?->payment_method ?? 'cod',
                'status' => $order->payment_status,
            ],
        ];
    }
}
