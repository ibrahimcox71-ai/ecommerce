<?php if (isset($component)) { $__componentOriginala5b7d55eb9299c3bd54b070f8a2d3d0f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala5b7d55eb9299c3bd54b070f8a2d3d0f = $attributes; } ?>
<?php $component = App\View\Components\Layouts\CustomerLayout::resolve(['title' => 'Order #'.e($order->order_number).''] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.customer-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\CustomerLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="<?php echo e(route('customer.orders')); ?>" class="text-muted text-decoration-none small">
                <i class="fas fa-arrow-left me-1"></i>Back to Orders
            </a>
            <h4 class="fw-bold mb-0 mt-1">Order #<?php echo e($order->order_number); ?></h4>
        </div>
        <span class="badge <?php echo e($order->statusBadge()); ?> fs-6"><?php echo e(ucfirst($order->status)); ?></span>
        <?php if($order->hasTracking()): ?>
            <a href="<?php echo e(route('order.track', $order->order_number)); ?>" class="btn btn-sm btn-outline-info">
                <i class="fas fa-truck me-1"></i>Track
            </a>
        <?php endif; ?>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="fw-bold mb-0">Items</h5>
                </div>
                <div class="card-body p-0">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Product</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Price</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <?php if($item->product_image): ?>
                                                <img src="<?php echo e($item->product_image); ?>" alt="<?php echo e($item->product_name); ?>"
                                                     style="width: 50px; height: 50px; object-fit: cover;" class="rounded">
                                            <?php endif; ?>
                                            <span class="fw-semibold"><?php echo e($item->product_name); ?></span>
                                        </div>
                                    </td>
                                    <td class="text-center"><?php echo e($item->quantity); ?></td>
                                    <td class="text-end">$<?php echo e(number_format($item->unit_price, 2)); ?></td>
                                    <td class="text-end fw-semibold">$<?php echo e(number_format($item->subtotal, 2)); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                        <tfoot class="table-light">
                            <tr><td colspan="3" class="text-end">Subtotal</td><td class="text-end">$<?php echo e(number_format($order->subtotal, 2)); ?></td></tr>
                            <?php if($order->coupon_discount > 0): ?>
                                <tr><td colspan="3" class="text-end text-success">Discount</td><td class="text-end text-success">-$<?php echo e(number_format($order->coupon_discount, 2)); ?></td></tr>
                            <?php endif; ?>
                            <tr><td colspan="3" class="text-end">Shipping</td><td class="text-end">$<?php echo e(number_format($order->shipping_cost, 2)); ?></td></tr>
                            <tr><td colspan="3" class="text-end">Tax</td><td class="text-end">$<?php echo e(number_format($order->tax_amount, 2)); ?></td></tr>
                            <tr><td colspan="3" class="text-end fw-bold">Total</td><td class="text-end fw-bold fs-5 text-primary">$<?php echo e(number_format($order->total, 2)); ?></td></tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white py-3">
                    <h6 class="fw-bold mb-0"><i class="fas fa-credit-card me-2 text-primary"></i>Payment</h6>
                </div>
                <div class="card-body">
                    <p class="mb-1"><strong>Method:</strong> <?php echo e($order->payment?->methodLabel() ?? 'Cash on Delivery'); ?></p>
                    <p class="mb-0">
                        <strong>Status:</strong>
                        <span class="badge <?php echo e($order->paymentStatusBadge()); ?>"><?php echo e(ucfirst($order->payment_status)); ?></span>
                    </p>
                </div>
            </div>

            
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white py-3">
                    <h6 class="fw-bold mb-0"><i class="fas fa-truck me-2 text-primary"></i>Shipping</h6>
                </div>
                <div class="card-body">
                    <?php $addr = $order->shipping_address ?>
                    <?php if($addr): ?>
                        <p class="mb-1"><strong><?php echo e($addr['name']); ?></strong></p>
                        <p class="mb-1"><?php echo e($addr['address_line1']); ?></p>
                        <?php if($addr['address_line2']): ?><p class="mb-1"><?php echo e($addr['address_line2']); ?></p><?php endif; ?>
                        <p class="mb-1"><?php echo e($addr['city']); ?>, <?php echo e($addr['state'] ?? ''); ?> <?php echo e($addr['zip'] ?? ''); ?></p>
                        <p class="mb-0"><?php echo e($addr['country']); ?></p>
                    <?php endif; ?>
                    <hr class="my-2">
                    <small class="text-muted">Method: <?php echo e(ucfirst($order->shipping_method ?? 'Standard')); ?></small>
                    <?php if($order->hasTracking()): ?>
                        <hr class="my-2">
                        <small class="text-muted d-block">Carrier: <?php echo e($order->carrier); ?></small>
                        <small class="text-muted d-block">
                            Tracking:
                            <?php if($order->tracking_url): ?>
                                <a href="<?php echo e($order->tracking_url); ?>" target="_blank"><?php echo e($order->tracking_number); ?></a>
                            <?php else: ?>
                                <?php echo e($order->tracking_number); ?>

                            <?php endif; ?>
                        </small>
                    <?php endif; ?>
                </div>
            </div>

            
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="fw-bold mb-0"><i class="fas fa-clock me-2 text-primary"></i>Timeline</h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0 small">
                        <li class="mb-2"><i class="fas fa-circle text-success me-2" style="font-size: 8px;"></i>Placed: <?php echo e($order->created_at->format('M d, Y h:i A')); ?></li>
                        <?php if($order->paid_at): ?><li class="mb-2"><i class="fas fa-circle text-success me-2" style="font-size: 8px;"></i>Paid: <?php echo e($order->paid_at->format('M d, Y h:i A')); ?></li><?php endif; ?>
                        <?php if($order->confirmed_at): ?><li class="mb-2"><i class="fas fa-circle text-info me-2" style="font-size: 8px;"></i>Confirmed: <?php echo e($order->confirmed_at->format('M d, Y h:i A')); ?></li><?php endif; ?>
                        <?php if($order->packing_at): ?><li class="mb-2"><i class="fas fa-circle text-secondary me-2" style="font-size: 8px;"></i>Packing: <?php echo e($order->packing_at->format('M d, Y h:i A')); ?></li><?php endif; ?>
                        <?php if($order->shipping_at): ?><li class="mb-2"><i class="fas fa-circle text-dark me-2" style="font-size: 8px;"></i>Shipped: <?php echo e($order->shipping_at->format('M d, Y h:i A')); ?></li><?php endif; ?>
                        <?php if($order->delivered_at): ?><li class="mb-2"><i class="fas fa-circle text-success me-2" style="font-size: 8px;"></i>Delivered: <?php echo e($order->delivered_at->format('M d, Y h:i A')); ?></li><?php endif; ?>
                        <?php if($order->cancelled_at): ?><li class="mb-2"><i class="fas fa-circle text-danger me-2" style="font-size: 8px;"></i>Cancelled: <?php echo e($order->cancelled_at->format('M d, Y h:i A')); ?></li><?php endif; ?>
                        <?php if($order->returned_at): ?><li class="mb-2"><i class="fas fa-circle text-warning me-2" style="font-size: 8px;"></i>Returned: <?php echo e($order->returned_at->format('M d, Y h:i A')); ?></li><?php endif; ?>
                        <?php if($order->refunded_at): ?><li class="mb-2"><i class="fas fa-circle text-dark me-2" style="font-size: 8px;"></i>Refunded: <?php echo e($order->refunded_at->format('M d, Y h:i A')); ?></li><?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
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
<?php /**PATH C:\laragon\www\ecommerce\resources\views\customer\order-detail.blade.php ENDPATH**/ ?>