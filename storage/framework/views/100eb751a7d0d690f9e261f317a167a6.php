<?php if (isset($component)) { $__componentOriginaledc75c655a063d12a477f2c8d8f324fc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc = $attributes; } ?>
<?php $component = App\View\Components\Layouts\AdminLayout::resolve(['title' => 'Financial Reports'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div><h4 class="fw-bold mb-1">Financial Reports</h4><p class="text-muted small mb-0">Access various financial reports and statements</p></div>
    </div>

    <div class="row g-4">
        <div class="col-md-6 col-lg-4">
            <a href="<?php echo e(route('admin.finance.reports.profit-loss')); ?>" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 hover-shadow">
                    <div class="card-body text-center p-4">
                        <div class="display-6 mb-3 text-primary"><i class="fas fa-chart-line"></i></div>
                        <h5 class="fw-bold">Profit & Loss</h5>
                        <p class="text-muted small mb-0">View revenue, expenses and net profit for a period</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-lg-4">
            <a href="<?php echo e(route('admin.finance.reports.balance-sheet')); ?>" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 hover-shadow">
                    <div class="card-body text-center p-4">
                        <div class="display-6 mb-3 text-success"><i class="fas fa-balance-scale"></i></div>
                        <h5 class="fw-bold">Balance Sheet</h5>
                        <p class="text-muted small mb-0">View assets, liabilities and equity snapshot</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-lg-4">
            <a href="<?php echo e(route('admin.finance.reports.trial-balance')); ?>" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 hover-shadow">
                    <div class="card-body text-center p-4">
                        <div class="display-6 mb-3 text-info"><i class="fas fa-list-alt"></i></div>
                        <h5 class="fw-bold">Trial Balance</h5>
                        <p class="text-muted small mb-0">View all account balances with debits and credits</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-lg-4">
            <a href="<?php echo e(route('admin.finance.reports.cash-flow')); ?>" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 hover-shadow">
                    <div class="card-body text-center p-4">
                        <div class="display-6 mb-3 text-warning"><i class="fas fa-money-bill-wave"></i></div>
                        <h5 class="fw-bold">Cash Flow</h5>
                        <p class="text-muted small mb-0">Operating, investing and financing cash flows</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-lg-4">
            <a href="<?php echo e(route('admin.finance.reports.tax-summary')); ?>" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 hover-shadow">
                    <div class="card-body text-center p-4">
                        <div class="display-6 mb-3 text-danger"><i class="fas fa-file-invoice-dollar"></i></div>
                        <h5 class="fw-bold">Tax Summary</h5>
                        <p class="text-muted small mb-0">View tax collected by rate and period</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-lg-4">
            <a href="<?php echo e(route('admin.finance.budgets.report')); ?>" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 hover-shadow">
                    <div class="card-body text-center p-4">
                        <div class="display-6 mb-3 text-secondary"><i class="fas fa-calculator"></i></div>
                        <h5 class="fw-bold">Budget vs Actual</h5>
                        <p class="text-muted small mb-0">Compare budgeted amounts with actual spending</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-lg-4">
            <a href="<?php echo e(route('admin.finance.reports.accounts-payable')); ?>" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 hover-shadow">
                    <div class="card-body text-center p-4">
                        <div class="display-6 mb-3 text-danger"><i class="fas fa-credit-card"></i></div>
                        <h5 class="fw-bold">Accounts Payable</h5>
                        <p class="text-muted small mb-0">Outstanding payments to suppliers</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-lg-4">
            <a href="<?php echo e(route('admin.finance.reports.accounts-receivable')); ?>" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 hover-shadow">
                    <div class="card-body text-center p-4">
                        <div class="display-6 mb-3 text-success"><i class="fas fa-hand-holding-usd"></i></div>
                        <h5 class="fw-bold">Accounts Receivable</h5>
                        <p class="text-muted small mb-0">Outstanding customer payments</p>
                    </div>
                </div>
            </a>
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
<?php /**PATH C:\laragon\www\ecommerce\resources\views\admin\finance\reports\index.blade.php ENDPATH**/ ?>