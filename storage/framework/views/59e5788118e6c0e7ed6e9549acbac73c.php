<?php if (isset($component)) { $__componentOriginaledc75c655a063d12a477f2c8d8f324fc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc = $attributes; } ?>
<?php $component = App\View\Components\Layouts\AdminLayout::resolve(['title' => 'Products'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
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
            <h4 class="fw-bold mb-1">Products</h4>
            <p class="text-muted small mb-0">Manage your product catalog</p>
        </div>
        <div class="d-flex gap-2">
            <a href="<?php echo e(route('admin.products.trashed')); ?>" class="btn btn-outline-secondary">
                <i class="fas fa-trash-alt me-1"></i> Trashed
            </a>
            <a href="<?php echo e(route('admin.products.create')); ?>" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Add Product
            </a>
        </div>
    </div>

    
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-6">
            <div class="stat-card-premium stat-border-primary">
                <div class="card-body">
                    <div class="stat-top">
                        <div class="stat-info">
                            <div class="stat-label">Total Products</div>
                            <div class="stat-value"><?php echo e($statistics['total']); ?></div>
                        </div>
                        <div class="stat-icon-wrap bg-icon-primary">
                            <i class="fas fa-box"></i>
                        </div>
                    </div>
                    <div class="stat-bottom">
                        <span class="stat-trend stat-trend-neutral"><?php echo e($statistics['simple']); ?> Simple</span>
                        <span class="stat-compare">· <?php echo e($statistics['variable']); ?> Variable</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="stat-card-premium stat-border-success">
                <div class="card-body">
                    <div class="stat-top">
                        <div class="stat-info">
                            <div class="stat-label">Published</div>
                            <div class="stat-value"><?php echo e($statistics['active']); ?></div>
                        </div>
                        <div class="stat-icon-wrap bg-icon-success">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                    <div class="stat-bottom">
                        <span class="stat-trend stat-trend-neutral"><?php echo e($statistics['draft']); ?> Draft</span>
                        <span class="stat-compare">· <?php echo e($statistics['hidden']); ?> Hidden</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="stat-card-premium stat-border-warning">
                <div class="card-body">
                    <div class="stat-top">
                        <div class="stat-info">
                            <div class="stat-label">Featured & Trending</div>
                            <div class="stat-value"><?php echo e($statistics['featured']); ?></div>
                        </div>
                        <div class="stat-icon-wrap bg-icon-warning">
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                    <div class="stat-bottom">
                        <span class="stat-trend stat-trend-neutral"><?php echo e($statistics['trending']); ?> Trending</span>
                        <span class="stat-compare">· <?php echo e($statistics['best_sellers']); ?> Best Seller</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="stat-card-premium stat-border-danger">
                <div class="card-body">
                    <div class="stat-top">
                        <div class="stat-info">
                            <div class="stat-label">Stock</div>
                            <div class="stat-value"><?php echo e($statistics['in_stock']); ?></div>
                        </div>
                        <div class="stat-icon-wrap bg-icon-danger">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                    </div>
                    <div class="stat-bottom">
                        <span class="stat-trend stat-trend-down"><?php echo e($statistics['low_stock']); ?> Low</span>
                        <span class="stat-compare">· <?php echo e($statistics['out_of_stock']); ?> Out</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="<?php echo e(route('admin.products.index')); ?>" class="row g-3" id="filterForm">
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
                        <input type="text" name="search" class="form-control product-search"
                               placeholder="Search products..." value="<?php echo e(request('search')); ?>"
                               data-url="<?php echo e(route('admin.products.search-suggestions')); ?>" autocomplete="off">
                        <div class="search-suggestions shadow-sm" id="searchSuggestions"></div>
                    </div>
                </div>
                <div class="col-md-1">
                    <select name="status" class="form-select">
                        <option value="">Status</option>
                        <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($status->value); ?>" <?php echo e(request('status') === $status->value ? 'selected' : ''); ?>>
                                <?php echo e($status->label()); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="category_id" class="form-select">
                        <option value="">Category</option>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($category->id); ?>" <?php echo e(request('category_id') == $category->id ? 'selected' : ''); ?>>
                                <?php echo e($category->name); ?>

                            </option>
                            <?php if($category->children->count() > 0): ?>
                                <?php $__currentLoopData = $category->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($child->id); ?>" <?php echo e(request('category_id') == $child->id ? 'selected' : ''); ?>>
                                        &nbsp;&nbsp;└ <?php echo e($child->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-1">
                    <select name="brand_id" class="form-select">
                        <option value="">Brand</option>
                        <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($brand->id); ?>" <?php echo e(request('brand_id') == $brand->id ? 'selected' : ''); ?>>
                                <?php echo e($brand->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-1">
                    <select name="product_type" class="form-select">
                        <option value="">Type</option>
                        <option value="simple" <?php echo e(request('product_type') === 'simple' ? 'selected' : ''); ?>>Simple</option>
                        <option value="variable" <?php echo e(request('product_type') === 'variable' ? 'selected' : ''); ?>>Variable</option>
                        <option value="digital" <?php echo e(request('product_type') === 'digital' ? 'selected' : ''); ?>>Digital</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <div class="d-flex gap-1">
                        <input type="date" name="date_from" class="form-control" placeholder="From"
                               value="<?php echo e(request('date_from')); ?>" title="From date">
                        <input type="date" name="date_to" class="form-control" placeholder="To"
                               value="<?php echo e(request('date_to')); ?>" title="To date">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="btn-group w-100">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-filter me-1"></i>Filter</button>
                        <a href="<?php echo e(route('admin.products.index')); ?>" class="btn btn-outline-secondary">Clear</a>
                    </div>
                </div>
            </form>
            <div class="row g-3 mt-2">
                <div class="col-md-12">
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="<?php echo e(route('admin.products.index', array_merge(request()->except(['featured', 'trending', 'best_seller', 'in_stock', 'low_stock', 'out_of_stock', 'with_discount']), ['featured' => 1]))); ?>"
                           class="badge bg-warning bg-opacity-10 text-warning text-decoration-none py-2 px-3 <?php echo e(request('featured') ? 'active' : ''); ?>">
                            <i class="fas fa-star me-1"></i> Featured
                        </a>
                        <a href="<?php echo e(route('admin.products.index', array_merge(request()->except(['featured', 'trending', 'best_seller', 'in_stock', 'low_stock', 'out_of_stock', 'with_discount']), ['trending' => 1]))); ?>"
                           class="badge bg-secondary bg-opacity-10 text-secondary text-decoration-none py-2 px-3 <?php echo e(request('trending') ? 'active' : ''); ?>">
                            <i class="fas fa-fire me-1"></i> Trending
                        </a>
                        <a href="<?php echo e(route('admin.products.index', array_merge(request()->except(['featured', 'trending', 'best_seller', 'in_stock', 'low_stock', 'out_of_stock', 'with_discount']), ['best_seller' => 1]))); ?>"
                           class="badge bg-success bg-opacity-10 text-success text-decoration-none py-2 px-3 <?php echo e(request('best_seller') ? 'active' : ''); ?>">
                            <i class="fas fa-trophy me-1"></i> Best Seller
                        </a>
                        <a href="<?php echo e(route('admin.products.index', array_merge(request()->except(['featured', 'trending', 'best_seller', 'in_stock', 'low_stock', 'out_of_stock', 'with_discount']), ['in_stock' => 1]))); ?>"
                           class="badge bg-info bg-opacity-10 text-info text-decoration-none py-2 px-3 <?php echo e(request('in_stock') ? 'active' : ''); ?>">
                            <i class="fas fa-box-open me-1"></i> In Stock
                        </a>
                        <a href="<?php echo e(route('admin.products.index', array_merge(request()->except(['featured', 'trending', 'best_seller', 'in_stock', 'low_stock', 'out_of_stock', 'with_discount']), ['low_stock' => 1]))); ?>"
                           class="badge bg-danger bg-opacity-10 text-danger text-decoration-none py-2 px-3 <?php echo e(request('low_stock') ? 'active' : ''); ?>">
                            <i class="fas fa-exclamation-triangle me-1"></i> Low Stock
                        </a>
                        <a href="<?php echo e(route('admin.products.index', array_merge(request()->except(['featured', 'trending', 'best_seller', 'in_stock', 'low_stock', 'out_of_stock', 'with_discount']), ['with_discount' => 1]))); ?>"
                           class="badge bg-primary bg-opacity-10 text-primary text-decoration-none py-2 px-3 <?php echo e(request('with_discount') ? 'active' : ''); ?>">
                            <i class="fas fa-tags me-1"></i> On Sale
                        </a>
                        <a href="<?php echo e(route('admin.products.index', array_merge(request()->except(['featured', 'trending', 'best_seller', 'in_stock', 'low_stock', 'out_of_stock', 'with_discount']), ['out_of_stock' => 1]))); ?>"
                           class="badge bg-dark bg-opacity-10 text-dark text-decoration-none py-2 px-3 <?php echo e(request('out_of_stock') ? 'active' : ''); ?>">
                            <i class="fas fa-times-circle me-1"></i> Out of Stock
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="d-none" id="bulkActions">
        <div class="alert alert-info d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
            <span><i class="fas fa-check-circle me-2"></i><span id="selectedCount">0</span> selected</span>
            <div class="d-flex gap-2">
                <select id="bulkStatus" class="form-select form-select-sm" style="width: auto;">
                    <option value="">Change Status...</option>
                    <option value="active">Published</option>
                    <option value="inactive">Inactive</option>
                    <option value="draft">Draft</option>
                    <option value="hidden">Hidden</option>
                    <option value="archived">Archived</option>
                </select>
                <button type="button" class="btn btn-sm btn-outline-primary" onclick="openBulkEdit()">
                    <i class="fas fa-pen me-1"></i> Bulk Edit
                </button>
                <button type="button" class="btn btn-sm btn-danger" onclick="bulkDelete()">
                    <i class="fas fa-trash me-1"></i> Delete
                </button>
            </div>
        </div>
    </div>

    
    <div class="card">
        <div class="card-body">
            <?php if($products->count() > 0): ?>
                <form id="bulkForm" method="POST" action="<?php echo e(route('admin.products.bulk-delete')); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle admin-product-table">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0" style="width: 36px;">
                                        <input type="checkbox" class="form-check-input" id="selectAll">
                                    </th>
                                    <th class="border-0">Product</th>
                                    <th class="border-0 d-none d-md-table-cell">SKU</th>
                                    <th class="border-0 d-none d-lg-table-cell">Category</th>
                                    <th class="border-0 text-center d-none d-lg-table-cell" style="width: 70px;">Stock</th>
                                    <th class="border-0 text-center" style="width: 90px;">Price</th>
                                    <th class="border-0 text-center" style="width: 90px;">Status</th>
                                    <th class="border-0 text-end" style="width: 100px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr data-id="<?php echo e($product->id); ?>">
                                        <td>
                                            <input type="checkbox" name="ids[]" value="<?php echo e($product->id); ?>"
                                                   class="form-check-input row-checkbox">
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <a href="<?php echo e(route('admin.products.edit', $product->id)); ?>" class="flex-shrink-0">
                                                    <?php if($product->thumbnail): ?>
                                                        <img src="<?php echo e($product->thumbnail_url); ?>" alt="<?php echo e($product->name); ?>"
                                                             class="rounded me-3" style="width: 48px; height: 48px; object-fit: cover;" loading="lazy">
                                                    <?php else: ?>
                                                        <div class="rounded me-3 d-flex align-items-center justify-content-center bg-light"
                                                             style="width: 48px; height: 48px;">
                                                            <i class="fas fa-box text-muted"></i>
                                                        </div>
                                                    <?php endif; ?>
                                                </a>
                                                <div class="min-w-0">
                                                    <a href="<?php echo e(route('admin.products.edit', $product->id)); ?>" class="text-decoration-none text-dark">
                                                        <span class="fw-semibold product-name"><?php echo e($product->name); ?></span>
                                                    </a>
                                                    <div class="small text-muted">
                                                        <?php if($product->brand): ?>
                                                            <span class="badge bg-secondary bg-opacity-10 text-secondary me-1"><?php echo e($product->brand->name); ?></span>
                                                        <?php endif; ?>
                                                        <?php if($product->product_type === 'variable'): ?>
                                                            <span class="badge bg-info bg-opacity-10 text-info me-1"><i class="fas fa-layer-group"></i></span>
                                                        <?php endif; ?>
                                                        <?php if($product->product_type === 'digital'): ?>
                                                            <span class="badge bg-primary bg-opacity-10 text-primary me-1"><i class="fas fa-download"></i></span>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="small mt-1">
                                                        <?php if($product->featured): ?>
                                                            <span class="badge bg-warning bg-opacity-10 text-warning p-1" style="font-size:8px;"><i class="fas fa-star"></i></span>
                                                        <?php endif; ?>
                                                        <?php if($product->trending): ?>
                                                            <span class="badge bg-secondary bg-opacity-10 text-secondary p-1" style="font-size:8px;"><i class="fas fa-fire"></i></span>
                                                        <?php endif; ?>
                                                        <?php if($product->best_seller): ?>
                                                            <span class="badge bg-success bg-opacity-10 text-success p-1" style="font-size:8px;"><i class="fas fa-trophy"></i></span>
                                                        <?php endif; ?>
                                                        <?php if($product->is_new_arrival): ?>
                                                            <span class="badge bg-info bg-opacity-10 text-info p-1" style="font-size:8px;"><i class="fas fa-clock"></i></span>
                                                        <?php endif; ?>
                                                        <?php if($product->has_discount): ?>
                                                            <span class="badge bg-primary bg-opacity-10 text-primary p-1" style="font-size:8px;"><i class="fas fa-tag"></i></span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="d-none d-md-table-cell">
                                            <code class="small"><?php echo e($product->sku); ?></code>
                                        </td>
                                        <td class="d-none d-lg-table-cell">
                                            <small class="text-muted"><?php echo e($product->category?->name ?? '—'); ?></small>
                                        </td>
                                        <td class="text-center d-none d-lg-table-cell">
                                            <?php if($product->unlimited_stock): ?>
                                                <span class="badge bg-success bg-opacity-10 text-success"><i class="fas fa-infinity"></i></span>
                                            <?php elseif($product->is_low_stock): ?>
                                                <span class="badge bg-warning bg-opacity-10 text-warning"><?php echo e($product->stock); ?></span>
                                            <?php elseif($product->is_out_of_stock): ?>
                                                <span class="badge bg-danger bg-opacity-10 text-danger">Out</span>
                                            <?php else: ?>
                                                <span class="badge bg-light text-dark"><?php echo e($product->stock); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <div>
                                                <span class="fw-semibold"><?php echo e(config('ecommerce.currency_symbol')); ?><?php echo e(number_format($product->current_price, 2)); ?></span>
                                                <?php if($product->discount > 0): ?>
                                                    <small class="text-muted text-decoration-line-through d-block" style="font-size:10px;">
                                                        <?php echo e(config('ecommerce.currency_symbol')); ?><?php echo e(number_format($product->price, 2)); ?>

                                                    </small>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-<?php echo e($product->status->color()); ?> bg-opacity-10 text-<?php echo e($product->status->color()); ?> product-status-badge">
                                                <?php echo e($product->status->label()); ?>

                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <a class="dropdown-item" href="<?php echo e(route('admin.products.show', $product->id)); ?>">
                                                            <i class="fas fa-eye me-2 text-muted"></i> View
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="<?php echo e(route('admin.products.edit', $product->id)); ?>">
                                                            <i class="fas fa-edit me-2 text-muted"></i> Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item quick-edit-btn" href="#" data-id="<?php echo e($product->id); ?>">
                                                            <i class="fas fa-bolt me-2 text-muted"></i> Quick Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="<?php echo e(route('admin.products.duplicate', $product->id)); ?>">
                                                            <i class="fas fa-copy me-2 text-muted"></i> Duplicate
                                                        </a>
                                                    </li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <form action="<?php echo e(route('admin.products.destroy', $product->id)); ?>" method="POST"
                                                              onsubmit="return confirm('Are you sure you want to delete <?php echo e(addslashes($product->name)); ?>?');">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('DELETE'); ?>
                                                            <button type="submit" class="dropdown-item text-danger">
                                                                <i class="fas fa-trash me-2"></i> Delete
                                                            </button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </form>

                <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-2">
                    <div class="text-muted small">
                        Showing <?php echo e($products->firstItem()); ?> to <?php echo e($products->lastItem()); ?> of <?php echo e($products->total()); ?> entries
                        &nbsp;|&nbsp;
                        <select name="per_page" onchange="window.location.href=this.value" class="form-select form-select-sm d-inline-block" style="width: auto;">
                            <option value="<?php echo e(route('admin.products.index', array_merge(request()->all(), ['per_page' => 15]))); ?>" <?php echo e($products->perPage() == 15 ? 'selected' : ''); ?>>15</option>
                            <option value="<?php echo e(route('admin.products.index', array_merge(request()->all(), ['per_page' => 25]))); ?>" <?php echo e($products->perPage() == 25 ? 'selected' : ''); ?>>25</option>
                            <option value="<?php echo e(route('admin.products.index', array_merge(request()->all(), ['per_page' => 50]))); ?>" <?php echo e($products->perPage() == 50 ? 'selected' : ''); ?>>50</option>
                            <option value="<?php echo e(route('admin.products.index', array_merge(request()->all(), ['per_page' => 100]))); ?>" <?php echo e($products->perPage() == 100 ? 'selected' : ''); ?>>100</option>
                        </select>
                        &nbsp;|&nbsp;
                        <div class="btn-group btn-group-sm">
                            <a href="<?php echo e(route('admin.products.export.csv', request()->only(['status', 'category_id', 'brand_id', 'product_type', 'search']))); ?>"
                               class="btn btn-outline-success" title="Export CSV">
                                <i class="fas fa-file-csv me-1"></i> CSV
                            </a>
                            <a href="<?php echo e(route('admin.products.export.excel', request()->only(['status', 'category_id', 'brand_id', 'product_type', 'search']))); ?>"
                               class="btn btn-outline-primary" title="Export Excel">
                                <i class="fas fa-file-excel me-1"></i> Excel
                            </a>
                        </div>
                    </div>
                    <div>
                        <?php echo e($products->links()); ?>

                    </div>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                    <h5>No products found</h5>
                    <p class="text-muted">
                        <?php if(request()->anyFilled(['search', 'status', 'category_id', 'brand_id', 'featured', 'trending', 'best_seller', 'in_stock', 'low_stock', 'with_discount'])): ?>
                            No products match your filters. <a href="<?php echo e(route('admin.products.index')); ?>">Clear filters</a>
                        <?php else: ?>
                            Get started by adding your first product.
                        <?php endif; ?>
                    </p>
                    <a href="<?php echo e(route('admin.products.create')); ?>" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Add Product
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


<div class="modal fade" id="quickEditModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-bolt me-2 text-warning"></i>Quick Edit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="quickEditForm" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label">Product Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="qe_name" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">SKU</label>
                            <input type="text" class="form-control" id="qe_sku" readonly disabled>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Price <span class="text-danger">*</span></label>
                            <input type="number" name="price" id="qe_price" class="form-control" step="0.01" min="0" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Cost Price</label>
                            <input type="number" name="cost_price" id="qe_cost_price" class="form-control" step="0.01" min="0">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Stock <span class="text-danger">*</span></label>
                            <input type="number" name="stock" id="qe_stock" class="form-control" min="0" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Status</label>
                            <select name="status" id="qe_status" class="form-select">
                                <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($status->value); ?>"><?php echo e($status->label()); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Category</label>
                            <select name="category_id" id="qe_category_id" class="form-select">
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Brand</label>
                            <select name="brand_id" id="qe_brand_id" class="form-select">
                                <option value="">Select Brand</option>
                                <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($brand->id); ?>"><?php echo e($brand->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <hr class="my-1">
                            <label class="form-label mb-2">Flags</label>
                            <div class="d-flex gap-3">
                                <div class="form-check form-switch">
                                    <input type="checkbox" class="form-check-input" name="featured" id="qe_featured" value="1">
                                    <label class="form-check-label" for="qe_featured">Featured</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input type="checkbox" class="form-check-input" name="trending" id="qe_trending" value="1">
                                    <label class="form-check-label" for="qe_trending">Trending</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input type="checkbox" class="form-check-input" name="best_seller" id="qe_best_seller" value="1">
                                    <label class="form-check-label" for="qe_best_seller">Best Seller</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="bulkEditModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-pen me-2 text-primary"></i>Bulk Edit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="bulkEditForm" method="POST" action="<?php echo e(route('admin.products.bulk-edit')); ?>">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="alert alert-info py-2 small">
                        <i class="fas fa-info-circle me-1"></i> Only filled fields will be applied to selected products.
                    </div>
                    <div id="bulkEditIds"></div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select name="fields[status]" class="form-select">
                                <option value="">— No Change —</option>
                                <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($status->value); ?>"><?php echo e($status->label()); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Category</label>
                            <select name="fields[category_id]" class="form-select">
                                <option value="">— No Change —</option>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Brand</label>
                            <select name="fields[brand_id]" class="form-select">
                                <option value="">— No Change —</option>
                                <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($brand->id); ?>"><?php echo e($brand->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Price</label>
                            <input type="number" name="fields[price]" class="form-control" step="0.01" min="0" placeholder="Leave empty to skip">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Cost Price</label>
                            <input type="number" name="fields[cost_price]" class="form-control" step="0.01" min="0" placeholder="Leave empty to skip">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Stock</label>
                            <input type="number" name="fields[stock]" class="form-control" min="0" placeholder="Leave empty to skip">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tax (%)</label>
                            <input type="number" name="fields[tax]" class="form-control" step="0.01" min="0" max="100" placeholder="Leave empty to skip">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Low Stock Threshold</label>
                            <input type="number" name="fields[low_stock_threshold]" class="form-control" min="0" placeholder="Leave empty to skip">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Apply to Selected
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<?php echo app('Illuminate\Foundation\Vite')(['resources/js/product.js']); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAll = document.getElementById('selectAll');
    const bulkActions = document.getElementById('bulkActions');
    const selectedCount = document.getElementById('selectedCount');
    const bulkForm = document.getElementById('bulkForm');
    const bulkStatus = document.getElementById('bulkStatus');

    if (selectAll) {
        selectAll.addEventListener('change', function() {
            document.querySelectorAll('.row-checkbox').forEach(function(cb) {
                cb.checked = selectAll.checked;
            });
            updateBulkActions();
        });
    }

    document.querySelectorAll('.row-checkbox').forEach(function(cb) {
        cb.addEventListener('change', updateBulkActions);
    });

    function updateBulkActions() {
        var checked = document.querySelectorAll('.row-checkbox:checked').length;
        if (checked > 0) {
            bulkActions.classList.remove('d-none');
            selectedCount.textContent = checked;
        } else {
            bulkActions.classList.add('d-none');
        }
    }

    // Bulk status change
    if (bulkStatus) {
        bulkStatus.addEventListener('change', function() {
            var status = this.value;
            if (status && confirm('Change status of selected products to "' + status + '"?')) {
                bulkForm.action = '<?php echo e(route('admin.products.bulk-update-status')); ?>';
                var input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'status';
                input.value = status;
                bulkForm.appendChild(input);
                bulkForm.submit();
            }
        });
    }

    // Quick Edit
    document.querySelectorAll('.quick-edit-btn').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            var id = this.dataset.id;
            var url = '/admin/products/' + id + '/quick-edit';

            fetch(url)
                .then(function(r) { return r.json(); })
                .then(function(response) {
                    if (response.success) {
                        var d = response.data;
                        document.getElementById('qe_name').value = d.name;
                        document.getElementById('qe_sku').value = d.sku;
                        document.getElementById('qe_price').value = d.price;
                        document.getElementById('qe_cost_price').value = d.cost_price || '';
                        document.getElementById('qe_stock').value = d.stock;
                        document.getElementById('qe_status').value = d.status;
                        document.getElementById('qe_category_id').value = d.category_id;
                        document.getElementById('qe_brand_id').value = d.brand_id || '';
                        document.getElementById('qe_featured').checked = d.featured;
                        document.getElementById('qe_trending').checked = d.trending;
                        document.getElementById('qe_best_seller').checked = d.best_seller;

                        var form = document.getElementById('quickEditForm');
                        form.action = '/admin/products/' + id + '/quick-update';

                        new bootstrap.Modal(document.getElementById('quickEditModal')).show();
                    }
                });
        });
    });

    // Quick edit form submit
    document.getElementById('quickEditForm').addEventListener('submit', function(e) {
        e.preventDefault();
        var form = this;
        var formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                'Accept': 'application/json',
            },
            body: formData
        })
        .then(function(r) { return r.json(); })
        .then(function(response) {
            if (response.success) {
                bootstrap.Modal.getInstance(document.getElementById('quickEditModal')).hide();
                showToast(response.message, 'success');
                setTimeout(function() { location.reload(); }, 1000);
            }
        })
        .catch(function() {
            showToast('An error occurred', 'error');
        });
    });

    // Featured toggle
    document.addEventListener('change', function(e) {
        var toggle = e.target.closest('.featured-toggle');
        if (!toggle) return;

        var id = toggle.dataset.id;
        fetch('/admin/products/' + id + '/toggle-featured', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            },
            body: JSON.stringify({})
        })
        .then(function(r) { return r.json(); })
        .then(function(response) {
            if (response.success) {
                showToast(response.message, 'success');
            }
        })
        .catch(function() {
            showToast('An error occurred', 'error');
        });
    });

    // Search suggestions
    var searchInput = document.querySelector('.product-search');
    var suggestions = document.getElementById('searchSuggestions');
    var suggestionTimer;

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(suggestionTimer);
            var q = this.value.trim();
            if (q.length < 2) {
                suggestions.classList.remove('show');
                return;
            }
            suggestionTimer = setTimeout(function() {
                fetch(searchInput.dataset.url + '?q=' + encodeURIComponent(q))
                    .then(function(r) { return r.json(); })
                    .then(function(response) {
                        if (response.success && response.data.length > 0) {
                            var html = '';
                            response.data.forEach(function(p) {
                                html += '<a href="/admin/products/' + p.id + '/edit" class="suggestion-item">';
                                if (p.image) html += '<img src="' + p.image + '" alt="">';
                                html += '<div><strong>' + p.name + '</strong><small>SKU: ' + p.sku + ' | $' + p.price + '</small></div>';
                                html += '</a>';
                            });
                            suggestions.innerHTML = html;
                            suggestions.classList.add('show');
                        } else {
                            suggestions.classList.remove('show');
                        }
                    });
            }, 300);
        });

        searchInput.addEventListener('blur', function() {
            setTimeout(function() { suggestions.classList.remove('show'); }, 200);
        });
    }
});

function bulkDelete() {
    if (confirm('Are you sure you want to delete selected products?')) {
        var form = document.getElementById('bulkForm');
        form.action = '<?php echo e(route('admin.products.bulk-delete')); ?>';
        form.submit();
    }
}

function openBulkEdit() {
    var checked = document.querySelectorAll('.row-checkbox:checked');
    var idsHtml = '';
    checked.forEach(function(cb) {
        idsHtml += '<input type="hidden" name="ids[]" value="' + cb.value + '">';
    });
    document.getElementById('bulkEditIds').innerHTML = idsHtml;
    new bootstrap.Modal(document.getElementById('bulkEditModal')).show();
}

function showToast(message, type) {
    type = type || 'info';
    var bgClass = type === 'success' ? 'bg-success' : type === 'error' ? 'bg-danger' : 'bg-info';
    var icon = type === 'success' ? 'check' : type === 'error' ? 'times' : 'info';

    var wrapper = document.createElement('div');
    wrapper.className = 'position-fixed bottom-0 end-0 p-3';
    wrapper.style.zIndex = '9999';
    wrapper.innerHTML = '<div class="toast ' + bgClass + ' text-white" role="alert">' +
        '<div class="toast-body d-flex align-items-center">' +
            '<i class="fas fa-' + icon + ' me-2"></i> ' + message +
        '</div>' +
    '</div>';
    document.body.appendChild(wrapper);

    var toastEl = wrapper.querySelector('.toast');
    var toast = new bootstrap.Toast(toastEl, { delay: 3000 });
    toast.show();

    toastEl.addEventListener('hidden.bs.toast', function() {
        wrapper.remove();
    });
}
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\admin\products\index.blade.php ENDPATH**/ ?>