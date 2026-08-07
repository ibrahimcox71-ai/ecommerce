<?php if (isset($component)) { $__componentOriginala5b7d55eb9299c3bd54b070f8a2d3d0f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala5b7d55eb9299c3bd54b070f8a2d3d0f = $attributes; } ?>
<?php $component = App\View\Components\Layouts\CustomerLayout::resolve(['title' => 'My Orders'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.customer-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\CustomerLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">My Orders</h4>
    </div>

    <?php if($orders->isEmpty()): ?>
        <div class="card">
            <div class="card-body text-center py-5 text-muted">
                <i class="fas fa-shopping-bag fa-3x mb-3"></i>
                <p>No orders found.</p>
                <a href="<?php echo e(route('shop')); ?>" class="btn btn-primary">Start Shopping</a>
            </div>
        </div>
    <?php else: ?>
        <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <strong class="fs-6">Order #<?php echo e($order->order_number); ?></strong>
                            <span class="badge <?php echo e($order->statusBadge()); ?> ms-2"><?php echo e(ucfirst($order->status)); ?></span>
                            <span class="badge <?php echo e($order->paymentStatusBadge()); ?> ms-1"><?php echo e(ucfirst($order->payment_status)); ?></span>
                        </div>
                        <span class="fw-bold text-primary">$<?php echo e(number_format($order->total, 2)); ?></span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            <?php echo e($order->created_at->format('M d, Y')); ?> —
                            <?php echo e($order->items->sum('quantity')); ?> item(s) —
                            <?php echo e($order->payment?->methodLabel() ?? 'COD'); ?>

                        </small>
                        <div>
                            <a href="<?php echo e(route('customer.order-detail', $order)); ?>" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye me-1"></i>View
                            </a>
                            <a href="<?php echo e(route('order.invoice', $order)); ?>" class="btn btn-sm btn-outline-secondary" target="_blank">
                                <i class="fas fa-file-invoice me-1"></i>Invoice
                            </a>
                            <?php if($order->hasTracking()): ?>
                                <a href="<?php echo e(route('order.track', $order->order_number)); ?>" class="btn btn-sm btn-outline-info">
                                    <i class="fas fa-truck me-1"></i>Track
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <div class="d-flex justify-content-center">
            <?php echo e($orders->links()); ?>

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
<?php /**PATH C:\laragon\www\ecommerce\resources\views\customer\orders.blade.php ENDPATH**/ ?>