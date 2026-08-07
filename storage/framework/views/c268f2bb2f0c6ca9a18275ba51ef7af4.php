<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Order #<?php echo e($order->order_number); ?> - <?php echo e(config('app.name')); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; font-size: 13px; color: #1e293b; }
        .print-header { border-bottom: 2px solid #2563eb; padding-bottom: 15px; margin-bottom: 20px; }
        .print-header .brand { font-size: 24px; font-weight: 800; color: #2563eb; }
        .section-title { font-size: 14px; font-weight: 700; margin-bottom: 10px; padding-bottom: 5px; border-bottom: 1px solid #e2e8f0; }
        table.items-table { width: 100%; border-collapse: collapse; }
        table.items-table th { background: #f8fafc; padding: 8px 10px; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #e2e8f0; }
        table.items-table td { padding: 8px 10px; border-bottom: 1px solid #f1f5f9; }
        .summary-table td { padding: 5px 10px; }
        .badge-status { padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; }
        @media print {
            .no-print { display: none !important; }
            body { padding: 20px; }
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <div class="no-print text-center mb-3">
            <button class="btn btn-primary" onclick="window.print()"><i class="fas fa-print me-1"></i>Print</button>
            <button class="btn btn-outline-secondary" onclick="window.close()">Close</button>
        </div>

        <div class="print-header d-flex justify-content-between align-items-center">
            <div>
                <div class="brand"><?php echo e(config('app.name')); ?></div>
                <small class="text-muted"><?php echo e(config('ecommerce.store_address', '')); ?></small>
            </div>
            <div class="text-end">
                <h5 class="mb-1">Order #<?php echo e($order->order_number); ?></h5>
                <small class="text-muted">Date: <?php echo e($order->created_at->format('M d, Y h:i A')); ?></small>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-4">
                <div class="section-title">Customer</div>
                <?php $addr = $order->shipping_address ?? [] ?>
                <p class="mb-0"><?php echo e($addr['name'] ?? ($order->user?->name ?? 'Guest')); ?></p>
                <small><?php echo e($addr['email'] ?? $order->user?->email ?? ''); ?></small><br>
                <small><?php echo e($addr['phone'] ?? ''); ?></small>
            </div>
            <div class="col-4">
                <div class="section-title">Shipping Address</div>
                <?php if($addr && ($addr['address_line1'] ?? false)): ?>
                    <p class="mb-0"><?php echo e($addr['address_line1']); ?></p>
                    <?php if($addr['address_line2'] ?? false): ?><p class="mb-0"><?php echo e($addr['address_line2']); ?></p><?php endif; ?>
                    <small><?php echo e($addr['city'] ?? ''); ?><?php echo e($addr['state'] ? ', ' . $addr['state'] : ''); ?> <?php echo e($addr['zip'] ?? ''); ?></small><br>
                    <small><?php echo e($addr['country'] ?? ''); ?></small>
                <?php else: ?>
                    <small class="text-muted">No address</small>
                <?php endif; ?>
            </div>
            <div class="col-4">
                <div class="section-title">Order Info</div>
                <table style="width: 100%;">
                    <tr><td><small>Status:</small></td><td class="text-end"><span class="badge-status bg-warning"><?php echo e(ucfirst($order->status)); ?></span></td></tr>
                    <tr><td><small>Payment:</small></td><td class="text-end"><span class="badge-status bg-<?php echo e($order->payment_status === 'paid' ? 'success' : 'warning'); ?>"><?php echo e(ucfirst($order->payment_status)); ?></span></td></tr>
                    <tr><td><small>Method:</small></td><td class="text-end"><small><?php echo e($order->payment?->methodLabel() ?? '—'); ?></small></td></tr>
                    <tr><td><small>Shipping:</small></td><td class="text-end"><small><?php echo e(ucfirst($order->shipping_method ?? 'Standard')); ?></small></td></tr>
                </table>
            </div>
        </div>

        <div class="section-title">Order Items</div>
        <table class="items-table mb-4">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th>SKU</th>
                    <th class="text-center">Qty</th>
                    <th class="text-end">Price</th>
                    <th class="text-end">Discount</th>
                    <th class="text-end">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($loop->iteration); ?></td>
                    <td><?php echo e($item->product_name); ?></td>
                    <td><?php echo e($item->product_sku ?? '—'); ?></td>
                    <td class="text-center"><?php echo e($item->quantity); ?></td>
                    <td class="text-end"><?php echo e(config('ecommerce.currency_symbol', '$')); ?><?php echo e(number_format($item->unit_price, 2)); ?></td>
                    <td class="text-end"><?php echo e($item->discount > 0 ? '-' . config('ecommerce.currency_symbol', '$') . number_format($item->discount, 2) : '—'); ?></td>
                    <td class="text-end fw-semibold"><?php echo e(config('ecommerce.currency_symbol', '$')); ?><?php echo e(number_format($item->subtotal, 2)); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>

        <div class="row justify-content-end">
            <div class="col-4">
                <table class="summary-table" style="width: 100%;">
                    <tr><td>Subtotal</td><td class="text-end fw-semibold"><?php echo e(config('ecommerce.currency_symbol', '$')); ?><?php echo e(number_format($order->subtotal, 2)); ?></td></tr>
                    <?php if($order->coupon_discount > 0): ?>
                        <tr><td>Discount</td><td class="text-end text-success">-<?php echo e(config('ecommerce.currency_symbol', '$')); ?><?php echo e(number_format($order->coupon_discount, 2)); ?></td></tr>
                    <?php endif; ?>
                    <tr><td>Shipping (<?php echo e(ucfirst($order->shipping_method ?? 'Standard')); ?>)</td><td class="text-end"><?php echo e(config('ecommerce.currency_symbol', '$')); ?><?php echo e(number_format($order->shipping_cost, 2)); ?></td></tr>
                    <tr><td>Tax (<?php echo e($order->tax_rate); ?>%)</td><td class="text-end"><?php echo e(config('ecommerce.currency_symbol', '$')); ?><?php echo e(number_format($order->tax_amount, 2)); ?></td></tr>
                    <tr style="border-top: 2px solid #2563eb;"><td class="fw-bold fs-5">Grand Total</td><td class="text-end fw-bold fs-5 text-primary"><?php echo e(config('ecommerce.currency_symbol', '$')); ?><?php echo e(number_format($order->total, 2)); ?></td></tr>
                </table>
            </div>
        </div>

        <?php if($order->notes): ?>
        <div class="mt-4 pt-3 border-top">
            <small class="fw-semibold">Notes:</small>
            <p class="text-muted small mb-0"><?php echo e($order->notes); ?></p>
        </div>
        <?php endif; ?>

        <div class="mt-4 pt-3 text-center border-top text-muted small">
            <?php echo e(config('app.name')); ?> &mdash; Order printed on <?php echo e(now()->format('M d, Y h:i A')); ?>

        </div>
    </div>
</body>
</html>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\admin\orders\print.blade.php ENDPATH**/ ?>