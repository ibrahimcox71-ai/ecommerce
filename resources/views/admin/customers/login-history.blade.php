<x-layouts.admin-layout title="Login History">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Login History</h4>
            <p class="text-muted small mb-0">{{ $customer->name }}</p>
        </div>
        <a href="{{ route('admin.customers.show', $customer->id) }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to Customer
        </a>
    </div>

    <div class="card">
        <div class="card-body p-0">
            @if($loginHistories->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0 ps-4">Date & Time</th>
                                <th class="border-0">IP Address</th>
                                <th class="border-0 d-none d-md-table-cell">Browser</th>
                                <th class="border-0 d-none d-md-table-cell">Platform</th>
                                <th class="border-0 d-none d-md-table-cell">Device</th>
                                <th class="border-0">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($loginHistories as $history)
                                <tr>
                                    <td class="ps-4">
                                        <span class="small">{{ $history->login_at->format('M d, Y H:i:s') }}</span>
                                        <small class="d-block text-muted">{{ $history->login_at->diffForHumans() }}</small>
                                    </td>
                                    <td><code>{{ $history->ip_address }}</code></td>
                                    <td class="d-none d-md-table-cell">{{ $history->browser ?? 'Unknown' }}</td>
                                    <td class="d-none d-md-table-cell">{{ $history->platform ?? 'Unknown' }}</td>
                                    <td class="d-none d-md-table-cell">{{ $history->device_type }}</td>
                                    <td>
                                        @if($history->is_successful)
                                            <span class="badge bg-success bg-opacity-10 text-success">Success</span>
                                        @else
                                            <span class="badge bg-danger bg-opacity-10 text-danger">
                                                {{ $history->failure_reason ?? 'Failed' }}
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center px-4 py-3 border-top">
                    <div class="text-muted small">
                        Showing {{ $loginHistories->firstItem() }} to {{ $loginHistories->lastItem() }} of {{ $loginHistories->total() }} entries
                    </div>
                    <div>
                        {{ $loginHistories->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-history fa-3x text-muted mb-3"></i>
                    <h5>No login history</h5>
                    <p class="text-muted">This customer has no recorded login activity.</p>
                </div>
            @endif
        </div>
    </div>

</x-layouts.admin-layout>
