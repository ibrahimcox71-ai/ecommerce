<?php if (isset($component)) { $__componentOriginaledc75c655a063d12a477f2c8d8f324fc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc = $attributes; } ?>
<?php $component = App\View\Components\Layouts\AdminLayout::resolve(['title' => ''.e($supplier->name).''] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1"><?php echo e($supplier->name); ?></h4>
            <p class="text-muted small mb-0">
                <span class="badge bg-dark me-1"><?php echo e($supplier->supplier_code); ?></span>
                Supplier details and purchase information
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="<?php echo e(route('admin.suppliers.edit', $supplier->id)); ?>" class="btn btn-primary">
                <i class="fas fa-edit me-1"></i> Edit
            </a>
            <a href="<?php echo e(route('admin.suppliers.index')); ?>" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            
            <div class="card mb-4">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Basic Information</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small text-uppercase">Company Name</label>
                            <p class="fw-semibold mb-0"><?php echo e($supplier->company_name ?: '—'); ?></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small text-uppercase">Contact Person</label>
                            <p class="fw-semibold mb-0"><?php echo e($supplier->contact_person ?: '—'); ?></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small text-uppercase">Email</label>
                            <p class="fw-semibold mb-0">
                                <?php if($supplier->email): ?>
                                    <a href="mailto:<?php echo e($supplier->email); ?>"><?php echo e($supplier->email); ?></a>
                                <?php else: ?>
                                    —
                                <?php endif; ?>
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small text-uppercase">Phone</label>
                            <p class="fw-semibold mb-0">
                                <?php if($supplier->phone): ?>
                                    <a href="tel:<?php echo e($supplier->phone); ?>"><?php echo e($supplier->phone); ?></a>
                                <?php else: ?>
                                    —
                                <?php endif; ?>
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small text-uppercase">Alternative Phone</label>
                            <p class="fw-semibold mb-0"><?php echo e($supplier->alternative_phone ?: '—'); ?></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small text-uppercase">Website</label>
                            <p class="fw-semibold mb-0">
                                <?php if($supplier->website): ?>
                                    <a href="<?php echo e($supplier->website); ?>" target="_blank" rel="noopener">
                                        <i class="fas fa-external-link-alt me-1"></i><?php echo e($supplier->website); ?>

                                    </a>
                                <?php else: ?>
                                    —
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                    <?php if($supplier->description): ?>
                        <div class="mb-0">
                            <label class="text-muted small text-uppercase">Description</label>
                            <p class="mb-0"><?php echo e($supplier->description); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            
            <div class="card mb-4">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Business Registration</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small text-uppercase">Trade License Number</label>
                            <p class="fw-semibold mb-0"><?php echo e($supplier->trade_license_number ?: '—'); ?></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small text-uppercase">Tax / VAT Number</label>
                            <p class="fw-semibold mb-0"><?php echo e($supplier->tax_vat_number ?: '—'); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="card mb-4">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Address</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="text-muted small text-uppercase">Country</label>
                            <p class="fw-semibold mb-0"><?php echo e($supplier->country ?: '—'); ?></p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="text-muted small text-uppercase">State</label>
                            <p class="fw-semibold mb-0"><?php echo e($supplier->state ?: '—'); ?></p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="text-muted small text-uppercase">City</label>
                            <p class="fw-semibold mb-0"><?php echo e($supplier->city ?: '—'); ?></p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="text-muted small text-uppercase">Postal Code</label>
                            <p class="fw-semibold mb-0"><?php echo e($supplier->postal_code ?: '—'); ?></p>
                        </div>
                    </div>
                    <?php if($supplier->full_address): ?>
                        <div class="mb-0">
                            <label class="text-muted small text-uppercase">Full Address</label>
                            <p class="mb-0"><?php echo e($supplier->full_address); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            
            <div class="card mb-4">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Purchase Information</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="text-muted small text-uppercase">Payment Terms</label>
                            <p class="fw-semibold mb-0"><?php echo e($supplier->payment_terms ?: '—'); ?></p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="text-muted small text-uppercase">Credit Limit</label>
                            <p class="fw-semibold mb-0">
                                <?php if($supplier->credit_limit): ?>
                                    $<?php echo e(number_format($supplier->credit_limit, 2)); ?>

                                <?php else: ?>
                                    —
                                <?php endif; ?>
                            </p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="text-muted small text-uppercase">Currency</label>
                            <p class="fw-semibold mb-0"><?php echo e($supplier->currency); ?></p>
                        </div>
                    </div>
                    <?php if($supplier->bank_information): ?>
                        <div class="mb-3">
                            <label class="text-muted small text-uppercase">Bank Information</label>
                            <p class="mb-0"><?php echo e($supplier->bank_information); ?></p>
                        </div>
                    <?php endif; ?>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="text-muted small text-uppercase">Outstanding Balance</label>
                            <h4 class="fw-bold <?php echo e($supplier->outstanding_balance > 0 ? 'text-danger' : 'text-success'); ?> mb-0">
                                $<?php echo e(number_format($supplier->outstanding_balance, 2)); ?>

                            </h4>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small text-uppercase">Last Purchase Date</label>
                            <p class="fw-semibold mb-0">
                                <?php if($supplier->last_purchase_date): ?>
                                    <?php echo e($supplier->last_purchase_date->format('F d, Y')); ?>

                                <?php else: ?>
                                    No purchases yet
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="card">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Activity Log</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm mb-0">
                            <thead>
                                <tr>
                                    <th>Action</th>
                                    <th>Description</th>
                                    <th>By</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $supplier->activityLogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td>
                                            <span class="badge bg-info"><?php echo e($log->description); ?></span>
                                        </td>
                                        <td class="small"><?php echo e($log->description); ?></td>
                                        <td class="small"><?php echo e($log->causer?->name ?? 'System'); ?></td>
                                        <td class="small text-muted"><?php echo e($log->created_at->diffForHumans()); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-3">No activity recorded</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            
            <div class="card mb-4">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Supplier Logo</h6>
                </div>
                <div class="card-body text-center">
                    <?php if($supplier->logo): ?>
                        <img src="<?php echo e($supplier->logo_url); ?>" alt="<?php echo e($supplier->name); ?>"
                             class="img-fluid rounded" style="max-height: 150px;">
                    <?php else: ?>
                        <div class="py-4">
                            <i class="fas fa-truck fa-4x text-muted"></i>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            
            <div class="card mb-4">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Status</h6>
                </div>
                <div class="card-body">
                    <?php
                        $statusColors = ['active' => 'success', 'inactive' => 'secondary', 'blacklisted' => 'danger'];
                        $statusIcons = ['active' => 'fa-check-circle', 'inactive' => 'fa-pause-circle', 'blacklisted' => 'fa-ban'];
                        $color = $statusColors[$supplier->status->value] ?? 'secondary';
                        $icon = $statusIcons[$supplier->status->value] ?? 'fa-circle';
                    ?>
                    <div class="text-center mb-3">
                        <span class="badge bg-<?php echo e($color); ?> fs-6 px-3 py-2">
                            <i class="fas <?php echo e($icon); ?> me-1"></i><?php echo e($supplier->status->label()); ?>

                        </span>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted">Supplier Code</span>
                        <span class="fw-semibold"><?php echo e($supplier->supplier_code); ?></span>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted">Total Products</span>
                        <span class="badge bg-primary rounded-pill"><?php echo e($supplier->products_count); ?></span>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted">Outstanding</span>
                        <span class="fw-semibold text-danger">$<?php echo e(number_format($supplier->outstanding_balance, 2)); ?></span>
                    </div>
                    <div class="d-flex justify-content-between py-2">
                        <span class="text-muted">Member Since</span>
                        <span class="fw-semibold"><?php echo e($supplier->created_at->format('M Y')); ?></span>
                    </div>
                </div>
            </div>

            
            <div class="d-grid gap-2">
                <a href="<?php echo e(route('admin.suppliers.edit', $supplier->id)); ?>" class="btn btn-primary">
                    <i class="fas fa-edit me-2"></i> Edit Supplier
                </a>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('suppliers.delete')): ?>
                    <button type="button" class="btn btn-outline-danger" onclick="quickDelete()">
                        <i class="fas fa-trash me-2"></i> Delete Supplier
                    </button>
                <?php endif; ?>
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

<?php $__env->startPush('scripts'); ?>
<script>
function quickDelete() {
    if (confirm('Are you sure you want to delete <?php echo e($supplier->name); ?>?')) {
        $('<form>').attr({ method: 'POST', action: '<?php echo e(route('admin.suppliers.destroy', $supplier->id)); ?>' })
            .append($('<input>').attr({ type: 'hidden', name: '_token', value: '<?php echo e(csrf_token()); ?>' }))
            .append($('<input>').attr({ type: 'hidden', name: '_method', value: 'DELETE' }))
            .appendTo('body').submit();
    }
}
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\admin\suppliers\show.blade.php ENDPATH**/ ?>