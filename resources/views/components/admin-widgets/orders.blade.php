@props(['total' => 0, 'pending' => 0, 'completed' => 0])
<div class="dashboard-widget">
    <div class="d-flex justify-content-between mb-2">
        <span class="text-muted small">Total Orders</span>
        <span class="fw-bold">{{ $total }}</span>
    </div>
    <div class="d-flex justify-content-between mb-2">
        <span class="text-muted small">Pending</span>
        <span class="fw-bold text-warning">{{ $pending }}</span>
    </div>
    <div class="d-flex justify-content-between">
        <span class="text-muted small">Completed</span>
        <span class="fw-bold text-success">{{ $completed }}</span>
    </div>
</div>
