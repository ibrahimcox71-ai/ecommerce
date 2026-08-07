<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['brands' => []]));

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

foreach (array_filter((['brands' => []]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<?php if($brands->isNotEmpty()): ?>
    <section class="mb-5">
        <div class="section-header">
            <div class="section-header-left">
                <span class="section-bar"></span>
                <h3>Shop by Brand</h3>
            </div>
        </div>
        <div class="brand-slider-v2 swiper">
            <div class="swiper-wrapper">
                <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="swiper-slide">
                        <a href="<?php echo e(route('brand.show', $brand->slug)); ?>" class="brand-card-v2">
                            <?php if($brand->image): ?>
                                <img src="<?php echo e(asset('storage/' . $brand->image)); ?>" alt="<?php echo e($brand->name); ?>" loading="lazy">
                            <?php else: ?>
                                <span class="brand-placeholder"><?php echo e($brand->name[0]); ?></span>
                            <?php endif; ?>
                            <span class="brand-name"><?php echo e($brand->name); ?></span>
                        </a>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>
<?php endif; ?>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\components\brand-slider.blade.php ENDPATH**/ ?>