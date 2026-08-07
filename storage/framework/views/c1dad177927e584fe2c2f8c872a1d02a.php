<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="robots" content="noindex,nofollow">
    <title><?php echo e($title ?? 'Admin Panel'); ?> - <?php echo e(config('app.name')); ?></title>

    <?php echo app('Illuminate\Foundation\Vite')(['resources/sass/app.scss', 'resources/sass/admin.scss', 'resources/js/app.js']); ?>

    <link rel="preload" as="style" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" media="print" onload="this.media='all'">
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"></noscript>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" media="print" onload="this.media='all'">
    <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"></noscript>

    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>

    <div class="admin-wrapper">

        <div class="admin-sidebar-overlay" id="sidebarOverlay"></div>

        <?php if (isset($component)) { $__componentOriginale842643f388f3f2a729c3cad188d3504 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale842643f388f3f2a729c3cad188d3504 = $attributes; } ?>
<?php $component = App\View\Components\Admin\Sidebar::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.sidebar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Admin\Sidebar::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale842643f388f3f2a729c3cad188d3504)): ?>
<?php $attributes = $__attributesOriginale842643f388f3f2a729c3cad188d3504; ?>
<?php unset($__attributesOriginale842643f388f3f2a729c3cad188d3504); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale842643f388f3f2a729c3cad188d3504)): ?>
<?php $component = $__componentOriginale842643f388f3f2a729c3cad188d3504; ?>
<?php unset($__componentOriginale842643f388f3f2a729c3cad188d3504); ?>
<?php endif; ?>

        <div class="admin-main">

            <?php if (isset($component)) { $__componentOriginal45d9cbba1e84739af2366cafaf311004 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal45d9cbba1e84739af2366cafaf311004 = $attributes; } ?>
<?php $component = App\View\Components\Admin\Header::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Admin\Header::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal45d9cbba1e84739af2366cafaf311004)): ?>
<?php $attributes = $__attributesOriginal45d9cbba1e84739af2366cafaf311004; ?>
<?php unset($__attributesOriginal45d9cbba1e84739af2366cafaf311004); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal45d9cbba1e84739af2366cafaf311004)): ?>
<?php $component = $__componentOriginal45d9cbba1e84739af2366cafaf311004; ?>
<?php unset($__componentOriginal45d9cbba1e84739af2366cafaf311004); ?>
<?php endif; ?>

            <main class="admin-content">
                <div class="container-fluid px-0">
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
            </main>

            <footer class="admin-footer text-center border-top">
                &copy; <?php echo e(date('Y')); ?> <?php echo e(config('app.name')); ?>. All rights reserved.
            </footer>

        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.min.js"></script>
    <script src="<?php echo e(asset('admin-assets/js/admin.js')); ?>"></script>

    <?php echo $__env->yieldPushContent('scripts'); ?>

</body>
</html>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\layouts\admin.blade.php ENDPATH**/ ?>