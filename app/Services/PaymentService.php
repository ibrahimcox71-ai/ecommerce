<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class PaymentService
{
    const METHOD_COD = 'cod';
    const METHOD_BANK_TRANSFER = 'bank_transfer';
    const METHOD_CARD = 'card';
    const METHOD_STRIPE = 'stripe';
    const METHOD_PAYPAL = 'paypal';

    const STATUS_PENDING = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_PAID = 'paid';
    const STATUS_FAILED = 'failed';
    const STATUS_REFUNDED = 'refunded';
    const STATUS_CANCELLED = 'cancelled';

    protected array $methods = [
        self::METHOD_COD => [
            'label' => 'Cash on Delivery',
            'icon' => 'fas fa-money-bill-wave',
            'description' => 'Pay when you receive your order',
            'requires_gateway' => false,
        ],
        self::METHOD_BANK_TRANSFER => [
            'label' => 'Bank Transfer',
            'icon' => 'fas fa-university',
            'description' => 'Transfer directly to our bank account',
            'requires_gateway' => false,
        ],
        self::METHOD_STRIPE => [
            'label' => 'Credit/Debit Card (Stripe)',
            'icon' => 'fab fa-cc-stripe',
            'description' => 'Pay securely with Stripe',
            'requires_gateway' => true,
        ],
        self::METHOD_PAYPAL => [
            'label' => 'PayPal',
            'icon' => 'fab fa-paypal',
            'description' => 'Pay with your PayPal account',
            'requires_gateway' => true,
        ],
    ];

    public function getMethods(): array
    {
        return $this->methods;
    }

    public function getMethod(string $key): ?array
    {
        return $this->methods[$key] ?? null;
    }

    public function createPayment(Order $order, string $method): Payment
    {
        return Payment::create([
            'order_id' => $order->id,
            'payment_method' => $method,
            'payment_status' => self::STATUS_PENDING,
            'amount' => $order->total,
            'paid_at' => null,
        ]);
    }

    public function processPayment(Order $order, string $method): array
    {
        $payment = $order->payment ?? $this->createPayment($order, $method);

        return match ($method) {
            self::METHOD_COD => $this->processCOD($order, $payment),
            self::METHOD_BANK_TRANSFER => $this->processBankTransfer($order, $payment),
            self::METHOD_STRIPE => $this->processStripe($order, $payment),
            self::METHOD_PAYPAL => $this->processPayPal($order, $payment),
            default => ['success' => false, 'message' => 'Unsupported payment method.'],
        };
    }

    protected function processCOD(Order $order, Payment $payment): array
    {
        return DB::transaction(function () use ($order, $payment) {
            $order->update([
                'payment_status' => self::STATUS_PENDING,
                'status' => 'confirmed',
                'confirmed_at' => now(),
            ]);

            $payment->update(['payment_status' => self::STATUS_PENDING]);

            Transaction::create([
                'order_id' => $order->id,
                'payment_id' => $payment->id,
                'type' => 'payment',
                'amount' => $order->total,
                'status' => self::STATUS_PENDING,
                'reference' => 'COD-' . $order->order_number,
            ]);

            return [
                'success' => true,
                'message' => 'Order placed successfully. Pay on delivery.',
                'payment' => $payment->fresh(),
            ];
        });
    }

    protected function processBankTransfer(Order $order, Payment $payment): array
    {
        return DB::transaction(function () use ($order, $payment) {
            $order->update([
                'payment_status' => self::STATUS_PENDING,
                'status' => 'pending',
            ]);

            $payment->update(['payment_status' => self::STATUS_PENDING]);

            Transaction::create([
                'order_id' => $order->id,
                'payment_id' => $payment->id,
                'type' => 'payment',
                'amount' => $order->total,
                'status' => self::STATUS_PENDING,
                'reference' => 'BANK-' . $order->order_number,
            ]);

            return [
                'success' => true,
                'message' => 'Order placed. Please complete bank transfer.',
                'payment' => $payment->fresh(),
                'bank_details' => config('ecommerce.bank_details', [
                    'bank' => 'Bank of America',
                    'account_name' => config('app.name'),
                    'account_number' => 'XXXX-XXXX-XXXX',
                    'routing' => 'XXXXXXX',
                ]),
            ];
        });
    }

    protected function processStripe(Order $order, Payment $payment): array
    {
        return [
            'success' => false,
            'message' => 'Stripe integration not configured.',
            'requires_redirect' => true,
            'redirect_url' => route('checkout') . '?payment=stripe',
        ];
    }

    protected function processPayPal(Order $order, Payment $payment): array
    {
        return [
            'success' => false,
            'message' => 'PayPal integration not configured.',
            'requires_redirect' => true,
            'redirect_url' => route('checkout') . '?payment=paypal',
        ];
    }

    public function markAsPaid(Order $order, string $reference = null, array $gatewayResponse = []): Payment
    {
        return DB::transaction(function () use ($order, $reference, $gatewayResponse) {
            $payment = $order->payment;
            if (!$payment) {
                $payment = $this->createPayment($order, 'manual');
            }

            $payment->update([
                'payment_status' => self::STATUS_PAID,
                'paid_at' => now(),
                'transaction_id' => $reference ?? $payment->transaction_id,
                'gateway_response' => $gatewayResponse,
            ]);

            $order->update([
                'payment_status' => self::STATUS_PAID,
                'paid_amount' => $order->total,
                'paid_at' => now(),
                'status' => $order->status === 'pending' ? 'confirmed' : $order->status,
                'confirmed_at' => $order->status === 'pending' ? now() : $order->confirmed_at,
            ]);

            Transaction::create([
                'order_id' => $order->id,
                'payment_id' => $payment->id,
                'type' => 'payment',
                'amount' => $order->total,
                'status' => self::STATUS_PAID,
                'reference' => $reference ?? 'MANUAL-' . $order->order_number,
                'gateway_response' => $gatewayResponse,
            ]);

            return $payment->fresh();
        });
    }

    public function markAsFailed(Order $order, string $reason = null): ?Payment
    {
        return DB::transaction(function () use ($order, $reason) {
            $payment = $order->payment;
            if ($payment) {
                $payment->update([
                    'payment_status' => self::STATUS_FAILED,
                ]);
            }

            $order->update([
                'payment_status' => self::STATUS_FAILED,
            ]);

            Transaction::create([
                'order_id' => $order->id,
                'payment_id' => $payment?->id,
                'type' => 'payment',
                'amount' => $order->total,
                'status' => self::STATUS_FAILED,
                'reference' => 'FAILED-' . $order->order_number,
                'gateway_response' => ['reason' => $reason],
            ]);

            return $payment?->fresh();
        });
    }

    public function refund(Order $order, float $amount = null): ?Payment
    {
        return DB::transaction(function () use ($order, $amount) {
            $payment = $order->payment;
            $refundAmount = $amount ?? $order->paid_amount;

            if ($payment) {
                $payment->update([
                    'payment_status' => self::STATUS_REFUNDED,
                ]);
            }

            $order->update([
                'payment_status' => self::STATUS_REFUNDED,
                'paid_amount' => max(0, $order->paid_amount - $refundAmount),
                'status' => 'refunded',
            ]);

            Transaction::create([
                'order_id' => $order->id,
                'payment_id' => $payment?->id,
                'type' => 'refund',
                'amount' => $refundAmount,
                'status' => self::STATUS_REFUNDED,
                'reference' => 'RFD-' . $order->order_number . '-' . time(),
            ]);

            return $payment?->fresh();
        });
    }

    public function getStatusBadge(string $status): string
    {
        return match ($status) {
            self::STATUS_PAID => 'bg-success',
            self::STATUS_PROCESSING => 'bg-info',
            self::STATUS_PENDING => 'bg-warning text-dark',
            self::STATUS_FAILED => 'bg-danger',
            self::STATUS_REFUNDED => 'bg-secondary',
            self::STATUS_CANCELLED => 'bg-dark',
            default => 'bg-light text-dark',
        };
    }
}
