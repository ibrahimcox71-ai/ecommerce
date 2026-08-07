<nav class="category-nav">
    <div class="container">
        <div class="category-nav-inner">
            <div class="nav-categories-list">
                <a href="<?php echo e(route('shop')); ?>" class="nav-cat-link <?php echo e(request()->routeIs('home') ? '' : ''); ?>">
                    <i class="fas fa-th-large"></i> All Categories
                </a>
                <?php
                    $menuCategories = \App\Models\Category::active()
                        ->parents()
                        ->withCount('products')
                        ->sorted()
                        ->take(10)
                        ->get();
                ?>
                <?php $__currentLoopData = $menuCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="nav-cat-dropdown">
                    <a href="<?php echo e(route('category.show', $cat->slug)); ?>" class="nav-cat-link">
                        <?php if($cat->icon): ?> <i class="<?php echo e($cat->icon); ?>"></i> <?php endif; ?>
                        <?php echo e($cat->name); ?>

                    </a>
                    <?php if($cat->children->isNotEmpty()): ?>
                    <div class="mega-dropdown">
                        <div class="mega-dropdown-inner">
                            <div class="mega-col">
                                <h6><?php echo e($cat->name); ?></h6>
                                <?php $__currentLoopData = $cat->children->take(8); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="<?php echo e(route('category.show', $child->slug)); ?>">
                                    <i class="fas fa-chevron-right"></i> <?php echo e($child->name); ?>

                                </a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <div class="mega-col mega-col-featured">
                                <h6>Featured</h6>
                                <a href="<?php echo e(route('shop', ['category' => $cat->slug, 'sort' => 'best-seller'])); ?>">
                                    <i class="fas fa-crown"></i> Best Sellers
                                </a>
                                <a href="<?php echo e(route('shop', ['category' => $cat->slug, 'sort' => 'newest'])); ?>">
                                    <i class="fas fa-sparkles"></i> New Arrivals
                                </a>
                                <a href="<?php echo e(route('flash-sale')); ?>">
                                    <i class="fas fa-bolt"></i> Flash Sale
                                </a>
                            </div>
                            <div class="mega-col mega-col-banner">
                                <div class="mega-banner">
                                    <div class="mega-banner-content">
                                        <span class="mega-banner-label">Limited Offer</span>
                                        <h5>Up to 50% Off</h5>
                                        <p>On <?php echo e($cat->name); ?></p>
                                        <a href="<?php echo e(route('shop', ['category' => $cat->slug])); ?>" class="mega-banner-btn">
                                            Shop Now <i class="fas fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="nav-special-links">
                <a href="<?php echo e(route('flash-sale')); ?>" class="nav-special-link sale-link">
                    <i class="fas fa-bolt"></i> Flash Sale
                </a>
                <a href="<?php echo e(route('shop', ['sort' => 'best-seller'])); ?>" class="nav-special-link">
                    <i class="fas fa-crown"></i> Best Sellers
                </a>
            </div>
        </div>
    </div>
</nav>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\partials\frontend\mega-menu.blade.php ENDPATH**/ ?>