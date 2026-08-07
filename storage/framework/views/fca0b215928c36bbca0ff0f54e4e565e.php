<?php if (isset($component)) { $__componentOriginaledc75c655a063d12a477f2c8d8f324fc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc = $attributes; } ?>
<?php $component = App\View\Components\Layouts\AdminLayout::resolve(['title' => 'Brands'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Brands</h4>
            <p class="text-muted small mb-0">Manage your product brands</p>
        </div>
        <div class="d-flex gap-2">
            <a href="<?php echo e(route('admin.brands.trashed')); ?>" class="btn btn-outline-secondary">
                <i class="fas fa-trash-alt me-1"></i> Trashed
                <?php if(($stats['trashed'] ?? 0) > 0): ?>
                    <span class="badge bg-danger ms-1"><?php echo e($stats['trashed']); ?></span>
                <?php endif; ?>
            </a>
            <a href="<?php echo e(route('admin.brands.create')); ?>" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Add Brand
            </a>
        </div>
    </div>

    
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-2">
            <div class="card bg-primary-subtle border-0">
                <div class="card-body text-center py-3">
                    <h5 class="mb-0 text-primary fw-bold"><?php echo e($stats['total'] ?? 0); ?></h5>
                    <small class="text-muted">Total</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-2">
            <div class="card bg-success-subtle border-0">
                <div class="card-body text-center py-3">
                    <h5 class="mb-0 text-success fw-bold"><?php echo e($stats['active'] ?? 0); ?></h5>
                    <small class="text-muted">Active</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-2">
            <div class="card bg-secondary-subtle border-0">
                <div class="card-body text-center py-3">
                    <h5 class="mb-0 text-secondary fw-bold"><?php echo e($stats['inactive'] ?? 0); ?></h5>
                    <small class="text-muted">Inactive</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-2">
            <div class="card bg-dark-subtle border-0">
                <div class="card-body text-center py-3">
                    <h5 class="mb-0 text-dark fw-bold"><?php echo e($stats['hidden'] ?? 0); ?></h5>
                    <small class="text-muted">Hidden</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-2">
            <div class="card bg-warning-subtle border-0">
                <div class="card-body text-center py-3">
                    <h5 class="mb-0 text-warning fw-bold"><?php echo e($stats['featured'] ?? 0); ?></h5>
                    <small class="text-muted">Featured</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-2">
            <div class="card bg-info-subtle border-0">
                <div class="card-body text-center py-3">
                    <h5 class="mb-0 text-info fw-bold"><?php echo e($stats['popular'] ?? 0); ?></h5>
                    <small class="text-muted">Popular</small>
                </div>
            </div>
        </div>
    </div>

    
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="<?php echo e(route('admin.brands.index')); ?>" class="row g-3">
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
                        <input type="text" name="search" class="form-control"
                               placeholder="Search by name, code, country..."
                               value="<?php echo e(request('search')); ?>">
                    </div>
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="active" <?php echo e(request('status') === 'active' ? 'selected' : ''); ?>>Active</option>
                        <option value="inactive" <?php echo e(request('status') === 'inactive' ? 'selected' : ''); ?>>Inactive</option>
                        <option value="hidden" <?php echo e(request('status') === 'hidden' ? 'selected' : ''); ?>>Hidden</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="featured" class="form-select">
                        <option value="">All Types</option>
                        <option value="1" <?php echo e(request('featured') === '1' ? 'selected' : ''); ?>>Featured</option>
                        <option value="0" <?php echo e(request('featured') === '0' ? 'selected' : ''); ?>>Not Featured</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="country" class="form-select">
                        <option value="">All Countries</option>
                        <?php
                            $countries = App\Models\Brand::whereNotNull('country')->distinct()->pluck('country');
                        ?>
                        <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($c); ?>" <?php echo e(request('country') === $c ? 'selected' : ''); ?>><?php echo e($c); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="per_page" class="form-select">
                        <option value="15" <?php echo e(request('per_page') == 15 ? 'selected' : ''); ?>>15 per page</option>
                        <option value="25" <?php echo e(request('per_page') == 25 ? 'selected' : ''); ?>>25 per page</option>
                        <option value="50" <?php echo e(request('per_page') == 50 ? 'selected' : ''); ?>>50 per page</option>
                        <option value="100" <?php echo e(request('per_page') == 100 ? 'selected' : ''); ?>>100 per page</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-outline-primary w-100">
                        <i class="fas fa-filter"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    
    <div class="d-none" id="bulkActions">
        <div class="alert alert-info d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
            <span><i class="fas fa-check-circle me-2"></i><strong id="selectedCount">0</strong> selected</span>
            <div class="d-flex gap-2">
                <select class="form-select form-select-sm" id="bulkStatusSelect" style="width: 140px;">
                    <option value="">Change Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                    <option value="hidden">Hidden</option>
                </select>
                <button type="button" class="btn btn-sm btn-warning" onclick="bulkUpdateStatus()">
                    <i class="fas fa-check-circle me-1"></i> Apply
                </button>
                <button type="button" class="btn btn-sm btn-danger" onclick="bulkDelete()">
                    <i class="fas fa-trash me-1"></i> Delete
                </button>
            </div>
        </div>
    </div>

    
    <div class="card">
        <div class="card-body p-0">
            <?php if($brands->count() > 0): ?>
                <form id="bulkForm" method="POST" action="<?php echo e(route('admin.brands.bulk-delete')); ?>">
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
                                    <th class="border-0 d-none d-lg-table-cell">Country</th>
                                    <th class="border-0 text-center">Products</th>
                                    <th class="border-0 text-center d-none d-xl-table-cell">Sort</th>
                                    <th class="border-0 text-center">Status</th>
                                    <th class="border-0 text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="ps-4">
                                            <input type="checkbox" name="ids[]" value="<?php echo e($brand->id); ?>"
                                                   class="form-check-input row-checkbox">
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <?php if($brand->logo): ?>
                                                    <img src="<?php echo e($brand->logo_url); ?>" alt="<?php echo e($brand->name); ?>"
                                                         class="rounded me-3" style="width: 44px; height: 44px; object-fit: cover;" loading="lazy">
                                                <?php elseif($brand->image): ?>
                                                    <img src="<?php echo e($brand->image_url); ?>" alt="<?php echo e($brand->name); ?>"
                                                         class="rounded me-3" style="width: 44px; height: 44px; object-fit: cover;" loading="lazy">
                                                <?php else: ?>
                                                    <div class="rounded me-3 d-flex align-items-center justify-content-center bg-light"
                                                         style="width: 44px; height: 44px;">
                                                        <i class="fas fa-building text-muted"></i>
                                                    </div>
                                                <?php endif; ?>
                                                <div>
                                                    <span class="fw-semibold">
                                                        <a href="<?php echo e(route('admin.brands.show', $brand->id)); ?>" class="text-decoration-none text-dark">
                                                            <?php echo e($brand->name); ?>

                                                        </a>
                                                    </span>
                                                    <small class="d-block text-muted">
                                                        <code class="small"><?php echo e($brand->slug); ?></code>
                                                    </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="d-none d-md-table-cell">
                                            <?php if($brand->brand_code): ?>
                                                <span class="badge bg-light text-dark border"><?php echo e($brand->brand_code); ?></span>
                                            <?php else: ?>
                                                <span class="text-muted">—</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="d-none d-lg-table-cell">
                                            <?php if($brand->country): ?>
                                                <span class="small"><?php echo e($brand->country); ?></span>
                                            <?php else: ?>
                                                <span class="text-muted">—</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-primary bg-opacity-10 text-primary">
                                                <?php echo e($brand->products_count); ?>

                                            </span>
                                        </td>
                                        <td class="text-center d-none d-xl-table-cell">
                                            <input type="number" class="form-control form-control-sm text-center sort-input"
                                                   value="<?php echo e($brand->sort_order); ?>" style="width: 65px;"
                                                   data-id="<?php echo e($brand->id); ?>" min="0">
                                        </td>
                                        <td class="text-center">
                                            <?php
                                                $statusColors = ['active' => 'success', 'inactive' => 'secondary', 'hidden' => 'dark'];
                                                $statusIcons = ['active' => 'fa-check-circle', 'inactive' => 'fa-pause-circle', 'hidden' => 'fa-eye-slash'];
                                                $color = $statusColors[$brand->status->value] ?? 'secondary';
                                                $icon = $statusIcons[$brand->status->value] ?? 'fa-circle';
                                            ?>
                                            <span class="badge bg-<?php echo e($color); ?> bg-opacity-10 text-<?php echo e($color); ?>">
                                                <i class="fas <?php echo e($icon); ?> me-1"></i><?php echo e($brand->status->label()); ?>

                                            </span>
                                            <?php if($brand->featured): ?>
                                                <span class="badge bg-warning bg-opacity-10 text-warning ms-1">
                                                    <i class="fas fa-star me-1"></i>
                                                </span>
                                            <?php endif; ?>
                                            <?php if($brand->popular): ?>
                                                <span class="badge bg-info bg-opacity-10 text-info ms-1">
                                                    <i class="fas fa-fire me-1"></i>
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="btn-group">
                                                <a href="<?php echo e(route('admin.brands.show', $brand->id)); ?>"
                                                   class="btn btn-sm btn-outline-secondary" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="<?php echo e(route('admin.brands.edit', $brand->id)); ?>"
                                                   class="btn btn-sm btn-outline-primary" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-outline-info"
                                                        onclick="duplicateBrand(<?php echo e($brand->id); ?>)" title="Duplicate">
                                                    <i class="fas fa-copy"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-danger"
                                                        onclick="confirmDelete(<?php echo e($brand->id); ?>, '<?php echo e(addslashes($brand->name)); ?>')" title="Delete">
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

                <div class="d-flex justify-content-between align-items-center px-4 py-3 border-top">
                    <div class="text-muted small">
                        Showing <?php echo e($brands->firstItem()); ?> to <?php echo e($brands->lastItem()); ?> of <?php echo e($brands->total()); ?> entries
                    </div>
                    <div>
                        <?php echo e($brands->appends(request()->query())->links()); ?>

                    </div>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="fas fa-building fa-3x text-muted mb-3"></i>
                    <h5>No brands found</h5>
                    <p class="text-muted">
                        <?php if(request()->anyFilled(['search', 'status', 'featured', 'country'])): ?>
                            No brands match your filters. <a href="<?php echo e(route('admin.brands.index')); ?>">Clear filters</a>
                        <?php else: ?>
                            Get started by creating your first brand.
                        <?php endif; ?>
                    </p>
                    <a href="<?php echo e(route('admin.brands.create')); ?>" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Add Brand
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
                <h5 class="modal-title">Delete Brand</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete <strong id="deleteName"></strong>?</p>
                <div id="deleteWarning" class="alert alert-warning d-none">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <span id="deleteWarningText"></span>
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

    $('.sort-input').change(function() {
        const id = $(this).data('id');
        const sortOrder = $(this).val();

        $.ajax({
            url: '<?php echo e(route('admin.brands.update-sort')); ?>',
            type: 'POST',
            data: {
                _token: '<?php echo e(csrf_token()); ?>',
                items: [{ id: id, sort_order: sortOrder }]
            },
            success: function(response) {
                if (response.success) {
                    showToast(response.message, 'success');
                }
            },
            error: function() {
                showToast('Failed to update sort order', 'error');
            }
        });
    });
});

function confirmDelete(id, name) {
    $('#deleteName').text(name);
    $('#deleteForm').attr('action', `/admin/brands/${id}`);
    $('#deleteWarning').addClass('d-none');
    $('#deleteForm button[type="submit"]').prop('disabled', false);

    $.get(`/admin/brands/${id}/check-deletable`, function(data) {
        if (!data.deletable) {
            $('#deleteWarningText').text(`Cannot delete: has ${data.product_count} product(s). Remove them first.`);
            $('#deleteWarning').removeClass('d-none');
            $('#deleteForm button[type="submit"]').prop('disabled', true);
        }
    });

    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}

function bulkDelete() {
    const ids = $('.row-checkbox:checked').map(function() { return $(this).val(); }).get();
    if (!ids.length) return;

    if (confirm('Are you sure you want to delete ' + ids.length + ' selected brands?')) {
        $('#bulkForm').attr('action', '<?php echo e(route('admin.brands.bulk-delete')); ?>').submit();
    }
}

function bulkUpdateStatus() {
    const ids = $('.row-checkbox:checked').map(function() { return $(this).val(); }).get();
    const status = $('#bulkStatusSelect').val();
    if (!ids.length || !status) return;

    if (confirm('Change status of ' + ids.length + ' brands to "' + status + '"?')) {
        $('<form>').attr({ method: 'POST', action: '<?php echo e(route('admin.brands.bulk-update-status')); ?>' })
            .append($('<input>').attr({ type: 'hidden', name: '_token', value: '<?php echo e(csrf_token()); ?>' }))
            .append($('<input>').attr({ type: 'hidden', name: 'status', value: status }))
            .append(ids.map(function(id) {
                return $('<input>').attr({ type: 'hidden', name: 'ids[]', value: id });
            }))
            .appendTo('body').submit();
    }
}

function duplicateBrand(id) {
    $('<form>').attr({ method: 'POST', action: `/admin/brands/${id}/duplicate` })
        .append($('<input>').attr({ type: 'hidden', name: '_token', value: '<?php echo e(csrf_token()); ?>' }))
        .appendTo('body').submit();
}

function showToast(message, type = 'info') {
    const bgClass = type === 'success' ? 'bg-success' : type === 'error' ? 'bg-danger' : 'bg-info';
    $('body').append(`
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999;">
            <div class="toast ${bgClass} text-white" role="alert">
                <div class="toast-body d-flex align-items-center">
                    <i class="fas fa-${type === 'success' ? 'check' : type === 'error' ? 'times' : 'info'} me-2"></i>
                    ${message}
                </div>
            </div>
        </div>
    `);
    const toast = new bootstrap.Toast($('.toast').last()[0], { delay: 3000 });
    toast.show();
    setTimeout(() => $('.toast').parent().remove(), 3500);
}
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\admin\brands\index.blade.php ENDPATH**/ ?>