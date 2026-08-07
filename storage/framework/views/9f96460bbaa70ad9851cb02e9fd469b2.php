<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Purchase Order - <?php echo e($purchase->po_number); ?></title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; color: #333; }
        .header { border-bottom: 2px solid #333; padding-bottom: 15px; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 24px; }
        .header .po-number { font-size: 18px; color: #666; }
        .info-table { width: 100%; margin-bottom: 20px; }
        .info-table td { padding: 4px 8px; vertical-align: top; }
        .info-table .label { font-weight: bold; width: 150px; color: #666; }
        table.items { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table.items th { background: #f5f5f5; padding: 8px; text-align: left; border: 1px solid #ddd; font-size: 11px; }
        table.items td { padding: 6px 8px; border: 1px solid #ddd; }
        table.items .text-end { text-align: right; }
        table.items .text-center { text-align: center; }
        .totals { width: 300px; margin-left: auto; }
        .totals td { padding: 4px 8px; }
        .totals .grand { font-size: 16px; font-weight: bold; }
        .footer { margin-top: 30px; border-top: 1px solid #ddd; padding-top: 15px; font-size: 11px; color: #999; }
        .status-badge { display: inline-block; padding: 3px 8px; border-radius: 3px; font-size: 11px; }
        .badge-secondary { background: #6c757d; color: white; }
        .badge-warning { background: #ffc107; color: #333; }
        .badge-info { background: #0dcaf0; color: #333; }
        .badge-primary { background: #0d6efd; color: white; }
        .badge-success { background: #198754; color: white; }
        .badge-danger { background: #dc3545; color: white; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body>
    <div class="no-print" style="text-align:center;margin-bottom:20px;">
        <button onclick="window.print()" style="padding:8px 20px;background:#0d6efd;color:white;border:none;border-radius:4px;cursor:pointer;">Print / Save PDF</button>
        <button onclick="window.close()" style="padding:8px 20px;background:#6c757d;color:white;border:none;border-radius:4px;cursor:pointer;margin-left:10px;">Close</button>
    </div>

    <div class="header">
        <table style="width:100%">
            <tr>
                <td>
                    <h1><?php echo e(config('app.name')); ?></h1>
                    <p style="margin:0;color:#666;">Purchase Order</p>
                </td>
                <td style="text-align:right">
                    <div class="po-number"><?php echo e($purchase->po_number); ?></div>
                    <span class="status-badge badge-<?php echo e($purchase->status->color()); ?>"><?php echo e($purchase->status->label()); ?></span>
                    <span class="status-badge badge-<?php echo e($purchase->payment_status->color()); ?>"><?php echo e($purchase->payment_status->label()); ?></span>
                </td>
            </tr>
        </table>
    </div>

    <table class="info-table">
        <tr>
            <td class="label">Supplier:</td>
            <td><strong><?php echo e($purchase->supplier?->name); ?></strong><br><?php echo e($purchase->supplier?->company_name ?: ''); ?><br><?php echo e($purchase->supplier?->full_address); ?></td>
            <td class="label">Warehouse:</td>
            <td><strong><?php echo e($purchase->warehouse?->name); ?></strong><br><?php echo e($purchase->warehouse?->full_address); ?></td>
        </tr>
        <tr>
            <td class="label">Purchase Date:</td>
            <td><?php echo e($purchase->purchase_date?->format('d M, Y')); ?></td>
            <td class="label">Expected Delivery:</td>
            <td><?php echo e($purchase->expected_delivery_date?->format('d M, Y') ?: '—'); ?></td>
        </tr>
        <tr>
            <td class="label">Reference:</td>
            <td><?php echo e($purchase->reference_number ?: '—'); ?></td>
            <td class="label">Currency:</td>
            <td><?php echo e($purchase->currency); ?></td>
        </tr>
    </table>

    <table class="items">
        <thead>
            <tr>
                <th style="width:5%">#</th>
                <th style="width:40%">Product</th>
                <th style="width:10%">SKU</th>
                <th class="text-end" style="width:10%">Qty</th>
                <th class="text-end" style="width:12%">Price</th>
                <th class="text-end" style="width:10%">Disc %</th>
                <th class="text-end" style="width:13%">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $purchase->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td class="text-center"><?php echo e($loop->iteration); ?></td>
                    <td><?php echo e($item->product_name); ?></td>
                    <td><?php echo e($item->sku ?: '—'); ?></td>
                    <td class="text-end"><?php echo e($item->quantity); ?></td>
                    <td class="text-end"><?php echo e(number_format($item->unit_price, 2)); ?></td>
                    <td class="text-end"><?php echo e($item->discount_percentage > 0 ? $item->discount_percentage . '%' : '—'); ?></td>
                    <td class="text-end"><?php echo e(number_format($item->total, 2)); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

    <table class="totals">
        <tr><td>Subtotal:</td><td class="text-end"><?php echo e(number_format($purchase->subtotal, 2)); ?></td></tr>
        <?php if($purchase->discount_amount > 0): ?>
            <tr><td>Discount:</td><td class="text-end">-<?php echo e(number_format($purchase->discount_amount, 2)); ?></td></tr>
        <?php endif; ?>
        <?php if($purchase->tax_amount > 0): ?>
            <tr><td>Tax:</td><td class="text-end"><?php echo e(number_format($purchase->tax_amount, 2)); ?></td></tr>
        <?php endif; ?>
        <?php if($purchase->shipping_cost > 0): ?>
            <tr><td>Shipping:</td><td class="text-end"><?php echo e(number_format($purchase->shipping_cost, 2)); ?></td></tr>
        <?php endif; ?>
        <tr class="grand"><td>Grand Total:</td><td class="text-end"><?php echo e(number_format($purchase->total_amount, 2)); ?></td></tr>
    </table>

    <?php if($purchase->notes): ?>
        <div style="margin-top:20px;padding:10px;background:#f9f9f9;border-radius:4px;">
            <strong>Notes:</strong><br><?php echo e($purchase->notes); ?>

        </div>
    <?php endif; ?>

    <?php if($purchase->terms): ?>
        <div style="margin-top:10px;padding:10px;background:#f9f9f9;border-radius:4px;">
            <strong>Terms:</strong><br><?php echo e($purchase->terms); ?>

        </div>
    <?php endif; ?>

    <div class="footer">
        <table style="width:100%">
            <tr>
                <td>Created by: <?php echo e($purchase->creator?->name ?? 'N/A'); ?></td>
                <td style="text-align:right"><?php echo e(now()->format('d M Y h:i A')); ?></td>
            </tr>
        </table>
    </div>
</body>
</html>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\admin\purchases\print.blade.php ENDPATH**/ ?>