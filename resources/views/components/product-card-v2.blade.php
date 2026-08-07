@props(['product', 'showBuyNow' => false])

@php
    $imgUrl = asset('images/no-image.svg');
    $imgHoverUrl = null;
    if ($product->thumbnail) {
        $imgUrl = asset('storage/' . $product->thumbnail);
    }

    if ($product->images->isNotEmpty()) {
        $imgHoverUrl = asset('storage/' . $product->images->first()->image);
    }

    $discountLabel = '';
    if ($product->has_discount) {
        $discountLabel = $product->discount_type === 'percentage'
            ? '-' . $product->discount . '%'
            : '-$' . number_format($product->discount, 2);
    }

    $isLowStock = $product->stock_quantity !== null && $product->stock_quantity <= 5 && $product->stock_quantity > 0;
    $isOutOfStock = $product->stock_quantity !== null && $product->stock_quantity <= 0;
    $avgRating = $product->average_rating ?? 0;
    $reviewCount = $product->review_count ?? 0;
@endphp

<div class="product-card-v2" role="article" aria-label="{{ $product->name }}">
    <div class="product-img-wrap">
        <a href="{{ route('product.show', $product->slug) }}" aria-label="View {{ $product->name }}">
            <img src="{{ $imgUrl }}"
                 alt="{{ $product->name }}"
                 loading="lazy"
                 onerror="this.onerror=null; this.src='{{ asset('images/no-image.svg') }}';">
            @if ($imgHoverUrl)
                <img src="{{ $imgHoverUrl }}"
                     alt="{{ $product->name }} - alternate view"
                     class="product-img-hover"
                     loading="lazy"
                     onerror="this.style.display='none';">
            @endif
            <div class="product-img-overlay"></div>
        </a>

        <div class="product-badges" role="list" aria-label="Product badges">
            @if ($discountLabel)
                <span class="product-badge badge-discount" role="listitem">{{ $discountLabel }}</span>
            @endif
            @if ($product->is_new ?? false)
                <span class="product-badge badge-new" role="listitem">New</span>
            @endif
            @if ($product->is_best_seller ?? false)
                <span class="product-badge badge-best-seller" role="listitem">Best Seller</span>
            @endif
            @if ($isLowStock)
                <span class="product-badge badge-low-stock" role="listitem">Only {{ $product->stock_quantity }} left</span>
            @endif
        </div>

        <div class="product-actions-v2" role="group" aria-label="Product actions">
            <a href="{{ route('product.show', $product->slug) }}" class="product-action-btn-v2" title="Quick View" aria-label="Quick view {{ $product->name }}">
                <i class="fas fa-eye" aria-hidden="true"></i>
            </a>
            <button class="product-action-btn-v2 wishlist-btn touch-target" title="Add to Wishlist" data-product-id="{{ $product->id }}" aria-label="Add {{ $product->name }} to wishlist">
                <i class="far fa-heart" aria-hidden="true"></i>
            </button>
            <button class="product-action-btn-v2" title="Compare" aria-label="Compare {{ $product->name }}" disabled>
                <i class="fas fa-random" aria-hidden="true"></i>
            </button>
        </div>
    </div>

    <div class="product-body-v2">
        @if ($product->brand)
            <div class="product-brand-v2">{{ $product->brand->name }}</div>
        @endif

        <a href="{{ route('product.show', $product->slug) }}" class="product-name-v2">
            {{ $product->name }}
        </a>

        <div class="product-rating-v2" role="img" aria-label="{{ $avgRating }} out of 5 stars">
            <div class="rating-stars">
                @for ($i = 1; $i <= 5; $i++)
                    @if ($i <= floor($avgRating))
                        <i class="fas fa-star text-warning" aria-hidden="true"></i>
                    @elseif ($i - 0.5 <= $avgRating)
                        <i class="fas fa-star-half-alt text-warning" aria-hidden="true"></i>
                    @else
                        <i class="far fa-star text-gray-300" aria-hidden="true"></i>
                    @endif
                @endfor
            </div>
            <span class="rating-count">({{ $reviewCount }})</span>
        </div>

        @if ($isOutOfStock)
            <div class="stock-status out-of-stock" role="status">
                <span class="stock-dot out-of-stock"></span> Out of Stock
            </div>
        @elseif ($isLowStock)
            <div class="stock-status low-stock" role="status">
                <span class="stock-dot low-stock"></span> Only {{ $product->stock_quantity }} left
            </div>
        @else
            <div class="stock-status in-stock" role="status">
                <span class="stock-dot in-stock"></span> In Stock
            </div>
        @endif

        <div class="product-price-row">
            <div class="product-pricing-v2">
                @if ($product->has_discount)
                    <span class="price-current">${{ number_format($product->current_price, 2) }}</span>
                    <span class="price-old">${{ number_format($product->price, 2) }}</span>
                @else
                    <span class="price-current">${{ number_format($product->price, 2) }}</span>
                @endif
            </div>
            @if (!$isOutOfStock)
                <form method="POST" action="{{ route('cart.add') }}" data-add-to-cart-form>
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="add-cart-btn-v2" title="Add to Cart" data-add-to-cart data-product-id="{{ $product->id }}" aria-label="Add {{ $product->name }} to cart">
                        <i class="fas fa-plus" aria-hidden="true"></i>
                    </button>
                </form>
            @endif
        </div>
    </div>

    @if ($showBuyNow && !$isOutOfStock)
        <form method="POST" action="{{ route('checkout.place') }}">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="quantity" value="1">
            <button type="submit" class="buy-now-btn">
                Buy Now <i class="fas fa-arrow-right ms-1" aria-hidden="true"></i>
            </button>
        </form>
    @endif
</div>
