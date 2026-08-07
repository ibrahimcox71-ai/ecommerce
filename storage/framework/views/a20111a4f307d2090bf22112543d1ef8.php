<?php if (isset($component)) { $__componentOriginaledc75c655a063d12a477f2c8d8f324fc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc = $attributes; } ?>
<?php $component = App\View\Components\Layouts\AdminLayout::resolve(['title' => 'Role Details'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1"><?php echo e(ucfirst($role->name)); ?></h4>
            <p class="text-muted small mb-0">Role details and assigned permissions</p>
        </div>
        <div class="d-flex gap-2">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('roles.edit')): ?>
                <a href="<?php echo e(route('admin.roles.edit', $role->id)); ?>" class="btn btn-primary">
                    <i class="fas fa-edit me-1"></i> Edit Role
                </a>
            <?php endif; ?>
            <a href="<?php echo e(route('admin.roles.index')); ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-inline-flex align-items-center justify-content-center mb-3"
                         style="width: 80px; height: 80px; font-size: 2rem;">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h5 class="fw-bold"><?php echo e(ucfirst($role->name)); ?></h5>
                    <span class="badge bg-secondary"><?php echo e($role->guard_name); ?></span>
                    <?php if($role->name === 'super-admin'): ?>
                        <div class="mt-2"><span class="badge bg-warning">Full Access</span></div>
                    <?php endif; ?>
                    <hr>
                    <p class="mb-1 small">
                        <strong>Created:</strong> <?php echo e($role->created_at->format('M d, Y')); ?>

                    </p>
                    <p class="mb-0 small">
                        <strong>Last Updated:</strong> <?php echo e($role->updated_at->format('M d, Y')); ?>

                    </p>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h6 class="fw-bold mb-0">Permissions (<?php echo e($role->permissions->count()); ?>)</h6>
                </div>
                <div class="card-body">
                    <?php if($role->permissions->count() > 0): ?>
                        <?php
                            $grouped = $role->permissions->groupBy(function($perm) {
                                return explode('.', $perm->name)[0];
                            });
                        ?>

                        <?php $__currentLoopData = $grouped; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group => $permissions): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="mb-3">
                                <h6 class="text-muted text-uppercase small fw-semibold mb-2"><?php echo e(ucfirst(str_replace('-', ' ', $group))); ?></h6>
                                <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="badge bg-primary bg-opacity-10 text-primary me-1 mb-1">
                                        <?php echo e(str_replace($group . '.', '', $permission->name)); ?>

                                    </span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="fas fa-lock fa-2x text-muted mb-2"></i>
                            <p class="text-muted mb-0">No permissions assigned to this role.</p>
                        </div>
                    <?php endif; ?>
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
<?php /**PATH C:\laragon\www\ecommerce\resources\views\admin\roles\show.blade.php ENDPATH**/ ?>