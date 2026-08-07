<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['posts' => [], 'title' => 'Latest News']));

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

foreach (array_filter((['posts' => [], 'title' => 'Latest News']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<?php if($posts->isNotEmpty()): ?>
    <section class="mb-5">
        <div class="section-header">
            <div class="section-header-left">
                <span class="section-bar"></span>
                <h3><?php echo e($title); ?></h3>
            </div>
            <a href="<?php echo e(route('blog')); ?>" class="section-link">View All <i class="fas fa-arrow-right ms-1" aria-hidden="true"></i></a>
        </div>
        <div class="row g-4">
            <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="rounded-top-4 d-flex align-items-center justify-content-center" style="height: 200px; background: linear-gradient(135deg, var(--primary-50), #E0E7FF);">
                            <i class="fas fa-newspaper fa-4x text-primary-custom" style="opacity: 0.4;" aria-hidden="true"></i>
                        </div>
                        <div class="card-body p-4">
                            <h5 class="fw-bold card-title text-gray-800"><?php echo e($post->title ?? 'Blog Post'); ?></h5>
                            <p class="card-text text-muted"><?php echo e(Str::limit($post->excerpt ?? ($post->body ?? ''), 100)); ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </section>
<?php endif; ?>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\components\blog.blade.php ENDPATH**/ ?>