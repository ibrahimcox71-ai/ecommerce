<?php if (isset($component)) { $__componentOriginaledc75c655a063d12a477f2c8d8f324fc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc = $attributes; } ?>
<?php $component = App\View\Components\Layouts\AdminLayout::resolve(['title' => 'Customer Details'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Customer Details</h4>
            <p class="text-muted small mb-0">View customer information and history</p>
        </div>
        <div class="d-flex gap-2">
            <a href="<?php echo e(route('admin.customers.edit', $customer->id)); ?>" class="btn btn-primary">
                <i class="fas fa-edit me-1"></i> Edit
            </a>
            <a href="<?php echo e(route('admin.customers.index')); ?>" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    
    <div class="card mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-auto">
                    <?php if($customer->avatar): ?>
                        <img src="<?php echo e($customer->avatar_url); ?>" alt="<?php echo e($customer->name); ?>"
                             class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
                    <?php else: ?>
                        <div class="rounded-circle d-flex align-items-center justify-content-center bg-light"
                             style="width: 80px; height: 80px;">
                            <i class="fas fa-user fa-2x text-muted"></i>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col">
                    <h5 class="fw-bold mb-1"><?php echo e($customer->name); ?></h5>
                    <div class="d-flex flex-wrap gap-2 align-items-center">
                        <span class="text-muted small">#<?php echo e($customer->id); ?></span>
                        <?php echo $customer->status_badge; ?>

                        <?php if($customer->customer_type?->value === 'business'): ?>
                            <span class="badge bg-primary bg-opacity-10 text-primary">
                                <i class="fas fa-building me-1"></i><?php echo e($customer->customer_type->label()); ?>

                            </span>
                        <?php endif; ?>
                        <?php if($customer->group): ?>
                            <span class="badge bg-light text-dark border"><?php echo e($customer->group->name); ?></span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-auto text-end">
                    <div class="small text-muted">Member since</div>
                    <div class="fw-semibold"><?php echo e($customer->created_at->format('M d, Y')); ?></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        
        <div class="col-lg-8">
            
            <div class="card mb-4">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Order Summary</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-6 col-md-3">
                            <div class="text-center p-3 bg-light rounded">
                                <h4 class="fw-bold text-primary mb-0"><?php echo e($customer->total_orders); ?></h4>
                                <small class="text-muted">Total Orders</small>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="text-center p-3 bg-light rounded">
                                <h4 class="fw-bold text-success mb-0"><?php echo e(config('ecommerce.currency.symbol', '$')); ?><?php echo e(number_format($customer->total_spend, 2)); ?></h4>
                                <small class="text-muted">Total Spend</small>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="text-center p-3 bg-light rounded">
                                <h4 class="fw-bold text-info mb-0"><?php echo e(config('ecommerce.currency.symbol', '$')); ?><?php echo e(number_format($customer->average_order_value, 2)); ?></h4>
                                <small class="text-muted">Avg Order Value</small>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="text-center p-3 bg-light rounded">
                                <h4 class="fw-bold text-warning mb-0"><?php echo e($customer->cancelled_orders_count); ?></h4>
                                <small class="text-muted">Cancelled</small>
                            </div>
                        </div>
                    </div>

                    <?php if($customer->last_order): ?>
                        <div class="mt-3 pt-3 border-top">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-muted d-block">Last Order</small>
                                    <span class="fw-semibold">#<?php echo e($customer->last_order->order_number ?? $customer->last_order->id); ?></span>
                                    <small class="text-muted ms-2"><?php echo e($customer->last_order->created_at->diffForHumans()); ?></small>
                                </div>
                                <span class="badge bg-<?php echo e($customer->last_order->order_status === 'completed' ? 'success' : 'warning'); ?>">
                                    <?php echo e(ucfirst($customer->last_order->order_status)); ?>

                                </span>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            
            <div class="card mb-4">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Contact Information</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <?php if($customer->email): ?>
                                <div class="mb-3">
                                    <small class="text-muted d-block">Email</small>
                                    <div class="d-flex align-items-center gap-2">
                                        <span><?php echo e($customer->email); ?></span>
                                        <?php if($customer->email_verified_at): ?>
                                            <span class="badge bg-success bg-opacity-10 text-success">
                                                <i class="fas fa-check-circle me-1"></i>Verified
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-warning bg-opacity-10 text-warning">
                                                <i class="fas fa-clock me-1"></i>Unverified
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if($customer->phone): ?>
                                <div class="mb-3">
                                    <small class="text-muted d-block">Phone</small>
                                    <div class="d-flex align-items-center gap-2">
                                        <span><?php echo e($customer->phone); ?></span>
                                        <?php if($customer->phone_verified_at): ?>
                                            <span class="badge bg-success bg-opacity-10 text-success">
                                                <i class="fas fa-check-circle me-1"></i>Verified
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if($customer->date_of_birth): ?>
                                <div class="mb-3">
                                    <small class="text-muted d-block">Date of Birth</small>
                                    <span><?php echo e($customer->date_of_birth->format('M d, Y')); ?></span>
                                </div>
                            <?php endif; ?>

                            <?php if($customer->gender): ?>
                                <div class="mb-3">
                                    <small class="text-muted d-block">Gender</small>
                                    <span><?php echo e(ucfirst($customer->gender)); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-6">
                            <?php if($customer->emergency_contact_name): ?>
                                <div class="mb-3">
                                    <small class="text-muted d-block">Emergency Contact</small>
                                    <span class="fw-semibold"><?php echo e($customer->emergency_contact_name); ?></span>
                                    <?php if($customer->emergency_contact_phone): ?>
                                        <br><small class="text-muted"><?php echo e($customer->emergency_contact_phone); ?></small>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <?php if($customer->user): ?>
                                <div class="mb-3">
                                    <small class="text-muted d-block">Linked User Account</small>
                                    <a href="<?php echo e(route('admin.users.show', $customer->user_id)); ?>" class="text-decoration-none">
                                        <i class="fas fa-external-link-alt me-1"></i><?php echo e($customer->user->name); ?>

                                    </a>
                                </div>
                            <?php endif; ?>

                            <?php if($customer->referral_code): ?>
                                <div class="mb-3">
                                    <small class="text-muted d-block">Referral Code</small>
                                    <code><?php echo e($customer->referral_code); ?></code>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="card mb-4">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0">Addresses</h6>
                </div>
                <div class="card-body">
                    <?php if($customer->addresses->count() > 0): ?>
                        <div class="row g-3">
                            <?php $__currentLoopData = $customer->addresses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $address): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-md-6">
                                    <div class="border rounded p-3 position-relative">
                                        <?php if($address->is_default): ?>
                                            <span class="badge bg-info position-absolute top-0 end-0 m-2">Default</span>
                                        <?php endif; ?>
                                        <div class="d-flex align-items-center mb-2">
                                            <span class="badge bg-light text-dark border me-2"><?php echo e($address->type_label); ?></span>
                                            <?php if($address->label): ?>
                                                <small class="text-muted"><?php echo e($address->label); ?></small>
                                            <?php endif; ?>
                                        </div>
                                        <div class="small">
                                            <strong><?php echo e($address->name); ?></strong>
                                            <?php if($address->phone): ?>
                                                <br><?php echo e($address->phone); ?>

                                            <?php endif; ?>
                                            <br><?php echo e($address->address_line_1); ?>

                                            <?php if($address->address_line_2): ?>
                                                <br><?php echo e($address->address_line_2); ?>

                                            <?php endif; ?>
                                            <br><?php echo e($address->city); ?>, <?php echo e($address->state); ?> <?php echo e($address->postal_code); ?>

                                            <br><?php echo e($address->country); ?>

                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="fas fa-map-marker-alt fa-2x text-muted mb-2"></i>
                            <p class="text-muted mb-0">No addresses saved</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            
            <?php if($customer->customer_type?->value === 'business' && ($customer->company_name || $customer->company_registration_number || $customer->tax_number)): ?>
                <div class="card mb-4">
                    <div class="card-header bg-transparent">
                        <h6 class="fw-bold mb-0">Business Details</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <?php if($customer->company_name): ?>
                                <div class="col-md-4 mb-3">
                                    <small class="text-muted d-block">Company Name</small>
                                    <span class="fw-semibold"><?php echo e($customer->company_name); ?></span>
                                </div>
                            <?php endif; ?>
                            <?php if($customer->company_registration_number): ?>
                                <div class="col-md-4 mb-3">
                                    <small class="text-muted d-block">Registration Number</small>
                                    <span><?php echo e($customer->company_registration_number); ?></span>
                                </div>
                            <?php endif; ?>
                            <?php if($customer->tax_number): ?>
                                <div class="col-md-4 mb-3">
                                    <small class="text-muted d-block">Tax Number</small>
                                    <span><?php echo e($customer->tax_number); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            
            <?php if($loginHistories->count() > 0): ?>
                <div class="card mb-4">
                    <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold mb-0">Login History</h6>
                        <?php if($customer->user): ?>
                            <a href="<?php echo e(route('admin.customers.login-history', $customer->id)); ?>" class="btn btn-sm btn-outline-secondary">
                                View All
                            </a>
                        <?php endif; ?>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-sm mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0">Date</th>
                                        <th class="border-0">IP</th>
                                        <th class="border-0 d-none d-md-table-cell">Browser</th>
                                        <th class="border-0 d-none d-md-table-cell">Device</th>
                                        <th class="border-0">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $loginHistories->take(10); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $history): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="small"><?php echo e($history->login_at->format('M d, H:i')); ?></td>
                                            <td class="small"><?php echo e($history->ip_address); ?></td>
                                            <td class="small d-none d-md-table-cell"><?php echo e($history->browser ?? 'Unknown'); ?></td>
                                            <td class="small d-none d-md-table-cell"><?php echo e($history->device_type); ?></td>
                                            <td>
                                                <?php if($history->is_successful): ?>
                                                    <span class="badge bg-success bg-opacity-10 text-success">Success</span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger bg-opacity-10 text-danger"><?php echo e($history->failure_reason ?? 'Failed'); ?></span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            
            <div class="card">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Activity Log</h6>
                </div>
                <div class="card-body">
                    <?php
                        $activities = $customer->activityLogs()->latest()->take(10)->get();
                    ?>
                    <?php if($activities->count() > 0): ?>
                        <div class="timeline">
                            <?php $__currentLoopData = $activities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="d-flex mb-3">
                                    <div class="me-3">
                                        <i class="fas fa-circle text-<?php echo e($log->description === 'created' ? 'success' : 'info'); ?> fa-xs mt-1"></i>
                                    </div>
                                    <div>
                                        <p class="mb-0 small"><?php echo e($log->description); ?></p>
                                        <small class="text-muted"><?php echo e($log->created_at->diffForHumans()); ?></small>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <p class="text-muted small mb-0">No activity recorded</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        
        <div class="col-lg-4">
            
            <div class="card mb-4">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Account</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Reward Points</span>
                        <span class="badge bg-warning bg-opacity-10 text-warning fw-semibold">
                            <?php echo e(number_format($customer->reward_points)); ?>

                        </span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Wallet Balance</span>
                        <span class="fw-semibold"><?php echo e(config('ecommerce.currency.symbol', '$')); ?><?php echo e(number_format($customer->wallet_balance, 2)); ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Last Login</span>
                        <span class="small"><?php echo e($customer->last_login_at?->diffForHumans() ?? 'Never'); ?></span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Returned Orders</span>
                        <span class="badge bg-secondary bg-opacity-10 text-secondary"><?php echo e($customer->returned_orders_count); ?></span>
                    </div>
                </div>
            </div>

            
            <?php if($customer->notes): ?>
                <div class="card mb-4">
                    <div class="card-header bg-transparent">
                        <h6 class="fw-bold mb-0">Notes</h6>
                    </div>
                    <div class="card-body">
                        <p class="small mb-0"><?php echo e($customer->notes); ?></p>
                    </div>
                </div>
            <?php endif; ?>

            
            <div class="card">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="<?php echo e(route('admin.customers.edit', $customer->id)); ?>" class="btn btn-outline-primary">
                            <i class="fas fa-edit me-2"></i> Edit Profile
                        </a>
                        <?php if($customer->isSuspended()): ?>
                            <button type="button" class="btn btn-outline-success" onclick="toggleStatus(<?php echo e($customer->id); ?>)">
                                <i class="fas fa-check-circle me-2"></i> Activate Customer
                            </button>
                        <?php else: ?>
                            <button type="button" class="btn btn-outline-warning" onclick="toggleStatus(<?php echo e($customer->id); ?>)">
                                <i class="fas fa-pause-circle me-2"></i> Suspend Customer
                            </button>
                        <?php endif; ?>
                        <button type="button" class="btn btn-outline-danger" onclick="confirmDelete(<?php echo e($customer->id); ?>, '<?php echo e(addslashes($customer->name)); ?>')">
                            <i class="fas fa-trash me-2"></i> Delete Customer
                        </button>
                    </div>
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


<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Customer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete <strong id="deleteName"></strong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-1"></i> Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
function toggleStatus(id) {
    if (!confirm('Are you sure you want to change this customer\'s status?')) return;

    $.ajax({
        url: `/admin/customers/${id}/toggle-status`,
        type: 'POST',
        data: { _token: '<?php echo e(csrf_token()); ?>' },
        success: function(response) {
            if (response.success) {
                location.reload();
            }
        }
    });
}

function confirmDelete(id, name) {
    $('#deleteName').text(name);
    $('#deleteForm').attr('action', `/admin/customers/${id}`);
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\admin\customers\show.blade.php ENDPATH**/ ?>