<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['name' => 'gallery', 'multiple' => true, 'accept' => 'image/*', 'label' => 'Drop images here or click to upload', 'existing' => [], 'primaryImageId' => null]));

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

foreach (array_filter((['name' => 'gallery', 'multiple' => true, 'accept' => 'image/*', 'label' => 'Drop images here or click to upload', 'existing' => [], 'primaryImageId' => null]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div class="product-dropzone-wrapper">
    <div class="product-dropzone" id="dropzone-<?php echo e($name); ?>" data-name="<?php echo e($name); ?>" data-multiple="<?php echo e($multiple ? 'true' : 'false'); ?>" tabindex="0" role="button" aria-label="<?php echo e($label); ?>">
        <div class="dropzone-message">
            <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3" aria-hidden="true"></i>
            <p class="mb-1 fw-semibold"><?php echo e($label); ?></p>
            <small class="text-muted">Supported: JPEG, PNG, JPG, GIF, WebP (Max 5MB each)</small>
        </div>
        <div class="dropzone-preview row g-2 mt-3" id="preview-<?php echo e($name); ?>">
            <?php $__currentLoopData = $existing; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-auto existing-image" data-id="<?php echo e($image['id'] ?? ''); ?>" data-image="<?php echo e($image['image'] ?? ''); ?>">
                    <div class="product-image-item <?php echo e(($image['is_primary'] ?? false) ? 'primary' : ''); ?>">
                        <img src="<?php echo e($image['url'] ?? $image['image']); ?>" alt="<?php echo e($image['alt_text'] ?? ''); ?>">
                        <div class="image-actions">
                            <?php if(!($image['is_primary'] ?? false)): ?>
                                <button type="button" class="btn btn-sm btn-light set-primary" title="Set as Primary" aria-label="Set as primary image">
                                    <i class="fas fa-star" aria-hidden="true"></i>
                                </button>
                            <?php endif; ?>
                            <button type="button" class="btn btn-sm btn-danger remove-image" title="Remove" aria-label="Remove image">
                                <i class="fas fa-times" aria-hidden="true"></i>
                            </button>
                        </div>
                        <?php if($image['is_primary'] ?? false): ?>
                            <div class="primary-badge">Primary</div>
                        <?php endif; ?>
                        <input type="hidden" name="images[<?php echo e($loop->index ?? 0); ?>][id]" value="<?php echo e($image['id'] ?? ''); ?>">
                        <input type="hidden" name="images[<?php echo e($loop->index ?? 0); ?>][image]" value="<?php echo e($image['image'] ?? ''); ?>">
                        <input type="hidden" name="images[<?php echo e($loop->index ?? 0); ?>][is_primary]" value="<?php echo e(($image['is_primary'] ?? false) ? '1' : '0'); ?>">
                        <input type="hidden" name="images[<?php echo e($loop->index ?? 0); ?>][sort_order]" value="<?php echo e($loop->index ?? 0); ?>">
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <input type="file" name="<?php echo e($name); ?>[]" id="fileInput-<?php echo e($name); ?>" accept="<?php echo e($accept); ?>" <?php echo e($multiple ? 'multiple' : ''); ?> class="d-none" aria-label="Choose files to upload">
</div>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\components\admin\product\dropzone.blade.php ENDPATH**/ ?>