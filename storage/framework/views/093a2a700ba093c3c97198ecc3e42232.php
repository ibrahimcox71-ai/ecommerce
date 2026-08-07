<?php if (isset($component)) { $__componentOriginaleac9542bb5e3f887e862d1d96c472e9b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaleac9542bb5e3f887e862d1d96c472e9b = $attributes; } ?>
<?php $component = App\View\Components\Layouts\FrontendLayout::resolve(['title' => 'Category','seoData' => $seoData ?? []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.frontend-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\FrontendLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php $title = $category->name ?>

<div class="category-page">
    
    <div class="category-hero">
        <div class="container">
            <div class="category-hero-content">
                <?php if (isset($component)) { $__componentOriginalcc52fffb9c918b8f3f4cf5faa6f3a53c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcc52fffb9c918b8f3f4cf5faa6f3a53c = $attributes; } ?>
<?php $component = App\View\Components\Frontend\Breadcrumb::resolve(['items' => [
                    ['label' => 'Shop', 'url' => route('shop')],
                    ['label' => $category->name],
                ]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
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
                <h1 class="category-hero-title"><?php echo e($category->name); ?></h1>
                <?php if($category->description): ?>
                    <p class="category-hero-desc"><?php echo e($category->description); ?></p>
                <?php endif; ?>
                <?php if($category->children->isNotEmpty()): ?>
                    <div class="category-sub-links">
                        <?php $__currentLoopData = $category->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e(route('category.show', $child->slug)); ?>" class="sub-cat-pill"><?php echo e($child->name); ?></a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="container py-4">
        <div class="row">
            <div class="col-12 mb-3">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <p class="mb-0 text-muted small">
                        Showing <strong><?php echo e($products->firstItem() ?: 0); ?></strong>
                        - <strong><?php echo e($products->lastItem() ?: 0); ?></strong>
                        of <strong><?php echo e($products->total()); ?></strong> products
                    </p>
                    <div class="d-flex align-items-center gap-2">
                        <label class="text-muted small">Sort:</label>
                        <select class="sort-select" onchange="window.location.href=this.value">
                            <option value="<?php echo e(request()->fullUrlWithQuery(['sort' => 'latest'])); ?>" <?php if(request('sort', 'latest') === 'latest'): echo 'selected'; endif; ?>>Latest</option>
                            <option value="<?php echo e(request()->fullUrlWithQuery(['sort' => 'price-low'])); ?>" <?php if(request('sort') === 'price-low'): echo 'selected'; endif; ?>>Price: Low to High</option>
                            <option value="<?php echo e(request()->fullUrlWithQuery(['sort' => 'price-high'])); ?>" <?php if(request('sort') === 'price-high'): echo 'selected'; endif; ?>>Price: High to Low</option>
                            <option value="<?php echo e(request()->fullUrlWithQuery(['sort' => 'name'])); ?>" <?php if(request('sort') === 'name'): echo 'selected'; endif; ?>>Name: A-Z</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <?php if($products->isEmpty()): ?>
            <div class="text-center py-5">
                <i class="fas fa-box-open fa-4x text-gray-300 mb-3"></i>
                <h5 class="fw-bold">No products in this category</h5>
                <a href="<?php echo e(route('shop')); ?>" class="btn btn-primary rounded-pill px-4 mt-2">Browse All Products</a>
            </div>
        <?php else: ?>
            <div class="row g-3 g-md-4 row-cols-2 row-cols-md-3 row-cols-lg-4">
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
            <div class="d-flex justify-content-center mt-4">
                <?php echo e($products->links()); ?>

            </div>
        <?php endif; ?>
    </div>
</div>

<?php $__env->startPush('styles'); ?>
<style>
.category-hero { background: linear-gradient(135deg, var(--primary-50), #fff); padding: 32px 0; margin-bottom: 8px; border-bottom: 1px solid #F3F4F6; }
.category-hero-content { max-width: 700px; }
.category-hero-title { font-size: 32px; font-weight: 900; color: var(--gray-900); letter-spacing: -.5px; margin: 12px 0 8px; }
@media (max-width: 767.98px) { .category-hero-title { font-size: 24px; } }
.category-hero-desc { font-size: 14px; color: var(--gray-500); line-height: 1.6; }
.category-sub-links { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 16px; }
.sub-cat-pill { padding: 6px 16px; border-radius: 20px; background: #fff; border: 1px solid #E5E7EB; font-size: 13px; font-weight: 500; color: var(--gray-700); text-decoration: none; transition: all .2s; }
.sub-cat-pill:hover { border-color: var(--primary); color: var(--primary); background: rgba(245,114,36,.04); }
.sort-select { padding: 6px 14px; border: 1px solid #E5E7EB; border-radius: 10px; font-size: 13px; outline: none; cursor: pointer; color: var(--gray-700); background: #fff; }
.sort-select:focus { border-color: var(--primary); }
</style>
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
<?php endif; ?><?php /**PATH C:\laragon\www\ecommerce\resources\views\frontend\category.blade.php ENDPATH**/ ?>