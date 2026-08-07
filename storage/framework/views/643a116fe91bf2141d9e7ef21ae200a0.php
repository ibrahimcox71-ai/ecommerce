<?php if (isset($component)) { $__componentOriginaleac9542bb5e3f887e862d1d96c472e9b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaleac9542bb5e3f887e862d1d96c472e9b = $attributes; } ?>
<?php $component = App\View\Components\Layouts\FrontendLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.frontend-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\FrontendLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php $title = 'Order Failed' ?>

<div class="container py-5">
    <div class="text-center mb-5">
        <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3 sizing-96 bg-danger-light">
            <i class="fas fa-times-circle text-danger" style="font-size: 3rem;"></i>
        </div>
        <h1 class="fw-bold text-gray-800">Order Failed</h1>
        <p class="fs-5 text-gray-500">We're sorry, but your order could not be processed.</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-6 text-center">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body py-4">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3 sizing-64 bg-warning-light">
                        <i class="fas fa-exclamation-triangle fa-2x text-warning"></i>
                    </div>
                    <h5 class="text-gray-800">What went wrong?</h5>
                    <p class="text-muted">There was an issue processing your payment. Your card has not been charged.</p>
                    <hr>
                    <p class="mb-0 text-muted">Please try again or choose a different payment method.</p>
                </div>
            </div>
            <div class="d-flex justify-content-center gap-3">
                <a href="<?php echo e(route('checkout')); ?>" class="btn btn-lg rounded-pill px-4 btn-primary-modern">
                    <i class="fas fa-redo me-2"></i>Try Again
                </a>
                <a href="<?php echo e(route('shop')); ?>" class="btn btn-lg rounded-pill px-4 border-gray-300 text-gray-600">
                    Continue Shopping
                </a>
            </div>
        </div>
    </div>
</div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaleac9542bb5e3f887e862d1d96c472e9b)): ?>
<?php $attributes = $__attributesOriginaleac9542bb5e3f887e862d1d96c472e9b; ?>
<?php unset($__attributesOriginaleac9542bb5e3f887e862d1d96c472e9b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaleac9542bb5e3f887e862d1d96c472e9b)): ?>
<?php $component = $__componentOriginaleac9542bb5e3f887e862d1d96c472e9b; ?>
<?php unset($__componentOriginaleac9542bb5e3f887e862d1d96c472e9b); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\frontend\order-failed.blade.php ENDPATH**/ ?>