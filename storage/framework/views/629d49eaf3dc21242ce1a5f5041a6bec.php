<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'icon' => 'bi bi-inbox',
    'message' => 'No records found.',
    'buttonLabel' => null,
    'buttonRoute' => null,
]));

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

foreach (array_filter(([
    'icon' => 'bi bi-inbox',
    'message' => 'No records found.',
    'buttonLabel' => null,
    'buttonRoute' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div class="text-center py-5" role="status">
    <i class="<?php echo e($icon); ?> text-gray-400" style="font-size: 3rem;" aria-hidden="true"></i>
    <p class="text-muted mt-3 mb-3"><?php echo e($message); ?></p>
    <?php if($buttonLabel && $buttonRoute): ?>
        <a href="<?php echo e(route($buttonRoute)); ?>" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1" aria-hidden="true"></i> <?php echo e($buttonLabel); ?>

        </a>
    <?php endif; ?>
</div>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\components\admin\empty-state.blade.php ENDPATH**/ ?>