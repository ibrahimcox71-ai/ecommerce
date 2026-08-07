<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['title' => config('app.name'), 'metaDescription' => '', 'canonicalUrl' => null]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['title' => config('app.name'), 'metaDescription' => '', 'canonicalUrl' => null]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $_seoTitle = $title ?? config('app.name');
    $_seoDesc = $metaDescription ?? '';
    $_canonical = $canonicalUrl ?? request()->url();
?>

<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="theme-color" content="#F57224">
    <title><?php echo e($_seoTitle); ?> - <?php echo e(config('app.name')); ?></title>

    <?php if($_seoDesc): ?>
    <meta name="description" content="<?php echo e($_seoDesc); ?>">
    <?php endif; ?>

    <meta name="robots" content="noindex,nofollow">
    <link rel="canonical" href="<?php echo e($_canonical); ?>">

    <meta property="og:site_name" content="<?php echo e(config('app.name')); ?>">
    <meta property="og:url" content="<?php echo e($_canonical); ?>">
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?php echo e($_seoTitle); ?> - <?php echo e(config('app.name')); ?>">
    <?php if($_seoDesc): ?>
    <meta property="og:description" content="<?php echo e($_seoDesc); ?>">
    <?php endif; ?>

    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="<?php echo e($_seoTitle); ?> - <?php echo e(config('app.name')); ?>">
    <?php if($_seoDesc): ?>
    <meta name="twitter:description" content="<?php echo e($_seoDesc); ?>">
    <?php endif; ?>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" media="print" onload="this.media='all'">
    <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"></noscript>

    <link rel="preload" as="style" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" media="print" onload="this.media='all'">
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"></noscript>

    <?php echo app('Illuminate\Foundation\Vite')(['resources/sass/app.scss', 'resources/js/app.js']); ?>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="auth-bg">

    <a href="#auth-main-content" class="skip-to-content btn btn-primary position-absolute start-0 z-3" style="transform: translateY(-100%); transition: transform 0.2s;" data-skip-link>
        Skip to main content
    </a>

    <div id="auth-main-content">
        <div class="container">
            <div class="row justify-content-center align-items-center min-vh-100 py-5">
                <div class="col-12 d-flex flex-column align-items-center">
                    <div class="text-center mb-4">
                        <a href="<?php echo e(route('home')); ?>" class="text-decoration-none">
                            <span class="d-inline-flex align-items-center gap-2 fs-2 fw-bold text-gray-900">
                                <span class="d-inline-flex align-items-center justify-content-center" style="width:44px;height:44px;background:linear-gradient(135deg,var(--primary),var(--secondary));border-radius:var(--radius-sm);color:#fff;font-size:1.2rem;">
                                    <i class="fas fa-store" aria-hidden="true"></i>
                                </span>
                                <?php echo e(config('app.name')); ?>

                            </span>
                        </a>
                    </div>

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

                    <div class="card-premium auth-card border-0 mx-auto" style="max-width: 420px; width: 100%; border-radius: 16px;">
                        <div class="card-body p-4 p-md-5">
                            <?php echo e($slot); ?>

                        </div>
                    </div>
                    <div class="text-center mt-3">
                        <small class="text-gray-500">&copy; <?php echo e(date('Y')); ?> <?php echo e(config('app.name')); ?></small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\components\layouts\guest-layout.blade.php ENDPATH**/ ?>