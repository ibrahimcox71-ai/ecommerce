<?php if (isset($component)) { $__componentOriginal994edf590732134acb9566c6d7a77e36 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal994edf590732134acb9566c6d7a77e36 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.guest-layout','data' => ['title' => 'Customer Login']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.guest-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Customer Login']); ?>
    <h4 class="fw-bold text-center mb-4 text-gray-800">Welcome Back</h4>

    <form method="POST" action="<?php echo e(route('customer.login')); ?>">
        <?php echo csrf_field(); ?>

        <div class="mb-4">
            <label for="email" class="form-label fw-semibold text-gray-700">Email address</label>
            <input type="email" name="email" id="email" class="form-control-premium" value="<?php echo e(old('email')); ?>" required placeholder="your@email.com">
            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="text-danger small mt-1"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="mb-4">
            <label for="password" class="form-label fw-semibold text-gray-700">Password</label>
            <input type="password" name="password" id="password" class="form-control-premium" required placeholder="Enter your password">
            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="text-danger small mt-1"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="form-check">
                <input type="checkbox" name="remember" class="form-check-input" id="remember">
                <label class="form-check-label small text-gray-600" for="remember">Remember me</label>
            </div>
            <a href="<?php echo e(route('password.request')); ?>" class="text-primary-custom small fw-semibold">Forgot password?</a>
        </div>

        <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 mb-3 fw-semibold">Sign In</button>

        <div class="text-center">
            <p class="small text-gray-500">Don't have an account? <a href="<?php echo e(route('customer.register')); ?>" class="text-primary-custom fw-semibold">Register</a></p>
        </div>
    </form>
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
<?php /**PATH C:\laragon\www\ecommerce\resources\views\auth\customer-login.blade.php ENDPATH**/ ?>