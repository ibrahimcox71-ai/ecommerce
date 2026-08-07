<?php if (isset($component)) { $__componentOriginaledc75c655a063d12a477f2c8d8f324fc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc = $attributes; } ?>
<?php $component = App\View\Components\Layouts\AdminLayout::resolve(['title' => 'Category Tree'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Category Tree</h4>
            <p class="text-muted small mb-0">Drag & drop to reorder categories</p>
        </div>
        <div class="d-flex gap-2">
            <a href="<?php echo e(route('admin.categories.trashed')); ?>" class="btn btn-outline-secondary">
                <i class="fas fa-trash-alt me-1"></i> Trashed
            </a>
            <a href="<?php echo e(route('admin.categories.index')); ?>" class="btn btn-outline-secondary">
                <i class="fas fa-list me-1"></i> List View
            </a>
            <a href="<?php echo e(route('admin.categories.create')); ?>" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Add Category
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
            <h6 class="fw-bold mb-0"><i class="fas fa-sitemap me-2"></i>Category Hierarchy</h6>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-sm btn-outline-success" id="expandAll">
                    <i class="fas fa-expand me-1"></i> Expand All
                </button>
                <button type="button" class="btn btn-sm btn-outline-warning" id="collapseAll">
                    <i class="fas fa-compress me-1"></i> Collapse All
                </button>
                <button type="button" class="btn btn-sm btn-success" id="saveTreeOrder" disabled>
                    <i class="fas fa-save me-1"></i> Save Order
                </button>
            </div>
        </div>
        <div class="card-body">
            <?php if(count($tree) > 0): ?>
                <div class="tree-container">
                    <ul class="list-unstyled mb-0 tree-root" id="treeRoot">
                        <?php $__currentLoopData = $tree; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $node): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if (isset($component)) { $__componentOriginal19c2991690e261bc82b192135d020e5a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal19c2991690e261bc82b192135d020e5a = $attributes; } ?>
<?php $component = App\View\Components\Admin\Category\TreeItem::resolve(['category' => $node,'depth' => 0] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
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
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="fas fa-sitemap fa-3x text-muted mb-3"></i>
                    <h5>No categories found</h5>
                    <p class="text-muted">Create your first category to see the tree.</p>
                    <a href="<?php echo e(route('admin.categories.create')); ?>" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Add Category
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
let treeChanged = false;

$(document).ready(function() {
    initSortableTree();
    initTreeToggle();
    initExpandCollapse();
});

function initSortableTree() {
    $('#treeRoot').sortable({
        items: '> .tree-node',
        handle: '.tree-drag-handle',
        placeholder: 'tree-placeholder',
        tolerance: 'pointer',
        axis: 'y',
        distance: 5,
        start: function(e, ui) {
            ui.placeholder.height(ui.item.height());
        },
        update: function(e, ui) {
            treeChanged = true;
            $('#saveTreeOrder').prop('disabled', false);
        }
    });

    $('.tree-children').sortable({
        items: '> .tree-node',
        handle: '.tree-drag-handle',
        placeholder: 'tree-placeholder',
        tolerance: 'pointer',
        axis: 'y',
        distance: 5,
        start: function(e, ui) {
            ui.placeholder.height(ui.item.height());
        },
        update: function(e, ui) {
            treeChanged = true;
            $('#saveTreeOrder').prop('disabled', false);
        }
    });
}

function initTreeToggle() {
    $(document).on('click', '.tree-toggle', function(e) {
        e.preventDefault();
        const $btn = $(this);
        const $children = $btn.closest('.tree-node').find('> .tree-children');
        const $icon = $btn.find('i');

        if ($children.is(':visible')) {
            $children.slideUp(200);
            $icon.removeClass('fa-chevron-down').addClass('fa-chevron-right');
        } else {
            $children.slideDown(200);
            $icon.removeClass('fa-chevron-right').addClass('fa-chevron-down');
        }
    });
}

function initExpandCollapse() {
    $('#expandAll').click(function() {
        $('.tree-children').show();
        $('.tree-toggle i').removeClass('fa-chevron-right').addClass('fa-chevron-down');
    });

    $('#collapseAll').click(function() {
        $('.tree-children').hide();
        $('.tree-toggle i').removeClass('fa-chevron-down').addClass('fa-chevron-right');
    });
}

$('#saveTreeOrder').click(function() {
    const items = [];

    function collectItems($el, parentId) {
        $el.children('.tree-node').each(function(index) {
            const $node = $(this);
            const id = $node.data('id');
            items.push({
                id: parseInt(id),
                sort_order: index,
                parent_id: parentId
            });
            const $childrenList = $node.find('> .tree-children');
            if ($childrenList.length) {
                collectItems($childrenList, parseInt(id));
            }
        });
    }

    collectItems($('#treeRoot'), null);

    $.ajax({
        url: '<?php echo e(route('admin.categories.update-sort')); ?>',
        type: 'POST',
        data: {
            _token: '<?php echo e(csrf_token()); ?>',
            items: items
        },
        success: function(response) {
            if (response.success) {
                showToast(response.message, 'success');
                $('#saveTreeOrder').prop('disabled', true);
                treeChanged = false;
            }
        },
        error: function() {
            showToast('Failed to save sort order', 'error');
        }
    });
});

function showToast(message, type = 'info') {
    const bgClass = type === 'success' ? 'bg-success' : type === 'error' ? 'bg-danger' : 'bg-info';
    $('body').append(`
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999;">
            <div class="toast ${bgClass} text-white" role="alert">
                <div class="toast-body d-flex align-items-center">
                    <i class="fas fa-${type === 'success' ? 'check' : type === 'error' ? 'times' : 'info'} me-2"></i>
                    ${message}
                </div>
            </div>
        </div>
    `);
    const toast = new bootstrap.Toast($('.toast').last()[0], { delay: 3000 });
    toast.show();
    setTimeout(() => $('.toast').parent().remove(), 3500);
}
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\admin\categories\tree.blade.php ENDPATH**/ ?>