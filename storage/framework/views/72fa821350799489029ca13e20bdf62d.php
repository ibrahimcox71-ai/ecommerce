<?php
    $_seo = $seoData ?? [];
    $_metaTitle = $metaTitle ?? $_seo['metaTitle'] ?? config('app.name');
    $_metaDescription = $metaDescription ?? $_seo['metaDescription'] ?? '';
?>

<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e($_metaTitle); ?></title>

    <?php if($_metaDescription): ?>
    <meta name="description" content="<?php echo e($_metaDescription); ?>">
    <?php endif; ?>

    <?php if(!empty($_seo['robots'])): ?>
    <meta name="robots" content="<?php echo e($_seo['robots']); ?>">
    <?php endif; ?>

    <?php if(!empty($_seo['canonicalUrl'])): ?>
    <link rel="canonical" href="<?php echo e($_seo['canonicalUrl']); ?>">
    <?php endif; ?>

    <meta property="og:site_name" content="<?php echo e($_seo['ogSiteName'] ?? config('app.name')); ?>">
    <meta property="og:url" content="<?php echo e($_seo['ogUrl'] ?? request()->url()); ?>">
    <meta property="og:type" content="<?php echo e($_seo['ogType'] ?? 'website'); ?>">
    <meta property="og:title" content="<?php echo e($_seo['ogTitle'] ?? $_metaTitle); ?>">
    <?php if(!empty($_seo['ogDescription'])): ?>
    <meta property="og:description" content="<?php echo e($_seo['ogDescription']); ?>">
    <?php endif; ?>
    <?php if(!empty($_seo['ogImage'])): ?>
    <meta property="og:image" content="<?php echo e($_seo['ogImage']); ?>">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <?php endif; ?>

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo e($_seo['ogTitle'] ?? $_metaTitle); ?>">
    <?php if(!empty($_seo['ogDescription'])): ?>
    <meta name="twitter:description" content="<?php echo e($_seo['ogDescription']); ?>">
    <?php endif; ?>
    <?php if(!empty($_seo['ogImage'])): ?>
    <meta name="twitter:image" content="<?php echo e($_seo['ogImage']); ?>">
    <?php endif; ?>

    <?php if(!empty($_seo['schemas'])): ?>
        <?php $__currentLoopData = $_seo['schemas']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $schema): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <script type="application/ld+json"><?php echo json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?></script>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>

    <?php echo app('Illuminate\Foundation\Vite')(['resources/sass/app.scss', 'resources/js/app.js']); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
    <div class="customer-layout">

        <?php if (isset($component)) { $__componentOriginalbb6bae8a9735202f3a63a247907e17ec = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbb6bae8a9735202f3a63a247907e17ec = $attributes; } ?>
<?php $component = App\View\Components\Customer\Sidebar::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('customer.sidebar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Customer\Sidebar::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbb6bae8a9735202f3a63a247907e17ec)): ?>
<?php $attributes = $__attributesOriginalbb6bae8a9735202f3a63a247907e17ec; ?>
<?php unset($__attributesOriginalbb6bae8a9735202f3a63a247907e17ec); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbb6bae8a9735202f3a63a247907e17ec)): ?>
<?php $component = $__componentOriginalbb6bae8a9735202f3a63a247907e17ec; ?>
<?php unset($__componentOriginalbb6bae8a9735202f3a63a247907e17ec); ?>
<?php endif; ?>

        <div class="customer-main d-flex flex-column min-vh-100">

            <?php echo $__env->make('partials.frontend.header-minimal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <main class="flex-grow-1">
                <div class="container-fluid py-4">
                    <div class="row">
                        <div class="col-12">
                            <?php if (isset($component)) { $__componentOriginal18c97383b279a0cfae79902a0a256cc3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal18c97383b279a0cfae79902a0a256cc3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.session-flash','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('session-flash'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal18c97383b279a0cfae79902a0a256cc3)): ?>
<?php $attributes = $__attributesOriginal18c97383b279a0cfae79902a0a256cc3; ?>
<?php unset($__attributesOriginal18c97383b279a0cfae79902a0a256cc3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal18c97383b279a0cfae79902a0a256cc3)): ?>
<?php $component = $__componentOriginal18c97383b279a0cfae79902a0a256cc3; ?>
<?php unset($__componentOriginal18c97383b279a0cfae79902a0a256cc3); ?>
<?php endif; ?>

                            <?php echo e($slot); ?>

                        </div>
                    </div>
                </div>
            </main>

            <?php echo $__env->make('partials.frontend.footer-minimal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        </div>

    </div>

    <?php echo $__env->yieldPushContent('scripts'); ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const badge = document.querySelector('.unread-notifications');
            if (!badge) return;
            fetch('<?php echo e(route("notification.unread-count")); ?>')
                .then(r => r.json())
                .then(d => {
                    if (d.count > 0) {
                        badge.textContent = d.count;
                        badge.style.display = '';
                    }
                });
        });
    </script>
</body>
</html>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\layouts\customer.blade.php ENDPATH**/ ?>