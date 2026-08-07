<x-layouts.admin-layout title="Categories">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Categories</h4>
            <p class="text-muted small mb-0">Manage your product categories</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.categories.tree') }}" class="btn btn-outline-secondary">
                <i class="fas fa-sitemap me-1"></i> Tree View
            </a>
            <a href="{{ route('admin.categories.trashed') }}" class="btn btn-outline-secondary">
                <i class="fas fa-trash-alt me-1"></i> Trashed
                @if(($stats['trashed'] ?? 0) > 0)
                    <span class="badge bg-danger ms-1">{{ $stats['trashed'] }}</span>
                @endif
            </a>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Add Category
            </a>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-2">
            <div class="card bg-primary-subtle border-0">
                <div class="card-body text-center py-3">
                    <h5 class="mb-0 text-primary fw-bold">{{ $stats['total'] ?? 0 }}</h5>
                    <small class="text-muted">Total</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-2">
            <div class="card bg-success-subtle border-0">
                <div class="card-body text-center py-3">
                    <h5 class="mb-0 text-success fw-bold">{{ $stats['active'] ?? 0 }}</h5>
                    <small class="text-muted">Active</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-2">
            <div class="card bg-warning-subtle border-0">
                <div class="card-body text-center py-3">
                    <h5 class="mb-0 text-warning fw-bold">{{ $stats['draft'] ?? 0 }}</h5>
                    <small class="text-muted">Draft</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-2">
            <div class="card bg-secondary-subtle border-0">
                <div class="card-body text-center py-3">
                    <h5 class="mb-0 text-secondary fw-bold">{{ $stats['inactive'] ?? 0 }}</h5>
                    <small class="text-muted">Inactive</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-2">
            <div class="card bg-info-subtle border-0">
                <div class="card-body text-center py-3">
                    <h5 class="mb-0 text-info fw-bold">{{ $stats['parents'] ?? 0 }}</h5>
                    <small class="text-muted">Parents</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-2">
            <div class="card bg-dark-subtle border-0">
                <div class="card-body text-center py-3">
                    <h5 class="mb-0 text-dark fw-bold">{{ $stats['hidden'] ?? 0 }}</h5>
                    <small class="text-muted">Hidden</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.categories.index') }}" class="row g-3">
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
                        <input type="text" name="search" class="form-control"
                               placeholder="Search categories..."
                               value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="hidden" {{ request('status') === 'hidden' ? 'selected' : '' }}>Hidden</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="parent" class="form-select">
                        <option value="">All Levels</option>
                        <option value="0" {{ request('parent') === '0' ? 'selected' : '' }}>Top Level</option>
                        @foreach($parentCategories as $parent)
                            <option value="{{ $parent->id }}" {{ request('parent') == $parent->id ? 'selected' : '' }}>
                                {{ $parent->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="featured" class="form-select">
                        <option value="">All Types</option>
                        <option value="1" {{ request('featured') === '1' ? 'selected' : '' }}>Featured</option>
                        <option value="0" {{ request('featured') === '0' ? 'selected' : '' }}>Not Featured</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="per_page" class="form-select">
                        <option value="15" {{ request('per_page') == 15 ? 'selected' : '' }}>15 per page</option>
                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 per page</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 per page</option>
                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100 per page</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-outline-primary w-100">
                        <i class="fas fa-filter"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Bulk Actions --}}
    <div class="d-none" id="bulkActions">
        <div class="alert alert-info d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
            <span><i class="fas fa-check-circle me-2"></i><strong id="selectedCount">0</strong> selected</span>
            <div class="d-flex gap-2">
                <select class="form-select form-select-sm" id="bulkStatusSelect" style="width: 140px;">
                    <option value="">Change Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                    <option value="draft">Draft</option>
                    <option value="hidden">Hidden</option>
                </select>
                <button type="button" class="btn btn-sm btn-warning" onclick="bulkUpdateStatus()">
                    <i class="fas fa-check-circle me-1"></i> Apply
                </button>
                <button type="button" class="btn btn-sm btn-danger" onclick="bulkDelete()">
                    <i class="fas fa-trash me-1"></i> Delete
                </button>
            </div>
        </div>
    </div>

    {{-- Categories Table --}}
    <div class="card">
        <div class="card-body p-0">
            @if($categories->count() > 0)
                <form id="bulkForm" method="POST" action="{{ route('admin.categories.bulk-delete') }}">
                    @csrf
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 ps-4" style="width: 40px;">
                                        <input type="checkbox" class="form-check-input" id="selectAll">
                                    </th>
                                    <th class="border-0">Category</th>
                                    <th class="border-0 d-none d-md-table-cell">Code</th>
                                    <th class="border-0 d-none d-lg-table-cell">Parent</th>
                                    <th class="border-0 text-center">Products</th>
                                    <th class="border-0 text-center d-none d-xl-table-cell">Sort</th>
                                    <th class="border-0 text-center">Status</th>
                                    <th class="border-0 text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $category)
                                    <tr>
                                        <td class="ps-4">
                                            <input type="checkbox" name="ids[]" value="{{ $category->id }}"
                                                   class="form-check-input row-checkbox">
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($category->thumbnail)
                                                    <img src="{{ $category->thumbnail_url }}" alt="{{ $category->name }}"
                                                         class="rounded me-3" style="width: 44px; height: 44px; object-fit: cover;" loading="lazy">
                                                @elseif($category->image)
                                                    <img src="{{ $category->image_url }}" alt="{{ $category->name }}"
                                                         class="rounded me-3" style="width: 44px; height: 44px; object-fit: cover;" loading="lazy">
                                                @else
                                                    <div class="rounded me-3 d-flex align-items-center justify-content-center bg-light"
                                                         style="width: 44px; height: 44px;">
                                                        <i class="fas fa-folder text-muted"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <span class="fw-semibold">
                                                        <a href="{{ route('admin.categories.show', $category->id) }}" class="text-decoration-none text-dark">
                                                            {{ $category->name }}
                                                        </a>
                                                    </span>
                                                    <small class="d-block text-muted">
                                                        <code class="small">{{ $category->slug }}</code>
                                                        @if($category->children_count > 0)
                                                            <span class="ms-2"><i class="fas fa-level-down-alt me-1"></i>{{ $category->children_count }} children</span>
                                                        @endif
                                                    </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="d-none d-md-table-cell">
                                            @if($category->category_code)
                                                <span class="badge bg-light text-dark border">{{ $category->category_code }}</span>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                        <td class="d-none d-lg-table-cell">
                                            @if($category->parent)
                                                <a href="{{ route('admin.categories.show', $category->parent->id) }}" class="text-decoration-none">
                                                    {{ $category->parent->name }}
                                                </a>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-primary bg-opacity-10 text-primary">
                                                {{ $category->products_count }}
                                            </span>
                                        </td>
                                        <td class="text-center d-none d-xl-table-cell">
                                            <input type="number" class="form-control form-control-sm text-center sort-input"
                                                   value="{{ $category->sort_order }}" style="width: 65px;"
                                                   data-id="{{ $category->id }}" min="0">
                                        </td>
                                        <td class="text-center">
                                            <x-admin.category.status-badge :status="$category->status" />
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="btn-group">
                                                <a href="{{ route('admin.categories.show', $category->id) }}"
                                                   class="btn btn-sm btn-outline-secondary" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.categories.edit', $category->id) }}"
                                                   class="btn btn-sm btn-outline-primary" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-outline-info"
                                                        onclick="duplicateCategory({{ $category->id }})" title="Duplicate">
                                                    <i class="fas fa-copy"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-danger"
                                                        onclick="confirmDelete({{ $category->id }}, '{{ addslashes($category->name) }}')" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </form>

                <div class="d-flex justify-content-between align-items-center px-4 py-3 border-top">
                    <div class="text-muted small">
                        Showing {{ $categories->firstItem() }} to {{ $categories->lastItem() }} of {{ $categories->total() }} entries
                    </div>
                    <div>
                        {{ $categories->appends(request()->query())->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                    <h5>No categories found</h5>
                    <p class="text-muted">
                        @if(request()->anyFilled(['search', 'status', 'parent', 'featured']))
                            No categories match your filters. <a href="{{ route('admin.categories.index') }}">Clear filters</a>
                        @else
                            Get started by creating your first category.
                        @endif
                    </p>
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Add Category
                    </a>
                </div>
            @endif
        </div>
    </div>

</x-layouts.admin-layout>

{{-- Delete Confirmation Modal --}}
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete <strong id="deleteName"></strong>?</p>
                <div id="deleteWarning" class="alert alert-warning d-none">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <span id="deleteWarningText"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-1"></i> Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    $('#selectAll').change(function() {
        $('.row-checkbox').prop('checked', $(this).prop('checked'));
        updateBulkActions();
    });

    $('.row-checkbox').change(function() {
        updateBulkActions();
    });

    function updateBulkActions() {
        const checked = $('.row-checkbox:checked').length;
        if (checked > 0) {
            $('#bulkActions').removeClass('d-none');
            $('#selectedCount').text(checked);
        } else {
            $('#bulkActions').addClass('d-none');
        }
    }

    $('.sort-input').change(function() {
        const id = $(this).data('id');
        const sortOrder = $(this).val();

        $.ajax({
            url: '{{ route('admin.categories.update-sort') }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                items: [{ id: id, sort_order: sortOrder }]
            },
            success: function(response) {
                if (response.success) {
                    showToast(response.message, 'success');
                }
            },
            error: function() {
                showToast('Failed to update sort order', 'error');
            }
        });
    });
});

function confirmDelete(id, name) {
    $('#deleteName').text(name);
    $('#deleteForm').attr('action', `/admin/categories/${id}`);
    $('#deleteWarning').addClass('d-none');

    $.get(`/admin/categories/${id}/check-deletable`, function(data) {
        if (!data.deletable) {
            let warnings = [];
            if (data.has_children) warnings.push(`${data.children_count} subcategory(ies)`);
            if (data.has_products) warnings.push(`${data.product_count} product(s)`);
            $('#deleteWarningText').text('Cannot delete: has ' + warnings.join(' and ') + '. Remove them first.');
            $('#deleteWarning').removeClass('d-none');
            $('#deleteForm button[type="submit"]').prop('disabled', true);
        } else {
            $('#deleteForm button[type="submit"]').prop('disabled', false);
        }
    });

    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}

function bulkDelete() {
    const ids = $('.row-checkbox:checked').map(function() { return $(this).val(); }).get();
    if (!ids.length) return;

    if (confirm('Are you sure you want to delete ' + ids.length + ' selected categories?')) {
        $('#bulkForm').attr('action', '{{ route('admin.categories.bulk-delete') }}').submit();
    }
}

function bulkUpdateStatus() {
    const ids = $('.row-checkbox:checked').map(function() { return $(this).val(); }).get();
    const status = $('#bulkStatusSelect').val();
    if (!ids.length || !status) return;

    if (confirm('Change status of ' + ids.length + ' categories to "' + status + '"?')) {
        $('<form>').attr({ method: 'POST', action: '{{ route('admin.categories.bulk-update-status') }}' })
            .append($('<input>').attr({ type: 'hidden', name: '_token', value: '{{ csrf_token() }}' }))
            .append($('<input>').attr({ type: 'hidden', name: 'status', value: status }))
            .append(ids.map(function(id) {
                return $('<input>').attr({ type: 'hidden', name: 'ids[]', value: id });
            }))
            .appendTo('body').submit();
    }
}

function duplicateCategory(id) {
    $('<form>').attr({ method: 'POST', action: `/admin/categories/${id}/duplicate` })
        .append($('<input>').attr({ type: 'hidden', name: '_token', value: '{{ csrf_token() }}' }))
        .appendTo('body').submit();
}

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
