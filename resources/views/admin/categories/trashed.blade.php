<x-layouts.admin-layout title="Trashed Categories">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Trashed Categories</h4>
            <p class="text-muted small mb-0">Deleted categories can be restored or permanently removed</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.categories.tree') }}" class="btn btn-outline-secondary">
                <i class="fas fa-sitemap me-1"></i> Tree View
            </a>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to Categories
            </a>
        </div>
    </div>

    {{-- Search --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.categories.trashed') }}" class="row g-3">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
                        <input type="text" name="search" class="form-control"
                               placeholder="Search trashed categories..."
                               value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-outline-primary me-2">Search</button>
                    <a href="{{ route('admin.categories.trashed') }}" class="btn btn-outline-secondary">Clear</a>
                </div>
            </form>
        </div>
    </div>

    {{-- Bulk Actions --}}
    <div class="d-none" id="bulkActions">
        <div class="alert alert-info d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
            <span><i class="fas fa-check-circle me-2"></i><strong id="selectedCount">0</strong> selected</span>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-sm btn-success" onclick="bulkRestore()">
                    <i class="fas fa-undo me-1"></i> Restore Selected
                </button>
                <button type="button" class="btn btn-sm btn-danger" onclick="bulkForceDelete()">
                    <i class="fas fa-trash-alt me-1"></i> Delete Permanently
                </button>
            </div>
        </div>
    </div>

    {{-- Trashed Categories Table --}}
    <div class="card">
        <div class="card-body p-0">
            @if($categories->count() > 0)
                <form id="bulkForm" method="POST" action="{{ route('admin.categories.bulk-restore') }}">
                    @csrf
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 ps-4" style="width: 40px;">
                                        <input type="checkbox" class="form-check-input" id="selectAll">
                                    </th>
                                    <th class="border-0">Category</th>
                                    <th class="border-0 d-none d-md-table-cell">Parent</th>
                                    <th class="border-0 d-none d-lg-table-cell">Deleted At</th>
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
                                                @if($category->image)
                                                    <img src="{{ $category->image_url }}" alt="{{ $category->name }}"
                                                         class="rounded me-3" style="width: 44px; height: 44px; object-fit: cover; opacity: 0.6;" loading="lazy">
                                                @else
                                                    <div class="rounded me-3 d-flex align-items-center justify-content-center bg-light"
                                                         style="width: 44px; height: 44px; opacity: 0.6;">
                                                        <i class="fas fa-folder text-muted"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <span class="fw-semibold text-muted">{{ $category->name }}</span>
                                                    <small class="d-block text-muted">
                                                        <code class="small">{{ $category->slug }}</code>
                                                    </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="d-none d-md-table-cell">
                                            @if($category->parent)
                                                <span class="badge bg-secondary">{{ $category->parent->name }}</span>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                        <td class="d-none d-lg-table-cell">
                                            <span class="text-muted small">
                                                {{ $category->deleted_at->format('M d, Y H:i') }}
                                                <br>
                                                <small>{{ $category->deleted_at->diffForHumans() }}</small>
                                            </span>
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="btn-group">
                                                <form action="{{ route('admin.categories.restore', $category->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success" title="Restore">
                                                        <i class="fas fa-undo"></i>
                                                    </button>
                                                </form>
                                                <button type="button" class="btn btn-sm btn-outline-danger"
                                                        onclick="confirmForceDelete({{ $category->id }}, '{{ addslashes($category->name) }}')" title="Delete Permanently">
                                                    <i class="fas fa-trash-alt"></i>
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
                        Showing {{ $categories->firstItem() ?? 0 }} to {{ $categories->lastItem() ?? 0 }} of {{ $categories->total() }} entries
                    </div>
                    <div>
                        {{ $categories->appends(request()->query())->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-trash-alt fa-3x text-muted mb-3"></i>
                    <h5>No trashed categories</h5>
                    <p class="text-muted">
                        @if(request()->has('search'))
                            No trashed categories match your search. <a href="{{ route('admin.categories.trashed') }}">Clear search</a>
                        @else
                            Trashed categories will appear here
                        @endif
                    </p>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-primary">
                        <i class="fas fa-folder me-1"></i> View Active Categories
                    </a>
                </div>
            @endif
        </div>
    </div>

</x-layouts.admin-layout>

{{-- Force Delete Modal --}}
<div class="modal fade" id="forceDeleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Permanently Delete Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Warning:</strong> This action cannot be undone!
                </div>
                <p>Are you sure you want to permanently delete <strong id="forceDeleteName"></strong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="forceDeleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash-alt me-1"></i> Delete Permanently
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
});

function confirmForceDelete(id, name) {
    $('#forceDeleteName').text(name);
    $('#forceDeleteForm').attr('action', `/admin/categories/${id}/force-delete`);
    new bootstrap.Modal(document.getElementById('forceDeleteModal')).show();
}

function bulkRestore() {
    if (confirm('Restore selected categories?')) {
        $('#bulkForm').attr('action', '{{ route('admin.categories.bulk-restore') }}').submit();
    }
}

function bulkForceDelete() {
    if (confirm('Permanently delete selected categories? This cannot be undone!')) {
        $('#bulkForm').attr('action', '{{ route('admin.categories.bulk-force-delete') }}').attr('method', 'POST').submit();
    }
}
</script>
@endpush
