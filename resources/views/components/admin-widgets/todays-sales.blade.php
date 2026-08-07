@props(['amount' => 0, 'orders' => 0])
<div class="dashboard-widget text-center">
    <h3 class="fw-bold mb-1 text-primary">${{ number_format($amount, 2) }}</h3>
    <p class="text-muted small mb-0">Today's Sales</p>
    <small class="text-muted">{{ $orders }} orders</small>
</div>
