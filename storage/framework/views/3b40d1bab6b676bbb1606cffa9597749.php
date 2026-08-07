<?php if (isset($component)) { $__componentOriginaledc75c655a063d12a477f2c8d8f324fc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc = $attributes; } ?>
<?php $component = App\View\Components\Layouts\AdminLayout::resolve(['title' => 'Profit & Loss Statement'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div><h4 class="fw-bold mb-1">Profit & Loss Statement</h4><p class="text-muted small mb-0">Revenue, expenses and net profit</p></div>
        <a href="<?php echo e(route('admin.finance.reports.index')); ?>" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i> Back to Reports</a>
    </div>

    <form method="GET" class="row g-2 mb-4">
        <div class="col-md-4"><input type="date" name="date_from" class="form-control" value="<?php echo e($filters['date_from'] ?? now()->startOfMonth()->format('Y-m-d')); ?>"></div>
        <div class="col-md-4"><input type="date" name="date_to" class="form-control" value="<?php echo e($filters['date_to'] ?? now()->endOfMonth()->format('Y-m-d')); ?>"></div>
        <div class="col-md-2"><button type="submit" class="btn btn-primary w-100"><i class="fas fa-filter me-1"></i> Filter</button></div>
        <div class="col-md-2"><a href="<?php echo e(route('admin.finance.reports.profit-loss')); ?>" class="btn btn-outline-secondary w-100">Reset</a></div>
    </form>

    <div class="row g-3 mb-4">
        <div class="col-md-4"><div class="card bg-success-subtle border-0"><div class="card-body text-center py-3"><h5 class="fw-bold mb-0 text-success"><?php echo e(number_format($report['total_revenue'], 2)); ?></h5><small class="text-muted">Total Revenue</small></div></div></div>
        <div class="col-md-4"><div class="card bg-danger-subtle border-0"><div class="card-body text-center py-3"><h5 class="fw-bold mb-0 text-danger"><?php echo e(number_format($report['total_expenses'], 2)); ?></h5><small class="text-muted">Total Expenses</small></div></div></div>
        <div class="col-md-4"><div class="card <?php echo e($report['net_profit'] >= 0 ? 'bg-primary-subtle' : 'bg-warning-subtle'); ?> border-0"><div class="card-body text-center py-3"><h5 class="fw-bold mb-0 <?php echo e($report['net_profit'] >= 0 ? 'text-primary' : 'text-warning'); ?>"><?php echo e(number_format($report['net_profit'], 2)); ?></h5><small class="text-muted">Net Profit (Margin: <?php echo e($report['profit_margin']); ?>%)</small></div></div></div>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card"><div class="card-header bg-transparent"><h6 class="fw-bold mb-0">Revenue</h6></div><div class="card-body text-center py-4"><h3 class="fw-bold text-success"><?php echo e(number_format($report['total_revenue'], 2)); ?></h3><p class="text-muted small mb-0">Gross Revenue</p></div></div>
        </div>
        <div class="col-lg-6">
            <div class="card"><div class="card-header bg-transparent"><h6 class="fw-bold mb-0">Expenses Breakdown</h6></div><div class="card-body p-0">
                <div class="table-responsive"><table class="table mb-0"><thead class="table-light"><tr><th>Category</th><th class="text-end">Amount</th></tr></thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $report['expense_breakdown']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $exp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr><td><?php echo e($exp['category']); ?></td><td class="text-end fw-semibold text-danger"><?php echo e(number_format($exp['amount'], 2)); ?></td></tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="2" class="text-center text-muted py-3">No expenses</td></tr>
                        <?php endif; ?>
                    </tbody>
                    <tfoot><tr class="table-active"><td class="fw-bold">Total Expenses</td><td class="text-end fw-bold text-danger"><?php echo e(number_format($report['total_expenses'], 2)); ?></td></tr></tfoot>
                </table></div>
            </div></div>
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
<?php /**PATH C:\laragon\www\ecommerce\resources\views\admin\finance\reports\profit-loss.blade.php ENDPATH**/ ?>