<nav class="category-nav">
    <div class="container">
        <div class="category-nav-inner">
            <div class="nav-categories-list">
                <a href="{{ route('shop') }}" class="nav-cat-link {{ request()->routeIs('home') ? '' : '' }}">
                    <i class="fas fa-th-large"></i> All Categories
                </a>
                @php
                    $menuCategories = \App\Models\Category::active()
                        ->parents()
                        ->withCount('products')
                        ->sorted()
                        ->take(10)
                        ->get();
                @endphp
                @foreach ($menuCategories as $cat)
                <div class="nav-cat-dropdown">
                    <a href="{{ route('category.show', $cat->slug) }}" class="nav-cat-link">
                        @if ($cat->icon) <i class="{{ $cat->icon }}"></i> @endif
                        {{ $cat->name }}
                    </a>
                    @if ($cat->children->isNotEmpty())
                    <div class="mega-dropdown">
                        <div class="mega-dropdown-inner">
                            <div class="mega-col">
                                <h6>{{ $cat->name }}</h6>
                                @foreach ($cat->children->take(8) as $child)
                                <a href="{{ route('category.show', $child->slug) }}">
                                    <i class="fas fa-chevron-right"></i> {{ $child->name }}
                                </a>
                                @endforeach
                            </div>
                            <div class="mega-col mega-col-featured">
                                <h6>Featured</h6>
                                <a href="{{ route('shop', ['category' => $cat->slug, 'sort' => 'best-seller']) }}">
                                    <i class="fas fa-crown"></i> Best Sellers
                                </a>
                                <a href="{{ route('shop', ['category' => $cat->slug, 'sort' => 'newest']) }}">
                                    <i class="fas fa-sparkles"></i> New Arrivals
                                </a>
                                <a href="{{ route('flash-sale') }}">
                                    <i class="fas fa-bolt"></i> Flash Sale
                                </a>
                            </div>
                            <div class="mega-col mega-col-banner">
                                <div class="mega-banner">
                                    <div class="mega-banner-content">
                                        <span class="mega-banner-label">Limited Offer</span>
                                        <h5>Up to 50% Off</h5>
                                        <p>On {{ $cat->name }}</p>
                                        <a href="{{ route('shop', ['category' => $cat->slug]) }}" class="mega-banner-btn">
                                            Shop Now <i class="fas fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
            <div class="nav-special-links">
                <a href="{{ route('flash-sale') }}" class="nav-special-link sale-link">
                    <i class="fas fa-bolt"></i> Flash Sale
                </a>
                <a href="{{ route('shop', ['sort' => 'best-seller']) }}" class="nav-special-link">
                    <i class="fas fa-crown"></i> Best Sellers
                </a>
            </div>
        </div>
    </div>
</nav>
