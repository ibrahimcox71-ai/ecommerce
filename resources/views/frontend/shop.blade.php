<x-layouts.frontend-layout title="Shop" :seoData="$seoData ?? []">

<div class="shop-page">
    {{-- Sticky Filter Bar --}}
    <div class="sticky-filter-bar" id="stickyFilterBar">
        <div class="container">
            <div class="filter-bar-inner">
                <div class="filter-bar-left">
                    <button class="filter-toggle-btn d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#filterOffcanvas" aria-label="Toggle filters">
                        <i class="fas fa-sliders-h"></i>
                        <span>Filters</span>
                        @if (request()->hasAny(['category', 'brand', 'min_price', 'max_price', 'rating', 'in_stock', 'on_sale']))
                            <span class="filter-active-dot"></span>
                        @endif
                    </button>
                    <div class="filter-bar-info">
                        <span class="results-count">
                            <strong>{{ $products->total() }}</strong> results
                        </span>
                        @if (request('q'))
                            <span class="search-query">for "<strong>{{ request('q') }}</strong>"</span>
                        @endif
                    </div>
                </div>
                <div class="filter-bar-right">
                    <div class="view-toggle d-none d-md-flex" role="group" aria-label="View toggle">
                        <button class="view-btn active" data-view="grid" aria-label="Grid view"><i class="fas fa-th"></i></button>
                        <button class="view-btn" data-view="list" aria-label="List view"><i class="fas fa-list"></i></button>
                    </div>
                    <div class="sort-group">
                        <label class="sort-label">Sort by:</label>
                        <select class="sort-select" onchange="window.location.href=this.value" aria-label="Sort products">
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'latest']) }}" @selected(request('sort', 'latest') === 'latest')>Latest</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'price-low']) }}" @selected(request('sort') === 'price-low')>Price: Low to High</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'price-high']) }}" @selected(request('sort') === 'price-high')>Price: High to Low</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'name']) }}" @selected(request('sort') === 'name')>Name: A-Z</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'rating']) }}" @selected(request('sort') === 'rating')>Top Rated</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'discount']) }}" @selected(request('sort') === 'discount')>Biggest Discount</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container py-4">
        <x-frontend.breadcrumb :items="[['label' => 'Shop']]" />

        <div class="row">
            {{-- Mobile Filter Offcanvas --}}
            <div class="offcanvas offcanvas-start filter-offcanvas" tabindex="-1" id="filterOffcanvas" aria-labelledby="filterOffcanvasLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title fw-bold" id="filterOffcanvasLabel"><i class="fas fa-sliders-h me-2 text-primary"></i>Filters</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close filters"></button>
                </div>
                <div class="offcanvas-body">
                    <x-shop-filters :categories="$categories" :brands="$brands" :maxPrice="$maxPrice ?? 1000" />
                </div>
            </div>

            {{-- Desktop Sidebar --}}
            <div class="col-lg-3 d-none d-lg-block">
                <div class="shop-sidebar">
                    <x-shop-filters :categories="$categories" :brands="$brands" :maxPrice="$maxPrice ?? 1000" />
                </div>
            </div>

            {{-- Product Grid --}}
            <div class="col-lg-9">
                @if ($products->isEmpty())
                    <div class="empty-state">
                        <div class="empty-icon"><i class="fas fa-box-open"></i></div>
                        <h4>No products found</h4>
                        <p>Try adjusting your filters or search terms.</p>
                        <div class="empty-actions">
                            <a href="{{ route('shop') }}" class="btn btn-primary rounded-pill px-4">Clear All Filters</a>
                        </div>
                    </div>
                @else
                    <div class="row g-3 g-md-4 row-cols-2 row-cols-md-3 product-grid {{ request('view') === 'list' ? 'list-view' : '' }}" id="productGrid">
                        @foreach ($products as $product)
                            <x-product-card :product="$product" />
                        @endforeach
                    </div>

                    <div class="pagination-wrapper">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.shop-page { min-height: 60vh; }
.filter-bar-inner { display: flex; align-items: center; justify-content: space-between; gap: 12px; }
.filter-bar-left { display: flex; align-items: center; gap: 12px; }
.filter-toggle-btn { display: inline-flex; align-items: center; gap: 8px; padding: 8px 16px; border-radius: 10px; border: 1px solid #E5E7EB; background: #fff; font-size: 13px; font-weight: 500; color: var(--gray-700); cursor: pointer; transition: all .2s; position: relative; }
.filter-toggle-btn:hover { border-color: var(--primary); color: var(--primary); }
.filter-active-dot { width: 8px; height: 8px; border-radius: 50%; background: var(--primary); position: absolute; top: 6px; right: 6px; }
.filter-bar-info { font-size: 14px; color: var(--gray-500); }
.results-count strong { color: var(--gray-800); }
.search-query { color: var(--gray-600); }
.filter-bar-right { display: flex; align-items: center; gap: 12px; }
.view-toggle { display: flex; border: 1px solid #E5E7EB; border-radius: 10px; overflow: hidden; }
.view-btn { width: 36px; height: 36px; border: none; background: transparent; color: var(--gray-400); cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 14px; transition: all .2s; }
.view-btn.active { background: var(--primary); color: #fff; }
.view-btn:not(.active):hover { color: var(--gray-600); }
.sort-group { display: flex; align-items: center; gap: 6px; }
.sort-label { font-size: 13px; color: var(--gray-500); white-space: nowrap; display: none; }
@media (min-width: 768px) { .sort-label { display: inline; } }
.sort-select { padding: 8px 14px; border: 1px solid #E5E7EB; border-radius: 10px; font-size: 13px; outline: none; cursor: pointer; color: var(--gray-700); background: #fff; min-width: 140px; }
.sort-select:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(245,114,36,.1); }
.shop-sidebar { position: sticky; top: calc(var(--header-height) + 80px); }
.empty-state { text-align: center; padding: 80px 20px; }
.empty-icon { font-size: 64px; color: #D1D5DB; margin-bottom: 16px; }
.empty-state h4 { font-weight: 700; color: var(--gray-800); margin-bottom: 8px; }
.empty-state p { color: var(--gray-500); margin-bottom: 20px; }
.pagination-wrapper { display: flex; justify-content: center; margin-top: 32px; }
.product-grid.list-view .col { flex: 0 0 100%; max-width: 100%; }
.product-grid.list-view .product-card-v2 { flex-direction: row; }
.product-grid.list-view .product-card-v2 .product-img-wrap { width: 200px; min-height: 200px; flex-shrink: 0; }
.product-grid.list-view .product-card-v2 .product-body-v2 { padding: 16px 20px; }
@media (max-width: 767.98px) { .filter-bar-info .results-count { font-size: 13px; } .sort-select { min-width: 120px; font-size: 12px; padding: 6px 10px; } }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Grid/List toggle
    document.querySelectorAll('.view-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.view-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            const view = this.dataset.view;
            const grid = document.getElementById('productGrid');
            if (grid) {
                grid.classList.toggle('list-view', view === 'list');
                const url = new URL(window.location);
                url.searchParams.set('view', view);
                history.replaceState({}, '', url);
            }
        });
    });
    // Restore view preference
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('view') === 'list') {
        const listBtn = document.querySelector('.view-btn[data-view="list"]');
        if (listBtn) listBtn.click();
    }
});
</script>
@endpush
</x-layouts.frontend-layout>