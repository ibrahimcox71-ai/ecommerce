<?php if (isset($component)) { $__componentOriginaledc75c655a063d12a477f2c8d8f324fc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc = $attributes; } ?>
<?php $component = App\View\Components\Layouts\AdminLayout::resolve(['title' => 'Sales Report'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <a href="<?php echo e(route('admin.orders.reports')); ?>" class="text-muted text-decoration-none small">
            <i class="fas fa-arrow-left me-1"></i>Back to Reports
        </a>
        <h4 class="fw-bold mb-0 mt-1">Sales Report</h4>
    </div>
    <form method="GET" class="d-flex gap-2">
        <input type="date" name="date_from" class="form-control form-control-sm" value="<?php echo e($dateFrom); ?>">
        <input type="date" name="date_to" class="form-control form-control-sm" value="<?php echo e($dateTo); ?>">
        <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-search"></i></button>
    </form>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-primary bg-opacity-10">
            <div class="card-body text-center">
                <small class="text-muted text-uppercase fw-semibold" style="font-size: 11px;">Total Orders</small>
                <h3 class="fw-bold mt-1 text-primary"><?php echo e($report['total_orders']); ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-success bg-opacity-10">
            <div class="card-body text-center">
                <small class="text-muted text-uppercase fw-semibold" style="font-size: 11px;">Total Revenue</small>
                <h3 class="fw-bold mt-1 text-success"><?php echo e(config('ecommerce.currency_symbol', '$')); ?><?php echo e(number_format($report['total_revenue'], 2)); ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-info bg-opacity-10">
            <div class="card-body text-center">
                <small class="text-muted text-uppercase fw-semibold" style="font-size: 11px;">Avg Order Value</small>
                <h3 class="fw-bold mt-1 text-info"><?php echo e(config('ecommerce.currency_symbol', '$')); ?><?php echo e(number_format($report['avg_order_value'], 2)); ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-warning bg-opacity-10">
            <div class="card-body text-center">
                <small class="text-muted text-uppercase fw-semibold" style="font-size: 11px;">Total Shipping</small>
                <h3 class="fw-bold mt-1 text-warning"><?php echo e(config('ecommerce.currency_symbol', '$')); ?><?php echo e(number_format($report['total_shipping'], 2)); ?></h3>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <small class="text-muted text-uppercase fw-semibold" style="font-size: 11px;">Total Paid</small>
                <h5 class="fw-bold mt-1 text-success"><?php echo e(config('ecommerce.currency_symbol', '$')); ?><?php echo e(number_format($report['total_paid'], 2)); ?></h5>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <small class="text-muted text-uppercase fw-semibold" style="font-size: 11px;">Total Tax</small>
                <h5 class="fw-bold mt-1"><?php echo e(config('ecommerce.currency_symbol', '$')); ?><?php echo e(number_format($report['total_tax'], 2)); ?></h5>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <small class="text-muted text-uppercase fw-semibold" style="font-size: 11px;">Total Discount</small>
                <h5 class="fw-bold mt-1 text-danger"><?php echo e(config('ecommerce.currency_symbol', '$')); ?><?php echo e(number_format($report['total_discount'], 2)); ?></h5>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <small class="text-muted text-uppercase fw-semibold" style="font-size: 11px;">Revenue Per Order</small>
                <h5 class="fw-bold mt-1 text-info"><?php echo e(config('ecommerce.currency_symbol', '$')); ?><?php echo e(number_format($report['avg_order_value'], 2)); ?></h5>
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
<?php /**PATH C:\laragon\www\ecommerce\resources\views\admin\orders\reports\sales.blade.php ENDPATH**/ ?>