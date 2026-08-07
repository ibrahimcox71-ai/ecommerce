<?php if (isset($component)) { $__componentOriginala5b7d55eb9299c3bd54b070f8a2d3d0f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala5b7d55eb9299c3bd54b070f8a2d3d0f = $attributes; } ?>
<?php $component = App\View\Components\Layouts\CustomerLayout::resolve(['title' => 'Addresses'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.customer-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\CustomerLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">My Addresses</h4>
        <a href="<?php echo e(route('customer.addresses.create')); ?>" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i>Add New
        </a>
    </div>

    <?php if($addresses->isEmpty()): ?>
        <div class="card">
            <div class="card-body text-center py-5 text-muted">
                <i class="fas fa-map-marker-alt fa-3x mb-3"></i>
                <p>No addresses saved yet.</p>
                <a href="<?php echo e(route('customer.addresses.create')); ?>" class="btn btn-primary">Add New Address</a>
            </div>
        </div>
    <?php else: ?>
        <div class="row g-3">
            <?php $__currentLoopData = $addresses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $address): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <span class="badge bg-<?php echo e($address->type === 'shipping' ? 'info' : 'secondary'); ?> me-1">
                                        <?php echo e(ucfirst($address->type)); ?>

                                    </span>
                                    <?php if($address->is_default): ?>
                                        <span class="badge bg-success">Default</span>
                                    <?php endif; ?>
                                </div>
                                <div class="d-flex gap-1">
                                    <?php if(!$address->is_default): ?>
                                        <form method="POST" action="<?php echo e(route('customer.addresses.default', $address)); ?>" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="btn btn-sm btn-link text-success p-0 me-2" title="Set as default">
                                                <i class="fas fa-check-circle"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                    <a href="<?php echo e(route('customer.addresses.edit', $address)); ?>" class="btn btn-sm btn-link text-primary p-0 me-2" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="<?php echo e(route('customer.addresses.destroy', $address)); ?>" class="d-inline" onsubmit="return confirm('Delete this address?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-link text-danger p-0" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <p class="mb-1 fw-semibold"><?php echo e($address->name); ?></p>
                            <p class="mb-1 text-muted small"><?php echo e($address->address_line1); ?></p>
                            <?php if($address->address_line2): ?>
                                <p class="mb-1 text-muted small"><?php echo e($address->address_line2); ?></p>
                            <?php endif; ?>
                            <p class="mb-1 text-muted small">
                                <?php echo e($address->city); ?><?php echo e($address->state ? ', ' . $address->state : ''); ?><?php echo e($address->zip ? ' ' . $address->zip : ''); ?>

                            </p>
                            <p class="mb-0 text-muted small"><?php echo e($address->country); ?></p>
                            <?php if($address->phone): ?>
                                <p class="mb-0 text-muted small mt-1"><i class="fas fa-phone me-1"></i><?php echo e($address->phone); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>
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
<?php /**PATH C:\laragon\www\ecommerce\resources\views\customer\addresses.blade.php ENDPATH**/ ?>