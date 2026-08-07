<?php if (isset($component)) { $__componentOriginaledc75c655a063d12a477f2c8d8f324fc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc = $attributes; } ?>
<?php $component = App\View\Components\Layouts\AdminLayout::resolve(['title' => 'Inventory Alerts'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Inventory Alerts</h4>
            <p class="text-muted small mb-0">Items requiring immediate attention</p>
        </div>
        <div class="d-flex gap-2">
            <a href="<?php echo e(route('admin.inventories.low-stock')); ?>" class="btn btn-outline-warning">
                <i class="fas fa-exclamation-triangle me-1"></i> Low Stock View
            </a>
            <a href="<?php echo e(route('admin.inventories.index')); ?>" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card bg-warning text-white border-0">
                <div class="card-body d-flex align-items-center">
                    <i class="fas fa-exclamation-triangle fa-3x me-3 opacity-75"></i>
                    <div>
                        <h3 class="fw-bold mb-0"><?php echo e($lowStockCount); ?></h3>
                        <p class="mb-0 opacity-75">Low Stock Items</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white border-0">
                <div class="card-body d-flex align-items-center">
                    <i class="fas fa-times-circle fa-3x me-3 opacity-75"></i>
                    <div>
                        <h3 class="fw-bold mb-0"><?php echo e($outOfStockCount); ?></h3>
                        <p class="mb-0 opacity-75">Out of Stock Items</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white border-0">
                <div class="card-body d-flex align-items-center">
                    <i class="fas fa-boxes fa-3x me-3 opacity-75"></i>
                    <div>
                        <h3 class="fw-bold mb-0"><?php echo e($overstockItems->count()); ?></h3>
                        <p class="mb-0 opacity-75">Overstock Items</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-primary text-white border-0">
                <div class="card-body d-flex align-items-center">
                    <i class="fas fa-sync-alt fa-3x me-3 opacity-75"></i>
                    <div>
                        <h3 class="fw-bold mb-0"><?php echo e($needsReorder->count()); ?></h3>
                        <p class="mb-0 opacity-75">Needs Reorder</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0 text-warning"><i class="fas fa-exclamation-triangle me-2"></i>Low Stock Items</h6>
                    <span class="badge bg-warning"><?php echo e($lowStockItems->count()); ?></span>
                </div>
                <div class="card-body p-0">
                    <?php if($lowStockItems->count() > 0): ?>
                        <div class="list-group list-group-flush">
                            <?php $__currentLoopData = $lowStockItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="list-group-item list-group-item-action border-0 d-flex justify-content-between align-items-center">
                                    <div class="small">
                                        <span class="fw-semibold"><?php echo e($item->variant ? $item->variant->product->name . ' - ' . $item->variant->name : ($item->product?->name ?? 'Deleted')); ?></span>
                                        <br><span class="text-muted"><?php echo e($item->warehouse?->name); ?></span>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge bg-warning"><?php echo e($item->quantity - $item->reserved_quantity); ?> left</span>
                                        <br><small class="text-muted">Threshold: <?php echo e($item->low_stock_threshold); ?></small>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                            <p class="mb-0">No low stock items</p>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="card-footer bg-transparent text-center">
                    <a href="<?php echo e(route('admin.inventories.low-stock')); ?>" class="btn btn-sm btn-warning">View All Low Stock</a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0 text-danger"><i class="fas fa-times-circle me-2"></i>Out of Stock Items</h6>
                    <span class="badge bg-danger"><?php echo e($outOfStockItems->count()); ?></span>
                </div>
                <div class="card-body p-0">
                    <?php if($outOfStockItems->count() > 0): ?>
                        <div class="list-group list-group-flush">
                            <?php $__currentLoopData = $outOfStockItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="list-group-item list-group-item-action border-0 d-flex justify-content-between align-items-center">
                                    <div class="small">
                                        <span class="fw-semibold"><?php echo e($item->variant ? $item->variant->product->name . ' - ' . $item->variant->name : ($item->product?->name ?? 'Deleted')); ?></span>
                                        <br><span class="text-muted"><?php echo e($item->warehouse?->name); ?></span>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge bg-danger">0 available</span>
                                        <br><small class="text-muted">Last updated: <?php echo e($item->updated_at->diffForHumans()); ?></small>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                            <p class="mb-0">No out of stock items</p>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="card-footer bg-transparent text-center">
                    <a href="<?php echo e(route('admin.inventories.low-stock')); ?>" class="btn btn-sm btn-danger">View All Out of Stock</a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0 text-info"><i class="fas fa-boxes me-2"></i>Overstock Items</h6>
                    <span class="badge bg-info"><?php echo e($overstockItems->count()); ?></span>
                </div>
                <div class="card-body p-0">
                    <?php if($overstockItems->count() > 0): ?>
                        <div class="list-group list-group-flush">
                            <?php $__currentLoopData = $overstockItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="list-group-item list-group-item-action border-0 d-flex justify-content-between align-items-center">
                                    <div class="small">
                                        <span class="fw-semibold"><?php echo e($item->variant ? $item->variant->product->name . ' - ' . $item->variant->name : ($item->product?->name ?? 'Deleted')); ?></span>
                                        <br><span class="text-muted"><?php echo e($item->warehouse?->name); ?></span>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge bg-info"><?php echo e($item->quantity); ?> units</span>
                                        <br><small class="text-muted">Max: <?php echo e($item->maximum_stock); ?></small>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                            <p class="mb-0">No overstock items</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0 text-primary"><i class="fas fa-sync-alt me-2"></i>Needs Reorder</h6>
                    <span class="badge bg-primary"><?php echo e($needsReorder->count()); ?></span>
                </div>
                <div class="card-body p-0">
                    <?php if($needsReorder->count() > 0): ?>
                        <div class="list-group list-group-flush">
                            <?php $__currentLoopData = $needsReorder; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="list-group-item list-group-item-action border-0 d-flex justify-content-between align-items-center">
                                    <div class="small">
                                        <span class="fw-semibold"><?php echo e($item->variant ? $item->variant->product->name . ' - ' . $item->variant->name : ($item->product?->name ?? 'Deleted')); ?></span>
                                        <br><span class="text-muted"><?php echo e($item->warehouse?->name); ?></span>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge bg-primary"><?php echo e($item->quantity - $item->reserved_quantity); ?> available</span>
                                        <br><small class="text-muted">Reorder at: <?php echo e($item->reorder_level); ?></small>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                            <p class="mb-0">No items need reorder</p>
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
<?php /**PATH C:\laragon\www\ecommerce\resources\views\admin\inventories\alerts.blade.php ENDPATH**/ ?>