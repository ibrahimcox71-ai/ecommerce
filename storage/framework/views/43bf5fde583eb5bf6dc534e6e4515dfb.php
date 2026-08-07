<?php if (isset($component)) { $__componentOriginaleac9542bb5e3f887e862d1d96c472e9b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaleac9542bb5e3f887e862d1d96c472e9b = $attributes; } ?>
<?php $component = App\View\Components\Layouts\FrontendLayout::resolve(['title' => 'Brand','seoData' => $seoData ?? []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.frontend-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\FrontendLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php $title = $brand->name ?>

<div class="container py-4">
    <?php if (isset($component)) { $__componentOriginale19f62b34dfe0bfdf95075badcb45bc2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumb','data' => ['items' => [
        ['label' => 'Shop', 'url' => route('shop')],
        ['label' => $brand->name],
    ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('breadcrumb'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
        ['label' => 'Shop', 'url' => route('shop')],
        ['label' => $brand->name],
    ])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2)): ?>
<?php $attributes = $__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2; ?>
<?php unset($__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale19f62b34dfe0bfdf95075badcb45bc2)): ?>
<?php $component = $__componentOriginale19f62b34dfe0bfdf95075badcb45bc2; ?>
<?php unset($__componentOriginale19f62b34dfe0bfdf95075badcb45bc2); ?>
<?php endif; ?>

    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4 d-flex align-items-center gap-3">
            <?php if($brand->image): ?>
                <img src="<?php echo e(asset('storage/' . $brand->image)); ?>" alt="<?php echo e($brand->name); ?>" style="max-height: 60px;" class="rounded-3">
            <?php endif; ?>
            <div>
                <h1 class="fw-bold mb-1 text-gray-800"><?php echo e($brand->name); ?></h1>
                <?php if($brand->description): ?>
                    <p class="text-muted mb-0"><?php echo e($brand->description); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <p class="mb-0 text-muted">
            Showing <span class="fw-semibold text-gray-800"><?php echo e($products->firstItem() ?: 0); ?></span>
            - <span class="fw-semibold text-gray-800"><?php echo e($products->lastItem() ?: 0); ?></span>
            of <span class="fw-semibold text-gray-800"><?php echo e($products->total()); ?></span> products
        </p>
        <div class="d-flex align-items-center gap-2">
            <label class="text-muted small mb-0">Sort:</label>
            <select class="form-select form-select-sm form-select-premium" onchange="window.location.href=this.value">
                <option value="<?php echo e(request()->fullUrlWithQuery(['sort' => 'latest'])); ?>" <?php if(request('sort', 'latest') === 'latest'): echo 'selected'; endif; ?>>Latest</option>
                <option value="<?php echo e(request()->fullUrlWithQuery(['sort' => 'price-low'])); ?>" <?php if(request('sort') === 'price-low'): echo 'selected'; endif; ?>>Price: Low to High</option>
                <option value="<?php echo e(request()->fullUrlWithQuery(['sort' => 'price-high'])); ?>" <?php if(request('sort') === 'price-high'): echo 'selected'; endif; ?>>Price: High to Low</option>
                <option value="<?php echo e(request()->fullUrlWithQuery(['sort' => 'name'])); ?>" <?php if(request('sort') === 'name'): echo 'selected'; endif; ?>>Name: A-Z</option>
            </select>
        </div>
    </div>

    <?php if($products->isEmpty()): ?>
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body text-center py-5">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3 sizing-80 bg-gray-100">
                    <i class="fas fa-box-open fa-3x text-gray-400"></i>
                </div>
                <h5 class="text-gray-800">No products from this brand</h5>
                <a href="<?php echo e(route('shop')); ?>" class="btn btn-primary-modern rounded-pill px-4 mt-2">Browse All Products</a>
            </div>
        </div>
    <?php else: ?>
        <div class="row g-4 row-cols-2 row-cols-md-3 row-cols-lg-4">
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
        <div class="mt-4 d-flex justify-content-center">
            <?php echo e($products->links()); ?>

        </div>
    <?php endif; ?>
</div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaleac9542bb5e3f887e862d1d96c472e9b)): ?>
<?php $attributes = $__attributesOriginaleac9542bb5e3f887e862d1d96c472e9b; ?>
<?php unset($__attributesOriginaleac9542bb5e3f887e862d1d96c472e9b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaleac9542bb5e3f887e862d1d96c472e9b)): ?>
<?php $component = $__componentOriginaleac9542bb5e3f887e862d1d96c472e9b; ?>
<?php unset($__componentOriginaleac9542bb5e3f887e862d1d96c472e9b); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\frontend\brand.blade.php ENDPATH**/ ?>