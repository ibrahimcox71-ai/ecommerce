<?php

namespace App\Services;

use App\Enums\TransactionType;
use App\Models\Transaction;
use App\Models\Order;
use App\Models\Expense;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class FinancePaymentService
{
    public function recordPaymentReceived(array $data): Transaction
    {
        return DB::transaction(function () use ($data) {
            $data['transaction_number'] = Transaction::generateTransactionNumber();
            $data['direction'] = 'inflow';
            $data['net_amount'] = ($data['amount'] ?? 0) - ($data['fee'] ?? 0);

            $transaction = Transaction::create($data);

            if (isset($data['order_id'])) {
                $order = Order::find($data['order_id']);
                if ($order) {
                    $newPaid = $order->paid_amount + $data['amount'];
                    $status = $newPaid >= $order->total ? 'paid' : 'partial';
                    $order->update([
                        'paid_amount' => $newPaid,
                        'payment_status' => $status,
                        'paid_at' => $status === 'paid' ? now() : $order->paid_at,
                    ]);
                }
            }

            return $transaction->fresh(['chartOfAccount', 'creator']);
        });
    }

    public function recordPaymentSent(array $data): Transaction
    {
        return DB::transaction(function () use ($data) {
            $data['transaction_number'] = Transaction::generateTransactionNumber();
            $data['direction'] = 'outflow';
            $data['net_amount'] = ($data['amount'] ?? 0) + ($data['fee'] ?? 0);

            $transaction = Transaction::create($data);

            return $transaction->fresh(['chartOfAccount', 'creator']);
        });
    }

    public function getPaymentMethods(): array
    {
        return [
            ['id' => 'cash', 'name' => 'Cash'],
            ['id' => 'bank_transfer', 'name' => 'Bank Transfer'],
            ['id' => 'check', 'name' => 'Check'],
            ['id' => 'mobile_banking', 'name' => 'Mobile Banking'],
            ['id' => 'credit_card', 'name' => 'Credit Card'],
            ['id' => 'debit_card', 'name' => 'Debit Card'],
            ['id' => 'online', 'name' => 'Online Payment'],
            ['id' => 'other', 'name' => 'Other'],
        ];
    }
}
