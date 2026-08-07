<?php if (isset($component)) { $__componentOriginaledc75c655a063d12a477f2c8d8f324fc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc = $attributes; } ?>
<?php $component = App\View\Components\Layouts\AdminLayout::resolve(['title' => 'Warehouses'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Warehouses</h4>
            <p class="text-muted small mb-0">Manage your warehouse locations</p>
        </div>
        <div class="d-flex gap-2">
            <a href="<?php echo e(route('admin.warehouses.trashed')); ?>" class="btn btn-outline-secondary">
                <i class="fas fa-trash-alt me-1"></i> Trashed
            </a>
            <a href="<?php echo e(route('admin.warehouses.create')); ?>" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Add Warehouse
            </a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="<?php echo e(route('admin.warehouses.index')); ?>" class="row g-3">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
                        <input type="text" name="search" class="form-control"
                               placeholder="Search warehouses..." value="<?php echo e(request('search')); ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="1" <?php echo e(request('status') === '1' ? 'selected' : ''); ?>>Active</option>
                        <option value="0" <?php echo e(request('status') === '0' ? 'selected' : ''); ?>>Inactive</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-outline-primary w-100">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <div class="d-none" id="bulkActions">
        <div class="alert alert-info d-flex align-items-center justify-content-between mb-3">
            <span><i class="fas fa-check-circle me-2"></i><span id="selectedCount">0</span> selected</span>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-sm btn-success" onclick="bulkRestore()">
                    <i class="fas fa-undo me-1"></i> Restore
                </button>
                <button type="button" class="btn btn-sm btn-danger" onclick="bulkDelete()">
                    <i class="fas fa-trash me-1"></i> Delete
                </button>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <?php if($warehouses->count() > 0): ?>
                <form id="bulkForm" method="POST" action="<?php echo e(route('admin.warehouses.bulk-delete')); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0" style="width: 40px;">
                                        <input type="checkbox" class="form-check-input" id="selectAll">
                                    </th>
                                    <th class="border-0">Warehouse</th>
                                    <th class="border-0" style="width: 100px;">Code</th>
                                    <th class="border-0" style="width: 130px;">Manager</th>
                                    <th class="border-0" style="width: 150px;">Location</th>
                                    <th class="border-0 text-center" style="width: 60px;">Items</th>
                                    <th class="border-0 text-center" style="width: 60px;">Default</th>
                                    <th class="border-0 text-center" style="width: 80px;">Status</th>
                                    <th class="border-0 text-end" style="width: 150px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $warehouses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $warehouse): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr data-id="<?php echo e($warehouse->id); ?>">
                                        <td>
                                            <input type="checkbox" name="ids[]" value="<?php echo e($warehouse->id); ?>"
                                                   class="form-check-input row-checkbox">
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="rounded me-3 d-flex align-items-center justify-content-center"
                                                     style="width: 48px; height: 48px; background: <?php echo e($warehouse->is_default ? '#e8f5e9' : '#f5f5f5'); ?>;">
                                                    <i class="fas fa-warehouse <?php echo e($warehouse->is_default ? 'text-success' : 'text-muted'); ?>"></i>
                                                </div>
                                                <div>
                                                    <a href="<?php echo e(route('admin.warehouses.show', $warehouse->id)); ?>" class="fw-semibold text-decoration-none"><?php echo e($warehouse->name); ?></a>
                                                    <small class="d-block text-muted"><?php echo e($warehouse->email ?: '—'); ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><code class="small"><?php echo e($warehouse->code); ?></code></td>
                                        <td><span class="small"><?php echo e($warehouse->manager_name ?: '—'); ?></span></td>
                                        <td>
                                            <span class="small">
                                                <?php echo e($warehouse->city ?: '—'); ?>

                                                <?php if($warehouse->city && $warehouse->state): ?>, <?php endif; ?>
                                                <?php echo e($warehouse->state ?: ''); ?>

                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-primary bg-opacity-10 text-primary">
                                                <?php echo e($warehouse->inventories_count); ?>

                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <?php if($warehouse->is_default): ?>
                                                <span class="badge bg-success"><i class="fas fa-check"></i></span>
                                            <?php else: ?>
                                                <span class="text-muted">—</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <div class="form-check form-switch d-flex justify-content-center">
                                                <input type="checkbox" class="form-check-input status-toggle"
                                                       role="switch" data-id="<?php echo e($warehouse->id); ?>"
                                                       <?php echo e($warehouse->status ? 'checked' : ''); ?>>
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <div class="btn-group">
                                                <a href="<?php echo e(route('admin.warehouses.show', $warehouse->id)); ?>"
                                                   class="btn btn-sm btn-outline-secondary" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="<?php echo e(route('admin.warehouses.edit', $warehouse->id)); ?>"
                                                   class="btn btn-sm btn-outline-primary" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <?php if(!$warehouse->is_default): ?>
                                                    <button type="button" class="btn btn-sm btn-outline-info"
                                                            onclick="setDefault(<?php echo e($warehouse->id); ?>, '<?php echo e($warehouse->name); ?>')" title="Set as Default">
                                                        <i class="fas fa-star"></i>
                                                    </button>
                                                <?php endif; ?>
                                                <button type="button" class="btn btn-sm btn-outline-danger"
                                                        onclick="confirmDelete(<?php echo e($warehouse->id); ?>, '<?php echo e($warehouse->name); ?>')" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </form>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted small">
                        Showing <?php echo e($warehouses->firstItem()); ?> to <?php echo e($warehouses->lastItem()); ?> of <?php echo e($warehouses->total()); ?> entries
                    </div>
                    <div><?php echo e($warehouses->links()); ?></div>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="fas fa-warehouse fa-3x text-muted mb-3"></i>
                    <h5>No warehouses found</h5>
                    <p class="text-muted">
                        <?php if(request()->anyFilled(['search', 'status'])): ?>
                            No warehouses match your filters. <a href="<?php echo e(route('admin.warehouses.index')); ?>">Clear filters</a>
                        <?php else: ?>
                            Get started by creating your first warehouse.
                        <?php endif; ?>
                    </p>
                    <a href="<?php echo e(route('admin.warehouses.create')); ?>" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Add Warehouse
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaledc75c655a063d12a477f2c8d8f324fc)): ?>
<?php $attributes = $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc; ?>
<?php unset($__attributesOriginaledc75c655a063d12a477f2c8d8f324fc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaledc75c655a063d12a477f2c8d8f324fc)): ?>
<?php $component = $__componentOriginaledc75c655a063d12a477f2c8d8f324fc; ?>
<?php unset($__componentOriginaledc75c655a063d12a477f2c8d8f324fc); ?>
<?php endif; ?>

<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Warehouse</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete <strong id="deleteName"></strong>?</p>
                <div class="alert alert-warning d-none" id="deleteWarning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    This warehouse has inventory records. Please reassign them first.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-1"></i> Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
$(document).ready(function() {
    $('#selectAll').change(function() {
        $('.row-checkbox').prop('checked', $(this).prop('checked'));
        updateBulkActions();
    });

    $('.row-checkbox').change(function() { updateBulkActions(); });

    function updateBulkActions() {
        const checked = $('.row-checkbox:checked').length;
        if (checked > 0) {
            $('#bulkActions').removeClass('d-none');
            $('#selectedCount').text(checked);
        } else {
            $('#bulkActions').addClass('d-none');
        }
    }

    $('.status-toggle').change(function() {
        const id = $(this).data('id');
        $.ajax({
            url: `/admin/warehouses/${id}/toggle-status`,
            type: 'POST',
            data: { _token: '<?php echo e(csrf_token()); ?>' },
            success: function(response) {
                if (response.success) showToast(response.message, 'success');
            },
            error: function() { showToast('An error occurred', 'error'); }
        });
    });
});

function setDefault(id, name) {
    if (confirm(`Set "${name}" as the default warehouse?`)) {
        $.ajax({
            url: `/admin/warehouses/${id}/set-default`,
            type: 'POST',
            data: { _token: '<?php echo e(csrf_token()); ?>' },
            success: function(response) {
                if (response.success || response.includes('success')) {
                    location.reload();
                }
            },
            error: function() { showToast('An error occurred', 'error'); }
        });
    }
}

function confirmDelete(id, name) {
    $('#deleteName').text(name);
    $('#deleteForm').attr('action', `/admin/warehouses/${id}`);
    const count = parseInt($(`tr[data-id="${id}"]`).find('.badge.bg-primary').text());
    if (count > 0) $('#deleteWarning').removeClass('d-none');
    else $('#deleteWarning').addClass('d-none');
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}

function bulkDelete() {
    if (confirm('Are you sure you want to delete selected warehouses?')) {
        $('#bulkForm').attr('action', '<?php echo e(route('admin.warehouses.bulk-delete')); ?>').submit();
    }
}

function bulkRestore() {
    if (confirm('Are you sure you want to restore selected warehouses?')) {
        $('#bulkForm').attr('action', '<?php echo e(route('admin.warehouses.bulk-restore')); ?>').submit();
    }
}

function showToast(message, type) {
    const bg = type === 'success' ? 'bg-success' : type === 'error' ? 'bg-danger' : 'bg-info';
    $('body').append(`<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999;"><div class="toast ${bg} text-white" role="alert"><div class="toast-body d-flex align-items-center"><i class="fas fa-${type === 'success' ? 'check' : type === 'error' ? 'times' : 'info'} me-2"></i>${message}</div></div></div>`);
    $('.toast').toast('show');
    setTimeout(() => $('.toast').parent().remove(), 3000);
}
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\admin\warehouses\index.blade.php ENDPATH**/ ?>