<?php if (isset($component)) { $__componentOriginaledc75c655a063d12a477f2c8d8f324fc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc = $attributes; } ?>
<?php $component = App\View\Components\Layouts\AdminLayout::resolve(['title' => 'Tax Summary'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div><h4 class="fw-bold mb-1">Tax Summary Report</h4><p class="text-muted small mb-0">Tax collected by rate and period</p></div>
        <a href="<?php echo e(route('admin.finance.reports.index')); ?>" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i> Back</a>
    </div>

    <form method="GET" class="row g-2 mb-4">
        <div class="col-md-4"><input type="date" name="date_from" class="form-control" value="<?php echo e($filters['date_from'] ?? ''); ?>"></div>
        <div class="col-md-4"><input type="date" name="date_to" class="form-control" value="<?php echo e($filters['date_to'] ?? ''); ?>"></div>
        <div class="col-md-2"><button type="submit" class="btn btn-primary w-100"><i class="fas fa-filter me-1"></i> Filter</button></div>
        <div class="col-md-2"><a href="<?php echo e(route('admin.finance.reports.tax-summary')); ?>" class="btn btn-outline-secondary w-100">Reset</a></div>
    </form>

    <div class="card"><div class="card-header bg-transparent"><h6 class="fw-bold mb-0">Tax Collected</h6></div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light"><tr><th>Tax Rate</th><th class="text-end">Rate (%)</th><th class="text-end">Total Collected</th><th class="text-end">Transactions</th></tr></thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $report['taxes']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr><td class="fw-semibold"><?php echo e($tax['rate_name']); ?></td><td class="text-end"><?php echo e($tax['rate']); ?>%</td><td class="text-end fw-semibold text-primary"><?php echo e(number_format($tax['total_amount'], 2)); ?></td><td class="text-end"><?php echo e($tax['transaction_count']); ?></td></tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="4" class="text-center py-4 text-muted">No tax collected</td></tr>
                    <?php endif; ?>
                </tbody>
                <tfoot><tr class="table-active"><td colspan="2" class="fw-bold">Grand Total</td><td class="text-end fw-bold"><?php echo e(number_format($report['grand_total'], 2)); ?></td><td></td></tr></tfoot>
            </table>
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
<?php /**PATH C:\laragon\www\ecommerce\resources\views\admin\finance\reports\tax-summary.blade.php ENDPATH**/ ?>