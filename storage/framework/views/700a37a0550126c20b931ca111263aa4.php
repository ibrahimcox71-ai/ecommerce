<?php if (isset($component)) { $__componentOriginaledc75c655a063d12a477f2c8d8f324fc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc = $attributes; } ?>
<?php $component = App\View\Components\Layouts\AdminLayout::resolve(['title' => 'Accounts Payable'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div><h4 class="fw-bold mb-1">Accounts Payable</h4><p class="text-muted small mb-0">Outstanding payments to suppliers / unpaid purchase orders</p></div>
        <a href="<?php echo e(route('admin.finance.reports.index')); ?>" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i> Back</a>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4"><div class="card bg-danger-subtle"><div class="card-body text-center py-3"><h5 class="fw-bold mb-0 text-danger"><?php echo e(number_format($report?->total_due ?? 0, 2)); ?></h5><small class="text-muted">Total Due</small></div></div></div>
        <div class="col-md-4"><div class="card bg-primary-subtle"><div class="card-body text-center py-3"><h5 class="fw-bold mb-0 text-primary"><?php echo e($report?->invoice_count ?? 0); ?></h5><small class="text-muted">Outstanding Invoices</small></div></div></div>
        <div class="col-md-4"><div class="card bg-warning-subtle"><div class="card-body text-center py-3"><h5 class="fw-bold mb-0 text-warning"><?php echo e(number_format($report?->overdue ?? 0, 2)); ?></h5><small class="text-muted">Overdue (30+ days)</small></div></div></div>
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
<?php /**PATH C:\laragon\www\ecommerce\resources\views\admin\finance\reports\accounts-payable.blade.php ENDPATH**/ ?>