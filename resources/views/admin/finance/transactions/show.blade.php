<x-layouts.admin-layout title="Transaction Details">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">{{ $transaction->transaction_number }}</h4>
            <p class="text-muted small mb-0">
                <span class="badge bg-{{ $transaction->type === 'sale' ? 'success' : ($transaction->type === 'expense' || $transaction->type === 'refund' ? 'danger' : 'primary') }}">{{ str_replace('_', ' ', $transaction->type) }}</span>
                <span class="badge bg-{{ $transaction->status === 'completed' ? 'success' : ($transaction->status === 'failed' ? 'danger' : 'warning') }} ms-1">{{ $transaction->status }}</span>
                <span class="badge bg-{{ $transaction->direction === 'inflow' ? 'success' : 'danger' }} ms-1">{{ ucfirst($transaction->direction) }}</span>
            </p>
        </div>
        <a href="{{ route('admin.finance.transactions.index') }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i> Back</a>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header bg-transparent"><h6 class="fw-bold mb-0">Transaction Info</h6></div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-6"><label class="text-muted small text-uppercase">Amount</label><p class="fw-bold fs-5 mb-0 {{ $transaction->direction === 'inflow' ? 'text-success' : 'text-danger' }}">{{ number_format($transaction->amount, 2) }}</p></div>
                        <div class="col-6"><label class="text-muted small text-uppercase">Net Amount</label><p class="fw-bold fs-5 mb-0">{{ number_format($transaction->net_amount, 2) }}</p></div>
                        @if($transaction->fee > 0)
                        <div class="col-6"><label class="text-muted small text-uppercase">Fee</label><p class="mb-0 text-danger">{{ number_format($transaction->fee, 2) }}</p></div>
                        @endif
                        <div class="col-6"><label class="text-muted small text-uppercase">Currency</label><p class="fw-semibold mb-0">{{ $transaction->currency }}</p></div>
                        <div class="col-6"><label class="text-muted small text-uppercase">Date</label><p class="mb-0">{{ $transaction->transaction_date?->format('d M, Y') }}</p></div>
                        <div class="col-6"><label class="text-muted small text-uppercase">Payment Method</label><p class="mb-0">{{ $transaction->payment_method ?: '—' }}</p></div>
                        @if($transaction->reference_number)
                        <div class="col-6"><label class="text-muted small text-uppercase">Reference</label><p class="mb-0">{{ $transaction->reference_number }}</p></div>
                        @endif
                        @if($transaction->description)
                        <div class="col-12"><label class="text-muted small text-uppercase">Description</label><p class="mb-0">{{ $transaction->description }}</p></div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header bg-transparent"><h6 class="fw-bold mb-0">Account Info</h6></div>
                <div class="card-body">
                    <div class="mb-3"><label class="text-muted small text-uppercase">Chart of Account</label><p class="fw-semibold mb-0">{{ $transaction->chartOfAccount?->name ?? '—' }}</p></div>
                    <div class="mb-3"><label class="text-muted small text-uppercase">Created By</label><p class="mb-0">{{ $transaction->creator?->name ?? '—' }}</p></div>
                    <div class="mb-3"><label class="text-muted small text-uppercase">Created At</label><p class="mb-0">{{ $transaction->created_at?->format('d M Y, h:i A') }}</p></div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin-layout>
