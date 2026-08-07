<?php if (isset($component)) { $__componentOriginaledc75c655a063d12a477f2c8d8f324fc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc = $attributes; } ?>
<?php $component = App\View\Components\Layouts\AdminLayout::resolve(['title' => 'Customers'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Customers</h4>
            <p class="text-muted small mb-0">Manage your customer base</p>
        </div>
        <div class="d-flex gap-2">
            <a href="<?php echo e(route('admin.customers.reports.index')); ?>" class="btn btn-outline-info">
                <i class="fas fa-chart-bar me-1"></i> Reports
            </a>
            <a href="<?php echo e(route('admin.customers.groups.index')); ?>" class="btn btn-outline-secondary">
                <i class="fas fa-layer-group me-1"></i> Groups
            </a>
            <a href="<?php echo e(route('admin.customers.trashed')); ?>" class="btn btn-outline-secondary">
                <i class="fas fa-trash-alt me-1"></i> Trashed
                <?php if(($stats['trashed'] ?? 0) > 0): ?>
                    <span class="badge bg-danger ms-1"><?php echo e($stats['trashed']); ?></span>
                <?php endif; ?>
            </a>
            <a href="<?php echo e(route('admin.customers.create')); ?>" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Add Customer
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
                    <h5 class="mb-0 text-warning fw-bold"><?php echo e($stats['suspended'] ?? 0); ?></h5>
                    <small class="text-muted">Suspended</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-2">
            <div class="card bg-info-subtle border-0">
                <div class="card-body text-center py-3">
                    <h5 class="mb-0 text-info fw-bold"><?php echo e($stats['individual'] ?? 0); ?></h5>
                    <small class="text-muted">Individual</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-2">
            <div class="card bg-primary-subtle border-0">
                <div class="card-body text-center py-3">
                    <h5 class="mb-0 text-primary fw-bold"><?php echo e($stats['business'] ?? 0); ?></h5>
                    <small class="text-muted">Business</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-2">
            <div class="card bg-secondary-subtle border-0">
                <div class="card-body text-center py-3">
                    <h5 class="mb-0 text-secondary fw-bold"><?php echo e($stats['with_orders'] ?? 0); ?></h5>
                    <small class="text-muted">With Orders</small>
                </div>
            </div>
        </div>
    </div>

    
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="<?php echo e(route('admin.customers.index')); ?>" class="row g-3">
                <div class="col-md-2">
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
                        <input type="text" name="search" class="form-control"
                               placeholder="Name, email, phone..."
                               value="<?php echo e(request('search')); ?>">
                    </div>
                </div>
                <div class="col-md-1.5">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="active" <?php echo e(request('status') === 'active' ? 'selected' : ''); ?>>Active</option>
                        <option value="suspended" <?php echo e(request('status') === 'suspended' ? 'selected' : ''); ?>>Suspended</option>
                    </select>
                </div>
                <div class="col-md-1.5">
                    <select name="customer_type" class="form-select">
                        <option value="">All Types</option>
                        <option value="individual" <?php echo e(request('customer_type') === 'individual' ? 'selected' : ''); ?>>Individual</option>
                        <option value="business" <?php echo e(request('customer_type') === 'business' ? 'selected' : ''); ?>>Business</option>
                    </select>
                </div>
                <div class="col-md-1.5">
                    <select name="customer_group_id" class="form-select">
                        <option value="">All Groups</option>
                        <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($group->id); ?>" <?php echo e(request('customer_group_id') == $group->id ? 'selected' : ''); ?>>
                                <?php echo e($group->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-1.5">
                    <input type="text" name="city" class="form-control" placeholder="City"
                           value="<?php echo e(request('city')); ?>">
                </div>
                <div class="col-md-1.5">
                    <input type="date" name="date_from" class="form-control" value="<?php echo e(request('date_from')); ?>"
                           placeholder="From">
                </div>
                <div class="col-md-1">
                    <input type="date" name="date_to" class="form-control" value="<?php echo e(request('date_to')); ?>"
                           placeholder="To">
                </div>
                <div class="col-md-1">
                    <select name="per_page" class="form-select">
                        <option value="15" <?php echo e(request('per_page') == 15 ? 'selected' : ''); ?>>15</option>
                        <option value="25" <?php echo e(request('per_page') == 25 ? 'selected' : ''); ?>>25</option>
                        <option value="50" <?php echo e(request('per_page') == 50 ? 'selected' : ''); ?>>50</option>
                        <option value="100" <?php echo e(request('per_page') == 100 ? 'selected' : ''); ?>>100</option>
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
                <button type="button" class="btn btn-sm btn-danger" onclick="bulkDelete()">
                    <i class="fas fa-trash me-1"></i> Delete Selected
                </button>
            </div>
        </div>
    </div>

    
    <div class="card">
        <div class="card-body p-0">
            <?php if($customers->count() > 0): ?>
                <form id="bulkForm" method="POST" action="<?php echo e(route('admin.customers.bulk-delete')); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 ps-4" style="width: 40px;">
                                        <input type="checkbox" class="form-check-input" id="selectAll">
                                    </th>
                                    <th class="border-0" style="width: 50px;">Photo</th>
                                    <th class="border-0">Customer</th>
                                    <th class="border-0 d-none d-lg-table-cell">Email / Phone</th>
                                    <th class="border-0 text-center d-none d-xl-table-cell">Orders</th>
                                    <th class="border-0 text-center d-none d-xl-table-cell">Total Spend</th>
                                    <th class="border-0 text-center d-none d-lg-table-cell">Points</th>
                                    <th class="border-0 text-center">Status</th>
                                    <th class="border-0 text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="ps-4">
                                            <input type="checkbox" name="ids[]" value="<?php echo e($customer->id); ?>"
                                                   class="form-check-input row-checkbox">
                                        </td>
                                        <td>
                                            <?php if($customer->avatar): ?>
                                                <img src="<?php echo e($customer->avatar_url); ?>" alt="<?php echo e($customer->name); ?>"
                                                     class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;" loading="lazy">
                                            <?php else: ?>
                                                <div class="rounded-circle d-flex align-items-center justify-content-center bg-light"
                                                     style="width: 40px; height: 40px;">
                                                    <i class="fas fa-user text-muted"></i>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div>
                                                <span class="fw-semibold">
                                                    <a href="<?php echo e(route('admin.customers.show', $customer->id)); ?>" class="text-decoration-none text-dark">
                                                        <?php echo e($customer->name); ?>

                                                    </a>
                                                </span>
                                                <small class="d-block text-muted">
                                                    #<?php echo e($customer->id); ?>

                                                    <?php if($customer->group): ?>
                                                        <span class="badge bg-light text-dark border ms-1"><?php echo e($customer->group->name); ?></span>
                                                    <?php endif; ?>
                                                    <?php if($customer->customer_type?->value === 'business'): ?>
                                                        <span class="badge bg-primary bg-opacity-10 text-primary ms-1">
                                                            <i class="fas fa-building me-1"></i>Business
                                                        </span>
                                                    <?php endif; ?>
                                                </small>
                                            </div>
                                        </td>
                                        <td class="d-none d-lg-table-cell">
                                            <div class="small">
                                                <?php if($customer->email): ?>
                                                    <div><i class="fas fa-envelope text-muted me-1"></i><?php echo e($customer->email); ?></div>
                                                <?php endif; ?>
                                                <?php if($customer->phone): ?>
                                                    <div><i class="fas fa-phone text-muted me-1"></i><?php echo e($customer->phone); ?></div>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td class="text-center d-none d-xl-table-cell">
                                            <span class="badge bg-info bg-opacity-10 text-info">
                                                <?php echo e($customer->total_orders); ?>

                                            </span>
                                        </td>
                                        <td class="text-center d-none d-xl-table-cell">
                                            <span class="fw-semibold"><?php echo e(config('ecommerce.currency.symbol', '$')); ?><?php echo e(number_format($customer->total_spend, 2)); ?></span>
                                        </td>
                                        <td class="text-center d-none d-lg-table-cell">
                                            <?php if($customer->reward_points > 0): ?>
                                                <span class="badge bg-warning bg-opacity-10 text-warning">
                                                    <i class="fas fa-star me-1"></i><?php echo e(number_format($customer->reward_points)); ?>

                                                </span>
                                            <?php else: ?>
                                                <span class="text-muted">0</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <?php echo $customer->status_badge; ?>

                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="btn-group">
                                                <a href="<?php echo e(route('admin.customers.show', $customer->id)); ?>"
                                                   class="btn btn-sm btn-outline-secondary" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="<?php echo e(route('admin.customers.edit', $customer->id)); ?>"
                                                   class="btn btn-sm btn-outline-primary" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <?php if($customer->isSuspended()): ?>
                                                    <button type="button" class="btn btn-sm btn-outline-success"
                                                            onclick="toggleStatus(<?php echo e($customer->id); ?>, 'activate')" title="Activate">
                                                        <i class="fas fa-check-circle"></i>
                                                    </button>
                                                <?php else: ?>
                                                    <button type="button" class="btn btn-sm btn-outline-warning"
                                                            onclick="toggleStatus(<?php echo e($customer->id); ?>, 'suspend')" title="Suspend">
                                                        <i class="fas fa-pause-circle"></i>
                                                    </button>
                                                <?php endif; ?>
                                                <button type="button" class="btn btn-sm btn-outline-danger"
                                                        onclick="confirmDelete(<?php echo e($customer->id); ?>, '<?php echo e(addslashes($customer->name)); ?>')" title="Delete">
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
                        Showing <?php echo e($customers->firstItem()); ?> to <?php echo e($customers->lastItem()); ?> of <?php echo e($customers->total()); ?> entries
                    </div>
                    <div>
                        <?php echo e($customers->appends(request()->query())->links()); ?>

                    </div>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="fas fa-users fa-3x text-muted mb-3"></i>
                    <h5>No customers found</h5>
                    <p class="text-muted">
                        <?php if(request()->anyFilled(['search', 'status', 'customer_type', 'customer_group_id', 'city'])): ?>
                            No customers match your filters. <a href="<?php echo e(route('admin.customers.index')); ?>">Clear filters</a>
                        <?php else: ?>
                            Get started by creating your first customer.
                        <?php endif; ?>
                    </p>
                    <a href="<?php echo e(route('admin.customers.create')); ?>" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Add Customer
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
                <h5 class="modal-title">Delete Customer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete <strong id="deleteName"></strong>?</p>
                <p class="text-muted small mb-0">This will soft-delete the customer. You can restore them from the trash.</p>
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
});

function confirmDelete(id, name) {
    $('#deleteName').text(name);
    $('#deleteForm').attr('action', `/admin/customers/${id}`);
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}

function bulkDelete() {
    const ids = $('.row-checkbox:checked').map(function() { return $(this).val(); }).get();
    if (!ids.length) return;
    if (confirm('Are you sure you want to delete ' + ids.length + ' selected customers?')) {
        $('#bulkForm').attr('action', '<?php echo e(route('admin.customers.bulk-delete')); ?>').submit();
    }
}

function toggleStatus(id, action) {
    const msg = action === 'suspend' ? 'suspend' : 'activate';
    if (!confirm(`Are you sure you want to ${msg} this customer?`)) return;

    $.ajax({
        url: `/admin/customers/${id}/toggle-status`,
        type: 'POST',
        data: { _token: '<?php echo e(csrf_token()); ?>' },
        success: function(response) {
            if (response.success) {
                location.reload();
            }
        },
        error: function() {
            alert('Failed to update status');
        }
    });
}
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\admin\customers\index.blade.php ENDPATH**/ ?>