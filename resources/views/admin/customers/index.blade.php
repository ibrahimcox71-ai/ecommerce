<x-layouts.admin-layout title="Customers">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Customers</h4>
            <p class="text-muted small mb-0">Manage your customer base</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.customers.reports.index') }}" class="btn btn-outline-info">
                <i class="fas fa-chart-bar me-1"></i> Reports
            </a>
            <a href="{{ route('admin.customers.groups.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-layer-group me-1"></i> Groups
            </a>
            <a href="{{ route('admin.customers.trashed') }}" class="btn btn-outline-secondary">
                <i class="fas fa-trash-alt me-1"></i> Trashed
                @if(($stats['trashed'] ?? 0) > 0)
                    <span class="badge bg-danger ms-1">{{ $stats['trashed'] }}</span>
                @endif
            </a>
            <a href="{{ route('admin.customers.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Add Customer
            </a>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-2">
            <div class="card bg-primary-subtle border-0">
                <div class="card-body text-center py-3">
                    <h5 class="mb-0 text-primary fw-bold">{{ $stats['total'] ?? 0 }}</h5>
                    <small class="text-muted">Total</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-2">
            <div class="card bg-success-subtle border-0">
                <div class="card-body text-center py-3">
                    <h5 class="mb-0 text-success fw-bold">{{ $stats['active'] ?? 0 }}</h5>
                    <small class="text-muted">Active</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-2">
            <div class="card bg-warning-subtle border-0">
                <div class="card-body text-center py-3">
                    <h5 class="mb-0 text-warning fw-bold">{{ $stats['suspended'] ?? 0 }}</h5>
                    <small class="text-muted">Suspended</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-2">
            <div class="card bg-info-subtle border-0">
                <div class="card-body text-center py-3">
                    <h5 class="mb-0 text-info fw-bold">{{ $stats['individual'] ?? 0 }}</h5>
                    <small class="text-muted">Individual</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-2">
            <div class="card bg-primary-subtle border-0">
                <div class="card-body text-center py-3">
                    <h5 class="mb-0 text-primary fw-bold">{{ $stats['business'] ?? 0 }}</h5>
                    <small class="text-muted">Business</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-2">
            <div class="card bg-secondary-subtle border-0">
                <div class="card-body text-center py-3">
                    <h5 class="mb-0 text-secondary fw-bold">{{ $stats['with_orders'] ?? 0 }}</h5>
                    <small class="text-muted">With Orders</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.customers.index') }}" class="row g-3">
                <div class="col-md-2">
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
                        <input type="text" name="search" class="form-control"
                               placeholder="Name, email, phone..."
                               value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-1.5">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Suspended</option>
                    </select>
                </div>
                <div class="col-md-1.5">
                    <select name="customer_type" class="form-select">
                        <option value="">All Types</option>
                        <option value="individual" {{ request('customer_type') === 'individual' ? 'selected' : '' }}>Individual</option>
                        <option value="business" {{ request('customer_type') === 'business' ? 'selected' : '' }}>Business</option>
                    </select>
                </div>
                <div class="col-md-1.5">
                    <select name="customer_group_id" class="form-select">
                        <option value="">All Groups</option>
                        @foreach($groups as $group)
                            <option value="{{ $group->id }}" {{ request('customer_group_id') == $group->id ? 'selected' : '' }}>
                                {{ $group->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-1.5">
                    <input type="text" name="city" class="form-control" placeholder="City"
                           value="{{ request('city') }}">
                </div>
                <div class="col-md-1.5">
                    <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}"
                           placeholder="From">
                </div>
                <div class="col-md-1">
                    <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}"
                           placeholder="To">
                </div>
                <div class="col-md-1">
                    <select name="per_page" class="form-select">
                        <option value="15" {{ request('per_page') == 15 ? 'selected' : '' }}>15</option>
                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-outline-primary w-100">
                        <i class="fas fa-filter"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Bulk Actions --}}
    <div class="d-none" id="bulkActions">
        <div class="alert alert-info d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
            <span><i class="fas fa-check-circle me-2"></i><strong id="selectedCount">0</strong> selected</span>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-sm btn-danger" onclick="bulkDelete()">
                    <i class="fas fa-trash me-1"></i> Delete Selected
                </button>
            </div>
        </div>
    </div>

    {{-- Customers Table --}}
    <div class="card">
        <div class="card-body p-0">
            @if($customers->count() > 0)
                <form id="bulkForm" method="POST" action="{{ route('admin.customers.bulk-delete') }}">
                    @csrf
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 ps-4" style="width: 40px;">
                                        <input type="checkbox" class="form-check-input" id="selectAll">
                                    </th>
                                    <th class="border-0" style="width: 50px;">Photo</th>
                                    <th class="border-0">Customer</th>
                                    <th class="border-0 d-none d-lg-table-cell">Email / Phone</th>
                                    <th class="border-0 text-center d-none d-xl-table-cell">Orders</th>
                                    <th class="border-0 text-center d-none d-xl-table-cell">Total Spend</th>
                                    <th class="border-0 text-center d-none d-lg-table-cell">Points</th>
                                    <th class="border-0 text-center">Status</th>
                                    <th class="border-0 text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($customers as $customer)
                                    <tr>
                                        <td class="ps-4">
                                            <input type="checkbox" name="ids[]" value="{{ $customer->id }}"
                                                   class="form-check-input row-checkbox">
                                        </td>
                                        <td>
                                            @if($customer->avatar)
                                                <img src="{{ $customer->avatar_url }}" alt="{{ $customer->name }}"
                                                     class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;" loading="lazy">
                                            @else
                                                <div class="rounded-circle d-flex align-items-center justify-content-center bg-light"
                                                     style="width: 40px; height: 40px;">
                                                    <i class="fas fa-user text-muted"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <div>
                                                <span class="fw-semibold">
                                                    <a href="{{ route('admin.customers.show', $customer->id) }}" class="text-decoration-none text-dark">
                                                        {{ $customer->name }}
                                                    </a>
                                                </span>
                                                <small class="d-block text-muted">
                                                    #{{ $customer->id }}
                                                    @if($customer->group)
                                                        <span class="badge bg-light text-dark border ms-1">{{ $customer->group->name }}</span>
                                                    @endif
                                                    @if($customer->customer_type?->value === 'business')
                                                        <span class="badge bg-primary bg-opacity-10 text-primary ms-1">
                                                            <i class="fas fa-building me-1"></i>Business
                                                        </span>
                                                    @endif
                                                </small>
                                            </div>
                                        </td>
                                        <td class="d-none d-lg-table-cell">
                                            <div class="small">
                                                @if($customer->email)
                                                    <div><i class="fas fa-envelope text-muted me-1"></i>{{ $customer->email }}</div>
                                                @endif
                                                @if($customer->phone)
                                                    <div><i class="fas fa-phone text-muted me-1"></i>{{ $customer->phone }}</div>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="text-center d-none d-xl-table-cell">
                                            <span class="badge bg-info bg-opacity-10 text-info">
                                                {{ $customer->total_orders }}
                                            </span>
                                        </td>
                                        <td class="text-center d-none d-xl-table-cell">
                                            <span class="fw-semibold">{{ config('ecommerce.currency.symbol', '$') }}{{ number_format($customer->total_spend, 2) }}</span>
                                        </td>
                                        <td class="text-center d-none d-lg-table-cell">
                                            @if($customer->reward_points > 0)
                                                <span class="badge bg-warning bg-opacity-10 text-warning">
                                                    <i class="fas fa-star me-1"></i>{{ number_format($customer->reward_points) }}
                                                </span>
                                            @else
                                                <span class="text-muted">0</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            {!! $customer->status_badge !!}
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="btn-group">
                                                <a href="{{ route('admin.customers.show', $customer->id) }}"
                                                   class="btn btn-sm btn-outline-secondary" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.customers.edit', $customer->id) }}"
                                                   class="btn btn-sm btn-outline-primary" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @if($customer->isSuspended())
                                                    <button type="button" class="btn btn-sm btn-outline-success"
                                                            onclick="toggleStatus({{ $customer->id }}, 'activate')" title="Activate">
                                                        <i class="fas fa-check-circle"></i>
                                                    </button>
                                                @else
                                                    <button type="button" class="btn btn-sm btn-outline-warning"
                                                            onclick="toggleStatus({{ $customer->id }}, 'suspend')" title="Suspend">
                                                        <i class="fas fa-pause-circle"></i>
                                                    </button>
                                                @endif
                                                <button type="button" class="btn btn-sm btn-outline-danger"
                                                        onclick="confirmDelete({{ $customer->id }}, '{{ addslashes($customer->name) }}')" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </form>

                <div class="d-flex justify-content-between align-items-center px-4 py-3 border-top">
                    <div class="text-muted small">
                        Showing {{ $customers->firstItem() }} to {{ $customers->lastItem() }} of {{ $customers->total() }} entries
                    </div>
                    <div>
                        {{ $customers->appends(request()->query())->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-users fa-3x text-muted mb-3"></i>
                    <h5>No customers found</h5>
                    <p class="text-muted">
                        @if(request()->anyFilled(['search', 'status', 'customer_type', 'customer_group_id', 'city']))
                            No customers match your filters. <a href="{{ route('admin.customers.index') }}">Clear filters</a>
                        @else
                            Get started by creating your first customer.
                        @endif
                    </p>
                    <a href="{{ route('admin.customers.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Add Customer
                    </a>
                </div>
            @endif
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
                <p class="text-muted small mb-0">This will soft-delete the customer. You can restore them from the trash.</p>
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
$(document).ready(function() {
    $('#selectAll').change(function() {
        $('.row-checkbox').prop('checked', $(this).prop('checked'));
        updateBulkActions();
    });

    $('.row-checkbox').change(function() {
        updateBulkActions();
    });

    function updateBulkActions() {
        const checked = $('.row-checkbox:checked').length;
        if (checked > 0) {
            $('#bulkActions').removeClass('d-none');
            $('#selectedCount').text(checked);
        } else {
            $('#bulkActions').addClass('d-none');
        }
    }
});

function confirmDelete(id, name) {
    $('#deleteName').text(name);
    $('#deleteForm').attr('action', `/admin/customers/${id}`);
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}

function bulkDelete() {
    const ids = $('.row-checkbox:checked').map(function() { return $(this).val(); }).get();
    if (!ids.length) return;
    if (confirm('Are you sure you want to delete ' + ids.length + ' selected customers?')) {
        $('#bulkForm').attr('action', '{{ route('admin.customers.bulk-delete') }}').submit();
    }
}

function toggleStatus(id, action) {
    const msg = action === 'suspend' ? 'suspend' : 'activate';
    if (!confirm(`Are you sure you want to ${msg} this customer?`)) return;

    $.ajax({
        url: `/admin/customers/${id}/toggle-status`,
        type: 'POST',
        data: { _token: '{{ csrf_token() }}' },
        success: function(response) {
            if (response.success) {
                location.reload();
            }
        },
        error: function() {
            alert('Failed to update status');
        }
    });
}
</script>
@endpush
