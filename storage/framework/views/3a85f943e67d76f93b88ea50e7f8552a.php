<?php if (isset($component)) { $__componentOriginaledc75c655a063d12a477f2c8d8f324fc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc = $attributes; } ?>
<?php $component = App\View\Components\Layouts\AdminLayout::resolve(['title' => 'Transaction Details'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1"><?php echo e($transaction->transaction_number); ?></h4>
            <p class="text-muted small mb-0">
                <span class="badge bg-<?php echo e($transaction->type === 'sale' ? 'success' : ($transaction->type === 'expense' || $transaction->type === 'refund' ? 'danger' : 'primary')); ?>"><?php echo e(str_replace('_', ' ', $transaction->type)); ?></span>
                <span class="badge bg-<?php echo e($transaction->status === 'completed' ? 'success' : ($transaction->status === 'failed' ? 'danger' : 'warning')); ?> ms-1"><?php echo e($transaction->status); ?></span>
                <span class="badge bg-<?php echo e($transaction->direction === 'inflow' ? 'success' : 'danger'); ?> ms-1"><?php echo e(ucfirst($transaction->direction)); ?></span>
            </p>
        </div>
        <a href="<?php echo e(route('admin.finance.transactions.index')); ?>" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i> Back</a>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header bg-transparent"><h6 class="fw-bold mb-0">Transaction Info</h6></div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-6"><label class="text-muted small text-uppercase">Amount</label><p class="fw-bold fs-5 mb-0 <?php echo e($transaction->direction === 'inflow' ? 'text-success' : 'text-danger'); ?>"><?php echo e(number_format($transaction->amount, 2)); ?></p></div>
                        <div class="col-6"><label class="text-muted small text-uppercase">Net Amount</label><p class="fw-bold fs-5 mb-0"><?php echo e(number_format($transaction->net_amount, 2)); ?></p></div>
                        <?php if($transaction->fee > 0): ?>
                        <div class="col-6"><label class="text-muted small text-uppercase">Fee</label><p class="mb-0 text-danger"><?php echo e(number_format($transaction->fee, 2)); ?></p></div>
                        <?php endif; ?>
                        <div class="col-6"><label class="text-muted small text-uppercase">Currency</label><p class="fw-semibold mb-0"><?php echo e($transaction->currency); ?></p></div>
                        <div class="col-6"><label class="text-muted small text-uppercase">Date</label><p class="mb-0"><?php echo e($transaction->transaction_date?->format('d M, Y')); ?></p></div>
                        <div class="col-6"><label class="text-muted small text-uppercase">Payment Method</label><p class="mb-0"><?php echo e($transaction->payment_method ?: '—'); ?></p></div>
                        <?php if($transaction->reference_number): ?>
                        <div class="col-6"><label class="text-muted small text-uppercase">Reference</label><p class="mb-0"><?php echo e($transaction->reference_number); ?></p></div>
                        <?php endif; ?>
                        <?php if($transaction->description): ?>
                        <div class="col-12"><label class="text-muted small text-uppercase">Description</label><p class="mb-0"><?php echo e($transaction->description); ?></p></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header bg-transparent"><h6 class="fw-bold mb-0">Account Info</h6></div>
                <div class="card-body">
                    <div class="mb-3"><label class="text-muted small text-uppercase">Chart of Account</label><p class="fw-semibold mb-0"><?php echo e($transaction->chartOfAccount?->name ?? '—'); ?></p></div>
                    <div class="mb-3"><label class="text-muted small text-uppercase">Created By</label><p class="mb-0"><?php echo e($transaction->creator?->name ?? '—'); ?></p></div>
                    <div class="mb-3"><label class="text-muted small text-uppercase">Created At</label><p class="mb-0"><?php echo e($transaction->created_at?->format('d M Y, h:i A')); ?></p></div>
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
<?php /**PATH C:\laragon\www\ecommerce\resources\views\admin\finance\transactions\show.blade.php ENDPATH**/ ?>