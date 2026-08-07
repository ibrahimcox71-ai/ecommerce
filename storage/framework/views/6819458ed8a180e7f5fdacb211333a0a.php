<aside class="customer-sidebar" id="customerSidebar">
    <div class="p-4 border-bottom text-center">
        <div class="rounded-circle bg-primary bg-gradient d-flex align-items-center justify-content-center mx-auto mb-2" style="width: 64px; height: 64px;">
            <span class="text-white fw-bold fs-4"><?php echo e(substr(auth()->guard('customer')->user()?->name ?? 'U', 0, 1)); ?></span>
        </div>
        <h6 class="mb-0 fw-semibold"><?php echo e(auth()->guard('customer')->user()?->name ?? 'User'); ?></h6>
        <small class="text-muted"><?php echo e(auth()->guard('customer')->user()?->email ?? ''); ?></small>
    </div>

    <nav class="mt-3">
        <ul class="nav flex-column">
            <?php $__currentLoopData = $navigation ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(Route::currentRouteName() === $item['route'] ? 'active' : ''); ?>"
                       href="<?php echo e(route($item['route'])); ?>">
                        <i class="<?php echo e($item['icon']); ?>"></i>
                        <span><?php echo e($item['label']); ?></span>
                        <?php if(isset($item['badge'])): ?>
                            <span class="badge bg-danger rounded-pill ms-auto <?php echo e($item['badge']); ?>" style="display: none;">0</span>
                        <?php endif; ?>
                    </a>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>

        <hr class="mx-3">

        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="<?php echo e(route('home')); ?>">
                    <i class="fas fa-arrow-left"></i>
                    <span>Back to Store</span>
                </a>
            </li>
            <li class="nav-item">
                <form method="POST" action="<?php echo e(route('customer.logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </li>
        </ul>
    </nav>
</aside>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\partials\customer\sidebar.blade.php ENDPATH**/ ?>