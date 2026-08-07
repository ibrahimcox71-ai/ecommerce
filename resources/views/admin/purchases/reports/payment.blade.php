<x-layouts.admin-layout title="Purchase Payment Report">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Payment Report</h4>
            <p class="text-muted small mb-0">Track all purchase payments</p>
        </div>
        <a href="{{ route('admin.purchases.reports') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to Reports
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="GET" class="row g-2 mb-3">
                <div class="col-md-3">
                    <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}" placeholder="From">
                </div>
                <div class="col-md-3">
                    <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}" placeholder="To">
                </div>
                <div class="col-md-3">
                    <select name="payment_method" class="form-select">
                        <option value="">All Methods</option>
                        <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                        <option value="bank" {{ request('payment_method') == 'bank' ? 'selected' : '' }}>Bank</option>
                        <option value="mobile_banking" {{ request('payment_method') == 'mobile_banking' ? 'selected' : '' }}>Mobile Banking</option>
                        <option value="credit" {{ request('payment_method') == 'credit' ? 'selected' : '' }}>Credit</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i></button>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>PO Number</th>
                            <th>Supplier</th>
                            <th>Method</th>
                            <th>Reference</th>
                            <th class="text-end">Amount</th>
                            <th>Notes</th>
                            <th>Created By</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $payment)
                            <tr>
                                <td>{{ $payment->payment_date?->format('d/m/Y') }}</td>
                                <td><a href="{{ route('admin.purchases.show', $payment->purchase_id) }}">{{ $payment->purchase?->po_number }}</a></td>
                                <td>{{ $payment->purchase?->supplier?->name }}</td>
                                <td><span class="badge bg-info">{{ ucwords(str_replace('_', ' ', $payment->payment_method)) }}</span></td>
                                <td><small>{{ $payment->reference_number ?: '—' }}</small></td>
                                <td class="text-end fw-semibold text-success">{{ number_format($payment->amount, 2) }}</td>
                                <td><small>{{ $payment->notes ?: '—' }}</small></td>
                                <td><small>{{ $payment->creator?->name }}</small></td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="text-center py-4 text-muted">No payments found.</td></tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr class="fw-bold">
                            <td colspan="5" class="text-end">Total:</td>
                            <td class="text-end">{{ number_format($payments->sum('amount'), 2) }}</td>
                            <td colspan="2"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

</x-layouts.admin-layout>
