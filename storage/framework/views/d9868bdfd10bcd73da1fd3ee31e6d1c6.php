<?php if (isset($component)) { $__componentOriginaledc75c655a063d12a477f2c8d8f324fc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc = $attributes; } ?>
<?php $component = App\View\Components\Layouts\AdminLayout::resolve(['title' => 'Expense Details'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1"><?php echo e($expense->expense_number); ?></h4>
            <p class="text-muted small mb-0">
                <span class="badge bg-<?php echo e($expense->status === 'approved' ? 'success' : ($expense->status === 'pending' ? 'warning' : 'secondary')); ?>"><?php echo e(ucfirst($expense->status)); ?></span>
            </p>
        </div>
        <div class="d-flex gap-2">
            <?php if($expense->isApprovable()): ?>
                <form method="POST" action="<?php echo e(route('admin.finance.expenses.approve', $expense->id)); ?>" class="d-inline">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn btn-success" onclick="return confirm('Approve this expense?')"><i class="fas fa-check-circle me-1"></i> Approve</button>
                </form>
            <?php endif; ?>
            <?php if($expense->isEditable()): ?>
                <a href="<?php echo e(route('admin.finance.expenses.edit', $expense->id)); ?>" class="btn btn-outline-primary"><i class="fas fa-edit me-1"></i> Edit</a>
            <?php endif; ?>
            <a href="<?php echo e(route('admin.finance.expenses.index')); ?>" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i> Back</a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header bg-transparent"><h6 class="fw-bold mb-0">Expense Details</h6></div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4"><label class="text-muted small text-uppercase">Category</label><p class="fw-semibold mb-0"><?php echo e($expense->category?->name ?? '—'); ?></p></div>
                        <div class="col-md-4"><label class="text-muted small text-uppercase">Amount</label><p class="fw-bold fs-5 mb-0 text-danger"><?php echo e(number_format($expense->amount, 2)); ?></p></div>
                        <div class="col-md-4"><label class="text-muted small text-uppercase">Total (incl. Tax)</label><p class="fw-bold fs-5 mb-0 text-danger"><?php echo e(number_format($expense->total_amount, 2)); ?></p></div>
                        <div class="col-md-4"><label class="text-muted small text-uppercase">Date</label><p class="mb-0"><?php echo e($expense->expense_date?->format('d M, Y')); ?></p></div>
                        <div class="col-md-4"><label class="text-muted small text-uppercase">Payee</label><p class="mb-0"><?php echo e($expense->payee ?: '—'); ?></p></div>
                        <div class="col-md-4"><label class="text-muted small text-uppercase">Payment Method</label><p class="mb-0"><?php echo e($expense->payment_method ?: '—'); ?></p></div>
                        <?php if($expense->reference_number): ?><div class="col-md-4"><label class="text-muted small text-uppercase">Reference</label><p class="mb-0"><?php echo e($expense->reference_number); ?></p></div><?php endif; ?>
                        <?php if($expense->chartOfAccount): ?><div class="col-md-4"><label class="text-muted small text-uppercase">Account</label><p class="mb-0"><?php echo e($expense->chartOfAccount->name); ?></p></div><?php endif; ?>
                        <?php if($expense->description): ?><div class="col-12"><label class="text-muted small text-uppercase">Description</label><p class="mb-0"><?php echo e($expense->description); ?></p></div><?php endif; ?>
                        <?php if($expense->notes): ?><div class="col-12"><label class="text-muted small text-uppercase">Notes</label><p class="mb-0"><?php echo e($expense->notes); ?></p></div><?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header bg-transparent"><h6 class="fw-bold mb-0">Record Info</h6></div>
                <div class="card-body">
                    <div class="mb-3"><label class="text-muted small text-uppercase">Created By</label><p class="mb-0"><?php echo e($expense->creator?->name ?? '—'); ?></p></div>
                    <div class="mb-3"><label class="text-muted small text-uppercase">Created At</label><p class="mb-0"><?php echo e($expense->created_at?->format('d M Y, h:i A')); ?></p></div>
                    <?php if($expense->approved_at): ?>
                    <div class="mb-3"><label class="text-muted small text-uppercase">Approved By</label><p class="mb-0"><?php echo e($expense->approver?->name ?? '—'); ?></p></div>
                    <div class="mb-3"><label class="text-muted small text-uppercase">Approved At</label><p class="mb-0"><?php echo e($expense->approved_at?->format('d M Y, h:i A')); ?></p></div>
                    <?php endif; ?>
                    <?php if($expense->receipt): ?>
                    <div class="mb-3">
                        <label class="text-muted small text-uppercase">Receipt</label>
                        <p class="mb-0"><a href="<?php echo e(asset('storage/' . $expense->receipt)); ?>" target="_blank" class="btn btn-sm btn-outline-primary"><i class="fas fa-file me-1"></i> View Receipt</a></p>
                    </div>
                    <?php endif; ?>
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
<?php /**PATH C:\laragon\www\ecommerce\resources\views\admin\finance\expenses\show.blade.php ENDPATH**/ ?>