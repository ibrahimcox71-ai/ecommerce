<?php if (isset($component)) { $__componentOriginaledc75c655a063d12a477f2c8d8f324fc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc = $attributes; } ?>
<?php $component = App\View\Components\Layouts\AdminLayout::resolve(['title' => 'Orders'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Orders</h4>
        <p class="text-muted small mb-0">Manage all customer orders</p>
    </div>
    <div class="d-flex gap-2">
        <div class="dropdown">
            <button class="btn btn-outline-success dropdown-toggle" data-bs-toggle="dropdown">
                <i class="fas fa-download me-1"></i> Export
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="<?php echo e(route('admin.orders.export.csv', request()->query())); ?>"><i class="fas fa-file-csv me-2 text-success"></i>CSV</a></li>
                <li><a class="dropdown-item" href="<?php echo e(route('admin.orders.export.excel', request()->query())); ?>"><i class="fas fa-file-excel me-2 text-primary"></i>Excel</a></li>
            </ul>
        </div>
        <a href="<?php echo e(route('admin.orders.reports.index')); ?>" class="btn btn-outline-info">
            <i class="fas fa-chart-bar me-1"></i> Reports
        </a>
        <a href="<?php echo e(route('admin.orders.create')); ?>" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Create Order
        </a>
    </div>
</div>

<div class="row g-2 mb-4">
    <div class="col-6 col-md">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-2">
                <small class="text-muted">Total</small>
                <h6 class="fw-bold mb-0"><?php echo e($statusCounts['all']); ?></h6>
            </div>
        </div>
    </div>
    <div class="col-6 col-md">
        <div class="card border-0 shadow-sm bg-warning bg-opacity-10">
            <div class="card-body text-center py-2">
                <small class="text-muted">Pending</small>
                <h6 class="fw-bold mb-0 text-warning"><?php echo e($statusCounts['pending']); ?></h6>
            </div>
        </div>
    </div>
    <div class="col-6 col-md">
        <div class="card border-0 shadow-sm bg-primary bg-opacity-10">
            <div class="card-body text-center py-2">
                <small class="text-muted">Processing</small>
                <h6 class="fw-bold mb-0 text-primary"><?php echo e($statusCounts['processing']); ?></h6>
            </div>
        </div>
    </div>
    <div class="col-6 col-md">
        <div class="card border-0 shadow-sm bg-dark bg-opacity-10">
            <div class="card-body text-center py-2">
                <small class="text-muted">Shipped</small>
                <h6 class="fw-bold mb-0"><?php echo e($statusCounts['shipping'] + $statusCounts['ready_to_ship'] + $statusCounts['out_for_delivery']); ?></h6>
            </div>
        </div>
    </div>
    <div class="col-6 col-md">
        <div class="card border-0 shadow-sm bg-success bg-opacity-10">
            <div class="card-body text-center py-2">
                <small class="text-muted">Delivered</small>
                <h6 class="fw-bold mb-0 text-success"><?php echo e($statusCounts['delivered'] + $statusCounts['completed']); ?></h6>
            </div>
        </div>
    </div>
    <div class="col-6 col-md">
        <div class="card border-0 shadow-sm bg-danger bg-opacity-10">
            <div class="card-body text-center py-2">
                <small class="text-muted">Cancelled</small>
                <h6 class="fw-bold mb-0 text-danger"><?php echo e($statusCounts['cancelled']); ?></h6>
            </div>
        </div>
    </div>
</div>


<ul class="nav nav-tabs mb-4">
    <li class="nav-item">
        <a class="nav-link <?php echo e(!request('status') && !request('payment_status') ? 'active' : ''); ?>"
           href="<?php echo e(route('admin.orders.index')); ?>">
            All <span class="badge bg-secondary ms-1"><?php echo e($statusCounts['all']); ?></span>
        </a>
    </li>
    <?php
        $statusTabs = [
            'pending' => ['bg-warning text-dark', $statusCounts['pending']],
            'confirmed' => ['bg-info', $statusCounts['confirmed']],
            'processing' => ['bg-primary', $statusCounts['processing']],
            'packing' => ['bg-secondary', $statusCounts['packing']],
            'ready_to_ship' => ['bg-dark', $statusCounts['ready_to_ship']],
            'shipping' => ['bg-dark', $statusCounts['shipping']],
            'out_for_delivery' => ['bg-info', $statusCounts['out_for_delivery']],
            'delivered' => ['bg-success', $statusCounts['delivered']],
            'completed' => ['bg-success', $statusCounts['completed']],
            'cancelled' => ['bg-danger', $statusCounts['cancelled']],
            'returned' => ['bg-warning text-dark', $statusCounts['returned']],
            'refunded' => ['bg-secondary', $statusCounts['refunded']],
        ];
    ?>
    <?php $__currentLoopData = $statusTabs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => [$badgeClass, $count]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($count > 0): ?>
        <li class="nav-item">
            <a class="nav-link <?php echo e(request('status') === $key ? 'active' : ''); ?>"
               href="<?php echo e(route('admin.orders.index', array_merge(request()->except('status'), ['status' => $key]))); ?>">
                <?php echo e(ucwords(str_replace('_', ' ', $key))); ?>

                <span class="badge <?php echo e($badgeClass); ?> ms-1"><?php echo e($count); ?></span>
            </a>
        </li>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form method="GET" class="row g-2 mb-3">
            <div class="col-md-3">
                <input type="text" name="search" class="form-control" placeholder="Search order #, customer, phone..."
                       value="<?php echo e(request('search')); ?>">
            </div>
            <div class="col-md-2">
                <select name="payment_status" class="form-select">
                    <option value="">All Payments</option>
                    <option value="paid" <?php if(request('payment_status') === 'paid'): echo 'selected'; endif; ?>>Paid</option>
                    <option value="partial" <?php if(request('payment_status') === 'partial'): echo 'selected'; endif; ?>>Partial</option>
                    <option value="pending" <?php if(request('payment_status') === 'pending'): echo 'selected'; endif; ?>>Pending</option>
                    <option value="failed" <?php if(request('payment_status') === 'failed'): echo 'selected'; endif; ?>>Failed</option>
                    <option value="refunded" <?php if(request('payment_status') === 'refunded'): echo 'selected'; endif; ?>>Refunded</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="order_origin" class="form-select">
                    <option value="">All Origins</option>
                    <option value="website" <?php if(request('order_origin') === 'website'): echo 'selected'; endif; ?>>Website</option>
                    <option value="manual" <?php if(request('order_origin') === 'manual'): echo 'selected'; endif; ?>>Manual</option>
                    <option value="pos" <?php if(request('order_origin') === 'pos'): echo 'selected'; endif; ?>>POS</option>
                </select>
            </div>
            <div class="col-md-2">
                <input type="date" name="date_from" class="form-control" value="<?php echo e(request('date_from')); ?>" placeholder="From">
            </div>
            <div class="col-md-2">
                <input type="date" name="date_to" class="form-control" value="<?php echo e(request('date_to')); ?>" placeholder="To">
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i></button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Order #</th>
                        <th>Customer</th>
                        <th class="text-center">Items</th>
                        <th class="text-end">Total</th>
                        <th>Payment</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>
                                <a href="<?php echo e(route('admin.orders.show', $order)); ?>" class="fw-semibold text-decoration-none">
                                    <?php echo e($order->order_number); ?>

                                </a>
                                <?php if($order->order_origin !== 'website'): ?>
                                    <br><small class="badge bg-light text-muted"><?php echo e(ucfirst($order->order_origin)); ?></small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <?php $name = $order->shipping_address['name'] ?? ($order->user?->name ?? 'Guest'); ?>
                                    <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center fw-bold"
                                         style="width: 32px; height: 32px; font-size: 12px;">
                                        <?php echo e(strtoupper(substr($name, 0, 1))); ?>

                                    </div>
                                    <div>
                                        <span class="fw-semibold small"><?php echo e($name); ?></span>
                                        <?php if($order->user): ?>
                                            <br><small class="text-muted" style="font-size: 11px;"><?php echo e($order->user->email); ?></small>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center"><?php echo e($order->getItemCount()); ?></td>
                            <td class="text-end fw-semibold"><?php echo e(config('ecommerce.currency_symbol', '$')); ?><?php echo e(number_format($order->total, 2)); ?></td>
                            <td>
                                <span class="badge <?php echo e($order->paymentStatusBadge()); ?>"><?php echo e(ucfirst($order->payment_status)); ?></span>
                                <br><small class="text-muted"><?php echo e($order->payment?->methodLabel() ?? '—'); ?></small>
                            </td>
                            <td>
                                <?php $s = App\Enums\OrderStatus::tryFrom($order->status); ?>
                                <?php if($s): ?>
                                    <span class="badge <?php echo e($s->badgeClass()); ?>"><?php echo e($s->label()); ?></span>
                                <?php else: ?>
                                    <span class="badge bg-light text-dark"><?php echo e(ucfirst($order->status)); ?></span>
                                <?php endif; ?>
                            </td>
                            <td><small class="text-muted"><?php echo e($order->created_at->format('M d, Y')); ?></small></td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="<?php echo e(route('admin.orders.show', $order)); ?>"><i class="fas fa-eye me-2"></i>View</a></li>
                                        <?php if($order->isEditable()): ?>
                                            <li><a class="dropdown-item" href="<?php echo e(route('admin.orders.edit', $order)); ?>"><i class="fas fa-edit me-2"></i>Edit</a></li>
                                        <?php endif; ?>
                                        <li><a class="dropdown-item" href="<?php echo e(route('admin.orders.print', $order)); ?>" target="_blank"><i class="fas fa-print me-2"></i>Print</a></li>
                                        <li><a class="dropdown-item" href="<?php echo e(route('admin.orders.invoice', $order)); ?>" target="_blank"><i class="fas fa-file-invoice me-2"></i>Invoice</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form method="POST" action="<?php echo e(route('admin.orders.duplicate', $order)); ?>" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="dropdown-item"><i class="fas fa-copy me-2"></i>Duplicate</button>
                                            </form>
                                        </li>
                                        <?php if($order->isDeletable()): ?>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form method="POST" action="<?php echo e(route('admin.orders.destroy', $order)); ?>" class="d-inline">
                                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Delete this order?')"><i class="fas fa-trash me-2"></i>Delete</button>
                                                </form>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="fas fa-shopping-cart fa-3x mb-3 d-block"></i>
                                No orders found.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-3">
            <small class="text-muted">Showing <?php echo e($orders->firstItem() ?? 0); ?> to <?php echo e($orders->lastItem() ?? 0); ?> of <?php echo e($orders->total()); ?> entries</small>
            <div class="d-flex gap-2">
                <a href="<?php echo e(route('admin.orders.export.csv', request()->query())); ?>" class="btn btn-sm btn-outline-success">
                    <i class="fas fa-file-csv me-1"></i> CSV
                </a>
                <a href="<?php echo e(route('admin.orders.export.excel', request()->query())); ?>" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-file-excel me-1"></i> Excel
                </a>
            </div>
        </div>

        <div class="d-flex justify-content-center mt-3">
            <?php echo e($orders->withQueryString()->links()); ?>

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
<?php /**PATH C:\laragon\www\ecommerce\resources\views\admin\orders\index.blade.php ENDPATH**/ ?>