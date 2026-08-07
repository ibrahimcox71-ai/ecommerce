<?php if (isset($component)) { $__componentOriginaledc75c655a063d12a477f2c8d8f324fc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc = $attributes; } ?>
<?php $component = App\View\Components\Layouts\AdminLayout::resolve(['title' => 'User Details'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1"><?php echo e($user->name); ?></h4>
            <p class="text-muted small mb-0">User details and activity</p>
        </div>
        <div class="d-flex gap-2">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('users.edit')): ?>
                <a href="<?php echo e(route('admin.users.edit', $user->id)); ?>" class="btn btn-primary">
                    <i class="fas fa-edit me-1"></i> Edit User
                </a>
            <?php endif; ?>
            <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <?php if($user->avatar): ?>
                        <img src="<?php echo e(Storage::url($user->avatar)); ?>" alt="<?php echo e($user->name); ?>"
                             class="rounded-circle img-fluid mb-3" style="width: 120px; height: 120px; object-fit: cover;">
                    <?php else: ?>
                        <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center mb-3"
                             style="width: 120px; height: 120px; font-size: 2.5rem;">
                            <?php echo e(strtoupper(substr($user->name, 0, 1))); ?>

                        </div>
                    <?php endif; ?>
                    <h5 class="fw-bold"><?php echo e($user->name); ?></h5>
                    <p class="text-muted small mb-2"><?php echo e($user->email); ?></p>
                    <?php $__currentLoopData = $user->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <span class="badge bg-<?php echo e($role->name === 'super-admin' ? 'warning' : 'primary'); ?> me-1">
                            <?php echo e(ucfirst($role->name)); ?>

                        </span>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <hr>
                    <p class="mb-1 small">
                        <strong>Status:</strong>
                        <span class="badge bg-<?php echo e($user->status ? 'success' : 'danger'); ?>">
                            <?php echo e($user->status ? 'Active' : 'Inactive'); ?>

                        </span>
                    </p>
                    <p class="mb-1 small"><strong>Phone:</strong> <?php echo e($user->phone ?? 'N/A'); ?></p>
                    <p class="mb-1 small"><strong>Member since:</strong> <?php echo e($user->created_at->format('M d, Y')); ?></p>
                    <?php if($user->email_verified_at): ?>
                        <p class="mb-0 small"><strong>Verified:</strong> <?php echo e($user->email_verified_at->format('M d, Y')); ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('users.edit')): ?>
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="fw-bold mb-0">Reset Password</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="<?php echo e(route('admin.users.reset-password', $user->id)); ?>">
                            <?php echo csrf_field(); ?>
                            <div class="mb-3">
                                <div class="form-outline">
                                    <input type="password" name="password" id="reset_password" class="form-control" required>
                                    <label class="form-label" for="reset_password">New Password</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-outline">
                                    <input type="password" name="password_confirmation" id="reset_password_confirmation" class="form-control" required>
                                    <label class="form-label" for="reset_password_confirmation">Confirm Password</label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-warning w-100">
                                <i class="fas fa-key me-1"></i> Reset Password
                            </button>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="fw-bold mb-0">Roles</h6>
                </div>
                <div class="card-body">
                    <?php if($user->roles->count() > 0): ?>
                        <?php $__currentLoopData = $user->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <span class="badge bg-primary bg-opacity-10 text-primary me-1 mb-1" style="font-size: 0.85rem;">
                                <i class="fas fa-shield-alt me-1"></i><?php echo e(ucfirst($role->name)); ?>

                            </span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <p class="text-muted mb-0">No roles assigned.</p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="fw-bold mb-0">Direct Permissions</h6>
                </div>
                <div class="card-body">
                    <?php if($user->getPermissionNames()->count() > 0): ?>
                        <?php $__currentLoopData = $user->getPermissionNames(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <span class="badge bg-info bg-opacity-10 text-info me-1 mb-1">
                                <?php echo e($permission); ?>

                            </span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <p class="text-muted mb-0">No direct permissions assigned. User inherits permissions from roles.</p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0">Login History</h6>
                    <a href="<?php echo e(route('admin.users.login-history', $user->id)); ?>" class="btn btn-sm btn-outline-primary">
                        View All
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 small">
                            <thead class="table-light">
                                <tr>
                                    <th>Date/Time</th>
                                    <th>IP Address</th>
                                    <th>Browser</th>
                                    <th>Platform</th>
                                    <th>Device</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $user->loginHistories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $history): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($history->login_at?->format('M d, Y H:i')); ?></td>
                                        <td><?php echo e($history->ip_address); ?></td>
                                        <td><?php echo e($history->browser); ?></td>
                                        <td><?php echo e($history->platform); ?></td>
                                        <td><?php echo e($history->device_type); ?></td>
                                        <td>
                                            <?php if($history->is_successful): ?>
                                                <span class="badge bg-success">Success</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger"><?php echo e($history->failure_reason ?? 'Failed'); ?></span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-3">No login history</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
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
<?php /**PATH C:\laragon\www\ecommerce\resources\views\admin\users\show.blade.php ENDPATH**/ ?>