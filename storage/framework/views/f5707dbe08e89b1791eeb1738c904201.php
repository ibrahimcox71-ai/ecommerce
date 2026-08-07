<?php if (isset($component)) { $__componentOriginaledc75c655a063d12a477f2c8d8f324fc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc = $attributes; } ?>
<?php $component = App\View\Components\Layouts\AdminLayout::resolve(['title' => 'Permissions'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Permissions</h4>
            <p class="text-muted small mb-0">Manage system permissions for all roles</p>
        </div>
        <div class="d-flex gap-2">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('permissions.manage')): ?>
                <a href="<?php echo e(route('admin.permissions.generate')); ?>" class="btn btn-outline-warning"
                   onclick="return confirm('Generate all system permissions? This may create new permissions.')">
                    <i class="fas fa-sync me-1"></i> Generate All
                </a>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('permissions.create')): ?>
                <a href="<?php echo e(route('admin.permissions.create')); ?>" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i> Add Permission
                </a>
            <?php endif; ?>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="<?php echo e(route('admin.permissions.index')); ?>" class="row g-3">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
                        <input type="text" name="search" class="form-control"
                               placeholder="Search permissions..." value="<?php echo e(request('search')); ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="group" class="form-select">
                        <option value="">All Groups</option>
                        <?php $__currentLoopData = $grouped; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($g['group']->value); ?>" <?php echo e(request('group') === $g['group']->value ? 'selected' : ''); ?>>
                                <?php echo e($g['group']->label()); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-outline-primary w-100">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <?php if($permissions->count() > 0): ?>
                <form id="bulkForm" method="POST" action="<?php echo e(route('admin.permissions.bulk-delete')); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('permissions.delete')): ?>
                                        <th class="border-0" style="width: 40px;">
                                            <input type="checkbox" class="form-check-input" id="selectAll">
                                        </th>
                                    <?php endif; ?>
                                    <th class="border-0">Permission</th>
                                    <th class="border-0">Group</th>
                                    <th class="border-0">Type</th>
                                    <th class="border-0">Guard</th>
                                    <th class="border-0 text-end" style="width: 120px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $parts = explode('.', $permission->name);
                                        $group = $parts[0] ?? '';
                                        $type = $parts[1] ?? '';
                                    ?>
                                    <tr>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('permissions.delete')): ?>
                                            <td>
                                                <input type="checkbox" name="ids[]" value="<?php echo e($permission->id); ?>"
                                                       class="form-check-input row-checkbox">
                                            </td>
                                        <?php endif; ?>
                                        <td>
                                            <code><?php echo e($permission->name); ?></code>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary"><?php echo e($group); ?></span>
                                        </td>
                                        <td>
                                            <?php
                                                $typeColors = [
                                                    'view' => 'info', 'create' => 'success', 'edit' => 'primary',
                                                    'delete' => 'danger', 'restore' => 'warning', 'export' => 'secondary',
                                                    'import' => 'dark', 'approve' => 'success', 'reject' => 'danger',
                                                    'publish' => 'success', 'unpublish' => 'warning', 'manage' => 'dark',
                                                ];
                                                $color = $typeColors[$type] ?? 'secondary';
                                            ?>
                                            <span class="badge bg-<?php echo e($color); ?>"><?php echo e($type); ?></span>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark"><?php echo e($permission->guard_name); ?></span>
                                        </td>
                                        <td class="text-end">
                                            <div class="btn-group">
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('permissions.edit')): ?>
                                                    <a href="<?php echo e(route('admin.permissions.edit', $permission->id)); ?>"
                                                       class="btn btn-sm btn-outline-primary" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                <?php endif; ?>
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('permissions.delete')): ?>
                                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                                            onclick="confirmDelete(<?php echo e($permission->id); ?>, '<?php echo e($permission->name); ?>')" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </form>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted small">
                        Showing <?php echo e($permissions->firstItem()); ?> to <?php echo e($permissions->lastItem()); ?> of <?php echo e($permissions->total()); ?> entries
                    </div>
                    <div><?php echo e($permissions->links()); ?></div>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="fas fa-lock fa-3x text-muted mb-3"></i>
                    <h5>No permissions found</h5>
                    <p class="text-muted">
                        <?php if(request()->anyFilled(['search', 'group'])): ?>
                            No permissions match your filters. <a href="<?php echo e(route('admin.permissions.index')); ?>">Clear filters</a>
                        <?php else: ?>
                            No permissions exist. Generate them first.
                        <?php endif; ?>
                    </p>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('permissions.manage')): ?>
                        <a href="<?php echo e(route('admin.permissions.generate')); ?>" class="btn btn-warning">
                            <i class="fas fa-sync me-1"></i> Generate All Permissions
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
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

<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Permission</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete <strong id="deleteName"></strong>?</p>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    This will remove the permission from all roles.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-1"></i> Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
$(document).ready(function() {
    $('#selectAll').change(function() {
        $('.row-checkbox').prop('checked', $(this).prop('checked'));
    });
});

function confirmDelete(id, name) {
    $('#deleteName').text(name);
    $('#deleteForm').attr('action', `/admin/permissions/${id}`);
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\admin\permissions\index.blade.php ENDPATH**/ ?>