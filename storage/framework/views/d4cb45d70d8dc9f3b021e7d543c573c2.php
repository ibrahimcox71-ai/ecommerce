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
?>

<div class="product-card-v2" role="article" aria-label="<?php echo e($product->name); ?>">
    <div class="product-img-wrap">
        <a href="<?php echo e(route('product.show', $product->slug)); ?>" aria-label="View <?php echo e($product->name); ?>">
            <img src="<?php echo e($imgUrl); ?>"
                 alt="<?php echo e($product->name); ?>"
                 loading="lazy"
                 onerror="this.onerror=null; this.src='<?php echo e(asset('images/no-image.svg')); ?>'; this.classList.add('img-failed');">
            <div class="product-img-overlay"></div>
        </a>
        <div class="product-badges">
            <?php if($discountLabel): ?>
                <span class="product-badge badge-discount"><?php echo e($discountLabel); ?></span>
            <?php endif; ?>
            <?php if($product->is_new ?? false): ?>
                <span class="product-badge badge-new">New</span>
            <?php endif; ?>
            <?php if(!($product->is_in_stock ?? true)): ?>
                <span class="product-badge badge-low-stock">Out of Stock</span>
            <?php endif; ?>
        </div>
        <div class="product-actions-v2" role="group" aria-label="Product actions">
            <a href="<?php echo e(route('product.show', $product->slug)); ?>" class="product-action-btn-v2" title="Quick View" aria-label="Quick view <?php echo e($product->name); ?>">
                <i class="fas fa-eye" aria-hidden="true"></i>
            </a>
            <button class="product-action-btn-v2 wishlist-btn" title="Add to Wishlist" aria-label="Add <?php echo e($product->name); ?> to wishlist" data-product-id="<?php echo e($product->id); ?>">
                <i class="far fa-heart" aria-hidden="true"></i>
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
        <div class="product-rating-v2">
            <?php if (isset($component)) { $__componentOriginalfa87e49ca3cdf62358bbc468aaf3394b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfa87e49ca3cdf62358bbc468aaf3394b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.star-rating','data' => ['rating' => $product->average_rating]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('star-rating'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['rating' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($product->average_rating)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfa87e49ca3cdf62358bbc468aaf3394b)): ?>
<?php $attributes = $__attributesOriginalfa87e49ca3cdf62358bbc468aaf3394b; ?>
<?php unset($__attributesOriginalfa87e49ca3cdf62358bbc468aaf3394b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfa87e49ca3cdf62358bbc468aaf3394b)): ?>
<?php $component = $__componentOriginalfa87e49ca3cdf62358bbc468aaf3394b; ?>
<?php unset($__componentOriginalfa87e49ca3cdf62358bbc468aaf3394b); ?>
<?php endif; ?>
            <span class="rating-count">(<?php echo e($product->review_count); ?>)</span>
        </div>
        <div class="product-price-row">
            <div class="product-pricing-v2">
                <?php if($product->has_discount): ?>
                    <span class="price-current">$<?php echo e(number_format($product->current_price, 2)); ?></span>
                    <span class="price-old">$<?php echo e(number_format($product->price, 2)); ?></span>
                <?php else: ?>
                    <span class="price-current">$<?php echo e(number_format($product->price, 2)); ?></span>
                <?php endif; ?>
            </div>
            <?php if($product->is_in_stock ?? true): ?>
            <button type="button" class="add-cart-btn-v2 add-to-cart-quick" title="Add to Cart" aria-label="Add <?php echo e($product->name); ?> to cart"
                    data-product-id="<?php echo e($product->id); ?>">
                <i class="fas fa-plus" aria-hidden="true"></i>
            </button>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\components\product-card-fixed.blade.php ENDPATH**/ ?>