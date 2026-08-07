<x-layouts.admin-layout title="Edit Role">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Edit Role: {{ ucfirst($role->name) }}</h4>
            <p class="text-muted small mb-0">Modify role permissions</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.roles.update', $role->id) }}">
        @csrf
        @method('PUT')

        <div class="card mb-4">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-outline">
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $role->name) }}" required placeholder="e.g., editor"
                                   @if($role->name === 'super-admin') readonly @endif>
                            <label class="form-label" for="name">Role Name</label>
                        </div>
                        @error('name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0">Permissions</h6>
                @if($role->name !== 'super-admin')
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="selectAllPermissions">
                        <label class="form-check-label fw-semibold" for="selectAllPermissions">Select All</label>
                    </div>
                @endif
            </div>
            <div class="card-body">
                @if($role->name === 'super-admin')
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i> Super Admin has full access to all permissions automatically.
                    </div>
                @elseif(count($groupedPermissions) > 0)
                    @foreach($groupedPermissions as $group)
                        <div class="mb-4">
                            <div class="d-flex align-items-center mb-2">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input group-select"
                                           data-group="{{ $group['group']->value }}" id="group_{{ $group['group']->value }}">
                                    <label class="form-check-label fw-semibold" for="group_{{ $group['group']->value }}">
                                        {{ $group['group']->label() }}
                                    </label>
                                </div>
                            </div>
                            <div class="row ms-4">
                                @foreach($group['permissions'] as $permission)
                                    <div class="col-md-3 col-sm-4 mb-1">
                                        <div class="form-check">
                                            <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                                   class="form-check-input permission-checkbox"
                                                   data-group="{{ $group['group']->value }}"
                                                   id="perm_{{ $permission->id }}"
                                                {{ in_array($permission->name, $rolePermissions) ? 'checked' : '' }}>
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
                    <div class="text-center py-4">
                        <p class="text-muted mb-0">No permissions found. Run the permission seeder first.</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-1"></i> Update Role
            </button>
            <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>

</x-layouts.admin-layout>

@push('scripts')
<script>
$(document).ready(function() {
    updateSelectAll();

    $('#selectAllPermissions').change(function() {
        $('.permission-checkbox').prop('checked', $(this).prop('checked'));
        $('.group-select').prop('checked', $(this).prop('checked'));
    });

    $('.group-select').change(function() {
        const group = $(this).data('group');
        $(`.permission-checkbox[data-group="${group}"]`).prop('checked', $(this).prop('checked'));
        updateSelectAll();
    });

    $('.permission-checkbox').change(function() {
        const group = $(this).data('group');
        const groupCheckboxes = $(`.permission-checkbox[data-group="${group}"]`);
        const checked = groupCheckboxes.filter(':checked').length;
        $(`.group-select[data-group="${group}"]`).prop('checked', checked === groupCheckboxes.length);
        updateSelectAll();
    });

    function updateSelectAll() {
        const total = $('.permission-checkbox').length;
        const checked = $('.permission-checkbox:checked').length;
        $('#selectAllPermissions').prop('checked', total > 0 && total === checked);
    }
});
</script>
@endpush
