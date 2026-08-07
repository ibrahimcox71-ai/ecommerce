<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['product']));

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

foreach (array_filter((['product']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<?php
    $mainImg = $product->thumbnail_url ?? ($product->images->first()?->image_url ?? asset('images/no-image.svg'));
    $hoverImg = $product->images->where('is_primary', false)->first()?->image_url;
?>
<div class="col">
    <div class="product-card-v2 h-100">
        <div class="product-img-wrap">
            <a href="<?php echo e(route('product.show', $product->slug)); ?>" class="product-img-link">
                <img src="<?php echo e($mainImg); ?>"
                     alt="<?php echo e($product->name); ?>"
                     loading="lazy"
                     class="product-img-main"
                     onerror="this.onerror=null; this.src='<?php echo e(asset('images/no-image.svg')); ?>'; this.classList.add('img-failed');">
                <?php if($hoverImg): ?>
                    <img src="<?php echo e($hoverImg); ?>"
                         alt="<?php echo e($product->name); ?>"
                         loading="lazy"
                         class="product-img-hover"
                         onerror="this.style.display='none';">
                <?php endif; ?>
                <div class="product-img-overlay"></div>
            </a>
            <div class="product-badges">
                <?php if($product->has_discount): ?>
                    <span class="product-badge badge-discount">
                        -<?php echo e($product->discount_type === 'percentage' ? $product->discount . '%' : '$' . number_format($product->discount, 2)); ?>

                    </span>
                <?php endif; ?>
                <?php if($product->is_new_arrival): ?>
                    <span class="product-badge badge-new">New</span>
                <?php endif; ?>
                <?php if($product->is_out_of_stock): ?>
                    <span class="product-badge badge-oos">Sold Out</span>
                <?php elseif($product->is_low_stock): ?>
                    <span class="product-badge badge-low-stock">Low Stock</span>
                <?php endif; ?>
            </div>
            <div class="product-actions-v2">
                <a href="<?php echo e(route('product.show', $product->slug)); ?>" class="product-action-btn-v2" title="Quick View" aria-label="Quick view <?php echo e($product->name); ?>">
                    <i class="fas fa-eye"></i>
                </a>
                <button class="product-action-btn-v2 wishlist-btn" title="Add to Wishlist" data-product-id="<?php echo e($product->id); ?>" aria-label="Add <?php echo e($product->name); ?> to wishlist">
                    <i class="far fa-heart"></i>
                </button>
            </div>
        </div>
        <div class="product-body-v2">
            <?php if($product->brand): ?>
                <div class="product-brand-v2">
                    <?php echo e($product->brand->name); ?>

                    <?php if(($product->brand->featured ?? false) || ($product->brand->popular ?? false)): ?>
                        <span class="verified-dot"><i class="fas fa-check-circle"></i></span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <a href="<?php echo e(route('product.show', $product->slug)); ?>" class="product-name-v2">
                <?php echo e($product->name); ?>

            </a>
            <div class="product-rating-v2">
                <div class="rating-stars">
                    <?php for($i = 1; $i <= 5; $i++): ?>
                        <?php if($i <= floor($product->average_rating)): ?>
                            <i class="fas fa-star"></i>
                        <?php elseif($i - 0.5 <= $product->average_rating): ?>
                            <i class="fas fa-star-half-alt"></i>
                        <?php else: ?>
                            <i class="far fa-star"></i>
                        <?php endif; ?>
                    <?php endfor; ?>
                </div>
                <span class="rating-count">(<?php echo e($product->review_count); ?>)</span>
            </div>
            <?php if($product->is_in_stock && !$product->is_out_of_stock): ?>
                <div class="stock-status in-stock">
                    <span class="stock-dot in-stock"></span>
                    <?php echo e($product->is_low_stock ? 'Only ' . $product->stock . ' left' : 'In Stock'); ?>

                </div>
            <?php else: ?>
                <div class="stock-status out-of-stock">
                    <span class="stock-dot out-of-stock"></span>
                    Out of Stock
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
                <button type="button" class="add-cart-btn-v2 add-to-cart-quick btn-ripple" title="Add to Cart"
                        data-product-id="<?php echo e($product->id); ?>"
                        <?php echo e(!$product->is_in_stock ? 'disabled' : ''); ?>

                        aria-label="Add <?php echo e($product->name); ?> to cart">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
        </div>
    </div>
</div><?php /**PATH C:\laragon\www\ecommerce\resources\views\components\product-card.blade.php ENDPATH**/ ?>