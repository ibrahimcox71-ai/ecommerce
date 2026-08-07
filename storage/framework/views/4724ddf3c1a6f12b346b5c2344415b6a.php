<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['slides' => []]));

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

foreach (array_filter((['slides' => []]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<?php if($slides->isNotEmpty()): ?>
    <section class="hero-slider-v2 swiper mb-5" aria-label="Featured promotions">
        <div class="swiper-wrapper">
            <?php $__currentLoopData = $slides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="swiper-slide">
                    <div class="hero-slide-content" style="background: linear-gradient(135deg, <?php echo e($slide['bg_start'] ?? 'var(--primary)'); ?>, <?php echo e($slide['bg_end'] ?? 'var(--secondary)'); ?>);">
                        <div class="container">
                            <div class="row align-items-center">
                                <div class="col-lg-6">
                                    <h1 class="hero-title-xlarge text-white"><?php echo e($slide['title'] ?? ''); ?></h1>
                                    <p class="hero-subtitle text-white"><?php echo e($slide['subtitle'] ?? ''); ?></p>
                                    <?php if($slide['cta_url'] ?? false): ?>
                                        <a href="<?php echo e($slide['cta_url']); ?>" class="btn btn-light btn-lg rounded-pill px-4 mt-3">
                                            <?php echo e($slide['cta_text'] ?? 'Shop Now'); ?> <i class="fas fa-arrow-right ms-2" aria-hidden="true"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                                <?php if($slide['image'] ?? false): ?>
                                    <div class="col-lg-6 text-center">
                                        <img src="<?php echo e($slide['image']); ?>" alt="<?php echo e($slide['title'] ?? ''); ?>" class="img-fluid hero-slide-img" loading="lazy">
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <div class="swiper-pagination hero-pagination" aria-hidden="true"></div>
    </section>
<?php endif; ?>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\components\hero-slider.blade.php ENDPATH**/ ?>