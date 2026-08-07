<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['product', 'showBuyNow' => false]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['product', 'showBuyNow' => false]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
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
?>

<div class="product-card-v2" role="article" aria-label="<?php echo e($product->name); ?>">
    <div class="product-img-wrap">
        <a href="<?php echo e(route('product.show', $product->slug)); ?>" aria-label="View <?php echo e($product->name); ?>">
            <img src="<?php echo e($imgUrl); ?>"
                 alt="<?php echo e($product->name); ?>"
                 loading="lazy"
                 onerror="this.onerror=null; this.src='<?php echo e(asset('images/no-image.svg')); ?>';">
            <?php if($imgHoverUrl): ?>
                <img src="<?php echo e($imgHoverUrl); ?>"
                     alt="<?php echo e($product->name); ?> - alternate view"
                     class="product-img-hover"
                     loading="lazy"
                     onerror="this.style.display='none';">
            <?php endif; ?>
            <div class="product-img-overlay"></div>
        </a>

        <div class="product-badges" role="list" aria-label="Product badges">
            <?php if($discountLabel): ?>
                <span class="product-badge badge-discount" role="listitem"><?php echo e($discountLabel); ?></span>
            <?php endif; ?>
            <?php if($product->is_new ?? false): ?>
                <span class="product-badge badge-new" role="listitem">New</span>
            <?php endif; ?>
            <?php if($product->is_best_seller ?? false): ?>
                <span class="product-badge badge-best-seller" role="listitem">Best Seller</span>
            <?php endif; ?>
            <?php if($isLowStock): ?>
                <span class="product-badge badge-low-stock" role="listitem">Only <?php echo e($product->stock_quantity); ?> left</span>
            <?php endif; ?>
        </div>

        <div class="product-actions-v2" role="group" aria-label="Product actions">
            <a href="<?php echo e(route('product.show', $product->slug)); ?>" class="product-action-btn-v2" title="Quick View" aria-label="Quick view <?php echo e($product->name); ?>">
                <i class="fas fa-eye" aria-hidden="true"></i>
            </a>
            <button class="product-action-btn-v2 wishlist-btn touch-target" title="Add to Wishlist" data-product-id="<?php echo e($product->id); ?>" aria-label="Add <?php echo e($product->name); ?> to wishlist">
                <i class="far fa-heart" aria-hidden="true"></i>
            </button>
            <button class="product-action-btn-v2" title="Compare" aria-label="Compare <?php echo e($product->name); ?>" disabled>
                <i class="fas fa-random" aria-hidden="true"></i>
            </button>
        </div>
    </div>

    <div class="product-body-v2">
        <?php if($product->brand): ?>
            <div class="product-brand-v2"><?php echo e($product->brand->name); ?></div>
        <?php endif; ?>

        <a href="<?php echo e(route('product.show', $product->slug)); ?>" class="product-name-v2">
            <?php echo e($product->name); ?>

        </a>

        <div class="product-rating-v2" role="img" aria-label="<?php echo e($avgRating); ?> out of 5 stars">
            <div class="rating-stars">
                <?php for($i = 1; $i <= 5; $i++): ?>
                    <?php if($i <= floor($avgRating)): ?>
                        <i class="fas fa-star text-warning" aria-hidden="true"></i>
                    <?php elseif($i - 0.5 <= $avgRating): ?>
                        <i class="fas fa-star-half-alt text-warning" aria-hidden="true"></i>
                    <?php else: ?>
                        <i class="far fa-star text-gray-300" aria-hidden="true"></i>
                    <?php endif; ?>
                <?php endfor; ?>
            </div>
            <span class="rating-count">(<?php echo e($reviewCount); ?>)</span>
        </div>

        <?php if($isOutOfStock): ?>
            <div class="stock-status out-of-stock" role="status">
                <span class="stock-dot out-of-stock"></span> Out of Stock
            </div>
        <?php elseif($isLowStock): ?>
            <div class="stock-status low-stock" role="status">
                <span class="stock-dot low-stock"></span> Only <?php echo e($product->stock_quantity); ?> left
            </div>
        <?php else: ?>
            <div class="stock-status in-stock" role="status">
                <span class="stock-dot in-stock"></span> In Stock
            </div>
        <?php endif; ?>

        <div class="product-price-row">
            <div class="product-pricing-v2">
                <?php if($product->has_discount): ?>
                    <span class="price-current">$<?php echo e(number_format($product->current_price, 2)); ?></span>
                    <span class="price-old">$<?php echo e(number_format($product->price, 2)); ?></span>
                <?php else: ?>
                    <span class="price-current">$<?php echo e(number_format($product->price, 2)); ?></span>
                <?php endif; ?>
            </div>
            <?php if(!$isOutOfStock): ?>
                <form method="POST" action="<?php echo e(route('cart.add')); ?>" data-add-to-cart-form>
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="add-cart-btn-v2" title="Add to Cart" data-add-to-cart data-product-id="<?php echo e($product->id); ?>" aria-label="Add <?php echo e($product->name); ?> to cart">
                        <i class="fas fa-plus" aria-hidden="true"></i>
                    </button>
                </form>
            <?php endif; ?>
        </div>
    </div>

    <?php if($showBuyNow && !$isOutOfStock): ?>
        <form method="POST" action="<?php echo e(route('checkout.place')); ?>">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
            <input type="hidden" name="quantity" value="1">
            <button type="submit" class="buy-now-btn">
                Buy Now <i class="fas fa-arrow-right ms-1" aria-hidden="true"></i>
            </button>
        </form>
    <?php endif; ?>
</div>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\components\product-card-v2.blade.php ENDPATH**/ ?>