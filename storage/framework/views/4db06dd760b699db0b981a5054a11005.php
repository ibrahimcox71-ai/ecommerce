<header class="admin-nav" id="adminNav">
    <div class="admin-nav-inner">
        <div class="nav-left">
            <button class="nav-toggle-btn" type="button" id="sidebarToggle" aria-label="Toggle sidebar">
                <i class="bi bi-list"></i>
            </button>
            <h5 class="nav-title mb-0"><?php echo e($title ?? 'Dashboard'); ?></h5>
        </div>

        <div class="nav-right">
            <div class="nav-search d-none d-xl-block">
                <i class="bi bi-search nav-search-icon"></i>
                <input type="text" class="form-control" placeholder="Search orders, products..." aria-label="Search">
                <span class="search-shortcut d-none d-xxl-inline">/</span>
            </div>

            <a href="<?php echo e(route('home')); ?>" class="nav-btn d-none d-sm-flex" target="_blank" title="Visit Store" data-bs-toggle="tooltip" data-bs-placement="bottom">
                <i class="bi bi-box-arrow-up-right"></i>
            </a>

            <button class="nav-btn d-none d-sm-flex" id="fullscreenToggle" type="button" title="Fullscreen" data-bs-toggle="tooltip" data-bs-placement="bottom">
                <i class="bi bi-arrows-fullscreen"></i>
            </button>

            <button class="nav-btn" id="darkModeToggle" type="button" title="Toggle Dark Mode" data-bs-toggle="tooltip" data-bs-placement="bottom">
                <i class="bi bi-moon-fill"></i>
            </button>

            <div class="dropdown">
                <button class="nav-btn nav-notif-btn" type="button" data-bs-toggle="dropdown" aria-label="Notifications" data-bs-auto-close="outside">
                    <i class="bi bi-bell-fill"></i>
                    <?php if($unreadCount > 0): ?>
                        <span class="nav-count"><?php echo e($unreadCount); ?></span>
                    <?php endif; ?>
                </button>
                <div class="dropdown-menu dropdown-menu-end notif-dropdown">
                    <div class="notif-header">
                        <h6>Notifications</h6>
                        <?php if($unreadCount > 0): ?>
                            <a href="#">Mark all read</a>
                        <?php endif; ?>
                    </div>
                    <?php $__empty_1 = true; $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="notif-item">
                            <div class="notif-icon" style="background: var(--<?php echo e($notification->data['color'] ?? 'primary'); ?>-light); color: var(--<?php echo e($notification->data['color'] ?? 'primary'); ?>);">
                                <i class="bi bi-<?php echo e($notification->data['icon'] ?? 'bell'); ?>"></i>
                            </div>
                            <div class="notif-content">
                                <p><?php echo e($notification->data['title'] ?? 'New notification'); ?></p>
                                <small><?php echo e($notification->created_at->diffForHumans()); ?></small>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="text-center py-4 text-muted">
                            <i class="bi bi-bell-slash d-block mb-2"></i>
                            <span>No new notifications</span>
                        </div>
                    <?php endif; ?>
                    <div class="notif-footer">
                        <a href="#">View all notifications</a>
                    </div>
                </div>
            </div>

            <div class="nav-divider d-none d-sm-block"></div>

            <div class="dropdown">
                <button class="nav-profile" type="button" data-bs-toggle="dropdown" aria-label="Profile">
                    <div class="nav-profile-avatar">
                        <?php echo e(substr(auth()->guard('admin')->user()?->name ?? 'A', 0, 1)); ?>

                    </div>
                    <span class="nav-profile-name"><?php echo e(auth()->guard('admin')->user()?->name ?? 'Admin'); ?></span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end nav-dropdown-menu">
                    <li>
                        <div class="dropdown-header"><?php echo e(auth()->guard('admin')->user()?->email ?? ''); ?></div>
                    </li>
                    <li><a class="dropdown-item" href="<?php echo e(route('admin.profile')); ?>"><i class="bi bi-person"></i> Profile</a></li>
                    <li><a class="dropdown-item" href="<?php echo e(route('admin.settings.index')); ?>"><i class="bi bi-gear"></i> Settings</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="<?php echo e(route('admin.logout')); ?>">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="dropdown-item"><i class="bi bi-box-arrow-right"></i> Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\partials\admin\header.blade.php ENDPATH**/ ?>