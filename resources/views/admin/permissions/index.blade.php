<x-layouts.admin-layout title="Permissions">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Permissions</h4>
            <p class="text-muted small mb-0">Manage system permissions for all roles</p>
        </div>
        <div class="d-flex gap-2">
            @can('permissions.manage')
                <a href="{{ route('admin.permissions.generate') }}" class="btn btn-outline-warning"
                   onclick="return confirm('Generate all system permissions? This may create new permissions.')">
                    <i class="fas fa-sync me-1"></i> Generate All
                </a>
            @endcan
            @can('permissions.create')
                <a href="{{ route('admin.permissions.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i> Add Permission
                </a>
            @endcan
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.permissions.index') }}" class="row g-3">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
                        <input type="text" name="search" class="form-control"
                               placeholder="Search permissions..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="group" class="form-select">
                        <option value="">All Groups</option>
                        @foreach($grouped as $g)
                            <option value="{{ $g['group']->value }}" {{ request('group') === $g['group']->value ? 'selected' : '' }}>
                                {{ $g['group']->label() }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-outline-primary w-100">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @if($permissions->count() > 0)
                <form id="bulkForm" method="POST" action="{{ route('admin.permissions.bulk-delete') }}">
                    @csrf
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    @can('permissions.delete')
                                        <th class="border-0" style="width: 40px;">
                                            <input type="checkbox" class="form-check-input" id="selectAll">
                                        </th>
                                    @endcan
                                    <th class="border-0">Permission</th>
                                    <th class="border-0">Group</th>
                                    <th class="border-0">Type</th>
                                    <th class="border-0">Guard</th>
                                    <th class="border-0 text-end" style="width: 120px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($permissions as $permission)
                                    @php
                                        $parts = explode('.', $permission->name);
                                        $group = $parts[0] ?? '';
                                        $type = $parts[1] ?? '';
                                    @endphp
                                    <tr>
                                        @can('permissions.delete')
                                            <td>
                                                <input type="checkbox" name="ids[]" value="{{ $permission->id }}"
                                                       class="form-check-input row-checkbox">
                                            </td>
                                        @endcan
                                        <td>
                                            <code>{{ $permission->name }}</code>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary">{{ $group }}</span>
                                        </td>
                                        <td>
                                            @php
                                                $typeColors = [
                                                    'view' => 'info', 'create' => 'success', 'edit' => 'primary',
                                                    'delete' => 'danger', 'restore' => 'warning', 'export' => 'secondary',
                                                    'import' => 'dark', 'approve' => 'success', 'reject' => 'danger',
                                                    'publish' => 'success', 'unpublish' => 'warning', 'manage' => 'dark',
                                                ];
                                                $color = $typeColors[$type] ?? 'secondary';
                                            @endphp
                                            <span class="badge bg-{{ $color }}">{{ $type }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark">{{ $permission->guard_name }}</span>
                                        </td>
                                        <td class="text-end">
                                            <div class="btn-group">
                                                @can('permissions.edit')
                                                    <a href="{{ route('admin.permissions.edit', $permission->id) }}"
                                                       class="btn btn-sm btn-outline-primary" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @endcan
                                                @can('permissions.delete')
                                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                                            onclick="confirmDelete({{ $permission->id }}, '{{ $permission->name }}')" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </form>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted small">
                        Showing {{ $permissions->firstItem() }} to {{ $permissions->lastItem() }} of {{ $permissions->total() }} entries
                    </div>
                    <div>{{ $permissions->links() }}</div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-lock fa-3x text-muted mb-3"></i>
                    <h5>No permissions found</h5>
                    <p class="text-muted">
                        @if(request()->anyFilled(['search', 'group']))
                            No permissions match your filters. <a href="{{ route('admin.permissions.index') }}">Clear filters</a>
                        @else
                            No permissions exist. Generate them first.
                        @endif
                    </p>
                    @can('permissions.manage')
                        <a href="{{ route('admin.permissions.generate') }}" class="btn btn-warning">
                            <i class="fas fa-sync me-1"></i> Generate All Permissions
                        </a>
                    @endcan
                </div>
            @endif
        </div>
    </div>

</x-layouts.admin-layout>

<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Permission</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete <strong id="deleteName"></strong>?</p>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    This will remove the permission from all roles.
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
    });
});

function confirmDelete(id, name) {
    $('#deleteName').text(name);
    $('#deleteForm').attr('action', `/admin/permissions/${id}`);
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>
@endpush
