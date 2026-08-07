<?php if (isset($component)) { $__componentOriginaledc75c655a063d12a477f2c8d8f324fc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc = $attributes; } ?>
<?php $component = App\View\Components\Layouts\AdminLayout::resolve(['title' => 'Account Details'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1"><?php echo e($account->code); ?> - <?php echo e($account->name); ?></h4>
            <p class="text-muted small mb-0">
                <span class="badge bg-info"><?php echo e(ucwords(str_replace('_', ' ', $account->type))); ?></span>
                <span class="badge bg-<?php echo e($account->is_active ? 'success' : 'secondary'); ?>"><?php echo e($account->is_active ? 'Active' : 'Inactive'); ?></span>
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="<?php echo e(route('admin.finance.accounts.edit', $account->id)); ?>" class="btn btn-outline-primary"><i class="fas fa-edit me-1"></i> Edit</a>
            <a href="<?php echo e(route('admin.finance.accounts.index')); ?>" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i> Back</a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header bg-transparent"><h6 class="fw-bold mb-0">Account Info</h6></div>
                <div class="card-body">
                    <div class="mb-3"><label class="text-muted small text-uppercase">Code</label><p class="fw-semibold mb-0"><?php echo e($account->code); ?></p></div>
                    <div class="mb-3"><label class="text-muted small text-uppercase">Type</label><p class="fw-semibold mb-0"><?php echo e(ucwords(str_replace('_', ' ', $account->type))); ?></p></div>
                    <div class="mb-3"><label class="text-muted small text-uppercase">Normal Balance</label><p class="fw-semibold mb-0"><?php echo e(ucfirst($account->normal_balance)); ?></p></div>
                    <div class="mb-3"><label class="text-muted small text-uppercase">Parent</label><p class="fw-semibold mb-0"><?php echo e($account->parent?->name ?? '—'); ?></p></div>
                    <?php if($account->description): ?><div class="mb-3"><label class="text-muted small text-uppercase">Description</label><p class="mb-0"><?php echo e($account->description); ?></p></div><?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header bg-transparent"><h6 class="fw-bold mb-0">Balance Summary</h6></div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="card bg-light"><div class="card-body text-center py-3"><small class="text-muted">Opening Balance</small><h5 class="mb-0 fw-bold"><?php echo e(number_format($account->opening_balance, 2)); ?></h5></div></div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-primary-subtle"><div class="card-body text-center py-3"><small class="text-muted">Current Balance</small><h5 class="mb-0 fw-bold text-primary"><?php echo e(number_format($account->current_balance, 2)); ?></h5></div></div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-info-subtle"><div class="card-body text-center py-3"><small class="text-muted">Total Balance</small><h5 class="mb-0 fw-bold text-info"><?php echo e(number_format($account->opening_balance + $account->current_balance, 2)); ?></h5></div></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-transparent"><h6 class="fw-bold mb-0">Recent Journal Entries</h6></div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light"><tr><th>Entry #</th><th>Date</th><th class="text-end">Debit</th><th class="text-end">Credit</th><th>Description</th></tr></thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $account->journalEntryItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><a href="<?php echo e(route('admin.finance.journal-entries.show', $item->journal_entry_id)); ?>" class="text-decoration-none"><?php echo e($item->journalEntry?->entry_number); ?></a></td>
                                        <td><small><?php echo e($item->journalEntry?->entry_date?->format('d/m/Y')); ?></small></td>
                                        <td class="text-end"><?php echo e($item->debit > 0 ? number_format($item->debit, 2) : '—'); ?></td>
                                        <td class="text-end"><?php echo e($item->credit > 0 ? number_format($item->credit, 2) : '—'); ?></td>
                                        <td><small><?php echo e($item->description ?: '—'); ?></small></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr><td colspan="5" class="text-center py-4 text-muted">No journal entries for this account</td></tr>
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
<?php /**PATH C:\laragon\www\ecommerce\resources\views\admin\finance\accounts\show.blade.php ENDPATH**/ ?>