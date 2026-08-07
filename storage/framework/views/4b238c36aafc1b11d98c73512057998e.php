<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['type' => 'info', 'icon' => null, 'dismiss' => true, 'class' => '']));

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

foreach (array_filter((['type' => 'info', 'icon' => null, 'dismiss' => true, 'class' => '']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<div class="alert alert-<?php echo e($type); ?> alert-dismissible fade show d-flex align-items-center gap-2 <?php echo e($class); ?>" role="alert">
    <?php if($icon): ?>
        <i class="<?php echo e($icon); ?>" aria-hidden="true"></i>
    <?php elseif($type === 'success'): ?>
        <i class="fas fa-check-circle" aria-hidden="true"></i>
    <?php elseif($type === 'danger' || $type === 'error'): ?>
        <i class="fas fa-exclamation-circle" aria-hidden="true"></i>
    <?php elseif($type === 'warning'): ?>
        <i class="fas fa-exclamation-triangle" aria-hidden="true"></i>
    <?php elseif($type === 'info'): ?>
        <i class="fas fa-info-circle" aria-hidden="true"></i>
    <?php endif; ?>
    <div class="flex-grow-1"><?php echo e($slot); ?></div>
    <?php if($dismiss): ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    <?php endif; ?>
</div>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\components\alert.blade.php ENDPATH**/ ?>