<?php if (isset($component)) { $__componentOriginaledc75c655a063d12a477f2c8d8f324fc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc = $attributes; } ?>
<?php $component = App\View\Components\Layouts\AdminLayout::resolve(['title' => 'Purchase Orders'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Purchase Orders</h4>
            <p class="text-muted small mb-0">Manage supplier purchase orders</p>
        </div>
        <div class="d-flex gap-2">
            <a href="<?php echo e(route('admin.purchases.reports')); ?>" class="btn btn-outline-info">
                <i class="fas fa-chart-bar me-1"></i> Reports
            </a>
            <a href="<?php echo e(route('admin.purchases.create')); ?>" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Create PO
            </a>
        </div>
    </div>

    <div class="row g-2 mb-4">
        <div class="col-6 col-md-2">
            <div class="card bg-secondary-subtle border-0">
                <div class="card-body text-center py-3">
                    <h5 class="fw-bold mb-0"><?php echo e($stats['total']); ?></h5>
                    <small class="text-muted">Total</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-2">
            <div class="card bg-warning-subtle border-0">
                <div class="card-body text-center py-3">
                    <h5 class="fw-bold mb-0 text-warning"><?php echo e($stats['pending']); ?></h5>
                    <small class="text-muted">Pending</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-2">
            <div class="card bg-success-subtle border-0">
                <div class="card-body text-center py-3">
                    <h5 class="fw-bold mb-0 text-success"><?php echo e($stats['completed']); ?></h5>
                    <small class="text-muted">Completed</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-2">
            <div class="card bg-primary-subtle border-0">
                <div class="card-body text-center py-3">
                    <h5 class="fw-bold mb-0 text-primary"><?php echo e(number_format($stats['total_amount'], 2)); ?></h5>
                    <small class="text-muted">Total Amount</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-2">
            <div class="card bg-success-subtle border-0">
                <div class="card-body text-center py-3">
                    <h5 class="fw-bold mb-0 text-success"><?php echo e(number_format($stats['total_paid'], 2)); ?></h5>
                    <small class="text-muted">Total Paid</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-2">
            <div class="card bg-danger-subtle border-0">
                <div class="card-body text-center py-3">
                    <h5 class="fw-bold mb-0 text-danger"><?php echo e(number_format($stats['total_due'], 2)); ?></h5>
                    <small class="text-muted">Total Due</small>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="GET" class="row g-2 mb-3">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" placeholder="Search PO, supplier, warehouse..." value="<?php echo e($filters['search'] ?? ''); ?>">
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <?php $__currentLoopData = App\Enums\PurchaseStatus::cases(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($status->value); ?>" <?php echo e(($filters['status'] ?? '') == $status->value ? 'selected' : ''); ?>><?php echo e($status->label()); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="payment_status" class="form-select">
                        <option value="">All Payment</option>
                        <?php $__currentLoopData = App\Enums\PurchasePaymentStatus::cases(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ps): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($ps->value); ?>" <?php echo e(($filters['payment_status'] ?? '') == $ps->value ? 'selected' : ''); ?>><?php echo e($ps->label()); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="supplier_id" class="form-select">
                        <option value="">All Suppliers</option>
                        <?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($supplier->id); ?>" <?php echo e(($filters['supplier_id'] ?? '') == $supplier->id ? 'selected' : ''); ?>><?php echo e($supplier->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="warehouse_id" class="form-select">
                        <option value="">All Warehouses</option>
                        <?php $__currentLoopData = $warehouses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $warehouse): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($warehouse->id); ?>" <?php echo e(($filters['warehouse_id'] ?? '') == $warehouse->id ? 'selected' : ''); ?>><?php echo e($warehouse->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i></button>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>PO Number</th>
                            <th>Supplier</th>
                            <th>Warehouse</th>
                            <th class="text-end">Items</th>
                            <th class="text-end">Total</th>
                            <th class="text-end">Paid</th>
                            <th class="text-end">Due</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $purchases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $purchase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <a href="<?php echo e(route('admin.purchases.show', $purchase->id)); ?>" class="fw-semibold text-decoration-none">
                                        <?php echo e($purchase->po_number); ?>

                                    </a>
                                    <?php if($purchase->reference_number): ?>
                                        <br><small class="text-muted"><?php echo e($purchase->reference_number); ?></small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="fw-semibold"><?php echo e($purchase->supplier?->name); ?></span>
                                    <?php if($purchase->supplier?->supplier_code): ?>
                                        <br><small class="text-muted"><?php echo e($purchase->supplier->supplier_code); ?></small>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($purchase->warehouse?->name); ?></td>
                                <td class="text-end"><?php echo e($purchase->items_count ?? $purchase->items->count()); ?></td>
                                <td class="text-end fw-semibold"><?php echo e(number_format($purchase->total_amount, 2)); ?></td>
                                <td class="text-end text-success"><?php echo e(number_format($purchase->paid_amount, 2)); ?></td>
                                <td class="text-end <?php echo e($purchase->due_amount > 0 ? 'text-danger' : ''); ?>"><?php echo e(number_format($purchase->due_amount, 2)); ?></td>
                                <td>
                                    <span class="badge bg-<?php echo e($purchase->status->color()); ?>"><?php echo e($purchase->status->label()); ?></span>
                                    <br>
                                    <small class="badge bg-<?php echo e($purchase->payment_status->color()); ?> mt-1"><?php echo e($purchase->payment_status->label()); ?></small>
                                </td>
                                <td>
                                    <small><?php echo e($purchase->purchase_date?->format('d/m/Y')); ?></small>
                                    <br><small class="text-muted"><?php echo e($purchase->created_at?->diffForHumans()); ?></small>
                                </td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item" href="<?php echo e(route('admin.purchases.show', $purchase->id)); ?>"><i class="fas fa-eye me-2"></i>View</a></li>
                                            <?php if($purchase->isEditable()): ?>
                                                <li><a class="dropdown-item" href="<?php echo e(route('admin.purchases.edit', $purchase->id)); ?>"><i class="fas fa-edit me-2"></i>Edit</a></li>
                                            <?php endif; ?>
                                            <?php if($purchase->isApprovable()): ?>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <form method="POST" action="<?php echo e(route('admin.purchases.approve', $purchase->id)); ?>" class="d-inline">
                                                        <?php echo csrf_field(); ?>
                                                        <button type="submit" class="dropdown-item text-success"><i class="fas fa-check-circle me-2"></i>Approve</button>
                                                    </form>
                                                </li>
                                                <li>
                                                    <form method="POST" action="<?php echo e(route('admin.purchases.reject', $purchase->id)); ?>" class="d-inline">
                                                        <?php echo csrf_field(); ?>
                                                        <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Reject this purchase order?')"><i class="fas fa-times-circle me-2"></i>Reject</button>
                                                    </form>
                                                </li>
                                            <?php endif; ?>
                                            <?php if($purchase->isCancellable() && !$purchase->isApprovable()): ?>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <form method="POST" action="<?php echo e(route('admin.purchases.cancel', $purchase->id)); ?>" class="d-inline">
                                                        <?php echo csrf_field(); ?>
                                                        <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Cancel this purchase order?')"><i class="fas fa-ban me-2"></i>Cancel</button>
                                                    </form>
                                                </li>
                                            <?php endif; ?>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item" href="<?php echo e(route('admin.purchases.clone', $purchase->id)); ?>"><i class="fas fa-copy me-2"></i>Clone</a></li>
                                            <li><a class="dropdown-item" href="<?php echo e(route('admin.purchases.print', $purchase->id)); ?>" target="_blank"><i class="fas fa-print me-2"></i>Print</a></li>
                                            <?php if($purchase->isDeletable()): ?>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <form method="POST" action="<?php echo e(route('admin.purchases.destroy', $purchase->id)); ?>" class="d-inline">
                                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                                        <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Delete this purchase order?')"><i class="fas fa-trash me-2"></i>Delete</button>
                                                    </form>
                                                </li>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="10" class="text-center py-5 text-muted">
                                    <i class="fas fa-shopping-cart fa-3x mb-3 d-block"></i>
                                    No purchase orders found
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3">
                <small class="text-muted">Showing <?php echo e($purchases->firstItem() ?? 0); ?> to <?php echo e($purchases->lastItem() ?? 0); ?> of <?php echo e($purchases->total()); ?> entries</small>
                <div class="d-flex gap-2">
                    <a href="<?php echo e(route('admin.purchases.export.csv', request()->query())); ?>" class="btn btn-sm btn-outline-success">
                        <i class="fas fa-file-csv me-1"></i> CSV
                    </a>
                    <a href="<?php echo e(route('admin.purchases.export.excel', request()->query())); ?>" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-file-excel me-1"></i> Excel
                    </a>
                </div>
            </div>

            <div class="d-flex justify-content-center mt-3">
                <?php echo e($purchases->withQueryString()->links()); ?>

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
<?php /**PATH C:\laragon\www\ecommerce\resources\views\admin\purchases\index.blade.php ENDPATH**/ ?>