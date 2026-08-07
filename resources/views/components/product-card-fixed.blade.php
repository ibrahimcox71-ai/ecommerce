@props(['product'])

@php
    $imgUrl = asset('images/no-image.svg');
    if ($product->thumbnail) {
        $imgUrl = asset('storage/' . $product->thumbnail);
    }

    $discountLabel = '';
    if ($product->has_discount) {
        $discountLabel = $product->discount_type === 'percentage'
            ? '-' . $product->discount . '%'
            : '-$' . number_format($product->discount, 2);
    }
@endphp

<div class="product-card-v2" role="article" aria-label="{{ $product->name }}">
    <div class="product-img-wrap">
        <a href="{{ route('product.show', $product->slug) }}" aria-label="View {{ $product->name }}">
            <img src="{{ $imgUrl }}"
                 alt="{{ $product->name }}"
                 loading="lazy"
                 onerror="this.onerror=null; this.src='{{ asset('images/no-image.svg') }}'; this.classList.add('img-failed');">
            <div class="product-img-overlay"></div>
        </a>
        <div class="product-badges">
            @if ($discountLabel)
                <span class="product-badge badge-discount">{{ $discountLabel }}</span>
            @endif
            @if ($product->is_new ?? false)
                <span class="product-badge badge-new">New</span>
            @endif
            @if (!($product->is_in_stock ?? true))
                <span class="product-badge badge-low-stock">Out of Stock</span>
            @endif
        </div>
        <div class="product-actions-v2" role="group" aria-label="Product actions">
            <a href="{{ route('product.show', $product->slug) }}" class="product-action-btn-v2" title="Quick View" aria-label="Quick view {{ $product->name }}">
                <i class="fas fa-eye" aria-hidden="true"></i>
            </a>
            <button class="product-action-btn-v2 wishlist-btn" title="Add to Wishlist" aria-label="Add {{ $product->name }} to wishlist" data-product-id="{{ $product->id }}">
                <i class="far fa-heart" aria-hidden="true"></i>
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
        <div class="product-rating-v2">
            <x-star-rating :rating="$product->average_rating" />
            <span class="rating-count">({{ $product->review_count }})</span>
        </div>
        <div class="product-price-row">
            <div class="product-pricing-v2">
                @if ($product->has_discount)
                    <span class="price-current">${{ number_format($product->current_price, 2) }}</span>
                    <span class="price-old">${{ number_format($product->price, 2) }}</span>
                @else
                    <span class="price-current">${{ number_format($product->price, 2) }}</span>
                @endif
            </div>
            @if ($product->is_in_stock ?? true)
            <button type="button" class="add-cart-btn-v2 add-to-cart-quick" title="Add to Cart" aria-label="Add {{ $product->name }} to cart"
                    data-product-id="{{ $product->id }}">
                <i class="fas fa-plus" aria-hidden="true"></i>
            </button>
            @endif
        </div>
    </div>
</div>
