<?php if (isset($component)) { $__componentOriginal994edf590732134acb9566c6d7a77e36 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal994edf590732134acb9566c6d7a77e36 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.guest-layout','data' => ['title' => 'Login']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.guest-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Login']); ?>
    <h4 class="fw-bold text-center mb-4">Welcome Back</h4>

    <form method="POST" action="<?php echo e(route('login')); ?>" class="text-start">
        <?php echo csrf_field(); ?>

        <!-- Email Field -->
        <div class="mb-3">
            <label for="email" class="form-label fw-semibold text-dark">Email address</label>
            <input type="email" id="email" name="email" class="form-control form-control-lg <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('email')); ?>" placeholder="your@email.com" required autofocus>
            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="invalid-feedback" role="alert">
                    <strong><?php echo e($message); ?></strong>
                </span>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <!-- Password Field -->
        <div class="mb-3">
            <label for="password" class="form-label fw-semibold text-dark">Password</label>
            <input type="password" id="password" name="password" class="form-control form-control-lg <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Enter your password" required>
            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="invalid-feedback" role="alert">
                    <strong><?php echo e($message); ?></strong>
                </span>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>>
                <label class="form-check-label text-secondary fs-6" for="remember">
                    Remember me
                </label>
            </div>
            <?php if(Route::has('password.request')): ?>
                <a class="text-primary text-decoration-none fw-medium fs-6" href="<?php echo e(route('password.request')); ?>">
                    Forgot password?
                </a>
            <?php endif; ?>
        </div>

        <!-- Submit Button -->
        <div class="d-grid mb-3">
            <button type="submit" class="btn btn-primary btn-lg fw-bold py-2 shadow-sm">
                Sign In
            </button>
        </div>

        <!-- Register Link -->
        <?php if(Route::has('register')): ?>
            <div class="text-center mt-3 fs-6">
                <span class="text-muted">Don't have an account?</span>
                <a href="<?php echo e(route('register')); ?>" class="text-primary text-decoration-none fw-semibold">Register</a>
            </div>
        <?php endif; ?>
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
<?php /**PATH C:\laragon\www\ecommerce\resources\views\auth\login.blade.php ENDPATH**/ ?>