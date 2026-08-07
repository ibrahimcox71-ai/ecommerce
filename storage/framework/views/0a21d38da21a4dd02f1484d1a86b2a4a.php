<?php if (isset($component)) { $__componentOriginaledc75c655a063d12a477f2c8d8f324fc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc = $attributes; } ?>
<?php $component = App\View\Components\Layouts\AdminLayout::resolve(['title' => 'Category Details'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1"><?php echo e($category->name); ?></h4>
            <p class="text-muted small mb-0">
                <?php if (isset($component)) { $__componentOriginal0b3c95dd01f7182f54004b521151849d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b3c95dd01f7182f54004b521151849d = $attributes; } ?>
<?php $component = App\View\Components\Admin\Category\StatusBadge::resolve(['status' => $category->status] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.category.status-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Admin\Category\StatusBadge::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0b3c95dd01f7182f54004b521151849d)): ?>
<?php $attributes = $__attributesOriginal0b3c95dd01f7182f54004b521151849d; ?>
<?php unset($__attributesOriginal0b3c95dd01f7182f54004b521151849d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0b3c95dd01f7182f54004b521151849d)): ?>
<?php $component = $__componentOriginal0b3c95dd01f7182f54004b521151849d; ?>
<?php unset($__componentOriginal0b3c95dd01f7182f54004b521151849d); ?>
<?php endif; ?>
                <?php if($category->category_code): ?>
                    <span class="badge bg-light text-dark border ms-2"><?php echo e($category->category_code); ?></span>
                <?php endif; ?>
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="<?php echo e(route('admin.categories.edit', $category->id)); ?>" class="btn btn-primary">
                <i class="fas fa-edit me-1"></i> Edit
            </a>
            <a href="<?php echo e(route('admin.categories.index')); ?>" class="btn btn-outline-secondary">
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
                    <div class="row g-3">
                        <div class="col-md-6">
                            <dl class="mb-0">
                                <dt class="text-muted small">Name</dt>
                                <dd class="fw-semibold"><?php echo e($category->name); ?></dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <dl class="mb-0">
                                <dt class="text-muted small">Slug</dt>
                                <dd><code><?php echo e($category->slug); ?></code></dd>
                            </dl>
                        </div>
                        <?php if($category->category_code): ?>
                        <div class="col-md-6">
                            <dl class="mb-0">
                                <dt class="text-muted small">Category Code</dt>
                                <dd><span class="badge bg-light text-dark border"><?php echo e($category->category_code); ?></span></dd>
                            </dl>
                        </div>
                        <?php endif; ?>
                        <div class="col-md-6">
                            <dl class="mb-0">
                                <dt class="text-muted small">Sort Order</dt>
                                <dd>#<?php echo e($category->sort_order); ?></dd>
                            </dl>
                        </div>
                    </div>

                    <?php if($category->short_description): ?>
                        <hr>
                        <dl class="mb-0">
                            <dt class="text-muted small">Short Description</dt>
                            <dd><?php echo e($category->short_description); ?></dd>
                        </dl>
                    <?php endif; ?>

                    <?php if($category->description): ?>
                        <hr>
                        <dl class="mb-0">
                            <dt class="text-muted small">Full Description</dt>
                            <dd class="text-pre-wrap"><?php echo e($category->description); ?></dd>
                        </dl>
                    <?php endif; ?>
                </div>
            </div>

            
            <div class="card mb-4">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Display Settings</h6>
                </div>
                <div class="card-body">
                    <div class="row g-2">
                        <div class="col-6 col-md-4">
                            <span class="badge bg-<?php echo e($category->featured ? 'success' : 'secondary'); ?> bg-opacity-10 text-<?php echo e($category->featured ? 'success' : 'secondary'); ?> me-2 mb-2 p-2">
                                <i class="fas fa-star me-1"></i> Featured
                            </span>
                        </div>
                        <div class="col-6 col-md-4">
                            <span class="badge bg-<?php echo e($category->popular ? 'success' : 'secondary'); ?> bg-opacity-10 text-<?php echo e($category->popular ? 'success' : 'secondary'); ?> me-2 mb-2 p-2">
                                <i class="fas fa-fire me-1"></i> Popular
                            </span>
                        </div>
                        <div class="col-6 col-md-4">
                            <span class="badge bg-<?php echo e($category->show_on_homepage ? 'success' : 'secondary'); ?> bg-opacity-10 text-<?php echo e($category->show_on_homepage ? 'success' : 'secondary'); ?> me-2 mb-2 p-2">
                                <i class="fas fa-home me-1"></i> Homepage
                            </span>
                        </div>
                        <div class="col-6 col-md-4">
                            <span class="badge bg-<?php echo e($category->show_in_mega_menu ? 'success' : 'secondary'); ?> bg-opacity-10 text-<?php echo e($category->show_in_mega_menu ? 'success' : 'secondary'); ?> me-2 mb-2 p-2">
                                <i class="fas fa-bars me-1"></i> Mega Menu
                            </span>
                        </div>
                        <div class="col-6 col-md-4">
                            <span class="badge bg-<?php echo e($category->show_in_mobile_menu ? 'success' : 'secondary'); ?> bg-opacity-10 text-<?php echo e($category->show_in_mobile_menu ? 'success' : 'secondary'); ?> me-2 mb-2 p-2">
                                <i class="fas fa-mobile me-1"></i> Mobile Menu
                            </span>
                        </div>
                        <div class="col-6 col-md-4">
                            <span class="badge bg-<?php echo e($category->show_in_sidebar ? 'success' : 'secondary'); ?> bg-opacity-10 text-<?php echo e($category->show_in_sidebar ? 'success' : 'secondary'); ?> me-2 mb-2 p-2">
                                <i class="fas fa-th-list me-1"></i> Sidebar
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="card mb-4">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0">Products (<?php echo e($category->product_count); ?>)</h6>
                    <?php if($category->product_count > 0): ?>
                        <a href="<?php echo e(route('admin.products.index', ['category' => $category->id])); ?>" class="btn btn-sm btn-outline-primary">
                            View All
                        </a>
                    <?php endif; ?>
                </div>
                <div class="card-body p-0">
                    <?php $recentProducts = $category->products()->latest()->take(5)->get(); ?>
                    <?php if($recentProducts->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0 ps-4">Product</th>
                                        <th class="border-0 text-end">Price</th>
                                        <th class="border-0 text-center">Stock</th>
                                        <th class="border-0 text-end pe-4">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $recentProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center">
                                                    <?php if($product->featured_image): ?>
                                                        <img src="<?php echo e(asset('storage/' . $product->featured_image)); ?>"
                                                             alt="<?php echo e($product->name); ?>" class="rounded me-2"
                                                             style="width: 40px; height: 40px; object-fit: cover;" loading="lazy">
                                                    <?php endif; ?>
                                                    <span class="small"><?php echo e($product->name); ?></span>
                                                </div>
                                            </td>
                                            <td class="text-end small"><?php echo e(config('ecommerce.currency_symbol', '$')); ?><?php echo e(number_format($product->price, 2)); ?></td>
                                            <td class="text-center">
                                                <span class="badge bg-<?php echo e($product->stock > 10 ? 'success' : ($product->stock > 0 ? 'warning' : 'danger')); ?>">
                                                    <?php echo e($product->stock ?? 0); ?>

                                                </span>
                                            </td>
                                            <td class="text-end pe-4">
                                                <?php if($product->status === 'active'): ?>
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
                    <?php else: ?>
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-box-open fa-2x mb-2"></i>
                            <p class="mb-0">No products in this category</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            
            <div class="card">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Activity Log</h6>
                </div>
                <div class="card-body p-0">
                    <?php $logs = $category->activityLogs()->latest()->take(10)->get(); ?>
                    <?php if($logs->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0 ps-4">Action</th>
                                        <th class="border-0">Details</th>
                                        <th class="border-0 pe-4 text-end">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="ps-4">
                                                <span class="badge bg-<?php echo e(str_contains($log->description, 'created') ? 'success' : (str_contains($log->description, 'updated') ? 'info' : (str_contains($log->description, 'restored') ? 'primary' : 'warning'))); ?>">
                                                    <?php echo e($log->description); ?>

                                                </span>
                                            </td>
                                            <td>
                                                <?php if($log->properties): ?>
                                                    <?php $__currentLoopData = $log->properties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <small class="text-muted me-1"><?php echo e($key); ?>: <?php echo e(is_array($value) ? json_encode($value) : $value); ?></small>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endif; ?>
                                            </td>
                                            <td class="pe-4 text-end text-muted small">
                                                <?php echo e($log->created_at->format('M d, Y H:i')); ?>

                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-history fa-2x mb-2"></i>
                            <p class="mb-0">No activity recorded yet</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            
            <div class="card mb-4">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Media Overview</h6>
                </div>
                <div class="card-body">
                    <?php if($category->image): ?>
                        <div class="mb-3">
                            <label class="text-muted small">Category Image</label>
                            <img src="<?php echo e($category->image_url); ?>" alt="<?php echo e($category->name); ?>"
                                 class="img-fluid rounded w-100" style="max-height: 200px; object-fit: cover;" loading="lazy">
                        </div>
                    <?php endif; ?>
                    <?php if($category->thumbnail): ?>
                        <div class="mb-3">
                            <label class="text-muted small">Thumbnail</label>
                            <img src="<?php echo e($category->thumbnail_url); ?>" alt="Thumbnail"
                                 class="img-fluid rounded" style="max-height: 80px; object-fit: cover;" loading="lazy">
                        </div>
                    <?php endif; ?>
                    <?php if($category->banner): ?>
                        <div class="mb-3">
                            <label class="text-muted small">Banner</label>
                            <img src="<?php echo e($category->banner_url); ?>" alt="Banner"
                                 class="img-fluid rounded" style="max-height: 80px; object-fit: cover;" loading="lazy">
                        </div>
                    <?php endif; ?>
                    <?php if($category->icon): ?>
                        <div class="mb-0">
                            <label class="text-muted small">Icon</label>
                            <div><i class="<?php echo e($category->icon); ?> fa-2x"></i> <code class="ms-2"><?php echo e($category->icon); ?></code></div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            
            <div class="card mb-4">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Hierarchy</h6>
                </div>
                <div class="card-body">
                    <dl class="mb-3">
                        <dt class="text-muted small">Parent</dt>
                        <dd>
                            <?php if($category->parent): ?>
                                <a href="<?php echo e(route('admin.categories.show', $category->parent->id)); ?>" class="text-decoration-none">
                                    <i class="fas fa-level-up-alt me-1"></i> <?php echo e($category->parent->name); ?>

                                </a>
                            <?php else: ?>
                                <span class="text-muted">None (Top Level)</span>
                            <?php endif; ?>
                        </dd>
                    </dl>
                    <dl class="mb-0">
                        <dt class="text-muted small">Subcategories (<?php echo e($category->children_count); ?>)</dt>
                        <dd>
                            <?php if($category->children->count() > 0): ?>
                                <div class="list-group list-group-flush">
                                    <?php $__currentLoopData = $category->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <a href="<?php echo e(route('admin.categories.show', $child->id)); ?>"
                                           class="list-group-item list-group-item-action px-0 py-2 border-0 d-flex justify-content-between align-items-center">
                                            <span><i class="fas fa-level-down-alt me-2 text-muted"></i><?php echo e($child->name); ?></span>
                                            <?php if (isset($component)) { $__componentOriginal0b3c95dd01f7182f54004b521151849d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b3c95dd01f7182f54004b521151849d = $attributes; } ?>
<?php $component = App\View\Components\Admin\Category\StatusBadge::resolve(['status' => $category->status] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.category.status-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Admin\Category\StatusBadge::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0b3c95dd01f7182f54004b521151849d)): ?>
<?php $attributes = $__attributesOriginal0b3c95dd01f7182f54004b521151849d; ?>
<?php unset($__attributesOriginal0b3c95dd01f7182f54004b521151849d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0b3c95dd01f7182f54004b521151849d)): ?>
<?php $component = $__componentOriginal0b3c95dd01f7182f54004b521151849d; ?>
<?php unset($__componentOriginal0b3c95dd01f7182f54004b521151849d); ?>
<?php endif; ?>
                                        </a>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php else: ?>
                                <span class="text-muted">No subcategories</span>
                            <?php endif; ?>
                        </dd>
                    </dl>
                </div>
            </div>

            
            <div class="card mb-4">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Statistics</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Total Products</span>
                        <strong><?php echo e($category->product_count); ?></strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Active Products</span>
                        <strong class="text-success"><?php echo e($category->active_product_count); ?></strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Out of Stock</span>
                        <strong class="text-danger"><?php echo e($category->out_of_stock_count); ?></strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Subcategories</span>
                        <strong><?php echo e($category->children_count); ?></strong>
                    </div>
                    <div class="d-flex justify-content-between mb-0">
                        <span class="text-muted">Sort Order</span>
                        <strong>#<?php echo e($category->sort_order); ?></strong>
                    </div>
                </div>
            </div>

            
            <?php if($category->meta_title || $category->meta_description || $category->meta_keywords || $category->seo_image): ?>
            <div class="card mb-4">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">SEO</h6>
                </div>
                <div class="card-body">
                    <?php if($category->meta_title): ?>
                        <dl class="mb-2">
                            <dt class="text-muted small">SEO Title</dt>
                            <dd class="mb-0"><?php echo e($category->meta_title); ?></dd>
                        </dl>
                    <?php endif; ?>
                    <?php if($category->meta_description): ?>
                        <dl class="mb-2">
                            <dt class="text-muted small">Meta Description</dt>
                            <dd class="mb-0 small"><?php echo e(Str::limit($category->meta_description, 150)); ?></dd>
                        </dl>
                    <?php endif; ?>
                    <?php if($category->meta_keywords): ?>
                        <dl class="mb-2">
                            <dt class="text-muted small">Meta Keywords</dt>
                            <dd class="mb-0 small"><?php echo e($category->meta_keywords); ?></dd>
                        </dl>
                    <?php endif; ?>
                    <?php if($category->canonical_url): ?>
                        <dl class="mb-2">
                            <dt class="text-muted small">Canonical URL</dt>
                            <dd class="mb-0 small"><code><?php echo e($category->canonical_url); ?></code></dd>
                        </dl>
                    <?php endif; ?>
                    <?php if($category->seo_image): ?>
                        <dl class="mb-0">
                            <dt class="text-muted small">SEO Image (OG)</dt>
                            <dd><img src="<?php echo e($category->seo_image_url); ?>" alt="OG" class="img-fluid rounded" style="max-height: 80px;" loading="lazy"></dd>
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
                        <dd class="mb-0"><?php echo e($category->created_at->format('M d, Y H:i:s')); ?></dd>
                    </dl>
                    <dl class="mb-2">
                        <dt class="text-muted small">Updated</dt>
                        <dd class="mb-0"><?php echo e($category->updated_at->format('M d, Y H:i:s')); ?></dd>
                    </dl>
                    <dl class="mb-0">
                        <dt class="text-muted small">Full Slug</dt>
                        <dd class="mb-0"><code><?php echo e($category->full_slug); ?></code></dd>
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
<?php /**PATH C:\laragon\www\ecommerce\resources\views\admin\categories\show.blade.php ENDPATH**/ ?>