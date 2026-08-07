@props(['amount' => 0, 'margin' => 0])
<div class="dashboard-widget text-center">
    <h3 class="fw-bold mb-1 text-success">${{ number_format($amount, 2) }}</h3>
    <p class="text-muted small mb-0">Net Profit</p>
    <small class="text-muted">Margin: {{ number_format($margin, 1) }}%</small>
</div>
