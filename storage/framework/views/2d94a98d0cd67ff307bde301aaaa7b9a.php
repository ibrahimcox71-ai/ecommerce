<?php if (isset($component)) { $__componentOriginaledc75c655a063d12a477f2c8d8f324fc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc = $attributes; } ?>
<?php $component = App\View\Components\Layouts\AdminLayout::resolve(['title' => 'Purchase Return Report'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Purchase Return Report</h4>
            <p class="text-muted small mb-0">Track returned items and refunds</p>
        </div>
        <a href="<?php echo e(route('admin.purchases.reports')); ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to Reports
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="GET" class="row g-2 mb-3">
                <div class="col-md-3">
                    <input type="date" name="date_from" class="form-control" value="<?php echo e(request('date_from')); ?>" placeholder="From">
                </div>
                <div class="col-md-3">
                    <input type="date" name="date_to" class="form-control" value="<?php echo e(request('date_to')); ?>" placeholder="To">
                </div>
                <div class="col-md-3">
                    <select name="refund_status" class="form-select">
                        <option value="">All Refund Status</option>
                        <option value="pending" <?php echo e(request('refund_status') == 'pending' ? 'selected' : ''); ?>>Pending</option>
                        <option value="processed" <?php echo e(request('refund_status') == 'processed' ? 'selected' : ''); ?>>Processed</option>
                        <option value="declined" <?php echo e(request('refund_status') == 'declined' ? 'selected' : ''); ?>>Declined</option>
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
                            <th>PO Number</th>
                            <th>Supplier</th>
                            <th>Product</th>
                            <th class="text-end">Qty</th>
                            <th class="text-end">Amount</th>
                            <th>Reason</th>
                            <th>Refund Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $returns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $return): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><small><?php echo e($return->return_number); ?></small></td>
                                <td><a href="<?php echo e(route('admin.purchases.show', $return->purchase_id)); ?>"><?php echo e($return->purchase?->po_number); ?></a></td>
                                <td><?php echo e($return->purchase?->supplier?->name); ?></td>
                                <td>
                                    <?php echo e($return->product?->name); ?>

                                    <?php if($return->variant): ?><br><small class="text-muted"><?php echo e($return->variant->name); ?></small><?php endif; ?>
                                </td>
                                <td class="text-end"><?php echo e($return->quantity); ?></td>
                                <td class="text-end fw-semibold"><?php echo e(number_format($return->total_amount, 2)); ?></td>
                                <td><small><?php echo e($return->reason ?: '—'); ?></small></td>
                                <td>
                                    <span class="badge bg-<?php echo e($return->refund_status === 'processed' ? 'success' : ($return->refund_status === 'declined' ? 'danger' : 'warning')); ?>">
                                        <?php echo e(ucfirst($return->refund_status)); ?>

                                    </span>
                                </td>
                                <td><small><?php echo e($return->return_date?->format('d/m/Y')); ?></small></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="9" class="text-center py-4 text-muted">No returns found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                    <tfoot>
                        <tr class="fw-bold">
                            <td colspan="4" class="text-end">Totals:</td>
                            <td class="text-end"><?php echo e($returns->sum('quantity')); ?></td>
                            <td class="text-end"><?php echo e(number_format($returns->sum('total_amount'), 2)); ?></td>
                            <td colspan="3"></td>
                        </tr>
                    </tfoot>
                </table>
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
<?php /**PATH C:\laragon\www\ecommerce\resources\views\admin\purchases\reports\return.blade.php ENDPATH**/ ?>