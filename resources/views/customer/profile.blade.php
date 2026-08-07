<x-layouts.customer-layout title="Profile">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">My Profile</h4>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <div class="mb-3">
                        @if ($user->avatar)
                            <img src="{{ Storage::url($user->avatar) }}" alt="{{ $user->name }}"
                                 class="rounded-circle img-fluid" style="width: 150px; height: 150px; object-fit: cover;">
                        @else
                            <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center"
                                 style="width: 150px; height: 150px; font-size: 3rem;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    <h5 class="fw-bold">{{ $user->name }}</h5>
                    <p class="text-muted small mb-1">{{ $user->email }}</p>
                    @if ($user->phone)
                        <p class="text-muted small mb-1">{{ $user->phone }}</p>
                    @endif
                    <span class="badge bg-{{ $user->status ? 'success' : 'danger' }}">
                        {{ $user->status ? 'Active' : 'Inactive' }}
                    </span>
                    @if (!$user->hasVerifiedEmail())
                        <div class="mt-2">
                            <span class="badge bg-warning text-dark">Email not verified</span>
                            <form method="POST" action="{{ route('verification.send') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-link p-0 ms-1">Resend</button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="fw-bold mb-0">Account Details</h6>
                </div>
                <div class="card-body small">
                    <p class="mb-1"><strong>Member since:</strong> {{ $user->created_at->format('M d, Y') }}</p>
                    @if ($user->email_verified_at)
                        <p class="mb-1"><strong>Email verified:</strong> {{ $user->email_verified_at->format('M d, Y') }}</p>
                    @endif
                    <p class="mb-0"><strong>Orders:</strong> {{ $user->orders?->count() ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="fw-bold mb-0">Edit Profile</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('customer.profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-outline">
                                    <input type="text" name="name" id="name" class="form-control"
                                           value="{{ old('name', $user->name) }}" required>
                                    <label class="form-label" for="name">Full name</label>
                                </div>
                                @error('name')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="form-outline">
                                    <input type="email" name="email" id="email" class="form-control"
                                           value="{{ old('email', $user->email) }}" required>
                                    <label class="form-label" for="email">Email address</label>
                                </div>
                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-outline">
                                    <input type="text" name="phone" id="phone" class="form-control"
                                           value="{{ old('phone', $user->phone) }}">
                                    <label class="form-label" for="phone">Phone number</label>
                                </div>
                                @error('phone')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="form-outline">
                                    <input type="file" name="avatar" id="avatar" class="form-control" accept="image/*">
                                    <label class="form-label" for="avatar">Profile photo</label>
                                </div>
                                @error('avatar')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Update Profile
                        </button>
                    </form>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="fw-bold mb-0">Change Password</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('customer.profile.password') }}">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="form-outline">
                                    <input type="password" name="current_password" id="current_password" class="form-control" required>
                                    <label class="form-label" for="current_password">Current password</label>
                                </div>
                                @error('current_password')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <div class="form-outline">
                                    <input type="password" name="password" id="password" class="form-control" required>
                                    <label class="form-label" for="password">New password</label>
                                </div>
                                @error('password')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <div class="form-outline">
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                                    <label class="form-label" for="password_confirmation">Confirm password</label>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-key me-1"></i>Change Password
                        </button>
                    </form>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0">Active Sessions</h6>
                </div>
                <div class="card-body">
                    <p class="small text-muted mb-3">
                        <i class="fas fa-info-circle me-1"></i>
                        This will log out all other sessions except the current one.
                    </p>
                    <form method="POST" action="{{ route('customer.sessions.destroy') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm"
                                onclick="return confirm('Are you sure? This will log out all other devices.')">
                            <i class="fas fa-sign-out-alt me-1"></i>Logout Other Devices
                        </button>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0">Login History</h6>
                    <a href="{{ route('customer.login.history') }}" class="btn btn-sm btn-outline-primary">
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
                                    <th>Device</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($loginHistory as $history)
                                    <tr>
                                        <td>{{ $history->login_at?->format('M d, Y H:i') }}</td>
                                        <td>{{ $history->ip_address }}</td>
                                        <td>{{ $history->browser }}</td>
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
                                        <td colspan="5" class="text-center text-muted py-3">No login history</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.customer-layout>
