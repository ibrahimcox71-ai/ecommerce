<x-layouts.admin-layout title="Order Returns">

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Order Returns</h4>
        <p class="text-muted small mb-0">Manage return requests and refunds</p>
    </div>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Back to Orders
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form method="GET" class="row g-2 mb-3">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Search return # or order #..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="pending" @selected(request('status') === 'pending')>Pending</option>
                    <option value="approved" @selected(request('status') === 'approved')>Approved</option>
                    <option value="rejected" @selected(request('status') === 'rejected')>Rejected</option>
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
                        <th>Order #</th>
                        <th>Reason</th>
                        <th>Qty</th>
                        <th class="text-end">Amount</th>
                        <th>Status</th>
                        <th>Refund Status</th>
                        <th>Date</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($returns as $return)
                        <tr>
                            <td class="fw-semibold">{{ $return->return_number }}</td>
                            <td>
                                <a href="{{ route('admin.orders.show', $return->order_id) }}" class="text-decoration-none">
                                    {{ $return->order->order_number ?? '—' }}
                                </a>
                            </td>
                            <td><small>{{ $return->reason }}</small></td>
                            <td class="text-center">{{ $return->quantity }}</td>
                            <td class="text-end fw-semibold">{{ config('ecommerce.currency_symbol', '$') }}{{ number_format($return->refund_amount, 2) }}</td>
                            <td><span class="badge {{ $return->statusBadge() }}">{{ ucfirst($return->status) }}</span></td>
                            <td>
                                @if($return->refund_status)
                                    <span class="badge bg-{{ $return->refund_status === 'refunded' ? 'success' : 'warning' }}">{{ ucfirst($return->refund_status) }}</span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td><small class="text-muted">{{ $return->created_at->format('M d, Y') }}</small></td>
                            <td class="text-center">
                                <a href="{{ route('admin.orders.returns.show', $return) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="9" class="text-center py-4 text-muted">No return requests found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-3">
            {{ $returns->withQueryString()->links() }}
        </div>
    </div>
</div>

</x-layouts.admin-layout>
