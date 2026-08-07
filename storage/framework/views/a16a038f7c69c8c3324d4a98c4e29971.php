<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['cart' => null]));

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

foreach (array_filter((['cart' => null]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div class="dropdown-menu dropdown-menu-end mini-cart-dropdown-v2" id="miniCartDropdown">
    <?php if (isset($component)) { $__componentOriginal3ea00a7772fa8583412300883e4a87b5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3ea00a7772fa8583412300883e4a87b5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.mini-cart-content','data' => ['cart' => $cart]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('mini-cart-content'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['cart' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($cart)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3ea00a7772fa8583412300883e4a87b5)): ?>
<?php $attributes = $__attributesOriginal3ea00a7772fa8583412300883e4a87b5; ?>
<?php unset($__attributesOriginal3ea00a7772fa8583412300883e4a87b5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3ea00a7772fa8583412300883e4a87b5)): ?>
<?php $component = $__componentOriginal3ea00a7772fa8583412300883e4a87b5; ?>
<?php unset($__componentOriginal3ea00a7772fa8583412300883e4a87b5); ?>
<?php endif; ?>
</div>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\components\mini-cart.blade.php ENDPATH**/ ?>