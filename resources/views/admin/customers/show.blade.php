<x-layouts.admin-layout title="Customer Details">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Customer Details</h4>
            <p class="text-muted small mb-0">View customer information and history</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.customers.edit', $customer->id) }}" class="btn btn-primary">
                <i class="fas fa-edit me-1"></i> Edit
            </a>
            <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    {{-- Customer Header --}}
    <div class="card mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-auto">
                    @if($customer->avatar)
                        <img src="{{ $customer->avatar_url }}" alt="{{ $customer->name }}"
                             class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
                    @else
                        <div class="rounded-circle d-flex align-items-center justify-content-center bg-light"
                             style="width: 80px; height: 80px;">
                            <i class="fas fa-user fa-2x text-muted"></i>
                        </div>
                    @endif
                </div>
                <div class="col">
                    <h5 class="fw-bold mb-1">{{ $customer->name }}</h5>
                    <div class="d-flex flex-wrap gap-2 align-items-center">
                        <span class="text-muted small">#{{ $customer->id }}</span>
                        {!! $customer->status_badge !!}
                        @if($customer->customer_type?->value === 'business')
                            <span class="badge bg-primary bg-opacity-10 text-primary">
                                <i class="fas fa-building me-1"></i>{{ $customer->customer_type->label() }}
                            </span>
                        @endif
                        @if($customer->group)
                            <span class="badge bg-light text-dark border">{{ $customer->group->name }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-auto text-end">
                    <div class="small text-muted">Member since</div>
                    <div class="fw-semibold">{{ $customer->created_at->format('M d, Y') }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- Left Column --}}
        <div class="col-lg-8">
            {{-- Order Summary --}}
            <div class="card mb-4">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Order Summary</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-6 col-md-3">
                            <div class="text-center p-3 bg-light rounded">
                                <h4 class="fw-bold text-primary mb-0">{{ $customer->total_orders }}</h4>
                                <small class="text-muted">Total Orders</small>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="text-center p-3 bg-light rounded">
                                <h4 class="fw-bold text-success mb-0">{{ config('ecommerce.currency.symbol', '$') }}{{ number_format($customer->total_spend, 2) }}</h4>
                                <small class="text-muted">Total Spend</small>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="text-center p-3 bg-light rounded">
                                <h4 class="fw-bold text-info mb-0">{{ config('ecommerce.currency.symbol', '$') }}{{ number_format($customer->average_order_value, 2) }}</h4>
                                <small class="text-muted">Avg Order Value</small>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="text-center p-3 bg-light rounded">
                                <h4 class="fw-bold text-warning mb-0">{{ $customer->cancelled_orders_count }}</h4>
                                <small class="text-muted">Cancelled</small>
                            </div>
                        </div>
                    </div>

                    @if($customer->last_order)
                        <div class="mt-3 pt-3 border-top">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-muted d-block">Last Order</small>
                                    <span class="fw-semibold">#{{ $customer->last_order->order_number ?? $customer->last_order->id }}</span>
                                    <small class="text-muted ms-2">{{ $customer->last_order->created_at->diffForHumans() }}</small>
                                </div>
                                <span class="badge bg-{{ $customer->last_order->order_status === 'completed' ? 'success' : 'warning' }}">
                                    {{ ucfirst($customer->last_order->order_status) }}
                                </span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Contact Information --}}
            <div class="card mb-4">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Contact Information</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            @if($customer->email)
                                <div class="mb-3">
                                    <small class="text-muted d-block">Email</small>
                                    <div class="d-flex align-items-center gap-2">
                                        <span>{{ $customer->email }}</span>
                                        @if($customer->email_verified_at)
                                            <span class="badge bg-success bg-opacity-10 text-success">
                                                <i class="fas fa-check-circle me-1"></i>Verified
                                            </span>
                                        @else
                                            <span class="badge bg-warning bg-opacity-10 text-warning">
                                                <i class="fas fa-clock me-1"></i>Unverified
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            @if($customer->phone)
                                <div class="mb-3">
                                    <small class="text-muted d-block">Phone</small>
                                    <div class="d-flex align-items-center gap-2">
                                        <span>{{ $customer->phone }}</span>
                                        @if($customer->phone_verified_at)
                                            <span class="badge bg-success bg-opacity-10 text-success">
                                                <i class="fas fa-check-circle me-1"></i>Verified
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            @if($customer->date_of_birth)
                                <div class="mb-3">
                                    <small class="text-muted d-block">Date of Birth</small>
                                    <span>{{ $customer->date_of_birth->format('M d, Y') }}</span>
                                </div>
                            @endif

                            @if($customer->gender)
                                <div class="mb-3">
                                    <small class="text-muted d-block">Gender</small>
                                    <span>{{ ucfirst($customer->gender) }}</span>
                                </div>
                            @endif
                        </div>

                        <div class="col-md-6">
                            @if($customer->emergency_contact_name)
                                <div class="mb-3">
                                    <small class="text-muted d-block">Emergency Contact</small>
                                    <span class="fw-semibold">{{ $customer->emergency_contact_name }}</span>
                                    @if($customer->emergency_contact_phone)
                                        <br><small class="text-muted">{{ $customer->emergency_contact_phone }}</small>
                                    @endif
                                </div>
                            @endif

                            @if($customer->user)
                                <div class="mb-3">
                                    <small class="text-muted d-block">Linked User Account</small>
                                    <a href="{{ route('admin.users.show', $customer->user_id) }}" class="text-decoration-none">
                                        <i class="fas fa-external-link-alt me-1"></i>{{ $customer->user->name }}
                                    </a>
                                </div>
                            @endif

                            @if($customer->referral_code)
                                <div class="mb-3">
                                    <small class="text-muted d-block">Referral Code</small>
                                    <code>{{ $customer->referral_code }}</code>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Addresses --}}
            <div class="card mb-4">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0">Addresses</h6>
                </div>
                <div class="card-body">
                    @if($customer->addresses->count() > 0)
                        <div class="row g-3">
                            @foreach($customer->addresses as $address)
                                <div class="col-md-6">
                                    <div class="border rounded p-3 position-relative">
                                        @if($address->is_default)
                                            <span class="badge bg-info position-absolute top-0 end-0 m-2">Default</span>
                                        @endif
                                        <div class="d-flex align-items-center mb-2">
                                            <span class="badge bg-light text-dark border me-2">{{ $address->type_label }}</span>
                                            @if($address->label)
                                                <small class="text-muted">{{ $address->label }}</small>
                                            @endif
                                        </div>
                                        <div class="small">
                                            <strong>{{ $address->name }}</strong>
                                            @if($address->phone)
                                                <br>{{ $address->phone }}
                                            @endif
                                            <br>{{ $address->address_line_1 }}
                                            @if($address->address_line_2)
                                                <br>{{ $address->address_line_2 }}
                                            @endif
                                            <br>{{ $address->city }}, {{ $address->state }} {{ $address->postal_code }}
                                            <br>{{ $address->country }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-map-marker-alt fa-2x text-muted mb-2"></i>
                            <p class="text-muted mb-0">No addresses saved</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Business Details --}}
            @if($customer->customer_type?->value === 'business' && ($customer->company_name || $customer->company_registration_number || $customer->tax_number))
                <div class="card mb-4">
                    <div class="card-header bg-transparent">
                        <h6 class="fw-bold mb-0">Business Details</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @if($customer->company_name)
                                <div class="col-md-4 mb-3">
                                    <small class="text-muted d-block">Company Name</small>
                                    <span class="fw-semibold">{{ $customer->company_name }}</span>
                                </div>
                            @endif
                            @if($customer->company_registration_number)
                                <div class="col-md-4 mb-3">
                                    <small class="text-muted d-block">Registration Number</small>
                                    <span>{{ $customer->company_registration_number }}</span>
                                </div>
                            @endif
                            @if($customer->tax_number)
                                <div class="col-md-4 mb-3">
                                    <small class="text-muted d-block">Tax Number</small>
                                    <span>{{ $customer->tax_number }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            {{-- Login History --}}
            @if($loginHistories->count() > 0)
                <div class="card mb-4">
                    <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold mb-0">Login History</h6>
                        @if($customer->user)
                            <a href="{{ route('admin.customers.login-history', $customer->id) }}" class="btn btn-sm btn-outline-secondary">
                                View All
                            </a>
                        @endif
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-sm mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0">Date</th>
                                        <th class="border-0">IP</th>
                                        <th class="border-0 d-none d-md-table-cell">Browser</th>
                                        <th class="border-0 d-none d-md-table-cell">Device</th>
                                        <th class="border-0">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($loginHistories->take(10) as $history)
                                        <tr>
                                            <td class="small">{{ $history->login_at->format('M d, H:i') }}</td>
                                            <td class="small">{{ $history->ip_address }}</td>
                                            <td class="small d-none d-md-table-cell">{{ $history->browser ?? 'Unknown' }}</td>
                                            <td class="small d-none d-md-table-cell">{{ $history->device_type }}</td>
                                            <td>
                                                @if($history->is_successful)
                                                    <span class="badge bg-success bg-opacity-10 text-success">Success</span>
                                                @else
                                                    <span class="badge bg-danger bg-opacity-10 text-danger">{{ $history->failure_reason ?? 'Failed' }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Activity Log --}}
            <div class="card">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Activity Log</h6>
                </div>
                <div class="card-body">
                    @php
                        $activities = $customer->activityLogs()->latest()->take(10)->get();
                    @endphp
                    @if($activities->count() > 0)
                        <div class="timeline">
                            @foreach($activities as $log)
                                <div class="d-flex mb-3">
                                    <div class="me-3">
                                        <i class="fas fa-circle text-{{ $log->description === 'created' ? 'success' : 'info' }} fa-xs mt-1"></i>
                                    </div>
                                    <div>
                                        <p class="mb-0 small">{{ $log->description }}</p>
                                        <small class="text-muted">{{ $log->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted small mb-0">No activity recorded</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Right Column --}}
        <div class="col-lg-4">
            {{-- Account Stats --}}
            <div class="card mb-4">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Account</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Reward Points</span>
                        <span class="badge bg-warning bg-opacity-10 text-warning fw-semibold">
                            {{ number_format($customer->reward_points) }}
                        </span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Wallet Balance</span>
                        <span class="fw-semibold">{{ config('ecommerce.currency.symbol', '$') }}{{ number_format($customer->wallet_balance, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Last Login</span>
                        <span class="small">{{ $customer->last_login_at?->diffForHumans() ?? 'Never' }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Returned Orders</span>
                        <span class="badge bg-secondary bg-opacity-10 text-secondary">{{ $customer->returned_orders_count }}</span>
                    </div>
                </div>
            </div>

            {{-- Notes Display --}}
            @if($customer->notes)
                <div class="card mb-4">
                    <div class="card-header bg-transparent">
                        <h6 class="fw-bold mb-0">Notes</h6>
                    </div>
                    <div class="card-body">
                        <p class="small mb-0">{{ $customer->notes }}</p>
                    </div>
                </div>
            @endif

            {{-- Quick Actions --}}
            <div class="card">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.customers.edit', $customer->id) }}" class="btn btn-outline-primary">
                            <i class="fas fa-edit me-2"></i> Edit Profile
                        </a>
                        @if($customer->isSuspended())
                            <button type="button" class="btn btn-outline-success" onclick="toggleStatus({{ $customer->id }})">
                                <i class="fas fa-check-circle me-2"></i> Activate Customer
                            </button>
                        @else
                            <button type="button" class="btn btn-outline-warning" onclick="toggleStatus({{ $customer->id }})">
                                <i class="fas fa-pause-circle me-2"></i> Suspend Customer
                            </button>
                        @endif
                        <button type="button" class="btn btn-outline-danger" onclick="confirmDelete({{ $customer->id }}, '{{ addslashes($customer->name) }}')">
                            <i class="fas fa-trash me-2"></i> Delete Customer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-layouts.admin-layout>

{{-- Delete Confirmation Modal --}}
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Customer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete <strong id="deleteName"></strong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-1"></i> Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function toggleStatus(id) {
    if (!confirm('Are you sure you want to change this customer\'s status?')) return;

    $.ajax({
        url: `/admin/customers/${id}/toggle-status`,
        type: 'POST',
        data: { _token: '{{ csrf_token() }}' },
        success: function(response) {
            if (response.success) {
                location.reload();
            }
        }
    });
}

function confirmDelete(id, name) {
    $('#deleteName').text(name);
    $('#deleteForm').attr('action', `/admin/customers/${id}`);
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>
@endpush
