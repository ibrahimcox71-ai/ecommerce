<x-layouts.admin-layout title="User Details">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">{{ $user->name }}</h4>
            <p class="text-muted small mb-0">User details and activity</p>
        </div>
        <div class="d-flex gap-2">
            @can('users.edit')
                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary">
                    <i class="fas fa-edit me-1"></i> Edit User
                </a>
            @endcan
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    @if($user->avatar)
                        <img src="{{ Storage::url($user->avatar) }}" alt="{{ $user->name }}"
                             class="rounded-circle img-fluid mb-3" style="width: 120px; height: 120px; object-fit: cover;">
                    @else
                        <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center mb-3"
                             style="width: 120px; height: 120px; font-size: 2.5rem;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                    <h5 class="fw-bold">{{ $user->name }}</h5>
                    <p class="text-muted small mb-2">{{ $user->email }}</p>
                    @foreach($user->roles as $role)
                        <span class="badge bg-{{ $role->name === 'super-admin' ? 'warning' : 'primary' }} me-1">
                            {{ ucfirst($role->name) }}
                        </span>
                    @endforeach
                    <hr>
                    <p class="mb-1 small">
                        <strong>Status:</strong>
                        <span class="badge bg-{{ $user->status ? 'success' : 'danger' }}">
                            {{ $user->status ? 'Active' : 'Inactive' }}
                        </span>
                    </p>
                    <p class="mb-1 small"><strong>Phone:</strong> {{ $user->phone ?? 'N/A' }}</p>
                    <p class="mb-1 small"><strong>Member since:</strong> {{ $user->created_at->format('M d, Y') }}</p>
                    @if($user->email_verified_at)
                        <p class="mb-0 small"><strong>Verified:</strong> {{ $user->email_verified_at->format('M d, Y') }}</p>
                    @endif
                </div>
            </div>

            @can('users.edit')
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="fw-bold mb-0">Reset Password</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.users.reset-password', $user->id) }}">
                            @csrf
                            <div class="mb-3">
                                <div class="form-outline">
                                    <input type="password" name="password" id="reset_password" class="form-control" required>
                                    <label class="form-label" for="reset_password">New Password</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-outline">
                                    <input type="password" name="password_confirmation" id="reset_password_confirmation" class="form-control" required>
                                    <label class="form-label" for="reset_password_confirmation">Confirm Password</label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-warning w-100">
                                <i class="fas fa-key me-1"></i> Reset Password
                            </button>
                        </form>
                    </div>
                </div>
            @endcan
        </div>

        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="fw-bold mb-0">Roles</h6>
                </div>
                <div class="card-body">
                    @if($user->roles->count() > 0)
                        @foreach($user->roles as $role)
                            <span class="badge bg-primary bg-opacity-10 text-primary me-1 mb-1" style="font-size: 0.85rem;">
                                <i class="fas fa-shield-alt me-1"></i>{{ ucfirst($role->name) }}
                            </span>
                        @endforeach
                    @else
                        <p class="text-muted mb-0">No roles assigned.</p>
                    @endif
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="fw-bold mb-0">Direct Permissions</h6>
                </div>
                <div class="card-body">
                    @if($user->getPermissionNames()->count() > 0)
                        @foreach($user->getPermissionNames() as $permission)
                            <span class="badge bg-info bg-opacity-10 text-info me-1 mb-1">
                                {{ $permission }}
                            </span>
                        @endforeach
                    @else
                        <p class="text-muted mb-0">No direct permissions assigned. User inherits permissions from roles.</p>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0">Login History</h6>
                    <a href="{{ route('admin.users.login-history', $user->id) }}" class="btn btn-sm btn-outline-primary">
                        View All
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 small">
                            <thead class="table-light">
                                <tr>
                                    <th>Date/Time</th>
                                    <th>IP Address</th>
                                    <th>Browser</th>
                                    <th>Platform</th>
                                    <th>Device</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($user->loginHistories as $history)
                                    <tr>
                                        <td>{{ $history->login_at?->format('M d, Y H:i') }}</td>
                                        <td>{{ $history->ip_address }}</td>
                                        <td>{{ $history->browser }}</td>
                                        <td>{{ $history->platform }}</td>
                                        <td>{{ $history->device_type }}</td>
                                        <td>
                                            @if ($history->is_successful)
                                                <span class="badge bg-success">Success</span>
                                            @else
                                                <span class="badge bg-danger">{{ $history->failure_reason ?? 'Failed' }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-3">No login history</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-layouts.admin-layout>
