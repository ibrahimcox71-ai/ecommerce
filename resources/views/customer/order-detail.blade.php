<x-layouts.customer-layout title="Order #{{ $order->order_number }}">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('customer.orders') }}" class="text-muted text-decoration-none small">
                <i class="fas fa-arrow-left me-1"></i>Back to Orders
            </a>
            <h4 class="fw-bold mb-0 mt-1">Order #{{ $order->order_number }}</h4>
        </div>
        <span class="badge {{ $order->statusBadge() }} fs-6">{{ ucfirst($order->status) }}</span>
        @if ($order->hasTracking())
            <a href="{{ route('order.track', $order->order_number) }}" class="btn btn-sm btn-outline-info">
                <i class="fas fa-truck me-1"></i>Track
            </a>
        @endif
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            {{-- Items --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="fw-bold mb-0">Items</h5>
                </div>
                <div class="card-body p-0">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Product</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Price</th>
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
                                                     style="width: 50px; height: 50px; object-fit: cover;" class="rounded">
                                            @endif
                                            <span class="fw-semibold">{{ $item->product_name }}</span>
                                        </div>
                                    </td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-end">${{ number_format($item->unit_price, 2) }}</td>
                                    <td class="text-end fw-semibold">${{ number_format($item->subtotal, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-light">
                            <tr><td colspan="3" class="text-end">Subtotal</td><td class="text-end">${{ number_format($order->subtotal, 2) }}</td></tr>
                            @if ($order->coupon_discount > 0)
                                <tr><td colspan="3" class="text-end text-success">Discount</td><td class="text-end text-success">-${{ number_format($order->coupon_discount, 2) }}</td></tr>
                            @endif
                            <tr><td colspan="3" class="text-end">Shipping</td><td class="text-end">${{ number_format($order->shipping_cost, 2) }}</td></tr>
                            <tr><td colspan="3" class="text-end">Tax</td><td class="text-end">${{ number_format($order->tax_amount, 2) }}</td></tr>
                            <tr><td colspan="3" class="text-end fw-bold">Total</td><td class="text-end fw-bold fs-5 text-primary">${{ number_format($order->total, 2) }}</td></tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            {{-- Payment --}}
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white py-3">
                    <h6 class="fw-bold mb-0"><i class="fas fa-credit-card me-2 text-primary"></i>Payment</h6>
                </div>
                <div class="card-body">
                    <p class="mb-1"><strong>Method:</strong> {{ $order->payment?->methodLabel() ?? 'Cash on Delivery' }}</p>
                    <p class="mb-0">
                        <strong>Status:</strong>
                        <span class="badge {{ $order->paymentStatusBadge() }}">{{ ucfirst($order->payment_status) }}</span>
                    </p>
                </div>
            </div>

            {{-- Shipping --}}
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white py-3">
                    <h6 class="fw-bold mb-0"><i class="fas fa-truck me-2 text-primary"></i>Shipping</h6>
                </div>
                <div class="card-body">
                    @php $addr = $order->shipping_address @endphp
                    @if ($addr)
                        <p class="mb-1"><strong>{{ $addr['name'] }}</strong></p>
                        <p class="mb-1">{{ $addr['address_line1'] }}</p>
                        @if ($addr['address_line2'])<p class="mb-1">{{ $addr['address_line2'] }}</p>@endif
                        <p class="mb-1">{{ $addr['city'] }}, {{ $addr['state'] ?? '' }} {{ $addr['zip'] ?? '' }}</p>
                        <p class="mb-0">{{ $addr['country'] }}</p>
                    @endif
                    <hr class="my-2">
                    <small class="text-muted">Method: {{ ucfirst($order->shipping_method ?? 'Standard') }}</small>
                    @if ($order->hasTracking())
                        <hr class="my-2">
                        <small class="text-muted d-block">Carrier: {{ $order->carrier }}</small>
                        <small class="text-muted d-block">
                            Tracking:
                            @if ($order->tracking_url)
                                <a href="{{ $order->tracking_url }}" target="_blank">{{ $order->tracking_number }}</a>
                            @else
                                {{ $order->tracking_number }}
                            @endif
                        </small>
                    @endif
                </div>
            </div>

            {{-- Timeline --}}
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="fw-bold mb-0"><i class="fas fa-clock me-2 text-primary"></i>Timeline</h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0 small">
                        <li class="mb-2"><i class="fas fa-circle text-success me-2" style="font-size: 8px;"></i>Placed: {{ $order->created_at->format('M d, Y h:i A') }}</li>
                        @if ($order->paid_at)<li class="mb-2"><i class="fas fa-circle text-success me-2" style="font-size: 8px;"></i>Paid: {{ $order->paid_at->format('M d, Y h:i A') }}</li>@endif
                        @if ($order->confirmed_at)<li class="mb-2"><i class="fas fa-circle text-info me-2" style="font-size: 8px;"></i>Confirmed: {{ $order->confirmed_at->format('M d, Y h:i A') }}</li>@endif
                        @if ($order->packing_at)<li class="mb-2"><i class="fas fa-circle text-secondary me-2" style="font-size: 8px;"></i>Packing: {{ $order->packing_at->format('M d, Y h:i A') }}</li>@endif
                        @if ($order->shipping_at)<li class="mb-2"><i class="fas fa-circle text-dark me-2" style="font-size: 8px;"></i>Shipped: {{ $order->shipping_at->format('M d, Y h:i A') }}</li>@endif
                        @if ($order->delivered_at)<li class="mb-2"><i class="fas fa-circle text-success me-2" style="font-size: 8px;"></i>Delivered: {{ $order->delivered_at->format('M d, Y h:i A') }}</li>@endif
                        @if ($order->cancelled_at)<li class="mb-2"><i class="fas fa-circle text-danger me-2" style="font-size: 8px;"></i>Cancelled: {{ $order->cancelled_at->format('M d, Y h:i A') }}</li>@endif
                        @if ($order->returned_at)<li class="mb-2"><i class="fas fa-circle text-warning me-2" style="font-size: 8px;"></i>Returned: {{ $order->returned_at->format('M d, Y h:i A') }}</li>@endif
                        @if ($order->refunded_at)<li class="mb-2"><i class="fas fa-circle text-dark me-2" style="font-size: 8px;"></i>Refunded: {{ $order->refunded_at->format('M d, Y h:i A') }}</li>@endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-layouts.customer-layout>
