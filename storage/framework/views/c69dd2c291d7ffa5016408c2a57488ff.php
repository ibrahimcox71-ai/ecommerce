<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['price' => 0, 'costPrice' => 0, 'tax' => 0, 'taxType' => 'exclusive', 'discount' => 0, 'discountType' => 'percentage']));

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

foreach (array_filter((['price' => 0, 'costPrice' => 0, 'tax' => 0, 'taxType' => 'exclusive', 'discount' => 0, 'discountType' => 'percentage']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div class="profit-calculator p-3 bg-light rounded" role="region" aria-label="Profit Calculator" aria-live="polite">
    <h6 class="fw-semibold mb-3"><i class="fas fa-chart-line me-2 text-primary" aria-hidden="true"></i>Profit Calculator</h6>
    <div class="row g-2 small">
        <div class="col-6">
            <span class="text-muted">Sale Price:</span>
            <span class="fw-semibold float-end" id="calcSalePrice"><?php echo e(config('ecommerce.currency_symbol')); ?>0.00</span>
        </div>
        <div class="col-6">
            <span class="text-muted">Cost Price:</span>
            <span class="fw-semibold float-end" id="calcCostPrice"><?php echo e(config('ecommerce.currency_symbol')); ?>0.00</span>
        </div>
        <div class="col-12"><hr class="my-1"></div>
        <div class="col-6">
            <span class="text-muted">Profit:</span>
            <span class="fw-semibold float-end text-success" id="calcProfit"><?php echo e(config('ecommerce.currency_symbol')); ?>0.00</span>
        </div>
        <div class="col-6">
            <span class="text-muted">Margin:</span>
            <span class="fw-semibold float-end text-primary" id="calcMargin">0%</span>
        </div>
        <div class="col-12"><hr class="my-1"></div>
        <div class="col-6">
            <span class="text-muted">Tax (<?php echo e($tax); ?>%):</span>
            <span class="fw-semibold float-end" id="calcTax"><?php echo e(config('ecommerce.currency_symbol')); ?>0.00</span>
        </div>
        <div class="col-6">
            <span class="text-muted">After Tax:</span>
            <span class="fw-semibold float-end" id="calcAfterTax"><?php echo e(config('ecommerce.currency_symbol')); ?>0.00</span>
        </div>
    </div>
</div>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\components\admin\product\profit-calculator.blade.php ENDPATH**/ ?>