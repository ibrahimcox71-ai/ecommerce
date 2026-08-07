@props(['product'])
@php
    $mainImg = $product->thumbnail_url ?? ($product->images->first()?->image_url ?? asset('images/no-image.svg'));
    $hoverImg = $product->images->where('is_primary', false)->first()?->image_url;
@endphp
<div class="col">
    <div class="product-card-v2 h-100">
        <div class="product-img-wrap">
            <a href="{{ route('product.show', $product->slug) }}" class="product-img-link">
                <img src="{{ $mainImg }}"
                     alt="{{ $product->name }}"
                     loading="lazy"
                     class="product-img-main"
                     onerror="this.onerror=null; this.src='{{ asset('images/no-image.svg') }}'; this.classList.add('img-failed');">
                @if ($hoverImg)
                    <img src="{{ $hoverImg }}"
                         alt="{{ $product->name }}"
                         loading="lazy"
                         class="product-img-hover"
                         onerror="this.style.display='none';">
                @endif
                <div class="product-img-overlay"></div>
            </a>
            <div class="product-badges">
                @if ($product->has_discount)
                    <span class="product-badge badge-discount">
                        -{{ $product->discount_type === 'percentage' ? $product->discount . '%' : '$' . number_format($product->discount, 2) }}
                    </span>
                @endif
                @if ($product->is_new_arrival)
                    <span class="product-badge badge-new">New</span>
                @endif
                @if ($product->is_out_of_stock)
                    <span class="product-badge badge-oos">Sold Out</span>
                @elseif ($product->is_low_stock)
                    <span class="product-badge badge-low-stock">Low Stock</span>
                @endif
            </div>
            <div class="product-actions-v2">
                <a href="{{ route('product.show', $product->slug) }}" class="product-action-btn-v2" title="Quick View" aria-label="Quick view {{ $product->name }}">
                    <i class="fas fa-eye"></i>
                </a>
                <button class="product-action-btn-v2 wishlist-btn" title="Add to Wishlist" data-product-id="{{ $product->id }}" aria-label="Add {{ $product->name }} to wishlist">
                    <i class="far fa-heart"></i>
                </button>
            </div>
        </div>
        <div class="product-body-v2">
            @if ($product->brand)
                <div class="product-brand-v2">
                    {{ $product->brand->name }}
                    @if (($product->brand->featured ?? false) || ($product->brand->popular ?? false))
                        <span class="verified-dot"><i class="fas fa-check-circle"></i></span>
                    @endif
                </div>
            @endif
            <a href="{{ route('product.show', $product->slug) }}" class="product-name-v2">
                {{ $product->name }}
            </a>
            <div class="product-rating-v2">
                <div class="rating-stars">
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= floor($product->average_rating))
                            <i class="fas fa-star"></i>
                        @elseif ($i - 0.5 <= $product->average_rating)
                            <i class="fas fa-star-half-alt"></i>
                        @else
                            <i class="far fa-star"></i>
                        @endif
                    @endfor
                </div>
                <span class="rating-count">({{ $product->review_count }})</span>
            </div>
            @if ($product->is_in_stock && !$product->is_out_of_stock)
                <div class="stock-status in-stock">
                    <span class="stock-dot in-stock"></span>
                    {{ $product->is_low_stock ? 'Only ' . $product->stock . ' left' : 'In Stock' }}
                </div>
            @else
                <div class="stock-status out-of-stock">
                    <span class="stock-dot out-of-stock"></span>
                    Out of Stock
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
                <button type="button" class="add-cart-btn-v2 add-to-cart-quick btn-ripple" title="Add to Cart"
                        data-product-id="{{ $product->id }}"
                        {{ !$product->is_in_stock ? 'disabled' : '' }}
                        aria-label="Add {{ $product->name }} to cart">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
        </div>
    </div>
</div>