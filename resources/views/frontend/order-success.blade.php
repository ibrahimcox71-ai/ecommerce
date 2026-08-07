<x-layouts.frontend-layout>
@php $title = 'Order Placed Successfully' @endphp

<div class="container py-5">
    <div class="text-center mb-5">
        <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3 sizing-96 bg-success-light">
            <i class="fas fa-check-circle text-success-custom" style="font-size: 3rem;"></i>
        </div>
        <h1 class="fw-bold text-gray-800">Thank You for Your Order!</h1>
        <p class="fs-5 text-gray-500">Your order has been placed successfully.</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <div class="row text-center">
                        <div class="col-4 border-end">
                            <small class="text-muted d-block">Order Number</small>
                            <strong class="fs-5 text-gray-800">{{ $order->order_number }}</strong>
                        </div>
                        <div class="col-4 border-end">
                            <small class="text-muted d-block">Date</small>
                            <strong class="text-gray-800">{{ $order->created_at->format('M d, Y') }}</strong>
                        </div>
                        <div class="col-4">
                            <small class="text-muted d-block">Total</small>
                            <strong class="fs-5 text-primary-custom">${{ number_format($order->total, 2) }}</strong>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 rounded-4 rounded-bottom-0 border-0">
                    <h5 class="fw-bold mb-0 text-gray-800">Order Items</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="fw-semibold text-gray-800">Product</th>
                                    <th class="text-center fw-semibold text-gray-800">Qty</th>
                                    <th class="text-end fw-semibold text-gray-800">Price</th>
                                    <th class="text-end fw-semibold text-gray-800">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->items as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                @if ($item->product_image)
                                                    <img src="{{ $item->product_image }}" alt="{{ $item->product_name }}"
                                                         style="width: 50px; height: 50px;" class="object-cover rounded-3">
                                                @endif
                                                <div>
                                                    <span class="fw-semibold text-gray-800">{{ $item->product_name }}</span>
                                                    @if ($item->product_sku)
                                                        <br><small class="text-muted">SKU: {{ $item->product_sku }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">{{ $item->quantity }}</td>
                                        <td class="text-end">${{ number_format($item->unit_price, 2) }}</td>
                                        <td class="text-end fw-semibold">${{ number_format($item->subtotal, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-50">
                                <tr>
                                    <td colspan="3" class="text-end text-gray-500">Subtotal</td>
                                    <td class="text-end text-gray-800">${{ number_format($order->subtotal, 2) }}</td>
                                </tr>
                                @if ($order->coupon_discount > 0)
                                    <tr>
                                        <td colspan="3" class="text-end text-success-custom">Discount</td>
                                        <td class="text-end text-success-custom">-${{ number_format($order->coupon_discount, 2) }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <td colspan="3" class="text-end text-gray-500">Shipping</td>
                                    <td class="text-end text-gray-800">${{ number_format($order->shipping_cost, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end text-gray-500">Tax</td>
                                    <td class="text-end text-gray-800">${{ number_format($order->tax_amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end fw-bold text-gray-800">Total</td>
                                    <td class="text-end fw-bold fs-5 text-primary-custom">${{ number_format($order->total, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 rounded-4 rounded-bottom-0 border-0">
                    <h5 class="fw-bold mb-0 text-gray-800">Shipping Address</h5>
                </div>
                <div class="card-body">
                    @php $addr = $order->shipping_address @endphp
                    @if ($addr)
                        <p class="mb-1"><strong class="text-gray-800">{{ $addr['name'] }}</strong></p>
                        <p class="mb-1 text-muted">{{ $addr['address_line1'] }}</p>
                        @if ($addr['address_line2'])<p class="mb-1 text-muted">{{ $addr['address_line2'] }}</p>@endif
                        <p class="mb-1 text-muted">{{ $addr['city'] }}, {{ $addr['state'] ?? '' }} {{ $addr['zip'] ?? '' }}</p>
                        <p class="mb-1 text-muted">{{ $addr['country'] }}</p>
                        <p class="mb-0 text-muted">{{ $addr['email'] }} | {{ $addr['phone'] }}</p>
                    @endif
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 rounded-4 rounded-bottom-0 border-0">
                    <h5 class="fw-bold mb-0 text-gray-800">Payment</h5>
                </div>
                <div class="card-body">
                    <p class="mb-1">
                        <strong class="text-gray-800">Method:</strong>
                        @if ($order->payment)
                            <span class="text-muted">{{ ucfirst($order->payment->payment_method) }}</span>
                        @else
                            <span class="text-muted">Cash on Delivery</span>
                        @endif
                    </p>
                    <p class="mb-0">
                        <strong class="text-gray-800">Status:</strong>
                        <span class="badge rounded-pill px-3 py-1 bg-warning text-dark">{{ ucfirst($order->payment_status) }}</span>
                    </p>
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('shop') }}" class="btn btn-lg rounded-pill px-4 border-primary-custom text-primary-custom">
                    <i class="fas fa-arrow-left me-2"></i>Continue Shopping
                </a>
                <a href="{{ route('customer.orders') }}" class="btn btn-lg rounded-pill px-4 btn-primary-modern">
                    <i class="fas fa-list me-2"></i>View Orders
                </a>
            </div>
        </div>
    </div>
</div>
</x-layouts.frontend-layout>
