<?php if (isset($component)) { $__componentOriginaledc75c655a063d12a477f2c8d8f324fc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc = $attributes; } ?>
<?php $component = App\View\Components\Layouts\AdminLayout::resolve(['title' => 'Purchase Order '.e($purchase->po_number).''] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1"><?php echo e($purchase->po_number); ?></h4>
            <p class="text-muted small mb-0">
                <span class="badge bg-<?php echo e($purchase->status->color()); ?>"><?php echo e($purchase->status->label()); ?></span>
                <span class="badge bg-<?php echo e($purchase->payment_status->color()); ?> ms-1"><?php echo e($purchase->payment_status->label()); ?></span>
            </p>
        </div>
        <div class="d-flex gap-2">
            <?php if($purchase->isApprovable()): ?>
                <form method="POST" action="<?php echo e(route('admin.purchases.approve', $purchase->id)); ?>" class="d-inline">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn btn-success"><i class="fas fa-check-circle me-1"></i> Approve</button>
                </form>
                <form method="POST" action="<?php echo e(route('admin.purchases.reject', $purchase->id)); ?>" class="d-inline">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Reject this purchase order?')"><i class="fas fa-times-circle me-1"></i> Reject</button>
                </form>
            <?php endif; ?>
            <?php if($purchase->status->value === 'approved'): ?>
                <form method="POST" action="<?php echo e(route('admin.purchases.mark-ordered', $purchase->id)); ?>" class="d-inline">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-truck me-1"></i> Mark Ordered</button>
                </form>
            <?php endif; ?>
            <?php if($purchase->isCancellable() && !$purchase->isApprovable()): ?>
                <form method="POST" action="<?php echo e(route('admin.purchases.cancel', $purchase->id)); ?>" class="d-inline">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Cancel this purchase order?')"><i class="fas fa-ban me-1"></i> Cancel</button>
                </form>
            <?php endif; ?>
            <?php if($purchase->isEditable()): ?>
                <a href="<?php echo e(route('admin.purchases.edit', $purchase->id)); ?>" class="btn btn-outline-primary"><i class="fas fa-edit me-1"></i> Edit</a>
            <?php endif; ?>
            <a href="<?php echo e(route('admin.purchases.clone', $purchase->id)); ?>" class="btn btn-outline-secondary"><i class="fas fa-copy me-1"></i> Clone</a>
            <a href="<?php echo e(route('admin.purchases.print', $purchase->id)); ?>" target="_blank" class="btn btn-outline-info"><i class="fas fa-print me-1"></i> Print</a>
            <a href="<?php echo e(route('admin.purchases.index')); ?>" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i> Back</a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header bg-transparent">
                    <ul class="nav nav-tabs card-header-tabs" role="tablist">
                        <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#items"><i class="fas fa-list me-1"></i> Items</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#receipts"><i class="fas fa-truck-loading me-1"></i> Goods Receipts</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#payments"><i class="fas fa-money-bill me-1"></i> Payments</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#returns"><i class="fas fa-undo me-1"></i> Returns</a></li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        
                        <div class="tab-pane fade show active" id="items">
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Product</th>
                                            <th>SKU</th>
                                            <th class="text-end">Qty</th>
                                            <th class="text-end">Received</th>
                                            <th class="text-end">Price</th>
                                            <th class="text-end">Discount</th>
                                            <th class="text-end">Tax</th>
                                            <th class="text-end">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $purchase->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($loop->iteration); ?></td>
                                                <td>
                                                    <div class="fw-semibold"><?php echo e($item->product_name); ?></div>
                                                    <?php if($item->variant): ?><small class="text-muted"><?php echo e($item->variant->name); ?></small><?php endif; ?>
                                                </td>
                                                <td><?php echo e($item->sku ?: '—'); ?></td>
                                                <td class="text-end"><?php echo e($item->quantity); ?></td>
                                                <td class="text-end"><?php echo e($item->received_quantity); ?></td>
                                                <td class="text-end"><?php echo e(number_format($item->unit_price, 2)); ?></td>
                                                <td class="text-end"><?php echo e($item->discount > 0 ? number_format($item->discount, 2) : '—'); ?></td>
                                                <td class="text-end"><?php echo e($item->tax > 0 ? number_format($item->tax, 2) : '—'); ?></td>
                                                <td class="text-end fw-semibold"><?php echo e(number_format($item->total, 2)); ?></td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                    <tfoot>
                                        <tr><td colspan="8" class="text-end fw-bold">Subtotal:</td><td class="text-end"><?php echo e(number_format($purchase->subtotal, 2)); ?></td></tr>
                                        <?php if($purchase->discount_amount > 0): ?><tr><td colspan="8" class="text-end fw-bold text-danger">Discount:</td><td class="text-end text-danger">-<?php echo e(number_format($purchase->discount_amount, 2)); ?></td></tr><?php endif; ?>
                                        <?php if($purchase->tax_amount > 0): ?><tr><td colspan="8" class="text-end fw-bold">Tax:</td><td class="text-end"><?php echo e(number_format($purchase->tax_amount, 2)); ?></td></tr><?php endif; ?>
                                        <?php if($purchase->shipping_cost > 0): ?><tr><td colspan="8" class="text-end fw-bold">Shipping:</td><td class="text-end"><?php echo e(number_format($purchase->shipping_cost, 2)); ?></td></tr><?php endif; ?>
                                        <tr class="table-active"><td colspan="8" class="text-end fw-bold fs-5">Grand Total:</td><td class="text-end fs-5 fw-bold"><?php echo e(number_format($purchase->total_amount, 2)); ?></td></tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        
                        <div class="tab-pane fade" id="receipts">
                            <?php if($purchase->isReceivable()): ?>
                                <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#goodsReceiptModal">
                                    <i class="fas fa-truck-loading me-1"></i> Receive Goods
                                </button>
                            <?php endif; ?>

                            <?php $__empty_1 = true; $__currentLoopData = $purchase->goodsReceipts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $receipt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="card mb-3 border">
                                    <div class="card-header bg-transparent d-flex justify-content-between">
                                        <span class="fw-semibold">GRN: <?php echo e($receipt->grn_number); ?></span>
                                        <span class="badge bg-<?php echo e($receipt->receipt_type === 'full' ? 'success' : ($receipt->receipt_type === 'remaining' ? 'info' : 'warning')); ?>">
                                            <?php echo e(ucfirst($receipt->receipt_type)); ?>

                                        </span>
                                    </div>
                                    <div class="card-body py-2">
                                        <small class="text-muted">Received by <?php echo e($receipt->receiver?->name); ?> on <?php echo e($receipt->received_at?->format('d/m/Y h:i A')); ?></small>
                                        <?php if($receipt->notes): ?><p class="small mb-2 mt-1"><?php echo e($receipt->notes); ?></p><?php endif; ?>
                                        <table class="table table-sm mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Product</th>
                                                    <th class="text-end">Qty</th>
                                                    <th class="text-end">Price</th>
                                                    <th class="text-end">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $__currentLoopData = $receipt->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ri): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td><?php echo e($ri->product?->name); ?></td>
                                                        <td class="text-end"><?php echo e($ri->quantity); ?></td>
                                                        <td class="text-end"><?php echo e(number_format($ri->unit_price, 2)); ?></td>
                                                        <td class="text-end"><?php echo e(number_format($ri->subtotal, 2)); ?></td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <p class="text-muted text-center py-4">No goods receipts yet.</p>
                            <?php endif; ?>
                        </div>

                        
                        <div class="tab-pane fade" id="payments">
                            <?php if(!in_array($purchase->status->value, ['draft', 'cancelled', 'returned'])): ?>
                                <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#paymentModal">
                                    <i class="fas fa-plus-circle me-1"></i> Add Payment
                                </button>
                            <?php endif; ?>

                            <div class="mb-3">
                                <div class="row g-2">
                                    <div class="col-md-4">
                                        <div class="card bg-light">
                                            <div class="card-body text-center py-2">
                                                <small class="text-muted">Total Amount</small>
                                                <h5 class="mb-0"><?php echo e(number_format($purchase->total_amount, 2)); ?></h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card bg-success-subtle">
                                            <div class="card-body text-center py-2">
                                                <small class="text-muted">Paid</small>
                                                <h5 class="mb-0 text-success"><?php echo e(number_format($purchase->paid_amount, 2)); ?></h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card bg-danger-subtle">
                                            <div class="card-body text-center py-2">
                                                <small class="text-muted">Due</small>
                                                <h5 class="mb-0 text-danger"><?php echo e(number_format($purchase->due_amount, 2)); ?></h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php if($purchase->payments->isNotEmpty()): ?>
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Method</th>
                                                <th>Reference</th>
                                                <th class="text-end">Amount</th>
                                                <th>Notes</th>
                                                <th>By</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $purchase->payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($payment->payment_date?->format('d/m/Y')); ?></td>
                                                    <td><span class="badge bg-info"><?php echo e(ucwords(str_replace('_', ' ', $payment->payment_method))); ?></span></td>
                                                    <td><small><?php echo e($payment->reference_number ?: '—'); ?></small></td>
                                                    <td class="text-end fw-semibold text-success"><?php echo e(number_format($payment->amount, 2)); ?></td>
                                                    <td><small><?php echo e($payment->notes ?: '—'); ?></small></td>
                                                    <td><small><?php echo e($payment->creator?->name); ?></small></td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                        <tfoot>
                                            <tr class="fw-bold">
                                                <td colspan="3" class="text-end">Total Paid:</td>
                                                <td class="text-end text-success"><?php echo e(number_format($purchase->payments->sum('amount'), 2)); ?></td>
                                                <td colspan="2"></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            <?php else: ?>
                                <p class="text-muted text-center py-4">No payments recorded yet.</p>
                            <?php endif; ?>
                        </div>

                        
                        <div class="tab-pane fade" id="returns">
                            <?php if(in_array($purchase->status->value, ['completed', 'partially_received'])): ?>
                                <button type="button" class="btn btn-warning mb-3" data-bs-toggle="modal" data-bs-target="#returnModal">
                                    <i class="fas fa-undo me-1"></i> Return Items
                                </button>
                            <?php endif; ?>

                            <?php $__empty_1 = true; $__currentLoopData = $purchase->returns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $return): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="card mb-2 border">
                                    <div class="card-body py-2 d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="fw-semibold"><?php echo e($return->product?->name); ?></span>
                                            <?php if($return->variant): ?><br><small class="text-muted"><?php echo e($return->variant->name); ?></small><?php endif; ?>
                                            <br><small class="text-muted"><?php echo e($return->return_number); ?> | <?php echo e($return->return_date?->format('d/m/Y')); ?></small>
                                        </div>
                                        <div class="text-end">
                                            <div class="fw-semibold"><?php echo e($return->quantity); ?> x <?php echo e(number_format($return->unit_price, 2)); ?></div>
                                            <small>Total: <?php echo e(number_format($return->total_amount, 2)); ?></small>
                                            <br><span class="badge bg-<?php echo e($return->refund_status === 'processed' ? 'success' : ($return->refund_status === 'declined' ? 'danger' : 'warning')); ?>"><?php echo e(ucfirst($return->refund_status)); ?></span>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <p class="text-muted text-center py-4">No returns recorded.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Purchase Details</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted small text-uppercase">Supplier</label>
                        <p class="fw-semibold mb-0"><?php echo e($purchase->supplier?->name); ?></p>
                        <small class="text-muted"><?php echo e($purchase->supplier?->supplier_code); ?></small>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small text-uppercase">Warehouse</label>
                        <p class="fw-semibold mb-0"><?php echo e($purchase->warehouse?->name); ?></p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small text-uppercase">Purchase Date</label>
                        <p class="fw-semibold mb-0"><?php echo e($purchase->purchase_date?->format('d M, Y')); ?></p>
                    </div>
                    <?php if($purchase->expected_delivery_date): ?>
                        <div class="mb-3">
                            <label class="text-muted small text-uppercase">Expected Delivery</label>
                            <p class="fw-semibold mb-0"><?php echo e($purchase->expected_delivery_date?->format('d M, Y')); ?></p>
                        </div>
                    <?php endif; ?>
                    <?php if($purchase->reference_number): ?>
                        <div class="mb-3">
                            <label class="text-muted small text-uppercase">Reference</label>
                            <p class="fw-semibold mb-0"><?php echo e($purchase->reference_number); ?></p>
                        </div>
                    <?php endif; ?>
                    <div class="mb-3">
                        <label class="text-muted small text-uppercase">Currency</label>
                        <p class="fw-semibold mb-0"><?php echo e($purchase->currency); ?> <?php if($purchase->exchange_rate != 1): ?>(Rate: <?php echo e($purchase->exchange_rate); ?>)<?php endif; ?></p>
                    </div>
                </div>
            </div>

            <?php if($purchase->notes): ?>
                <div class="card mb-4">
                    <div class="card-header bg-transparent">
                        <h6 class="fw-bold mb-0">Notes</h6>
                    </div>
                    <div class="card-body">
                        <p class="small mb-0"><?php echo e($purchase->notes); ?></p>
                    </div>
                </div>
            <?php endif; ?>

            <?php if($purchase->terms): ?>
                <div class="card mb-4">
                    <div class="card-header bg-transparent">
                        <h6 class="fw-bold mb-0">Terms</h6>
                    </div>
                    <div class="card-body">
                        <p class="small mb-0"><?php echo e($purchase->terms); ?></p>
                    </div>
                </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Timeline</h6>
                </div>
                <div class="card-body">
                    <ul class="timeline list-unstyled mb-0">
                        <li class="mb-2">
                            <small class="text-muted">Created</small>
                            <p class="mb-0 small"><?php echo e($purchase->created_at?->format('d M Y, h:i A')); ?> by <?php echo e($purchase->creator?->name ?? 'N/A'); ?></p>
                        </li>
                        <?php if($purchase->approved_at): ?>
                            <li class="mb-2">
                                <small class="text-muted">Approved</small>
                                <p class="mb-0 small"><?php echo e($purchase->approved_at?->format('d M Y, h:i A')); ?> by <?php echo e($purchase->approver?->name ?? 'N/A'); ?></p>
                            </li>
                        <?php endif; ?>
                        <?php if($purchase->ordered_at): ?>
                            <li class="mb-2">
                                <small class="text-muted">Ordered</small>
                                <p class="mb-0 small"><?php echo e($purchase->ordered_at?->format('d M Y, h:i A')); ?></p>
                            </li>
                        <?php endif; ?>
                        <?php if($purchase->completed_at): ?>
                            <li class="mb-2">
                                <small class="text-muted">Completed</small>
                                <p class="mb-0 small"><?php echo e($purchase->completed_at?->format('d M Y, h:i A')); ?></p>
                            </li>
                        <?php endif; ?>
                        <?php if($purchase->cancelled_at): ?>
                            <li class="mb-2">
                                <small class="text-muted">Cancelled</small>
                                <p class="mb-0 small"><?php echo e($purchase->cancelled_at?->format('d M Y, h:i A')); ?></p>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="goodsReceiptModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" action="<?php echo e(route('admin.purchases.receive', $purchase->id)); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="modal-header">
                        <h5 class="modal-title">Receive Goods</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Receipt Type <span class="text-danger">*</span></label>
                            <select name="receipt_type" class="form-select" id="receiptType" onchange="toggleReceiptItems()">
                                <option value="full">Full Receipt</option>
                                <option value="partial">Partial Receipt</option>
                                <option value="remaining">Receive Remaining</option>
                            </select>
                        </div>
                        <div id="partialItemsSection" class="d-none">
                            <label class="form-label">Quantities to receive</label>
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Ordered</th>
                                        <th>Received</th>
                                        <th>Pending</th>
                                        <th>Receive</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $purchase->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($item->product_name); ?></td>
                                            <td><?php echo e($item->quantity); ?></td>
                                            <td><?php echo e($item->received_quantity); ?></td>
                                            <td><?php echo e($item->pending_quantity); ?></td>
                                            <td>
                                                <input type="number" name="items[<?php echo e($item->id); ?>]" class="form-control form-control-sm"
                                                       value="<?php echo e($item->pending_quantity); ?>" min="0" max="<?php echo e($item->pending_quantity); ?>" step="any"
                                                       data-pending="<?php echo e($item->pending_quantity); ?>">
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Notes</label>
                            <textarea name="notes" class="form-control" rows="2" placeholder="Optional notes about receipt"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success"><i class="fas fa-check me-1"></i> Receive Goods</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="paymentModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="<?php echo e(route('admin.purchases.payment', $purchase->id)); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="modal-header">
                        <h5 class="modal-title">Add Payment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Amount <span class="text-danger">*</span></label>
                            <input type="number" name="amount" class="form-control" step="0.01" min="0.01" max="<?php echo e($purchase->due_amount); ?>" required>
                            <small class="text-muted">Due amount: <?php echo e(number_format($purchase->due_amount, 2)); ?></small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Payment Method <span class="text-danger">*</span></label>
                            <select name="payment_method" class="form-select" required>
                                <option value="cash">Cash</option>
                                <option value="bank">Bank Transfer</option>
                                <option value="mobile_banking">Mobile Banking</option>
                                <option value="credit">Credit</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Reference Number</label>
                            <input type="text" name="reference_number" class="form-control" placeholder="Cheque / Transaction ID">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Payment Date</label>
                            <input type="date" name="payment_date" class="form-control" value="<?php echo e(date('Y-m-d')); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Notes</label>
                            <textarea name="notes" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success"><i class="fas fa-check me-1"></i> Add Payment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="returnModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" action="<?php echo e(route('admin.purchases.return', $purchase->id)); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="modal-header">
                        <h5 class="modal-title">Return Items</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Received</th>
                                    <th>Returned</th>
                                    <th>Returnable</th>
                                    <th>Qty to Return</th>
                                    <th>Reason</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $purchase->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php $returnable = $item->received_quantity - $item->returned_quantity; ?>
                                    <?php if($returnable > 0): ?>
                                        <tr>
                                            <td><?php echo e($item->product_name); ?></td>
                                            <td><?php echo e($item->received_quantity); ?></td>
                                            <td><?php echo e($item->returned_quantity); ?></td>
                                            <td><?php echo e($returnable); ?></td>
                                            <td>
                                                <input type="hidden" name="items[<?php echo e($loop->index); ?>][purchase_item_id]" value="<?php echo e($item->id); ?>">
                                                <input type="number" name="items[<?php echo e($loop->index); ?>][quantity]" class="form-control form-control-sm" min="0" max="<?php echo e($returnable); ?>" step="any" value="0">
                                            </td>
                                            <td>
                                                <select name="items[<?php echo e($loop->index); ?>][reason]" class="form-select form-select-sm">
                                                    <option value="Damaged">Damaged</option>
                                                    <option value="Defective">Defective</option>
                                                    <option value="Wrong Item">Wrong Item</option>
                                                    <option value="Quality Issue">Quality Issue</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-warning"><i class="fas fa-undo me-1"></i> Return Items</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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

<?php $__env->startPush('scripts'); ?>
<script>
function toggleReceiptItems() {
    const type = document.getElementById('receiptType').value;
    document.getElementById('partialItemsSection').classList.toggle('d-none', type !== 'partial');
}
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\admin\purchases\show.blade.php ENDPATH**/ ?>