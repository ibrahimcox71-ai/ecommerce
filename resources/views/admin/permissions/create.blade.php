<x-layouts.admin-layout title="Create Permission">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Create Permission</h4>
            <p class="text-muted small mb-0">Add a new system permission</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.permissions.store') }}">
        @csrf

        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="form-outline">
                            <select name="group" id="group" class="form-select @error('group') is-invalid @enderror" required>
                                <option value="">Select Group</option>
                                @foreach($groups as $group)
                                    <option value="{{ $group->value }}" {{ old('group') === $group->value ? 'selected' : '' }}>
                                        {{ $group->label() }}
                                    </option>
                                @endforeach
                            </select>
                            <label class="form-label" for="group">Permission Group</label>
                        </div>
                        @error('group')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <div class="form-outline">
                            <select name="type" id="type" class="form-select @error('type') is-invalid @enderror" required>
                                <option value="">Select Type</option>
                                @foreach($types as $type)
                                    <option value="{{ $type }}" {{ old('type') === $type ? 'selected' : '' }}>
                                        {{ ucfirst($type) }}
                                    </option>
                                @endforeach
                            </select>
                            <label class="form-label" for="type">Permission Type</label>
                        </div>
                        @error('type')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <div class="form-outline">
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}" readonly placeholder="Auto-generated">
                            <label class="form-label" for="name">Permission Name</label>
                        </div>
                        @error('name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Create Permission
                </button>
                <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </div>
    </form>

</x-layouts.admin-layout>

@push('scripts')
<script>
$(document).ready(function() {
    $('#group, #type').change(function() {
        const group = $('#group').val();
        const type = $('#type').val();
        if (group && type) {
            $('#name').val(group + '.' + type);
        } else {
            $('#name').val('');
        }
    });
});
</script>
@endpush
