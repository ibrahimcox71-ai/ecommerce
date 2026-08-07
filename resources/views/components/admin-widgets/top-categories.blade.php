@props(['categories' => []])
@if($categories->isNotEmpty())
    <div class="dashboard-widget">
        <h6 class="fw-semibold mb-3"><i class="fas fa-chart-pie me-2 text-info" aria-hidden="true"></i>Top Categories</h6>
        @foreach($categories as $category)
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="small">{{ $category->name ?? 'Category' }}</span>
                <span class="badge bg-secondary rounded-pill">{{ $category->count ?? 0 }}</span>
            </div>
        @endforeach
    </div>
@endif
