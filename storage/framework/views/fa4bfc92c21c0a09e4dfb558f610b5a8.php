<?php if (isset($component)) { $__componentOriginal994edf590732134acb9566c6d7a77e36 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal994edf590732134acb9566c6d7a77e36 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.guest-layout','data' => ['title' => 'Register']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.guest-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Register']); ?>
    <h4 class="fw-bold text-center mb-4">Create Account</h4>

    <form method="POST" action="<?php echo e(route('register')); ?>">
        <?php echo csrf_field(); ?>

        <div class="mb-4">
            <div class="form-outline">
                <input type="text" name="name" id="name" class="form-control" value="<?php echo e(old('name')); ?>" required>
                <label class="form-label" for="name">Full name</label>
            </div>
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
            <div class="form-outline">
                <input type="email" name="email" id="email" class="form-control" value="<?php echo e(old('email')); ?>" required>
                <label class="form-label" for="email">Email address</label>
            </div>
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
            <div class="col-md-6">
                <div class="form-outline">
                    <input type="password" name="password" id="password" class="form-control" required>
                    <label class="form-label" for="password">Password</label>
                </div>
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
                <div class="form-outline">
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                    <label class="form-label" for="password_confirmation">Confirm password</label>
                </div>
            </div>
        </div>

        <div class="form-check mb-4">
            <input type="checkbox" name="terms" class="form-check-input" id="terms">
            <label class="form-check-label small" for="terms">
                I agree to the <a href="<?php echo e(route('terms')); ?>">Terms of Service</a> and <a href="<?php echo e(route('privacy-policy')); ?>">Privacy Policy</a>
            </label>
            <?php $__errorArgs = ['terms'];
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

        <button type="submit" class="btn btn-primary btn-block w-100 mb-3">Create Account</button>

        <div class="text-center">
            <p class="small">Already have an account? <a href="<?php echo e(route('login')); ?>">Sign In</a></p>
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
<?php /**PATH C:\laragon\www\ecommerce\resources\views\auth\register.blade.php ENDPATH**/ ?>