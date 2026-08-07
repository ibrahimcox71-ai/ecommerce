<?php if (isset($component)) { $__componentOriginaledc75c655a063d12a477f2c8d8f324fc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc = $attributes; } ?>
<?php $component = App\View\Components\Layouts\AdminLayout::resolve(['title' => 'Create Role'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Create Role</h4>
            <p class="text-muted small mb-0">Define a new role and assign permissions</p>
        </div>
    </div>

    <form method="POST" action="<?php echo e(route('admin.roles.store')); ?>">
        <?php echo csrf_field(); ?>

        <div class="card mb-4">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-outline">
                            <input type="text" name="name" id="name" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   value="<?php echo e(old('name')); ?>" required placeholder="e.g., editor">
                            <label class="form-label" for="name">Role Name</label>
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
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h6 class="fw-bold mb-0">Permissions</h6>
            </div>
            <div class="card-body">
                <?php if(count($groupedPermissions) > 0): ?>
                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="selectAllPermissions">
                            <label class="form-check-label fw-semibold" for="selectAllPermissions">Select All Permissions</label>
                        </div>
                    </div>
                    <hr>

                    <?php $__currentLoopData = $groupedPermissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="mb-4">
                            <div class="d-flex align-items-center mb-2">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input group-select"
                                           data-group="<?php echo e($group['group']->value); ?>" id="group_<?php echo e($group['group']->value); ?>">
                                    <label class="form-check-label fw-semibold" for="group_<?php echo e($group['group']->value); ?>">
                                        <?php echo e($group['group']->label()); ?>

                                    </label>
                                </div>
                            </div>
                            <div class="row ms-4">
                                <?php $__currentLoopData = $group['permissions']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-md-3 col-sm-4 mb-1">
                                        <div class="form-check">
                                            <input type="checkbox" name="permissions[]" value="<?php echo e($permission->id); ?>"
                                                   class="form-check-input permission-checkbox"
                                                   data-group="<?php echo e($group['group']->value); ?>"
                                                   id="perm_<?php echo e($permission->id); ?>"
                                                <?php echo e(in_array($permission->id, old('permissions', [])) ? 'checked' : ''); ?>>
                                            <label class="form-check-label small" for="perm_<?php echo e($permission->id); ?>">
                                                <?php echo e(str_replace($group['group']->value . '.', '', $permission->name)); ?>

                                            </label>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <div class="text-center py-4">
                        <p class="text-muted mb-0">No permissions found. Run the permission seeder first.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-1"></i> Create Role
            </button>
            <a href="<?php echo e(route('admin.roles.index')); ?>" class="btn btn-secondary">Cancel</a>
        </div>
    </form>

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

<?php $__env->startPush('scripts'); ?>
<script>
$(document).ready(function() {
    $('#selectAllPermissions').change(function() {
        $('.permission-checkbox').prop('checked', $(this).prop('checked'));
        $('.group-select').prop('checked', $(this).prop('checked'));
    });

    $('.group-select').change(function() {
        const group = $(this).data('group');
        $(`.permission-checkbox[data-group="${group}"]`).prop('checked', $(this).prop('checked'));
        updateSelectAll();
    });

    $('.permission-checkbox').change(function() {
        const group = $(this).data('group');
        const groupCheckboxes = $(`.permission-checkbox[data-group="${group}"]`);
        const checked = groupCheckboxes.filter(':checked').length;
        $(`.group-select[data-group="${group}"]`).prop('checked', checked === groupCheckboxes.length);
        updateSelectAll();
    });

    function updateSelectAll() {
        const total = $('.permission-checkbox').length;
        const checked = $('.permission-checkbox:checked').length;
        $('#selectAllPermissions').prop('checked', total === checked);
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\admin\roles\create.blade.php ENDPATH**/ ?>