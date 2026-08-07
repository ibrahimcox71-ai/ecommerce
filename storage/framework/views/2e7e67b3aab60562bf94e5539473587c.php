<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'name' => 'image',
    'label' => 'Image',
    'currentImage' => null,
    'accept' => 'image/*',
    'maxSize' => '2MB',
    'recommended' => '512x512px',
    'helpText' => null,
    'removable' => false,
    'removeName' => 'remove_image',
]));

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

foreach (array_filter(([
    'name' => 'image',
    'label' => 'Image',
    'currentImage' => null,
    'accept' => 'image/*',
    'maxSize' => '2MB',
    'recommended' => '512x512px',
    'helpText' => null,
    'removable' => false,
    'removeName' => 'remove_image',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div class="mb-3">
    <label class="form-label fw-medium"><?php echo e($label); ?></label>

    <div class="border rounded-3 p-3 text-center bg-light-subtle upload-zone"
         id="previewContainer_<?php echo e($name); ?>"
         tabindex="0"
         role="button"
         aria-label="Click or drop to upload <?php echo e($label); ?>"
         ondragover="event.preventDefault()"
         ondrop="handleMediaDrop(event, '<?php echo e($name); ?>')">
        <?php if($currentImage): ?>
            <img id="preview_<?php echo e($name); ?>"
                 src="<?php echo e($currentImage); ?>"
                 alt="<?php echo e($label); ?> preview"
                 class="img-fluid rounded mb-2 upload-preview">
        <?php else: ?>
            <img id="preview_<?php echo e($name); ?>"
                 src="#"
                 alt="<?php echo e($label); ?> preview"
                 class="img-fluid rounded mb-2 d-none upload-preview">
        <?php endif; ?>
        <div id="placeholder_<?php echo e($name); ?>" class="py-3 <?php echo e($currentImage ? 'd-none' : ''); ?>">
            <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-2" aria-hidden="true"></i>
            <p class="text-muted small mb-0">Drop file here or click to browse</p>
        </div>
    </div>

    <input type="file"
           class="form-control mt-2 <?php $__errorArgs = [$name];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
           id="input_<?php echo e($name); ?>"
           name="<?php echo e($name); ?>"
           accept="<?php echo e($accept); ?>"
           aria-label="Choose <?php echo e($label); ?> file"
           onchange="previewMediaFile(this, '<?php echo e($name); ?>')">

    <div class="d-flex justify-content-between align-items-start mt-1">
        <small class="text-muted">
            <?php echo e($helpText ?? "Accepted: JPG, PNG, WEBP. Max {$maxSize}. Recommended: {$recommended}"); ?>

        </small>
        <?php if($removable && $currentImage): ?>
            <div class="form-check ms-2">
                <input class="form-check-input" type="checkbox"
                       id="<?php echo e($removeName); ?>"
                       name="<?php echo e($removeName); ?>" value="1"
                       onchange="toggleRemoveMedia('<?php echo e($name); ?>', this)">
                <label class="form-check-label text-danger small" for="<?php echo e($removeName); ?>">
                    <i class="fas fa-trash-alt me-1" aria-hidden="true"></i>Remove
                </label>
            </div>
        <?php endif; ?>
    </div>

    <?php $__errorArgs = [$name];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
function previewMediaFile(input, name) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('preview_' + name);
            preview.src = e.target.result;
            preview.classList.remove('d-none');
            document.getElementById('placeholder_' + name).classList.add('d-none');
            const removeCheckbox = document.getElementById('<?php echo e($removeName); ?>');
            if (removeCheckbox) removeCheckbox.checked = false;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function handleMediaDrop(event, name) {
    event.preventDefault();
    const files = event.dataTransfer.files;
    if (files.length > 0) {
        const input = document.getElementById('input_' + name);
        input.files = files;
        previewMediaFile(input, name);
    }
}

function toggleRemoveMedia(name, checkbox) {
    const preview = document.getElementById('preview_' + name);
    const placeholder = document.getElementById('placeholder_' + name);
    const input = document.getElementById('input_' + name);

    if (checkbox.checked) {
        preview.classList.add('d-none');
        placeholder.classList.remove('d-none');
        input.value = '';
    } else {
        <?php if($currentImage): ?>
        preview.classList.remove('d-none');
        placeholder.classList.add('d-none');
        <?php endif; ?>
    }
}
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\components\admin\category\media-uploader.blade.php ENDPATH**/ ?>