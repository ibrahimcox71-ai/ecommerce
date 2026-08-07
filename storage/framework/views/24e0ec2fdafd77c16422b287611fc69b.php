<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['title' => 'Stay in the Loop', 'subtitle' => 'Subscribe to get special offers and updates.']));

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

foreach (array_filter((['title' => 'Stay in the Loop', 'subtitle' => 'Subscribe to get special offers and updates.']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<section class="mb-5">
    <div class="newsletter-card rounded-4 p-5 text-center text-white">
        <h2 class="fw-bold mb-2"><?php echo e($title); ?></h2>
        <p class="mb-4 text-white-50"><?php echo e($subtitle); ?></p>
        <form class="newsletter-form mx-auto" style="max-width: 480px;" method="POST" action="<?php echo e(route('newsletter.subscribe')); ?>">
            <?php echo csrf_field(); ?>
            <div class="input-group">
                <input type="email" name="email" class="form-control form-control-lg border-0" placeholder="Enter your email" required aria-label="Email for newsletter">
                <button type="submit" class="btn btn-light px-4 fw-semibold">Subscribe</button>
            </div>
        </form>
    </div>
</section>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\components\newsletter.blade.php ENDPATH**/ ?>