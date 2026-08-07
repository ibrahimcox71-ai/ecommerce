<?php if (isset($component)) { $__componentOriginaledc75c655a063d12a477f2c8d8f324fc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc = $attributes; } ?>
<?php $component = App\View\Components\Layouts\AdminLayout::resolve(['title' => 'Inventory History'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Inventory History</h4>
            <p class="text-muted small mb-0">Complete stock timeline across all warehouses</p>
        </div>
        <a href="<?php echo e(route('admin.stock-movements.index')); ?>" class="btn btn-outline-info">
            <i class="fas fa-exchange-alt me-1"></i> Stock Movements
        </a>
        <a href="<?php echo e(route('admin.inventories.index')); ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to Inventory
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="<?php echo e(route('admin.inventories.history')); ?>" class="row g-3">
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
                        <input type="text" name="search" class="form-control" placeholder="Search product or SKU..." value="<?php echo e(request('search')); ?>">
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
                    <select name="change_type" class="form-select">
                        <option value="">All Types</option>
                        <option value="increase" <?php echo e(request('change_type') === 'increase' ? 'selected' : ''); ?>>Stock In</option>
                        <option value="decrease" <?php echo e(request('change_type') === 'decrease' ? 'selected' : ''); ?>>Stock Out</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="reference_type" class="form-select">
                        <option value="">All References</option>
                        <option value="add" <?php echo e(request('reference_type') === 'add' ? 'selected' : ''); ?>>Stock In</option>
                        <option value="subtract" <?php echo e(request('reference_type') === 'subtract' ? 'selected' : ''); ?>>Stock Out</option>
                        <option value="reserve" <?php echo e(request('reference_type') === 'reserve' ? 'selected' : ''); ?>>Reserve</option>
                        <option value="release" <?php echo e(request('reference_type') === 'release' ? 'selected' : ''); ?>>Release</option>
                        <option value="adjustment" <?php echo e(request('reference_type') === 'adjustment' ? 'selected' : ''); ?>>Adjustment</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <input type="date" name="date_from" class="form-control" value="<?php echo e(request('date_from')); ?>" placeholder="From">
                </div>
                <div class="col-md-1">
                    <input type="date" name="date_to" class="form-control" value="<?php echo e(request('date_to')); ?>" placeholder="To">
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-outline-primary w-100">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <?php if($logs->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0" style="width: 90px;">Date</th>
                                <th class="border-0">Product</th>
                                <th class="border-0" style="width: 90px;">SKU</th>
                                <th class="border-0" style="width: 120px;">Warehouse</th>
                                <th class="border-0 text-center" style="width: 60px;">Before</th>
                                <th class="border-0 text-center" style="width: 70px;">Change</th>
                                <th class="border-0 text-center" style="width: 60px;">After</th>
                                <th class="border-0" style="width: 120px;">Reason</th>
                                <th class="border-0" style="width: 80px;">By</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $isIncrease = $log->quantity_change > 0;
                                ?>
                                <tr>
                                    <td class="small text-muted"><?php echo e($log->created_at->format('M d, H:i')); ?></td>
                                    <td>
                                        <span class="small fw-semibold">
                                            <?php echo e($log->variant ? $log->variant->product->name . ' - ' . $log->variant->name : ($log->product?->name ?? 'Deleted')); ?>

                                        </span>
                                    </td>
                                    <td><code class="small"><?php echo e($log->variant?->sku ?? $log->product?->sku ?? '—'); ?></code></td>
                                    <td><span class="small"><?php echo e($log->warehouse?->name ?? '—'); ?></span></td>
                                    <td class="text-center text-muted small"><?php echo e(number_format($log->quantity_before)); ?></td>
                                    <td class="text-center">
                                        <span class="badge bg-<?php echo e($isIncrease ? 'success' : 'danger'); ?>">
                                            <?php echo e($isIncrease ? '+' : ''); ?><?php echo e(number_format($log->quantity_change)); ?>

                                        </span>
                                    </td>
                                    <td class="text-center fw-semibold small"><?php echo e(number_format($log->quantity_after)); ?></td>
                                    <td><span class="small"><?php echo e($log->reason ?: '—'); ?></span></td>
                                    <td><span class="small text-muted"><?php echo e($log->causer?->name ?? 'System'); ?></span></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted small">
                        Showing <?php echo e($logs->firstItem()); ?> to <?php echo e($logs->lastItem()); ?> of <?php echo e($logs->total()); ?> entries
                    </div>
                    <div><?php echo e($logs->links()); ?></div>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="fas fa-history fa-3x text-muted mb-3"></i>
                    <h5>No history records found</h5>
                    <p class="text-muted">Stock movements will appear here.</p>
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
<?php /**PATH C:\laragon\www\ecommerce\resources\views\admin\inventories\history.blade.php ENDPATH**/ ?>