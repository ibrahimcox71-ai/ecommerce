<x-layouts.admin-layout title="Return {{ $return->return_number }}">

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <a href="{{ route('admin.orders.returns.index') }}" class="text-muted text-decoration-none small">
            <i class="fas fa-arrow-left me-1"></i>Back to Returns
        </a>
        <h4 class="fw-bold mb-0 mt-1">Return #{{ $return->return_number }}</h4>
        <p class="text-muted small mb-0">
            <span class="badge {{ $return->statusBadge() }}">{{ ucfirst($return->status) }}</span>
            @if($return->refund_status)
                <span class="badge bg-{{ $return->refund_status === 'refunded' ? 'success' : 'warning' }} ms-1">{{ ucfirst($return->refund_status) }}</span>
            @endif
        </p>
    </div>
    <div class="d-flex gap-2">
        @if($return->isPending())
            <form method="POST" action="{{ route('admin.orders.returns.approve', $return) }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-success"><i class="fas fa-check-circle me-1"></i>Approve</button>
            </form>
            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                <i class="fas fa-times-circle me-1"></i>Reject
            </button>
        @endif
        @if($return->isApproved() && !$return->isRefunded())
            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#refundModal">
                <i class="fas fa-undo me-1"></i>Process Refund
            </button>
        @endif
        <a href="{{ route('admin.orders.show', $return->order_id) }}" class="btn btn-outline-secondary">
            <i class="fas fa-eye me-1"></i> View Order
        </a>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="fw-bold mb-0"><i class="fas fa-info-circle me-2 text-primary"></i>Return Details</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <small class="text-muted d-block">Order Number</small>
                        <strong>{{ $return->order->order_number ?? '—' }}</strong>
                    </div>
                    <div class="col-md-3">
                        <small class="text-muted d-block">Quantity</small>
                        <strong>{{ $return->quantity }}</strong>
                    </div>
                    <div class="col-md-3">
                        <small class="text-muted d-block">Refund Amount</small>
                        <strong class="text-success">{{ config('ecommerce.currency_symbol', '$') }}{{ number_format($return->refund_amount, 2) }}</strong>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted d-block">Reason</small>
                        <strong>{{ $return->reason }}</strong>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted d-block">Created By</small>
                        <strong>{{ $return->creator?->name ?? 'Customer' }}</strong>
                    </div>
                    @if($return->customer_notes)
                        <div class="col-12">
                            <small class="text-muted d-block">Customer Notes</small>
                            <p class="mb-0">{{ $return->customer_notes }}</p>
                        </div>
                    @endif
                    @if($return->staff_notes)
                        <div class="col-12">
                            <small class="text-muted d-block">Staff Notes</small>
                            <p class="mb-0">{{ $return->staff_notes }}</p>
                        </div>
                    @endif
                    @if($return->rejection_reason)
                        <div class="col-12">
                            <small class="text-muted d-block text-danger">Rejection Reason</small>
                            <p class="mb-0 text-danger">{{ $return->rejection_reason }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        @if($return->orderItem)
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="fw-bold mb-0"><i class="fas fa-box me-2 text-primary"></i>Returned Item</h5>
            </div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Product</th>
                            <th>SKU</th>
                            <th class="text-center">Qty</th>
                            <th class="text-end">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="fw-semibold">{{ $return->orderItem->product_name }}</td>
                            <td>{{ $return->orderItem->product_sku ?? '—' }}</td>
                            <td class="text-center">{{ $return->quantity }}</td>
                            <td class="text-end">{{ config('ecommerce.currency_symbol', '$') }}{{ number_format($return->orderItem->unit_price, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white py-3">
                <h6 class="fw-bold mb-0"><i class="fas fa-clock me-2 text-primary"></i>Timeline</h6>
            </div>
            <div class="card-body p-3">
                <div class="d-flex gap-3 mb-3">
                    <div><i class="fas fa-circle text-primary" style="font-size: 8px;"></i></div>
                    <div>
                        <small class="fw-semibold d-block">Return Requested</small>
                        <small class="text-muted">{{ $return->created_at->format('M d, Y h:i A') }}</small>
                    </div>
                </div>
                @if($return->approved_at)
                <div class="d-flex gap-3 mb-3">
                    <div><i class="fas fa-circle text-success" style="font-size: 8px;"></i></div>
                    <div>
                        <small class="fw-semibold d-block">Approved by {{ $return->approver?->name ?? 'System' }}</small>
                        <small class="text-muted">{{ $return->approved_at->format('M d, Y h:i A') }}</small>
                    </div>
                </div>
                @endif
                @if($return->rejected_at)
                <div class="d-flex gap-3 mb-3">
                    <div><i class="fas fa-circle text-danger" style="font-size: 8px;"></i></div>
                    <div>
                        <small class="fw-semibold d-block">Rejected</small>
                        <small class="text-muted">{{ $return->rejected_at->format('M d, Y h:i A') }}</small>
                    </div>
                </div>
                @endif
                @if($return->refunded_at)
                <div class="d-flex gap-3">
                    <div><i class="fas fa-circle text-secondary" style="font-size: 8px;"></i></div>
                    <div>
                        <small class="fw-semibold d-block">Refund Processed</small>
                        <small class="text-muted">{{ $return->refunded_at->format('M d, Y h:i A') }}</small>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Reject Modal --}}
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.orders.returns.reject', $return) }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Reject Return</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label">Rejection Reason</label>
                    <textarea name="rejection_reason" class="form-control" rows="3" required></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Reject Return</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Refund Modal --}}
<div class="modal fade" id="refundModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.orders.returns.process-refund', $return) }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Process Refund</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label">Refund Amount</label>
                    <input type="number" name="refund_amount" class="form-control" step="0.01" min="0" value="{{ $return->refund_amount }}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning">Process Refund</button>
                </div>
            </form>
        </div>
    </div>
</div>

</x-layouts.admin-layout>
