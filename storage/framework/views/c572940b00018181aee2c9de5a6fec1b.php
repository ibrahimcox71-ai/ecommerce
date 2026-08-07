<?php if (isset($component)) { $__componentOriginaledc75c655a063d12a477f2c8d8f324fc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc = $attributes; } ?>
<?php $component = App\View\Components\Layouts\AdminLayout::resolve(['title' => 'Create Recurring Expense'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div><h4 class="fw-bold mb-1">Create Recurring Expense</h4><p class="text-muted small mb-0">Set up a recurring expense</p></div>
        <a href="<?php echo e(route('admin.finance.recurring-expenses.index')); ?>" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="<?php echo e(route('admin.finance.recurring-expenses.store')); ?>">
                <?php echo csrf_field(); ?>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Category <span class="text-danger">*</span></label>
                        <select name="expense_category_id" class="form-select" required>
                            <option value="">Select</option>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($cat->id); ?>" <?php if(old('expense_category_id') == $cat->id): echo 'selected'; endif; ?>><?php echo e($cat->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Amount <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="amount" class="form-control" value="<?php echo e(old('amount')); ?>" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Interval <span class="text-danger">*</span></label>
                        <select name="interval" class="form-select" required>
                            <option value="">Select</option>
                            <option value="daily" <?php if(old('interval') == 'daily'): echo 'selected'; endif; ?>>Daily</option>
                            <option value="weekly" <?php if(old('interval') == 'weekly'): echo 'selected'; endif; ?>>Weekly</option>
                            <option value="bi_weekly" <?php if(old('interval') == 'bi_weekly'): echo 'selected'; endif; ?>>Bi-Weekly</option>
                            <option value="monthly" <?php if(old('interval') == 'monthly'): echo 'selected'; endif; ?>>Monthly</option>
                            <option value="quarterly" <?php if(old('interval') == 'quarterly'): echo 'selected'; endif; ?>>Quarterly</option>
                            <option value="semi_annually" <?php if(old('interval') == 'semi_annually'): echo 'selected'; endif; ?>>Semi-Annually</option>
                            <option value="annually" <?php if(old('interval') == 'annually'): echo 'selected'; endif; ?>>Annually</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Account</label>
                        <select name="chart_of_account_id" class="form-select">
                            <option value="">—</option>
                            <?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $acc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($acc->id); ?>" <?php if(old('chart_of_account_id') == $acc->id): echo 'selected'; endif; ?>><?php echo e($acc->code); ?> - <?php echo e($acc->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Payee</label>
                        <input type="text" name="payee" class="form-control" value="<?php echo e(old('payee')); ?>">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Start Date <span class="text-danger">*</span></label>
                        <input type="date" name="start_date" class="form-control" value="<?php echo e(old('start_date')); ?>" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">End Date</label>
                        <input type="date" name="end_date" class="form-control" value="<?php echo e(old('end_date')); ?>">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Max Occurrences</label>
                        <input type="number" min="1" name="max_occurrences" class="form-control" value="<?php echo e(old('max_occurrences')); ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Payment Method</label>
                        <input type="text" name="payment_method" class="form-control" value="<?php echo e(old('payment_method')); ?>">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="2"><?php echo e(old('description')); ?></textarea>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Create</button>
                    <a href="<?php echo e(route('admin.finance.recurring-expenses.index')); ?>" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
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
<?php /**PATH C:\laragon\www\ecommerce\resources\views\admin\finance\recurring-expenses\create.blade.php ENDPATH**/ ?>