<?php if (isset($component)) { $__componentOriginaledc75c655a063d12a477f2c8d8f324fc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc = $attributes; } ?>
<?php $component = App\View\Components\Layouts\AdminLayout::resolve(['title' => 'Trashed Warehouses'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Trashed Warehouses</h4>
            <p class="text-muted small mb-0">Deleted warehouses can be restored or permanently removed</p>
        </div>
        <a href="<?php echo e(route('admin.warehouses.index')); ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to Warehouses
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="<?php echo e(route('admin.warehouses.trashed')); ?>" class="row g-3">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
                        <input type="text" name="search" class="form-control" placeholder="Search trashed warehouses..." value="<?php echo e(request('search')); ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-outline-primary me-2">Search</button>
                    <?php if(request()->has('search')): ?>
                        <a href="<?php echo e(route('admin.warehouses.trashed')); ?>" class="btn btn-outline-secondary">Clear</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

    <div class="d-none" id="bulkActions">
        <div class="alert alert-info d-flex align-items-center justify-content-between mb-3">
            <span><i class="fas fa-check-circle me-2"></i><span id="selectedCount">0</span> selected</span>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-sm btn-success" onclick="bulkRestore()">
                    <i class="fas fa-undo me-1"></i> Restore Selected
                </button>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <?php if($warehouses->count() > 0): ?>
                <form id="bulkForm" method="POST" action="<?php echo e(route('admin.warehouses.bulk-restore')); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0" style="width: 40px;"><input type="checkbox" class="form-check-input" id="selectAll"></th>
                                    <th class="border-0">Warehouse</th>
                                    <th class="border-0" style="width: 100px;">Code</th>
                                    <th class="border-0" style="width: 150px;">Deleted At</th>
                                    <th class="border-0 text-end" style="width: 200px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $warehouses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $warehouse): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr data-id="<?php echo e($warehouse->id); ?>">
                                        <td><input type="checkbox" name="ids[]" value="<?php echo e($warehouse->id); ?>" class="form-check-input row-checkbox"></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="rounded me-3 d-flex align-items-center justify-content-center bg-light"
                                                     style="width: 48px; height: 48px; opacity: 0.6;">
                                                    <i class="fas fa-warehouse text-muted"></i>
                                                </div>
                                                <span class="fw-semibold text-muted"><?php echo e($warehouse->name); ?></span>
                                            </div>
                                        </td>
                                        <td><code class="small"><?php echo e($warehouse->code); ?></code></td>
                                        <td>
                                            <span class="text-muted small">
                                                <?php echo e($warehouse->deleted_at->format('M d, Y')); ?>

                                                <br><small><?php echo e($warehouse->deleted_at->diffForHumans()); ?></small>
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <div class="btn-group">
                                                <form action="<?php echo e(route('admin.warehouses.restore', $warehouse->id)); ?>" method="POST" class="d-inline">
                                                    <?php echo csrf_field(); ?>
                                                    <button type="submit" class="btn btn-sm btn-success" title="Restore"><i class="fas fa-undo"></i></button>
                                                </form>
                                                <button type="button" class="btn btn-sm btn-outline-danger"
                                                        onclick="confirmForceDelete(<?php echo e($warehouse->id); ?>, '<?php echo e($warehouse->name); ?>')" title="Delete Permanently">
                                                    <i class="fas fa-trash-alt"></i>
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
                        Showing <?php echo e($warehouses->firstItem() ?? 0); ?> to <?php echo e($warehouses->lastItem() ?? 0); ?> of <?php echo e($warehouses->total()); ?> entries
                    </div>
                    <div><?php echo e($warehouses->links()); ?></div>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="fas fa-trash-alt fa-3x text-muted mb-3"></i>
                    <h5>No trashed warehouses</h5>
                    <p class="text-muted">
                        <?php if(request()->has('search')): ?>
                            No trashed warehouses match your search. <a href="<?php echo e(route('admin.warehouses.trashed')); ?>">Clear search</a>
                        <?php else: ?>
                            Deleted warehouses will appear here
                        <?php endif; ?>
                    </p>
                    <a href="<?php echo e(route('admin.warehouses.index')); ?>" class="btn btn-primary">
                        <i class="fas fa-warehouse me-1"></i> View Active Warehouses
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

<div class="modal fade" id="forceDeleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Permanently Delete Warehouse</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger"><i class="fas fa-exclamation-triangle me-2"></i><strong>Warning:</strong> This action cannot be undone!</div>
                <p>Are you sure you want to permanently delete <strong id="forceDeleteName"></strong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="forceDeleteForm" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt me-1"></i> Delete Permanently</button>
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
        if (checked > 0) { $('#bulkActions').removeClass('d-none'); $('#selectedCount').text(checked); }
        else { $('#bulkActions').addClass('d-none'); }
    }
});

function confirmForceDelete(id, name) {
    $('#forceDeleteName').text(name);
    $('#forceDeleteForm').attr('action', `/admin/warehouses/${id}/force-delete`);
    new bootstrap.Modal(document.getElementById('forceDeleteModal')).show();
}

function bulkRestore() {
    if (confirm('Are you sure you want to restore selected warehouses?')) { $('#bulkForm').submit(); }
}
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\admin\warehouses\trashed.blade.php ENDPATH**/ ?>