<?php if (isset($component)) { $__componentOriginaledc75c655a063d12a477f2c8d8f324fc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc = $attributes; } ?>
<?php $component = App\View\Components\Layouts\AdminLayout::resolve(['title' => 'Login History'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Login History</h4>
            <p class="text-muted small mb-0"><?php echo e($customer->name); ?></p>
        </div>
        <a href="<?php echo e(route('admin.customers.show', $customer->id)); ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to Customer
        </a>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <?php if($loginHistories->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0 ps-4">Date & Time</th>
                                <th class="border-0">IP Address</th>
                                <th class="border-0 d-none d-md-table-cell">Browser</th>
                                <th class="border-0 d-none d-md-table-cell">Platform</th>
                                <th class="border-0 d-none d-md-table-cell">Device</th>
                                <th class="border-0">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $loginHistories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $history): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="ps-4">
                                        <span class="small"><?php echo e($history->login_at->format('M d, Y H:i:s')); ?></span>
                                        <small class="d-block text-muted"><?php echo e($history->login_at->diffForHumans()); ?></small>
                                    </td>
                                    <td><code><?php echo e($history->ip_address); ?></code></td>
                                    <td class="d-none d-md-table-cell"><?php echo e($history->browser ?? 'Unknown'); ?></td>
                                    <td class="d-none d-md-table-cell"><?php echo e($history->platform ?? 'Unknown'); ?></td>
                                    <td class="d-none d-md-table-cell"><?php echo e($history->device_type); ?></td>
                                    <td>
                                        <?php if($history->is_successful): ?>
                                            <span class="badge bg-success bg-opacity-10 text-success">Success</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger bg-opacity-10 text-danger">
                                                <?php echo e($history->failure_reason ?? 'Failed'); ?>

                                            </span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center px-4 py-3 border-top">
                    <div class="text-muted small">
                        Showing <?php echo e($loginHistories->firstItem()); ?> to <?php echo e($loginHistories->lastItem()); ?> of <?php echo e($loginHistories->total()); ?> entries
                    </div>
                    <div>
                        <?php echo e($loginHistories->links()); ?>

                    </div>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="fas fa-history fa-3x text-muted mb-3"></i>
                    <h5>No login history</h5>
                    <p class="text-muted">This customer has no recorded login activity.</p>
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
<?php /**PATH C:\laragon\www\ecommerce\resources\views\admin\customers\login-history.blade.php ENDPATH**/ ?>