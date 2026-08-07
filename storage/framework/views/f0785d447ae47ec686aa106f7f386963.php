<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['variant' => [], 'index' => 0, 'attributes' => []]));

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

foreach (array_filter((['variant' => [], 'index' => 0, 'attributes' => []]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div class="variant-row card mb-2 variant-item" data-index="<?php echo e($index); ?>">
    <div class="card-body py-2">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <span class="fw-semibold variant-number">Variant #<?php echo e($index + 1); ?></span>
            <button type="button" class="btn btn-sm btn-outline-danger remove-variant" aria-label="Remove variant #<?php echo e($index + 1); ?>">
                <i class="fas fa-times" aria-hidden="true"></i> Remove
            </button>
        </div>
        <div class="row g-2">
            <div class="col-md-3">
                <label class="form-label small">Variant Name <span class="text-danger">*</span></label>
                <input type="text" name="variants[<?php echo e($index); ?>][name]" class="form-control form-control-sm"
                    value="<?php echo e($variant['name'] ?? ''); ?>" placeholder="e.g. Red, Large">
            </div>
            <div class="col-md-2">
                <label class="form-label small">SKU</label>
                <input type="text" name="variants[<?php echo e($index); ?>][sku]" class="form-control form-control-sm variant-sku"
                    value="<?php echo e($variant['sku'] ?? ''); ?>" placeholder="Auto">
            </div>
            <div class="col-md-2">
                <label class="form-label small">Price</label>
                <input type="number" name="variants[<?php echo e($index); ?>][price]" class="form-control form-control-sm variant-price"
                    value="<?php echo e($variant['price'] ?? ''); ?>" step="0.01" min="0" placeholder="Inherit">
            </div>
            <div class="col-md-2">
                <label class="form-label small">Stock</label>
                <input type="number" name="variants[<?php echo e($index); ?>][stock]" class="form-control form-control-sm variant-stock"
                    value="<?php echo e($variant['stock'] ?? 0); ?>" min="0">
            </div>
            <div class="col-md-1">
                <label class="form-label small">Active</label>
                <div class="form-check form-switch mt-1">
                    <input type="checkbox" class="form-check-input" name="variants[<?php echo e($index); ?>][status]" value="1"
                        <?php echo e(!isset($variant['status']) || $variant['status'] ? 'checked' : ''); ?>

                        aria-label="Variant <?php echo e($index + 1); ?> active status">
                </div>
            </div>
            <div class="col-md-2">
                <label class="form-label small">Image</label>
                <input type="file" name="variants[<?php echo e($index); ?>][image_file]" class="form-control form-control-sm" accept="image/*" aria-label="Upload variant image">
            </div>
        </div>

        <?php if(count($attributes) > 0): ?>
            <div class="row g-2 mt-2">
                <div class="col-12">
                    <label class="form-label small text-muted">Attribute Values</label>
                </div>
                <?php $__currentLoopData = $attributes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attribute): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-auto">
                        <select name="variants[<?php echo e($index); ?>][attribute_values][]" class="form-select form-select-sm" aria-label="<?php echo e($attribute->name); ?>">
                            <option value=""><?php echo e($attribute->name); ?></option>
                            <?php $__currentLoopData = $attribute->values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($value->id); ?>"
                                    <?php echo e(in_array($value->id, $variant['attribute_values'] ?? []) ? 'selected' : ''); ?>>
                                    <?php echo e($value->value); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>

        <?php if(isset($variant['id']) && $variant['id'] > 0): ?>
            <input type="hidden" name="variants[<?php echo e($index); ?>][id]" value="<?php echo e($variant['id']); ?>">
        <?php endif; ?>
    </div>
</div>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\components\admin\product\variant-row.blade.php ENDPATH**/ ?>