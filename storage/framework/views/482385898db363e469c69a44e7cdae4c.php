<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['total' => 0, 'pending' => 0, 'completed' => 0]));

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

foreach (array_filter((['total' => 0, 'pending' => 0, 'completed' => 0]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<div class="dashboard-widget">
    <div class="d-flex justify-content-between mb-2">
        <span class="text-muted small">Total Orders</span>
        <span class="fw-bold"><?php echo e($total); ?></span>
    </div>
    <div class="d-flex justify-content-between mb-2">
        <span class="text-muted small">Pending</span>
        <span class="fw-bold text-warning"><?php echo e($pending); ?></span>
    </div>
    <div class="d-flex justify-content-between">
        <span class="text-muted small">Completed</span>
        <span class="fw-bold text-success"><?php echo e($completed); ?></span>
    </div>
</div>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\components\admin-widgets\orders.blade.php ENDPATH**/ ?>