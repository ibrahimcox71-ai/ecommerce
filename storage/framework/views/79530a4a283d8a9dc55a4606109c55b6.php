<?php if (isset($component)) { $__componentOriginal994edf590732134acb9566c6d7a77e36 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal994edf590732134acb9566c6d7a77e36 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.guest-layout','data' => ['title' => 'Verify Email']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.guest-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Verify Email']); ?>
    <div class="text-center">
        <i class="fas fa-envelope-open-text fa-3x text-primary mb-3"></i>
        <h4 class="fw-bold mb-3">Verify Your Email</h4>
        <p class="text-muted small mb-4">A verification link has been sent to your email address.</p>

        <form method="POST" action="<?php echo e(route('verification.send')); ?>">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn btn-primary">Resend Verification Email</button>
        </form>

        <form method="POST" action="<?php echo e(route('logout')); ?>" class="mt-3">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn btn-link text-muted small">Logout</button>
        </form>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal994edf590732134acb9566c6d7a77e36)): ?>
<?php $attributes = $__attributesOriginal994edf590732134acb9566c6d7a77e36; ?>
<?php unset($__attributesOriginal994edf590732134acb9566c6d7a77e36); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal994edf590732134acb9566c6d7a77e36)): ?>
<?php $component = $__componentOriginal994edf590732134acb9566c6d7a77e36; ?>
<?php unset($__componentOriginal994edf590732134acb9566c6d7a77e36); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\auth\verify-email.blade.php ENDPATH**/ ?>