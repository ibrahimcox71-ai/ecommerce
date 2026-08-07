<x-layouts.frontend-layout title="Wishlist">
<div class="wishlist-page">
    <div class="container py-4">
        <x-breadcrumb :items="[['label' => 'Wishlist']]" />

        @auth('web')
            @php
                $wishlists = auth('web')->user()->wishlists()->with('product.images', 'product.brand', 'product.category')->latest()->get();
            @endphp
            @if ($wishlists->isNotEmpty())
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="section-bar"></div>
                    <h3 class="fw-bold mb-0">My Wishlist</h3>
                    <span class="wishlist-count-badge-static">{{ $wishlists->count() }} items</span>
                </div>
                <div class="row g-3 g-md-4 row-cols-2 row-cols-md-3 row-cols-lg-4">
                    @foreach ($wishlists as $wish)
                        @if ($wish->product)
                            <x-product-card :product="$wish->product" />
                        @endif
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <div class="empty-icon-wrap"><i class="fas fa-heart"></i></div>
                    <h4 class="fw-bold mt-3">Your wishlist is empty</h4>
                    <p class="text-muted mb-4">Save your favorite items here and shop them later!</p>
                    <a href="{{ route('shop') }}" class="btn btn-primary rounded-pill px-4 py-2">
                        <i class="fas fa-shopping-bag me-2"></i>Browse Products
                    </a>
                </div>
            @endif
        @else
            <div class="text-center py-5">
                <div class="empty-icon-wrap"><i class="fas fa-heart"></i></div>
                <h4 class="fw-bold mt-3">Your Wishlist</h4>
                <p class="text-muted mb-4">Please <a href="{{ route('login') }}" class="text-primary text-decoration-underline fw-semibold">sign in</a> to view and manage your wishlist.</p>
                <a href="{{ route('shop') }}" class="btn btn-primary rounded-pill px-4 py-2">
                    <i class="fas fa-shopping-bag me-2"></i>Browse Products
                </a>
            </div>
        @endauth
    </div>
</div>

@push('styles')
<style>
.wishlist-page { min-height: 60vh; }
.section-bar { width: 4px; height: 28px; background: linear-gradient(180deg, var(--primary), var(--secondary)); border-radius: 2px; flex-shrink: 0; }
.wishlist-count-badge-static { font-size: 12px; color: var(--gray-500); background: #F3F4F6; padding: 4px 12px; border-radius: 20px; font-weight: 500; }
.empty-icon-wrap { width: 80px; height: 80px; border-radius: 50%; background: #FEF2F2; display: inline-flex; align-items: center; justify-content: center; font-size: 32px; color: #EF4444; }
</style>
@endpush
</x-layouts.frontend-layout>
