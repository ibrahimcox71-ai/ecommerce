<?php if (isset($component)) { $__componentOriginaledc75c655a063d12a477f2c8d8f324fc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc = $attributes; } ?>
<?php $component = App\View\Components\Layouts\AdminLayout::resolve(['title' => 'Trashed Products'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Trashed Products</h4>
            <p class="text-muted small mb-0">Deleted products that can be restored</p>
        </div>
        <div>
            <a href="<?php echo e(route('admin.products.index')); ?>" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to Products
            </a>
        </div>
    </div>

    
    <div class="d-none" id="bulkActions">
        <div class="alert alert-info d-flex align-items-center justify-content-between mb-3">
            <span><i class="fas fa-check-circle me-2"></i><span id="selectedCount">0</span> selected</span>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-sm btn-success" onclick="bulkRestore()">
                    <i class="fas fa-undo me-1"></i> Restore
                </button>
                <button type="button" class="btn btn-sm btn-danger" onclick="bulkForceDelete()">
                    <i class="fas fa-trash-alt me-1"></i> Permanent Delete
                </button>
            </div>
        </div>
    </div>

    
    <div class="card">
        <div class="card-body">
            <?php if($products->count() > 0): ?>
                <form id="bulkForm" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0" style="width: 40px;">
                                        <input type="checkbox" class="form-check-input" id="selectAll">
                                    </th>
                                    <th class="border-0">Product</th>
                                    <th class="border-0">SKU</th>
                                    <th class="border-0">Deleted</th>
                                    <th class="border-0 text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr data-id="<?php echo e($product->id); ?>">
                                        <td>
                                            <input type="checkbox" name="ids[]" value="<?php echo e($product->id); ?>" 
                                                   class="form-check-input row-checkbox">
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <?php if($product->thumbnail): ?>
                                                    <img src="<?php echo e($product->thumbnail_url); ?>" alt="<?php echo e($product->name); ?>" 
                                                         class="rounded me-3" style="width: 48px; height: 48px; object-fit: cover; opacity: 0.6;">
                                                <?php else: ?>
                                                    <div class="rounded me-3 d-flex align-items-center justify-content-center bg-light" 
                                                         style="width: 48px; height: 48px; opacity: 0.6;">
                                                        <i class="fas fa-box text-muted"></i>
                                                    </div>
                                                <?php endif; ?>
                                                <div>
                                                    <span class="fw-semibold text-muted"><?php echo e($product->name); ?></span>
                                                    <small class="d-block text-muted">
                                                        <?php echo e($product->category?->name ?? 'Uncategorized'); ?>

                                                    </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <code class="text-muted"><?php echo e($product->sku); ?></code>
                                        </td>
                                        <td>
                                            <span class="text-muted"><?php echo e($product->deleted_at->format('M d, Y')); ?></span>
                                            <small class="d-block text-muted"><?php echo e($product->deleted_at->diffForHumans()); ?></small>
                                        </td>
                                        <td class="text-end">
                                            <div class="btn-group">
                                                <form action="<?php echo e(route('admin.products.restore', $product->id)); ?>" method="POST" class="d-inline">
                                                    <?php echo csrf_field(); ?>
                                                    <button type="submit" class="btn btn-sm btn-success" title="Restore">
                                                        <i class="fas fa-undo"></i>
                                                    </button>
                                                </form>
                                                <form action="<?php echo e(route('admin.products.force-delete', $product->id)); ?>" method="POST" class="d-inline">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Permanent Delete"
                                                            onclick="return confirm('Are you sure? This cannot be undone!');">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </form>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted small">
                        Showing <?php echo e($products->firstItem()); ?> to <?php echo e($products->lastItem()); ?> of <?php echo e($products->total()); ?> entries
                    </div>
                    <div>
                        <?php echo e($products->links()); ?>

                    </div>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="fas fa-trash-alt fa-3x text-muted mb-3"></i>
                    <h5>No trashed products</h5>
                    <p class="text-muted">Products you delete will appear here</p>
                    <a href="<?php echo e(route('admin.products.index')); ?>" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Go to Products
                    </a>
                </div>
            <?php endif; ?>
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
document.addEventListener('DOMContentLoaded', function() {
    var selectAll = document.getElementById('selectAll');
    var bulkActions = document.getElementById('bulkActions');
    var selectedCount = document.getElementById('selectedCount');
    var bulkForm = document.getElementById('bulkForm');

    if (selectAll) {
        selectAll.addEventListener('change', function() {
            document.querySelectorAll('.row-checkbox').forEach(function(cb) {
                cb.checked = selectAll.checked;
            });
            updateBulkActions();
        });
    }

    document.querySelectorAll('.row-checkbox').forEach(function(cb) {
        cb.addEventListener('change', updateBulkActions);
    });

    function updateBulkActions() {
        var checked = document.querySelectorAll('.row-checkbox:checked').length;
        if (checked > 0) {
            bulkActions.classList.remove('d-none');
            selectedCount.textContent = checked;
        } else {
            bulkActions.classList.add('d-none');
        }
    }
});

function bulkRestore() {
    if (confirm('Are you sure you want to restore selected products?')) {
        document.getElementById('bulkForm').action = '<?php echo e(route('admin.products.bulk-restore')); ?>';
        document.getElementById('bulkForm').submit();
    }
}

function bulkForceDelete() {
    if (confirm('Are you sure? This will permanently delete the products and cannot be undone!')) {
        document.getElementById('bulkForm').action = '<?php echo e(route('admin.products.bulk-force-delete')); ?>';
        document.getElementById('bulkForm').submit();
    }
}
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\admin\products\trashed.blade.php ENDPATH**/ ?>