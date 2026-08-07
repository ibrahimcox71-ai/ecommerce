<?php if (isset($component)) { $__componentOriginaledc75c655a063d12a477f2c8d8f324fc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc = $attributes; } ?>
<?php $component = App\View\Components\Layouts\AdminLayout::resolve(['title' => 'Budget Details'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1"><?php echo e($budget->name); ?></h4>
            <p class="text-muted small mb-0">
                <span class="badge bg-info"><?php echo e(ucfirst(str_replace('_', ' ', $budget->period))); ?></span>
                <span class="badge bg-<?php echo e($budget->status === 'active' ? 'success' : ($budget->status === 'completed' ? 'primary' : 'secondary')); ?> ms-1"><?php echo e(ucfirst($budget->status)); ?></span>
            </p>
        </div>
        <a href="<?php echo e(route('admin.finance.budgets.index')); ?>" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i> Back</a>
    </div>

    <?php $overallPct = $budget->total_budget > 0 ? round($budget->total_spent / $budget->total_budget * 100, 1) : 0; ?>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card bg-light"><div class="card-body text-center py-2"><small class="text-muted">Period</small><h5 class="mb-0"><?php echo e($budget->start_date?->format('M d')); ?> - <?php echo e($budget->end_date?->format('M d, Y')); ?></h5></div></div>
        </div>
        <div class="col-md-3">
            <div class="card bg-primary-subtle"><div class="card-body text-center py-2"><small class="text-muted">Budget</small><h5 class="mb-0 text-primary"><?php echo e(number_format($budget->total_budget, 2)); ?></h5></div></div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger-subtle"><div class="card-body text-center py-2"><small class="text-muted">Spent</small><h5 class="mb-0 text-danger"><?php echo e(number_format($budget->total_spent, 2)); ?></h5></div></div>
        </div>
        <div class="col-md-3">
            <div class="card <?php echo e($budget->total_remaining >= 0 ? 'bg-success-subtle' : 'bg-danger-subtle'); ?>"><div class="card-body text-center py-2"><small class="text-muted">Remaining</small><h5 class="mb-0 <?php echo e($budget->total_remaining >= 0 ? 'text-success' : 'text-danger'); ?>"><?php echo e(number_format($budget->total_remaining, 2)); ?></h5></div></div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between mb-1"><span class="fw-semibold">Overall Progress</span><span><?php echo e($overallPct); ?>%</span></div>
            <div class="progress" style="height:20px">
                <div class="progress-bar <?php echo e($overallPct > 100 ? 'bg-danger' : ($overallPct > 80 ? 'bg-warning' : 'bg-success')); ?>" style="width:<?php echo e(min($overallPct, 100)); ?>%">
                    <?php echo e($overallPct); ?>%
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-transparent"><h6 class="fw-bold mb-0">Budget Items</h6></div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr><th>Category</th><th class="text-end">Budgeted</th><th class="text-end">Spent</th><th class="text-end">Remaining</th><th>Usage</th><th>Status</th></tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $budget->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $pct = $item->getUsagePercentage(); ?>
                            <tr>
                                <td class="fw-semibold"><?php echo e($item->category_name); ?></td>
                                <td class="text-end"><?php echo e(number_format($item->budgeted_amount, 2)); ?></td>
                                <td class="text-end text-danger"><?php echo e(number_format($item->spent_amount, 2)); ?></td>
                                <td class="text-end fw-bold <?php echo e($item->remaining_amount < 0 ? 'text-danger' : 'text-success'); ?>"><?php echo e(number_format($item->remaining_amount, 2)); ?></td>
                                <td style="min-width:120px">
                                    <div class="progress" style="height:8px">
                                        <div class="progress-bar <?php echo e($pct > 100 ? 'bg-danger' : ($pct > 80 ? 'bg-warning' : 'bg-success')); ?>" style="width:<?php echo e(min($pct, 100)); ?>%"></div>
                                    </div>
                                    <small class="text-muted"><?php echo e($pct); ?>%</small>
                                </td>
                                <td>
                                    <?php if($item->isOverBudget()): ?>
                                        <span class="badge bg-danger">Over Budget</span>
                                    <?php else: ?>
                                        <span class="badge bg-success">On Track</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
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
<?php /**PATH C:\laragon\www\ecommerce\resources\views\admin\finance\budgets\show.blade.php ENDPATH**/ ?>