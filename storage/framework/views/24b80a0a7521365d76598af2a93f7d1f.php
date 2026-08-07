<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'title',
    'subtitle' => null,
    'buttons' => [],
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
    'title',
    'subtitle' => null,
    'buttons' => [],
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
    <div>
        <h4 class="mb-1 fw-semibold"><?php echo e($title); ?></h4>
        <?php if($subtitle): ?>
            <p class="text-muted mb-0 small"><?php echo e($subtitle); ?></p>
        <?php endif; ?>
    </div>
    <div class="d-flex gap-2 flex-wrap">
        <?php $__currentLoopData = $buttons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $button): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(isset($button['route'])): ?>
                <a href="<?php echo e(route($button['route'], $button['params'] ?? [])); ?>"
                   class="btn btn-<?php echo e($button['color'] ?? 'primary'); ?> btn-sm d-flex align-items-center gap-1">
                    <?php if(isset($button['icon'])): ?><i class="<?php echo e($button['icon']); ?>"></i><?php endif; ?>
                    <?php echo e($button['label']); ?>

                </a>
            <?php endif; ?>
            <?php if(isset($button['modal'])): ?>
                <button type="button" class="btn btn-<?php echo e($button['color'] ?? 'primary'); ?> btn-sm d-flex align-items-center gap-1"
                        data-bs-toggle="modal" data-bs-target="#<?php echo e($button['modal']); ?>">
                    <?php if(isset($button['icon'])): ?><i class="<?php echo e($button['icon']); ?>"></i><?php endif; ?>
                    <?php echo e($button['label']); ?>

                </button>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php echo e($slot ?? ''); ?>

    </div>
</div>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\components\admin\crud-header.blade.php ENDPATH**/ ?>