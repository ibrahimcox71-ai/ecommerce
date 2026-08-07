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
<?php $title = 'Invoice - ' . $order->invoice_number ?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-5">
                    
                    <div class="d-flex justify-content-between mb-5">
                        <div>
                            <h2 class="fw-bold text-primary"><?php echo e(config('app.name')); ?></h2>
                            <p class="text-muted mb-0">123 Store Street</p>
                            <p class="text-muted mb-0">New York, NY 10001</p>
                            <p class="text-muted">United States</p>
                        </div>
                        <div class="text-end">
                            <h3 class="fw-bold">INVOICE</h3>
                            <p class="mb-0"><strong>Invoice #:</strong> <?php echo e($order->invoice_number); ?></p>
                            <p class="mb-0"><strong>Order #:</strong> <?php echo e($order->order_number); ?></p>
                            <p class="mb-0"><strong>Date:</strong> <?php echo e($order->created_at->format('M d, Y')); ?></p>
                        </div>
                    </div>

                    
                    <div class="row mb-5">
                        <div class="col-6">
                            <h6 class="fw-bold text-uppercase text-muted mb-2">Bill To</h6>
                            <?php $billing = $order->billing_address ?? $order->shipping_address ?>
                            <?php if($billing): ?>
                                <p class="mb-1"><strong><?php echo e($billing['name']); ?></strong></p>
                                <p class="mb-1"><?php echo e($billing['address_line1']); ?></p>
                                <?php if($billing['address_line2']): ?><p class="mb-1"><?php echo e($billing['address_line2']); ?></p><?php endif; ?>
                                <p class="mb-1"><?php echo e($billing['city']); ?>, <?php echo e($billing['state'] ?? ''); ?> <?php echo e($billing['zip'] ?? ''); ?></p>
                                <p class="mb-1"><?php echo e($billing['country']); ?></p>
                                <p class="mb-0"><?php echo e($billing['email']); ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="col-6">
                            <h6 class="fw-bold text-uppercase text-muted mb-2">Ship To</h6>
                            <?php $shipping = $order->shipping_address ?>
                            <?php if($shipping): ?>
                                <p class="mb-1"><strong><?php echo e($shipping['name']); ?></strong></p>
                                <p class="mb-1"><?php echo e($shipping['address_line1']); ?></p>
                                <?php if($shipping['address_line2']): ?><p class="mb-1"><?php echo e($shipping['address_line2']); ?></p><?php endif; ?>
                                <p class="mb-1"><?php echo e($shipping['city']); ?>, <?php echo e($shipping['state'] ?? ''); ?> <?php echo e($shipping['zip'] ?? ''); ?></p>
                                <p class="mb-1"><?php echo e($shipping['country']); ?></p>
                                <p class="mb-0"><?php echo e($shipping['email']); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th>SKU</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Unit Price</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($index + 1); ?></td>
                                    <td><?php echo e($item->product_name); ?></td>
                                    <td><?php echo e($item->product_sku ?? '—'); ?></td>
                                    <td class="text-center"><?php echo e($item->quantity); ?></td>
                                    <td class="text-end">$<?php echo e(number_format($item->unit_price, 2)); ?></td>
                                    <td class="text-end">$<?php echo e(number_format($item->subtotal, 2)); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" class="text-end fw-semibold">Subtotal</td>
                                <td class="text-end">$<?php echo e(number_format($order->subtotal, 2)); ?></td>
                            </tr>
                            <?php if($order->coupon_discount > 0): ?>
                                <tr>
                                    <td colspan="5" class="text-end fw-semibold text-success">Discount</td>
                                    <td class="text-end text-success">-$<?php echo e(number_format($order->coupon_discount, 2)); ?></td>
                                </tr>
                            <?php endif; ?>
                            <tr>
                                <td colspan="5" class="text-end fw-semibold">Shipping (<?php echo e($order->shipping_method ?? 'Standard'); ?>)</td>
                                <td class="text-end">$<?php echo e(number_format($order->shipping_cost, 2)); ?></td>
                            </tr>
                            <tr>
                                <td colspan="5" class="text-end fw-semibold">Tax</td>
                                <td class="text-end">$<?php echo e(number_format($order->tax_amount, 2)); ?></td>
                            </tr>
                            <tr>
                                <td colspan="5" class="text-end fw-bold fs-5">Total</td>
                                <td class="text-end fw-bold fs-5">$<?php echo e(number_format($order->total, 2)); ?></td>
                            </tr>
                        </tfoot>
                    </table>

                    
                    <div class="row mt-4">
                        <div class="col-6">
                            <p class="mb-1"><strong>Payment Method:</strong> <?php echo e($order->payment?->payment_method ? ucfirst($order->payment->payment_method) : 'Cash on Delivery'); ?></p>
                            <p class="mb-0"><strong>Payment Status:</strong>
                                <span class="badge <?php echo e($order->payment_status === 'paid' ? 'bg-success' : 'bg-warning'); ?>">
                                    <?php echo e(ucfirst($order->payment_status)); ?>

                                </span>
                            </p>
                        </div>
                        <div class="col-6 text-end">
                            <p class="text-muted mb-0">Thank you for your business!</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <button class="btn btn-primary" onclick="window.print()">
                    <i class="fas fa-print me-2"></i>Print Invoice
                </button>
                <a href="<?php echo e(route('customer.orders')); ?>" class="btn btn-outline-secondary ms-2">
                    <i class="fas fa-arrow-left me-2"></i>Back to Orders
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
<?php /**PATH C:\laragon\www\ecommerce\resources\views\frontend\invoice.blade.php ENDPATH**/ ?>