@props(['category', 'depth' => 0])

<li class="list-group-item border-0 py-2 ps-{{ min($depth * 4 + 3, 10) }} tree-node"
    data-id="{{ $category['id'] }}"
    data-sort="{{ $category['sort_order'] ?? 0 }}"
    role="treeitem"
    aria-expanded="{{ count($category['children'] ?? []) > 0 ? 'true' : 'false' }}">
    <div class="d-flex align-items-center gap-2 tree-node-content">
        @if(count($category['children'] ?? []) > 0)
            <button type="button" class="btn btn-sm btn-link p-0 text-muted tree-toggle" aria-label="Toggle {{ $category['name'] }} children">
                <i class="fas fa-chevron-down fa-xs" aria-hidden="true"></i>
            </button>
        @else
            <span class="d-inline-block tree-spacer"></span>
        @endif

        <div class="tree-drag-handle text-muted" title="Drag to reorder" aria-label="Drag {{ $category['name'] }} to reorder">
            <i class="fas fa-grip-vertical fa-xs" aria-hidden="true"></i>
        </div>

        <div class="d-flex align-items-center flex-grow-1 gap-2">
            <i class="fas fa-folder text-warning" aria-hidden="true"></i>
            <span class="fw-medium">{{ $category['name'] }}</span>
            <span class="text-muted small">/{{ $category['slug'] }}</span>
            <x-admin.category.status-badge :status="$category['status']" />
        </div>

        <div class="d-flex align-items-center gap-3 text-muted small">
            <span title="Products">
                <i class="fas fa-box me-1" aria-hidden="true"></i>{{ $category['product_count'] ?? 0 }}
            </span>
            <span class="text-muted">#{{ $category['sort_order'] ?? 0 }}</span>
        </div>

        <div class="d-flex gap-1 ms-2">
            <a href="{{ route('admin.categories.edit', $category['id']) }}"
               class="btn btn-sm btn-outline-primary px-2" title="Edit {{ $category['name'] }}" aria-label="Edit {{ $category['name'] }}">
                <i class="fas fa-edit fa-xs" aria-hidden="true"></i>
            </a>
            <a href="{{ route('admin.categories.show', $category['id']) }}"
               class="btn btn-sm btn-outline-secondary px-2" title="View {{ $category['name'] }}" aria-label="View {{ $category['name'] }}">
                <i class="fas fa-eye fa-xs" aria-hidden="true"></i>
            </a>
        </div>
    </div>

    @if(count($category['children'] ?? []) > 0)
        <ul class="list-unstyled mb-0 tree-children" role="group">
            @foreach($category['children'] as $child)
                <x-admin.category.tree-item :category="$child" :depth="$depth + 1" />
            @endforeach
        </ul>
    @endif
</li>
