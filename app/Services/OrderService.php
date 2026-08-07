<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Models\ActivityLog;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class OrderService
{
    protected array $transitions = [
        'pending' => ['confirmed', 'cancelled'],
        'confirmed' => ['processing', 'cancelled'],
        'processing' => ['packing', 'cancelled'],
        'packing' => ['ready_to_ship'],
        'ready_to_ship' => ['shipping'],
        'shipping' => ['out_for_delivery'],
        'out_for_delivery' => ['delivered'],
        'delivered' => ['completed', 'returned'],
        'completed' => ['returned'],
        'cancelled' => ['refunded'],
        'returned' => ['refunded'],
    ];

    public function canTransition(Order $order, OrderStatus $newStatus): bool
    {
        $allowed = $this->transitions[$order->status] ?? [];
        return in_array($newStatus->value, $allowed);
    }

    public function transition(Order $order, OrderStatus $newStatus, ?string $reason = null, ?int $causerId = null): Order
    {
        if (!$this->canTransition($order, $newStatus)) {
            throw new \RuntimeException(
                "Cannot transition from '{$order->status}' to '{$newStatus->value}'."
            );
        }

        $updateData = ['status' => $newStatus->value];

        $timestampMap = [
            'confirmed' => 'confirmed_at',
            'processing' => null,
            'packing' => 'packing_at',
            'ready_to_ship' => 'ready_to_ship_at',
            'shipping' => 'shipping_at',
            'out_for_delivery' => 'out_for_delivery_at',
            'delivered' => 'delivered_at',
            'completed' => 'completed_at',
            'cancelled' => 'cancelled_at',
            'returned' => 'returned_at',
            'refunded' => 'refunded_at',
        ];

        if (isset($timestampMap[$newStatus->value]) && $timestampMap[$newStatus->value]) {
            $updateData[$timestampMap[$newStatus->value]] = now();
        }

        if ($newStatus === OrderStatus::Cancelled && $reason) {
            $updateData['cancel_reason'] = $reason;
        }

        $order->update($updateData);

        $this->logActivity($order, $newStatus, $reason, $causerId);

        return $order->fresh();
    }

    public function getAllowedTransitions(Order $order): array
    {
        $allowed = $this->transitions[$order->status] ?? [];
        return array_map(fn($s) => OrderStatus::from($s), $allowed);
    }

    public function createFromData(array $data, int $adminId): Order
    {
        return DB::transaction(function () use ($data, $adminId) {
            $orderNumber = $this->generateOrderNumber();

            $shippingAddress = $data['shipping_address'] ?? [];
            $billingAddress = $data['billing_same'] ?? true
                ? $shippingAddress
                : ($data['billing_address'] ?? $shippingAddress);

            $order = Order::create([
                'user_id' => $data['user_id'] ?? null,
                'order_number' => $orderNumber,
                'order_origin' => $data['order_origin'] ?? 'manual',
                'status' => 'pending',
                'subtotal' => $data['subtotal'] ?? 0,
                'coupon_discount' => $data['coupon_discount'] ?? 0,
                'shipping_cost' => $data['shipping_cost'] ?? 0,
                'tax_rate' => $data['tax_rate'] ?? 0,
                'tax_amount' => $data['tax_amount'] ?? 0,
                'total' => $data['total'] ?? 0,
                'paid_amount' => 0,
                'payment_status' => 'pending',
                'shipping_method' => $data['shipping_method'] ?? 'standard',
                'shipping_address' => $shippingAddress,
                'billing_address' => $billingAddress,
                'notes' => $data['notes'] ?? null,
                'currency' => $data['currency'] ?? 'USD',
                'invoice_number' => generateInvoiceNumber(),
                'invoice_at' => now(),
            ]);

            foreach ($data['items'] as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'] ?? null,
                    'product_variant_id' => $item['product_variant_id'] ?? null,
                    'product_name' => $item['product_name'],
                    'product_sku' => $item['product_sku'] ?? null,
                    'product_image' => $item['product_image'] ?? null,
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'discount' => $item['discount'] ?? 0,
                    'subtotal' => $item['subtotal'],
                ]);
            }

            if ($data['payment_method'] ?? false) {
                $order->payment()->create([
                    'payment_method' => $data['payment_method'],
                    'payment_status' => 'pending',
                    'amount' => $order->total,
                ]);
            }

            $this->logActivity($order, OrderStatus::Pending, 'Order created manually', $adminId);

            return $order->load(['items', 'payment']);
        });
    }

    public function duplicateOrder(Order $source, int $adminId): Order
    {
        $data = [
            'user_id' => $source->user_id,
            'subtotal' => $source->subtotal,
            'coupon_discount' => $source->coupon_discount,
            'shipping_cost' => $source->shipping_cost,
            'tax_rate' => $source->tax_rate,
            'tax_amount' => $source->tax_amount,
            'total' => $source->total,
            'shipping_method' => $source->shipping_method,
            'shipping_address' => $source->shipping_address,
            'billing_address' => $source->billing_address,
            'notes' => $source->notes,
            'currency' => $source->currency,
            'items' => $source->items->map(fn($i) => [
                'product_id' => $i->product_id,
                'product_variant_id' => $i->product_variant_id,
                'product_name' => $i->product_name,
                'product_sku' => $i->product_sku,
                'product_image' => $i->product_image,
                'quantity' => $i->quantity,
                'unit_price' => $i->unit_price,
                'discount' => $i->discount,
                'subtotal' => $i->subtotal,
            ])->toArray(),
        ];

        return $this->createFromData($data, $adminId);
    }

    public function updateOrder(Order $order, array $data): Order
    {
        return DB::transaction(function () use ($order, $data) {
            $updateData = [];

            if (isset($data['shipping_address'])) {
                $updateData['shipping_address'] = $data['shipping_address'];
            }
            if (isset($data['billing_address'])) {
                $updateData['billing_address'] = $data['billing_address'];
            }
            if (isset($data['shipping_method'])) {
                $updateData['shipping_method'] = $data['shipping_method'];
            }
            if (isset($data['shipping_cost'])) {
                $updateData['shipping_cost'] = $data['shipping_cost'];
            }
            if (isset($data['notes'])) {
                $updateData['notes'] = $data['notes'];
            }
            if (isset($data['tracking_number'])) {
                $updateData['tracking_number'] = $data['tracking_number'];
            }
            if (isset($data['tracking_url'])) {
                $updateData['tracking_url'] = $data['tracking_url'];
            }
            if (isset($data['carrier'])) {
                $updateData['carrier'] = $data['carrier'];
            }
            if (isset($data['estimated_delivery'])) {
                $updateData['estimated_delivery'] = $data['estimated_delivery'];
            }
            if (isset($data['cancel_reason'])) {
                $updateData['cancel_reason'] = $data['cancel_reason'];
            }

            if (!empty($updateData)) {
                $order->update($updateData);
            }

            if (isset($data['items']) && is_array($data['items'])) {
                $order->items()->delete();
                foreach ($data['items'] as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item['product_id'] ?? null,
                        'product_variant_id' => $item['product_variant_id'] ?? null,
                        'product_name' => $item['product_name'],
                        'product_sku' => $item['product_sku'] ?? null,
                        'product_image' => $item['product_image'] ?? null,
                        'quantity' => $item['quantity'],
                        'unit_price' => $item['unit_price'],
                        'discount' => $item['discount'] ?? 0,
                        'subtotal' => $item['subtotal'],
                    ]);
                }

                $subtotal = collect($data['items'])->sum(fn($i) => $i['subtotal']);
                $total = $subtotal + ($data['shipping_cost'] ?? $order->shipping_cost) + ($data['tax_amount'] ?? $order->tax_amount) - ($data['coupon_discount'] ?? $order->coupon_discount);
                $order->update([
                    'subtotal' => $subtotal,
                    'total' => max(0, $total),
                ]);
            }

            return $order->fresh()->load(['items', 'payment']);
        });
    }

    public function holdOrder(Order $order, int $adminId): Order
    {
        if (!$order->isHoldable()) {
            throw new \RuntimeException('Order cannot be put on hold.');
        }
        return $this->transition($order, OrderStatus::from('cancelled'), 'Order placed on hold', $adminId);
    }

    public function markPaid(Order $order, ?string $reference = null, ?int $adminId = null): Order
    {
        DB::transaction(function () use ($order, $reference, $adminId) {
            $order->update([
                'payment_status' => 'paid',
                'paid_amount' => $order->total,
                'paid_at' => now(),
            ]);

            $payment = $order->payment;
            if ($payment) {
                $payment->update([
                    'payment_status' => 'paid',
                    'paid_at' => now(),
                    'transaction_id' => $reference ?? $payment->transaction_id,
                ]);
            }

            $order->transactions()->create([
                'payment_id' => $payment?->id,
                'type' => 'payment',
                'amount' => $order->total,
                'status' => 'paid',
                'reference' => $reference,
            ]);

            ActivityLog::create([
                'log_name' => 'order',
                'description' => 'Payment marked as paid',
                'subject_type' => Order::class,
                'subject_id' => $order->id,
                'causer_type' => $adminId ? Admin::class : null,
                'causer_id' => $adminId,
                'properties' => ['reference' => $reference],
            ]);
        });

        return $order->fresh();
    }

    public function markPartialPaid(Order $order, float $amount, ?string $reference = null, ?int $adminId = null): Order
    {
        DB::transaction(function () use ($order, $amount, $reference, $adminId) {
            $newPaid = $order->paid_amount + $amount;
            $status = $newPaid >= $order->total ? 'paid' : 'partial';

            $order->update([
                'payment_status' => $status,
                'paid_amount' => $newPaid,
                'paid_at' => $status === 'paid' ? now() : $order->paid_at,
            ]);

            $payment = $order->payment;
            if ($payment) {
                $payment->update([
                    'payment_status' => $status,
                    'paid_at' => $status === 'paid' ? now() : $payment->paid_at,
                ]);
            }

            $order->transactions()->create([
                'payment_id' => $payment?->id,
                'type' => 'payment',
                'amount' => $amount,
                'status' => $status === 'paid' ? 'paid' : 'pending',
                'reference' => $reference,
            ]);

            ActivityLog::create([
                'log_name' => 'order',
                'description' => "Partial payment of {$amount} received",
                'subject_type' => Order::class,
                'subject_id' => $order->id,
                'causer_type' => $adminId ? Admin::class : null,
                'causer_id' => $adminId,
                'properties' => ['amount' => $amount, 'reference' => $reference],
            ]);
        });

        return $order->fresh();
    }

    public function refund(Order $order, float $amount, ?string $reason = null, ?int $adminId = null): Order
    {
        DB::transaction(function () use ($order, $amount, $reason, $adminId) {
            $order->update([
                'payment_status' => 'refunded',
                'paid_amount' => max(0, $order->paid_amount - $amount),
            ]);

            $payment = $order->payment;
            if ($payment) {
                $payment->update(['payment_status' => 'refunded']);
            }

            $order->transactions()->create([
                'payment_id' => $payment?->id,
                'type' => 'refund',
                'amount' => $amount,
                'status' => 'refunded',
                'reference' => 'RFN-' . strtoupper(uniqid()),
            ]);

            ActivityLog::create([
                'log_name' => 'order',
                'description' => "Refund of {$amount} processed",
                'subject_type' => Order::class,
                'subject_id' => $order->id,
                'causer_type' => $adminId ? Admin::class : null,
                'causer_id' => $adminId,
                'properties' => ['amount' => $amount, 'reason' => $reason],
            ]);
        });

        return $order->fresh();
    }

    public function updateTracking(Order $order, string $trackingNumber, ?string $carrier = null, ?string $trackingUrl = null, ?string $estimatedDelivery = null): Order
    {
        $order->update([
            'tracking_number' => $trackingNumber,
            'carrier' => $carrier ?? $order->carrier,
            'tracking_url' => $trackingUrl ?? $order->tracking_url,
            'estimated_delivery' => $estimatedDelivery ?? $order->estimated_delivery,
        ]);

        return $order->fresh();
    }

    public function getOrderTimeline(Order $order): array
    {
        $timeline = [];

        $events = [
            'created' => $order->created_at,
            'confirmed_at' => $order->confirmed_at,
            'packing_at' => $order->packing_at,
            'ready_to_ship_at' => $order->ready_to_ship_at,
            'shipping_at' => $order->shipping_at,
            'out_for_delivery_at' => $order->out_for_delivery_at,
            'delivered_at' => $order->delivered_at,
            'completed_at' => $order->completed_at,
            'cancelled_at' => $order->cancelled_at,
            'returned_at' => $order->returned_at,
            'refunded_at' => $order->refunded_at,
        ];

        $labels = [
            'created' => 'Order Created',
            'confirmed_at' => 'Order Confirmed',
            'packing_at' => 'Packed',
            'ready_to_ship_at' => 'Ready To Ship',
            'shipping_at' => 'Shipped',
            'out_for_delivery_at' => 'Out For Delivery',
            'delivered_at' => 'Delivered',
            'completed_at' => 'Completed',
            'cancelled_at' => 'Cancelled',
            'returned_at' => 'Returned',
            'refunded_at' => 'Refunded',
        ];

        $icons = [
            'created' => 'bi-cart-plus',
            'confirmed_at' => 'bi-check-circle',
            'packing_at' => 'bi-box-seam',
            'ready_to_ship_at' => 'bi-truck',
            'shipping_at' => 'bi-truck',
            'out_for_delivery_at' => 'bi-geo-alt',
            'delivered_at' => 'bi-check-all',
            'completed_at' => 'bi-star',
            'cancelled_at' => 'bi-x-circle',
            'returned_at' => 'bi-arrow-counterclockwise',
            'refunded_at' => 'bi-cash-stack',
        ];

        foreach ($events as $key => $timestamp) {
            if ($timestamp) {
                $timeline[] = [
                    'label' => $labels[$key],
                    'timestamp' => $timestamp,
                    'icon' => $icons[$key],
                    'key' => $key,
                ];
            }
        }

        $activities = ActivityLog::where('subject_type', Order::class)
            ->where('subject_id', $order->id)
            ->where('log_name', 'order')
            ->orderBy('created_at')
            ->get();

        foreach ($activities as $activity) {
            $timeline[] = [
                'label' => $activity->description,
                'timestamp' => $activity->created_at,
                'icon' => 'bi-activity',
                'key' => 'activity_' . $activity->id,
                'properties' => $activity->properties,
            ];
        }

        usort($timeline, fn($a, $b) => $a['timestamp']->timestamp <=> $b['timestamp']->timestamp);

        return $timeline;
    }

    protected function logActivity(Order $order, OrderStatus $status, ?string $reason = null, ?int $causerId = null): void
    {
        $description = $status === OrderStatus::Pending
            ? 'Order created'
            : "Order status changed to {$status->label()}";

        if ($status === OrderStatus::Cancelled && $reason) {
            $description .= " (Reason: {$reason})";
        }

        $properties = ['status' => $status->value];
        if ($reason) {
            $properties['reason'] = $reason;
        }

        ActivityLog::create([
            'log_name' => 'order',
            'description' => $description,
            'subject_type' => Order::class,
            'subject_id' => $order->id,
            'causer_type' => $causerId ? Admin::class : null,
            'causer_id' => $causerId,
            'properties' => $properties,
        ]);
    }

    protected function generateOrderNumber(): string
    {
        $prefix = config('ecommerce.order.prefix', 'ORD-');
        $last = Order::max('id') ?? 0;
        return $prefix . str_pad($last + 1, 6, '0', STR_PAD_LEFT);
    }
}
