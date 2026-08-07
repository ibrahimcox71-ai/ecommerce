<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['rating' => 0, 'size' => 'sm']));

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

foreach (array_filter((['rating' => 0, 'size' => 'sm']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<div class="star-rating d-inline-flex gap-1" role="img" aria-label="<?php echo e(number_format($rating, 1)); ?> out of 5 stars">
    <?php for($i = 1; $i <= 5; $i++): ?>
        <?php if($i <= floor($rating)): ?>
            <i class="fas fa-star text-warning fa-<?php echo e($size); ?>" aria-hidden="true"></i>
        <?php elseif($i - 0.5 <= $rating): ?>
            <i class="fas fa-star-half-alt text-warning fa-<?php echo e($size); ?>" aria-hidden="true"></i>
        <?php else: ?>
            <i class="far fa-star text-gray-300 fa-<?php echo e($size); ?>" aria-hidden="true"></i>
        <?php endif; ?>
    <?php endfor; ?>
</div>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\components\star-rating.blade.php ENDPATH**/ ?>