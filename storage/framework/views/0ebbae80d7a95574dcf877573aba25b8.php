<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['cards' => []]));

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

foreach (array_filter((['cards' => []]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php if(empty($cards)): ?>
    <p class="text-muted small">No statistics available.</p>
<?php else: ?>
<div class="row g-3 mb-4">
    <?php $__currentLoopData = $cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-6 col-md-4 col-lg-3 col-xl-2">
            <div class="card border-0 shadow-sm h-100 <?php echo e($card['class'] ?? ''); ?>">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-3">
                        <?php if(isset($card['icon'])): ?>
                            <span class="stat-icon d-flex align-items-center justify-content-center p-2 rounded-3" style="width: 40px; height: 40px; background: <?php echo e($card['icon_bg'] ?? 'var(--bs-primary-bg-subtle)'); ?>;">
                                <i class="<?php echo e($card['icon']); ?> fs-5" style="color: <?php echo e($card['icon_color'] ?? 'var(--bs-primary)'); ?>;" aria-hidden="true"></i>
                            </span>
                        <?php endif; ?>
                        <div class="flex-grow-1 min-w-0">
                            <p class="text-muted mb-0 small text-truncate"><?php echo e($card['label']); ?></p>
                            <h5 class="mb-0 fw-bold"><?php echo e($card['value']); ?></h5>
                            <?php if(isset($card['trend'])): ?>
                                <small class="text-<?php echo e($card['trend_color'] ?? 'success'); ?>"><?php echo e($card['trend']); ?></small>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php endif; ?>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\components\admin\stat-cards.blade.php ENDPATH**/ ?>