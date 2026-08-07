<?php if (isset($component)) { $__componentOriginaleac9542bb5e3f887e862d1d96c472e9b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaleac9542bb5e3f887e862d1d96c472e9b = $attributes; } ?>
<?php $component = App\View\Components\Layouts\FrontendLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.frontend-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\FrontendLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php $title = 'Order Placed Successfully' ?>

<div class="container py-5">
    <div class="text-center mb-5">
        <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3 sizing-96 bg-success-light">
            <i class="fas fa-check-circle text-success-custom" style="font-size: 3rem;"></i>
        </div>
        <h1 class="fw-bold text-gray-800">Thank You for Your Order!</h1>
        <p class="fs-5 text-gray-500">Your order has been placed successfully.</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <div class="row text-center">
                        <div class="col-4 border-end">
                            <small class="text-muted d-block">Order Number</small>
                            <strong class="fs-5 text-gray-800"><?php echo e($order->order_number); ?></strong>
                        </div>
                        <div class="col-4 border-end">
                            <small class="text-muted d-block">Date</small>
                            <strong class="text-gray-800"><?php echo e($order->created_at->format('M d, Y')); ?></strong>
                        </div>
                        <div class="col-4">
                            <small class="text-muted d-block">Total</small>
                            <strong class="fs-5 text-primary-custom">$<?php echo e(number_format($order->total, 2)); ?></strong>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 rounded-4 rounded-bottom-0 border-0">
                    <h5 class="fw-bold mb-0 text-gray-800">Order Items</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="fw-semibold text-gray-800">Product</th>
                                    <th class="text-center fw-semibold text-gray-800">Qty</th>
                                    <th class="text-end fw-semibold text-gray-800">Price</th>
                                    <th class="text-end fw-semibold text-gray-800">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <?php if($item->product_image): ?>
                                                    <img src="<?php echo e($item->product_image); ?>" alt="<?php echo e($item->product_name); ?>"
                                                         style="width: 50px; height: 50px;" class="object-cover rounded-3">
                                                <?php endif; ?>
                                                <div>
                                                    <span class="fw-semibold text-gray-800"><?php echo e($item->product_name); ?></span>
                                                    <?php if($item->product_sku): ?>
                                                        <br><small class="text-muted">SKU: <?php echo e($item->product_sku); ?></small>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center"><?php echo e($item->quantity); ?></td>
                                        <td class="text-end">$<?php echo e(number_format($item->unit_price, 2)); ?></td>
                                        <td class="text-end fw-semibold">$<?php echo e(number_format($item->subtotal, 2)); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                            <tfoot class="bg-gray-50">
                                <tr>
                                    <td colspan="3" class="text-end text-gray-500">Subtotal</td>
                                    <td class="text-end text-gray-800">$<?php echo e(number_format($order->subtotal, 2)); ?></td>
                                </tr>
                                <?php if($order->coupon_discount > 0): ?>
                                    <tr>
                                        <td colspan="3" class="text-end text-success-custom">Discount</td>
                                        <td class="text-end text-success-custom">-$<?php echo e(number_format($order->coupon_discount, 2)); ?></td>
                                    </tr>
                                <?php endif; ?>
                                <tr>
                                    <td colspan="3" class="text-end text-gray-500">Shipping</td>
                                    <td class="text-end text-gray-800">$<?php echo e(number_format($order->shipping_cost, 2)); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end text-gray-500">Tax</td>
                                    <td class="text-end text-gray-800">$<?php echo e(number_format($order->tax_amount, 2)); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end fw-bold text-gray-800">Total</td>
                                    <td class="text-end fw-bold fs-5 text-primary-custom">$<?php echo e(number_format($order->total, 2)); ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 rounded-4 rounded-bottom-0 border-0">
                    <h5 class="fw-bold mb-0 text-gray-800">Shipping Address</h5>
                </div>
                <div class="card-body">
                    <?php $addr = $order->shipping_address ?>
                    <?php if($addr): ?>
                        <p class="mb-1"><strong class="text-gray-800"><?php echo e($addr['name']); ?></strong></p>
                        <p class="mb-1 text-muted"><?php echo e($addr['address_line1']); ?></p>
                        <?php if($addr['address_line2']): ?><p class="mb-1 text-muted"><?php echo e($addr['address_line2']); ?></p><?php endif; ?>
                        <p class="mb-1 text-muted"><?php echo e($addr['city']); ?>, <?php echo e($addr['state'] ?? ''); ?> <?php echo e($addr['zip'] ?? ''); ?></p>
                        <p class="mb-1 text-muted"><?php echo e($addr['country']); ?></p>
                        <p class="mb-0 text-muted"><?php echo e($addr['email']); ?> | <?php echo e($addr['phone']); ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 rounded-4 rounded-bottom-0 border-0">
                    <h5 class="fw-bold mb-0 text-gray-800">Payment</h5>
                </div>
                <div class="card-body">
                    <p class="mb-1">
                        <strong class="text-gray-800">Method:</strong>
                        <?php if($order->payment): ?>
                            <span class="text-muted"><?php echo e(ucfirst($order->payment->payment_method)); ?></span>
                        <?php else: ?>
                            <span class="text-muted">Cash on Delivery</span>
                        <?php endif; ?>
                    </p>
                    <p class="mb-0">
                        <strong class="text-gray-800">Status:</strong>
                        <span class="badge rounded-pill px-3 py-1 bg-warning text-dark"><?php echo e(ucfirst($order->payment_status)); ?></span>
                    </p>
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="<?php echo e(route('shop')); ?>" class="btn btn-lg rounded-pill px-4 border-primary-custom text-primary-custom">
                    <i class="fas fa-arrow-left me-2"></i>Continue Shopping
                </a>
                <a href="<?php echo e(route('customer.orders')); ?>" class="btn btn-lg rounded-pill px-4 btn-primary-modern">
                    <i class="fas fa-list me-2"></i>View Orders
                </a>
            </div>
        </div>
    </div>
</div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaleac9542bb5e3f887e862d1d96c472e9b)): ?>
<?php $attributes = $__attributesOriginaleac9542bb5e3f887e862d1d96c472e9b; ?>
<?php unset($__attributesOriginaleac9542bb5e3f887e862d1d96c472e9b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaleac9542bb5e3f887e862d1d96c472e9b)): ?>
<?php $component = $__componentOriginaleac9542bb5e3f887e862d1d96c472e9b; ?>
<?php unset($__componentOriginaleac9542bb5e3f887e862d1d96c472e9b); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\frontend\order-success.blade.php ENDPATH**/ ?>