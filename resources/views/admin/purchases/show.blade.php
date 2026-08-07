<x-layouts.admin-layout title="Purchase Order {{ $purchase->po_number }}">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">{{ $purchase->po_number }}</h4>
            <p class="text-muted small mb-0">
                <span class="badge bg-{{ $purchase->status->color() }}">{{ $purchase->status->label() }}</span>
                <span class="badge bg-{{ $purchase->payment_status->color() }} ms-1">{{ $purchase->payment_status->label() }}</span>
            </p>
        </div>
        <div class="d-flex gap-2">
            @if($purchase->isApprovable())
                <form method="POST" action="{{ route('admin.purchases.approve', $purchase->id) }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success"><i class="fas fa-check-circle me-1"></i> Approve</button>
                </form>
                <form method="POST" action="{{ route('admin.purchases.reject', $purchase->id) }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Reject this purchase order?')"><i class="fas fa-times-circle me-1"></i> Reject</button>
                </form>
            @endif
            @if($purchase->status->value === 'approved')
                <form method="POST" action="{{ route('admin.purchases.mark-ordered', $purchase->id) }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-primary"><i class="fas fa-truck me-1"></i> Mark Ordered</button>
                </form>
            @endif
            @if($purchase->isCancellable() && !$purchase->isApprovable())
                <form method="POST" action="{{ route('admin.purchases.cancel', $purchase->id) }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Cancel this purchase order?')"><i class="fas fa-ban me-1"></i> Cancel</button>
                </form>
            @endif
            @if($purchase->isEditable())
                <a href="{{ route('admin.purchases.edit', $purchase->id) }}" class="btn btn-outline-primary"><i class="fas fa-edit me-1"></i> Edit</a>
            @endif
            <a href="{{ route('admin.purchases.clone', $purchase->id) }}" class="btn btn-outline-secondary"><i class="fas fa-copy me-1"></i> Clone</a>
            <a href="{{ route('admin.purchases.print', $purchase->id) }}" target="_blank" class="btn btn-outline-info"><i class="fas fa-print me-1"></i> Print</a>
            <a href="{{ route('admin.purchases.index') }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i> Back</a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header bg-transparent">
                    <ul class="nav nav-tabs card-header-tabs" role="tablist">
                        <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#items"><i class="fas fa-list me-1"></i> Items</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#receipts"><i class="fas fa-truck-loading me-1"></i> Goods Receipts</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#payments"><i class="fas fa-money-bill me-1"></i> Payments</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#returns"><i class="fas fa-undo me-1"></i> Returns</a></li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        {{-- Items Tab --}}
                        <div class="tab-pane fade show active" id="items">
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Product</th>
                                            <th>SKU</th>
                                            <th class="text-end">Qty</th>
                                            <th class="text-end">Received</th>
                                            <th class="text-end">Price</th>
                                            <th class="text-end">Discount</th>
                                            <th class="text-end">Tax</th>
                                            <th class="text-end">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($purchase->items as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <div class="fw-semibold">{{ $item->product_name }}</div>
                                                    @if($item->variant)<small class="text-muted">{{ $item->variant->name }}</small>@endif
                                                </td>
                                                <td>{{ $item->sku ?: '—' }}</td>
                                                <td class="text-end">{{ $item->quantity }}</td>
                                                <td class="text-end">{{ $item->received_quantity }}</td>
                                                <td class="text-end">{{ number_format($item->unit_price, 2) }}</td>
                                                <td class="text-end">{{ $item->discount > 0 ? number_format($item->discount, 2) : '—' }}</td>
                                                <td class="text-end">{{ $item->tax > 0 ? number_format($item->tax, 2) : '—' }}</td>
                                                <td class="text-end fw-semibold">{{ number_format($item->total, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr><td colspan="8" class="text-end fw-bold">Subtotal:</td><td class="text-end">{{ number_format($purchase->subtotal, 2) }}</td></tr>
                                        @if($purchase->discount_amount > 0)<tr><td colspan="8" class="text-end fw-bold text-danger">Discount:</td><td class="text-end text-danger">-{{ number_format($purchase->discount_amount, 2) }}</td></tr>@endif
                                        @if($purchase->tax_amount > 0)<tr><td colspan="8" class="text-end fw-bold">Tax:</td><td class="text-end">{{ number_format($purchase->tax_amount, 2) }}</td></tr>@endif
                                        @if($purchase->shipping_cost > 0)<tr><td colspan="8" class="text-end fw-bold">Shipping:</td><td class="text-end">{{ number_format($purchase->shipping_cost, 2) }}</td></tr>@endif
                                        <tr class="table-active"><td colspan="8" class="text-end fw-bold fs-5">Grand Total:</td><td class="text-end fs-5 fw-bold">{{ number_format($purchase->total_amount, 2) }}</td></tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        {{-- Goods Receipts Tab --}}
                        <div class="tab-pane fade" id="receipts">
                            @if($purchase->isReceivable())
                                <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#goodsReceiptModal">
                                    <i class="fas fa-truck-loading me-1"></i> Receive Goods
                                </button>
                            @endif

                            @forelse($purchase->goodsReceipts as $receipt)
                                <div class="card mb-3 border">
                                    <div class="card-header bg-transparent d-flex justify-content-between">
                                        <span class="fw-semibold">GRN: {{ $receipt->grn_number }}</span>
                                        <span class="badge bg-{{ $receipt->receipt_type === 'full' ? 'success' : ($receipt->receipt_type === 'remaining' ? 'info' : 'warning') }}">
                                            {{ ucfirst($receipt->receipt_type) }}
                                        </span>
                                    </div>
                                    <div class="card-body py-2">
                                        <small class="text-muted">Received by {{ $receipt->receiver?->name }} on {{ $receipt->received_at?->format('d/m/Y h:i A') }}</small>
                                        @if($receipt->notes)<p class="small mb-2 mt-1">{{ $receipt->notes }}</p>@endif
                                        <table class="table table-sm mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Product</th>
                                                    <th class="text-end">Qty</th>
                                                    <th class="text-end">Price</th>
                                                    <th class="text-end">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($receipt->items as $ri)
                                                    <tr>
                                                        <td>{{ $ri->product?->name }}</td>
                                                        <td class="text-end">{{ $ri->quantity }}</td>
                                                        <td class="text-end">{{ number_format($ri->unit_price, 2) }}</td>
                                                        <td class="text-end">{{ number_format($ri->subtotal, 2) }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted text-center py-4">No goods receipts yet.</p>
                            @endforelse
                        </div>

                        {{-- Payments Tab --}}
                        <div class="tab-pane fade" id="payments">
                            @if(!in_array($purchase->status->value, ['draft', 'cancelled', 'returned']))
                                <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#paymentModal">
                                    <i class="fas fa-plus-circle me-1"></i> Add Payment
                                </button>
                            @endif

                            <div class="mb-3">
                                <div class="row g-2">
                                    <div class="col-md-4">
                                        <div class="card bg-light">
                                            <div class="card-body text-center py-2">
                                                <small class="text-muted">Total Amount</small>
                                                <h5 class="mb-0">{{ number_format($purchase->total_amount, 2) }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card bg-success-subtle">
                                            <div class="card-body text-center py-2">
                                                <small class="text-muted">Paid</small>
                                                <h5 class="mb-0 text-success">{{ number_format($purchase->paid_amount, 2) }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card bg-danger-subtle">
                                            <div class="card-body text-center py-2">
                                                <small class="text-muted">Due</small>
                                                <h5 class="mb-0 text-danger">{{ number_format($purchase->due_amount, 2) }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if($purchase->payments->isNotEmpty())
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Method</th>
                                                <th>Reference</th>
                                                <th class="text-end">Amount</th>
                                                <th>Notes</th>
                                                <th>By</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($purchase->payments as $payment)
                                                <tr>
                                                    <td>{{ $payment->payment_date?->format('d/m/Y') }}</td>
                                                    <td><span class="badge bg-info">{{ ucwords(str_replace('_', ' ', $payment->payment_method)) }}</span></td>
                                                    <td><small>{{ $payment->reference_number ?: '—' }}</small></td>
                                                    <td class="text-end fw-semibold text-success">{{ number_format($payment->amount, 2) }}</td>
                                                    <td><small>{{ $payment->notes ?: '—' }}</small></td>
                                                    <td><small>{{ $payment->creator?->name }}</small></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr class="fw-bold">
                                                <td colspan="3" class="text-end">Total Paid:</td>
                                                <td class="text-end text-success">{{ number_format($purchase->payments->sum('amount'), 2) }}</td>
                                                <td colspan="2"></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            @else
                                <p class="text-muted text-center py-4">No payments recorded yet.</p>
                            @endif
                        </div>

                        {{-- Returns Tab --}}
                        <div class="tab-pane fade" id="returns">
                            @if(in_array($purchase->status->value, ['completed', 'partially_received']))
                                <button type="button" class="btn btn-warning mb-3" data-bs-toggle="modal" data-bs-target="#returnModal">
                                    <i class="fas fa-undo me-1"></i> Return Items
                                </button>
                            @endif

                            @forelse($purchase->returns as $return)
                                <div class="card mb-2 border">
                                    <div class="card-body py-2 d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="fw-semibold">{{ $return->product?->name }}</span>
                                            @if($return->variant)<br><small class="text-muted">{{ $return->variant->name }}</small>@endif
                                            <br><small class="text-muted">{{ $return->return_number }} | {{ $return->return_date?->format('d/m/Y') }}</small>
                                        </div>
                                        <div class="text-end">
                                            <div class="fw-semibold">{{ $return->quantity }} x {{ number_format($return->unit_price, 2) }}</div>
                                            <small>Total: {{ number_format($return->total_amount, 2) }}</small>
                                            <br><span class="badge bg-{{ $return->refund_status === 'processed' ? 'success' : ($return->refund_status === 'declined' ? 'danger' : 'warning') }}">{{ ucfirst($return->refund_status) }}</span>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted text-center py-4">No returns recorded.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Purchase Details</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted small text-uppercase">Supplier</label>
                        <p class="fw-semibold mb-0">{{ $purchase->supplier?->name }}</p>
                        <small class="text-muted">{{ $purchase->supplier?->supplier_code }}</small>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small text-uppercase">Warehouse</label>
                        <p class="fw-semibold mb-0">{{ $purchase->warehouse?->name }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small text-uppercase">Purchase Date</label>
                        <p class="fw-semibold mb-0">{{ $purchase->purchase_date?->format('d M, Y') }}</p>
                    </div>
                    @if($purchase->expected_delivery_date)
                        <div class="mb-3">
                            <label class="text-muted small text-uppercase">Expected Delivery</label>
                            <p class="fw-semibold mb-0">{{ $purchase->expected_delivery_date?->format('d M, Y') }}</p>
                        </div>
                    @endif
                    @if($purchase->reference_number)
                        <div class="mb-3">
                            <label class="text-muted small text-uppercase">Reference</label>
                            <p class="fw-semibold mb-0">{{ $purchase->reference_number }}</p>
                        </div>
                    @endif
                    <div class="mb-3">
                        <label class="text-muted small text-uppercase">Currency</label>
                        <p class="fw-semibold mb-0">{{ $purchase->currency }} @if($purchase->exchange_rate != 1)(Rate: {{ $purchase->exchange_rate }})@endif</p>
                    </div>
                </div>
            </div>

            @if($purchase->notes)
                <div class="card mb-4">
                    <div class="card-header bg-transparent">
                        <h6 class="fw-bold mb-0">Notes</h6>
                    </div>
                    <div class="card-body">
                        <p class="small mb-0">{{ $purchase->notes }}</p>
                    </div>
                </div>
            @endif

            @if($purchase->terms)
                <div class="card mb-4">
                    <div class="card-header bg-transparent">
                        <h6 class="fw-bold mb-0">Terms</h6>
                    </div>
                    <div class="card-body">
                        <p class="small mb-0">{{ $purchase->terms }}</p>
                    </div>
                </div>
            @endif

            <div class="card">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Timeline</h6>
                </div>
                <div class="card-body">
                    <ul class="timeline list-unstyled mb-0">
                        <li class="mb-2">
                            <small class="text-muted">Created</small>
                            <p class="mb-0 small">{{ $purchase->created_at?->format('d M Y, h:i A') }} by {{ $purchase->creator?->name ?? 'N/A' }}</p>
                        </li>
                        @if($purchase->approved_at)
                            <li class="mb-2">
                                <small class="text-muted">Approved</small>
                                <p class="mb-0 small">{{ $purchase->approved_at?->format('d M Y, h:i A') }} by {{ $purchase->approver?->name ?? 'N/A' }}</p>
                            </li>
                        @endif
                        @if($purchase->ordered_at)
                            <li class="mb-2">
                                <small class="text-muted">Ordered</small>
                                <p class="mb-0 small">{{ $purchase->ordered_at?->format('d M Y, h:i A') }}</p>
                            </li>
                        @endif
                        @if($purchase->completed_at)
                            <li class="mb-2">
                                <small class="text-muted">Completed</small>
                                <p class="mb-0 small">{{ $purchase->completed_at?->format('d M Y, h:i A') }}</p>
                            </li>
                        @endif
                        @if($purchase->cancelled_at)
                            <li class="mb-2">
                                <small class="text-muted">Cancelled</small>
                                <p class="mb-0 small">{{ $purchase->cancelled_at?->format('d M Y, h:i A') }}</p>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Goods Receipt Modal --}}
    <div class="modal fade" id="goodsReceiptModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin.purchases.receive', $purchase->id) }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Receive Goods</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Receipt Type <span class="text-danger">*</span></label>
                            <select name="receipt_type" class="form-select" id="receiptType" onchange="toggleReceiptItems()">
                                <option value="full">Full Receipt</option>
                                <option value="partial">Partial Receipt</option>
                                <option value="remaining">Receive Remaining</option>
                            </select>
                        </div>
                        <div id="partialItemsSection" class="d-none">
                            <label class="form-label">Quantities to receive</label>
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Ordered</th>
                                        <th>Received</th>
                                        <th>Pending</th>
                                        <th>Receive</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($purchase->items as $item)
                                        <tr>
                                            <td>{{ $item->product_name }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>{{ $item->received_quantity }}</td>
                                            <td>{{ $item->pending_quantity }}</td>
                                            <td>
                                                <input type="number" name="items[{{ $item->id }}]" class="form-control form-control-sm"
                                                       value="{{ $item->pending_quantity }}" min="0" max="{{ $item->pending_quantity }}" step="any"
                                                       data-pending="{{ $item->pending_quantity }}">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Notes</label>
                            <textarea name="notes" class="form-control" rows="2" placeholder="Optional notes about receipt"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success"><i class="fas fa-check me-1"></i> Receive Goods</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Payment Modal --}}
    <div class="modal fade" id="paymentModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin.purchases.payment', $purchase->id) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add Payment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Amount <span class="text-danger">*</span></label>
                            <input type="number" name="amount" class="form-control" step="0.01" min="0.01" max="{{ $purchase->due_amount }}" required>
                            <small class="text-muted">Due amount: {{ number_format($purchase->due_amount, 2) }}</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Payment Method <span class="text-danger">*</span></label>
                            <select name="payment_method" class="form-select" required>
                                <option value="cash">Cash</option>
                                <option value="bank">Bank Transfer</option>
                                <option value="mobile_banking">Mobile Banking</option>
                                <option value="credit">Credit</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Reference Number</label>
                            <input type="text" name="reference_number" class="form-control" placeholder="Cheque / Transaction ID">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Payment Date</label>
                            <input type="date" name="payment_date" class="form-control" value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Notes</label>
                            <textarea name="notes" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success"><i class="fas fa-check me-1"></i> Add Payment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Return Modal --}}
    <div class="modal fade" id="returnModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin.purchases.return', $purchase->id) }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Return Items</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Received</th>
                                    <th>Returned</th>
                                    <th>Returnable</th>
                                    <th>Qty to Return</th>
                                    <th>Reason</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($purchase->items as $item)
                                    @php $returnable = $item->received_quantity - $item->returned_quantity; @endphp
                                    @if($returnable > 0)
                                        <tr>
                                            <td>{{ $item->product_name }}</td>
                                            <td>{{ $item->received_quantity }}</td>
                                            <td>{{ $item->returned_quantity }}</td>
                                            <td>{{ $returnable }}</td>
                                            <td>
                                                <input type="hidden" name="items[{{ $loop->index }}][purchase_item_id]" value="{{ $item->id }}">
                                                <input type="number" name="items[{{ $loop->index }}][quantity]" class="form-control form-control-sm" min="0" max="{{ $returnable }}" step="any" value="0">
                                            </td>
                                            <td>
                                                <select name="items[{{ $loop->index }}][reason]" class="form-select form-select-sm">
                                                    <option value="Damaged">Damaged</option>
                                                    <option value="Defective">Defective</option>
                                                    <option value="Wrong Item">Wrong Item</option>
                                                    <option value="Quality Issue">Quality Issue</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-warning"><i class="fas fa-undo me-1"></i> Return Items</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-layouts.admin-layout>

@push('scripts')
<script>
function toggleReceiptItems() {
    const type = document.getElementById('receiptType').value;
    document.getElementById('partialItemsSection').classList.toggle('d-none', type !== 'partial');
}
</script>
@endpush
