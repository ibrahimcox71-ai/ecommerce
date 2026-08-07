<?php if (isset($component)) { $__componentOriginaledc75c655a063d12a477f2c8d8f324fc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc = $attributes; } ?>
<?php $component = App\View\Components\Layouts\AdminLayout::resolve(['title' => 'Chart of Accounts'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Chart of Accounts</h4>
            <p class="text-muted small mb-0">Manage your accounting chart of accounts</p>
        </div>
        <a href="<?php echo e(route('admin.finance.accounts.create')); ?>" class="btn btn-primary"><i class="fas fa-plus me-1"></i> Create Account</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="GET" class="row g-2 mb-3">
                <div class="col-md-4"><input type="text" name="search" class="form-control" placeholder="Search by name or code..." value="<?php echo e($filters['search'] ?? ''); ?>"></div>
                <div class="col-md-3">
                    <select name="type" class="form-select">
                        <option value="">All Types</option>
                        <?php $__currentLoopData = ['asset','liability','equity','revenue','expense','contra_asset','contra_liability','contra_equity','contra_revenue','contra_expense']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($type); ?>" <?php echo e(($filters['type'] ?? '') === $type ? 'selected' : ''); ?>><?php echo e(ucwords(str_replace('_', ' ', $type))); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="is_active" class="form-select">
                        <option value="">All Status</option>
                        <option value="1" <?php echo e(($filters['is_active'] ?? '') === '1' ? 'selected' : ''); ?>>Active</option>
                        <option value="0" <?php echo e(($filters['is_active'] ?? '') === '0' ? 'selected' : ''); ?>>Inactive</option>
                    </select>
                </div>
                <div class="col-md-1"><button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i></button></div>
                <div class="col-md-2"><a href="<?php echo e(route('admin.finance.accounts.index')); ?>" class="btn btn-outline-secondary w-100">Reset</a></div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr><th>Code</th><th>Name</th><th>Type</th><th>Normal</th><th class="text-end">Balance</th><th>Status</th><th class="text-center">Actions</th></tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><span class="fw-semibold"><?php echo e($account->code); ?></span></td>
                                <td>
                                    <a href="<?php echo e(route('admin.finance.accounts.show', $account->id)); ?>" class="text-decoration-none fw-semibold">
                                        <?php echo e($account->name); ?>

                                    </a>
                                    <?php if($account->parent): ?><br><small class="text-muted"><?php echo e($account->parent->name); ?></small><?php endif; ?>
                                </td>
                                <td><span class="badge bg-info"><?php echo e(ucwords(str_replace('_', ' ', $account->type))); ?></span></td>
                                <td><small><?php echo e(ucfirst($account->normal_balance)); ?></small></td>
                                <td class="text-end fw-semibold"><?php echo e(number_format($account->current_balance, 2)); ?></td>
                                <td>
                                    <span class="badge bg-<?php echo e($account->is_active ? 'success' : 'secondary'); ?>">
                                        <?php echo e($account->is_active ? 'Active' : 'Inactive'); ?>

                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item" href="<?php echo e(route('admin.finance.accounts.show', $account->id)); ?>"><i class="fas fa-eye me-2"></i>View</a></li>
                                            <li><a class="dropdown-item" href="<?php echo e(route('admin.finance.accounts.edit', $account->id)); ?>"><i class="fas fa-edit me-2"></i>Edit</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form method="POST" action="<?php echo e(route('admin.finance.accounts.toggle-status', $account->id)); ?>" class="d-inline">
                                                    <?php echo csrf_field(); ?>
                                                    <button type="submit" class="dropdown-item"><?php echo e($account->is_active ? 'Deactivate' : 'Activate'); ?></button>
                                                </form>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form method="POST" action="<?php echo e(route('admin.finance.accounts.destroy', $account->id)); ?>" class="d-inline">
                                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Delete this account?')"><i class="fas fa-trash me-2"></i>Delete</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="7" class="text-center py-5 text-muted"><i class="fas fa-book fa-3x mb-3 d-block"></i>No accounts found</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-3"><?php echo e($accounts->withQueryString()->links()); ?></div>
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
<?php /**PATH C:\laragon\www\ecommerce\resources\views\admin\finance\accounts\index.blade.php ENDPATH**/ ?>