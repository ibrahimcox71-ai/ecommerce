<x-layouts.frontend-layout title="Category" :seoData="$seoData ?? []">
@php $title = $category->name @endphp

<div class="category-page">
    {{-- Category Hero --}}
    <div class="category-hero">
        <div class="container">
            <div class="category-hero-content">
                <x-frontend.breadcrumb :items="[
                    ['label' => 'Shop', 'url' => route('shop')],
                    ['label' => $category->name],
                ]" />
                <h1 class="category-hero-title">{{ $category->name }}</h1>
                @if ($category->description)
                    <p class="category-hero-desc">{{ $category->description }}</p>
                @endif
                @if ($category->children->isNotEmpty())
                    <div class="category-sub-links">
                        @foreach ($category->children as $child)
                            <a href="{{ route('category.show', $child->slug) }}" class="sub-cat-pill">{{ $child->name }}</a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="container py-4">
        <div class="row">
            <div class="col-12 mb-3">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <p class="mb-0 text-muted small">
                        Showing <strong>{{ $products->firstItem() ?: 0 }}</strong>
                        - <strong>{{ $products->lastItem() ?: 0 }}</strong>
                        of <strong>{{ $products->total() }}</strong> products
                    </p>
                    <div class="d-flex align-items-center gap-2">
                        <label class="text-muted small">Sort:</label>
                        <select class="sort-select" onchange="window.location.href=this.value">
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'latest']) }}" @selected(request('sort', 'latest') === 'latest')>Latest</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'price-low']) }}" @selected(request('sort') === 'price-low')>Price: Low to High</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'price-high']) }}" @selected(request('sort') === 'price-high')>Price: High to Low</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'name']) }}" @selected(request('sort') === 'name')>Name: A-Z</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        @if ($products->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-box-open fa-4x text-gray-300 mb-3"></i>
                <h5 class="fw-bold">No products in this category</h5>
                <a href="{{ route('shop') }}" class="btn btn-primary rounded-pill px-4 mt-2">Browse All Products</a>
            </div>
        @else
            <div class="row g-3 g-md-4 row-cols-2 row-cols-md-3 row-cols-lg-4">
                @foreach ($products as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
            <div class="d-flex justify-content-center mt-4">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</div>

@push('styles')
<style>
.category-hero { background: linear-gradient(135deg, var(--primary-50), #fff); padding: 32px 0; margin-bottom: 8px; border-bottom: 1px solid #F3F4F6; }
.category-hero-content { max-width: 700px; }
.category-hero-title { font-size: 32px; font-weight: 900; color: var(--gray-900); letter-spacing: -.5px; margin: 12px 0 8px; }
@media (max-width: 767.98px) { .category-hero-title { font-size: 24px; } }
.category-hero-desc { font-size: 14px; color: var(--gray-500); line-height: 1.6; }
.category-sub-links { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 16px; }
.sub-cat-pill { padding: 6px 16px; border-radius: 20px; background: #fff; border: 1px solid #E5E7EB; font-size: 13px; font-weight: 500; color: var(--gray-700); text-decoration: none; transition: all .2s; }
.sub-cat-pill:hover { border-color: var(--primary); color: var(--primary); background: rgba(245,114,36,.04); }
.sort-select { padding: 6px 14px; border: 1px solid #E5E7EB; border-radius: 10px; font-size: 13px; outline: none; cursor: pointer; color: var(--gray-700); background: #fff; }
.sort-select:focus { border-color: var(--primary); }
</style>
@endpush
</x-layouts.frontend-layout>