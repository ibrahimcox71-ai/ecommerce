<?php if (isset($component)) { $__componentOriginaledc75c655a063d12a477f2c8d8f324fc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc = $attributes; } ?>
<?php $component = App\View\Components\Layouts\AdminLayout::resolve(['title' => 'Brand Details'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1"><?php echo e($brand->name); ?></h4>
            <p class="text-muted small mb-0">Brand details and information</p>
        </div>
        <div class="d-flex gap-2">
            <a href="<?php echo e(route('admin.brands.edit', $brand->id)); ?>" class="btn btn-primary">
                <i class="fas fa-edit me-1"></i> Edit
            </a>
            <a href="<?php echo e(route('admin.brands.index')); ?>" class="btn btn-outline-secondary">
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
                            <dl class="mb-0">
                                <dt class="text-muted small">Brand Name</dt>
                                <dd class="fw-semibold mb-0"><?php echo e($brand->name); ?></dd>
                            </dl>
                        </div>
                        <div class="col-md-6 mb-3">
                            <dl class="mb-0">
                                <dt class="text-muted small">Brand Code</dt>
                                <dd class="mb-0">
                                    <?php if($brand->brand_code): ?>
                                        <span class="badge bg-light text-dark border"><?php echo e($brand->brand_code); ?></span>
                                    <?php else: ?>
                                        <span class="text-muted">—</span>
                                    <?php endif; ?>
                                </dd>
                            </dl>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <dl class="mb-0">
                                <dt class="text-muted small">Slug</dt>
                                <dd class="mb-0"><code><?php echo e($brand->slug); ?></code></dd>
                            </dl>
                        </div>
                        <div class="col-md-6 mb-3">
                            <dl class="mb-0">
                                <dt class="text-muted small">Country</dt>
                                <dd class="mb-0"><?php echo e($brand->country ?? '—'); ?></dd>
                            </dl>
                        </div>
                    </div>

                    <?php if($brand->description): ?>
                        <hr>
                        <dl class="mb-0">
                            <dt class="text-muted small">Description</dt>
                            <dd><?php echo e($brand->description); ?></dd>
                        </dl>
                    <?php endif; ?>

                    <hr>
                    <div class="row">
                        <?php if($brand->website): ?>
                            <div class="col-md-4 mb-2">
                                <dl class="mb-0">
                                    <dt class="text-muted small"><i class="fas fa-globe me-1"></i> Website</dt>
                                    <dd class="mb-0"><a href="<?php echo e($brand->website); ?>" target="_blank" class="small"><?php echo e($brand->website); ?></a></dd>
                                </dl>
                            </div>
                        <?php endif; ?>
                        <?php if($brand->email): ?>
                            <div class="col-md-4 mb-2">
                                <dl class="mb-0">
                                    <dt class="text-muted small"><i class="fas fa-envelope me-1"></i> Email</dt>
                                    <dd class="mb-0"><a href="mailto:<?php echo e($brand->email); ?>" class="small"><?php echo e($brand->email); ?></a></dd>
                                </dl>
                            </div>
                        <?php endif; ?>
                        <?php if($brand->phone): ?>
                            <div class="col-md-4 mb-2">
                                <dl class="mb-0">
                                    <dt class="text-muted small"><i class="fas fa-phone me-1"></i> Phone</dt>
                                    <dd class="mb-0 small"><?php echo e($brand->phone); ?></dd>
                                </dl>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            
            <?php if($brand->banner): ?>
                <div class="card mb-4">
                    <div class="card-header bg-transparent">
                        <h6 class="fw-bold mb-0">Banner</h6>
                    </div>
                    <div class="card-body p-0">
                        <img src="<?php echo e($brand->banner_url); ?>" alt="<?php echo e($brand->name); ?> Banner"
                             class="img-fluid rounded-bottom w-100" style="max-height: 300px; object-fit: cover;">
                    </div>
                </div>
            <?php endif; ?>

            
            <div class="card">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Activity Log</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 ps-4">Action</th>
                                    <th class="border-0">By</th>
                                    <th class="border-0 pe-4 text-end">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $brand->activityLogs()->latest()->take(20)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td class="ps-4">
                                            <span class="badge bg-<?php echo e(str_contains($log->description, 'created') ? 'success' : (str_contains($log->description, 'updated') ? 'info' : (str_contains($log->description, 'restored') ? 'warning' : 'secondary'))); ?>">
                                                <?php echo e($log->description); ?>

                                            </span>
                                        </td>
                                        <td class="small">
                                            <?php if($log->causer): ?>
                                                <?php echo e($log->causer->name ?? 'Unknown'); ?>

                                            <?php else: ?>
                                                <span class="text-muted">System</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="pe-4 text-end text-muted small">
                                            <?php echo e($log->created_at->format('M d, Y H:i')); ?>

                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="3" class="text-center py-4 text-muted">
                                            No activity logs found
                                        </td>
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
                    <h6 class="fw-bold mb-0">Logo & Status</h6>
                </div>
                <div class="card-body text-center">
                    <?php if($brand->logo): ?>
                        <img src="<?php echo e($brand->logo_url); ?>" alt="<?php echo e($brand->name); ?>"
                             class="img-fluid rounded mb-3" style="max-height: 150px;">
                    <?php elseif($brand->image): ?>
                        <img src="<?php echo e($brand->image_url); ?>" alt="<?php echo e($brand->name); ?>"
                             class="img-fluid rounded mb-3" style="max-height: 150px;">
                    <?php else: ?>
                        <div class="bg-light rounded p-4 mb-3">
                            <i class="fas fa-building fa-3x text-muted"></i>
                        </div>
                    <?php endif; ?>

                    <div class="d-flex justify-content-center gap-2 flex-wrap mb-0">
                        <?php
                            $statusColors = ['active' => 'success', 'inactive' => 'secondary', 'hidden' => 'dark'];
                            $statusIcons = ['active' => 'fa-check-circle', 'inactive' => 'fa-pause-circle', 'hidden' => 'fa-eye-slash'];
                        ?>
                        <span class="badge bg-<?php echo e($statusColors[$brand->status->value] ?? 'secondary'); ?>">
                            <i class="fas <?php echo e($statusIcons[$brand->status->value] ?? 'fa-circle'); ?> me-1"></i>
                            <?php echo e($brand->status->label()); ?>

                        </span>
                        <?php if($brand->featured): ?>
                            <span class="badge bg-warning"><i class="fas fa-star me-1"></i> Featured</span>
                        <?php endif; ?>
                        <?php if($brand->popular): ?>
                            <span class="badge bg-info"><i class="fas fa-fire me-1"></i> Popular</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            
            <div class="card mb-4">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Product Statistics</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Total Products</span>
                        <span class="badge bg-primary"><?php echo e($brand->products_count); ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Active Products</span>
                        <span class="badge bg-success"><?php echo e($brand->active_products_count); ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-0">
                        <span class="text-muted">Sort Order</span>
                        <span class="fw-semibold"><?php echo e($brand->sort_order); ?></span>
                    </div>
                </div>
            </div>

            
            <?php if($brand->meta_title || $brand->meta_description || $brand->meta_keywords || $brand->canonical_url): ?>
                <div class="card mb-4">
                    <div class="card-header bg-transparent">
                        <h6 class="fw-bold mb-0">SEO</h6>
                    </div>
                    <div class="card-body">
                        <?php if($brand->meta_title): ?>
                            <dl class="mb-2">
                                <dt class="text-muted small">Meta Title</dt>
                                <dd class="mb-0 small"><?php echo e($brand->meta_title); ?></dd>
                            </dl>
                        <?php endif; ?>
                        <?php if($brand->meta_description): ?>
                            <dl class="mb-2">
                                <dt class="text-muted small">Meta Description</dt>
                                <dd class="mb-0 small"><?php echo e(Str::limit($brand->meta_description, 100)); ?></dd>
                            </dl>
                        <?php endif; ?>
                        <?php if($brand->meta_keywords): ?>
                            <dl class="mb-2">
                                <dt class="text-muted small">Meta Keywords</dt>
                                <dd class="mb-0 small"><?php echo e($brand->meta_keywords); ?></dd>
                            </dl>
                        <?php endif; ?>
                        <?php if($brand->canonical_url): ?>
                            <dl class="mb-0">
                                <dt class="text-muted small">Canonical URL</dt>
                                <dd class="mb-0 small"><a href="<?php echo e($brand->canonical_url); ?>" target="_blank"><?php echo e(Str::limit($brand->canonical_url, 40)); ?></a></dd>
                            </dl>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

            
            <div class="card">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Timestamps</h6>
                </div>
                <div class="card-body">
                    <dl class="mb-2">
                        <dt class="text-muted small">Created</dt>
                        <dd class="mb-0"><?php echo e($brand->created_at->format('M d, Y H:i')); ?></dd>
                    </dl>
                    <dl class="mb-2">
                        <dt class="text-muted small">Updated</dt>
                        <dd class="mb-0"><?php echo e($brand->updated_at->format('M d, Y H:i')); ?></dd>
                    </dl>
                    <?php if($brand->is_hidden): ?>
                        <dl class="mb-0">
                            <dt class="text-muted small">Visibility</dt>
                            <dd class="mb-0"><span class="badge bg-dark">Hidden from listings</span></dd>
                        </dl>
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
<?php /**PATH C:\laragon\www\ecommerce\resources\views\admin\brands\show.blade.php ENDPATH**/ ?>