<?php if (isset($component)) { $__componentOriginaledc75c655a063d12a477f2c8d8f324fc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc = $attributes; } ?>
<?php $component = App\View\Components\Layouts\AdminLayout::resolve(['title' => 'Edit Order '.e($order->order_number).''] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <a href="<?php echo e(route('admin.orders.show', $order)); ?>" class="text-muted text-decoration-none small">
            <i class="fas fa-arrow-left me-1"></i>Back to Order
        </a>
        <h4 class="fw-bold mb-0 mt-1">Edit Order #<?php echo e($order->order_number); ?></h4>
        <p class="text-muted small mb-0">Update order details and items</p>
    </div>
</div>

<form method="POST" action="<?php echo e(route('admin.orders.update', $order)); ?>" id="orderForm">
    <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>

    <div class="row g-4">
        <div class="col-lg-8">
            
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0"><i class="fas fa-box me-2 text-primary"></i>Order Items</h5>
                    <button type="button" class="btn btn-sm btn-outline-primary" id="addItemBtn">
                        <i class="fas fa-plus me-1"></i>Add Item
                    </button>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0" id="itemsTable">
                            <thead class="table-light">
                                <tr>
                                    <th>Product</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-end">Price</th>
                                    <th class="text-end">Discount</th>
                                    <th class="text-end">Subtotal</th>
                                    <th class="text-center"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="item-row">
                                    <td>
                                        <input type="text" name="items[<?php echo e($idx); ?>][product_name]" class="form-control form-control-sm" value="<?php echo e($item->product_name); ?>" required>
                                        <input type="hidden" name="items[<?php echo e($idx); ?>][product_id]" value="<?php echo e($item->product_id); ?>">
                                        <input type="hidden" name="items[<?php echo e($idx); ?>][product_sku]" value="<?php echo e($item->product_sku); ?>">
                                        <?php if($item->product_sku): ?>
                                            <small class="text-muted"><?php echo e($item->product_sku); ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <input type="number" name="items[<?php echo e($idx); ?>][quantity]" class="form-control form-control-sm item-qty text-center" value="<?php echo e($item->quantity); ?>" min="1" step="1">
                                    </td>
                                    <td>
                                        <input type="number" name="items[<?php echo e($idx); ?>][unit_price]" class="form-control form-control-sm item-price text-end" step="0.01" min="0" value="<?php echo e($item->unit_price); ?>">
                                    </td>
                                    <td>
                                        <input type="number" name="items[<?php echo e($idx); ?>][discount]" class="form-control form-control-sm item-discount text-end" step="0.01" min="0" value="<?php echo e($item->discount); ?>">
                                    </td>
                                    <td>
                                        <input type="number" name="items[<?php echo e($idx); ?>][subtotal]" class="form-control form-control-sm item-subtotal text-end" step="0.01" readonly value="<?php echo e($item->subtotal); ?>">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-outline-danger remove-item" <?php echo e($loop->first ? 'disabled' : ''); ?>>
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="4" class="text-end fw-semibold">Subtotal:</td>
                                    <td class="text-end fw-bold" id="subtotalDisplay">$<?php echo e(number_format($order->subtotal, 2)); ?></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-end fw-semibold">Shipping:</td>
                                    <td class="text-end">
                                        <input type="number" name="shipping_cost" id="shippingCost" class="form-control form-control-sm text-end" step="0.01" min="0" value="<?php echo e($order->shipping_cost); ?>" style="width: 130px; margin-left: auto;">
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-end fw-semibold">Tax Amount:</td>
                                    <td class="text-end fw-bold" id="taxDisplay">$<?php echo e(number_format($order->tax_amount, 2)); ?></td>
                                    <td></td>
                                </tr>
                                <tr class="border-top">
                                    <td colspan="4" class="text-end fw-bold fs-5">Total:</td>
                                    <td class="text-end fw-bold fs-5 text-primary" id="totalDisplay">$<?php echo e(number_format($order->total, 2)); ?></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="fw-bold mb-0"><i class="fas fa-truck me-2 text-primary"></i>Shipping & Tracking</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold">Method</label>
                            <select name="shipping_method" class="form-select">
                                <option value="standard" <?php if($order->shipping_method === 'standard'): echo 'selected'; endif; ?>>Standard</option>
                                <option value="express" <?php if($order->shipping_method === 'express'): echo 'selected'; endif; ?>>Express</option>
                                <option value="overnight" <?php if($order->shipping_method === 'overnight'): echo 'selected'; endif; ?>>Overnight</option>
                                <option value="free" <?php if($order->shipping_method === 'free'): echo 'selected'; endif; ?>>Free</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold">Carrier</label>
                            <select name="carrier" class="form-select">
                                <option value="">Select Carrier</option>
                                <option value="UPS" <?php if($order->carrier === 'UPS'): echo 'selected'; endif; ?>>UPS</option>
                                <option value="FedEx" <?php if($order->carrier === 'FedEx'): echo 'selected'; endif; ?>>FedEx</option>
                                <option value="USPS" <?php if($order->carrier === 'USPS'): echo 'selected'; endif; ?>>USPS</option>
                                <option value="DHL" <?php if($order->carrier === 'DHL'): echo 'selected'; endif; ?>>DHL</option>
                                <option value="Aramex" <?php if($order->carrier === 'Aramex'): echo 'selected'; endif; ?>>Aramex</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold">Tracking #</label>
                            <input type="text" name="tracking_number" class="form-control" value="<?php echo e($order->tracking_number); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Tracking URL</label>
                            <input type="url" name="tracking_url" class="form-control" value="<?php echo e($order->tracking_url); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Estimated Delivery</label>
                            <input type="date" name="estimated_delivery" class="form-control" value="<?php echo e($order->estimated_delivery?->format('Y-m-d')); ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold">Name</label>
                            <input type="text" name="shipping_address[name]" class="form-control" value="<?php echo e($order->shipping_address['name'] ?? ''); ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold">Email</label>
                            <input type="email" name="shipping_address[email]" class="form-control" value="<?php echo e($order->shipping_address['email'] ?? ''); ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold">Phone</label>
                            <input type="text" name="shipping_address[phone]" class="form-control" value="<?php echo e($order->shipping_address['phone'] ?? ''); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Address</label>
                            <input type="text" name="shipping_address[address_line1]" class="form-control" value="<?php echo e($order->shipping_address['address_line1'] ?? ''); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Address Line 2</label>
                            <input type="text" name="shipping_address[address_line2]" class="form-control" value="<?php echo e($order->shipping_address['address_line2'] ?? ''); ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-semibold">City</label>
                            <input type="text" name="shipping_address[city]" class="form-control" value="<?php echo e($order->shipping_address['city'] ?? ''); ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-semibold">State</label>
                            <input type="text" name="shipping_address[state]" class="form-control" value="<?php echo e($order->shipping_address['state'] ?? ''); ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-semibold">ZIP</label>
                            <input type="text" name="shipping_address[zip]" class="form-control" value="<?php echo e($order->shipping_address['zip'] ?? ''); ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-semibold">Country</label>
                            <input type="text" name="shipping_address[country]" class="form-control" value="<?php echo e($order->shipping_address['country'] ?? 'US'); ?>">
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="fw-bold mb-0"><i class="fas fa-sticky-note me-2 text-primary"></i>Notes</h5>
                </div>
                <div class="card-body">
                    <textarea name="notes" class="form-control" rows="3"><?php echo e($order->notes); ?></textarea>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white py-3">
                    <h6 class="fw-bold mb-0"><i class="fas fa-receipt me-2 text-primary"></i>Order Summary</h6>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr><td class="text-muted">Order #</td><td class="text-end fw-semibold"><?php echo e($order->order_number); ?></td></tr>
                        <tr><td class="text-muted">Status</td><td class="text-end"><span class="badge <?php echo e($order->statusBadge()); ?>"><?php echo e(ucfirst($order->status)); ?></span></td></tr>
                        <tr><td class="text-muted">Payment</td><td class="text-end"><span class="badge <?php echo e($order->paymentStatusBadge()); ?>"><?php echo e(ucfirst($order->payment_status)); ?></span></td></tr>
                        <tr><td class="text-muted">Date</td><td class="text-end"><?php echo e($order->created_at->format('M d, Y')); ?></td></tr>
                    </table>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <button type="submit" class="btn btn-primary w-100 btn-lg">
                        <i class="fas fa-save me-2"></i>Update Order
                    </button>
                    <a href="<?php echo e(route('admin.orders.show', $order)); ?>" class="btn btn-outline-secondary w-100 mt-2">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</form>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let rowIndex = <?php echo e($order->items->count()); ?>;

    function calculateRow(row) {
        const qty = parseFloat(row.querySelector('.item-qty').value) || 0;
        const price = parseFloat(row.querySelector('.item-price').value) || 0;
        const discount = parseFloat(row.querySelector('.item-discount').value) || 0;
        const subtotal = (qty * price) - discount;
        row.querySelector('.item-subtotal').value = subtotal.toFixed(2);
        calculateTotal();
    }

    function calculateTotal() {
        let subtotal = 0;
        document.querySelectorAll('.item-row').forEach(row => {
            subtotal += parseFloat(row.querySelector('.item-subtotal').value) || 0;
        });

        const shipping = parseFloat(document.getElementById('shippingCost').value) || 0;
        const total = subtotal + shipping;

        document.getElementById('subtotalDisplay').textContent = '$' + subtotal.toFixed(2);
        document.getElementById('totalDisplay').textContent = '$' + Math.max(0, total).toFixed(2);
    }

    function addItemRow() {
        const tbody = document.querySelector('#itemsTable tbody');
        const template = document.querySelector('.item-row');
        const row = template.cloneNode(true);

        row.querySelectorAll('input').forEach(el => {
            const name = el.getAttribute('name');
            if (name) {
                el.setAttribute('name', name.replace(/\[\d+\]/, '[' + rowIndex + ']'));
            }
            if (el.type !== 'hidden' && !el.classList.contains('remove-item')) {
                el.value = el.classList.contains('item-qty') ? '1' : el.classList.contains('item-discount') ? '0' : '';
            }
        });

        row.querySelector('.remove-item').disabled = false;
        tbody.appendChild(row);

        row.querySelectorAll('.item-qty, .item-price, .item-discount').forEach(el => {
            el.addEventListener('input', () => calculateRow(row));
        });

        row.querySelector('.remove-item').addEventListener('click', function() {
            if (document.querySelectorAll('.item-row').length > 1) {
                row.remove();
                calculateTotal();
            }
        });

        rowIndex++;
    }

    document.getElementById('addItemBtn').addEventListener('click', addItemRow);

    document.querySelectorAll('.item-row').forEach(row => {
        row.querySelectorAll('.item-qty, .item-price, .item-discount').forEach(el => {
            el.addEventListener('input', () => calculateRow(row));
        });
        row.querySelector('.remove-item').addEventListener('click', function() {
            if (document.querySelectorAll('.item-row').length > 1) {
                row.remove();
                calculateTotal();
            }
        });
    });

    document.getElementById('shippingCost').addEventListener('input', calculateTotal);
    calculateTotal();
});
</script>
<?php $__env->stopPush(); ?>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaledc75c655a063d12a477f2c8d8f324fc)): ?>
<?php $attributes = $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc; ?>
<?php unset($__attributesOriginaledc75c655a063d12a477f2c8d8f324fc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaledc75c655a063d12a477f2c8d8f324fc)): ?>
<?php $component = $__componentOriginaledc75c655a063d12a477f2c8d8f324fc; ?>
<?php unset($__componentOriginaledc75c655a063d12a477f2c8d8f324fc); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\admin\orders\edit.blade.php ENDPATH**/ ?>