<x-layouts.admin-layout title="Create User">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Create Admin User</h4>
            <p class="text-muted small mb-0">Add a new administrator to the system</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf

        <div class="card mb-4">
            <div class="card-header">
                <h6 class="fw-bold mb-0">Account Information</h6>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-outline">
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}" required>
                            <label class="form-label" for="name">Full Name</label>
                        </div>
                        @error('name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <div class="form-outline">
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}" required>
                            <label class="form-label" for="email">Email Address</label>
                        </div>
                        @error('email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-outline">
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
                            <label class="form-label" for="password">Password</label>
                        </div>
                        @error('password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <div class="form-outline">
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                            <label class="form-label" for="password_confirmation">Confirm Password</label>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-outline">
                            <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror"
                                   value="{{ old('phone') }}">
                            <label class="form-label" for="phone">Phone Number</label>
                        </div>
                        @error('phone')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <div class="form-check mt-4">
                            <input type="checkbox" name="status" class="form-check-input" id="status" value="1" checked>
                            <label class="form-check-label" for="status">Active</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h6 class="fw-bold mb-0">Roles</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($roles as $role)
                        <div class="col-md-3 col-sm-4 mb-2">
                            <div class="form-check">
                                <input type="checkbox" name="roles[]" value="{{ $role->id }}"
                                       class="form-check-input" id="role_{{ $role->id }}"
                                    {{ in_array($role->id, old('roles', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="role_{{ $role->id }}">
                                    {{ ucfirst($role->name) }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
                @error('roles')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0">Direct Permissions</h6>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="selectAllPermissions">
                    <label class="form-check-label" for="selectAllPermissions">Select All</label>
                </div>
            </div>
            <div class="card-body">
                @if(count($groupedPermissions) > 0)
                    @foreach($groupedPermissions as $group)
                        <div class="mb-3">
                            <h6 class="text-muted text-uppercase small fw-semibold">{{ $group['group']->label() }}</h6>
                            <div class="row">
                                @foreach($group['permissions'] as $permission)
                                    <div class="col-md-3 col-sm-4 mb-1">
                                        <div class="form-check">
                                            <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                                   class="form-check-input permission-checkbox"
                                                   id="perm_{{ $permission->id }}"
                                                {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label small" for="perm_{{ $permission->id }}">
                                                {{ str_replace($group['group']->value . '.', '', $permission->name) }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted mb-0">No permissions available.</p>
                @endif
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-1"></i> Create User
            </button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>

</x-layouts.admin-layout>

@push('scripts')
<script>
$(document).ready(function() {
    $('#selectAllPermissions').change(function() {
        $('.permission-checkbox').prop('checked', $(this).prop('checked'));
    });
});
</script>
@endpush
