<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['products' => [], 'endDate' => null]));

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

foreach (array_filter((['products' => [], 'endDate' => null]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<?php if($products->isNotEmpty()): ?>
    <section class="flash-sale-v2 mb-5">
        <div class="flash-bg-pattern">
            <i class="fas fa-bolt" aria-hidden="true"></i>
        </div>
        <div class="flash-content">
            <div class="flash-header">
                <div class="flash-title-section">
                    <div class="flash-icon">
                        <i class="fas fa-bolt" aria-hidden="true"></i>
                    </div>
                    <div>
                        <h2 class="flash-title">Flash Sale</h2>
                        <p class="flash-subtitle">Limited time offers ending soon</p>
                    </div>
                </div>
                <div class="flash-timer-v2" data-end="<?php echo e($endDate ?? now()->addDays(3)); ?>">
                    <div class="timer-block">
                        <span class="timer-num" id="fsd-days">00</span>
                        <span class="timer-label">Days</span>
                    </div>
                    <span class="timer-sep">:</span>
                    <div class="timer-block">
                        <span class="timer-num" id="fsd-hours">00</span>
                        <span class="timer-label">Hours</span>
                    </div>
                    <span class="timer-sep">:</span>
                    <div class="timer-block">
                        <span class="timer-num" id="fsd-mins">00</span>
                        <span class="timer-label">Mins</span>
                    </div>
                    <span class="timer-sep">:</span>
                    <div class="timer-block">
                        <span class="timer-num" id="fsd-secs">00</span>
                        <span class="timer-label">Secs</span>
                    </div>
                </div>
            </div>
            <div class="flash-products-grid">
                <?php $__currentLoopData = $products->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if (isset($component)) { $__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.product-card','data' => ['product' => $product]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('product-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['product' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($product)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a)): ?>
<?php $attributes = $__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a; ?>
<?php unset($__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a)): ?>
<?php $component = $__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a; ?>
<?php unset($__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a); ?>
<?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="flash-cta">
                <a href="<?php echo e(route('flash-sale')); ?>" class="btn btn-light rounded-pill px-4">View All Deals <i class="fas fa-arrow-right ms-1" aria-hidden="true"></i></a>
            </div>
        </div>
    </section>
<?php endif; ?>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\components\flash-sale.blade.php ENDPATH**/ ?>