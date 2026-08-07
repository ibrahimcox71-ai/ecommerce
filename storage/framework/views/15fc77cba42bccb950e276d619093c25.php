<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['amount' => 0, 'orders' => 0]));

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

foreach (array_filter((['amount' => 0, 'orders' => 0]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<div class="dashboard-widget text-center">
    <h3 class="fw-bold mb-1 text-primary">$<?php echo e(number_format($amount, 2)); ?></h3>
    <p class="text-muted small mb-0">Today's Sales</p>
    <small class="text-muted"><?php echo e($orders); ?> orders</small>
</div>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\components\admin-widgets\todays-sales.blade.php ENDPATH**/ ?>