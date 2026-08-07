<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['title' => config('app.name'), 'metaDescription' => '', 'canonicalUrl' => null, 'seoData' => []]));

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

foreach (array_filter((['title' => config('app.name'), 'metaDescription' => '', 'canonicalUrl' => null, 'seoData' => []]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $_seo = $seoData ?? [];
    $_metaTitle = $metaTitle ?? $_seo['metaTitle'] ?? $title ?? config('app.name');
    $_metaDescription = $metaDescription ?: ($_seo['metaDescription'] ?? '');
?>

<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="theme-color" content="#F57224">

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

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" media="print" onload="this.media='all'">

    <link rel="preload" as="style" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" media="print" onload="this.media='all'">
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"></noscript>

    <?php echo app('Illuminate\Foundation\Vite')(['resources/sass/app.scss', 'resources/js/app.js', 'resources/js/frontend.js']); ?>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>

    <a href="#main-content" class="skip-to-content btn btn-primary position-absolute start-0 z-3" style="transform: translateY(-100%); transition: transform 0.2s;" data-skip-link>
        Skip to main content
    </a>

    <?php echo $__env->make('partials.frontend.announcement', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('partials.frontend.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('partials.frontend.mega-menu', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <main id="main-content">
        <?php echo e($slot); ?>

    </main>

    <?php echo $__env->make('partials.frontend.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <?php echo $__env->make('partials.frontend.mobile-nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="toast-container-v2" id="toastContainer" role="alert" aria-live="polite" aria-atomic="true"></div>

    <?php
        $_routeUrls = [
            'wishlistToggle' => route('wishlist.toggle'),
            'wishlistCount' => route('wishlist.count'),
            'cartAdd' => route('cart.add'),
            'cartSummary' => route('cart.summary'),
            'cartCouponApply' => route('cart.coupon.apply'),
            'checkout' => route('checkout'),
            'search' => route('search'),
            'login' => route('login'),
            'notificationUnread' => route('notification.unread-count'),
        ];
    ?>
    <script>window.routeUrls = <?php echo json_encode($_routeUrls, 15, 512) ?>;</script>

    <div class="floating-elements" role="complementary" aria-label="Quick actions">
        <button class="floating-btn back-to-top touch-target" id="backToTop" aria-label="Back to top" tabindex="0">
            <i class="fas fa-chevron-up" aria-hidden="true"></i>
        </button>
    </div>

    <div id="recentlyPurchasedPopup"></div>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\components\layouts\frontend-layout.blade.php ENDPATH**/ ?>