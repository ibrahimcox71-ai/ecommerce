@props(['count' => 0, 'pageViews' => 0])
<div class="dashboard-widget text-center">
    <h3 class="fw-bold mb-1">{{ $count }}</h3>
    <p class="text-muted small mb-0">Visitors Today</p>
    <small class="text-muted">{{ $pageViews }} page views</small>
</div>
