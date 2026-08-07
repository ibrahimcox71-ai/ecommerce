<?php if (isset($component)) { $__componentOriginaledc75c655a063d12a477f2c8d8f324fc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc = $attributes; } ?>
<?php $component = App\View\Components\Layouts\AdminLayout::resolve(['title' => 'Trashed Brands'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Trashed Brands</h4>
            <p class="text-muted small mb-0">Deleted brands can be restored or permanently removed</p>
        </div>
        <a href="<?php echo e(route('admin.brands.index')); ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to Brands
        </a>
    </div>

    
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="<?php echo e(route('admin.brands.trashed')); ?>" class="row g-3">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
                        <input type="text" name="search" class="form-control"
                               placeholder="Search trashed brands..."
                               value="<?php echo e(request('search')); ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <select name="per_page" class="form-select">
                        <option value="15" <?php echo e(request('per_page') == 15 ? 'selected' : ''); ?>>15 per page</option>
                        <option value="25" <?php echo e(request('per_page') == 25 ? 'selected' : ''); ?>>25 per page</option>
                        <option value="50" <?php echo e(request('per_page') == 50 ? 'selected' : ''); ?>>50 per page</option>
                        <option value="100" <?php echo e(request('per_page') == 100 ? 'selected' : ''); ?>>100 per page</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-outline-primary w-100">
                        <i class="fas fa-search me-1"></i> Search
                    </button>
                </div>
            </form>
        </div>
    </div>

    
    <div class="d-none" id="bulkActions">
        <div class="alert alert-info d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
            <span><i class="fas fa-check-circle me-2"></i><strong id="selectedCount">0</strong> selected</span>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-sm btn-success" onclick="bulkRestore()">
                    <i class="fas fa-undo me-1"></i> Restore Selected
                </button>
                <button type="button" class="btn btn-sm btn-danger" onclick="bulkForceDelete()">
                    <i class="fas fa-trash-alt me-1"></i> Delete Permanently
                </button>
            </div>
        </div>
    </div>

    
    <div class="card">
        <div class="card-body p-0">
            <?php if($brands->count() > 0): ?>
                <form id="bulkForm" method="POST" action="<?php echo e(route('admin.brands.bulk-restore')); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 ps-4" style="width: 40px;">
                                        <input type="checkbox" class="form-check-input" id="selectAll">
                                    </th>
                                    <th class="border-0">Brand</th>
                                    <th class="border-0 d-none d-md-table-cell">Code</th>
                                    <th class="border-0">Deleted At</th>
                                    <th class="border-0 text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr data-id="<?php echo e($brand->id); ?>">
                                        <td class="ps-4">
                                            <input type="checkbox" name="ids[]" value="<?php echo e($brand->id); ?>"
                                                   class="form-check-input row-checkbox">
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <?php if($brand->image): ?>
                                                    <img src="<?php echo e($brand->image_url); ?>" alt="<?php echo e($brand->name); ?>"
                                                         class="rounded me-3" style="width: 44px; height: 44px; object-fit: cover; opacity: 0.6;" loading="lazy">
                                                <?php else: ?>
                                                    <div class="rounded me-3 d-flex align-items-center justify-content-center bg-light"
                                                         style="width: 44px; height: 44px; opacity: 0.6;">
                                                        <i class="fas fa-building text-muted"></i>
                                                    </div>
                                                <?php endif; ?>
                                                <div>
                                                    <span class="fw-semibold text-muted"><?php echo e($brand->name); ?></span>
                                                    <small class="d-block text-muted">
                                                        <code class="small"><?php echo e($brand->slug); ?></code>
                                                    </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="d-none d-md-table-cell">
                                            <?php if($brand->brand_code): ?>
                                                <span class="badge bg-light text-dark border opacity-60"><?php echo e($brand->brand_code); ?></span>
                                            <?php else: ?>
                                                <span class="text-muted">—</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="small">
                                                <div><?php echo e($brand->deleted_at->format('M d, Y')); ?></div>
                                                <small class="text-muted"><?php echo e($brand->deleted_at->diffForHumans()); ?></small>
                                            </div>
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="btn-group">
                                                <form action="<?php echo e(route('admin.brands.restore', $brand->id)); ?>" method="POST" class="d-inline">
                                                    <?php echo csrf_field(); ?>
                                                    <button type="submit" class="btn btn-sm btn-success" title="Restore">
                                                        <i class="fas fa-undo"></i>
                                                    </button>
                                                </form>
                                                <button type="button" class="btn btn-sm btn-outline-danger"
                                                        onclick="confirmForceDelete(<?php echo e($brand->id); ?>, '<?php echo e(addslashes($brand->name)); ?>')" title="Delete Permanently">
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

                <div class="d-flex justify-content-between align-items-center px-4 py-3 border-top">
                    <div class="text-muted small">
                        Showing <?php echo e($brands->firstItem() ?? 0); ?> to <?php echo e($brands->lastItem() ?? 0); ?> of <?php echo e($brands->total()); ?> entries
                    </div>
                    <div>
                        <?php echo e($brands->appends(request()->query())->links()); ?>

                    </div>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="fas fa-trash-alt fa-3x text-muted mb-3"></i>
                    <h5>No trashed brands</h5>
                    <p class="text-muted">
                        <?php if(request()->has('search')): ?>
                            No trashed brands match your search. <a href="<?php echo e(route('admin.brands.trashed')); ?>">Clear search</a>
                        <?php else: ?>
                            Deleted brands will appear here
                        <?php endif; ?>
                    </p>
                    <a href="<?php echo e(route('admin.brands.index')); ?>" class="btn btn-primary">
                        <i class="fas fa-building me-1"></i> View Active Brands
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
                <h5 class="modal-title">Permanently Delete Brand</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Warning:</strong> This action cannot be undone!
                </div>
                <p>Are you sure you want to permanently delete <strong id="forceDeleteName"></strong>?</p>
                <p class="text-muted small mb-0">This will permanently remove the brand and all its data from the database.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="forceDeleteForm" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash-alt me-1"></i> Delete Permanently
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

    $('.row-checkbox').change(function() {
        updateBulkActions();
    });

    function updateBulkActions() {
        const checked = $('.row-checkbox:checked').length;
        if (checked > 0) {
            $('#bulkActions').removeClass('d-none');
            $('#selectedCount').text(checked);
        } else {
            $('#bulkActions').addClass('d-none');
        }
    }
});

function confirmForceDelete(id, name) {
    $('#forceDeleteName').text(name);
    $('#forceDeleteForm').attr('action', `/admin/brands/${id}/force-delete`);
    new bootstrap.Modal(document.getElementById('forceDeleteModal')).show();
}

function bulkRestore() {
    if (confirm('Are you sure you want to restore selected brands?')) {
        $('#bulkForm').attr('action', '<?php echo e(route('admin.brands.bulk-restore')); ?>').submit();
    }
}

function bulkForceDelete() {
    if (confirm('Are you sure you want to permanently delete selected brands? This cannot be undone!')) {
        $('#bulkForm').attr('action', '<?php echo e(route('admin.brands.bulk-force-delete')); ?>')
            .attr('method', 'POST')
            .find('input[name="_method"]').remove();
        $('<input>').attr({ type: 'hidden', name: '_method', value: 'DELETE' }).appendTo('#bulkForm');
        $('<input>').attr({ type: 'hidden', name: '_token', value: '<?php echo e(csrf_token()); ?>' }).appendTo('#bulkForm');
        $('#bulkForm').submit();
    }
}
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\admin\brands\trashed.blade.php ENDPATH**/ ?>