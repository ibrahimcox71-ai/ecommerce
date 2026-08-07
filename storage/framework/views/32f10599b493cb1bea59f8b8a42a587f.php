<nav aria-label="breadcrumb" class="bg-gray-100 py-2 mb-4">
    <div class="container">
        <ol class="breadcrumb breadcrumb-premium mb-0">
            <li class="breadcrumb-item">
                <a href="<?php echo e(route('home')); ?>"><i class="fas fa-home me-1"></i>Home</a>
            </li>
            <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($loop->last): ?>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo e($item['label']); ?></li>
                <?php else: ?>
                    <li class="breadcrumb-item">
                        <a href="<?php echo e($item['url'] ?? '#'); ?>"><?php echo e($item['label']); ?></a>
                    </li>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ol>
    </div>
</nav>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\components\frontend\breadcrumb.blade.php ENDPATH**/ ?>