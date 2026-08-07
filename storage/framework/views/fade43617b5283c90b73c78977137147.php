<?php if (isset($component)) { $__componentOriginaledc75c655a063d12a477f2c8d8f324fc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc = $attributes; } ?>
<?php $component = App\View\Components\Layouts\AdminLayout::resolve(['title' => 'Low Stock Inventory'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Low Stock & Out of Stock</h4>
            <p class="text-muted small mb-0">Products that need attention</p>
        </div>
        <div class="d-flex gap-2">
            <a href="<?php echo e(route('admin.inventories.alerts')); ?>" class="btn btn-outline-danger">
                <i class="fas fa-bell me-1"></i> Alerts
            </a>
            <a href="<?php echo e(route('admin.inventories.index')); ?>" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to Inventory
            </a>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0 opacity-75">Low Stock Items</h6>
                            <h2 class="fw-bold mb-0"><?php echo e($lowStockCount); ?></h2>
                        </div>
                        <i class="fas fa-exclamation-triangle fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0 opacity-75">Out of Stock Items</h6>
                            <h2 class="fw-bold mb-0"><?php echo e($outOfStockCount); ?></h2>
                        </div>
                        <i class="fas fa-times-circle fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="<?php echo e(route('admin.inventories.low-stock')); ?>" class="row g-3">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
                        <input type="text" name="search" class="form-control" placeholder="Search products..." value="<?php echo e(request('search')); ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <select name="warehouse_id" class="form-select">
                        <option value="">All Warehouses</option>
                        <?php $__currentLoopData = $warehouses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $warehouse): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($warehouse->id); ?>" <?php echo e(request('warehouse_id') == $warehouse->id ? 'selected' : ''); ?>><?php echo e($warehouse->name); ?></option>
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
            <?php if($inventories->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0">Product</th>
                                <th class="border-0" style="width: 100px;">SKU</th>
                                <th class="border-0" style="width: 140px;">Warehouse</th>
                                <th class="border-0 text-center" style="width: 70px;">Stock</th>
                                <th class="border-0 text-center" style="width: 70px;">Reserved</th>
                                <th class="border-0 text-center" style="width: 70px;">Available</th>
                                <th class="border-0 text-center" style="width: 70px;">Incoming</th>
                                <th class="border-0 text-center" style="width: 90px;">Threshold</th>
                                <th class="border-0 text-center" style="width: 100px;">Status</th>
                                <th class="border-0 text-end" style="width: 80px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $inventories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $available = $inv->quantity - $inv->reserved_quantity;
                                    $isOut = $available <= 0;
                                ?>
                                <tr class="<?php echo e($isOut ? 'table-danger' : 'table-warning'); ?>">
                                    <td>
                                        <span class="fw-semibold small">
                                            <?php echo e($inv->variant ? $inv->variant->product->name . ' - ' . $inv->variant->name : ($inv->product?->name ?? 'Deleted')); ?>

                                        </span>
                                    </td>
                                    <td><code class="small"><?php echo e($inv->variant?->sku ?? $inv->product?->sku ?? '—'); ?></code></td>
                                    <td><span class="small"><?php echo e($inv->warehouse?->name ?? '—'); ?></span></td>
                                    <td class="text-center fw-semibold"><?php echo e(number_format($inv->quantity)); ?></td>
                                    <td class="text-center text-muted"><?php echo e(number_format($inv->reserved_quantity)); ?></td>
                                    <td class="text-center">
                                        <span class="badge bg-<?php echo e($isOut ? 'danger' : 'warning'); ?>"><?php echo e(number_format($available)); ?></span>
                                    </td>
                                    <td class="text-center text-muted"><?php echo e(number_format($inv->incoming_stock)); ?></td>
                                    <td class="text-center text-muted"><?php echo e($inv->low_stock_threshold); ?></td>
                                    <td class="text-center">
                                        <span class="badge bg-<?php echo e($isOut ? 'danger' : 'warning'); ?>">
                                            <?php echo e($isOut ? 'Out of Stock' : 'Low Stock'); ?>

                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <div class="btn-group">
                                            <a href="<?php echo e(route('admin.inventories.stock-in')); ?>?product_id=<?php echo e($inv->product_id); ?>&variant_id=<?php echo e($inv->product_variant_id); ?>&warehouse_id=<?php echo e($inv->warehouse_id); ?>"
                                               class="btn btn-sm btn-outline-success" title="Stock In">
                                                <i class="fas fa-plus"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted small">
                        Showing <?php echo e($inventories->firstItem()); ?> to <?php echo e($inventories->lastItem()); ?> of <?php echo e($inventories->total()); ?> entries
                    </div>
                    <div><?php echo e($inventories->links()); ?></div>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                    <h5>All stocked up!</h5>
                    <p class="text-muted">No low stock or out of stock items found.</p>
                    <a href="<?php echo e(route('admin.inventories.index')); ?>" class="btn btn-primary">
                        <i class="fas fa-arrow-left me-1"></i> Back to Inventory
                    </a>
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
<?php /**PATH C:\laragon\www\ecommerce\resources\views\admin\inventories\low-stock.blade.php ENDPATH**/ ?>