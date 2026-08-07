<nav class="mobile-bottom-nav-v2" role="navigation" aria-label="Mobile navigation">
    <a href="<?php echo e(route('home')); ?>" class="mb-nav-item <?php echo e(request()->routeIs('home') ? 'active' : ''); ?>" aria-label="Home">
        <i class="fas fa-home" aria-hidden="true"></i>
        <span>Home</span>
    </a>
    <a href="<?php echo e(route('shop')); ?>" class="mb-nav-item <?php echo e(request()->routeIs('shop*') ? 'active' : ''); ?>" aria-label="Shop">
        <i class="fas fa-store" aria-hidden="true"></i>
        <span>Shop</span>
    </a>
    <a href="<?php echo e(route('cart')); ?>" class="mb-nav-item <?php echo e(request()->routeIs('cart*') ? 'active' : ''); ?>" aria-label="Cart">
        <i class="fas fa-shopping-bag" aria-hidden="true"></i>
        <span>Cart</span>
        <span class="badge bg-primary cart-count-badge d-none" role="status">0</span>
    </a>
    <a href="<?php echo e(route('wishlist')); ?>" class="mb-nav-item <?php echo e(request()->routeIs('wishlist*') ? 'active' : ''); ?>" aria-label="Wishlist">
        <i class="fas fa-heart" aria-hidden="true"></i>
        <span>Wishlist</span>
        <span class="badge bg-danger wishlist-count-badge d-none" role="status">0</span>
    </a>
    <?php if(auth()->guard('web')->check()): ?>
        <a href="<?php echo e(route('customer.dashboard')); ?>" class="mb-nav-item <?php echo e(request()->routeIs('customer.*') ? 'active' : ''); ?>" aria-label="My Account">
            <i class="fas fa-user" aria-hidden="true"></i>
            <span>Account</span>
        </a>
    <?php else: ?>
        <a href="<?php echo e(route('login')); ?>" class="mb-nav-item" aria-label="Login">
            <i class="fas fa-sign-in-alt" aria-hidden="true"></i>
            <span>Login</span>
        </a>
    <?php endif; ?>
</nav>

<nav class="offcanvas offcanvas-start" tabindex="-1" id="mobileNavOffcanvas" aria-labelledby="mobileNavLabel">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title fw-bold" id="mobileNavLabel">
            <i class="fas fa-store text-primary-custom me-2" aria-hidden="true"></i><?php echo e(config('app.name')); ?>

        </h5>
        <button type="button" class="btn-close touch-target" data-bs-dismiss="offcanvas" aria-label="Close menu"></button>
    </div>
    <div class="offcanvas-body p-0">
        <div class="list-group list-group-flush">
            <a href="<?php echo e(route('home')); ?>" class="list-group-item list-group-item-action d-flex align-items-center gap-3 py-3 <?php echo e(request()->routeIs('home') ? 'active' : ''); ?>">
                <i class="fas fa-home fa-fw" aria-hidden="true"></i>Home
            </a>
            <a href="<?php echo e(route('shop')); ?>" class="list-group-item list-group-item-action d-flex align-items-center gap-3 py-3 <?php echo e(request()->routeIs('shop*') ? 'active' : ''); ?>">
                <i class="fas fa-store fa-fw" aria-hidden="true"></i>Shop
            </a>
            <a href="<?php echo e(route('flash-sale')); ?>" class="list-group-item list-group-item-action d-flex align-items-center gap-3 py-3 text-accent">
                <i class="fas fa-bolt fa-fw" aria-hidden="true"></i>Flash Sale
            </a>
            <a href="<?php echo e(route('about')); ?>" class="list-group-item list-group-item-action d-flex align-items-center gap-3 py-3 <?php echo e(request()->routeIs('about*') ? 'active' : ''); ?>">
                <i class="fas fa-info-circle fa-fw" aria-hidden="true"></i>About
            </a>
            <a href="<?php echo e(route('blog')); ?>" class="list-group-item list-group-item-action d-flex align-items-center gap-3 py-3 <?php echo e(request()->routeIs('blog') ? 'active' : ''); ?>">
                <i class="fas fa-blog fa-fw" aria-hidden="true"></i>Blog
            </a>
            <a href="<?php echo e(route('contact')); ?>" class="list-group-item list-group-item-action d-flex align-items-center gap-3 py-3 <?php echo e(request()->routeIs('contact*') ? 'active' : ''); ?>">
                <i class="fas fa-envelope fa-fw" aria-hidden="true"></i>Contact
            </a>
        </div>
        <div class="border-top mt-3 pt-3 px-3">
            <?php if(auth()->guard('web')->check()): ?>
                <a href="<?php echo e(route('customer.dashboard')); ?>" class="btn btn-primary w-100 rounded-pill mb-2">
                    <i class="fas fa-user me-2" aria-hidden="true"></i>My Account
                </a>
            <?php else: ?>
                <a href="<?php echo e(route('login')); ?>" class="btn btn-primary w-100 rounded-pill mb-2">
                    <i class="fas fa-sign-in-alt me-2" aria-hidden="true"></i>Login
                </a>
                <a href="<?php echo e(route('register')); ?>" class="btn btn-outline-primary w-100 rounded-pill">
                    <i class="fas fa-user-plus me-2" aria-hidden="true"></i>Register
                </a>
            <?php endif; ?>
        </div>
    </div>
</nav>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\partials\frontend\mobile-nav.blade.php ENDPATH**/ ?>