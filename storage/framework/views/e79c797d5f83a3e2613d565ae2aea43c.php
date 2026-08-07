<?php if (isset($component)) { $__componentOriginala5b7d55eb9299c3bd54b070f8a2d3d0f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala5b7d55eb9299c3bd54b070f8a2d3d0f = $attributes; } ?>
<?php $component = App\View\Components\Layouts\CustomerLayout::resolve(['title' => 'Notifications'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.customer-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\CustomerLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">Notifications</h4>
        </div>
        <?php if($notifications->total() > 0): ?>
            <div class="d-flex gap-2">
                <form method="POST" action="<?php echo e(route('customer.notifications.read-all')); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-check-double me-1"></i>Mark All as Read
                    </button>
                </form>
            </div>
        <?php endif; ?>
    </div>

    <?php if($notifications->isEmpty()): ?>
        <div class="card">
            <div class="card-body text-center py-5 text-muted">
                <i class="fas fa-bell fa-3x mb-3"></i>
                <p>No notifications yet.</p>
            </div>
        </div>
    <?php else: ?>
        <div class="list-group">
            <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="list-group-item list-group-item-action border-0 shadow-sm mb-2 rounded
                    <?php echo e(is_null($notification->read_at) ? 'border-start border-primary border-4' : ''); ?>">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="d-flex gap-3 align-items-start">
                            <div class="rounded-circle bg-<?php echo e($notification->data['color'] ?? 'primary'); ?> bg-opacity-10 p-3 d-flex align-items-center justify-content-center"
                                 style="width: 48px; height: 48px;">
                                <i class="fas fa-<?php echo e($notification->data['icon'] ?? 'bell'); ?> text-<?php echo e($notification->data['color'] ?? 'primary'); ?>"></i>
                            </div>
                            <div>
                                <p class="mb-1 fw-semibold"><?php echo e($notification->data['title'] ?? 'Notification'); ?></p>
                                <?php if(isset($notification->data['message'])): ?>
                                    <p class="mb-1 text-muted small"><?php echo e($notification->data['message']); ?></p>
                                <?php endif; ?>
                                <small class="text-muted"><?php echo e($notification->created_at->diffForHumans()); ?></small>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <?php if(is_null($notification->read_at)): ?>
                                <form method="POST" action="<?php echo e(route('customer.notifications.read', $notification)); ?>" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn btn-sm btn-link text-success p-0" title="Mark as read">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                            <?php endif; ?>
                            <form method="POST" action="<?php echo e(route('customer.notifications.destroy', $notification)); ?>" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-sm btn-link text-danger p-0" title="Delete"
                                        onclick="return confirm('Delete this notification?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="d-flex justify-content-center mt-4">
            <?php echo e($notifications->links()); ?>

        </div>
    <?php endif; ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala5b7d55eb9299c3bd54b070f8a2d3d0f)): ?>
<?php $attributes = $__attributesOriginala5b7d55eb9299c3bd54b070f8a2d3d0f; ?>
<?php unset($__attributesOriginala5b7d55eb9299c3bd54b070f8a2d3d0f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala5b7d55eb9299c3bd54b070f8a2d3d0f)): ?>
<?php $component = $__componentOriginala5b7d55eb9299c3bd54b070f8a2d3d0f; ?>
<?php unset($__componentOriginala5b7d55eb9299c3bd54b070f8a2d3d0f); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\customer\notifications.blade.php ENDPATH**/ ?>