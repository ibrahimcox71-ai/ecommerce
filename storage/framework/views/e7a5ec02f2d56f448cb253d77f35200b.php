<?php if (isset($component)) { $__componentOriginaledc75c655a063d12a477f2c8d8f324fc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc = $attributes; } ?>
<?php $component = App\View\Components\Layouts\AdminLayout::resolve(['title' => 'Warehouse Details'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1"><?php echo e($warehouse->name); ?></h4>
            <p class="text-muted small mb-0">Warehouse details and inventory summary</p>
        </div>
        <div class="d-flex gap-2">
            <a href="<?php echo e(route('admin.warehouses.edit', $warehouse->id)); ?>" class="btn btn-primary">
                <i class="fas fa-edit me-1"></i> Edit
            </a>
            <a href="<?php echo e(route('admin.warehouses.index')); ?>" class="btn btn-outline-secondary">
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
                        <div class="col-md-6">
                            <dl class="mb-0">
                                <dt class="text-muted small">Name</dt>
                                <dd class="fw-semibold"><?php echo e($warehouse->name); ?></dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <dl class="mb-0">
                                <dt class="text-muted small">Code</dt>
                                <dd><code><?php echo e($warehouse->code); ?></code></dd>
                            </dl>
                        </div>
                    </div>
                    <?php if($warehouse->manager_name): ?>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <dl class="mb-0">
                                    <dt class="text-muted small">Warehouse Manager</dt>
                                    <dd class="fw-semibold"><?php echo e($warehouse->manager_name); ?></dd>
                                </dl>
                            </div>
                        </div>
                    <?php endif; ?>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <dl class="mb-0">
                                <dt class="text-muted small">Address</dt>
                                <dd><?php echo e($warehouse->address ?: 'Not set'); ?></dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <dl class="mb-0">
                                <dt class="text-muted small">City, State</dt>
                                <dd><?php echo e($warehouse->city ?: '—'); ?><?php echo e($warehouse->city && $warehouse->state ? ', ' : ''); ?><?php echo e($warehouse->state ?: ''); ?></dd>
                            </dl>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <dl class="mb-0">
                                <dt class="text-muted small">Country</dt>
                                <dd><?php echo e($warehouse->country ?: 'Not set'); ?></dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <dl class="mb-0">
                                <dt class="text-muted small">Postal Code</dt>
                                <dd><?php echo e($warehouse->postal_code ?: 'Not set'); ?></dd>
                            </dl>
                        </div>
                    </div>
                    <?php if($warehouse->phone || $warehouse->email): ?>
                        <hr>
                        <div class="row">
                            <?php if($warehouse->phone): ?>
                                <div class="col-md-6">
                                    <dl class="mb-0">
                                        <dt class="text-muted small">Phone</dt>
                                        <dd><?php echo e($warehouse->phone); ?></dd>
                                    </dl>
                                </div>
                            <?php endif; ?>
                            <?php if($warehouse->email): ?>
                                <div class="col-md-6">
                                    <dl class="mb-0">
                                        <dt class="text-muted small">Email</dt>
                                        <dd><?php echo e($warehouse->email); ?></dd>
                                    </dl>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Recent Stock Movements</h6>
                </div>
                <div class="card-body p-0">
                    <?php if($recentMovements->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0 ps-4">Reference</th>
                                        <th class="border-0">Product</th>
                                        <th class="border-0 text-center">Type</th>
                                        <th class="border-0 text-center">Qty</th>
                                        <th class="border-0 pe-4">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $recentMovements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="ps-4"><code class="small"><?php echo e($m->reference_number); ?></code></td>
                                            <td><span class="small"><?php echo e($m->product?->name ?? '—'); ?></span></td>
                                            <td class="text-center">
                                                <span class="badge bg-<?php echo e($m->movement_type === 'stock_in' ? 'success' : ($m->movement_type === 'stock_out' ? 'danger' : 'info')); ?>">
                                                    <?php echo e(ucfirst(str_replace('_', ' ', $m->movement_type))); ?>

                                                </span>
                                            </td>
                                            <td class="text-center fw-semibold"><?php echo e(number_format($m->quantity)); ?></td>
                                            <td class="pe-4 text-muted small"><?php echo e($m->created_at->format('M d, H:i')); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-exchange-alt fa-2x mb-2"></i>
                            <p class="mb-0">No recent movements</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Status</h6>
                </div>
                <div class="card-body text-center">
                    <div class="d-flex justify-content-center gap-2 mb-0">
                        <?php if($warehouse->status): ?>
                            <span class="badge bg-success"><i class="fas fa-check me-1"></i> Active</span>
                        <?php else: ?>
                            <span class="badge bg-secondary"><i class="fas fa-times me-1"></i> Inactive</span>
                        <?php endif; ?>
                        <?php if($warehouse->is_default): ?>
                            <span class="badge bg-info"><i class="fas fa-star me-1"></i> Default</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Inventory Summary</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Total Items</span>
                        <span class="badge bg-primary"><?php echo e($warehouse->inventories_count); ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Total Value</span>
                        <span class="fw-semibold">$<?php echo e(number_format($totalValue ?? 0, 2)); ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Low Stock</span>
                        <span class="badge bg-warning"><?php echo e($lowStockCount); ?></span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Out of Stock</span>
                        <span class="badge bg-danger"><?php echo e($outOfStockCount); ?></span>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Details</h6>
                </div>
                <div class="card-body">
                    <dl class="mb-2">
                        <dt class="text-muted small">Created</dt>
                        <dd class="mb-0"><?php echo e($warehouse->created_at->format('M d, Y H:i')); ?></dd>
                    </dl>
                    <dl class="mb-2">
                        <dt class="text-muted small">Updated</dt>
                        <dd class="mb-0"><?php echo e($warehouse->updated_at->format('M d, Y H:i')); ?></dd>
                    </dl>
                    <dl class="mb-0">
                        <dt class="text-muted small">Sort Order</dt>
                        <dd class="mb-0"><?php echo e($warehouse->sort_order); ?></dd>
                    </dl>
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
<?php /**PATH C:\laragon\www\ecommerce\resources\views\admin\warehouses\show.blade.php ENDPATH**/ ?>