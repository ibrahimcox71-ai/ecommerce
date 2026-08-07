<header class="main-header" role="banner">
    <div class="container">
        <div class="header-inner">

            <button class="header-action-btn d-lg-none touch-target" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileNavOffcanvas" aria-label="Open menu">
                <i class="fas fa-bars" aria-hidden="true"></i>
            </button>

            <a class="header-logo" href="<?php echo e(route('home')); ?>" aria-label="<?php echo e(config('app.name')); ?> home">
                <span class="logo-icon"><i class="fas fa-store" aria-hidden="true"></i></span>
                <span class="logo-text"><?php echo e(config('app.name')); ?></span>
            </a>

            <div class="search-container d-none d-lg-block" role="search">
                <form action="<?php echo e(route('search')); ?>" method="GET" class="search-wrapper" aria-label="Search products">
                    <span class="search-icon"><i class="fas fa-search" aria-hidden="true"></i></span>
                    <input type="text" name="q" class="search-input" placeholder="Search products, brands, categories..." autocomplete="off" aria-label="Search query" aria-autocomplete="list" aria-controls="searchSuggestions" role="combobox" aria-expanded="false">
                    <button type="submit" class="search-submit" aria-label="Submit search">
                        <i class="fas fa-arrow-right" aria-hidden="true"></i>
                    </button>
                </form>
                <div class="search-suggestions" id="searchSuggestions" role="listbox" aria-label="Search suggestions">
                    <div class="p-3 text-center text-muted small">Type to search products...</div>
                </div>
            </div>

            <div class="header-actions">

                <div class="flash-header-timer" id="headerFlashTimer" role="timer" aria-label="Flash sale ends in 00 hours 00 minutes 00 seconds" aria-live="polite">
                    <i class="fas fa-bolt" aria-hidden="true"></i>
                    <span>Ends in</span>
                    <span class="timer-unit fh-hours" aria-hidden="true">00</span>
                    <span aria-hidden="true">:</span>
                    <span class="timer-unit fh-mins" aria-hidden="true">00</span>
                    <span aria-hidden="true">:</span>
                    <span class="timer-unit fh-secs" aria-hidden="true">00</span>
                </div>

                <a href="<?php echo e(route('wishlist')); ?>" class="header-action-btn touch-target" title="Wishlist" aria-label="Wishlist">
                    <i class="far fa-heart" aria-hidden="true"></i>
                    <span class="header-action-badge wishlist-count-badge d-none" role="status">0</span>
                </a>

                <button class="header-action-btn touch-target" title="Compare" aria-label="Compare products" disabled>
                    <i class="fas fa-random" aria-hidden="true"></i>
                </button>

                <a href="<?php echo e(route('cart')); ?>" class="header-action-btn touch-target" id="cartDropdown" data-bs-toggle="dropdown" aria-expanded="false" title="Cart" aria-label="Shopping cart">
                    <i class="fas fa-shopping-bag" aria-hidden="true"></i>
                    <span class="header-action-badge cart-count-badge d-none" role="status">0</span>
                </a>
                <div class="dropdown-menu dropdown-menu-end mini-cart-dropdown-v2" id="miniCartDropdown" aria-label="Mini cart">
                    <?php if (isset($component)) { $__componentOriginal3ea00a7772fa8583412300883e4a87b5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3ea00a7772fa8583412300883e4a87b5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.mini-cart-content','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('mini-cart-content'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3ea00a7772fa8583412300883e4a87b5)): ?>
<?php $attributes = $__attributesOriginal3ea00a7772fa8583412300883e4a87b5; ?>
<?php unset($__attributesOriginal3ea00a7772fa8583412300883e4a87b5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3ea00a7772fa8583412300883e4a87b5)): ?>
<?php $component = $__componentOriginal3ea00a7772fa8583412300883e4a87b5; ?>
<?php unset($__componentOriginal3ea00a7772fa8583412300883e4a87b5); ?>
<?php endif; ?>
                </div>

                <?php if(auth()->guard('web')->check()): ?>
                    <a href="<?php echo e(route('customer.notifications')); ?>" class="header-action-btn d-none d-md-flex touch-target" title="Notifications" aria-label="Notifications">
                        <i class="fas fa-bell" aria-hidden="true"></i>
                        <span class="header-action-badge notification-count-badge d-none" role="status">0</span>
                    </a>
                    <div class="dropdown d-none d-sm-block">
                        <a href="<?php echo e(route('customer.dashboard')); ?>" class="header-auth-btn btn-filled" aria-label="My account">
                            <i class="fas fa-user" aria-hidden="true"></i>
                            <span><?php echo e(auth()->guard('web')->user()->name); ?></span>
                        </a>
                    </div>
                <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>" class="header-auth-btn d-none d-sm-inline-flex" aria-label="Sign in">
                        <i class="fas fa-sign-in-alt" aria-hidden="true"></i>
                        <span>Sign In</span>
                    </a>
                <?php endif; ?>

            </div>
        </div>
    </div>
</header>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\partials\frontend\header.blade.php ENDPATH**/ ?>