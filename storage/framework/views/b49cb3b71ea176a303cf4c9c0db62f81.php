<?php if (isset($component)) { $__componentOriginaledc75c655a063d12a477f2c8d8f324fc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc = $attributes; } ?>
<?php $component = App\View\Components\Layouts\AdminLayout::resolve(['title' => 'Categories'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Categories</h4>
            <p class="text-muted small mb-0">Manage your product categories</p>
        </div>
        <div class="d-flex gap-2">
            <a href="<?php echo e(route('admin.categories.tree')); ?>" class="btn btn-outline-secondary">
                <i class="fas fa-sitemap me-1"></i> Tree View
            </a>
            <a href="<?php echo e(route('admin.categories.trashed')); ?>" class="btn btn-outline-secondary">
                <i class="fas fa-trash-alt me-1"></i> Trashed
                <?php if(($stats['trashed'] ?? 0) > 0): ?>
                    <span class="badge bg-danger ms-1"><?php echo e($stats['trashed']); ?></span>
                <?php endif; ?>
            </a>
            <a href="<?php echo e(route('admin.categories.create')); ?>" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Add Category
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
            <div class="card bg-warning-subtle border-0">
                <div class="card-body text-center py-3">
                    <h5 class="mb-0 text-warning fw-bold"><?php echo e($stats['draft'] ?? 0); ?></h5>
                    <small class="text-muted">Draft</small>
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
            <div class="card bg-info-subtle border-0">
                <div class="card-body text-center py-3">
                    <h5 class="mb-0 text-info fw-bold"><?php echo e($stats['parents'] ?? 0); ?></h5>
                    <small class="text-muted">Parents</small>
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
    </div>

    
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="<?php echo e(route('admin.categories.index')); ?>" class="row g-3">
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
                        <input type="text" name="search" class="form-control"
                               placeholder="Search categories..."
                               value="<?php echo e(request('search')); ?>">
                    </div>
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="active" <?php echo e(request('status') === 'active' ? 'selected' : ''); ?>>Active</option>
                        <option value="inactive" <?php echo e(request('status') === 'inactive' ? 'selected' : ''); ?>>Inactive</option>
                        <option value="draft" <?php echo e(request('status') === 'draft' ? 'selected' : ''); ?>>Draft</option>
                        <option value="hidden" <?php echo e(request('status') === 'hidden' ? 'selected' : ''); ?>>Hidden</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="parent" class="form-select">
                        <option value="">All Levels</option>
                        <option value="0" <?php echo e(request('parent') === '0' ? 'selected' : ''); ?>>Top Level</option>
                        <?php $__currentLoopData = $parentCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($parent->id); ?>" <?php echo e(request('parent') == $parent->id ? 'selected' : ''); ?>>
                                <?php echo e($parent->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                    <option value="draft">Draft</option>
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
            <?php if($categories->count() > 0): ?>
                <form id="bulkForm" method="POST" action="<?php echo e(route('admin.categories.bulk-delete')); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 ps-4" style="width: 40px;">
                                        <input type="checkbox" class="form-check-input" id="selectAll">
                                    </th>
                                    <th class="border-0">Category</th>
                                    <th class="border-0 d-none d-md-table-cell">Code</th>
                                    <th class="border-0 d-none d-lg-table-cell">Parent</th>
                                    <th class="border-0 text-center">Products</th>
                                    <th class="border-0 text-center d-none d-xl-table-cell">Sort</th>
                                    <th class="border-0 text-center">Status</th>
                                    <th class="border-0 text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="ps-4">
                                            <input type="checkbox" name="ids[]" value="<?php echo e($category->id); ?>"
                                                   class="form-check-input row-checkbox">
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <?php if($category->thumbnail): ?>
                                                    <img src="<?php echo e($category->thumbnail_url); ?>" alt="<?php echo e($category->name); ?>"
                                                         class="rounded me-3" style="width: 44px; height: 44px; object-fit: cover;" loading="lazy">
                                                <?php elseif($category->image): ?>
                                                    <img src="<?php echo e($category->image_url); ?>" alt="<?php echo e($category->name); ?>"
                                                         class="rounded me-3" style="width: 44px; height: 44px; object-fit: cover;" loading="lazy">
                                                <?php else: ?>
                                                    <div class="rounded me-3 d-flex align-items-center justify-content-center bg-light"
                                                         style="width: 44px; height: 44px;">
                                                        <i class="fas fa-folder text-muted"></i>
                                                    </div>
                                                <?php endif; ?>
                                                <div>
                                                    <span class="fw-semibold">
                                                        <a href="<?php echo e(route('admin.categories.show', $category->id)); ?>" class="text-decoration-none text-dark">
                                                            <?php echo e($category->name); ?>

                                                        </a>
                                                    </span>
                                                    <small class="d-block text-muted">
                                                        <code class="small"><?php echo e($category->slug); ?></code>
                                                        <?php if($category->children_count > 0): ?>
                                                            <span class="ms-2"><i class="fas fa-level-down-alt me-1"></i><?php echo e($category->children_count); ?> children</span>
                                                        <?php endif; ?>
                                                    </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="d-none d-md-table-cell">
                                            <?php if($category->category_code): ?>
                                                <span class="badge bg-light text-dark border"><?php echo e($category->category_code); ?></span>
                                            <?php else: ?>
                                                <span class="text-muted">—</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="d-none d-lg-table-cell">
                                            <?php if($category->parent): ?>
                                                <a href="<?php echo e(route('admin.categories.show', $category->parent->id)); ?>" class="text-decoration-none">
                                                    <?php echo e($category->parent->name); ?>

                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted">—</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-primary bg-opacity-10 text-primary">
                                                <?php echo e($category->products_count); ?>

                                            </span>
                                        </td>
                                        <td class="text-center d-none d-xl-table-cell">
                                            <input type="number" class="form-control form-control-sm text-center sort-input"
                                                   value="<?php echo e($category->sort_order); ?>" style="width: 65px;"
                                                   data-id="<?php echo e($category->id); ?>" min="0">
                                        </td>
                                        <td class="text-center">
                                            <?php if (isset($component)) { $__componentOriginal0b3c95dd01f7182f54004b521151849d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b3c95dd01f7182f54004b521151849d = $attributes; } ?>
<?php $component = App\View\Components\Admin\Category\StatusBadge::resolve(['status' => $category->status] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.category.status-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Admin\Category\StatusBadge::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0b3c95dd01f7182f54004b521151849d)): ?>
<?php $attributes = $__attributesOriginal0b3c95dd01f7182f54004b521151849d; ?>
<?php unset($__attributesOriginal0b3c95dd01f7182f54004b521151849d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0b3c95dd01f7182f54004b521151849d)): ?>
<?php $component = $__componentOriginal0b3c95dd01f7182f54004b521151849d; ?>
<?php unset($__componentOriginal0b3c95dd01f7182f54004b521151849d); ?>
<?php endif; ?>
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="btn-group">
                                                <a href="<?php echo e(route('admin.categories.show', $category->id)); ?>"
                                                   class="btn btn-sm btn-outline-secondary" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="<?php echo e(route('admin.categories.edit', $category->id)); ?>"
                                                   class="btn btn-sm btn-outline-primary" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-outline-info"
                                                        onclick="duplicateCategory(<?php echo e($category->id); ?>)" title="Duplicate">
                                                    <i class="fas fa-copy"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-danger"
                                                        onclick="confirmDelete(<?php echo e($category->id); ?>, '<?php echo e(addslashes($category->name)); ?>')" title="Delete">
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
                        Showing <?php echo e($categories->firstItem()); ?> to <?php echo e($categories->lastItem()); ?> of <?php echo e($categories->total()); ?> entries
                    </div>
                    <div>
                        <?php echo e($categories->appends(request()->query())->links()); ?>

                    </div>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                    <h5>No categories found</h5>
                    <p class="text-muted">
                        <?php if(request()->anyFilled(['search', 'status', 'parent', 'featured'])): ?>
                            No categories match your filters. <a href="<?php echo e(route('admin.categories.index')); ?>">Clear filters</a>
                        <?php else: ?>
                            Get started by creating your first category.
                        <?php endif; ?>
                    </p>
                    <a href="<?php echo e(route('admin.categories.create')); ?>" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Add Category
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
                <h5 class="modal-title">Delete Category</h5>
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
            url: '<?php echo e(route('admin.categories.update-sort')); ?>',
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
    $('#deleteForm').attr('action', `/admin/categories/${id}`);
    $('#deleteWarning').addClass('d-none');

    $.get(`/admin/categories/${id}/check-deletable`, function(data) {
        if (!data.deletable) {
            let warnings = [];
            if (data.has_children) warnings.push(`${data.children_count} subcategory(ies)`);
            if (data.has_products) warnings.push(`${data.product_count} product(s)`);
            $('#deleteWarningText').text('Cannot delete: has ' + warnings.join(' and ') + '. Remove them first.');
            $('#deleteWarning').removeClass('d-none');
            $('#deleteForm button[type="submit"]').prop('disabled', true);
        } else {
            $('#deleteForm button[type="submit"]').prop('disabled', false);
        }
    });

    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}

function bulkDelete() {
    const ids = $('.row-checkbox:checked').map(function() { return $(this).val(); }).get();
    if (!ids.length) return;

    if (confirm('Are you sure you want to delete ' + ids.length + ' selected categories?')) {
        $('#bulkForm').attr('action', '<?php echo e(route('admin.categories.bulk-delete')); ?>').submit();
    }
}

function bulkUpdateStatus() {
    const ids = $('.row-checkbox:checked').map(function() { return $(this).val(); }).get();
    const status = $('#bulkStatusSelect').val();
    if (!ids.length || !status) return;

    if (confirm('Change status of ' + ids.length + ' categories to "' + status + '"?')) {
        $('<form>').attr({ method: 'POST', action: '<?php echo e(route('admin.categories.bulk-update-status')); ?>' })
            .append($('<input>').attr({ type: 'hidden', name: '_token', value: '<?php echo e(csrf_token()); ?>' }))
            .append($('<input>').attr({ type: 'hidden', name: 'status', value: status }))
            .append(ids.map(function(id) {
                return $('<input>').attr({ type: 'hidden', name: 'ids[]', value: id });
            }))
            .appendTo('body').submit();
    }
}

function duplicateCategory(id) {
    $('<form>').attr({ method: 'POST', action: `/admin/categories/${id}/duplicate` })
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
<?php /**PATH C:\laragon\www\ecommerce\resources\views\admin\categories\index.blade.php ENDPATH**/ ?>