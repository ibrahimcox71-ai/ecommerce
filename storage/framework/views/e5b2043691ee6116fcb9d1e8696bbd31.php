<?php if (isset($component)) { $__componentOriginaledc75c655a063d12a477f2c8d8f324fc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc = $attributes; } ?>
<?php $component = App\View\Components\Layouts\AdminLayout::resolve(['title' => 'Tax Management'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div><h4 class="fw-bold mb-1">Tax Management</h4><p class="text-muted small mb-0">Manage tax groups, rates, and view tax collected</p></div>
    </div>

    <div class="row g-4">
        <div class="col-lg-5">
            <div class="card mb-4">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0">Tax Groups</h6>
                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createGroupModal"><i class="fas fa-plus me-1"></i> Add Group</button>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light"><tr><th>Name</th><th class="text-center">Rates</th><th>Status</th><th class="text-center">Actions</th></tr></thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td>
                                            <span class="fw-semibold"><?php echo e($group->name); ?></span>
                                            <?php if($group->is_default): ?><span class="badge bg-info ms-1">Default</span><?php endif; ?>
                                        </td>
                                        <td class="text-center"><?php echo e($group->tax_rates_count); ?></td>
                                        <td><span class="badge bg-<?php echo e($group->is_active ? 'success' : 'secondary'); ?>"><?php echo e($group->is_active ? 'Active' : 'Inactive'); ?></span></td>
                                        <td class="text-center">
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editGroupModal<?php echo e($group->id); ?>"><i class="fas fa-edit me-2"></i>Edit</a></li>
                                                    <li>
                                                        <form method="POST" action="<?php echo e(route('admin.finance.taxes.groups.destroy', $group->id)); ?>" class="d-inline">
                                                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                                            <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Delete this group?')"><i class="fas fa-trash me-2"></i>Delete</button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr><td colspan="4" class="text-center py-4 text-muted">No tax groups</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-transparent"><h6 class="fw-bold mb-0">Tax Summary</h6></div>
                <div class="card-body">
                    <div class="text-center">
                        <h2 class="fw-bold text-primary"><?php echo e(number_format($totalTaxCollected, 2)); ?></h2>
                        <p class="text-muted small">Total Tax Collected</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0">Tax Rates</h6>
                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createRateModal"><i class="fas fa-plus me-1"></i> Add Rate</button>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light"><tr><th>Name</th><th>Rate</th><th>Group</th><th>Region</th><th>Compound</th><th>Status</th><th class="text-center">Actions</th></tr></thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $rates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td class="fw-semibold"><?php echo e($rate->name); ?></td>
                                        <td><span class="badge bg-primary"><?php echo e($rate->rate); ?>%</span></td>
                                        <td><small><?php echo e($rate->taxGroup?->name); ?></small></td>
                                        <td><small><?php echo e($rate->region ?: '—'); ?></small></td>
                                        <td><?php echo $rate->is_compound ? '<span class="badge bg-info">Yes</span>' : '<span class="badge bg-secondary">No</span>'; ?></td>
                                        <td><span class="badge bg-<?php echo e($rate->is_active ? 'success' : 'secondary'); ?>"><?php echo e($rate->is_active ? 'Active' : 'Inactive'); ?></span></td>
                                        <td class="text-center">
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editRateModal<?php echo e($rate->id); ?>"><i class="fas fa-edit me-2"></i>Edit</a></li>
                                                    <li>
                                                        <form method="POST" action="<?php echo e(route('admin.finance.taxes.rates.destroy', $rate->id)); ?>" class="d-inline">
                                                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                                            <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Delete this rate?')"><i class="fas fa-trash me-2"></i>Delete</button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr><td colspan="7" class="text-center py-4 text-muted">No tax rates</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php if($rates->hasPages()): ?><div class="card-footer d-flex justify-content-center"><?php echo e($rates->withQueryString()->links()); ?></div><?php endif; ?>
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="createGroupModal" tabindex="-1">
        <div class="modal-dialog"><div class="modal-content">
            <form method="POST" action="<?php echo e(route('admin.finance.taxes.groups.store')); ?>">
                <?php echo csrf_field(); ?>
                <div class="modal-header"><h5 class="modal-title">Create Tax Group</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="mb-3"><label class="form-label">Name <span class="text-danger">*</span></label><input type="text" name="name" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="2"></textarea></div>
                    <div class="form-check mb-2"><input type="checkbox" name="is_active" class="form-check-input" value="1" checked><label class="form-check-label">Active</label></div>
                    <div class="form-check"><input type="checkbox" name="is_default" class="form-check-input" value="1"><label class="form-check-label">Set as Default</label></div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn btn-primary">Create</button></div>
            </form>
        </div></div>
    </div>

    
    <div class="modal fade" id="createRateModal" tabindex="-1">
        <div class="modal-dialog"><div class="modal-content">
            <form method="POST" action="<?php echo e(route('admin.finance.taxes.rates.store')); ?>">
                <?php echo csrf_field(); ?>
                <div class="modal-header"><h5 class="modal-title">Create Tax Rate</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="mb-3"><label class="form-label">Group <span class="text-danger">*</span></label>
                        <select name="tax_group_id" class="form-select" required>
                            <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($g->id); ?>"><?php echo e($g->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="mb-3"><label class="form-label">Name <span class="text-danger">*</span></label><input type="text" name="name" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label">Rate (%) <span class="text-danger">*</span></label><input type="number" name="rate" class="form-control" step="0.01" min="0" max="100" required></div>
                    <div class="mb-3"><label class="form-label">Region</label><input type="text" name="region" class="form-control" placeholder="e.g., US, EU, or leave blank"></div>
                    <div class="mb-3"><label class="form-label">Priority</label><input type="number" name="priority" class="form-control" value="0" min="0"></div>
                    <div class="form-check mb-2"><input type="checkbox" name="is_compound" class="form-check-input" value="1"><label class="form-check-label">Compound Tax</label></div>
                    <div class="form-check mb-2"><input type="checkbox" name="is_active" class="form-check-input" value="1" checked><label class="form-check-label">Active</label></div>
                    <div class="mb-3"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="2"></textarea></div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn btn-primary">Create</button></div>
            </form>
        </div></div>
    </div>

    
    <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="modal fade" id="editGroupModal<?php echo e($group->id); ?>" tabindex="-1">
        <div class="modal-dialog"><div class="modal-content">
            <form method="POST" action="<?php echo e(route('admin.finance.taxes.groups.update', $group->id)); ?>">
                <?php echo csrf_field(); ?>
                <div class="modal-header"><h5 class="modal-title">Edit Tax Group</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="mb-3"><label class="form-label">Name <span class="text-danger">*</span></label><input type="text" name="name" class="form-control" value="<?php echo e($group->name); ?>" required></div>
                    <div class="mb-3"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="2"><?php echo e($group->description); ?></textarea></div>
                    <div class="form-check mb-2"><input type="checkbox" name="is_active" class="form-check-input" value="1" <?php echo e($group->is_active ? 'checked' : ''); ?>><label class="form-check-label">Active</label></div>
                    <div class="form-check"><input type="checkbox" name="is_default" class="form-check-input" value="1" <?php echo e($group->is_default ? 'checked' : ''); ?>><label class="form-check-label">Set as Default</label></div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn btn-primary">Update</button></div>
            </form>
        </div></div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    
    <?php $__currentLoopData = $rates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="modal fade" id="editRateModal<?php echo e($rate->id); ?>" tabindex="-1">
        <div class="modal-dialog"><div class="modal-content">
            <form method="POST" action="<?php echo e(route('admin.finance.taxes.rates.update', $rate->id)); ?>">
                <?php echo csrf_field(); ?>
                <div class="modal-header"><h5 class="modal-title">Edit Tax Rate</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="mb-3"><label class="form-label">Group <span class="text-danger">*</span></label>
                        <select name="tax_group_id" class="form-select" required>
                            <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($g->id); ?>" <?php echo e($rate->tax_group_id === $g->id ? 'selected' : ''); ?>><?php echo e($g->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="mb-3"><label class="form-label">Name <span class="text-danger">*</span></label><input type="text" name="name" class="form-control" value="<?php echo e($rate->name); ?>" required></div>
                    <div class="mb-3"><label class="form-label">Rate (%) <span class="text-danger">*</span></label><input type="number" name="rate" class="form-control" step="0.01" min="0" max="100" value="<?php echo e($rate->rate); ?>" required></div>
                    <div class="mb-3"><label class="form-label">Region</label><input type="text" name="region" class="form-control" value="<?php echo e($rate->region); ?>"></div>
                    <div class="mb-3"><label class="form-label">Priority</label><input type="number" name="priority" class="form-control" value="<?php echo e($rate->priority); ?>" min="0"></div>
                    <div class="form-check mb-2"><input type="checkbox" name="is_compound" class="form-check-input" value="1" <?php echo e($rate->is_compound ? 'checked' : ''); ?>><label class="form-check-label">Compound Tax</label></div>
                    <div class="form-check mb-2"><input type="checkbox" name="is_active" class="form-check-input" value="1" <?php echo e($rate->is_active ? 'checked' : ''); ?>><label class="form-check-label">Active</label></div>
                    <div class="mb-3"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="2"><?php echo e($rate->description); ?></textarea></div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn btn-primary">Update</button></div>
            </form>
        </div></div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
<?php /**PATH C:\laragon\www\ecommerce\resources\views\admin\finance\taxes\index.blade.php ENDPATH**/ ?>