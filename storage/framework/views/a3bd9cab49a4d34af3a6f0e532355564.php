<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'permission',
    'tag' => 'button',
    'href' => null,
    'class' => '',
    'action' => null,
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
    'permission',
    'tag' => 'button',
    'href' => null,
    'class' => '',
    'action' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $user = auth()->guard('admin')->user();
    $hasAccess = $user && ($user->hasRole('super-admin') || $user->can($permission));
?>

<?php if($hasAccess): ?>
    <?php if($tag === 'a'): ?>
        <a href="<?php echo e($href); ?>" class="<?php echo e($class); ?>" <?php if($action): ?> data-action="<?php echo e($action); ?>" <?php endif; ?>>
            <?php echo e($slot); ?>

        </a>
    <?php else: ?>
        <button type="button" class="<?php echo e($class); ?>" <?php if($action): ?> data-action="<?php echo e($action); ?>" <?php endif; ?>>
            <?php echo e($slot); ?>

        </button>
    <?php endif; ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\components\permission-button.blade.php ENDPATH**/ ?>