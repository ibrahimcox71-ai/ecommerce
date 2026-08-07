<x-layouts.admin-layout title="Role Details">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">{{ ucfirst($role->name) }}</h4>
            <p class="text-muted small mb-0">Role details and assigned permissions</p>
        </div>
        <div class="d-flex gap-2">
            @can('roles.edit')
                <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-primary">
                    <i class="fas fa-edit me-1"></i> Edit Role
                </a>
            @endcan
            <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-inline-flex align-items-center justify-content-center mb-3"
                         style="width: 80px; height: 80px; font-size: 2rem;">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h5 class="fw-bold">{{ ucfirst($role->name) }}</h5>
                    <span class="badge bg-secondary">{{ $role->guard_name }}</span>
                    @if($role->name === 'super-admin')
                        <div class="mt-2"><span class="badge bg-warning">Full Access</span></div>
                    @endif
                    <hr>
                    <p class="mb-1 small">
                        <strong>Created:</strong> {{ $role->created_at->format('M d, Y') }}
                    </p>
                    <p class="mb-0 small">
                        <strong>Last Updated:</strong> {{ $role->updated_at->format('M d, Y') }}
                    </p>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h6 class="fw-bold mb-0">Permissions ({{ $role->permissions->count() }})</h6>
                </div>
                <div class="card-body">
                    @if($role->permissions->count() > 0)
                        @php
                            $grouped = $role->permissions->groupBy(function($perm) {
                                return explode('.', $perm->name)[0];
                            });
                        @endphp

                        @foreach($grouped as $group => $permissions)
                            <div class="mb-3">
                                <h6 class="text-muted text-uppercase small fw-semibold mb-2">{{ ucfirst(str_replace('-', ' ', $group)) }}</h6>
                                @foreach($permissions as $permission)
                                    <span class="badge bg-primary bg-opacity-10 text-primary me-1 mb-1">
                                        {{ str_replace($group . '.', '', $permission->name) }}
                                    </span>
                                @endforeach
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-lock fa-2x text-muted mb-2"></i>
                            <p class="text-muted mb-0">No permissions assigned to this role.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</x-layouts.admin-layout>
