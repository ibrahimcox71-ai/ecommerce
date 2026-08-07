<?php if (isset($component)) { $__componentOriginaledc75c655a063d12a477f2c8d8f324fc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc = $attributes; } ?>
<?php $component = App\View\Components\Layouts\AdminLayout::resolve(['title' => 'Budgets'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div><h4 class="fw-bold mb-1">Budgets</h4><p class="text-muted small mb-0">Track and manage budgets</p></div>
        <div class="d-flex gap-2">
            <a href="<?php echo e(route('admin.finance.budgets.report')); ?>" class="btn btn-outline-info"><i class="fas fa-chart-bar me-1"></i> Report</a>
            <a href="<?php echo e(route('admin.finance.budgets.create')); ?>" class="btn btn-primary"><i class="fas fa-plus me-1"></i> Create Budget</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="GET" class="row g-2 mb-3">
                <div class="col-md-4">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="active" <?php echo e(($filters['status'] ?? '') === 'active' ? 'selected' : ''); ?>>Active</option>
                        <option value="completed" <?php echo e(($filters['status'] ?? '') === 'completed' ? 'selected' : ''); ?>>Completed</option>
                        <option value="cancelled" <?php echo e(($filters['status'] ?? '') === 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="period" class="form-select">
                        <option value="">All Periods</option>
                        <?php $__currentLoopData = ['monthly','quarterly','semi_annually','annually','custom']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($p); ?>" <?php echo e(($filters['period'] ?? '') === $p ? 'selected' : ''); ?>><?php echo e(ucfirst(str_replace('_', ' ', $p))); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-1"><button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i></button></div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr><th>Name</th><th>Period</th><th>Duration</th><th class="text-end">Budget</th><th class="text-end">Spent</th><th class="text-end">Remaining</th><th>Progress</th><th>Status</th><th class="text-center">Actions</th></tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $budgets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $budget): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php $pct = $budget->total_budget > 0 ? round($budget->total_spent / $budget->total_budget * 100, 1) : 0; ?>
                            <tr>
                                <td><a href="<?php echo e(route('admin.finance.budgets.show', $budget->id)); ?>" class="fw-semibold text-decoration-none"><?php echo e($budget->name); ?></a></td>
                                <td><span class="badge bg-info"><?php echo e(ucfirst(str_replace('_', ' ', $budget->period))); ?></span></td>
                                <td><small><?php echo e($budget->start_date?->format('d/m/Y')); ?> - <?php echo e($budget->end_date?->format('d/m/Y')); ?></small></td>
                                <td class="text-end fw-semibold"><?php echo e(number_format($budget->total_budget, 2)); ?></td>
                                <td class="text-end fw-semibold text-danger"><?php echo e(number_format($budget->total_spent, 2)); ?></td>
                                <td class="text-end fw-semibold <?php echo e($budget->total_remaining < 0 ? 'text-danger' : 'text-success'); ?>"><?php echo e(number_format($budget->total_remaining, 2)); ?></td>
                                <td style="min-width:120px">
                                    <div class="progress" style="height:8px">
                                        <div class="progress-bar <?php echo e($pct > 100 ? 'bg-danger' : ($pct > 80 ? 'bg-warning' : 'bg-success')); ?>" style="width:<?php echo e(min($pct, 100)); ?>%"></div>
                                    </div>
                                    <small class="text-muted"><?php echo e($pct); ?>%</small>
                                </td>
                                <td>
                                    <span class="badge bg-<?php echo e($budget->status === 'active' ? 'success' : ($budget->status === 'completed' ? 'primary' : 'secondary')); ?>">
                                        <?php echo e(ucfirst($budget->status)); ?>

                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item" href="<?php echo e(route('admin.finance.budgets.show', $budget->id)); ?>"><i class="fas fa-eye me-2"></i>View</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form method="POST" action="<?php echo e(route('admin.finance.budgets.destroy', $budget->id)); ?>" class="d-inline">
                                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Delete this budget?')"><i class="fas fa-trash me-2"></i>Delete</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="9" class="text-center py-5 text-muted"><i class="fas fa-calculator fa-3x mb-3 d-block"></i>No budgets found</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-3"><?php echo e($budgets->withQueryString()->links()); ?></div>
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
<?php /**PATH C:\laragon\www\ecommerce\resources\views\admin\finance\budgets\index.blade.php ENDPATH**/ ?>