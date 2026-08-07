<?php if (isset($component)) { $__componentOriginaledc75c655a063d12a477f2c8d8f324fc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc = $attributes; } ?>
<?php $component = App\View\Components\Layouts\AdminLayout::resolve(['title' => 'Inventory'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Inventory</h4>
            <p class="text-muted small mb-0">Manage stock across warehouses</p>
        </div>
        <div class="d-flex gap-2">
            <a href="<?php echo e(route('admin.stock-movements.index')); ?>" class="btn btn-outline-info">
                <i class="fas fa-exchange-alt me-1"></i> Movements
            </a>
            <a href="<?php echo e(route('admin.inventories.alerts')); ?>" class="btn btn-outline-danger position-relative">
                <i class="fas fa-bell me-1"></i> Alerts
                <?php if($lowStockCount + $outOfStockCount > 0): ?>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"><?php echo e($lowStockCount + $outOfStockCount); ?></span>
                <?php endif; ?>
            </a>
            <a href="<?php echo e(route('admin.inventories.low-stock')); ?>" class="btn btn-outline-warning position-relative">
                <i class="fas fa-exclamation-triangle me-1"></i> Low Stock
                <?php if($lowStockCount > 0): ?>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"><?php echo e($lowStockCount); ?></span>
                <?php endif; ?>
            </a>
            <a href="<?php echo e(route('admin.inventories.stock-in')); ?>" class="btn btn-success">
                <i class="fas fa-plus-circle me-1"></i> Stock In
            </a>
            <a href="<?php echo e(route('admin.inventories.stock-out')); ?>" class="btn btn-danger">
                <i class="fas fa-minus-circle me-1"></i> Stock Out
            </a>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0 opacity-75">Total Products</h6>
                            <h3 class="fw-bold mb-0"><?php echo e($totalProducts); ?></h3>
                        </div>
                        <i class="fas fa-box fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0 opacity-75">Total Stock Value</h6>
                            <h3 class="fw-bold mb-0">$<?php echo e(number_format($totalStockValue, 2)); ?></h3>
                        </div>
                        <i class="fas fa-dollar-sign fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0 opacity-75">Low Stock</h6>
                            <h3 class="fw-bold mb-0"><?php echo e($lowStockCount); ?></h3>
                        </div>
                        <i class="fas fa-exclamation-triangle fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0 opacity-75">Out of Stock</h6>
                            <h3 class="fw-bold mb-0"><?php echo e($outOfStockCount); ?></h3>
                        </div>
                        <i class="fas fa-times-circle fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="<?php echo e(route('admin.inventories.index')); ?>" class="row g-3">
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
                        <input type="text" name="search" class="form-control" placeholder="Search by name, SKU, or barcode..." value="<?php echo e(request('search')); ?>">
                    </div>
                </div>
                <div class="col-md-2">
                    <select name="warehouse_id" class="form-select">
                        <option value="">All Warehouses</option>
                        <?php $__currentLoopData = $warehouses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $warehouse): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($warehouse->id); ?>" <?php echo e(request('warehouse_id') == $warehouse->id ? 'selected' : ''); ?>><?php echo e($warehouse->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="stock_status" class="form-select">
                        <option value="">All Stock Status</option>
                        <option value="in" <?php echo e(request('stock_status') === 'in' ? 'selected' : ''); ?>>In Stock</option>
                        <option value="low" <?php echo e(request('stock_status') === 'low' ? 'selected' : ''); ?>>Low Stock</option>
                        <option value="out" <?php echo e(request('stock_status') === 'out' ? 'selected' : ''); ?>>Out of Stock</option>
                        <option value="overstock" <?php echo e(request('stock_status') === 'overstock' ? 'selected' : ''); ?>>Overstock</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="category_id" class="form-select">
                        <option value="">All Categories</option>
                    </select>
                </div>
                <div class="col-md-1">
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
                                <th class="border-0" style="width: 50px;">Image</th>
                                <th class="border-0">Product</th>
                                <th class="border-0" style="width: 100px;">SKU</th>
                                <th class="border-0" style="width: 130px;">Warehouse</th>
                                <th class="border-0 text-center" style="width: 70px;">Stock</th>
                                <th class="border-0 text-center" style="width: 70px;">Available</th>
                                <th class="border-0 text-center" style="width: 70px;">Reserved</th>
                                <th class="border-0 text-center" style="width: 70px;">Damaged</th>
                                <th class="border-0 text-center" style="width: 90px;">Status</th>
                                <th class="border-0 text-end" style="width: 140px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $inventories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $available = $inv->quantity - $inv->reserved_quantity;
                                    $statusClass = $available <= 0 ? 'danger' : ($available <= $inv->low_stock_threshold ? 'warning' : 'success');
                                    $statusText = $available <= 0 ? 'Out' : ($available <= $inv->low_stock_threshold ? 'Low' : 'In Stock');
                                    $productName = $inv->variant ? $inv->variant->product->name . ' - ' . $inv->variant->name : ($inv->product?->name ?? 'Deleted Product');
                                    $imageUrl = $inv->product?->thumbnail_url;
                                ?>
                                <tr>
                                    <td>
                                        <?php if($imageUrl): ?>
                                            <img src="<?php echo e($imageUrl); ?>" alt="" class="rounded" style="width: 40px; height: 40px; object-fit: cover;">
                                        <?php else: ?>
                                            <div class="rounded bg-light d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                <i class="fas fa-box text-muted"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="fw-semibold small"><?php echo e($productName); ?></span>
                                    </td>
                                    <td><code class="small"><?php echo e($inv->variant?->sku ?? $inv->product?->sku ?? '—'); ?></code></td>
                                    <td><span class="small"><?php echo e($inv->warehouse?->name ?? '—'); ?></span></td>
                                    <td class="text-center fw-semibold"><?php echo e(number_format($inv->quantity)); ?></td>
                                    <td class="text-center">
                                        <span class="badge bg-<?php echo e($statusClass); ?>"><?php echo e(number_format($available)); ?></span>
                                    </td>
                                    <td class="text-center text-muted small"><?php echo e(number_format($inv->reserved_quantity)); ?></td>
                                    <td class="text-center text-muted small"><?php echo e(number_format($inv->damaged_stock)); ?></td>
                                    <td class="text-center">
                                        <span class="badge bg-<?php echo e($statusClass); ?>" style="min-width: 60px;"><?php echo e($statusText); ?></span>
                                    </td>
                                    <td class="text-end">
                                        <div class="btn-group">
                                            <a href="<?php echo e(route('admin.inventories.stock-in')); ?>?product_id=<?php echo e($inv->product_id); ?>&variant_id=<?php echo e($inv->product_variant_id); ?>&warehouse_id=<?php echo e($inv->warehouse_id); ?>"
                                               class="btn btn-sm btn-outline-success" title="Stock In">
                                                <i class="fas fa-plus"></i>
                                            </a>
                                            <a href="<?php echo e(route('admin.inventories.stock-out')); ?>?product_id=<?php echo e($inv->product_id); ?>&variant_id=<?php echo e($inv->product_variant_id); ?>&warehouse_id=<?php echo e($inv->warehouse_id); ?>"
                                               class="btn btn-sm btn-outline-danger" title="Stock Out">
                                                <i class="fas fa-minus"></i>
                                            </a>
                                            <a href="<?php echo e(route('admin.inventories.history')); ?>?search=<?php echo e($inv->product?->sku ?? $inv->variant?->sku); ?>"
                                               class="btn btn-sm btn-outline-info" title="History">
                                                <i class="fas fa-history"></i>
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
                    <i class="fas fa-warehouse fa-3x text-muted mb-3"></i>
                    <h5>No inventory records found</h5>
                    <p class="text-muted">
                        <?php if(request()->anyFilled(['search', 'warehouse_id', 'stock_status'])): ?>
                            No records match your filters. <a href="<?php echo e(route('admin.inventories.index')); ?>">Clear filters</a>
                        <?php else: ?>
                            Start by adding stock to products.
                        <?php endif; ?>
                    </p>
                    <a href="<?php echo e(route('admin.inventories.stock-in')); ?>" class="btn btn-success">
                        <i class="fas fa-plus-circle me-1"></i> Stock In
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
<?php /**PATH C:\laragon\www\ecommerce\resources\views\admin\inventories\index.blade.php ENDPATH**/ ?>