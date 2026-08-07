<?php if (isset($component)) { $__componentOriginaledc75c655a063d12a477f2c8d8f324fc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc = $attributes; } ?>
<?php $component = App\View\Components\Layouts\AdminLayout::resolve(['title' => 'Order '.e($order->order_number).''] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <a href="<?php echo e(route('admin.orders.index')); ?>" class="text-muted text-decoration-none small">
            <i class="fas fa-arrow-left me-1"></i>Back to Orders
        </a>
        <h4 class="fw-bold mb-1 mt-1">Order #<?php echo e($order->order_number); ?></h4>
        <p class="text-muted small mb-0">
            <?php $s = App\Enums\OrderStatus::tryFrom($order->status); ?>
            <span class="badge <?php echo e($s?->badgeClass() ?? 'bg-light text-dark'); ?> fs-6"><?php echo e($s?->label() ?? ucfirst($order->status)); ?></span>
            <span class="badge <?php echo e($order->paymentStatusBadge()); ?> fs-6 ms-1"><?php echo e(ucfirst($order->payment_status)); ?></span>
            <?php if($order->order_origin !== 'website'): ?>
                <span class="badge bg-light text-dark fs-6 ms-1"><?php echo e(ucfirst($order->order_origin)); ?></span>
            <?php endif; ?>
        </p>
    </div>
    <div class="d-flex gap-2 flex-wrap">
        <?php $__currentLoopData = $allowedTransitions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transition): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <button type="button" class="btn btn-outline-<?php echo e($transition->color()); ?>"
                    onclick="document.getElementById('status-form').querySelector('[name=status]').value='<?php echo e($transition->value); ?>';document.getElementById('status-form').submit();">
                <i class="fas <?php echo e($transition->icon() ? 'fa-' . str_replace('bi-', '', $transition->icon()) : 'fa-arrow-right'); ?> me-1"></i>
                <?php echo e($transition->label()); ?>

            </button>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <div class="dropdown">
            <button class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                <i class="fas fa-cog me-1"></i> Actions
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="<?php echo e(route('admin.orders.print', $order)); ?>" target="_blank"><i class="fas fa-print me-2"></i>Print Order</a></li>
                <li><a class="dropdown-item" href="<?php echo e(route('admin.orders.invoice', $order)); ?>" target="_blank"><i class="fas fa-file-invoice me-2"></i>View Invoice</a></li>
                <li><hr class="dropdown-divider"></li>
                <?php if($order->isEditable()): ?>
                    <li><a class="dropdown-item" href="<?php echo e(route('admin.orders.edit', $order)); ?>"><i class="fas fa-edit me-2"></i>Edit Order</a></li>
                <?php endif; ?>
                <li>
                    <form method="POST" action="<?php echo e(route('admin.orders.duplicate', $order)); ?>" class="d-inline">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="dropdown-item"><i class="fas fa-copy me-2"></i>Duplicate</button>
                    </form>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="<?php echo e(route('admin.orders.export.csv', ['status' => $order->status])); ?>"><i class="fas fa-file-csv me-2 text-success"></i>Export CSV</a></li>
                <li><a class="dropdown-item" href="<?php echo e(route('admin.orders.export.excel', ['status' => $order->status])); ?>"><i class="fas fa-file-excel me-2 text-primary"></i>Export Excel</a></li>
                <?php if($order->isDeletable()): ?>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="<?php echo e(route('admin.orders.destroy', $order)); ?>" class="d-inline">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Delete this order permanently?')"><i class="fas fa-trash me-2"></i>Delete</button>
                        </form>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
        <a href="<?php echo e(route('admin.orders.index')); ?>" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i> Back</a>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        
        <form id="status-form" method="POST" action="<?php echo e(route('admin.orders.update-status', $order)); ?>" class="d-none">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="status">
        </form>

        
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0"><i class="fas fa-box me-2 text-primary"></i>Order Items</h5>
                <span><?php echo e($order->getItemCount()); ?> item(s)</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Product</th>
                                <th>SKU</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Unit Price</th>
                                <th class="text-end">Discount</th>
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
                                                     style="width: 40px; height: 40px; object-fit: cover;" class="rounded" loading="lazy">
                                            <?php else: ?>
                                                <div class="rounded bg-light d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                    <i class="fas fa-box text-muted"></i>
                                                </div>
                                            <?php endif; ?>
                                            <div>
                                                <span class="fw-semibold small"><?php echo e($item->product_name); ?></span>
                                                <?php if($item->variant): ?><br><small class="text-muted"><?php echo e($item->variant->name); ?></small><?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td><small class="text-muted"><?php echo e($item->product_sku ?? '—'); ?></small></td>
                                    <td class="text-center"><?php echo e($item->quantity); ?></td>
                                    <td class="text-end"><?php echo e(config('ecommerce.currency_symbol', '$')); ?><?php echo e(number_format($item->unit_price, 2)); ?></td>
                                    <td class="text-end text-danger"><?php echo e($item->discount > 0 ? '-' . config('ecommerce.currency_symbol', '$') . number_format($item->discount, 2) : '—'); ?></td>
                                    <td class="text-end fw-semibold"><?php echo e(config('ecommerce.currency_symbol', '$')); ?><?php echo e(number_format($item->subtotal, 2)); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white">
                <div class="row justify-content-end">
                    <div class="col-md-5">
                        <table class="table table-sm mb-0">
                            <tr><td class="text-end text-muted">Subtotal</td><td class="text-end fw-semibold"><?php echo e(config('ecommerce.currency_symbol', '$')); ?><?php echo e(number_format($order->subtotal, 2)); ?></td></tr>
                            <?php if($order->coupon_discount > 0): ?>
                                <tr><td class="text-end text-muted">Discount</td><td class="text-end text-success">-<?php echo e(config('ecommerce.currency_symbol', '$')); ?><?php echo e(number_format($order->coupon_discount, 2)); ?></td></tr>
                            <?php endif; ?>
                            <tr><td class="text-end text-muted">Shipping</td><td class="text-end"><?php echo e(config('ecommerce.currency_symbol', '$')); ?><?php echo e(number_format($order->shipping_cost, 2)); ?></td></tr>
                            <tr><td class="text-end text-muted">Tax (<?php echo e($order->tax_rate); ?>%)</td><td class="text-end"><?php echo e(config('ecommerce.currency_symbol', '$')); ?><?php echo e(number_format($order->tax_amount, 2)); ?></td></tr>
                            <tr class="border-top"><td class="text-end fw-bold">Grand Total</td><td class="text-end fw-bold fs-5 text-primary"><?php echo e(config('ecommerce.currency_symbol', '$')); ?><?php echo e(number_format($order->total, 2)); ?></td></tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0"><i class="fas fa-credit-card me-2 text-primary"></i>Payment</h5>
                <div>
                    <span class="badge <?php echo e($order->paymentStatusBadge()); ?> fs-6"><?php echo e(ucfirst($order->payment_status)); ?></span>
                </div>
            </div>
            <div class="card-body">
                <div class="row g-3 mb-3">
                    <div class="col-md-3">
                        <small class="text-muted d-block">Method</small>
                        <strong><?php echo e($order->payment?->methodLabel() ?? '—'); ?></strong>
                    </div>
                    <div class="col-md-3">
                        <small class="text-muted d-block">Amount</small>
                        <strong><?php echo e(config('ecommerce.currency_symbol', '$')); ?><?php echo e(number_format($order->payment?->amount ?? $order->total, 2)); ?></strong>
                    </div>
                    <div class="col-md-3">
                        <small class="text-muted d-block">Paid</small>
                        <strong><?php echo e(config('ecommerce.currency_symbol', '$')); ?><?php echo e(number_format($order->paid_amount, 2)); ?></strong>
                    </div>
                    <div class="col-md-3">
                        <small class="text-muted d-block">Due</small>
                        <strong class="<?php echo e($order->getDueAmount() > 0 ? 'text-danger' : 'text-success'); ?>"><?php echo e(config('ecommerce.currency_symbol', '$')); ?><?php echo e(number_format($order->getDueAmount(), 2)); ?></strong>
                    </div>
                </div>

                <?php if(in_array($order->payment_status, ['pending', 'partial'])): ?>
                    <div class="d-flex gap-2 flex-wrap mb-3">
                        <form method="POST" action="<?php echo e(route('admin.orders.mark-paid', $order)); ?>" class="d-flex gap-2 align-items-center">
                            <?php echo csrf_field(); ?>
                            <input type="text" name="reference" class="form-control form-control-sm" placeholder="Transaction ref" style="width: 180px;">
                            <button class="btn btn-sm btn-success" type="submit"><i class="fas fa-check me-1"></i>Mark Paid</button>
                        </form>
                        <form method="POST" action="<?php echo e(route('admin.orders.mark-partial-paid', $order)); ?>" class="d-flex gap-2 align-items-center">
                            <?php echo csrf_field(); ?>
                            <input type="number" name="amount" class="form-control form-control-sm" step="0.01" placeholder="Amount" style="width: 120px;" required>
                            <input type="text" name="reference" class="form-control form-control-sm" placeholder="Ref" style="width: 120px;">
                            <button class="btn btn-sm btn-info" type="submit"><i class="fas fa-money-bill me-1"></i>Partial</button>
                        </form>
                        <form method="POST" action="<?php echo e(route('admin.orders.mark-failed', $order)); ?>" class="d-inline">
                            <?php echo csrf_field(); ?>
                            <button class="btn btn-sm btn-outline-danger" type="submit"><i class="fas fa-times me-1"></i>Mark Failed</button>
                        </form>
                    </div>
                <?php endif; ?>

                <?php if($order->isPaid() && !$order->isRefunded()): ?>
                    <form method="POST" action="<?php echo e(route('admin.orders.refund', $order)); ?>" class="d-flex gap-2 align-items-center mb-3">
                        <?php echo csrf_field(); ?>
                        <input type="number" name="amount" class="form-control form-control-sm" step="0.01" style="width: 180px;"
                               placeholder="Refund amount (max: <?php echo e(config('ecommerce.currency_symbol', '$')); ?><?php echo e(number_format($order->paid_amount, 2)); ?>)"
                               max="<?php echo e($order->paid_amount); ?>" value="<?php echo e($order->paid_amount); ?>">
                        <input type="text" name="reason" class="form-control form-control-sm" placeholder="Reason" style="width: 200px;">
                        <button class="btn btn-sm btn-warning" type="submit"><i class="fas fa-undo me-1"></i>Refund</button>
                    </form>
                <?php endif; ?>

                <?php if($order->transactions->isNotEmpty()): ?>
                    <h6 class="fw-semibold mt-3 mb-2">Transaction History</h6>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Reference</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $order->transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $txn): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($txn->typeLabel()); ?></td>
                                        <td><?php echo e(config('ecommerce.currency_symbol', '$')); ?><?php echo e(number_format($txn->amount, 2)); ?></td>
                                        <td><span class="badge <?php echo e($txn->statusBadge()); ?>"><?php echo e(ucfirst($txn->status)); ?></span></td>
                                        <td><small><?php echo e($txn->reference ?? '—'); ?></small></td>
                                        <td><small class="text-muted"><?php echo e($txn->created_at->format('M d, Y h:i A')); ?></small></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="fw-bold mb-0"><i class="fas fa-truck me-2 text-primary"></i>Update Status & Tracking</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="<?php echo e(route('admin.orders.update-status', $order)); ?>" class="row g-2">
                    <?php echo csrf_field(); ?>
                    <div class="col-md-3">
                        <label class="form-label small fw-semibold">Status</label>
                        <select name="status" class="form-select">
                            <?php $__currentLoopData = App\Enums\OrderStatus::cases(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $st): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($st->value); ?>" <?php if($order->status === $st->value): echo 'selected'; endif; ?>>
                                    <?php echo e($st->label()); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-semibold">Tracking #</label>
                        <input type="text" name="tracking_number" class="form-control" placeholder="Tracking number" value="<?php echo e($order->tracking_number); ?>">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small fw-semibold">Carrier</label>
                        <select name="carrier" class="form-select">
                            <option value="">Select Carrier</option>
                            <option value="UPS" <?php if($order->carrier === 'UPS'): echo 'selected'; endif; ?>>UPS</option>
                            <option value="FedEx" <?php if($order->carrier === 'FedEx'): echo 'selected'; endif; ?>>FedEx</option>
                            <option value="USPS" <?php if($order->carrier === 'USPS'): echo 'selected'; endif; ?>>USPS</option>
                            <option value="DHL" <?php if($order->carrier === 'DHL'): echo 'selected'; endif; ?>>DHL</option>
                            <option value="Aramex" <?php if($order->carrier === 'Aramex'): echo 'selected'; endif; ?>>Aramex</option>
                            <option value="BlueDart" <?php if($order->carrier === 'BlueDart'): echo 'selected'; endif; ?>>BlueDart</option>
                            <option value="Delhivery" <?php if($order->carrier === 'Delhivery'): echo 'selected'; endif; ?>>Delhivery</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small fw-semibold">Est. Delivery</label>
                        <input type="date" name="estimated_delivery" class="form-control" value="<?php echo e($order->estimated_delivery?->format('Y-m-d')); ?>">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small fw-semibold">Cancel Reason</label>
                        <input type="text" name="cancel_reason" class="form-control" placeholder="If cancelling" value="<?php echo e($order->cancel_reason); ?>">
                    </div>
                    <div class="col-12 mt-2">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Update Status</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
    <div class="col-lg-4">
        
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white py-3">
                <h6 class="fw-bold mb-0"><i class="fas fa-user me-2 text-primary"></i>Customer</h6>
            </div>
            <div class="card-body">
                <?php $addr = $order->shipping_address ?>
                <?php if($addr): ?>
                    <p class="mb-1"><strong><?php echo e($addr['name'] ?? '—'); ?></strong></p>
                    <p class="mb-1 small"><?php echo e($addr['email'] ?? ''); ?></p>
                    <p class="mb-1 small"><?php echo e($addr['phone'] ?? ''); ?></p>
                <?php endif; ?>
                <?php if($order->user): ?>
                    <hr class="my-2">
                    <small class="text-muted">Account: <?php echo e($order->user->name); ?> (<?php echo e($order->user->email); ?>)</small>
                <?php else: ?>
                    <hr class="my-2">
                    <small class="text-muted">Guest checkout</small>
                <?php endif; ?>
            </div>
        </div>

        
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white py-3">
                <h6 class="fw-bold mb-0"><i class="fas fa-map-marker-alt me-2 text-primary"></i>Shipping</h6>
            </div>
            <div class="card-body">
                <?php $addr = $order->shipping_address ?>
                <?php if($addr && ($addr['address_line1'] ?? false)): ?>
                    <p class="mb-1"><?php echo e($addr['address_line1']); ?></p>
                    <?php if($addr['address_line2'] ?? false): ?><p class="mb-1"><?php echo e($addr['address_line2']); ?></p><?php endif; ?>
                    <p class="mb-1"><?php echo e(($addr['city'] ?? '')); ?><?php echo e(($addr['state'] ?? '') ? ', ' . $addr['state'] : ''); ?> <?php echo e($addr['zip'] ?? ''); ?></p>
                    <p class="mb-0"><?php echo e($addr['country'] ?? ''); ?></p>
                <?php else: ?>
                    <p class="text-muted small mb-0">No shipping address provided</p>
                <?php endif; ?>
                <hr class="my-2">
                <small class="text-muted d-block">Method: <?php echo e(ucfirst($order->shipping_method ?? 'Standard')); ?></small>
                <small class="text-muted d-block">Cost: <?php echo e(config('ecommerce.currency_symbol', '$')); ?><?php echo e(number_format($order->shipping_cost, 2)); ?></small>
                <?php if($order->hasTracking()): ?>
                    <hr class="my-2">
                    <small class="text-muted d-block">Carrier: <?php echo e($order->carrier ?? '—'); ?></small>
                    <small class="text-muted d-block">
                        Tracking:
                        <?php if($order->tracking_url): ?>
                            <a href="<?php echo e($order->tracking_url); ?>" target="_blank"><?php echo e($order->tracking_number); ?></a>
                        <?php else: ?>
                            <?php echo e($order->tracking_number); ?>

                        <?php endif; ?>
                    </small>
                <?php endif; ?>
                <?php if($order->estimated_delivery): ?>
                    <hr class="my-2">
                    <small class="text-muted d-block">Est. Delivery: <?php echo e($order->estimated_delivery->format('M d, Y')); ?></small>
                <?php endif; ?>
            </div>
        </div>

        
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white py-3">
                <h6 class="fw-bold mb-0"><i class="fas fa-file-invoice me-2 text-primary"></i>Billing</h6>
            </div>
            <div class="card-body">
                <?php $billing = $order->billing_address ?>
                <?php if($billing && ($billing['address_line1'] ?? false)): ?>
                    <p class="mb-1"><?php echo e($billing['address_line1']); ?></p>
                    <?php if($billing['address_line2'] ?? false): ?><p class="mb-1"><?php echo e($billing['address_line2']); ?></p><?php endif; ?>
                    <p class="mb-1"><?php echo e(($billing['city'] ?? '')); ?><?php echo e(($billing['state'] ?? '') ? ', ' . $billing['state'] : ''); ?> <?php echo e($billing['zip'] ?? ''); ?></p>
                    <p class="mb-0"><?php echo e($billing['country'] ?? ''); ?></p>
                <?php else: ?>
                    <p class="text-muted small mb-0">Same as shipping</p>
                <?php endif; ?>
            </div>
        </div>

        
        <?php if($order->notes): ?>
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white py-3">
                <h6 class="fw-bold mb-0"><i class="fas fa-sticky-note me-2 text-primary"></i>Notes</h6>
            </div>
            <div class="card-body">
                <p class="small mb-0"><?php echo e($order->notes); ?></p>
            </div>
        </div>
        <?php endif; ?>

        
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h6 class="fw-bold mb-0"><i class="fas fa-clock me-2 text-primary"></i>Timeline</h6>
            </div>
            <div class="card-body p-0">
                <div class="timeline-vertical p-3">
                    <?php $__empty_1 = true; $__currentLoopData = $timeline; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="timeline-item d-flex gap-3 mb-3">
                            <div class="timeline-icon flex-shrink-0">
                                <div class="rounded-circle d-flex align-items-center justify-content-center"
                                     style="width: 32px; height: 32px; background: var(--primary-light, rgba(37,99,235,0.1));">
                                    <i class="<?php echo e($event['icon']); ?> text-primary" style="font-size: 14px;"></i>
                                </div>
                            </div>
                            <div class="timeline-content">
                                <p class="mb-0 small fw-semibold"><?php echo e($event['label']); ?></p>
                                <small class="text-muted"><?php echo e($event['timestamp']->format('M d, Y h:i A')); ?></small>
                                <?php if(isset($event['properties']) && is_array($event['properties'])): ?>
                                    <?php $__currentLoopData = $event['properties']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(!in_array($key, ['status'])): ?>
                                            <br><small class="text-muted"><?php echo e(ucfirst($key)); ?>: <?php echo e($value); ?></small>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php if(!$loop->last): ?>
                            <div class="timeline-line ms-4 ps-3" style="border-left: 2px dashed var(--gray-200, #E2E8F0); height: 10px; margin-top: -8px; margin-bottom: 8px;"></div>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-muted small mb-0 text-center py-2">No timeline events.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('styles'); ?>
<style>
.timeline-item:last-child .timeline-line { display: none; }
</style>
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
<?php /**PATH C:\laragon\www\ecommerce\resources\views\admin\orders\show.blade.php ENDPATH**/ ?>