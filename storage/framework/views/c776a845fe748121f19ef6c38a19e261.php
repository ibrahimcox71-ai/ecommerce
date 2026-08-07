<?php if (isset($component)) { $__componentOriginaledc75c655a063d12a477f2c8d8f324fc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc = $attributes; } ?>
<?php $component = App\View\Components\Layouts\AdminLayout::resolve(['title' => 'Finance Periods'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div><h4 class="fw-bold mb-1">Finance Periods</h4><p class="text-muted small mb-0">Manage accounting periods</p></div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createPeriodModal"><i class="fas fa-plus me-1"></i> Add Period</button>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr><th>Name</th><th>Start Date</th><th>End Date</th><th>Status</th><th>Closed By</th><th>Closed At</th><th class="text-center">Actions</th></tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $periods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $period): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="fw-semibold"><?php echo e($period->name); ?></td>
                                <td><?php echo e($period->start_date?->format('d/m/Y')); ?></td>
                                <td><?php echo e($period->end_date?->format('d/m/Y')); ?></td>
                                <td>
                                    <span class="badge bg-<?php echo e($period->status === 'open' ? 'success' : ($period->status === 'closed' ? 'secondary' : 'danger')); ?>">
                                        <?php echo e(ucfirst($period->status)); ?>

                                    </span>
                                </td>
                                <td><?php echo e($period->closedBy?->name ?? '—'); ?></td>
                                <td><?php echo e($period->closed_at?->format('d/m/Y H:i') ?? '—'); ?></td>
                                <td class="text-center">
                                    <?php if($period->isOpen()): ?>
                                    <div class="btn-group btn-group-sm">
                                        <form method="POST" action="<?php echo e(route('admin.finance.periods.close', $period->id)); ?>" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="btn btn-outline-success" onclick="return confirm('Close this period?')" title="Close"><i class="fas fa-check"></i></button>
                                        </form>
                                        <form method="POST" action="<?php echo e(route('admin.finance.periods.destroy', $period->id)); ?>" class="d-inline">
                                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Delete?')" title="Delete"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </div>
                                    <?php elseif($period->isClosed()): ?>
                                        <form method="POST" action="<?php echo e(route('admin.finance.periods.lock', $period->id)); ?>" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Lock this period? This cannot be undone.')"><i class="fas fa-lock me-1"></i> Lock</button>
                                        </form>
                                    <?php else: ?>
                                        <span class="text-muted">Locked</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="7" class="text-center py-5 text-muted"><i class="fas fa-calendar-alt fa-3x mb-3 d-block"></i>No periods defined</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php if($periods->hasPages()): ?><div class="card-footer d-flex justify-content-center"><?php echo e($periods->links()); ?></div><?php endif; ?>
    </div>

    
    <div class="modal fade" id="createPeriodModal" tabindex="-1">
        <div class="modal-dialog"><div class="modal-content">
            <form method="POST" action="<?php echo e(route('admin.finance.periods.store')); ?>">
                <?php echo csrf_field(); ?>
                <div class="modal-header"><h5 class="modal-title">Create Period</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="mb-3"><label class="form-label">Name <span class="text-danger">*</span></label><input type="text" name="name" class="form-control" placeholder="e.g., Q3 2026" required></div>
                    <div class="row g-3">
                        <div class="col-6"><label class="form-label">Start Date <span class="text-danger">*</span></label><input type="date" name="start_date" class="form-control" required></div>
                        <div class="col-6"><label class="form-label">End Date <span class="text-danger">*</span></label><input type="date" name="end_date" class="form-control" required></div>
                    </div>
                    <div class="mt-3"><label class="form-label">Notes</label><textarea name="notes" class="form-control" rows="2"></textarea></div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn btn-primary">Create</button></div>
            </form>
        </div></div>
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
<?php /**PATH C:\laragon\www\ecommerce\resources\views\admin\finance\periods\index.blade.php ENDPATH**/ ?>