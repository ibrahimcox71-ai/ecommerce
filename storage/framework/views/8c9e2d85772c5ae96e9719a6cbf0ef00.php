<?php if (isset($component)) { $__componentOriginala5b7d55eb9299c3bd54b070f8a2d3d0f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala5b7d55eb9299c3bd54b070f8a2d3d0f = $attributes; } ?>
<?php $component = App\View\Components\Layouts\CustomerLayout::resolve(['title' => ''.e(isset($address) ? 'Edit Address' : 'Add Address').''] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.customer-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\CustomerLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="<?php echo e(route('customer.addresses')); ?>" class="text-muted text-decoration-none small">
                <i class="fas fa-arrow-left me-1"></i>Back to Addresses
            </a>
            <h4 class="fw-bold mb-0 mt-1"><?php echo e(isset($address) ? 'Edit Address' : 'Add New Address'); ?></h4>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="POST" action="<?php echo e(isset($address) ? route('customer.addresses.update', $address) : route('customer.addresses.store')); ?>">
                <?php echo csrf_field(); ?>
                <?php if(isset($address)): ?>
                    <?php echo method_field('PUT'); ?>
                <?php endif; ?>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-outline">
                            <input type="text" name="name" id="name" class="form-control"
                                   value="<?php echo e(old('name', $address->name ?? '')); ?>" required>
                            <label class="form-label" for="name">Full Name</label>
                        </div>
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="col-md-6">
                        <div class="form-outline">
                            <input type="text" name="phone" id="phone" class="form-control"
                                   value="<?php echo e(old('phone', $address->phone ?? '')); ?>">
                            <label class="form-label" for="phone">Phone Number</label>
                        </div>
                        <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-outline">
                            <input type="email" name="email" id="email" class="form-control"
                                   value="<?php echo e(old('email', $address->email ?? '')); ?>">
                            <label class="form-label" for="email">Email Address</label>
                        </div>
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="col-md-6">
                        <select name="type" id="type" class="form-select">
                            <option value="shipping" <?php if(old('type', $address->type ?? '') === 'shipping'): echo 'selected'; endif; ?>>Shipping</option>
                            <option value="billing" <?php if(old('type', $address->type ?? '') === 'billing'): echo 'selected'; endif; ?>>Billing</option>
                        </select>
                        <label class="form-label" for="type">Address Type</label>
                        <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="form-outline">
                        <input type="text" name="address_line1" id="address_line1" class="form-control"
                               value="<?php echo e(old('address_line1', $address->address_line1 ?? '')); ?>" required>
                        <label class="form-label" for="address_line1">Address Line 1</label>
                    </div>
                    <?php $__errorArgs = ['address_line1'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="mb-3">
                    <div class="form-outline">
                        <input type="text" name="address_line2" id="address_line2" class="form-control"
                               value="<?php echo e(old('address_line2', $address->address_line2 ?? '')); ?>">
                        <label class="form-label" for="address_line2">Address Line 2 (Optional)</label>
                    </div>
                    <?php $__errorArgs = ['address_line2'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="form-outline">
                            <input type="text" name="city" id="city" class="form-control"
                                   value="<?php echo e(old('city', $address->city ?? '')); ?>" required>
                            <label class="form-label" for="city">City</label>
                        </div>
                        <?php $__errorArgs = ['city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="col-md-4">
                        <div class="form-outline">
                            <input type="text" name="state" id="state" class="form-control"
                                   value="<?php echo e(old('state', $address->state ?? '')); ?>">
                            <label class="form-label" for="state">State / Province</label>
                        </div>
                        <?php $__errorArgs = ['state'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="col-md-4">
                        <div class="form-outline">
                            <input type="text" name="zip" id="zip" class="form-control"
                                   value="<?php echo e(old('zip', $address->zip ?? '')); ?>">
                            <label class="form-label" for="zip">ZIP / Postal Code</label>
                        </div>
                        <?php $__errorArgs = ['zip'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="form-outline">
                            <input type="text" name="country" id="country" class="form-control"
                                   value="<?php echo e(old('country', $address->country ?? '')); ?>" required>
                            <label class="form-label" for="country">Country</label>
                        </div>
                        <?php $__errorArgs = ['country'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check form-switch mt-2">
                            <input type="hidden" name="is_default" value="0">
                            <input type="checkbox" name="is_default" id="is_default" class="form-check-input" value="1"
                                   <?php if(old('is_default', $address->is_default ?? false)): echo 'checked'; endif; ?>>
                            <label class="form-check-label" for="is_default">Set as default address</label>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i><?php echo e(isset($address) ? 'Update Address' : 'Save Address'); ?>

                </button>
            </form>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala5b7d55eb9299c3bd54b070f8a2d3d0f)): ?>
<?php $attributes = $__attributesOriginala5b7d55eb9299c3bd54b070f8a2d3d0f; ?>
<?php unset($__attributesOriginala5b7d55eb9299c3bd54b070f8a2d3d0f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala5b7d55eb9299c3bd54b070f8a2d3d0f)): ?>
<?php $component = $__componentOriginala5b7d55eb9299c3bd54b070f8a2d3d0f; ?>
<?php unset($__componentOriginala5b7d55eb9299c3bd54b070f8a2d3d0f); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\customer\address-form.blade.php ENDPATH**/ ?>