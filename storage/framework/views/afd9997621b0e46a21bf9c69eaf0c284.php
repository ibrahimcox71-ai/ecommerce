<?php if (isset($component)) { $__componentOriginaledc75c655a063d12a477f2c8d8f324fc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc = $attributes; } ?>
<?php $component = App\View\Components\Layouts\AdminLayout::resolve(['title' => 'Budget vs Actual Report'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div><h4 class="fw-bold mb-1">Budget vs Actual Report</h4></div>
        <div>
            <select id="budgetSelect" class="form-select form-select-sm d-inline-block w-auto" onchange="window.location.href='?budget_id='+this.value">
                <option value="">Select Budget</option>
                <?php $__currentLoopData = $budgets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($b->id); ?>" <?php if(($data['budget'] ?? null)?->id == $b->id): echo 'selected'; endif; ?>><?php echo e($b->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
    </div>

    <?php if($data['budget'] ?? null): ?>
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card bg-primary-subtle border-0">
                    <div class="card-body text-center py-3">
                        <h5 class="fw-bold text-primary mb-1"><?php echo e(number_format($data['total_budgeted'], 2)); ?></h5>
                        <small class="text-muted">Budgeted</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning-subtle border-0">
                    <div class="card-body text-center py-3">
                        <h5 class="fw-bold text-warning mb-1"><?php echo e(number_format($data['total_spent'], 2)); ?></h5>
                        <small class="text-muted">Actual Spent</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-<?php echo e($data['variance'] >= 0 ? 'success' : 'danger'); ?>-subtle border-0">
                    <div class="card-body text-center py-3">
                        <h5 class="fw-bold text-<?php echo e($data['variance'] >= 0 ? 'success' : 'danger'); ?> mb-1"><?php echo e(number_format(abs($data['variance']), 2)); ?></h5>
                        <small class="text-muted"><?php echo e($data['variance'] >= 0 ? 'Under Budget' : 'Over Budget'); ?></small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info-subtle border-0">
                    <div class="card-body text-center py-3">
                        <h5 class="fw-bold text-info mb-1"><?php echo e(number_format($data['utilization_percentage'], 1)); ?>%</h5>
                        <small class="text-muted">Utilization</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Category</th>
                                <th class="text-end">Budgeted</th>
                                <th class="text-end">Actual</th>
                                <th class="text-end">Variance</th>
                                <th class="text-end">Utilization</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $data['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($item['name']); ?></td>
                                    <td class="text-end"><?php echo e(number_format($item['budgeted'], 2)); ?></td>
                                    <td class="text-end"><?php echo e(number_format($item['actual'], 2)); ?></td>
                                    <td class="text-end text-<?php echo e($item['variance'] >= 0 ? 'success' : 'danger'); ?>"><?php echo e(number_format($item['variance'], 2)); ?></td>
                                    <td class="text-end"><?php echo e(number_format($item['utilization'], 1)); ?>%</td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="text-center py-5">
            <i class="bi bi-pie-chart" style="font-size: 3rem; color: var(--bs-gray-400);"></i>
            <p class="text-muted mt-3">Select a budget to view the report.</p>
        </div>
    <?php endif; ?>
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
<?php /**PATH C:\laragon\www\ecommerce\resources\views\admin\finance\budgets\report.blade.php ENDPATH**/ ?>