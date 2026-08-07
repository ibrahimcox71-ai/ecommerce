<x-layouts.admin-layout title="Order {{ $order->order_number }}">

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <a href="{{ route('admin.orders.index') }}" class="text-muted text-decoration-none small">
            <i class="fas fa-arrow-left me-1"></i>Back to Orders
        </a>
        <h4 class="fw-bold mb-1 mt-1">Order #{{ $order->order_number }}</h4>
        <p class="text-muted small mb-0">
            @php $s = App\Enums\OrderStatus::tryFrom($order->status); @endphp
            <span class="badge {{ $s?->badgeClass() ?? 'bg-light text-dark' }} fs-6">{{ $s?->label() ?? ucfirst($order->status) }}</span>
            <span class="badge {{ $order->paymentStatusBadge() }} fs-6 ms-1">{{ ucfirst($order->payment_status) }}</span>
            @if($order->order_origin !== 'website')
                <span class="badge bg-light text-dark fs-6 ms-1">{{ ucfirst($order->order_origin) }}</span>
            @endif
        </p>
    </div>
    <div class="d-flex gap-2 flex-wrap">
        @foreach($allowedTransitions as $transition)
            <button type="button" class="btn btn-outline-{{ $transition->color() }}"
                    onclick="document.getElementById('status-form').querySelector('[name=status]').value='{{ $transition->value }}';document.getElementById('status-form').submit();">
                <i class="fas {{ $transition->icon() ? 'fa-' . str_replace('bi-', '', $transition->icon()) : 'fa-arrow-right' }} me-1"></i>
                {{ $transition->label() }}
            </button>
        @endforeach
        <div class="dropdown">
            <button class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                <i class="fas fa-cog me-1"></i> Actions
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="{{ route('admin.orders.print', $order) }}" target="_blank"><i class="fas fa-print me-2"></i>Print Order</a></li>
                <li><a class="dropdown-item" href="{{ route('admin.orders.invoice', $order) }}" target="_blank"><i class="fas fa-file-invoice me-2"></i>View Invoice</a></li>
                <li><hr class="dropdown-divider"></li>
                @if($order->isEditable())
                    <li><a class="dropdown-item" href="{{ route('admin.orders.edit', $order) }}"><i class="fas fa-edit me-2"></i>Edit Order</a></li>
                @endif
                <li>
                    <form method="POST" action="{{ route('admin.orders.duplicate', $order) }}" class="d-inline">
                        @csrf
                        <button type="submit" class="dropdown-item"><i class="fas fa-copy me-2"></i>Duplicate</button>
                    </form>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="{{ route('admin.orders.export.csv', ['status' => $order->status]) }}"><i class="fas fa-file-csv me-2 text-success"></i>Export CSV</a></li>
                <li><a class="dropdown-item" href="{{ route('admin.orders.export.excel', ['status' => $order->status]) }}"><i class="fas fa-file-excel me-2 text-primary"></i>Export Excel</a></li>
                @if($order->isDeletable())
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('admin.orders.destroy', $order) }}" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Delete this order permanently?')"><i class="fas fa-trash me-2"></i>Delete</button>
                        </form>
                    </li>
                @endif
            </ul>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i> Back</a>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        {{-- Hidden status form --}}
        <form id="status-form" method="POST" action="{{ route('admin.orders.update-status', $order) }}" class="d-none">
            @csrf
            <input type="hidden" name="status">
        </form>

        {{-- Order Items --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0"><i class="fas fa-box me-2 text-primary"></i>Order Items</h5>
                <span>{{ $order->getItemCount() }} item(s)</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Product</th>
                                <th>SKU</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Unit Price</th>
                                <th class="text-end">Discount</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->items as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            @if ($item->product_image)
                                                <img src="{{ $item->product_image }}" alt="{{ $item->product_name }}"
                                                     style="width: 40px; height: 40px; object-fit: cover;" class="rounded" loading="lazy">
                                            @else
                                                <div class="rounded bg-light d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                    <i class="fas fa-box text-muted"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <span class="fw-semibold small">{{ $item->product_name }}</span>
                                                @if($item->variant)<br><small class="text-muted">{{ $item->variant->name }}</small>@endif
                                            </div>
                                        </div>
                                    </td>
                                    <td><small class="text-muted">{{ $item->product_sku ?? '—' }}</small></td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-end">{{ config('ecommerce.currency_symbol', '$') }}{{ number_format($item->unit_price, 2) }}</td>
                                    <td class="text-end text-danger">{{ $item->discount > 0 ? '-' . config('ecommerce.currency_symbol', '$') . number_format($item->discount, 2) : '—' }}</td>
                                    <td class="text-end fw-semibold">{{ config('ecommerce.currency_symbol', '$') }}{{ number_format($item->subtotal, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white">
                <div class="row justify-content-end">
                    <div class="col-md-5">
                        <table class="table table-sm mb-0">
                            <tr><td class="text-end text-muted">Subtotal</td><td class="text-end fw-semibold">{{ config('ecommerce.currency_symbol', '$') }}{{ number_format($order->subtotal, 2) }}</td></tr>
                            @if($order->coupon_discount > 0)
                                <tr><td class="text-end text-muted">Discount</td><td class="text-end text-success">-{{ config('ecommerce.currency_symbol', '$') }}{{ number_format($order->coupon_discount, 2) }}</td></tr>
                            @endif
                            <tr><td class="text-end text-muted">Shipping</td><td class="text-end">{{ config('ecommerce.currency_symbol', '$') }}{{ number_format($order->shipping_cost, 2) }}</td></tr>
                            <tr><td class="text-end text-muted">Tax ({{ $order->tax_rate }}%)</td><td class="text-end">{{ config('ecommerce.currency_symbol', '$') }}{{ number_format($order->tax_amount, 2) }}</td></tr>
                            <tr class="border-top"><td class="text-end fw-bold">Grand Total</td><td class="text-end fw-bold fs-5 text-primary">{{ config('ecommerce.currency_symbol', '$') }}{{ number_format($order->total, 2) }}</td></tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Payment & Transactions --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0"><i class="fas fa-credit-card me-2 text-primary"></i>Payment</h5>
                <div>
                    <span class="badge {{ $order->paymentStatusBadge() }} fs-6">{{ ucfirst($order->payment_status) }}</span>
                </div>
            </div>
            <div class="card-body">
                <div class="row g-3 mb-3">
                    <div class="col-md-3">
                        <small class="text-muted d-block">Method</small>
                        <strong>{{ $order->payment?->methodLabel() ?? '—' }}</strong>
                    </div>
                    <div class="col-md-3">
                        <small class="text-muted d-block">Amount</small>
                        <strong>{{ config('ecommerce.currency_symbol', '$') }}{{ number_format($order->payment?->amount ?? $order->total, 2) }}</strong>
                    </div>
                    <div class="col-md-3">
                        <small class="text-muted d-block">Paid</small>
                        <strong>{{ config('ecommerce.currency_symbol', '$') }}{{ number_format($order->paid_amount, 2) }}</strong>
                    </div>
                    <div class="col-md-3">
                        <small class="text-muted d-block">Due</small>
                        <strong class="{{ $order->getDueAmount() > 0 ? 'text-danger' : 'text-success' }}">{{ config('ecommerce.currency_symbol', '$') }}{{ number_format($order->getDueAmount(), 2) }}</strong>
                    </div>
                </div>

                @if(in_array($order->payment_status, ['pending', 'partial']))
                    <div class="d-flex gap-2 flex-wrap mb-3">
                        <form method="POST" action="{{ route('admin.orders.mark-paid', $order) }}" class="d-flex gap-2 align-items-center">
                            @csrf
                            <input type="text" name="reference" class="form-control form-control-sm" placeholder="Transaction ref" style="width: 180px;">
                            <button class="btn btn-sm btn-success" type="submit"><i class="fas fa-check me-1"></i>Mark Paid</button>
                        </form>
                        <form method="POST" action="{{ route('admin.orders.mark-partial-paid', $order) }}" class="d-flex gap-2 align-items-center">
                            @csrf
                            <input type="number" name="amount" class="form-control form-control-sm" step="0.01" placeholder="Amount" style="width: 120px;" required>
                            <input type="text" name="reference" class="form-control form-control-sm" placeholder="Ref" style="width: 120px;">
                            <button class="btn btn-sm btn-info" type="submit"><i class="fas fa-money-bill me-1"></i>Partial</button>
                        </form>
                        <form method="POST" action="{{ route('admin.orders.mark-failed', $order) }}" class="d-inline">
                            @csrf
                            <button class="btn btn-sm btn-outline-danger" type="submit"><i class="fas fa-times me-1"></i>Mark Failed</button>
                        </form>
                    </div>
                @endif

                @if($order->isPaid() && !$order->isRefunded())
                    <form method="POST" action="{{ route('admin.orders.refund', $order) }}" class="d-flex gap-2 align-items-center mb-3">
                        @csrf
                        <input type="number" name="amount" class="form-control form-control-sm" step="0.01" style="width: 180px;"
                               placeholder="Refund amount (max: {{ config('ecommerce.currency_symbol', '$') }}{{ number_format($order->paid_amount, 2) }})"
                               max="{{ $order->paid_amount }}" value="{{ $order->paid_amount }}">
                        <input type="text" name="reason" class="form-control form-control-sm" placeholder="Reason" style="width: 200px;">
                        <button class="btn btn-sm btn-warning" type="submit"><i class="fas fa-undo me-1"></i>Refund</button>
                    </form>
                @endif

                @if ($order->transactions->isNotEmpty())
                    <h6 class="fw-semibold mt-3 mb-2">Transaction History</h6>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Reference</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->transactions as $txn)
                                    <tr>
                                        <td>{{ $txn->typeLabel() }}</td>
                                        <td>{{ config('ecommerce.currency_symbol', '$') }}{{ number_format($txn->amount, 2) }}</td>
                                        <td><span class="badge {{ $txn->statusBadge() }}">{{ ucfirst($txn->status) }}</span></td>
                                        <td><small>{{ $txn->reference ?? '—' }}</small></td>
                                        <td><small class="text-muted">{{ $txn->created_at->format('M d, Y h:i A') }}</small></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        {{-- Update Status & Tracking --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="fw-bold mb-0"><i class="fas fa-truck me-2 text-primary"></i>Update Status & Tracking</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.orders.update-status', $order) }}" class="row g-2">
                    @csrf
                    <div class="col-md-3">
                        <label class="form-label small fw-semibold">Status</label>
                        <select name="status" class="form-select">
                            @foreach(App\Enums\OrderStatus::cases() as $st)
                                <option value="{{ $st->value }}" @selected($order->status === $st->value)>
                                    {{ $st->label() }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-semibold">Tracking #</label>
                        <input type="text" name="tracking_number" class="form-control" placeholder="Tracking number" value="{{ $order->tracking_number }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small fw-semibold">Carrier</label>
                        <select name="carrier" class="form-select">
                            <option value="">Select Carrier</option>
                            <option value="UPS" @selected($order->carrier === 'UPS')>UPS</option>
                            <option value="FedEx" @selected($order->carrier === 'FedEx')>FedEx</option>
                            <option value="USPS" @selected($order->carrier === 'USPS')>USPS</option>
                            <option value="DHL" @selected($order->carrier === 'DHL')>DHL</option>
                            <option value="Aramex" @selected($order->carrier === 'Aramex')>Aramex</option>
                            <option value="BlueDart" @selected($order->carrier === 'BlueDart')>BlueDart</option>
                            <option value="Delhivery" @selected($order->carrier === 'Delhivery')>Delhivery</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small fw-semibold">Est. Delivery</label>
                        <input type="date" name="estimated_delivery" class="form-control" value="{{ $order->estimated_delivery?->format('Y-m-d') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small fw-semibold">Cancel Reason</label>
                        <input type="text" name="cancel_reason" class="form-control" placeholder="If cancelling" value="{{ $order->cancel_reason }}">
                    </div>
                    <div class="col-12 mt-2">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Update Status</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Sidebar --}}
    <div class="col-lg-4">
        {{-- Customer Info --}}
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white py-3">
                <h6 class="fw-bold mb-0"><i class="fas fa-user me-2 text-primary"></i>Customer</h6>
            </div>
            <div class="card-body">
                @php $addr = $order->shipping_address @endphp
                @if ($addr)
                    <p class="mb-1"><strong>{{ $addr['name'] ?? '—' }}</strong></p>
                    <p class="mb-1 small">{{ $addr['email'] ?? '' }}</p>
                    <p class="mb-1 small">{{ $addr['phone'] ?? '' }}</p>
                @endif
                @if ($order->user)
                    <hr class="my-2">
                    <small class="text-muted">Account: {{ $order->user->name }} ({{ $order->user->email }})</small>
                @else
                    <hr class="my-2">
                    <small class="text-muted">Guest checkout</small>
                @endif
            </div>
        </div>

        {{-- Shipping Address --}}
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white py-3">
                <h6 class="fw-bold mb-0"><i class="fas fa-map-marker-alt me-2 text-primary"></i>Shipping</h6>
            </div>
            <div class="card-body">
                @php $addr = $order->shipping_address @endphp
                @if ($addr && ($addr['address_line1'] ?? false))
                    <p class="mb-1">{{ $addr['address_line1'] }}</p>
                    @if ($addr['address_line2'] ?? false)<p class="mb-1">{{ $addr['address_line2'] }}</p>@endif
                    <p class="mb-1">{{ ($addr['city'] ?? '') }}{{ ($addr['state'] ?? '') ? ', ' . $addr['state'] : '' }} {{ $addr['zip'] ?? '' }}</p>
                    <p class="mb-0">{{ $addr['country'] ?? '' }}</p>
                @else
                    <p class="text-muted small mb-0">No shipping address provided</p>
                @endif
                <hr class="my-2">
                <small class="text-muted d-block">Method: {{ ucfirst($order->shipping_method ?? 'Standard') }}</small>
                <small class="text-muted d-block">Cost: {{ config('ecommerce.currency_symbol', '$') }}{{ number_format($order->shipping_cost, 2) }}</small>
                @if ($order->hasTracking())
                    <hr class="my-2">
                    <small class="text-muted d-block">Carrier: {{ $order->carrier ?? '—' }}</small>
                    <small class="text-muted d-block">
                        Tracking:
                        @if ($order->tracking_url)
                            <a href="{{ $order->tracking_url }}" target="_blank">{{ $order->tracking_number }}</a>
                        @else
                            {{ $order->tracking_number }}
                        @endif
                    </small>
                @endif
                @if($order->estimated_delivery)
                    <hr class="my-2">
                    <small class="text-muted d-block">Est. Delivery: {{ $order->estimated_delivery->format('M d, Y') }}</small>
                @endif
            </div>
        </div>

        {{-- Billing Address --}}
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white py-3">
                <h6 class="fw-bold mb-0"><i class="fas fa-file-invoice me-2 text-primary"></i>Billing</h6>
            </div>
            <div class="card-body">
                @php $billing = $order->billing_address @endphp
                @if ($billing && ($billing['address_line1'] ?? false))
                    <p class="mb-1">{{ $billing['address_line1'] }}</p>
                    @if ($billing['address_line2'] ?? false)<p class="mb-1">{{ $billing['address_line2'] }}</p>@endif
                    <p class="mb-1">{{ ($billing['city'] ?? '') }}{{ ($billing['state'] ?? '') ? ', ' . $billing['state'] : '' }} {{ $billing['zip'] ?? '' }}</p>
                    <p class="mb-0">{{ $billing['country'] ?? '' }}</p>
                @else
                    <p class="text-muted small mb-0">Same as shipping</p>
                @endif
            </div>
        </div>

        {{-- Order Notes --}}
        @if($order->notes)
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white py-3">
                <h6 class="fw-bold mb-0"><i class="fas fa-sticky-note me-2 text-primary"></i>Notes</h6>
            </div>
            <div class="card-body">
                <p class="small mb-0">{{ $order->notes }}</p>
            </div>
        </div>
        @endif

        {{-- Order Timeline --}}
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h6 class="fw-bold mb-0"><i class="fas fa-clock me-2 text-primary"></i>Timeline</h6>
            </div>
            <div class="card-body p-0">
                <div class="timeline-vertical p-3">
                    @forelse($timeline as $event)
                        <div class="timeline-item d-flex gap-3 mb-3">
                            <div class="timeline-icon flex-shrink-0">
                                <div class="rounded-circle d-flex align-items-center justify-content-center"
                                     style="width: 32px; height: 32px; background: var(--primary-light, rgba(37,99,235,0.1));">
                                    <i class="{{ $event['icon'] }} text-primary" style="font-size: 14px;"></i>
                                </div>
                            </div>
                            <div class="timeline-content">
                                <p class="mb-0 small fw-semibold">{{ $event['label'] }}</p>
                                <small class="text-muted">{{ $event['timestamp']->format('M d, Y h:i A') }}</small>
                                @if(isset($event['properties']) && is_array($event['properties']))
                                    @foreach($event['properties'] as $key => $value)
                                        @if(!in_array($key, ['status']))
                                            <br><small class="text-muted">{{ ucfirst($key) }}: {{ $value }}</small>
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        @if(!$loop->last)
                            <div class="timeline-line ms-4 ps-3" style="border-left: 2px dashed var(--gray-200, #E2E8F0); height: 10px; margin-top: -8px; margin-bottom: 8px;"></div>
                        @endif
                    @empty
                        <p class="text-muted small mb-0 text-center py-2">No timeline events.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.timeline-item:last-child .timeline-line { display: none; }
</style>
@endpush

</x-layouts.admin-layout>
