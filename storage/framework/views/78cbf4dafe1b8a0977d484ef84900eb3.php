<?php if (isset($component)) { $__componentOriginaledc75c655a063d12a477f2c8d8f324fc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc = $attributes; } ?>
<?php $component = App\View\Components\Layouts\AdminLayout::resolve(['title' => ''.e($product->name).''] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

    <?php $__env->startPush('styles'); ?>
        <?php echo app('Illuminate\Foundation\Vite')(['resources/sass/product.scss']); ?>
    <?php $__env->stopPush(); ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1"><?php echo e($product->name); ?></h4>
            <p class="text-muted small mb-0">
                <span class="badge bg-<?php echo e($product->status->color()); ?> bg-opacity-10 text-<?php echo e($product->status->color()); ?>">
                    <?php echo e($product->status->label()); ?>

                </span>
                <span class="ms-2">SKU: <code><?php echo e($product->sku); ?></code></span>
                <?php if($product->product_type): ?>
                    <span class="ms-2 badge bg-info bg-opacity-10 text-info"><?php echo e(ucfirst($product->product_type)); ?></span>
                <?php endif; ?>
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="<?php echo e(route('admin.products.edit', $product->id)); ?>" class="btn btn-primary">
                <i class="fas fa-edit me-1"></i> Edit
            </a>
            <a href="<?php echo e(route('admin.products.duplicate', $product->id)); ?>" class="btn btn-outline-secondary">
                <i class="fas fa-copy me-1"></i> Duplicate
            </a>
            <a href="<?php echo e(route('admin.products.index')); ?>" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    <div class="row g-4">
        
        <div class="col-lg-8">

            
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="fw-semibold mb-0"><i class="fas fa-box me-2"></i>Product Information</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <?php if($product->thumbnail): ?>
                                <img src="<?php echo e($product->thumbnail_url); ?>" alt="<?php echo e($product->name); ?>"
                                     class="img-thumbnail" style="width: 100%;">
                            <?php else: ?>
                                <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                     style="width: 100%; aspect-ratio: 1;">
                                    <i class="fas fa-box fa-3x text-muted"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-9">
                            <table class="table table-sm">
                                <tr>
                                    <td class="text-muted" style="width: 150px;">Name</td>
                                    <td class="fw-semibold"><?php echo e($product->name); ?></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Slug</td>
                                    <td><code><?php echo e($product->slug); ?></code></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Category</td>
                                    <td><?php echo e($product->category?->name ?? '—'); ?></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Sub Category</td>
                                    <td><?php echo e($product->subCategory?->name ?? '—'); ?></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Child Category</td>
                                    <td><?php echo e($product->childCategory?->name ?? '—'); ?></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Brand</td>
                                    <td><?php echo e($product->brand?->name ?? '—'); ?></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Barcode</td>
                                    <td><?php echo e($product->barcode ?? '—'); ?></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Currency</td>
                                    <td><?php echo e($product->currency ?? config('ecommerce.currency')); ?></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Product Type</td>
                                    <td>
                                        <span class="badge bg-<?php echo e($product->product_type === 'variable' ? 'primary' : ($product->product_type === 'digital' ? 'info' : 'secondary')); ?>">
                                            <?php echo e(ucfirst($product->product_type)); ?>

                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            
            <?php if($product->short_description || $product->description): ?>
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="fw-semibold mb-0"><i class="fas fa-align-left me-2"></i>Description</h6>
                    </div>
                    <div class="card-body">
                        <?php if($product->short_description): ?>
                            <p class="text-muted"><?php echo e($product->short_description); ?></p>
                            <?php if($product->description): ?><hr><?php endif; ?>
                        <?php endif; ?>
                        <?php if($product->description): ?>
                            <div><?php echo strip_tags($product->description, '<p><br><b><strong><i><em><u><ol><ul><li><a><img><table><tr><td><th><h1><h2><h3><h4><h5><h6><blockquote><pre><code><hr><span><div><sub><sup>'); ?></div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

            
            <?php if($product->images->count() > 0): ?>
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="fw-semibold mb-0"><i class="fas fa-images me-2"></i>Gallery (<?php echo e($product->images->count()); ?>)</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-2">
                            <?php $__currentLoopData = $product->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-auto">
                                    <div class="position-relative">
                                        <img src="<?php echo e($image->image_url); ?>" alt="<?php echo e($image->alt_text ?? $product->name); ?>"
                                             class="rounded" style="width: 100px; height: 100px; object-fit: cover;">
                                        <?php if($image->is_primary): ?>
                                            <span class="badge bg-success position-absolute top-0 start-0 mt-1 ms-1" style="font-size: 8px;">Primary</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            
            <?php if($product->variants->count() > 0): ?>
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="fw-semibold mb-0"><i class="fas fa-layer-group me-2"></i>Variants (<?php echo e($product->variants->count()); ?>)</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Variant</th>
                                        <th>SKU</th>
                                        <th>Price</th>
                                        <th>Cost</th>
                                        <th>Stock</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $product->variants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <?php if($variant->image): ?>
                                                    <img src="<?php echo e($variant->image_url); ?>" class="rounded" style="width: 32px; height: 32px; object-fit: cover;">
                                                <?php else: ?>
                                                    <span class="text-muted">—</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php echo e($variant->name); ?>

                                                <?php if($variant->attributeValues->count() > 0): ?>
                                                    <small class="text-muted d-block">
                                                        <?php $__currentLoopData = $variant->attributeValues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $av): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <span class="badge bg-light text-dark me-1"><?php echo e($av->attributeValue?->value ?? $av->attribute?->name); ?></span>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </small>
                                                <?php endif; ?>
                                            </td>
                                            <td><code><?php echo e($variant->sku); ?></code></td>
                                            <td>
                                                <?php if($variant->price): ?>
                                                    <?php echo e(config('ecommerce.currency_symbol')); ?><?php echo e(number_format($variant->price, 2)); ?>

                                                <?php else: ?>
                                                    <span class="text-muted">Inherit</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($variant->cost_price): ?>
                                                    <?php echo e(config('ecommerce.currency_symbol')); ?><?php echo e(number_format($variant->cost_price, 2)); ?>

                                                <?php else: ?>
                                                    <span class="text-muted">—</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($variant->unlimited_stock): ?>
                                                    <span class="text-success"><i class="fas fa-infinity"></i></span>
                                                <?php else: ?>
                                                    <?php echo e($variant->stock); ?>

                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($variant->status): ?>
                                                    <span class="badge bg-success">Active</span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary">Inactive</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            
            <?php if($stockHistory && $stockHistory->count() > 0): ?>
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="fw-semibold mb-0"><i class="fas fa-history me-2"></i>Stock History</h6>
                    </div>
                    <div class="card-body">
                        <div class="stock-timeline">
                            <?php $__currentLoopData = $stockHistory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="timeline-item <?php echo e($entry->quantity > 0 ? 'timeline-in' : 'timeline-out'); ?>">
                                    <div class="timeline-marker">
                                        <i class="fas <?php echo e($entry->quantity > 0 ? 'fa-arrow-down' : 'fa-arrow-up'); ?>"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <strong><?php echo e($entry->quantity > 0 ? '+' : ''); ?><?php echo e($entry->quantity); ?></strong>
                                                <span class="text-muted ms-2"><?php echo e($entry->reference_type ?? 'Manual Adjustment'); ?></span>
                                                <?php if($entry->reference): ?>
                                                    <span class="text-muted ms-1">(<?php echo e($entry->reference); ?>)</span>
                                                <?php endif; ?>
                                            </div>
                                            <small class="text-muted"><?php echo e($entry->created_at->format('M d, H:i')); ?></small>
                                        </div>
                                        <?php if($entry->notes): ?>
                                            <small class="text-muted d-block mt-1"><?php echo e($entry->notes); ?></small>
                                        <?php endif; ?>
                                        <small class="text-muted d-block">
                                            Balance: <?php echo e($entry->current_quantity ?? '—'); ?>

                                        </small>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            
            <?php if($product->schema_markup): ?>
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="fw-semibold mb-0"><i class="fas fa-code me-2"></i>Schema Markup Preview</h6>
                    </div>
                    <div class="card-body">
                        <pre class="mb-0" style="max-height: 300px; overflow-y: auto;"><code><?php echo e($product->schema_markup); ?></code></pre>
                    </div>
                </div>
            <?php endif; ?>

            
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="fw-semibold mb-0"><i class="fas fa-history me-2"></i>Activity Log</h6>
                </div>
                <div class="card-body">
                    <?php if($activityLogs->count() > 0): ?>
                        <div class="list-group list-group-flush">
                            <?php $__currentLoopData = $activityLogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="list-group-item px-0 py-2 border-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="badge bg-light text-dark me-2" style="width: 6px; height: 6px; padding: 0; border-radius: 50%; display: inline-block;"></span>
                                            <?php echo e($log->description); ?>

                                            <?php if($log->properties): ?>
                                                <button type="button" class="btn btn-sm btn-link p-0 ms-1" data-bs-toggle="tooltip" title="<?php echo e(json_encode($log->properties, JSON_PRETTY_PRINT)); ?>">
                                                    <i class="fas fa-info-circle text-muted"></i>
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                        <small class="text-muted"><?php echo e($log->created_at->diffForHumans()); ?></small>
                                    </div>
                                    <?php if($log->causer): ?>
                                        <small class="text-muted ms-0">by <?php echo e($log->causer->name ?? 'System'); ?></small>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <div class="mt-3">
                            <?php echo e($activityLogs->links()); ?>

                        </div>
                    <?php else: ?>
                        <p class="text-muted mb-0">No activity recorded yet.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        
        <div class="col-lg-4">

            
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="fw-semibold mb-0"><i class="fas fa-dollar-sign me-2"></i>Pricing Overview</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="text-center p-3 bg-light rounded">
                                <div class="h4 mb-1 text-success"><?php echo e(config('ecommerce.currency_symbol')); ?><?php echo e(number_format($product->current_price, 2)); ?></div>
                                <small class="text-muted">Sale Price</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center p-3 bg-light rounded">
                                <div class="h4 mb-1"><?php echo e(config('ecommerce.currency_symbol')); ?><?php echo e(number_format($product->price, 2)); ?></div>
                                <small class="text-muted">Base Price</small>
                            </div>
                        </div>
                        <?php if($product->cost_price > 0): ?>
                            <div class="col-6">
                                <div class="text-center p-3 bg-light rounded">
                                    <div class="h4 mb-1"><?php echo e(config('ecommerce.currency_symbol')); ?><?php echo e(number_format($product->cost_price, 2)); ?></div>
                                    <small class="text-muted">Cost Price</small>
                                </div>
                            </div>
                            <?php
                                $marginColor = $product->profit_margin > 30 ? 'success' : ($product->profit_margin > 15 ? 'warning' : 'danger');
                            ?>
                            <div class="col-6">
                                <div class="text-center p-3 bg-<?php echo e($marginColor); ?> bg-opacity-10 rounded">
                                    <div class="h4 mb-1 text-<?php echo e($marginColor); ?>"><?php echo e($product->profit_margin); ?>%</div>
                                    <small class="text-muted">Margin</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-center p-3 bg-success bg-opacity-10 rounded">
                                    <div class="h4 mb-1 text-success">+<?php echo e(config('ecommerce.currency_symbol')); ?><?php echo e(number_format($product->profit, 2)); ?></div>
                                    <small class="text-muted">Profit</small>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if($product->tax > 0): ?>
                            <div class="col-6">
                                <div class="text-center p-3 bg-info bg-opacity-10 rounded">
                                    <div class="h4 mb-1 text-info"><?php echo e(config('ecommerce.currency_symbol')); ?><?php echo e(number_format($product->price_after_tax - $product->current_price, 2)); ?></div>
                                    <small class="text-muted">Tax (<?php echo e($product->tax); ?>% <?php echo e($product->tax_type); ?>)</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-center p-3 bg-primary bg-opacity-10 rounded">
                                    <div class="h4 mb-1 text-primary"><?php echo e(config('ecommerce.currency_symbol')); ?><?php echo e(number_format($product->price_after_tax, 2)); ?></div>
                                    <small class="text-muted">After Tax</small>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if($product->discount > 0 && $product->has_discount): ?>
                            <div class="col-6">
                                <div class="text-center p-3 bg-warning bg-opacity-10 rounded">
                                    <div class="h4 mb-1 text-warning">-<?php echo e($product->discount_percentage); ?>%</div>
                                    <small class="text-muted">Discount</small>
                                </div>
                            </div>
                            <?php if($product->discount_start): ?>
                                <div class="col-6">
                                    <div class="text-center p-3 bg-light rounded">
                                        <small class="text-muted">Until <?php echo e($product->discount_end?->format('M d, Y') ?? 'Forever'); ?></small>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="fw-semibold mb-0"><i class="fas fa-boxes me-2"></i>Stock</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Stock</span>
                        <span class="fw-semibold">
                            <?php if($product->unlimited_stock): ?>
                                <span class="text-success"><i class="fas fa-infinity"></i> Unlimited</span>
                            <?php else: ?>
                                <?php echo e($product->stock); ?>

                            <?php endif; ?>
                        </span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Total (incl. variants)</span>
                        <span class="fw-semibold">
                            <?php if($product->total_stock !== null): ?>
                                <?php echo e($product->total_stock); ?>

                            <?php else: ?>
                                <span class="text-success"><i class="fas fa-infinity"></i></span>
                            <?php endif; ?>
                        </span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Min Stock</span>
                        <span class="fw-semibold"><?php echo e($product->min_stock ?: '—'); ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Low Stock Threshold</span>
                        <span class="fw-semibold"><?php echo e($product->low_stock_threshold ?: '—'); ?></span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Stock Value</span>
                        <span class="fw-semibold"><?php echo e(config('ecommerce.currency_symbol')); ?><?php echo e(number_format($product->stock_value, 2)); ?></span>
                    </div>
                    <?php if($product->is_low_stock): ?>
                        <div class="alert alert-warning mt-3 mb-0 py-2">
                            <i class="fas fa-exclamation-triangle me-1"></i> Low stock alert! Only <?php echo e($product->stock); ?> remaining.
                        </div>
                    <?php elseif($product->is_out_of_stock): ?>
                        <div class="alert alert-danger mt-3 mb-0 py-2">
                            <i class="fas fa-times-circle me-1"></i> Out of stock!
                        </div>
                    <?php elseif($product->is_below_min_stock): ?>
                        <div class="alert alert-warning mt-3 mb-0 py-2">
                            <i class="fas fa-exclamation-circle me-1"></i> Below minimum stock level!
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="fw-semibold mb-0"><i class="fas fa-flag me-2"></i>Product Flags</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-2">
                        <?php if($product->featured): ?>
                            <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25">
                                <i class="fas fa-star me-1"></i> Featured
                            </span>
                        <?php endif; ?>
                        <?php if($product->trending): ?>
                            <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25">
                                <i class="fas fa-fire me-1"></i> Trending
                            </span>
                        <?php endif; ?>
                        <?php if($product->best_seller): ?>
                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25">
                                <i class="fas fa-trophy me-1"></i> Best Seller
                            </span>
                        <?php endif; ?>
                        <?php if($product->is_new_arrival): ?>
                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25">
                                <i class="fas fa-star me-1"></i> New Arrival
                            </span>
                        <?php endif; ?>
                        <?php if($product->has_discount): ?>
                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25">
                                <i class="fas fa-tag me-1"></i> On Sale
                            </span>
                        <?php endif; ?>
                        <?php if($product->is_virtual): ?>
                            <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25">
                                <i class="fas fa-download me-1"></i> Digital
                            </span>
                        <?php endif; ?>
                        <?php if($product->tags && count($product->tags) > 0): ?>
                            <?php $__currentLoopData = $product->tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <span class="badge bg-light text-dark"><?php echo e($tag); ?></span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            
            <?php if($product->inventories->count() > 0): ?>
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="fw-semibold mb-0"><i class="fas fa-warehouse me-2"></i>Warehouse Inventory</h6>
                    </div>
                    <div class="card-body">
                        <?php $__currentLoopData = $product->inventories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inventory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                                <div>
                                    <strong><?php echo e($inventory->warehouse->name); ?></strong>
                                    <?php if($inventory->warehouse->is_default): ?>
                                        <span class="badge bg-primary ms-1" style="font-size: 8px;">Default</span>
                                    <?php endif; ?>
                                </div>
                                <span class="badge bg-light text-dark"><?php echo e($inventory->quantity); ?></span>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php endif; ?>

            
            <?php if($product->weight || $product->length): ?>
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="fw-semibold mb-0"><i class="fas fa-truck me-2"></i>Shipping Details</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted">Weight</span>
                            <span><?php echo e($product->weight ? $product->weight . ' ' . ($product->weight_unit ?? 'kg') : '—'); ?></span>
                        </div>
                        <?php if($product->length || $product->width || $product->height): ?>
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted">Dimensions</span>
                                <span><?php echo e($product->length ?? 0); ?> × <?php echo e($product->width ?? 0); ?> × <?php echo e($product->height ?? 0); ?> <?php echo e($product->dimension_unit ?? 'cm'); ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if($product->warranty_type !== 'no_warranty' && $product->warranty_type): ?>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Warranty</span>
                                <span><?php echo e(ucfirst($product->warranty_type)); ?> <?php echo e($product->warranty_period ? "({$product->warranty_period} months)" : ''); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

            
            <?php if($product->min_order_quantity > 1 || $product->max_order_quantity): ?>
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="fw-semibold mb-0"><i class="fas fa-shopping-cart me-2"></i>Order Limits</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted">Min Order</span>
                            <span><?php echo e($product->min_order_quantity ?? 1); ?></span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Max Order</span>
                            <span><?php echo e($product->max_order_quantity ?? 'No limit'); ?></span>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            
            <?php if($product->meta_title || $product->meta_description || $product->meta_keywords || $product->canonical_url): ?>
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="fw-semibold mb-0"><i class="fas fa-search me-2"></i>SEO</h6>
                    </div>
                    <div class="card-body">
                        <?php if($product->meta_title): ?>
                            <div class="mb-3">
                                <small class="text-muted d-block mb-1">Meta Title</small>
                                <div class="p-2 bg-light rounded"><?php echo e($product->meta_title); ?></div>
                            </div>
                        <?php endif; ?>
                        <?php if($product->meta_description): ?>
                            <div class="mb-3">
                                <small class="text-muted d-block mb-1">Meta Description</small>
                                <div class="p-2 bg-light rounded"><?php echo e($product->meta_description); ?></div>
                            </div>
                        <?php endif; ?>
                        <?php if($product->meta_keywords): ?>
                            <div class="mb-3">
                                <small class="text-muted d-block mb-1">Meta Keywords</small>
                                <div>
                                    <?php $__currentLoopData = explode(',', $product->meta_keywords); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $keyword): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <span class="badge bg-light text-dark me-1"><?php echo e(trim($keyword)); ?></span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if($product->canonical_url): ?>
                            <div>
                                <small class="text-muted d-block mb-1">Canonical URL</small>
                                <div class="p-2 bg-light rounded"><code><?php echo e($product->canonical_url); ?></code></div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

            
            <?php if($product->review_count > 0): ?>
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="fw-semibold mb-0"><i class="fas fa-star me-2"></i>Reviews</h6>
                    </div>
                    <div class="card-body text-center">
                        <div class="h2 mb-0"><?php echo e(number_format($product->average_rating, 1)); ?></div>
                        <div class="text-warning">
                            <?php for($i = 1; $i <= 5; $i++): ?>
                                <i class="fas fa-star<?php echo e($i <= round($product->average_rating) ? '' : '-o'); ?>"></i>
                            <?php endfor; ?>
                        </div>
                        <small class="text-muted"><?php echo e($product->review_count); ?> review(s)</small>
                    </div>
                </div>
            <?php endif; ?>

            
            <div class="card">
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="<?php echo e(route('admin.products.edit', $product->id)); ?>" class="btn btn-primary">
                            <i class="fas fa-edit me-1"></i> Edit Product
                        </a>
                        <a href="<?php echo e(route('admin.products.duplicate', $product->id)); ?>" class="btn btn-outline-secondary">
                            <i class="fas fa-copy me-1"></i> Duplicate Product
                        </a>
                        <form action="<?php echo e(route('admin.products.destroy', $product->id)); ?>" method="POST"
                              onsubmit="return confirm('Are you sure you want to delete this product?');">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-outline-danger w-100">
                                <i class="fas fa-trash me-1"></i> Delete Product
                            </button>
                        </form>
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

<?php $__env->startPush('scripts'); ?>
<?php echo app('Illuminate\Foundation\Vite')(['resources/js/product.js']); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function(el) {
        return new bootstrap.Tooltip(el);
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\admin\products\show.blade.php ENDPATH**/ ?>