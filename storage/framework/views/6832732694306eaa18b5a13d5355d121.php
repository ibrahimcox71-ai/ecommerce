<?php if (isset($component)) { $__componentOriginaledc75c655a063d12a477f2c8d8f324fc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc = $attributes; } ?>
<?php $component = App\View\Components\Layouts\AdminLayout::resolve(['title' => 'Order Returns'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Order Returns</h4>
        <p class="text-muted small mb-0">Manage return requests and refunds</p>
    </div>
    <a href="<?php echo e(route('admin.orders.index')); ?>" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Back to Orders
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form method="GET" class="row g-2 mb-3">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Search return # or order #..." value="<?php echo e(request('search')); ?>">
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="pending" <?php if(request('status') === 'pending'): echo 'selected'; endif; ?>>Pending</option>
                    <option value="approved" <?php if(request('status') === 'approved'): echo 'selected'; endif; ?>>Approved</option>
                    <option value="rejected" <?php if(request('status') === 'rejected'): echo 'selected'; endif; ?>>Rejected</option>
                </select>
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i></button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Return #</th>
                        <th>Order #</th>
                        <th>Reason</th>
                        <th>Qty</th>
                        <th class="text-end">Amount</th>
                        <th>Status</th>
                        <th>Refund Status</th>
                        <th>Date</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $returns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $return): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="fw-semibold"><?php echo e($return->return_number); ?></td>
                            <td>
                                <a href="<?php echo e(route('admin.orders.show', $return->order_id)); ?>" class="text-decoration-none">
                                    <?php echo e($return->order->order_number ?? '—'); ?>

                                </a>
                            </td>
                            <td><small><?php echo e($return->reason); ?></small></td>
                            <td class="text-center"><?php echo e($return->quantity); ?></td>
                            <td class="text-end fw-semibold"><?php echo e(config('ecommerce.currency_symbol', '$')); ?><?php echo e(number_format($return->refund_amount, 2)); ?></td>
                            <td><span class="badge <?php echo e($return->statusBadge()); ?>"><?php echo e(ucfirst($return->status)); ?></span></td>
                            <td>
                                <?php if($return->refund_status): ?>
                                    <span class="badge bg-<?php echo e($return->refund_status === 'refunded' ? 'success' : 'warning'); ?>"><?php echo e(ucfirst($return->refund_status)); ?></span>
                                <?php else: ?>
                                    <span class="text-muted">—</span>
                                <?php endif; ?>
                            </td>
                            <td><small class="text-muted"><?php echo e($return->created_at->format('M d, Y')); ?></small></td>
                            <td class="text-center">
                                <a href="<?php echo e(route('admin.orders.returns.show', $return)); ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="9" class="text-center py-4 text-muted">No return requests found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-3">
            <?php echo e($returns->withQueryString()->links()); ?>

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
<?php /**PATH C:\laragon\www\ecommerce\resources\views\admin\orders\returns\index.blade.php ENDPATH**/ ?>