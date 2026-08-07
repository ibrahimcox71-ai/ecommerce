<?php if (isset($component)) { $__componentOriginaledc75c655a063d12a477f2c8d8f324fc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc = $attributes; } ?>
<?php $component = App\View\Components\Layouts\AdminLayout::resolve(['title' => 'Journal Entry '.e($entry->entry_number).''] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1"><?php echo e($entry->entry_number); ?></h4>
            <p class="text-muted small mb-0">
                <span class="badge bg-<?php echo e($entry->type === 'standard' ? 'primary' : ($entry->type === 'adjusting' ? 'warning' : ($entry->type === 'closing' ? 'danger' : ($entry->type === 'reversing' ? 'info' : 'secondary')))); ?>"><?php echo e(ucfirst($entry->type)); ?></span>
                <?php if($entry->is_posted): ?><span class="badge bg-success ms-1">Posted</span><?php else: ?><span class="badge bg-warning text-dark ms-1">Draft</span><?php endif; ?>
            </p>
        </div>
        <div class="d-flex gap-2">
            <?php if(!$entry->is_posted): ?>
                <a href="<?php echo e(route('admin.finance.journal-entries.edit', $entry->id)); ?>" class="btn btn-outline-primary"><i class="fas fa-edit me-1"></i> Edit</a>
                <form method="POST" action="<?php echo e(route('admin.finance.journal-entries.post', $entry->id)); ?>" class="d-inline">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn btn-success" onclick="return confirm('Post this entry?')"><i class="fas fa-check-circle me-1"></i> Post</button>
                </form>
            <?php else: ?>
                <form method="POST" action="<?php echo e(route('admin.finance.journal-entries.reverse', $entry->id)); ?>" class="d-inline">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn btn-warning" onclick="return confirm('Create a reversing entry?')"><i class="fas fa-undo me-1"></i> Reverse</button>
                </form>
            <?php endif; ?>
            <a href="<?php echo e(route('admin.finance.journal-entries.index')); ?>" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i> Back</a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-transparent"><h6 class="fw-bold mb-0">Entry Lines</h6></div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <thead class="table-light">
                                <tr><th>Account Code</th><th>Account Name</th><th>Description</th><th class="text-end">Debit</th><th class="text-end">Credit</th></tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $entry->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($item->chartOfAccount?->code); ?></td>
                                        <td><?php echo e($item->chartOfAccount?->name); ?></td>
                                        <td><small><?php echo e($item->description ?: '—'); ?></small></td>
                                        <td class="text-end"><?php echo e($item->debit > 0 ? number_format($item->debit, 2) : '—'); ?></td>
                                        <td class="text-end"><?php echo e($item->credit > 0 ? number_format($item->credit, 2) : '—'); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                            <tfoot>
                                <tr class="table-active fw-bold">
                                    <td colspan="3" class="text-end">Totals:</td>
                                    <td class="text-end"><?php echo e(number_format($entry->total_debit, 2)); ?></td>
                                    <td class="text-end"><?php echo e(number_format($entry->total_credit, 2)); ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header bg-transparent"><h6 class="fw-bold mb-0">Details</h6></div>
                <div class="card-body">
                    <div class="mb-3"><label class="text-muted small text-uppercase">Entry Date</label><p class="fw-semibold mb-0"><?php echo e($entry->entry_date?->format('d M, Y')); ?></p></div>
                    <?php if($entry->description): ?>
                    <div class="mb-3"><label class="text-muted small text-uppercase">Description</label><p class="mb-0"><?php echo e($entry->description); ?></p></div>
                    <?php endif; ?>
                    <?php if($entry->financePeriod): ?>
                    <div class="mb-3"><label class="text-muted small text-uppercase">Period</label><p class="mb-0"><?php echo e($entry->financePeriod->name); ?></p></div>
                    <?php endif; ?>
                    <div class="mb-3"><label class="text-muted small text-uppercase">Created By</label><p class="mb-0"><?php echo e($entry->creator?->name ?? '—'); ?></p></div>
                    <?php if($entry->is_posted): ?>
                    <div class="mb-3"><label class="text-muted small text-uppercase">Posted By</label><p class="mb-0"><?php echo e($entry->postedBy?->name ?? '—'); ?></p></div>
                    <div class="mb-3"><label class="text-muted small text-uppercase">Posted At</label><p class="mb-0"><?php echo e($entry->posted_at?->format('d M Y, h:i A')); ?></p></div>
                    <?php endif; ?>
                </div>
            </div>
            <?php if($entry->notes): ?>
            <div class="card">
                <div class="card-header bg-transparent"><h6 class="fw-bold mb-0">Notes</h6></div>
                <div class="card-body"><p class="small mb-0"><?php echo e($entry->notes); ?></p></div>
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
<?php /**PATH C:\laragon\www\ecommerce\resources\views\admin\finance\journal-entries\show.blade.php ENDPATH**/ ?>