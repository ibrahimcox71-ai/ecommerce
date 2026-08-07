<?php if (isset($component)) { $__componentOriginaledc75c655a063d12a477f2c8d8f324fc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc = $attributes; } ?>
<?php $component = App\View\Components\Layouts\AdminLayout::resolve(['title' => 'Balance Sheet'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div><h4 class="fw-bold mb-1">Balance Sheet</h4><p class="text-muted small mb-0">As of <?php echo e(\Carbon\Carbon::parse($asOfDate)->format('F d, Y')); ?></p></div>
        <div><a href="<?php echo e(route('admin.finance.reports.index')); ?>" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i> Back</a></div>
    </div>

    <form method="GET" class="row g-2 mb-4">
        <div class="col-md-4"><input type="date" name="as_of_date" class="form-control" value="<?php echo e($asOfDate); ?>"></div>
        <div class="col-md-2"><button type="submit" class="btn btn-primary w-100"><i class="fas fa-filter me-1"></i> View</button></div>
    </form>

    <?php
        $totalAssets = $assets->sum('balance');
        $totalLiabilities = $liabilities->sum('balance');
        $totalEquity = $equity->sum('balance');
    ?>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header bg-success-subtle"><h6 class="fw-bold mb-0 text-success">Assets</h6></div>
                <div class="card-body p-0">
                    <table class="table mb-0"><thead class="table-light"><tr><th>Account</th><th class="text-end">Balance</th></tr></thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $assets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr><td><small><?php echo e($a['name']); ?></small></td><td class="text-end fw-semibold"><?php echo e(number_format($a['balance'], 2)); ?></td></tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="2" class="text-center text-muted py-3">No asset accounts</td></tr>
                            <?php endif; ?>
                        </tbody>
                        <tfoot><tr class="table-active"><td class="fw-bold">Total Assets</td><td class="text-end fw-bold text-success"><?php echo e(number_format($totalAssets, 2)); ?></td></tr></tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header bg-danger-subtle"><h6 class="fw-bold mb-0 text-danger">Liabilities</h6></div>
                <div class="card-body p-0">
                    <table class="table mb-0"><thead class="table-light"><tr><th>Account</th><th class="text-end">Balance</th></tr></thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $liabilities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr><td><small><?php echo e($l['name']); ?></small></td><td class="text-end fw-semibold"><?php echo e(number_format($l['balance'], 2)); ?></td></tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="2" class="text-center text-muted py-3">No liability accounts</td></tr>
                            <?php endif; ?>
                        </tbody>
                        <tfoot><tr class="table-active"><td class="fw-bold">Total Liabilities</td><td class="text-end fw-bold text-danger"><?php echo e(number_format($totalLiabilities, 2)); ?></td></tr></tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header bg-primary-subtle"><h6 class="fw-bold mb-0 text-primary">Equity</h6></div>
                <div class="card-body p-0">
                    <table class="table mb-0"><thead class="table-light"><tr><th>Account</th><th class="text-end">Balance</th></tr></thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $equity; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr><td><small><?php echo e($e['name']); ?></small></td><td class="text-end fw-semibold"><?php echo e(number_format($e['balance'], 2)); ?></td></tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="2" class="text-center text-muted py-3">No equity accounts</td></tr>
                            <?php endif; ?>
                        </tbody>
                        <tfoot><tr class="table-active"><td class="fw-bold">Total Equity</td><td class="text-end fw-bold text-primary"><?php echo e(number_format($totalEquity, 2)); ?></td></tr></tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card bg-light">
                <div class="card-body text-center py-3">
                    <div class="row">
                        <div class="col-4"><h6 class="text-muted">Total Assets</h6><h4 class="fw-bold text-success"><?php echo e(number_format($totalAssets, 2)); ?></h4></div>
                        <div class="col-4"><h6 class="text-muted">Total Liabilities + Equity</h6><h4 class="fw-bold text-primary"><?php echo e(number_format($totalLiabilities + $totalEquity, 2)); ?></h4></div>
                        <div class="col-4">
                            <h6 class="text-muted">Difference</h6>
                            <h4 class="fw-bold <?php echo e(abs($totalAssets - ($totalLiabilities + $totalEquity)) < 0.01 ? 'text-success' : 'text-danger'); ?>">
                                <?php echo e(number_format($totalAssets - ($totalLiabilities + $totalEquity), 2)); ?>

                                <?php if(abs($totalAssets - ($totalLiabilities + $totalEquity)) < 0.01): ?>
                                    <i class="fas fa-check-circle ms-1"></i>
                                <?php endif; ?>
                            </h4>
                        </div>
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
<?php /**PATH C:\laragon\www\ecommerce\resources\views\admin\finance\reports\balance-sheet.blade.php ENDPATH**/ ?>