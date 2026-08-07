<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\ChartOfAccount;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TransactionController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->only(['search', 'type', 'direction', 'status', 'date_from', 'date_to', 'payment_method']);

        $transactions = Transaction::with(['chartOfAccount', 'creator'])
            ->when($filters['search'] ?? null, fn($q, $v) => $q->where(function($sq) use ($v) {
                $sq->where('transaction_number', 'like', "%{$v}%")
                    ->orWhere('description', 'like', "%{$v}%")
                    ->orWhere('reference_number', 'like', "%{$v}%");
            }))
            ->when($filters['type'] ?? null, fn($q, $v) => $q->where('type', $v))
            ->when($filters['direction'] ?? null, fn($q, $v) => $q->where('direction', $v))
            ->when($filters['status'] ?? null, fn($q, $v) => $q->where('status', $v))
            ->when($filters['payment_method'] ?? null, fn($q, $v) => $q->where('payment_method', $v))
            ->when($filters['date_from'] ?? null, fn($q, $v) => $q->whereDate('transaction_date', '>=', $v))
            ->when($filters['date_to'] ?? null, fn($q, $v) => $q->whereDate('transaction_date', '<=', $v))
            ->latest()
            ->paginate(15);

        $stats = [
            'total_inflow' => Transaction::completed()->inflow()->sum('net_amount'),
            'total_outflow' => Transaction::completed()->outflow()->sum('net_amount'),
            'total_count' => Transaction::count(),
            'pending_count' => Transaction::where('status', 'pending')->count(),
        ];

        return view('admin.finance.transactions.index', compact('transactions', 'filters', 'stats'));
    }

    public function show(Transaction $transaction): View
    {
        $transaction->load(['chartOfAccount', 'creator']);

        return view('admin.finance.transactions.show', compact('transaction'));
    }

    public function exportCsv(Request $request): \Illuminate\Http\Response
    {
        $filters = $request->only(['type', 'direction', 'status', 'date_from', 'date_to']);
        $transactions = Transaction::with(['chartOfAccount', 'creator'])
            ->when($filters['type'] ?? null, fn($q, $v) => $q->where('type', $v))
            ->when($filters['direction'] ?? null, fn($q, $v) => $q->where('direction', $v))
            ->when($filters['status'] ?? null, fn($q, $v) => $q->where('status', $v))
            ->when($filters['date_from'] ?? null, fn($q, $v) => $q->whereDate('transaction_date', '>=', $v))
            ->when($filters['date_to'] ?? null, fn($q, $v) => $q->whereDate('transaction_date', '<=', $v))
            ->latest()
            ->get();

        $filename = 'transactions-' . now()->format('Y-m-d-His') . '.csv';
        $handle = fopen('php://temp', 'w+');

        fputcsv($handle, ['Transaction #', 'Type', 'Direction', 'Amount', 'Fee', 'Net', 'Currency', 'Payment Method', 'Reference', 'Description', 'Date', 'Status', 'Account']);

        foreach ($transactions as $t) {
            fputcsv($handle, [
                $t->transaction_number, $t->type, $t->direction, $t->amount, $t->fee, $t->net_amount,
                $t->currency, $t->payment_method, $t->reference_number, $t->description,
                $t->transaction_date?->format('Y-m-d'), $t->status, $t->chartOfAccount?->name,
            ]);
        }

        rewind($handle);
        $content = stream_get_contents($handle);
        fclose($handle);

        return response($content, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ]);
    }
}
