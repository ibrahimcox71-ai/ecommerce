<x-layouts.admin-layout title="Category Tree">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Category Tree</h4>
            <p class="text-muted small mb-0">Drag & drop to reorder categories</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.categories.trashed') }}" class="btn btn-outline-secondary">
                <i class="fas fa-trash-alt me-1"></i> Trashed
            </a>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-list me-1"></i> List View
            </a>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
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
            @if(count($tree) > 0)
                <div class="tree-container">
                    <ul class="list-unstyled mb-0 tree-root" id="treeRoot">
                        @foreach($tree as $node)
                            <x-admin.category.tree-item :category="$node" :depth="0" />
                        @endforeach
                    </ul>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-sitemap fa-3x text-muted mb-3"></i>
                    <h5>No categories found</h5>
                    <p class="text-muted">Create your first category to see the tree.</p>
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Add Category
                    </a>
                </div>
            @endif
        </div>
    </div>

</x-layouts.admin-layout>

@push('scripts')
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
        url: '{{ route('admin.categories.update-sort') }}',
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
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
@endpush
