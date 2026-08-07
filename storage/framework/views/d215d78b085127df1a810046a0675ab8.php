<aside class="admin-sidebar text-white" id="adminSidebar">

    <button type="button" class="sidebar-close" id="sidebarClose" aria-label="Close sidebar">
        <i class="bi bi-x-lg"></i>
    </button>

    <div class="sidebar-brand">
        <a href="<?php echo e(route('admin.dashboard')); ?>" class="sidebar-brand-link">
            <div class="sidebar-brand-icon">
                <i class="bi bi-shop"></i>
            </div>
            <div>
                <div class="sidebar-brand-text"><?php echo e(config('app.name')); ?></div>
                <div class="sidebar-brand-sub">Admin Panel</div>
            </div>
        </a>
    </div>

    <div class="sidebar-profile">
        <div class="sidebar-profile-avatar">
            <?php echo e(strtoupper(substr(auth()->guard('admin')->user()?->name ?? 'A', 0, 1))); ?>

        </div>
        <div class="sidebar-profile-info">
            <div class="sidebar-profile-name"><?php echo e(auth()->guard('admin')->user()?->name ?? 'Admin'); ?></div>
            <div class="sidebar-profile-role"><?php echo e(auth()->guard('admin')->user()?->email ?? 'Administrator'); ?></div>
        </div>
        <div class="sidebar-profile-badge"></div>
    </div>

    <nav class="sidebar-nav">
        <div class="sidebar-nav-label">Main Menu</div>
        <ul class="list-unstyled mb-0">
            <?php $__currentLoopData = $navigation ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(isset($item['type']) && $item['type'] === 'divider'): ?>
                    <li><hr class="sidebar-divider"></li>
                <?php elseif(isset($item['route'])): ?>
                    <?php
                        $isActive = Route::currentRouteName() === $item['route'];
                        $hasChildren = !empty($item['children']);
                        $isChildActive = $hasChildren && collect($item['children'])->contains(fn($c) => Route::currentRouteName() === ($c['route'] ?? ''));
                    ?>
                    <li class="sidebar-nav-item">
                        <?php if($hasChildren): ?>
                            <a class="sidebar-nav-link <?php echo e(($isActive || $isChildActive) ? 'active' : ''); ?>"
                               href="#sidebarCollapse_<?php echo e(Str::slug($item['label'])); ?>"
                               data-bs-toggle="collapse" role="button"
                               aria-expanded="<?php echo e($isChildActive ? 'true' : 'false'); ?>">
                                <i class="<?php echo e($item['icon']); ?>"></i>
                                <span class="nav-label"><?php echo e($item['label']); ?></span>
                                <i class="bi bi-chevron-down nav-arrow <?php echo e($isChildActive ? 'open' : ''); ?>"></i>
                            </a>
                            <ul class="list-unstyled collapse <?php echo e($isChildActive ? 'show' : ''); ?> sidebar-submenu"
                                id="sidebarCollapse_<?php echo e(Str::slug($item['label'])); ?>">
                                <?php $__currentLoopData = $item['children']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li>
                                        <a class="sidebar-nav-link sidebar-submenu-link <?php echo e(Route::currentRouteName() === ($child['route'] ?? '') ? 'active' : ''); ?>"
                                           href="<?php echo e(isset($child['route']) ? route($child['route']) : '#'); ?>">
                                            <i class="<?php echo e($child['icon'] ?? 'bi bi-circle'); ?>"></i>
                                            <span class="nav-label"><?php echo e($child['label']); ?></span>
                                        </a>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        <?php else: ?>
                            <a class="sidebar-nav-link <?php echo e($isActive ? 'active' : ''); ?>"
                               href="<?php echo e(route($item['route'])); ?>">
                                <i class="<?php echo e($item['icon']); ?>"></i>
                                <span class="nav-label"><?php echo e($item['label']); ?></span>
                                <?php if(($item['label'] === 'Orders' || $item['label'] === 'Customers') && !$isActive): ?>
                                    <span class="badge bg-danger">3</span>
                                <?php endif; ?>
                            </a>
                        <?php endif; ?>
                    </li>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </nav>

    <div class="sidebar-footer">
        <form method="POST" action="<?php echo e(route('admin.logout')); ?>">
            <?php echo csrf_field(); ?>
            <button type="submit" class="sidebar-nav-link w-100 text-start border-0 bg-transparent">
                <i class="bi bi-box-arrow-right"></i>
                <span class="nav-label">Logout</span>
            </button>
        </form>
    </div>

</aside>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\partials\admin\sidebar.blade.php ENDPATH**/ ?>