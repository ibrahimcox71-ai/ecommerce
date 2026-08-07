<?php if (isset($component)) { $__componentOriginaledc75c655a063d12a477f2c8d8f324fc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc = $attributes; } ?>
<?php $component = App\View\Components\Layouts\AdminLayout::resolve(['title' => 'Transactions'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div><h4 class="fw-bold mb-1">Transactions</h4><p class="text-muted small mb-0">View all financial transactions</p></div>
        <a href="<?php echo e(route('admin.finance.transactions.export.csv', request()->query())); ?>" class="btn btn-outline-success"><i class="fas fa-file-csv me-1"></i> Export CSV</a>
    </div>

    <div class="row g-2 mb-4">
        <div class="col-6 col-md-3">
            <div class="card bg-success-subtle border-0"><div class="card-body text-center py-2"><h5 class="fw-bold mb-0 text-success"><?php echo e(number_format($stats['total_inflow'], 2)); ?></h5><small class="text-muted">Total Inflow</small></div></div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card bg-danger-subtle border-0"><div class="card-body text-center py-2"><h5 class="fw-bold mb-0 text-danger"><?php echo e(number_format($stats['total_outflow'], 2)); ?></h5><small class="text-muted">Total Outflow</small></div></div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card bg-primary-subtle border-0"><div class="card-body text-center py-2"><h5 class="fw-bold mb-0 text-primary"><?php echo e($stats['total_count']); ?></h5><small class="text-muted">Total Transactions</small></div></div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card bg-warning-subtle border-0"><div class="card-body text-center py-2"><h5 class="fw-bold mb-0 text-warning"><?php echo e($stats['pending_count']); ?></h5><small class="text-muted">Pending</small></div></div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="GET" class="row g-2 mb-3">
                <div class="col-md-3"><input type="text" name="search" class="form-control" placeholder="Search..." value="<?php echo e($filters['search'] ?? ''); ?>"></div>
                <div class="col-md-2">
                    <select name="type" class="form-select">
                        <option value="">All Types</option>
                        <?php $__currentLoopData = ['sale','purchase','expense','payment_received','payment_sent','refund','transfer','deposit','withdrawal','adjustment']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($type); ?>" <?php echo e(($filters['type'] ?? '') === $type ? 'selected' : ''); ?>><?php echo e(ucwords(str_replace('_', ' ', $type))); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="direction" class="form-select">
                        <option value="">All Directions</option>
                        <option value="inflow" <?php echo e(($filters['direction'] ?? '') === 'inflow' ? 'selected' : ''); ?>>Inflow</option>
                        <option value="outflow" <?php echo e(($filters['direction'] ?? '') === 'outflow' ? 'selected' : ''); ?>>Outflow</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="completed" <?php echo e(($filters['status'] ?? '') === 'completed' ? 'selected' : ''); ?>>Completed</option>
                        <option value="pending" <?php echo e(($filters['status'] ?? '') === 'pending' ? 'selected' : ''); ?>>Pending</option>
                        <option value="failed" <?php echo e(($filters['status'] ?? '') === 'failed' ? 'selected' : ''); ?>>Failed</option>
                    </select>
                </div>
                <div class="col-md-2"><input type="date" name="date_from" class="form-control" value="<?php echo e($filters['date_from'] ?? ''); ?>" placeholder="From"></div>
                <div class="col-md-1"><button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i></button></div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr><th>#</th><th>Type</th><th class="text-end">Amount</th><th class="text-end">Fee</th><th class="text-end">Net</th><th>Method</th><th>Date</th><th>Direction</th><th>Status</th><th class="text-center">Actions</th></tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><small><?php echo e($t->transaction_number); ?></small></td>
                                <td><span class="badge bg-<?php echo e($t->type === 'sale' ? 'success' : ($t->type === 'expense' || $t->type === 'refund' ? 'danger' : 'primary')); ?>"><?php echo e(str_replace('_', ' ', $t->type)); ?></span></td>
                                <td class="text-end fw-semibold"><?php echo e(number_format($t->amount, 2)); ?></td>
                                <td class="text-end text-muted"><?php echo e($t->fee > 0 ? number_format($t->fee, 2) : '—'); ?></td>
                                <td class="text-end fw-bold <?php echo e($t->direction === 'inflow' ? 'text-success' : 'text-danger'); ?>"><?php echo e(number_format($t->net_amount, 2)); ?></td>
                                <td><small><?php echo e($t->payment_method ?: '—'); ?></small></td>
                                <td><small><?php echo e($t->transaction_date?->format('d/m/Y')); ?></small></td>
                                <td><span class="badge bg-<?php echo e($t->direction === 'inflow' ? 'success' : ($t->direction === 'outflow' ? 'danger' : 'secondary')); ?>"><?php echo e(ucfirst($t->direction)); ?></span></td>
                                <td><span class="badge bg-<?php echo e($t->status === 'completed' ? 'success' : ($t->status === 'failed' ? 'danger' : 'warning')); ?>"><?php echo e($t->status); ?></span></td>
                                <td class="text-center">
                                    <a href="<?php echo e(route('admin.finance.transactions.show', $t->id)); ?>" class="btn btn-sm btn-outline-secondary"><i class="fas fa-eye"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="10" class="text-center py-5 text-muted"><i class="fas fa-exchange-alt fa-3x mb-3 d-block"></i>No transactions found</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-3"><?php echo e($transactions->withQueryString()->links()); ?></div>
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
<?php /**PATH C:\laragon\www\ecommerce\resources\views\admin\finance\transactions\index.blade.php ENDPATH**/ ?>