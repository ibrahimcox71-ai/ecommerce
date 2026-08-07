<?php if (isset($component)) { $__componentOriginaledc75c655a063d12a477f2c8d8f324fc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc = $attributes; } ?>
<?php $component = App\View\Components\Layouts\AdminLayout::resolve(['title' => 'Dashboard'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

    <div class="dashboard-welcome">
        <div class="welcome-header">
            <div>
                <h1 class="welcome-title">Welcome back, <span><?php echo e(auth()->guard('admin')->user()?->name ?? 'Super Admin'); ?></span></h1>
                <p class="welcome-subtitle">Here's your business performance overview for today.</p>
            </div>
            <div class="d-flex align-items-center gap-3 flex-shrink-0">
                <span class="welcome-date">
                    <i class="bi bi-calendar3"></i>
                    <?php echo e(now()->format('F d, Y')); ?>

                </span>
            </div>
        </div>
        <div class="quick-actions">
            <a href="<?php echo e(route('admin.products.create')); ?>" class="quick-action-btn quick-action-primary">
                <i class="bi bi-plus-lg"></i> Product
            </a>
            <a href="<?php echo e(route('admin.orders.index')); ?>" class="quick-action-btn quick-action-secondary">
                <i class="bi bi-plus-lg"></i> Order
            </a>
            <a href="<?php echo e(route('admin.customers.index')); ?>" class="quick-action-btn quick-action-secondary">
                <i class="bi bi-plus-lg"></i> Customer
            </a>
            <a href="<?php echo e(route('admin.coupons.create')); ?>" class="quick-action-btn quick-action-secondary">
                <i class="bi bi-plus-lg"></i> Coupon
            </a>
            <button class="quick-action-btn quick-action-secondary" onclick="alert('Export feature coming soon')">
                <i class="bi bi-download"></i> Export
            </button>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6 animate-fade-in animate-fade-in-5">
            <div class="stat-card-premium stat-border-purple">
                <div class="card-body">
                    <div class="stat-top">
                        <div class="stat-info">
                            <div class="stat-label">Total Revenue</div>
                            <div class="stat-value" id="kpiTotalRevenue">$0</div>
                        </div>
                        <div class="stat-icon-wrap bg-icon-purple">
                            <i class="bi bi-graph-up-arrow"></i>
                        </div>
                    </div>
                    <div class="stat-bottom">
                        <span class="stat-trend" id="kpiRevenueTrend"></span>
                        <span class="stat-compare">vs last month</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 animate-fade-in animate-fade-in-6">
            <div class="stat-card-premium stat-border-success">
                <div class="card-body">
                    <div class="stat-top">
                        <div class="stat-info">
                            <div class="stat-label">Total Profit</div>
                            <div class="stat-value" id="kpiTotalProfit">$0</div>
                        </div>
                        <div class="stat-icon-wrap bg-icon-success">
                            <i class="bi bi-piggy-bank"></i>
                        </div>
                    </div>
                    <div class="stat-bottom">
                        <span class="stat-trend" id="kpiProfitTrend"></span>
                        <span class="stat-compare">vs last month</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 animate-fade-in animate-fade-in-7">
            <div class="stat-card-premium stat-border-warning">
                <div class="card-body">
                    <div class="stat-top">
                        <div class="stat-info">
                            <div class="stat-label">Pending Orders</div>
                            <div class="stat-value" id="kpiPendingOrders">0</div>
                        </div>
                        <div class="stat-icon-wrap bg-icon-warning">
                            <i class="bi bi-clock-history"></i>
                        </div>
                    </div>
                    <div class="stat-bottom">
                        <span class="stat-trend" id="kpiPendingTrend"></span>
                        <span class="stat-compare">vs last week</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 animate-fade-in animate-fade-in-8">
            <div class="stat-card-premium stat-border-pink">
                <div class="card-body">
                    <div class="stat-top">
                        <div class="stat-info">
                            <div class="stat-label">Conversion Rate</div>
                            <div class="stat-value" id="kpiConversionRate">0%</div>
                        </div>
                        <div class="stat-icon-wrap bg-icon-pink">
                            <i class="bi bi-percent"></i>
                        </div>
                    </div>
                    <div class="stat-bottom">
                        <span class="stat-trend" id="kpiConversionTrend"></span>
                        <span class="stat-compare">vs last month</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="dashboard-card">
                <div class="dashboard-card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <div>
                        <div class="section-title">Revenue Overview</div>
                        <div class="section-subtitle">Revenue and orders performance over time</div>
                    </div>
                    <div class="chart-period-group btn-group btn-group-sm" role="group">
                        <button type="button" class="btn active" data-period="week">7 Days</button>
                        <button type="button" class="btn" data-period="month">30 Days</button>
                        <button type="button" class="btn" data-period="year">This Year</button>
                    </div>
                </div>
                <div class="dashboard-card-body">
                    <div class="chart-container" style="min-height: 280px; position: relative;">
                        <canvas id="revenueChart" style="display: block; width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="dashboard-card">
                <div class="dashboard-card-header">
                    <div class="section-title">Order Status</div>
                    <div class="section-subtitle">Distribution by order status</div>
                </div>
                <div class="dashboard-card-body d-flex align-items-center justify-content-center">
                    <div id="orderStatusChart" style="width: 100%; min-height: 280px; position: relative;"></div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="row g-4 mb-4">
        <div class="col-xl-7">
            <div class="dashboard-card">
                <div class="dashboard-card-header">
                    <div class="section-title">Sales by Category</div>
                    <div class="section-subtitle">Revenue distribution across product categories</div>
                </div>
                <div class="dashboard-card-body">
                    <div class="chart-container-sm" style="min-height: 280px; position: relative;">
                        <div id="categoryChart"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-5">
            <div class="dashboard-card">
                <div class="dashboard-card-header">
                    <div class="section-title">Customer Growth</div>
                    <div class="section-subtitle">New customer registrations (monthly)</div>
                </div>
                <div class="dashboard-card-body">
                    <div class="chart-container-sm" style="min-height: 280px; position: relative;">
                        <div id="customerGrowthChart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="row g-4 mb-4">
        <div class="col-xl-6">
            <div class="dashboard-card">
                <div class="dashboard-card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <div>
                        <div class="section-title">Latest Orders</div>
                        <div class="section-subtitle">Recent purchase transactions</div>
                    </div>
                    <a href="<?php echo e(route('admin.orders.index')); ?>" class="quick-action-btn quick-action-secondary" style="padding: 4px 14px; font-size: 0.75rem;">
                        View All <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="dashboard-card-body p-0">
                    <div class="table-responsive">
                        <table class="dashboard-table table">
                            <thead>
                                <tr>
                                    <th style="padding-left: 24px;">Order ID</th>
                                    <th>Customer</th>
                                    <th>Status</th>
                                    <th style="text-align: right; padding-right: 24px;">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $latestOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td style="padding-left: 24px;">
                                        <span class="fw-semibold">#<?php echo e($order->order_number); ?></span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="table-avatar" style="background: linear-gradient(135deg, #2563EB, #7C3AED);">
                                                <?php echo e(strtoupper(substr($order->user->name ?? 'U', 0, 2))); ?>

                                            </div>
                                            <span><?php echo e($order->user->name ?? 'Guest'); ?></span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-premium <?php echo e($order->statusBadge()); ?>">
                                            <?php echo e(ucfirst($order->status)); ?>

                                        </span>
                                    </td>
                                    <td style="text-align: right; padding-right: 24px;" class="fw-semibold">$<?php echo e(number_format($order->total, 2)); ?></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">No recent orders found.</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="px-3 py-2 border-top border-light text-center">
                    <a href="<?php echo e(route('admin.orders.index')); ?>" class="text-decoration-none small fw-medium" style="color: var(--primary);">
                        View all orders <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="dashboard-card">
                <div class="dashboard-card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <div>
                        <div class="section-title">Latest Customers</div>
                        <div class="section-subtitle">Recently registered customers</div>
                    </div>
                    <a href="<?php echo e(route('admin.customers.index')); ?>" class="quick-action-btn quick-action-secondary" style="padding: 4px 14px; font-size: 0.75rem;">
                        View All <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="dashboard-card-body p-0">
                    <div class="table-responsive">
                        <table class="dashboard-table table">
                            <thead>
                                <tr>
                                    <th style="padding-left: 24px;">Customer</th>
                                    <th>Email</th>
                                    <th>Orders</th>
                                    <th style="text-align: right; padding-right: 24px;">Total Spent</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $latestCustomers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td style="padding-left: 24px;">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="table-avatar" style="background: linear-gradient(135deg, #10B981, #059669);">
                                                <?php echo e(strtoupper(substr($customer->name, 0, 2))); ?>

                                            </div>
                                            <div>
                                                <span class="fw-semibold d-block" style="font-size: 0.83rem;"><?php echo e($customer->name); ?></span>
                                                <small class="text-muted" style="font-size: 0.68rem;">Joined <?php echo e($customer->created_at->diffForHumans()); ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?php echo e($customer->email); ?></td>
                                    <td><span class="badge badge-premium bg-primary"><?php echo e($customer->orders_count); ?> orders</span></td>
                                    <td style="text-align: right; padding-right: 24px;" class="fw-semibold">$<?php echo e(number_format($customer->total_spend_sum, 2)); ?></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">No customers found.</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="px-3 py-2 border-top border-light text-center">
                    <a href="<?php echo e(route('admin.customers.index')); ?>" class="text-decoration-none small fw-medium" style="color: var(--primary);">
                        View all customers <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    
    <div class="row g-4">
        <div class="col-xl-4">
            <div class="dashboard-card">
                <div class="dashboard-card-header">
                    <div class="section-title">Recent Activity</div>
                    <div class="section-subtitle">Latest actions in your store</div>
                </div>
                <div class="dashboard-card-body py-2">
                    <div class="activity-timeline">
                        <?php $__empty_1 = true; $__currentLoopData = $recentActivity; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="activity-item">
                            <div class="activity-icon" style="background: var(--primary-light); color: var(--primary);">
                                <i class="bi bi-activity"></i>
                            </div>
                            <div class="activity-content">
                                <p><?php echo e($activity->description); ?></p>
                                <span class="activity-time"><?php echo e($activity->created_at->diffForHumans()); ?></span>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="text-center py-3 text-muted">No recent activity found.</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="dashboard-card">
                <div class="dashboard-card-header d-flex justify-content-between align-items-center">
                    <div>
                        <div class="section-title">Low Stock Alerts</div>
                        <div class="section-subtitle">Products needing restock</div>
                    </div>
                    <a href="<?php echo e(route('admin.inventories.low-stock')); ?>" class="quick-action-btn quick-action-secondary" style="padding: 3px 10px; font-size: 0.7rem;">
                        View All
                    </a>
                </div>
                <div class="dashboard-card-body py-1">
                    <?php $__empty_1 = true; $__currentLoopData = $lowStockAlerts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="low-stock-item">
                        <div class="low-stock-img">
                            <i class="bi bi-box"></i>
                        </div>
                        <div class="low-stock-info">
                            <div class="low-stock-name"><?php echo e($alert->product->name ?? 'Unknown Product'); ?></div>
                            <div class="low-stock-sku">SKU: <?php echo e($alert->product->sku ?? 'N/A'); ?></div>
                        </div>
                        <div class="low-stock-qty">
                            <div class="current"><?php echo e($alert->available_quantity); ?></div>
                            <div class="minimum">min: <?php echo e($alert->low_stock_threshold); ?></div>
                        </div>
                        <button class="btn-restock">Restock</button>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-center py-4 text-muted">No low stock alerts.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="dashboard-card">
                <div class="dashboard-card-header">
                    <div class="section-title">Recent Notifications</div>
                    <div class="section-subtitle">Latest store updates and alerts</div>
                </div>
                <div class="dashboard-card-body py-0">
                    <?php $__empty_1 = true; $__currentLoopData = $recentNotifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="notif-item">
                        <div class="notif-icon" style="background: var(--info-light); color: var(--info);">
                            <i class="bi bi-bell"></i>
                        </div>
                        <div class="notif-content">
                            <p><?php echo $notification->data['message'] ?? 'New notification'; ?></p>
                            <small><?php echo e($notification->created_at->diffForHumans()); ?></small>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-center py-4 text-muted">No new notifications.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <svg style="position: absolute; width: 0; height: 0;">
        <defs>
            <linearGradient id="sparkline-gradient-primary" x1="0" y1="0" x2="0" y2="1">
                <stop offset="0%" stop-color="var(--primary)" stop-opacity="1"/>
                <stop offset="100%" stop-color="var(--primary)" stop-opacity="0"/>
            </linearGradient>
            <linearGradient id="sparkline-gradient-success" x1="0" y1="0" x2="0" y2="1">
                <stop offset="0%" stop-color="var(--success)" stop-opacity="1"/>
                <stop offset="100%" stop-color="var(--success)" stop-opacity="0"/>
            </linearGradient>
            <linearGradient id="sparkline-gradient-secondary" x1="0" y1="0" x2="0" y2="1">
                <stop offset="0%" stop-color="var(--secondary)" stop-opacity="1"/>
                <stop offset="100%" stop-color="var(--secondary)" stop-opacity="0"/>
            </linearGradient>
            <linearGradient id="sparkline-gradient-info" x1="0" y1="0" x2="0" y2="1">
                <stop offset="0%" stop-color="var(--info)" stop-opacity="1"/>
                <stop offset="100%" stop-color="var(--info)" stop-opacity="0"/>
            </linearGradient>
        </defs>
    </svg>

    <div class="floating-action">
        <button class="floating-action-btn" type="button" data-bs-toggle="tooltip" data-bs-placement="left" title="Quick Actions">
            <i class="bi bi-plus-lg"></i>
        </button>
    </div>

    <?php $__env->startPush('scripts'); ?>
        <?php echo app('Illuminate\Foundation\Vite')('resources/js/admin-dashboard.js'); ?>
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
<?php /**PATH C:\laragon\www\ecommerce\resources\views\admin\dashboard.blade.php ENDPATH**/ ?>