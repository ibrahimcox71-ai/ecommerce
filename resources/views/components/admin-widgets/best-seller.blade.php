@props(['products' => []])
@if($products->isNotEmpty())
    <div class="dashboard-widget">
        <h6 class="fw-semibold mb-3"><i class="fas fa-trophy me-2 text-warning" aria-hidden="true"></i>Best Sellers</h6>
        <div class="list-group list-group-flush">
            @foreach($products as $product)
                <div class="list-group-item px-0 d-flex justify-content-between align-items-center">
                    <span class="small">{{ $product->name ?? 'Product' }}</span>
                    <span class="badge bg-primary rounded-pill">{{ $product->sold_count ?? 0 }}</span>
                </div>
            @endforeach
        </div>
    </div>
@endif
