@props(['count' => 0, 'newToday' => 0])
<div class="dashboard-widget text-center">
    <h3 class="fw-bold mb-1">{{ $count }}</h3>
    <p class="text-muted small mb-0">Total Customers</p>
    <small class="text-success">{{ $newToday }} new today</small>
</div>
