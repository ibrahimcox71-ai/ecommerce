@props(['products' => []])
@if($products->isNotEmpty())
    <div class="dashboard-widget">
        <h6 class="fw-semibold mb-3"><i class="fas fa-exclamation-triangle me-2 text-danger" aria-hidden="true"></i>Low Stock</h6>
        @foreach($products as $product)
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="small">{{ $product->name ?? 'Product' }}</span>
                <span class="badge bg-danger rounded-pill">{{ $product->stock ?? 0 }}</span>
            </div>
        @endforeach
    </div>
@endif
