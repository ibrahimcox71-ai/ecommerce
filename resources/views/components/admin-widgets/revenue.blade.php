@props(['amount' => 0, 'trend' => 0])
<div class="dashboard-widget">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <p class="text-muted small mb-0">Total Revenue</p>
            <h3 class="fw-bold mb-0">${{ number_format($amount, 2) }}</h3>
        </div>
        @if($trend)
            <span class="badge bg-{{ $trend >= 0 ? 'success' : 'danger' }} rounded-pill">
                {{ $trend >= 0 ? '+' : '' }}{{ number_format($trend, 1) }}%
            </span>
        @endif
    </div>
</div>
