@php
    $layout = $guard === 'admin' ? 'admin-layout' : 'customer-layout';
    $title = $guard === 'admin' ? 'Login History - Admin' : 'Login History';
    $routePrefix = $guard === 'admin' ? 'admin' : 'customer';
@endphp

<x-dynamic-component :component="'layouts.' . $layout" :title="$title">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Login History</h4>
        <a href="{{ route($routePrefix . '.profile') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i>Back to Profile
        </a>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Date/Time</th>
                            <th>IP Address</th>
                            <th>Browser</th>
                            <th>Platform</th>
                            <th>Device</th>
                            <th>Status</th>
                            <th>Logout At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($histories as $history)
                            <tr>
                                <td>{{ $histories->firstItem() + $loop->index }}</td>
                                <td>{{ $history->login_at?->format('M d, Y H:i:s') }}</td>
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
                                <td>{{ $history->logout_at?->format('M d, Y H:i:s') ?? '—' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">No login history found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($histories->hasPages())
            <div class="card-footer">
                {{ $histories->links() }}
            </div>
        @endif
    </div>
</x-dynamic-component>
