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
<?php $title = 'Track Order' ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 text-center">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3 sizing-72 bg-primary-light">
                        <i class="fas fa-search fa-2x text-primary-custom"></i>
                    </div>
                    <h4 class="fw-bold mb-2 text-gray-800">Track Your Order</h4>
                    <p class="text-muted mb-4">Enter your order number to check the current status.</p>

                    <form method="GET" action="<?php echo e(route('order.track')); ?>" class="mb-4">
                        <div class="input-group input-group-lg">
                            <input type="text" name="order_number" class="form-control rounded-0 rounded-start-pill"
                                   placeholder="e.g. ORD-..." value="<?php echo e(old('order_number', $orderNumber ?? '')); ?>">
                            <button class="btn btn-primary-modern px-4 rounded-0 rounded-end-pill" type="submit">
                                <i class="fas fa-search me-1"></i>Track
                            </button>
                        </div>
                    </form>

                    <?php if($order): ?>
                        <hr>
                        <div class="text-start mt-4">
                            <div class="d-flex justify-content-between mb-3">
                                <div>
                                    <small class="text-muted d-block">Order Number</small>
                                    <strong class="text-gray-800"><?php echo e($order->order_number); ?></strong>
                                </div>
                                <div class="text-end">
                                    <small class="text-muted d-block">Status</small>
                                    <span class="badge rounded-pill px-3 py-1 fs-6 bg-success text-white"><?php echo e(ucfirst($order->status)); ?></span>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mb-3">
                                <div>
                                    <small class="text-muted d-block">Total</small>
                                    <strong class="text-gray-800">$<?php echo e(number_format($order->total, 2)); ?></strong>
                                </div>
                                <div class="text-end">
                                    <small class="text-muted d-block">Payment</small>
                                    <span class="badge rounded-pill px-3 py-1 bg-primary-custom text-white"><?php echo e(ucfirst($order->payment_status)); ?></span>
                                </div>
                            </div>

                            <?php if($order->hasTracking()): ?>
                                <hr>
                                <div class="mb-3">
                                    <small class="text-muted d-block">Carrier</small>
                                    <strong class="text-gray-800"><?php echo e($order->carrier); ?></strong>
                                </div>
                                <div class="mb-3">
                                    <small class="text-muted d-block">Tracking Number</small>
                                    <strong>
                                        <?php if($order->tracking_url): ?>
                                            <a href="<?php echo e($order->tracking_url); ?>" target="_blank" class="text-primary-custom">
                                                <?php echo e($order->tracking_number); ?> <i class="fas fa-external-link-alt small"></i>
                                            </a>
                                        <?php else: ?>
                                            <span class="text-gray-800"><?php echo e($order->tracking_number); ?></span>
                                        <?php endif; ?>
                                    </strong>
                                </div>
                            <?php endif; ?>

                            <hr>
                            <h6 class="fw-bold mb-3 text-gray-800">Order Timeline</h6>
                            <ul class="list-unstyled small">
                                <li class="mb-2"><i class="fas fa-circle me-2 text-success fs-9"></i>Placed: <?php echo e($order->created_at->format('M d, Y h:i A')); ?></li>
                                <?php if($order->paid_at): ?><li class="mb-2"><i class="fas fa-circle me-2 text-success fs-9"></i>Paid: <?php echo e($order->paid_at->format('M d, Y h:i A')); ?></li><?php endif; ?>
                                <?php if($order->confirmed_at): ?><li class="mb-2"><i class="fas fa-circle me-2 text-info fs-9"></i>Confirmed: <?php echo e($order->confirmed_at->format('M d, Y h:i A')); ?></li><?php endif; ?>
                                <?php if($order->packing_at): ?><li class="mb-2"><i class="fas fa-circle me-2 text-gray-500 fs-9"></i>Packing: <?php echo e($order->packing_at->format('M d, Y h:i A')); ?></li><?php endif; ?>
                                <?php if($order->shipping_at): ?><li class="mb-2"><i class="fas fa-circle me-2 text-gray-800 fs-9"></i>Shipped: <?php echo e($order->shipping_at->format('M d, Y h:i A')); ?></li><?php endif; ?>
                                <?php if($order->delivered_at): ?><li class="mb-2"><i class="fas fa-circle me-2 text-success fs-9"></i>Delivered: <?php echo e($order->delivered_at->format('M d, Y h:i A')); ?></li><?php endif; ?>
                                <?php if($order->cancelled_at): ?><li class="mb-2"><i class="fas fa-circle me-2 text-danger fs-9"></i>Cancelled: <?php echo e($order->cancelled_at->format('M d, Y h:i A')); ?></li><?php endif; ?>
                                <?php if($order->returned_at): ?><li class="mb-2"><i class="fas fa-circle me-2 text-warning fs-9"></i>Returned: <?php echo e($order->returned_at->format('M d, Y h:i A')); ?></li><?php endif; ?>
                                <?php if($order->refunded_at): ?><li class="mb-2"><i class="fas fa-circle me-2 text-gray-600 fs-9"></i>Refunded: <?php echo e($order->refunded_at->format('M d, Y h:i A')); ?></li><?php endif; ?>
                            </ul>
                        </div>

                        <div class="text-center mt-3">
                            <a href="<?php echo e(route('order.invoice', $order)); ?>" class="btn rounded-pill px-4 border-primary-custom text-primary-custom" target="_blank">
                                <i class="fas fa-file-invoice me-1"></i>View Invoice
                            </a>
                        </div>
                    <?php elseif($orderNumber): ?>
                        <div class="rounded-3 p-3 d-flex align-items-center gap-2 bg-warning-light text-gray-800">
                            <i class="fas fa-exclamation-triangle text-warning"></i>
                            No order found with number "<?php echo e($orderNumber); ?>".
                        </div>
                    <?php endif; ?>
                </div>
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
<?php /**PATH C:\laragon\www\ecommerce\resources\views\frontend\track-order.blade.php ENDPATH**/ ?>