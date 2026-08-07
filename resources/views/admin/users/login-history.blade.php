<x-layouts.admin-layout title="Login History">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Login History: {{ $user->name }}</h4>
            <p class="text-muted small mb-0">Complete login activity for this user</p>
        </div>
        <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to Profile
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            @if($histories->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Login Time</th>
                                <th>Logout Time</th>
                                <th>IP Address</th>
                                <th>Browser</th>
                                <th>Platform</th>
                                <th>Device</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($histories as $history)
                                <tr>
                                    <td>{{ $history->login_at?->format('M d, Y H:i:s') }}</td>
                                    <td>{{ $history->logout_at?->format('M d, Y H:i:s') ?? 'Still logged in' }}</td>
                                    <td><code>{{ $history->ip_address }}</code></td>
                                    <td>{{ $history->browser }}</td>
                                    <td>{{ $history->platform }}</td>
                                    <td>{{ $history->device_type }}</td>
                                    <td>
                                        @if($history->is_successful)
                                            <span class="badge bg-success">Success</span>
                                        @else
                                            <span class="badge bg-danger">{{ $history->failure_reason ?? 'Failed' }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted small">
                        Showing {{ $histories->firstItem() }} to {{ $histories->lastItem() }} of {{ $histories->total() }} entries
                    </div>
                    <div>{{ $histories->links() }}</div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-history fa-3x text-muted mb-3"></i>
                    <h5>No login history</h5>
                    <p class="text-muted mb-0">This user has not logged in yet.</p>
                </div>
            @endif
        </div>
    </div>

</x-layouts.admin-layout>
