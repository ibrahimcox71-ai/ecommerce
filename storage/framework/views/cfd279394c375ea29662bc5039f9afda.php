<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'route' => null,
    'perPage' => 15,
    'total' => 0,
    'from' => 0,
    'to' => 0,
    'deleteUrl' => '',
    'statusUrl' => '',
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
    'route' => null,
    'perPage' => 15,
    'total' => 0,
    'from' => 0,
    'to' => 0,
    'deleteUrl' => '',
    'statusUrl' => '',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2 mb-3">
    <div class="d-flex align-items-center gap-2 flex-wrap bulk-actions d-none" aria-live="polite" aria-atomic="true">
        <span class="text-muted small selected-count">0 selected</span>
        <select class="form-select form-select-sm" id="bulkStatusSelect" aria-label="Bulk action">
            <option value="">-- Actions --</option>
            <option value="active">Set Active</option>
            <option value="inactive">Set Inactive</option>
        </select>
        <button type="button" class="btn btn-primary btn-sm" id="bulkStatusUpdate" aria-label="Apply status update">
            <i class="fas fa-check me-1" aria-hidden="true"></i> Update
        </button>
        <button type="button" class="btn btn-danger btn-sm" id="bulkDelete" aria-label="Delete selected">
            <i class="fas fa-trash me-1" aria-hidden="true"></i> Delete
        </button>
    </div>
    <div class="d-flex align-items-center gap-2 ms-auto">
        <small class="text-muted">
            Showing <?php echo e($from); ?> to <?php echo e($to); ?> of <?php echo e($total); ?> entries
        </small>
        <select class="form-select form-select-sm" id="perPageSelect" aria-label="Items per page" onchange="window.location.href='<?php echo e($route ? route($route) : url()->current()); ?>?per_page='+this.value">
            <option value="15" <?php if($perPage == 15): echo 'selected'; endif; ?>>15</option>
            <option value="25" <?php if($perPage == 25): echo 'selected'; endif; ?>>25</option>
            <option value="50" <?php if($perPage == 50): echo 'selected'; endif; ?>>50</option>
            <option value="100" <?php if($perPage == 100): echo 'selected'; endif; ?>>100</option>
        </select>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
$(document).ready(function () {
    const $selectAll = $('#selectAll');
    const $checkboxes = $('.table-checkbox');
    const $bulkActions = $('.bulk-actions');
    const $selectedCount = $('.selected-count');
    const $bulkDelete = $('#bulkDelete');
    const $bulkStatusUpdate = $('#bulkStatusUpdate');
    const deleteUrl = '<?php echo e($deleteUrl ?? ""); ?>';
    const statusUrl = '<?php echo e($statusUrl ?? ""); ?>';

    $selectAll?.on('change', function () {
        $checkboxes.prop('checked', this.checked);
        updateBulkActions();
    });

    $checkboxes?.on('change', function () {
        if ($selectAll) $selectAll.prop('checked', $checkboxes.length === $checkboxes.filter(':checked').length);
        updateBulkActions();
    });

    function updateBulkActions() {
        const checked = $checkboxes.filter(':checked');
        if (checked.length > 0) {
            $bulkActions.removeClass('d-none');
            $selectedCount.text(checked.length + ' selected');
        } else {
            $bulkActions.addClass('d-none');
        }
    }

    $bulkDelete?.on('click', function () {
        const ids = $checkboxes.filter(':checked').map(function () { return $(this).val(); }).get();
        if (ids.length === 0) return;
        if (!confirm('Are you sure you want to delete ' + ids.length + ' item(s)?')) return;
        $.post(deleteUrl, { ids: ids, _token: '<?php echo e(csrf_token()); ?>', _method: 'DELETE' }, function () { location.reload(); });
    });

    $bulkStatusUpdate?.on('click', function () {
        const ids = $checkboxes.filter(':checked').map(function () { return $(this).val(); }).get();
        const status = $('#bulkStatusSelect').val();
        if (ids.length === 0 || !status) return;
        $.post(statusUrl, { ids: ids, status: status, _token: '<?php echo e(csrf_token()); ?>' }, function () { location.reload(); });
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\components\admin\bulk-actions.blade.php ENDPATH**/ ?>