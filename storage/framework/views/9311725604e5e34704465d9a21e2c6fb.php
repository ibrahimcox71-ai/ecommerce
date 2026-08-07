<?php if (isset($component)) { $__componentOriginaledc75c655a063d12a477f2c8d8f324fc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc = $attributes; } ?>
<?php $component = App\View\Components\Layouts\AdminLayout::resolve(['title' => 'Trial Balance'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div><h4 class="fw-bold mb-1">Trial Balance</h4><p class="text-muted small mb-0">All account balances with debits and credits</p></div>
        <a href="<?php echo e(route('admin.finance.reports.index')); ?>" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i> Back</a>
    </div>

    <form method="GET" class="row g-2 mb-4">
        <div class="col-md-4"><input type="date" name="date_from" class="form-control" value="<?php echo e($filters['date_from'] ?? ''); ?>"></div>
        <div class="col-md-4"><input type="date" name="date_to" class="form-control" value="<?php echo e($filters['date_to'] ?? ''); ?>"></div>
        <div class="col-md-2"><button type="submit" class="btn btn-primary w-100"><i class="fas fa-filter me-1"></i> Filter</button></div>
        <div class="col-md-2"><a href="<?php echo e(route('admin.finance.reports.trial-balance')); ?>" class="btn btn-outline-secondary w-100">Reset</a></div>
    </form>

    <div class="card"><div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr><th>Code</th><th>Account</th><th>Type</th><th class="text-end">Opening</th><th class="text-end">Movement</th><th class="text-end">Closing</th></tr>
                </thead>
                <tbody>
                    <?php
                        $totalOpening = 0; $totalClosing = 0;
                    ?>
                    <?php $__empty_1 = true; $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $acc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            $totalOpening += $acc['opening_balance'];
                            $totalClosing += $acc['closing_balance'];
                        ?>
                        <tr>
                            <td><?php echo e($acc['code']); ?></td>
                            <td class="fw-semibold"><?php echo e($acc['name']); ?></td>
                            <td><span class="badge bg-info"><?php echo e(ucfirst(str_replace('_', ' ', $acc['type']))); ?></span></td>
                            <td class="text-end"><?php echo e(number_format($acc['opening_balance'], 2)); ?></td>
                            <td class="text-end <?php echo e($acc['movement'] >= 0 ? 'text-success' : 'text-danger'); ?>"><?php echo e(number_format($acc['movement'], 2)); ?></td>
                            <td class="text-end fw-semibold"><?php echo e(number_format($acc['closing_balance'], 2)); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="6" class="text-center py-4 text-muted">No accounts found</td></tr>
                    <?php endif; ?>
                </tbody>
                <tfoot>
                    <tr class="table-active fw-bold">
                        <td colspan="3" class="text-end">Totals:</td>
                        <td class="text-end"><?php echo e(number_format($totalOpening, 2)); ?></td>
                        <td></td>
                        <td class="text-end"><?php echo e(number_format($totalClosing, 2)); ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div></div>
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
<?php /**PATH C:\laragon\www\ecommerce\resources\views\admin\finance\reports\trial-balance.blade.php ENDPATH**/ ?>