<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'title' => 'Trashed Items',
    'count' => 0,
    'actions' => '',
    'indexRoute' => '#',
    'entity' => 'Items',
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
    'title' => 'Trashed Items',
    'count' => 0,
    'actions' => '',
    'indexRoute' => '#',
    'entity' => 'Items',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<div class="alert alert-info d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3" role="status">
    <div>
        <i class="fas fa-trash-restore me-2" aria-hidden="true"></i>
        <strong><?php echo e($title); ?></strong>
        <span class="ms-2 text-muted"><?php echo e($count); ?> item(s)</span>
    </div>
    <div class="d-flex gap-2">
        <?php echo e($actions); ?>

        <a href="<?php echo e($indexRoute); ?>" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1" aria-hidden="true"></i> Back to <?php echo e($entity); ?>

        </a>
    </div>
</div>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\components\trashed-header.blade.php ENDPATH**/ ?>