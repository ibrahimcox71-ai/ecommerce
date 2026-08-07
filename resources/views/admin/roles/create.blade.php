<x-layouts.admin-layout title="Create Role">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Create Role</h4>
            <p class="text-muted small mb-0">Define a new role and assign permissions</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.roles.store') }}">
        @csrf

        <div class="card mb-4">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-outline">
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}" required placeholder="e.g., editor">
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
            <div class="card-header">
                <h6 class="fw-bold mb-0">Permissions</h6>
            </div>
            <div class="card-body">
                @if(count($groupedPermissions) > 0)
                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="selectAllPermissions">
                            <label class="form-check-label fw-semibold" for="selectAllPermissions">Select All Permissions</label>
                        </div>
                    </div>
                    <hr>

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
                    <div class="text-center py-4">
                        <p class="text-muted mb-0">No permissions found. Run the permission seeder first.</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-1"></i> Create Role
            </button>
            <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>

</x-layouts.admin-layout>

@push('scripts')
<script>
$(document).ready(function() {
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
        $('#selectAllPermissions').prop('checked', total === checked);
    }
});
</script>
@endpush
