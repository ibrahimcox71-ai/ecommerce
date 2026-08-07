<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['status' => 'active']));

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

foreach (array_filter((['status' => 'active']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $styles = [
        'active' => 'bg-success-subtle text-success border-success-subtle',
        'inactive' => 'bg-secondary-subtle text-secondary border-secondary-subtle',
        'draft' => 'bg-warning-subtle text-warning border-warning-subtle',
        'hidden' => 'bg-dark-subtle text-dark border-dark-subtle',
    ];
    $icons = [
        'active' => 'fa-check-circle',
        'inactive' => 'fa-pause-circle',
        'draft' => 'fa-pen-fancy',
        'hidden' => 'fa-eye-slash',
    ];
    $class = $styles[$status] ?? 'bg-secondary-subtle text-secondary';
    $icon = $icons[$status] ?? 'fa-circle';
?>

<span class="badge border <?php echo e($class); ?> px-3 py-2 rounded-pill">
    <i class="fas <?php echo e($icon); ?> me-1"></i>
    <?php echo e(ucfirst($status)); ?>

</span>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\components\admin\category\status-badge.blade.php ENDPATH**/ ?>