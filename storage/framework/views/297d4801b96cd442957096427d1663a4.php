<?php if (isset($component)) { $__componentOriginaleac9542bb5e3f887e862d1d96c472e9b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaleac9542bb5e3f887e862d1d96c472e9b = $attributes; } ?>
<?php $component = App\View\Components\Layouts\FrontendLayout::resolve(['title' => 'Shop','seoData' => $seoData ?? []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.frontend-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\FrontendLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

<div class="shop-page">
    
    <div class="sticky-filter-bar" id="stickyFilterBar">
        <div class="container">
            <div class="filter-bar-inner">
                <div class="filter-bar-left">
                    <button class="filter-toggle-btn d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#filterOffcanvas" aria-label="Toggle filters">
                        <i class="fas fa-sliders-h"></i>
                        <span>Filters</span>
                        <?php if(request()->hasAny(['category', 'brand', 'min_price', 'max_price', 'rating', 'in_stock', 'on_sale'])): ?>
                            <span class="filter-active-dot"></span>
                        <?php endif; ?>
                    </button>
                    <div class="filter-bar-info">
                        <span class="results-count">
                            <strong><?php echo e($products->total()); ?></strong> results
                        </span>
                        <?php if(request('q')): ?>
                            <span class="search-query">for "<strong><?php echo e(request('q')); ?></strong>"</span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="filter-bar-right">
                    <div class="view-toggle d-none d-md-flex" role="group" aria-label="View toggle">
                        <button class="view-btn active" data-view="grid" aria-label="Grid view"><i class="fas fa-th"></i></button>
                        <button class="view-btn" data-view="list" aria-label="List view"><i class="fas fa-list"></i></button>
                    </div>
                    <div class="sort-group">
                        <label class="sort-label">Sort by:</label>
                        <select class="sort-select" onchange="window.location.href=this.value" aria-label="Sort products">
                            <option value="<?php echo e(request()->fullUrlWithQuery(['sort' => 'latest'])); ?>" <?php if(request('sort', 'latest') === 'latest'): echo 'selected'; endif; ?>>Latest</option>
                            <option value="<?php echo e(request()->fullUrlWithQuery(['sort' => 'price-low'])); ?>" <?php if(request('sort') === 'price-low'): echo 'selected'; endif; ?>>Price: Low to High</option>
                            <option value="<?php echo e(request()->fullUrlWithQuery(['sort' => 'price-high'])); ?>" <?php if(request('sort') === 'price-high'): echo 'selected'; endif; ?>>Price: High to Low</option>
                            <option value="<?php echo e(request()->fullUrlWithQuery(['sort' => 'name'])); ?>" <?php if(request('sort') === 'name'): echo 'selected'; endif; ?>>Name: A-Z</option>
                            <option value="<?php echo e(request()->fullUrlWithQuery(['sort' => 'rating'])); ?>" <?php if(request('sort') === 'rating'): echo 'selected'; endif; ?>>Top Rated</option>
                            <option value="<?php echo e(request()->fullUrlWithQuery(['sort' => 'discount'])); ?>" <?php if(request('sort') === 'discount'): echo 'selected'; endif; ?>>Biggest Discount</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container py-4">
        <?php if (isset($component)) { $__componentOriginalcc52fffb9c918b8f3f4cf5faa6f3a53c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcc52fffb9c918b8f3f4cf5faa6f3a53c = $attributes; } ?>
<?php $component = App\View\Components\Frontend\Breadcrumb::resolve(['items' => [['label' => 'Shop']]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('frontend.breadcrumb'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Frontend\Breadcrumb::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalcc52fffb9c918b8f3f4cf5faa6f3a53c)): ?>
<?php $attributes = $__attributesOriginalcc52fffb9c918b8f3f4cf5faa6f3a53c; ?>
<?php unset($__attributesOriginalcc52fffb9c918b8f3f4cf5faa6f3a53c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalcc52fffb9c918b8f3f4cf5faa6f3a53c)): ?>
<?php $component = $__componentOriginalcc52fffb9c918b8f3f4cf5faa6f3a53c; ?>
<?php unset($__componentOriginalcc52fffb9c918b8f3f4cf5faa6f3a53c); ?>
<?php endif; ?>

        <div class="row">
            
            <div class="offcanvas offcanvas-start filter-offcanvas" tabindex="-1" id="filterOffcanvas" aria-labelledby="filterOffcanvasLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title fw-bold" id="filterOffcanvasLabel"><i class="fas fa-sliders-h me-2 text-primary"></i>Filters</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close filters"></button>
                </div>
                <div class="offcanvas-body">
                    <?php if (isset($component)) { $__componentOriginal063d692a706e46a49fa25a390252e208 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal063d692a706e46a49fa25a390252e208 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.shop-filters','data' => ['categories' => $categories,'brands' => $brands,'maxPrice' => $maxPrice ?? 1000]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('shop-filters'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['categories' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($categories),'brands' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($brands),'maxPrice' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($maxPrice ?? 1000)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal063d692a706e46a49fa25a390252e208)): ?>
<?php $attributes = $__attributesOriginal063d692a706e46a49fa25a390252e208; ?>
<?php unset($__attributesOriginal063d692a706e46a49fa25a390252e208); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal063d692a706e46a49fa25a390252e208)): ?>
<?php $component = $__componentOriginal063d692a706e46a49fa25a390252e208; ?>
<?php unset($__componentOriginal063d692a706e46a49fa25a390252e208); ?>
<?php endif; ?>
                </div>
            </div>

            
            <div class="col-lg-3 d-none d-lg-block">
                <div class="shop-sidebar">
                    <?php if (isset($component)) { $__componentOriginal063d692a706e46a49fa25a390252e208 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal063d692a706e46a49fa25a390252e208 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.shop-filters','data' => ['categories' => $categories,'brands' => $brands,'maxPrice' => $maxPrice ?? 1000]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('shop-filters'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['categories' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($categories),'brands' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($brands),'maxPrice' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($maxPrice ?? 1000)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal063d692a706e46a49fa25a390252e208)): ?>
<?php $attributes = $__attributesOriginal063d692a706e46a49fa25a390252e208; ?>
<?php unset($__attributesOriginal063d692a706e46a49fa25a390252e208); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal063d692a706e46a49fa25a390252e208)): ?>
<?php $component = $__componentOriginal063d692a706e46a49fa25a390252e208; ?>
<?php unset($__componentOriginal063d692a706e46a49fa25a390252e208); ?>
<?php endif; ?>
                </div>
            </div>

            
            <div class="col-lg-9">
                <?php if($products->isEmpty()): ?>
                    <div class="empty-state">
                        <div class="empty-icon"><i class="fas fa-box-open"></i></div>
                        <h4>No products found</h4>
                        <p>Try adjusting your filters or search terms.</p>
                        <div class="empty-actions">
                            <a href="<?php echo e(route('shop')); ?>" class="btn btn-primary rounded-pill px-4">Clear All Filters</a>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="row g-3 g-md-4 row-cols-2 row-cols-md-3 product-grid <?php echo e(request('view') === 'list' ? 'list-view' : ''); ?>" id="productGrid">
                        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if (isset($component)) { $__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.product-card','data' => ['product' => $product]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('product-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['product' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($product)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a)): ?>
<?php $attributes = $__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a; ?>
<?php unset($__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a)): ?>
<?php $component = $__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a; ?>
<?php unset($__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a); ?>
<?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <div class="pagination-wrapper">
                        <?php echo e($products->links()); ?>

                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('styles'); ?>
<style>
.shop-page { min-height: 60vh; }
.filter-bar-inner { display: flex; align-items: center; justify-content: space-between; gap: 12px; }
.filter-bar-left { display: flex; align-items: center; gap: 12px; }
.filter-toggle-btn { display: inline-flex; align-items: center; gap: 8px; padding: 8px 16px; border-radius: 10px; border: 1px solid #E5E7EB; background: #fff; font-size: 13px; font-weight: 500; color: var(--gray-700); cursor: pointer; transition: all .2s; position: relative; }
.filter-toggle-btn:hover { border-color: var(--primary); color: var(--primary); }
.filter-active-dot { width: 8px; height: 8px; border-radius: 50%; background: var(--primary); position: absolute; top: 6px; right: 6px; }
.filter-bar-info { font-size: 14px; color: var(--gray-500); }
.results-count strong { color: var(--gray-800); }
.search-query { color: var(--gray-600); }
.filter-bar-right { display: flex; align-items: center; gap: 12px; }
.view-toggle { display: flex; border: 1px solid #E5E7EB; border-radius: 10px; overflow: hidden; }
.view-btn { width: 36px; height: 36px; border: none; background: transparent; color: var(--gray-400); cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 14px; transition: all .2s; }
.view-btn.active { background: var(--primary); color: #fff; }
.view-btn:not(.active):hover { color: var(--gray-600); }
.sort-group { display: flex; align-items: center; gap: 6px; }
.sort-label { font-size: 13px; color: var(--gray-500); white-space: nowrap; display: none; }
@media (min-width: 768px) { .sort-label { display: inline; } }
.sort-select { padding: 8px 14px; border: 1px solid #E5E7EB; border-radius: 10px; font-size: 13px; outline: none; cursor: pointer; color: var(--gray-700); background: #fff; min-width: 140px; }
.sort-select:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(245,114,36,.1); }
.shop-sidebar { position: sticky; top: calc(var(--header-height) + 80px); }
.empty-state { text-align: center; padding: 80px 20px; }
.empty-icon { font-size: 64px; color: #D1D5DB; margin-bottom: 16px; }
.empty-state h4 { font-weight: 700; color: var(--gray-800); margin-bottom: 8px; }
.empty-state p { color: var(--gray-500); margin-bottom: 20px; }
.pagination-wrapper { display: flex; justify-content: center; margin-top: 32px; }
.product-grid.list-view .col { flex: 0 0 100%; max-width: 100%; }
.product-grid.list-view .product-card-v2 { flex-direction: row; }
.product-grid.list-view .product-card-v2 .product-img-wrap { width: 200px; min-height: 200px; flex-shrink: 0; }
.product-grid.list-view .product-card-v2 .product-body-v2 { padding: 16px 20px; }
@media (max-width: 767.98px) { .filter-bar-info .results-count { font-size: 13px; } .sort-select { min-width: 120px; font-size: 12px; padding: 6px 10px; } }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Grid/List toggle
    document.querySelectorAll('.view-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.view-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            const view = this.dataset.view;
            const grid = document.getElementById('productGrid');
            if (grid) {
                grid.classList.toggle('list-view', view === 'list');
                const url = new URL(window.location);
                url.searchParams.set('view', view);
                history.replaceState({}, '', url);
            }
        });
    });
    // Restore view preference
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('view') === 'list') {
        const listBtn = document.querySelector('.view-btn[data-view="list"]');
        if (listBtn) listBtn.click();
    }
});
</script>
<?php $__env->stopPush(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaleac9542bb5e3f887e862d1d96c472e9b)): ?>
<?php $attributes = $__attributesOriginaleac9542bb5e3f887e862d1d96c472e9b; ?>
<?php unset($__attributesOriginaleac9542bb5e3f887e862d1d96c472e9b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaleac9542bb5e3f887e862d1d96c472e9b)): ?>
<?php $component = $__componentOriginaleac9542bb5e3f887e862d1d96c472e9b; ?>
<?php unset($__componentOriginaleac9542bb5e3f887e862d1d96c472e9b); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\ecommerce\resources\views\frontend\shop.blade.php ENDPATH**/ ?>