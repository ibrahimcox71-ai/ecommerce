<?php if (isset($component)) { $__componentOriginaledc75c655a063d12a477f2c8d8f324fc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc = $attributes; } ?>
<?php $component = App\View\Components\Layouts\AdminLayout::resolve(['title' => 'Journal Entries'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div><h4 class="fw-bold mb-1">Journal Entries</h4><p class="text-muted small mb-0">Manage accounting journal entries</p></div>
        <a href="<?php echo e(route('admin.finance.journal-entries.create')); ?>" class="btn btn-primary"><i class="fas fa-plus me-1"></i> New Entry</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="GET" class="row g-2 mb-3">
                <div class="col-md-3"><input type="text" name="search" class="form-control" placeholder="Search entry number..." value="<?php echo e($filters['search'] ?? ''); ?>"></div>
                <div class="col-md-2">
                    <select name="type" class="form-select">
                        <option value="">All Types</option>
                        <?php $__currentLoopData = ['standard','adjusting','closing','reversing','opening']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($type); ?>" <?php echo e(($filters['type'] ?? '') === $type ? 'selected' : ''); ?>><?php echo e(ucfirst($type)); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="is_posted" class="form-select">
                        <option value="">All Status</option>
                        <option value="posted" <?php echo e(($filters['is_posted'] ?? '') === 'posted' ? 'selected' : ''); ?>>Posted</option>
                        <option value="draft" <?php echo e(($filters['is_posted'] ?? '') === 'draft' ? 'selected' : ''); ?>>Draft</option>
                    </select>
                </div>
                <div class="col-md-2"><input type="date" name="date_from" class="form-control" value="<?php echo e($filters['date_from'] ?? ''); ?>" placeholder="From"></div>
                <div class="col-md-2"><input type="date" name="date_to" class="form-control" value="<?php echo e($filters['date_to'] ?? ''); ?>" placeholder="To"></div>
                <div class="col-md-1"><button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i></button></div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr><th>Entry #</th><th>Type</th><th>Description</th><th class="text-end">Debit</th><th class="text-end">Credit</th><th>Date</th><th>Status</th><th class="text-center">Actions</th></tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $entries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><a href="<?php echo e(route('admin.finance.journal-entries.show', $entry->id)); ?>" class="fw-semibold text-decoration-none"><?php echo e($entry->entry_number); ?></a></td>
                                <td><span class="badge bg-<?php echo e($entry->type === 'standard' ? 'primary' : ($entry->type === 'adjusting' ? 'warning' : ($entry->type === 'closing' ? 'danger' : ($entry->type === 'reversing' ? 'info' : 'secondary')))); ?>"><?php echo e(ucfirst($entry->type)); ?></span></td>
                                <td><small><?php echo e(Str::limit($entry->description, 40) ?: '—'); ?></small></td>
                                <td class="text-end"><?php echo e(number_format($entry->total_debit, 2)); ?></td>
                                <td class="text-end"><?php echo e(number_format($entry->total_credit, 2)); ?></td>
                                <td><small><?php echo e($entry->entry_date?->format('d/m/Y')); ?></small></td>
                                <td>
                                    <?php if($entry->is_posted): ?>
                                        <span class="badge bg-success">Posted</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark">Draft</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item" href="<?php echo e(route('admin.finance.journal-entries.show', $entry->id)); ?>"><i class="fas fa-eye me-2"></i>View</a></li>
                                            <?php if(!$entry->is_posted): ?>
                                                <li><a class="dropdown-item" href="<?php echo e(route('admin.finance.journal-entries.edit', $entry->id)); ?>"><i class="fas fa-edit me-2"></i>Edit</a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <form method="POST" action="<?php echo e(route('admin.finance.journal-entries.post', $entry->id)); ?>" class="d-inline">
                                                        <?php echo csrf_field(); ?>
                                                        <button type="submit" class="dropdown-item text-success"><i class="fas fa-check-circle me-2"></i>Post</button>
                                                    </form>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <form method="POST" action="<?php echo e(route('admin.finance.journal-entries.destroy', $entry->id)); ?>" class="d-inline">
                                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                                        <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Delete this entry?')"><i class="fas fa-trash me-2"></i>Delete</button>
                                                    </form>
                                                </li>
                                            <?php else: ?>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <form method="POST" action="<?php echo e(route('admin.finance.journal-entries.reverse', $entry->id)); ?>" class="d-inline">
                                                        <?php echo csrf_field(); ?>
                                                        <button type="submit" class="dropdown-item text-warning" onclick="return confirm('Reverse this entry? This will create a reversing entry.')"><i class="fas fa-undo me-2"></i>Reverse</button>
                                                    </form>
                                                </li>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="8" class="text-center py-5 text-muted"><i class="fas fa-journal-whills fa-3x mb-3 d-block"></i>No journal entries found</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-3"><?php echo e($entries->withQueryString()->links()); ?></div>
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
<?php /**PATH C:\laragon\www\ecommerce\resources\views\admin\finance\journal-entries\index.blade.php ENDPATH**/ ?>