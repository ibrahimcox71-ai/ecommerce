<?php if (isset($component)) { $__componentOriginaledc75c655a063d12a477f2c8d8f324fc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc = $attributes; } ?>
<?php $component = App\View\Components\Layouts\AdminLayout::resolve(['title' => 'Expenses'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div><h4 class="fw-bold mb-1">Expenses</h4><p class="text-muted small mb-0">Manage business expenses</p></div>
        <a href="<?php echo e(route('admin.finance.expenses.create')); ?>" class="btn btn-primary"><i class="fas fa-plus me-1"></i> New Expense</a>
    </div>

    <div class="row g-2 mb-4">
        <div class="col-3"><div class="card bg-success-subtle border-0"><div class="card-body text-center py-2"><h5 class="fw-bold mb-0 text-success"><?php echo e(number_format($stats['total_approved'], 2)); ?></h5><small class="text-muted">Approved</small></div></div></div>
        <div class="col-3"><div class="card bg-warning-subtle border-0"><div class="card-body text-center py-2"><h5 class="fw-bold mb-0 text-warning"><?php echo e(number_format($stats['total_pending'], 2)); ?></h5><small class="text-muted">Pending</small></div></div></div>
        <div class="col-3"><div class="card bg-primary-subtle border-0"><div class="card-body text-center py-2"><h5 class="fw-bold mb-0 text-primary"><?php echo e($stats['approved_count']); ?></h5><small class="text-muted">Approved Count</small></div></div></div>
        <div class="col-3"><div class="card bg-warning-subtle border-0"><div class="card-body text-center py-2"><h5 class="fw-bold mb-0 text-warning"><?php echo e($stats['pending_count']); ?></h5><small class="text-muted">Pending Count</small></div></div></div>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="GET" class="row g-2 mb-3">
                <div class="col-md-3"><input type="text" name="search" class="form-control" placeholder="Search..." value="<?php echo e($filters['search'] ?? ''); ?>"></div>
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="approved" <?php echo e(($filters['status'] ?? '') === 'approved' ? 'selected' : ''); ?>>Approved</option>
                        <option value="pending" <?php echo e(($filters['status'] ?? '') === 'pending' ? 'selected' : ''); ?>>Pending</option>
                        <option value="cancelled" <?php echo e(($filters['status'] ?? '') === 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="category_id" class="form-select">
                        <option value="">All Categories</option>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($cat->id); ?>" <?php echo e(($filters['category_id'] ?? '') == $cat->id ? 'selected' : ''); ?>><?php echo e($cat->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-2"><input type="date" name="date_from" class="form-control" value="<?php echo e($filters['date_from'] ?? ''); ?>"></div>
                <div class="col-md-2"><input type="date" name="date_to" class="form-control" value="<?php echo e($filters['date_to'] ?? ''); ?>"></div>
                <div class="col-md-1"><button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i></button></div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr><th>#</th><th>Category</th><th class="text-end">Amount</th><th>Payee</th><th>Date</th><th>Status</th><th class="text-center">Actions</th></tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $expenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expense): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><a href="<?php echo e(route('admin.finance.expenses.show', $expense->id)); ?>" class="fw-semibold text-decoration-none"><?php echo e($expense->expense_number); ?></a></td>
                                <td><?php echo e($expense->category?->name ?? '—'); ?></td>
                                <td class="text-end fw-semibold"><?php echo e(number_format($expense->total_amount, 2)); ?></td>
                                <td><small><?php echo e($expense->payee ?: '—'); ?></small></td>
                                <td><small><?php echo e($expense->expense_date?->format('d/m/Y')); ?></small></td>
                                <td>
                                    <span class="badge bg-<?php echo e($expense->status === 'approved' ? 'success' : ($expense->status === 'pending' ? 'warning' : 'secondary')); ?>">
                                        <?php echo e(ucfirst($expense->status)); ?>

                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item" href="<?php echo e(route('admin.finance.expenses.show', $expense->id)); ?>"><i class="fas fa-eye me-2"></i>View</a></li>
                                            <?php if($expense->isEditable()): ?>
                                                <li><a class="dropdown-item" href="<?php echo e(route('admin.finance.expenses.edit', $expense->id)); ?>"><i class="fas fa-edit me-2"></i>Edit</a></li>
                                            <?php endif; ?>
                                            <?php if($expense->isApprovable()): ?>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <form method="POST" action="<?php echo e(route('admin.finance.expenses.approve', $expense->id)); ?>" class="d-inline">
                                                        <?php echo csrf_field(); ?>
                                                        <button type="submit" class="dropdown-item text-success"><i class="fas fa-check-circle me-2"></i>Approve</button>
                                                    </form>
                                                </li>
                                            <?php endif; ?>
                                            <?php if($expense->isEditable() && $expense->status !== 'cancelled'): ?>
                                                <li>
                                                    <form method="POST" action="<?php echo e(route('admin.finance.expenses.cancel', $expense->id)); ?>" class="d-inline">
                                                        <?php echo csrf_field(); ?>
                                                        <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Cancel this expense?')"><i class="fas fa-ban me-2"></i>Cancel</button>
                                                    </form>
                                                </li>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="7" class="text-center py-5 text-muted"><i class="fas fa-receipt fa-3x mb-3 d-block"></i>No expenses found</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-3">
                <small class="text-muted">Showing <?php echo e($expenses->firstItem() ?? 0); ?> to <?php echo e($expenses->lastItem() ?? 0); ?> of <?php echo e($expenses->total()); ?></small>
                <a href="<?php echo e(route('admin.finance.expenses.export.csv', request()->query())); ?>" class="btn btn-sm btn-outline-success"><i class="fas fa-file-csv me-1"></i> CSV</a>
            </div>
            <div class="d-flex justify-content-center mt-3"><?php echo e($expenses->withQueryString()->links()); ?></div>
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
<?php /**PATH C:\laragon\www\ecommerce\resources\views\admin\finance\expenses\index.blade.php ENDPATH**/ ?>