<x-layouts.customer-layout title="My Orders">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">My Orders</h4>
    </div>

    @if ($orders->isEmpty())
        <div class="card">
            <div class="card-body text-center py-5 text-muted">
                <i class="fas fa-shopping-bag fa-3x mb-3"></i>
                <p>No orders found.</p>
                <a href="{{ route('shop') }}" class="btn btn-primary">Start Shopping</a>
            </div>
        </div>
    @else
        @foreach ($orders as $order)
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <strong class="fs-6">Order #{{ $order->order_number }}</strong>
                            <span class="badge {{ $order->statusBadge() }} ms-2">{{ ucfirst($order->status) }}</span>
                            <span class="badge {{ $order->paymentStatusBadge() }} ms-1">{{ ucfirst($order->payment_status) }}</span>
                        </div>
                        <span class="fw-bold text-primary">${{ number_format($order->total, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            {{ $order->created_at->format('M d, Y') }} —
                            {{ $order->items->sum('quantity') }} item(s) —
                            {{ $order->payment?->methodLabel() ?? 'COD' }}
                        </small>
                        <div>
                            <a href="{{ route('customer.order-detail', $order) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye me-1"></i>View
                            </a>
                            <a href="{{ route('order.invoice', $order) }}" class="btn btn-sm btn-outline-secondary" target="_blank">
                                <i class="fas fa-file-invoice me-1"></i>Invoice
                            </a>
                            @if ($order->hasTracking())
                                <a href="{{ route('order.track', $order->order_number) }}" class="btn btn-sm btn-outline-info">
                                    <i class="fas fa-truck me-1"></i>Track
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="d-flex justify-content-center">
            {{ $orders->links() }}
        </div>
    @endif
</x-layouts.customer-layout>
