<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'id' => 'confirmDeleteModal',
    'title' => 'Confirm Delete',
    'message' => 'Are you sure you want to delete this item? This action cannot be undone.',
    'cancelText' => 'Cancel',
    'confirmText' => 'Delete',
    'confirmBtnId' => 'confirmDeleteBtn',
    'formId' => 'deleteForm',
    'action' => '#',
    'entity' => 'item',
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
    'id' => 'confirmDeleteModal',
    'title' => 'Confirm Delete',
    'message' => 'Are you sure you want to delete this item? This action cannot be undone.',
    'cancelText' => 'Cancel',
    'confirmText' => 'Delete',
    'confirmBtnId' => 'confirmDeleteBtn',
    'formId' => 'deleteForm',
    'action' => '#',
    'entity' => 'item',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<div class="modal fade" id="<?php echo e($id); ?>" tabindex="-1" role="dialog" aria-modal="true" aria-labelledby="<?php echo e($id); ?>Label">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="<?php echo e($id); ?>Label"><?php echo e($title); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger mb-0">
                    <i class="fas fa-exclamation-triangle me-2" aria-hidden="true"></i>
                    <?php echo e($message); ?>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo e($cancelText); ?></button>
                <button type="button" class="btn btn-danger" id="<?php echo e($confirmBtnId); ?>"
                        data-entity="<?php echo e($entity); ?>">
                    <i class="fas fa-trash me-1" aria-hidden="true"></i> <?php echo e($confirmText); ?>

                </button>
                <form id="<?php echo e($formId); ?>" method="POST" class="d-none" action="<?php echo e($action); ?>">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                </form>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\components\confirm-delete.blade.php ENDPATH**/ ?>