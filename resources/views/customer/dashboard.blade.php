<x-layouts.customer-layout title="Dashboard">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">My Dashboard</h4>
        <span class="text-muted small">
            <i class="fas fa-calendar-alt me-1"></i>{{ now()->format('F d, Y') }}
        </span>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card stat-card border-start border-primary border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="text-muted mb-1">Total Orders</h6>
                            <h4 class="fw-bold mb-0">{{ $totalOrders ?? 0 }}</h4>
                        </div>
                        <i class="fas fa-shopping-bag fa-2x text-primary opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card border-start border-success border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="text-muted mb-1">Completed</h6>
                            <h4 class="fw-bold mb-0">{{ $completedOrders ?? 0 }}</h4>
                        </div>
                        <i class="fas fa-check-circle fa-2x text-success opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card border-start border-warning border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="text-muted mb-1">Wishlist</h6>
                            <h4 class="fw-bold mb-0">{{ $wishlistCount ?? 0 }}</h4>
                        </div>
                        <i class="fas fa-heart fa-2x text-warning opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card border-start border-info border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="text-muted mb-1">Reviews</h6>
                            <h4 class="fw-bold mb-0">{{ $reviewCount ?? 0 }}</h4>
                        </div>
                        <i class="fas fa-star fa-2x text-info opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h6 class="fw-bold mb-0">Recent Orders</h6>
            <a href="{{ route('customer.orders') }}" class="btn btn-sm btn-outline-primary">View All</a>
        </div>
        @if (isset($recentOrders) && $recentOrders->isNotEmpty())
            <div class="list-group list-group-flush">
                @foreach ($recentOrders as $order)
                    <a href="{{ route('customer.order-detail', $order) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <div>
                            <span class="fw-semibold">#{{ $order->order_number }}</span>
                            <span class="badge {{ $order->statusBadge() }} ms-2">{{ ucfirst($order->status) }}</span>
                        </div>
                        <span class="text-muted small">${{ number_format($order->total, 2) }} &middot; {{ $order->created_at->diffForHumans() }}</span>
                    </a>
                @endforeach
            </div>
        @else
            <div class="card-body text-center py-5 text-muted">
                <i class="fas fa-receipt fa-3x mb-3"></i>
                <p>You haven't placed any orders yet.</p>
                <a href="{{ route('shop') }}" class="btn btn-primary">Start Shopping</a>
            </div>
        @endif
    </div>

</x-layouts.customer-layout>
