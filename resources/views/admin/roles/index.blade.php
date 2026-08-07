<x-layouts.admin-layout title="Roles">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Roles</h4>
            <p class="text-muted small mb-0">Manage user roles and their permissions</p>
        </div>
        <div class="d-flex gap-2">
            @can('roles.create')
                <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i> Add Role
                </a>
            @endcan
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @if($roles->count() > 0)
                <form id="bulkForm" method="POST" action="{{ route('admin.roles.bulk-delete') }}">
                    @csrf
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    @can('roles.delete')
                                        <th class="border-0" style="width: 40px;">
                                            <input type="checkbox" class="form-check-input" id="selectAll">
                                        </th>
                                    @endcan
                                    <th class="border-0">Role Name</th>
                                    <th class="border-0 text-center">Users</th>
                                    <th class="border-0 text-center">Permissions</th>
                                    <th class="border-0 text-center">Guard</th>
                                    <th class="border-0 text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($roles as $role)
                                    <tr>
                                        @can('roles.delete')
                                            <td>
                                                @if($role->name !== 'super-admin')
                                                    <input type="checkbox" name="ids[]" value="{{ $role->id }}"
                                                           class="form-check-input row-checkbox">
                                                @endif
                                            </td>
                                        @endcan
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle d-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary me-3"
                                                     style="width: 40px; height: 40px;">
                                                    <i class="fas fa-shield-alt"></i>
                                                </div>
                                                <div>
                                                    <span class="fw-semibold">{{ ucfirst($role->name) }}</span>
                                                    @if($role->name === 'super-admin')
                                                        <span class="badge bg-warning ms-2">Full Access</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-info">{{ $role->users_count ?? 0 }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-primary">{{ $role->permissions_count ?? $role->permissions->count() }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-secondary">{{ $role->guard_name }}</span>
                                        </td>
                                        <td class="text-end">
                                            <div class="btn-group">
                                                @can('roles.view')
                                                    <a href="{{ route('admin.roles.show', $role->id) }}"
                                                       class="btn btn-sm btn-outline-secondary" title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                @endcan
                                                @can('roles.edit')
                                                    <a href="{{ route('admin.roles.edit', $role->id) }}"
                                                       class="btn btn-sm btn-outline-primary" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @endcan
                                                @can('roles.delete')
                                                    @if($role->name !== 'super-admin')
                                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                                                onclick="confirmDelete({{ $role->id }}, '{{ $role->name }}')" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    @endif
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
                        Showing {{ $roles->firstItem() }} to {{ $roles->lastItem() }} of {{ $roles->total() }} entries
                    </div>
                    <div>{{ $roles->links() }}</div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-shield-alt fa-3x text-muted mb-3"></i>
                    <h5>No roles found</h5>
                    <p class="text-muted">Get started by creating your first role.</p>
                    <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Add Role
                    </a>
                </div>
            @endif
        </div>
    </div>

</x-layouts.admin-layout>

<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete <strong id="deleteName"></strong>?</p>
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
});

function confirmDelete(id, name) {
    $('#deleteName').text(name);
    $('#deleteForm').attr('action', `/admin/roles/${id}`);
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>
@endpush
