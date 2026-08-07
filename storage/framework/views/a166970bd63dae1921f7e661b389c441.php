<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['selected' => 'simple']));

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

foreach (array_filter((['selected' => 'simple']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div class="mb-3">
    <label class="form-label fw-semibold">Product Type</label>
    <div class="row g-2" role="radiogroup" aria-label="Product type selection">
        <div class="col-4">
            <input type="radio" class="btn-check" name="product_type" id="typeSimple" value="simple" autocomplete="off"
                <?php echo e($selected === 'simple' ? 'checked' : ''); ?>>
            <label class="btn btn-outline-primary w-100 text-start py-3 px-3" for="typeSimple" aria-describedby="simpleDesc">
                <div class="d-flex align-items-center gap-3">
                    <i class="fas fa-box fa-lg" aria-hidden="true"></i>
                    <div>
                        <div class="fw-semibold">Simple</div>
                        <small class="opacity-75" id="simpleDesc">Single product, no variants</small>
                    </div>
                </div>
            </label>
        </div>
        <div class="col-4">
            <input type="radio" class="btn-check" name="product_type" id="typeVariable" value="variable" autocomplete="off"
                <?php echo e($selected === 'variable' ? 'checked' : ''); ?>>
            <label class="btn btn-outline-primary w-100 text-start py-3 px-3" for="typeVariable" aria-describedby="variableDesc">
                <div class="d-flex align-items-center gap-3">
                    <i class="fas fa-layer-group fa-lg" aria-hidden="true"></i>
                    <div>
                        <div class="fw-semibold">Variable</div>
                        <small class="opacity-75" id="variableDesc">Size, Color, Custom options</small>
                    </div>
                </div>
            </label>
        </div>
        <div class="col-4">
            <input type="radio" class="btn-check" name="product_type" id="typeDigital" value="digital" autocomplete="off"
                <?php echo e($selected === 'digital' ? 'checked' : ''); ?>>
            <label class="btn btn-outline-primary w-100 text-start py-3 px-3" for="typeDigital" aria-describedby="digitalDesc">
                <div class="d-flex align-items-center gap-3">
                    <i class="fas fa-download fa-lg" aria-hidden="true"></i>
                    <div>
                        <div class="fw-semibold">Digital</div>
                        <small class="opacity-75" id="digitalDesc">Downloadable files, keys</small>
                    </div>
                </div>
            </label>
        </div>
    </div>
</div>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\components\admin\product\type-selector.blade.php ENDPATH**/ ?>