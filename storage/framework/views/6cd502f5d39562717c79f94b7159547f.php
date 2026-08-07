<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['amount' => 0, 'trend' => 0]));

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

foreach (array_filter((['amount' => 0, 'trend' => 0]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<div class="dashboard-widget">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <p class="text-muted small mb-0">Total Revenue</p>
            <h3 class="fw-bold mb-0">$<?php echo e(number_format($amount, 2)); ?></h3>
        </div>
        <?php if($trend): ?>
            <span class="badge bg-<?php echo e($trend >= 0 ? 'success' : 'danger'); ?> rounded-pill">
                <?php echo e($trend >= 0 ? '+' : ''); ?><?php echo e(number_format($trend, 1)); ?>%
            </span>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\components\admin-widgets\revenue.blade.php ENDPATH**/ ?>