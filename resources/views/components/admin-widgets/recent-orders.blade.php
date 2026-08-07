@props(['orders' => []])
@if($orders->isNotEmpty())
    <div class="dashboard-widget">
        <h6 class="fw-semibold mb-3"><i class="fas fa-shopping-cart me-2 text-primary" aria-hidden="true"></i>Recent Orders</h6>
        @foreach($orders as $order)
            <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                <div>
                    <strong class="small">#{{ $order->order_number ?? 'N/A' }}</strong>
                    <small class="text-muted d-block">{{ $order->created_at?->diffForHumans() }}</small>
                </div>
                <span class="fw-bold small">${{ number_format($order->total ?? 0, 2) }}</span>
            </div>
        @endforeach
    </div>
@endif
