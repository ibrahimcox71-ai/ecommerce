<x-layouts.admin-layout title="Users">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Admin Users</h4>
            <p class="text-muted small mb-0">Manage system administrators and their roles</p>
        </div>
        <div class="d-flex gap-2">
            @can('users.create')
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i> Add User
                </a>
            @endcan
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.users.index') }}" class="row g-3">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
                        <input type="text" name="search" class="form-control"
                               placeholder="Search by name or email..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="role" class="form-select">
                        <option value="">All Roles</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}" {{ request('role') === $role->name ? 'selected' : '' }}>
                                {{ ucfirst($role->name) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactive</option>
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
            @if($users->count() > 0)
                <form id="bulkForm" method="POST" action="{{ route('admin.users.bulk-delete') }}">
                    @csrf
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    @can('users.delete')
                                        <th class="border-0" style="width: 40px;">
                                            <input type="checkbox" class="form-check-input" id="selectAll">
                                        </th>
                                    @endcan
                                    <th class="border-0">User</th>
                                    <th class="border-0">Email</th>
                                    <th class="border-0">Roles</th>
                                    <th class="border-0 text-center">Last Login</th>
                                    <th class="border-0 text-center">Status</th>
                                    <th class="border-0 text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        @can('users.delete')
                                            <td>
                                                @if(!$user->hasRole('super-admin'))
                                                    <input type="checkbox" name="ids[]" value="{{ $user->id }}"
                                                           class="form-check-input row-checkbox">
                                                @endif
                                            </td>
                                        @endcan
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($user->avatar)
                                                    <img src="{{ Storage::url($user->avatar) }}" alt="{{ $user->name }}"
                                                         class="rounded-circle me-3" style="width: 40px; height: 40px; object-fit: cover;">
                                                @else
                                                    <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center me-3"
                                                         style="width: 40px; height: 40px; font-weight: 600;">
                                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                                    </div>
                                                @endif
                                                <div>
                                                    <span class="fw-semibold">{{ $user->name }}</span>
                                                    <small class="d-block text-muted">
                                                        {{ $user->phone ?: 'No phone' }}
                                                    </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @foreach($user->roles as $role)
                                                <span class="badge bg-{{ $role->name === 'super-admin' ? 'warning' : 'primary' }} bg-opacity-10 text-{{ $role->name === 'super-admin' ? 'warning' : 'primary' }} me-1">
                                                    {{ ucfirst($role->name) }}
                                                </span>
                                            @endforeach
                                        </td>
                                        <td class="text-center">
                                            @if($user->latestLoginHistory)
                                                <small class="text-muted">
                                                    {{ $user->latestLoginHistory->login_at?->diffForHumans() ?? 'Never' }}
                                                </small>
                                            @else
                                                <span class="text-muted">Never</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="form-check form-switch d-flex justify-content-center">
                                                <input type="checkbox" class="form-check-input status-toggle"
                                                       role="switch" data-id="{{ $user->id }}"
                                                       {{ $user->status ? 'checked' : '' }}
                                                       @if($user->hasRole('super-admin') && $user->id !== auth('admin')->id()) disabled @endif>
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <div class="btn-group">
                                                @can('users.view')
                                                    <a href="{{ route('admin.users.show', $user->id) }}"
                                                       class="btn btn-sm btn-outline-secondary" title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                @endcan
                                                @can('users.edit')
                                                    <a href="{{ route('admin.users.edit', $user->id) }}"
                                                       class="btn btn-sm btn-outline-primary" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @endcan
                                                @can('users.delete')
                                                    @if(!$user->hasRole('super-admin'))
                                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                                                onclick="confirmDelete({{ $user->id }}, '{{ $user->name }}')" title="Delete">
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
                        Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} entries
                    </div>
                    <div>{{ $users->links() }}</div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-users fa-3x text-muted mb-3"></i>
                    <h5>No users found</h5>
                    <p class="text-muted">
                        @if(request()->anyFilled(['search', 'role', 'status']))
                            No users match your filters. <a href="{{ route('admin.users.index') }}">Clear filters</a>
                        @else
                            Get started by creating your first admin user.
                        @endif
                    </p>
                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Add User
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
                <h5 class="modal-title">Delete User</h5>
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
    });

    $('.status-toggle').change(function() {
        const id = $(this).data('id');
        const status = $(this).prop('checked');

        $.ajax({
            url: `/admin/users/${id}/toggle-status`,
            type: 'POST',
            data: { _token: '{{ csrf_token() }}' },
            success: function(response) {
                if (response.success) {
                    showToast(response.message, 'success');
                }
            },
            error: function() {
                showToast('An error occurred', 'error');
            }
        });
    });
});

function confirmDelete(id, name) {
    $('#deleteName').text(name);
    $('#deleteForm').attr('action', `/admin/users/${id}`);
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
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
    $('.toast').toast('show');
    setTimeout(() => $('.toast').parent().remove(), 3000);
}
</script>
@endpush
