@props(['amount' => 0, 'percentage' => 0])
<div class="dashboard-widget text-center">
    <h3 class="fw-bold mb-1 text-primary">${{ number_format($amount, 2) }}</h3>
    <p class="text-muted small mb-0">Monthly Sales</p>
    @if($percentage)
        <small class="text-{{ $percentage >= 0 ? 'success' : 'danger' }}">
            {{ $percentage >= 0 ? '+' : '' }}{{ number_format($percentage, 1) }}% vs last month
        </small>
    @endif
</div>
