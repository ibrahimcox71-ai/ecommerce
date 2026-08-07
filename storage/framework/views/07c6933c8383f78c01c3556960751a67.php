<?php if (isset($component)) { $__componentOriginala5b7d55eb9299c3bd54b070f8a2d3d0f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala5b7d55eb9299c3bd54b070f8a2d3d0f = $attributes; } ?>
<?php $component = App\View\Components\Layouts\CustomerLayout::resolve(['title' => 'Dashboard'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.customer-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\CustomerLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">My Dashboard</h4>
        <span class="text-muted small">
            <i class="fas fa-calendar-alt me-1"></i><?php echo e(now()->format('F d, Y')); ?>

        </span>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card stat-card border-start border-primary border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="text-muted mb-1">Total Orders</h6>
                            <h4 class="fw-bold mb-0"><?php echo e($totalOrders ?? 0); ?></h4>
                        </div>
                        <i class="fas fa-shopping-bag fa-2x text-primary opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card border-start border-success border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="text-muted mb-1">Completed</h6>
                            <h4 class="fw-bold mb-0"><?php echo e($completedOrders ?? 0); ?></h4>
                        </div>
                        <i class="fas fa-check-circle fa-2x text-success opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card border-start border-warning border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="text-muted mb-1">Wishlist</h6>
                            <h4 class="fw-bold mb-0"><?php echo e($wishlistCount ?? 0); ?></h4>
                        </div>
                        <i class="fas fa-heart fa-2x text-warning opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card border-start border-info border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="text-muted mb-1">Reviews</h6>
                            <h4 class="fw-bold mb-0"><?php echo e($reviewCount ?? 0); ?></h4>
                        </div>
                        <i class="fas fa-star fa-2x text-info opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h6 class="fw-bold mb-0">Recent Orders</h6>
            <a href="<?php echo e(route('customer.orders')); ?>" class="btn btn-sm btn-outline-primary">View All</a>
        </div>
        <?php if(isset($recentOrders) && $recentOrders->isNotEmpty()): ?>
            <div class="list-group list-group-flush">
                <?php $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('customer.order-detail', $order)); ?>" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <div>
                            <span class="fw-semibold">#<?php echo e($order->order_number); ?></span>
                            <span class="badge <?php echo e($order->statusBadge()); ?> ms-2"><?php echo e(ucfirst($order->status)); ?></span>
                        </div>
                        <span class="text-muted small">$<?php echo e(number_format($order->total, 2)); ?> &middot; <?php echo e($order->created_at->diffForHumans()); ?></span>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <div class="card-body text-center py-5 text-muted">
                <i class="fas fa-receipt fa-3x mb-3"></i>
                <p>You haven't placed any orders yet.</p>
                <a href="<?php echo e(route('shop')); ?>" class="btn btn-primary">Start Shopping</a>
            </div>
        <?php endif; ?>
    </div>

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
<?php /**PATH C:\laragon\www\ecommerce\resources\views\customer\dashboard.blade.php ENDPATH**/ ?>