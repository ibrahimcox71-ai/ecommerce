<x-layouts.admin-layout title="Edit Permission">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Edit Permission</h4>
            <p class="text-muted small mb-0">Modify permission name</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.permissions.update', $permission->id) }}">
        @csrf
        @method('PUT')

        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-outline">
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $permission->name) }}" required>
                            <label class="form-label" for="name">Permission Name</label>
                        </div>
                        @error('name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                        <div class="text-muted small mt-1">
                            Format: <code>group.type</code> (e.g., <code>products.create</code>)
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Update Permission
                </button>
                <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </div>
    </form>

</x-layouts.admin-layout>
