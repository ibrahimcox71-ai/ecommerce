<?php

namespace App\Services;

use App\Enums\PurchasePaymentStatus;
use App\Models\Admin;
use App\Models\Purchase;
use App\Models\PurchasePayment;
use App\Repositories\PurchaseRepository;
use Illuminate\Support\Facades\DB;

class PurchasePaymentService
{
    public function makePayment(int $purchaseId, array $data, Admin $user): PurchasePayment
    {
        return DB::transaction(function () use ($purchaseId, $data, $user) {
            $purchase = app(PurchaseRepository::class)->findOrFail($purchaseId);

            if (in_array($purchase->status->value, ['draft', 'cancelled', 'returned'])) {
                throw new \RuntimeException('Cannot add payment to this purchase order.');
            }

            $payment = PurchasePayment::create([
                'purchase_id' => $purchase->id,
                'payment_method' => $data['payment_method'],
                'reference_number' => $data['reference_number'] ?? null,
                'amount' => $data['amount'],
                'payment_date' => $data['payment_date'] ?? now(),
                'currency' => $data['currency'] ?? $purchase->currency,
                'exchange_rate' => $data['exchange_rate'] ?? $purchase->exchange_rate,
                'notes' => $data['notes'] ?? null,
                'attachment' => $data['attachment'] ?? null,
                'created_by' => $user->id,
            ]);

            $newPaid = $purchase->paid_amount + $data['amount'];
            $newDue = $purchase->total_amount - $newPaid;

            $paymentStatus = $newDue <= 0
                ? PurchasePaymentStatus::Paid->value
                : PurchasePaymentStatus::Partial->value;

            $purchase->update([
                'paid_amount' => $newPaid,
                'due_amount' => max(0, $newDue),
                'payment_status' => $paymentStatus,
            ]);

            $purchase->supplier()->update(['last_purchase_date' => now()]);

            return $payment->load(['creator']);
        });
    }
}
