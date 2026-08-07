<?php if (isset($component)) { $__componentOriginal994edf590732134acb9566c6d7a77e36 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal994edf590732134acb9566c6d7a77e36 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.guest-layout','data' => ['title' => 'Customer Register']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.guest-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Customer Register']); ?>
    <h4 class="fw-bold text-center mb-4 text-gray-800">Create Account</h4>

    <form method="POST" action="<?php echo e(route('customer.register')); ?>">
        <?php echo csrf_field(); ?>

        <div class="mb-4">
            <label for="name" class="form-label fw-semibold text-gray-700">Full name</label>
            <input type="text" name="name" id="name" class="form-control-premium" value="<?php echo e(old('name')); ?>" required placeholder="John Doe">
            <?php $__errorArgs = ['name'];
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

        <div class="row mb-4">
            <div class="col-md-6 mb-3 mb-md-0">
                <label for="password" class="form-label fw-semibold text-gray-700">Password</label>
                <input type="password" name="password" id="password" class="form-control-premium" required placeholder="Min 8 characters">
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
            <div class="col-md-6">
                <label for="password_confirmation" class="form-label fw-semibold text-gray-700">Confirm password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control-premium" required placeholder="Repeat password">
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 mb-3 fw-semibold">Create Account</button>

        <div class="text-center">
            <p class="small text-gray-500">Already have an account? <a href="<?php echo e(route('customer.login')); ?>" class="text-primary-custom fw-semibold">Sign In</a></p>
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
<?php /**PATH C:\laragon\www\ecommerce\resources\views\auth\customer-register.blade.php ENDPATH**/ ?>