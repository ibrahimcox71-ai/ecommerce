<x-layouts.admin-layout title="Purchase Return Report">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Purchase Return Report</h4>
            <p class="text-muted small mb-0">Track returned items and refunds</p>
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
                    <select name="refund_status" class="form-select">
                        <option value="">All Refund Status</option>
                        <option value="pending" {{ request('refund_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processed" {{ request('refund_status') == 'processed' ? 'selected' : '' }}>Processed</option>
                        <option value="declined" {{ request('refund_status') == 'declined' ? 'selected' : '' }}>Declined</option>
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
                            <th>Return #</th>
                            <th>PO Number</th>
                            <th>Supplier</th>
                            <th>Product</th>
                            <th class="text-end">Qty</th>
                            <th class="text-end">Amount</th>
                            <th>Reason</th>
                            <th>Refund Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($returns as $return)
                            <tr>
                                <td><small>{{ $return->return_number }}</small></td>
                                <td><a href="{{ route('admin.purchases.show', $return->purchase_id) }}">{{ $return->purchase?->po_number }}</a></td>
                                <td>{{ $return->purchase?->supplier?->name }}</td>
                                <td>
                                    {{ $return->product?->name }}
                                    @if($return->variant)<br><small class="text-muted">{{ $return->variant->name }}</small>@endif
                                </td>
                                <td class="text-end">{{ $return->quantity }}</td>
                                <td class="text-end fw-semibold">{{ number_format($return->total_amount, 2) }}</td>
                                <td><small>{{ $return->reason ?: '—' }}</small></td>
                                <td>
                                    <span class="badge bg-{{ $return->refund_status === 'processed' ? 'success' : ($return->refund_status === 'declined' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($return->refund_status) }}
                                    </span>
                                </td>
                                <td><small>{{ $return->return_date?->format('d/m/Y') }}</small></td>
                            </tr>
                        @empty
                            <tr><td colspan="9" class="text-center py-4 text-muted">No returns found.</td></tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr class="fw-bold">
                            <td colspan="4" class="text-end">Totals:</td>
                            <td class="text-end">{{ $returns->sum('quantity') }}</td>
                            <td class="text-end">{{ number_format($returns->sum('total_amount'), 2) }}</td>
                            <td colspan="3"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

</x-layouts.admin-layout>
