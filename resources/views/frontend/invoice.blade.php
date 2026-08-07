<x-layouts.frontend-layout>
@php $title = 'Invoice - ' . $order->invoice_number @endphp

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-5">
                    {{-- Header --}}
                    <div class="d-flex justify-content-between mb-5">
                        <div>
                            <h2 class="fw-bold text-primary">{{ config('app.name') }}</h2>
                            <p class="text-muted mb-0">123 Store Street</p>
                            <p class="text-muted mb-0">New York, NY 10001</p>
                            <p class="text-muted">United States</p>
                        </div>
                        <div class="text-end">
                            <h3 class="fw-bold">INVOICE</h3>
                            <p class="mb-0"><strong>Invoice #:</strong> {{ $order->invoice_number }}</p>
                            <p class="mb-0"><strong>Order #:</strong> {{ $order->order_number }}</p>
                            <p class="mb-0"><strong>Date:</strong> {{ $order->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>

                    {{-- Addresses --}}
                    <div class="row mb-5">
                        <div class="col-6">
                            <h6 class="fw-bold text-uppercase text-muted mb-2">Bill To</h6>
                            @php $billing = $order->billing_address ?? $order->shipping_address @endphp
                            @if ($billing)
                                <p class="mb-1"><strong>{{ $billing['name'] }}</strong></p>
                                <p class="mb-1">{{ $billing['address_line1'] }}</p>
                                @if ($billing['address_line2'])<p class="mb-1">{{ $billing['address_line2'] }}</p>@endif
                                <p class="mb-1">{{ $billing['city'] }}, {{ $billing['state'] ?? '' }} {{ $billing['zip'] ?? '' }}</p>
                                <p class="mb-1">{{ $billing['country'] }}</p>
                                <p class="mb-0">{{ $billing['email'] }}</p>
                            @endif
                        </div>
                        <div class="col-6">
                            <h6 class="fw-bold text-uppercase text-muted mb-2">Ship To</h6>
                            @php $shipping = $order->shipping_address @endphp
                            @if ($shipping)
                                <p class="mb-1"><strong>{{ $shipping['name'] }}</strong></p>
                                <p class="mb-1">{{ $shipping['address_line1'] }}</p>
                                @if ($shipping['address_line2'])<p class="mb-1">{{ $shipping['address_line2'] }}</p>@endif
                                <p class="mb-1">{{ $shipping['city'] }}, {{ $shipping['state'] ?? '' }} {{ $shipping['zip'] ?? '' }}</p>
                                <p class="mb-1">{{ $shipping['country'] }}</p>
                                <p class="mb-0">{{ $shipping['email'] }}</p>
                            @endif
                        </div>
                    </div>

                    {{-- Items Table --}}
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th>SKU</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Unit Price</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->items as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->product_name }}</td>
                                    <td>{{ $item->product_sku ?? '—' }}</td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-end">${{ number_format($item->unit_price, 2) }}</td>
                                    <td class="text-end">${{ number_format($item->subtotal, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" class="text-end fw-semibold">Subtotal</td>
                                <td class="text-end">${{ number_format($order->subtotal, 2) }}</td>
                            </tr>
                            @if ($order->coupon_discount > 0)
                                <tr>
                                    <td colspan="5" class="text-end fw-semibold text-success">Discount</td>
                                    <td class="text-end text-success">-${{ number_format($order->coupon_discount, 2) }}</td>
                                </tr>
                            @endif
                            <tr>
                                <td colspan="5" class="text-end fw-semibold">Shipping ({{ $order->shipping_method ?? 'Standard' }})</td>
                                <td class="text-end">${{ number_format($order->shipping_cost, 2) }}</td>
                            </tr>
                            <tr>
                                <td colspan="5" class="text-end fw-semibold">Tax</td>
                                <td class="text-end">${{ number_format($order->tax_amount, 2) }}</td>
                            </tr>
                            <tr>
                                <td colspan="5" class="text-end fw-bold fs-5">Total</td>
                                <td class="text-end fw-bold fs-5">${{ number_format($order->total, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>

                    {{-- Payment Status --}}
                    <div class="row mt-4">
                        <div class="col-6">
                            <p class="mb-1"><strong>Payment Method:</strong> {{ $order->payment?->payment_method ? ucfirst($order->payment->payment_method) : 'Cash on Delivery' }}</p>
                            <p class="mb-0"><strong>Payment Status:</strong>
                                <span class="badge {{ $order->payment_status === 'paid' ? 'bg-success' : 'bg-warning' }}">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </p>
                        </div>
                        <div class="col-6 text-end">
                            <p class="text-muted mb-0">Thank you for your business!</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <button class="btn btn-primary" onclick="window.print()">
                    <i class="fas fa-print me-2"></i>Print Invoice
                </button>
                <a href="{{ route('customer.orders') }}" class="btn btn-outline-secondary ms-2">
                    <i class="fas fa-arrow-left me-2"></i>Back to Orders
                </a>
            </div>
        </div>
    </div>
</div>
</x-layouts.frontend-layout>
