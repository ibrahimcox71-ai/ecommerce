<?php if (isset($component)) { $__componentOriginaledc75c655a063d12a477f2c8d8f324fc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc = $attributes; } ?>
<?php $component = App\View\Components\Layouts\AdminLayout::resolve(['title' => 'Purchase Reports'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Purchase Reports</h4>
            <p class="text-muted small mb-0">Analyze purchase performance</p>
        </div>
        <a href="<?php echo e(route('admin.purchases.index')); ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>

    <div class="row g-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-file-invoice fa-3x text-primary mb-3"></i>
                    <h5>Purchase Report</h5>
                    <p class="text-muted small">View all purchase orders with date filters</p>
                    <a href="<?php echo e(route('admin.purchases.reports.purchase')); ?>" class="btn btn-outline-primary">
                        <i class="fas fa-eye me-1"></i> View Report
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-truck fa-3x text-success mb-3"></i>
                    <h5>Supplier Report</h5>
                    <p class="text-muted small">Purchase summary by supplier</p>
                    <a href="<?php echo e(route('admin.purchases.reports.supplier')); ?>" class="btn btn-outline-success">
                        <i class="fas fa-eye me-1"></i> View Report
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-money-bill-wave fa-3x text-info mb-3"></i>
                    <h5>Payment Report</h5>
                    <p class="text-muted small">Track all purchase payments</p>
                    <a href="<?php echo e(route('admin.purchases.reports.payment')); ?>" class="btn btn-outline-info">
                        <i class="fas fa-eye me-1"></i> View Report
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-exclamation-triangle fa-3x text-danger mb-3"></i>
                    <h5>Outstanding Due Report</h5>
                    <p class="text-muted small">View unpaid and partially paid purchases</p>
                    <a href="<?php echo e(route('admin.purchases.reports.due')); ?>" class="btn btn-outline-danger">
                        <i class="fas fa-eye me-1"></i> View Report
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-undo fa-3x text-warning mb-3"></i>
                    <h5>Purchase Return Report</h5>
                    <p class="text-muted small">Track returned items and refunds</p>
                    <a href="<?php echo e(route('admin.purchases.reports.return')); ?>" class="btn btn-outline-warning">
                        <i class="fas fa-eye me-1"></i> View Report
                    </a>
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
<?php /**PATH C:\laragon\www\ecommerce\resources\views\admin\purchases\reports\index.blade.php ENDPATH**/ ?>