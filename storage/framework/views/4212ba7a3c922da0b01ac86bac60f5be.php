<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['categories' => []]));

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

foreach (array_filter((['categories' => []]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<?php if($categories->isNotEmpty()): ?>
    <section class="mb-5">
        <div class="section-header">
            <div class="section-header-left">
                <span class="section-bar"></span>
                <h3>Featured Categories</h3>
            </div>
            <a href="<?php echo e(route('shop')); ?>" class="section-link">View All <i class="fas fa-arrow-right ms-1" aria-hidden="true"></i></a>
        </div>
        <div class="row g-3 g-md-4 row-cols-2 row-cols-md-3 row-cols-lg-4">
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col">
                    <a href="<?php echo e(route('category.show', $category->slug)); ?>" class="text-decoration-none">
                        <div class="card border-0 shadow-sm rounded-4 text-center p-4 h-100">
                            <div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center sizing-64 bg-primary-50 text-primary-custom" style="font-size: 1.5rem;">
                                <i class="<?php echo e($category->icon ?? 'fas fa-folder'); ?>" aria-hidden="true"></i>
                            </div>
                            <h6 class="fw-semibold mb-1 text-gray-800"><?php echo e($category->name); ?></h6>
                            <small class="text-muted"><?php echo e($category->products_count ?? 0); ?> products</small>
                        </div>
                    </a>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </section>
<?php endif; ?>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\components\category-grid.blade.php ENDPATH**/ ?>