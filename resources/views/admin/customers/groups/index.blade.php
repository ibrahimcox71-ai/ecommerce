<x-layouts.admin-layout title="Customer Groups">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Customer Groups</h4>
            <p class="text-muted small mb-0">Organize customers into groups for segmentation</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.customers.groups.trashed') }}" class="btn btn-outline-secondary">
                <i class="fas fa-trash-alt me-1"></i> Trashed
                @if(($stats['trashed'] ?? 0) > 0)
                    <span class="badge bg-danger ms-1">{{ $stats['trashed'] }}</span>
                @endif
            </a>
            <a href="{{ route('admin.customers.groups.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Add Group
            </a>
            <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.customers.groups.index') }}" class="row g-3">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
                        <input type="text" name="search" class="form-control" placeholder="Search groups..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="per_page" class="form-select">
                        <option value="15" {{ request('per_page') == 15 ? 'selected' : '' }}>15 per page</option>
                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 per page</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 per page</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-outline-primary w-100">
                        <i class="fas fa-filter"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-0">
            @if($groups->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0 ps-4" style="width: 40px;">
                                    <input type="checkbox" class="form-check-input" id="selectAll">
                                </th>
                                <th class="border-0">Name</th>
                                <th class="border-0 d-none d-md-table-cell">Description</th>
                                <th class="border-0 text-center">Customers</th>
                                <th class="border-0 text-center">Sort</th>
                                <th class="border-0 text-center">Status</th>
                                <th class="border-0 text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($groups as $group)
                                <tr>
                                    <td class="ps-4">
                                        <input type="checkbox" class="form-check-input row-checkbox" value="{{ $group->id }}">
                                    </td>
                                    <td>
                                        <span class="fw-semibold">{{ $group->name }}</span>
                                    </td>
                                    <td class="d-none d-md-table-cell">
                                        <span class="small text-muted">{{ Str::limit($group->description, 60) ?: '—' }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-primary bg-opacity-10 text-primary">{{ $group->customers_count }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="small">{{ $group->sort_order }}</span>
                                    </td>
                                    <td class="text-center">
                                        @if($group->status)
                                            <span class="badge bg-success bg-opacity-10 text-success">
                                                <i class="fas fa-check-circle me-1"></i>Active
                                            </span>
                                        @else
                                            <span class="badge bg-secondary bg-opacity-10 text-secondary">
                                                <i class="fas fa-pause-circle me-1"></i>Inactive
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group">
                                            <a href="{{ route('admin.customers.groups.edit', $group->id) }}"
                                               class="btn btn-sm btn-outline-primary" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-success"
                                                    onclick="toggleStatus({{ $group->id }})" title="Toggle Status">
                                                <i class="fas fa-{{ $group->status ? 'pause' : 'play' }}"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-danger"
                                                    onclick="confirmDelete({{ $group->id }}, '{{ addslashes($group->name) }}')" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center px-4 py-3 border-top">
                    <div class="text-muted small">
                        Showing {{ $groups->firstItem() }} to {{ $groups->lastItem() }} of {{ $groups->total() }} entries
                    </div>
                    <div>
                        {{ $groups->appends(request()->query())->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-layer-group fa-3x text-muted mb-3"></i>
                    <h5>No groups found</h5>
                    <p class="text-muted">Create your first customer group to start segmenting customers.</p>
                    <a href="{{ route('admin.customers.groups.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Add Group
                    </a>
                </div>
            @endif
        </div>
    </div>

</x-layouts.admin-layout>

{{-- Delete Modal --}}
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Group</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete <strong id="deleteName"></strong>?</p>
                <p class="text-muted small">Groups with customers cannot be deleted. Reassign customers first.</p>
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
    });
});

function confirmDelete(id, name) {
    $('#deleteName').text(name);
    $('#deleteForm').attr('action', `/admin/customers/groups/${id}`);
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}

function toggleStatus(id) {
    $.ajax({
        url: `/admin/customers/groups/${id}/toggle-status`,
        type: 'POST',
        data: { _token: '{{ csrf_token() }}' },
        success: function(response) {
            if (response.success) location.reload();
        }
    });
}
</script>
@endpush
