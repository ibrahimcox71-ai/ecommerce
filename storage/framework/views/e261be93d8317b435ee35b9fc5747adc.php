<?php if (isset($component)) { $__componentOriginaledc75c655a063d12a477f2c8d8f324fc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc = $attributes; } ?>
<?php $component = App\View\Components\Layouts\AdminLayout::resolve(['title' => 'Customer Reports'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Customer Reports</h4>
            <p class="text-muted small mb-0">Analytics and insights for your customer base</p>
        </div>
        <a href="<?php echo e(route('admin.customers.index')); ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>

    
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card bg-primary-subtle border-0">
                <div class="card-body text-center py-3">
                    <h5 class="mb-0 text-primary fw-bold"><?php echo e($stats['total'] ?? 0); ?></h5>
                    <small class="text-muted">Total Customers</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card bg-success-subtle border-0">
                <div class="card-body text-center py-3">
                    <h5 class="mb-0 text-success fw-bold"><?php echo e($stats['active'] ?? 0); ?></h5>
                    <small class="text-muted">Active</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card bg-warning-subtle border-0">
                <div class="card-body text-center py-3">
                    <h5 class="mb-0 text-warning fw-bold"><?php echo e($stats['suspended'] ?? 0); ?></h5>
                    <small class="text-muted">Suspended</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card bg-info-subtle border-0">
                <div class="card-body text-center py-3">
                    <h5 class="mb-0 text-info fw-bold"><?php echo e($stats['with_orders'] ?? 0); ?></h5>
                    <small class="text-muted">With Orders</small>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0">Top Customers</h6>
                    <small class="text-muted">By order count</small>
                </div>
                <div class="card-body p-0">
                    <?php if(count($topCustomers) > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0 ps-4">#</th>
                                        <th class="border-0">Customer</th>
                                        <th class="border-0 text-center">Orders</th>
                                        <th class="border-0 text-end pe-4">Total Spent</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $topCustomers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="ps-4">
                                                <span class="badge bg-<?php echo e($index < 3 ? 'warning' : 'secondary'); ?> bg-opacity-10 text-<?php echo e($index < 3 ? 'warning' : 'secondary'); ?>">
                                                    <?php echo e($index + 1); ?>

                                                </span>
                                            </td>
                                            <td>
                                                <span class="fw-semibold small"><?php echo e($customer['name']); ?></span>
                                                <small class="d-block text-muted"><?php echo e($customer['email']); ?></small>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-primary bg-opacity-10 text-primary"><?php echo e($customer['orders_count']); ?></span>
                                            </td>
                                            <td class="text-end pe-4">
                                                <span class="fw-semibold"><?php echo e(config('ecommerce.currency.symbol', '$')); ?><?php echo e(number_format($customer['total_spend'], 2)); ?></span>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <p class="text-muted mb-0">No customer data available</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0">Highest Spending</h6>
                    <small class="text-muted">By total spend</small>
                </div>
                <div class="card-body p-0">
                    <?php if(count($highestSpending) > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0 ps-4">#</th>
                                        <th class="border-0">Customer</th>
                                        <th class="border-0 text-center">Orders</th>
                                        <th class="border-0 text-end pe-4">Total Spent</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $highestSpending; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="ps-4">
                                                <span class="badge bg-<?php echo e($index < 3 ? 'danger' : 'secondary'); ?> bg-opacity-10 text-<?php echo e($index < 3 ? 'danger' : 'secondary'); ?>">
                                                    <?php echo e($index + 1); ?>

                                                </span>
                                            </td>
                                            <td>
                                                <span class="fw-semibold small"><?php echo e($customer['name']); ?></span>
                                                <small class="d-block text-muted"><?php echo e($customer['email']); ?></small>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-info bg-opacity-10 text-info"><?php echo e($customer['orders_count']); ?></span>
                                            </td>
                                            <td class="text-end pe-4">
                                                <span class="fw-semibold"><?php echo e(config('ecommerce.currency.symbol', '$')); ?><?php echo e(number_format($customer['total_spend'], 2)); ?></span>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <p class="text-muted mb-0">No customer data available</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-2">
        
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0">Inactive Customers (90 days)</h6>
                    <span class="badge bg-warning"><?php echo e(count($inactiveCustomers)); ?> customers</span>
                </div>
                <div class="card-body p-0">
                    <?php if(count($inactiveCustomers) > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0 ps-4">Customer</th>
                                        <th class="border-0 d-none d-md-table-cell">Last Login</th>
                                        <th class="border-0 text-center">Orders</th>
                                        <th class="border-0 text-end pe-4">Spent</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $inactiveCustomers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="ps-4">
                                                <span class="fw-semibold small"><?php echo e($customer['name']); ?></span>
                                                <small class="d-block text-muted"><?php echo e($customer['email']); ?></small>
                                            </td>
                                            <td class="d-none d-md-table-cell">
                                                <small><?php echo e($customer['last_login'] ? $customer['last_login']->diffForHumans() : 'Never'); ?></small>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-secondary bg-opacity-10 text-secondary"><?php echo e($customer['total_orders']); ?></span>
                                            </td>
                                            <td class="text-end pe-4">
                                                <span class="small"><?php echo e(config('ecommerce.currency.symbol', '$')); ?><?php echo e(number_format($customer['total_spend'], 2)); ?></span>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                            <p class="text-muted mb-0">No inactive customers found!</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Customer Growth (12 Months)</h6>
                </div>
                <div class="card-body">
                    <?php if(count($growthData) > 0): ?>
                        <canvas id="growthChart" height="250"></canvas>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Not enough data for growth chart</p>
                        </div>
                    <?php endif; ?>
                </div>
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

<?php $__env->startPush('styles'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
$(document).ready(function() {
    <?php if(count($growthData) > 0): ?>
        const growthLabels = <?php echo json_encode(array_map(fn($d) => $d['period'], $growthData)); ?>;
        const growthCounts = <?php echo json_encode(array_map(fn($d) => $d['count'], $growthData)); ?>;

        new Chart(document.getElementById('growthChart'), {
            type: 'bar',
            data: {
                labels: growthLabels,
                datasets: [{
                    label: 'New Customers',
                    data: growthCounts,
                    backgroundColor: 'rgba(13, 110, 253, 0.2)',
                    borderColor: 'rgba(13, 110, 253, 1)',
                    borderWidth: 2,
                    borderRadius: 4,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    }
                }
            }
        });
    <?php endif; ?>
});
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\admin\customers\reports\index.blade.php ENDPATH**/ ?>