<x-layouts.frontend-layout title="Search Results">
    <div class="container py-4">
        <x-breadcrumb :items="[['label' => 'Search']]" />

        <div class="mb-4">
            <h1 class="fw-bold text-gray-800">Search Results</h1>
            @if (request('q'))
                <p class="text-muted">Showing results for "<strong class="text-gray-800">{{ request('q') }}</strong>"</p>
            @endif
        </div>

        @if (isset($products) && $products->isNotEmpty())
            <div class="row g-4 row-cols-2 row-cols-md-3 row-cols-lg-4">
                @foreach ($products as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
            <div class="mt-4 d-flex justify-content-center">
                {{ $products->links() }}
            </div>
        @else
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body text-center py-5">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3 sizing-80 bg-gray-100">
                        <i class="fas fa-search fa-3x text-gray-400"></i>
                    </div>
                    <h5 class="fw-bold text-gray-800">No products found</h5>
                    <p class="text-muted mb-4">Try adjusting your search or filter criteria.</p>
                    <a href="{{ route('shop') }}" class="btn btn-primary-modern rounded-pill px-4">
                        <i class="fas fa-shopping-bag me-2"></i>Browse All Products
                    </a>
                </div>
            </div>
        @endif
    </div>
</x-layouts.frontend-layout>
