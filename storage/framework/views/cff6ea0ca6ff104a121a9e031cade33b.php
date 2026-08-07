<?php if (isset($component)) { $__componentOriginaledc75c655a063d12a477f2c8d8f324fc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc = $attributes; } ?>
<?php $component = App\View\Components\Layouts\AdminLayout::resolve(['title' => 'Inventory Reports'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Inventory Reports</h4>
            <p class="text-muted small mb-0">Stock value, movement analysis, and warehouse breakdown</p>
        </div>
        <div class="d-flex gap-2">
            <a href="<?php echo e(route('admin.inventories.export.csv')); ?>" class="btn btn-outline-success">
                <i class="fas fa-file-csv me-1"></i> Export CSV
            </a>
            <a href="<?php echo e(route('admin.inventories.export.excel')); ?>" class="btn btn-outline-primary">
                <i class="fas fa-file-excel me-1"></i> Export Excel
            </a>
            <a href="<?php echo e(route('admin.inventories.index')); ?>" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="<?php echo e(route('admin.inventories.reports')); ?>" class="row g-3">
                <div class="col-md-3">
                    <select name="warehouse_id" class="form-select">
                        <option value="">All Warehouses</option>
                        <?php $__currentLoopData = $warehouses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $warehouse): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($warehouse->id); ?>" <?php echo e(request('warehouse_id') == $warehouse->id ? 'selected' : ''); ?>><?php echo e($warehouse->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="date" name="date_from" class="form-control" value="<?php echo e(request('date_from')); ?>" placeholder="From date">
                </div>
                <div class="col-md-3">
                    <input type="date" name="date_to" class="form-control" value="<?php echo e(request('date_to')); ?>" placeholder="To date">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-outline-primary w-100">Generate Report</button>
                </div>
            </form>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="text-muted small mb-1">Total Inventory Value</div>
                    <h4 class="fw-bold text-primary mb-0">$<?php echo e(number_format($totalInventoryValue, 2)); ?></h4>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="text-muted small mb-1">Low Stock Items</div>
                    <h4 class="fw-bold text-warning mb-0"><?php echo e($lowStockCount); ?></h4>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="text-muted small mb-1">Out of Stock Items</div>
                    <h4 class="fw-bold text-danger mb-0"><?php echo e($outOfStockCount); ?></h4>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="text-muted small mb-1">Warehouses</div>
                    <h4 class="fw-bold text-info mb-0"><?php echo e($warehouses->count()); ?></h4>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Stock Movement Summary</h6>
                </div>
                <div class="card-body">
                    <?php
                        $stockIn = $movementSummary->where('movement_type', 'in')->first();
                        $stockOut = $movementSummary->where('movement_type', 'out')->first();
                    ?>
                    <div class="text-center mb-4">
                        <div class="row">
                            <div class="col-6">
                                <div class="p-3 bg-success bg-opacity-10 rounded">
                                    <div class="text-success small">Stock In</div>
                                    <h3 class="fw-bold mb-0 text-success"><?php echo e(number_format($stockIn?->total_quantity ?? 0)); ?></h3>
                                    <small class="text-muted"><?php echo e(number_format($stockIn?->total_transactions ?? 0)); ?> transactions</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 bg-danger bg-opacity-10 rounded">
                                    <div class="text-danger small">Stock Out</div>
                                    <h3 class="fw-bold mb-0 text-danger"><?php echo e(number_format($stockOut?->total_quantity ?? 0)); ?></h3>
                                    <small class="text-muted"><?php echo e(number_format($stockOut?->total_transactions ?? 0)); ?> transactions</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if($stockIn || $stockOut): ?>
                        <?php
                            $total = ($stockIn?->total_quantity ?? 0) + ($stockOut?->total_quantity ?? 0);
                            $inPct = $total > 0 ? (($stockIn?->total_quantity ?? 0) / $total) * 100 : 0;
                        ?>
                        <div class="progress" style="height: 25px;">
                            <div class="progress-bar bg-success" style="width: <?php echo e($inPct); ?>%"><?php echo e(number_format($inPct, 1)); ?>% In</div>
                            <div class="progress-bar bg-danger" style="width: <?php echo e(100 - $inPct); ?>%"><?php echo e(number_format(100 - $inPct, 1)); ?>% Out</div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Stock Value by Warehouse</h6>
                </div>
                <div class="card-body p-0">
                    <?php if($stockValueSummary->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0 ps-4">Warehouse</th>
                                        <th class="border-0 text-end">Items</th>
                                        <th class="border-0 text-end">Units</th>
                                        <th class="border-0 pe-4 text-end">Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $stockValueSummary; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="ps-4"><span class="fw-semibold small"><?php echo e($sv->warehouse?->name ?? 'Unknown'); ?></span></td>
                                            <td class="text-end text-muted small"><?php echo e(number_format($sv->total_items)); ?></td>
                                            <td class="text-end text-muted small"><?php echo e(number_format($sv->total_quantity)); ?></td>
                                            <td class="pe-4 text-end fw-semibold">$<?php echo e(number_format($sv->stock_value, 2)); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-chart-bar fa-2x mb-2"></i>
                            <p class="mb-0">No data available</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Warehouse Stock Summary</h6>
                </div>
                <div class="card-body p-0">
                    <?php if($stockSummaryByWarehouse->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0 ps-4">Warehouse</th>
                                        <th class="border-0 text-end">Total Items</th>
                                        <th class="border-0 text-end">Total Units</th>
                                        <th class="border-0 text-end">Low Stock</th>
                                        <th class="border-0 text-end">Out of Stock</th>
                                        <th class="border-0 pe-4 text-end">Stock Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $stockSummaryByWarehouse; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $summary): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="ps-4"><span class="fw-semibold small"><?php echo e($summary['warehouse']); ?></span></td>
                                            <td class="text-end"><?php echo e(number_format($summary['total_items'])); ?></td>
                                            <td class="text-end"><?php echo e(number_format($summary['total_quantity'])); ?></td>
                                            <td class="text-end">
                                                <span class="badge bg-<?php echo e($summary['low_stock'] > 0 ? 'warning' : 'success'); ?>"><?php echo e($summary['low_stock']); ?></span>
                                            </td>
                                            <td class="text-end">
                                                <span class="badge bg-<?php echo e($summary['out_of_stock'] > 0 ? 'danger' : 'success'); ?>"><?php echo e($summary['out_of_stock']); ?></span>
                                            </td>
                                            <td class="pe-4 text-end fw-semibold">$<?php echo e(number_format($summary['value'], 2)); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-warehouse fa-2x mb-2"></i>
                            <p class="mb-0">No warehouse data available</p>
                        </div>
                    <?php endif; ?>
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
<?php /**PATH C:\laragon\www\ecommerce\resources\views\admin\inventories\reports.blade.php ENDPATH**/ ?>