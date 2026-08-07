<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['category', 'depth' => 0]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['category', 'depth' => 0]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<li class="list-group-item border-0 py-2 ps-<?php echo e(min($depth * 4 + 3, 10)); ?> tree-node"
    data-id="<?php echo e($category['id']); ?>"
    data-sort="<?php echo e($category['sort_order'] ?? 0); ?>"
    role="treeitem"
    aria-expanded="<?php echo e(count($category['children'] ?? []) > 0 ? 'true' : 'false'); ?>">
    <div class="d-flex align-items-center gap-2 tree-node-content">
        <?php if(count($category['children'] ?? []) > 0): ?>
            <button type="button" class="btn btn-sm btn-link p-0 text-muted tree-toggle" aria-label="Toggle <?php echo e($category['name']); ?> children">
                <i class="fas fa-chevron-down fa-xs" aria-hidden="true"></i>
            </button>
        <?php else: ?>
            <span class="d-inline-block tree-spacer"></span>
        <?php endif; ?>

        <div class="tree-drag-handle text-muted" title="Drag to reorder" aria-label="Drag <?php echo e($category['name']); ?> to reorder">
            <i class="fas fa-grip-vertical fa-xs" aria-hidden="true"></i>
        </div>

        <div class="d-flex align-items-center flex-grow-1 gap-2">
            <i class="fas fa-folder text-warning" aria-hidden="true"></i>
            <span class="fw-medium"><?php echo e($category['name']); ?></span>
            <span class="text-muted small">/<?php echo e($category['slug']); ?></span>
            <?php if (isset($component)) { $__componentOriginal0b3c95dd01f7182f54004b521151849d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b3c95dd01f7182f54004b521151849d = $attributes; } ?>
<?php $component = App\View\Components\Admin\Category\StatusBadge::resolve(['status' => $category['status']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.category.status-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Admin\Category\StatusBadge::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0b3c95dd01f7182f54004b521151849d)): ?>
<?php $attributes = $__attributesOriginal0b3c95dd01f7182f54004b521151849d; ?>
<?php unset($__attributesOriginal0b3c95dd01f7182f54004b521151849d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0b3c95dd01f7182f54004b521151849d)): ?>
<?php $component = $__componentOriginal0b3c95dd01f7182f54004b521151849d; ?>
<?php unset($__componentOriginal0b3c95dd01f7182f54004b521151849d); ?>
<?php endif; ?>
        </div>

        <div class="d-flex align-items-center gap-3 text-muted small">
            <span title="Products">
                <i class="fas fa-box me-1" aria-hidden="true"></i><?php echo e($category['product_count'] ?? 0); ?>

            </span>
            <span class="text-muted">#<?php echo e($category['sort_order'] ?? 0); ?></span>
        </div>

        <div class="d-flex gap-1 ms-2">
            <a href="<?php echo e(route('admin.categories.edit', $category['id'])); ?>"
               class="btn btn-sm btn-outline-primary px-2" title="Edit <?php echo e($category['name']); ?>" aria-label="Edit <?php echo e($category['name']); ?>">
                <i class="fas fa-edit fa-xs" aria-hidden="true"></i>
            </a>
            <a href="<?php echo e(route('admin.categories.show', $category['id'])); ?>"
               class="btn btn-sm btn-outline-secondary px-2" title="View <?php echo e($category['name']); ?>" aria-label="View <?php echo e($category['name']); ?>">
                <i class="fas fa-eye fa-xs" aria-hidden="true"></i>
            </a>
        </div>
    </div>

    <?php if(count($category['children'] ?? []) > 0): ?>
        <ul class="list-unstyled mb-0 tree-children" role="group">
            <?php $__currentLoopData = $category['children']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if (isset($component)) { $__componentOriginal19c2991690e261bc82b192135d020e5a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal19c2991690e261bc82b192135d020e5a = $attributes; } ?>
<?php $component = App\View\Components\Admin\Category\TreeItem::resolve(['category' => $child,'depth' => $depth + 1] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.category.tree-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Admin\Category\TreeItem::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal19c2991690e261bc82b192135d020e5a)): ?>
<?php $attributes = $__attributesOriginal19c2991690e261bc82b192135d020e5a; ?>
<?php unset($__attributesOriginal19c2991690e261bc82b192135d020e5a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal19c2991690e261bc82b192135d020e5a)): ?>
<?php $component = $__componentOriginal19c2991690e261bc82b192135d020e5a; ?>
<?php unset($__componentOriginal19c2991690e261bc82b192135d020e5a); ?>
<?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    <?php endif; ?>
</li>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\components\admin\category\tree-item.blade.php ENDPATH**/ ?>