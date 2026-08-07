<?php if (isset($component)) { $__componentOriginaledc75c655a063d12a477f2c8d8f324fc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc = $attributes; } ?>
<?php $component = App\View\Components\Layouts\AdminLayout::resolve(['title' => 'Coupon Detail'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1"><?php echo e($coupon->code); ?></h4>
            <p class="text-muted small mb-0">Coupon details and usage</p>
        </div>
        <div class="d-flex gap-2">
            <a href="<?php echo e(route('admin.coupons.edit', $coupon)); ?>" class="btn btn-primary">
                <i class="fas fa-edit me-1"></i> Edit
            </a>
            <a href="<?php echo e(route('admin.coupons.index')); ?>" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-semibold">Usage History</h6>
                    <span class="badge bg-primary"><?php echo e($coupon->usages->count()); ?> uses</span>
                </div>
                <div class="card-body">
                    <?php if($coupon->usages->isNotEmpty()): ?>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Customer</th>
                                        <th>Order</th>
                                        <th class="text-end">Discount</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $coupon->usages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $usage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($usage->user?->name ?? $usage->order?->user?->name ?? '—'); ?></td>
                                            <td>
                                                <?php if($usage->order): ?>
                                                    <a href="<?php echo e(route('admin.orders.show', $usage->order)); ?>">#<?php echo e($usage->order->order_number); ?></a>
                                                <?php else: ?>
                                                    —
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-end">$<?php echo e(number_format($usage->discount_amount, 2)); ?></td>
                                            <td><small><?php echo e($usage->created_at->format('M d, Y h:i A')); ?></small></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-muted mb-0">No usage yet.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h6 class="mb-0 fw-semibold">Details</h6>
                </div>
                <div class="card-body small">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Code</span>
                        <span class="fw-semibold font-monospace"><?php echo e($coupon->code); ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Type</span>
                        <span><?php echo e($coupon->type === 'percentage' ? 'Percentage' : 'Fixed'); ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Value</span>
                        <span class="fw-semibold"><?php echo e($coupon->type === 'percentage' ? $coupon->value . '%' : '$' . number_format($coupon->value, 2)); ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Min Order</span>
                        <span><?php echo e($coupon->min_order_amount ? '$' . number_format($coupon->min_order_amount, 2) : 'None'); ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Max Discount</span>
                        <span><?php echo e($coupon->max_discount ? '$' . number_format($coupon->max_discount, 2) : 'None'); ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Usage</span>
                        <span><?php echo e($coupon->usages->count()); ?><?php echo e($coupon->usage_limit > 0 ? ' / ' . $coupon->usage_limit : ''); ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Status</span>
                        <span>
                            <?php if($coupon->is_active): ?>
                                <span class="badge bg-success">Active</span>
                            <?php else: ?>
                                <span class="badge bg-warning text-dark">Inactive</span>
                            <?php endif; ?>
                        </span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Starts</span>
                        <span><?php echo e($coupon->starts_at ? $coupon->starts_at->format('M d, Y') : 'Immediately'); ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Expires</span>
                        <span class="<?php echo e($coupon->expires_at?->isPast() ? 'text-danger' : ''); ?>">
                            <?php echo e($coupon->expires_at ? $coupon->expires_at->format('M d, Y') : 'Never'); ?>

                        </span>
                    </div>
                    <?php if($coupon->description): ?>
                        <hr>
                        <p class="mb-0"><?php echo e($coupon->description); ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-white">
                    <h6 class="mb-0 fw-semibold">Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex gap-2">
                        <form method="POST" action="<?php echo e(route('admin.coupons.toggle-status', $coupon)); ?>">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-<?php echo e($coupon->is_active ? 'warning' : 'success'); ?> btn-sm">
                                <i class="fas fa-<?php echo e($coupon->is_active ? 'pause' : 'play'); ?> me-1"></i>
                                <?php echo e($coupon->is_active ? 'Deactivate' : 'Activate'); ?>

                            </button>
                        </form>
                        <form method="POST" action="<?php echo e(route('admin.coupons.destroy', $coupon)); ?>" onsubmit="return confirm('Delete this coupon?')">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash me-1"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
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
<?php /**PATH C:\laragon\www\ecommerce\resources\views\admin\coupons\show.blade.php ENDPATH**/ ?>