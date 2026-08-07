<x-layouts.frontend-layout title="Brand" :seoData="$seoData ?? []">
@php $title = $brand->name @endphp

<div class="container py-4">
    <x-breadcrumb :items="[
        ['label' => 'Shop', 'url' => route('shop')],
        ['label' => $brand->name],
    ]" />

    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4 d-flex align-items-center gap-3">
            @if ($brand->image)
                <img src="{{ asset('storage/' . $brand->image) }}" alt="{{ $brand->name }}" style="max-height: 60px;" class="rounded-3">
            @endif
            <div>
                <h1 class="fw-bold mb-1 text-gray-800">{{ $brand->name }}</h1>
                @if ($brand->description)
                    <p class="text-muted mb-0">{{ $brand->description }}</p>
                @endif
            </div>
        </div>
    </div>

    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <p class="mb-0 text-muted">
            Showing <span class="fw-semibold text-gray-800">{{ $products->firstItem() ?: 0 }}</span>
            - <span class="fw-semibold text-gray-800">{{ $products->lastItem() ?: 0 }}</span>
            of <span class="fw-semibold text-gray-800">{{ $products->total() }}</span> products
        </p>
        <div class="d-flex align-items-center gap-2">
            <label class="text-muted small mb-0">Sort:</label>
            <select class="form-select form-select-sm form-select-premium" onchange="window.location.href=this.value">
                <option value="{{ request()->fullUrlWithQuery(['sort' => 'latest']) }}" @selected(request('sort', 'latest') === 'latest')>Latest</option>
                <option value="{{ request()->fullUrlWithQuery(['sort' => 'price-low']) }}" @selected(request('sort') === 'price-low')>Price: Low to High</option>
                <option value="{{ request()->fullUrlWithQuery(['sort' => 'price-high']) }}" @selected(request('sort') === 'price-high')>Price: High to Low</option>
                <option value="{{ request()->fullUrlWithQuery(['sort' => 'name']) }}" @selected(request('sort') === 'name')>Name: A-Z</option>
            </select>
        </div>
    </div>

    @if ($products->isEmpty())
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body text-center py-5">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3 sizing-80 bg-gray-100">
                    <i class="fas fa-box-open fa-3x text-gray-400"></i>
                </div>
                <h5 class="text-gray-800">No products from this brand</h5>
                <a href="{{ route('shop') }}" class="btn btn-primary-modern rounded-pill px-4 mt-2">Browse All Products</a>
            </div>
        </div>
    @else
        <div class="row g-4 row-cols-2 row-cols-md-3 row-cols-lg-4">
            @foreach ($products as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>
        <div class="mt-4 d-flex justify-content-center">
            {{ $products->links() }}
        </div>
    @endif
</div>
</x-layouts.frontend-layout>
