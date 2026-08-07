<?php if (isset($component)) { $__componentOriginaledc75c655a063d12a477f2c8d8f324fc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc = $attributes; } ?>
<?php $component = App\View\Components\Layouts\AdminLayout::resolve(['title' => 'Recurring Expenses'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <?php if (isset($component)) { $__componentOriginalf004a19b46f034c7c5fdb76a3638f50e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf004a19b46f034c7c5fdb76a3638f50e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.crud-header','data' => ['title' => 'Recurring Expenses','subtitle' => 'Manage recurring/predictable expenses','buttons' => [
            ['label' => 'Add Recurring Expense', 'route' => 'admin.finance.recurring-expenses.create', 'icon' => 'bi bi-plus-lg'],
        ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.crud-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Recurring Expenses','subtitle' => 'Manage recurring/predictable expenses','buttons' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
            ['label' => 'Add Recurring Expense', 'route' => 'admin.finance.recurring-expenses.create', 'icon' => 'bi bi-plus-lg'],
        ])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf004a19b46f034c7c5fdb76a3638f50e)): ?>
<?php $attributes = $__attributesOriginalf004a19b46f034c7c5fdb76a3638f50e; ?>
<?php unset($__attributesOriginalf004a19b46f034c7c5fdb76a3638f50e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf004a19b46f034c7c5fdb76a3638f50e)): ?>
<?php $component = $__componentOriginalf004a19b46f034c7c5fdb76a3638f50e; ?>
<?php unset($__componentOriginalf004a19b46f034c7c5fdb76a3638f50e); ?>
<?php endif; ?>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Category</th>
                            <th>Amount</th>
                            <th>Interval</th>
                            <th>Payee</th>
                            <th>Next Due</th>
                            <th>Occurrences</th>
                            <th>Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $recurrings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($r->category?->name ?? '—'); ?></td>
                                <td class="fw-semibold"><?php echo e(number_format($r->amount, 2)); ?></td>
                                <td><?php echo e(ucwords(str_replace('_', ' ', $r->interval))); ?></td>
                                <td><?php echo e($r->payee ?? '—'); ?></td>
                                <td><?php echo e($r->next_due_date?->format('d/m/Y') ?? '—'); ?></td>
                                <td><?php echo e($r->occurrences); ?>/<?php echo e($r->max_occurrences ?? '∞'); ?></td>
                                <td>
                                    <span class="badge bg-<?php echo e($r->isActive() ? 'success' : ($r->status === 'paused' ? 'warning' : 'secondary')); ?>">
                                        <?php echo e(ucfirst($r->status)); ?>

                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="<?php echo e(route('admin.finance.recurring-expenses.edit', $r->id)); ?>" class="btn btn-sm btn-outline-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                                    <form method="POST" action="<?php echo e(route('admin.finance.recurring-expenses.toggle-status', $r->id)); ?>" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="btn btn-sm btn-outline-<?php echo e($r->isActive() ? 'warning' : 'success'); ?>"
                                                title="<?php echo e($r->isActive() ? 'Pause' : 'Activate'); ?>">
                                            <i class="bi bi-<?php echo e($r->isActive() ? 'pause' : 'play'); ?>"></i>
                                        </button>
                                    </form>
                                    <form method="POST" action="<?php echo e(route('admin.finance.recurring-expenses.destroy', $r->id)); ?>" class="d-inline" onsubmit="return confirm('Cancel this recurring expense?')">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Cancel"><i class="bi bi-x-lg"></i></button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="8">
                                    <?php if (isset($component)) { $__componentOriginal99089f8e2ef4184d7d35db81d60c6521 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal99089f8e2ef4184d7d35db81d60c6521 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.empty-state','data' => ['icon' => 'bi bi-arrow-repeat','message' => 'No recurring expenses found.','buttonLabel' => 'Add Recurring Expense','buttonRoute' => 'admin.finance.recurring-expenses.create']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.empty-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'bi bi-arrow-repeat','message' => 'No recurring expenses found.','buttonLabel' => 'Add Recurring Expense','buttonRoute' => 'admin.finance.recurring-expenses.create']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal99089f8e2ef4184d7d35db81d60c6521)): ?>
<?php $attributes = $__attributesOriginal99089f8e2ef4184d7d35db81d60c6521; ?>
<?php unset($__attributesOriginal99089f8e2ef4184d7d35db81d60c6521); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal99089f8e2ef4184d7d35db81d60c6521)): ?>
<?php $component = $__componentOriginal99089f8e2ef4184d7d35db81d60c6521; ?>
<?php unset($__componentOriginal99089f8e2ef4184d7d35db81d60c6521); ?>
<?php endif; ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php if($recurrings->hasPages()): ?><div class="card-footer d-flex justify-content-center"><?php echo e($recurrings->links()); ?></div><?php endif; ?>
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
<?php /**PATH C:\laragon\www\ecommerce\resources\views\admin\finance\recurring-expenses\index.blade.php ENDPATH**/ ?>