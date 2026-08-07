<?php if (isset($component)) { $__componentOriginaledc75c655a063d12a477f2c8d8f324fc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc = $attributes; } ?>
<?php $component = App\View\Components\Layouts\AdminLayout::resolve(['title' => 'Coupons'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Coupons</h4>
            <p class="text-muted small mb-0">Manage discount coupons</p>
        </div>
        <a href="<?php echo e(route('admin.coupons.create')); ?>" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Add Coupon
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="<?php echo e(route('admin.coupons.index')); ?>" class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Search by code or description..." value="<?php echo e(request('search')); ?>">
                </div>
                <div class="col-md-3">
                    <select name="type" class="form-select">
                        <option value="">All Types</option>
                        <option value="percentage" <?php echo e(request('type') === 'percentage' ? 'selected' : ''); ?>>Percentage</option>
                        <option value="fixed" <?php echo e(request('type') === 'fixed' ? 'selected' : ''); ?>>Fixed</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="active" <?php echo e(request('status') === 'active' ? 'selected' : ''); ?>>Active</option>
                        <option value="inactive" <?php echo e(request('status') === 'inactive' ? 'selected' : ''); ?>>Inactive</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-outline-primary w-100">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <?php if($coupons->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0">Code</th>
                                <th class="border-0">Type</th>
                                <th class="border-0 text-end">Value</th>
                                <th class="border-0 text-end">Min Order</th>
                                <th class="border-0 text-end">Max Discount</th>
                                <th class="border-0 text-center">Usage</th>
                                <th class="border-0">Expiry</th>
                                <th class="border-0 text-center">Status</th>
                                <th class="border-0 text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $coupons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coupon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <span class="fw-semibold font-monospace"><?php echo e($coupon->code); ?></span>
                                        <?php if($coupon->description): ?>
                                            <small class="d-block text-muted text-truncate" style="max-width: 180px;"><?php echo e($coupon->description); ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($coupon->type === 'percentage'): ?>
                                            <span class="badge bg-info">Percentage</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Fixed</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-end fw-semibold">
                                        <?php echo e($coupon->type === 'percentage' ? $coupon->value . '%' : '$' . number_format($coupon->value, 2)); ?>

                                    </td>
                                    <td class="text-end">
                                        <?php echo e($coupon->min_order_amount ? '$' . number_format($coupon->min_order_amount, 2) : '—'); ?>

                                    </td>
                                    <td class="text-end">
                                        <?php echo e($coupon->max_discount ? '$' . number_format($coupon->max_discount, 2) : '—'); ?>

                                    </td>
                                    <td class="text-center">
                                        <?php if($coupon->usage_limit > 0): ?>
                                            <small><?php echo e($coupon->usages_count); ?> / <?php echo e($coupon->usage_limit); ?></small>
                                        <?php else: ?>
                                            <small><?php echo e($coupon->usages_count); ?> / &infin;</small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($coupon->expires_at): ?>
                                            <small class="<?php echo e(now()->gt($coupon->expires_at) ? 'text-danger' : 'text-muted'); ?>">
                                                <?php echo e($coupon->expires_at->format('M d, Y')); ?>

                                            </small>
                                        <?php else: ?>
                                            <span class="text-muted">—</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if($coupon->is_active && !$coupon->expires_at?->isPast()): ?>
                                            <span class="badge bg-success">Active</span>
                                        <?php elseif($coupon->expires_at?->isPast()): ?>
                                            <span class="badge bg-secondary">Expired</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning text-dark">Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-end">
                                        <div class="btn-group">
                                            <a href="<?php echo e(route('admin.coupons.show', $coupon)); ?>" class="btn btn-sm btn-outline-secondary" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?php echo e(route('admin.coupons.edit', $coupon)); ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="POST" action="<?php echo e(route('admin.coupons.toggle-status', $coupon)); ?>" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="btn btn-sm btn-outline-<?php echo e($coupon->is_active ? 'warning' : 'success'); ?>" title="<?php echo e($coupon->is_active ? 'Deactivate' : 'Activate'); ?>">
                                                    <i class="fas fa-<?php echo e($coupon->is_active ? 'pause' : 'play'); ?>"></i>
                                                </button>
                                            </form>
                                            <form method="POST" action="<?php echo e(route('admin.coupons.destroy', $coupon)); ?>" class="d-inline" onsubmit="return confirm('Delete coupon <?php echo e($coupon->code); ?>?')">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted small">
                        Showing <?php echo e($coupons->firstItem()); ?> to <?php echo e($coupons->lastItem()); ?> of <?php echo e($coupons->total()); ?> entries
                    </div>
                    <div><?php echo e($coupons->links()); ?></div>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="fas fa-ticket-alt fa-4x text-muted mb-3"></i>
                    <h5>No coupons found</h5>
                    <p class="text-muted">
                        <?php if(request()->anyFilled(['search', 'type', 'status'])): ?>
                            No coupons match your filters. <a href="<?php echo e(route('admin.coupons.index')); ?>">Clear filters</a>
                        <?php else: ?>
                            Get started by creating your first coupon.
                        <?php endif; ?>
                    </p>
                    <a href="<?php echo e(route('admin.coupons.create')); ?>" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Add Coupon
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
<?php /**PATH C:\laragon\www\ecommerce\resources\views\admin\coupons\index.blade.php ENDPATH**/ ?>