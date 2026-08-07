<x-layouts.admin-layout title="Suppliers">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Suppliers</h4>
            <p class="text-muted small mb-0">Manage your product suppliers</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.suppliers.trashed') }}" class="btn btn-outline-secondary">
                <i class="fas fa-trash-alt me-1"></i> Trashed
                @if(($stats['trashed'] ?? 0) > 0)
                    <span class="badge bg-danger ms-1">{{ $stats['trashed'] }}</span>
                @endif
            </a>
            <a href="{{ route('admin.suppliers.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Add Supplier
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
            <div class="card bg-secondary-subtle border-0">
                <div class="card-body text-center py-3">
                    <h5 class="mb-0 text-secondary fw-bold">{{ $stats['inactive'] ?? 0 }}</h5>
                    <small class="text-muted">Inactive</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-2">
            <div class="card bg-danger-subtle border-0">
                <div class="card-body text-center py-3">
                    <h5 class="mb-0 text-danger fw-bold">{{ $stats['blacklisted'] ?? 0 }}</h5>
                    <small class="text-muted">Blacklisted</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-2">
            <div class="card bg-info-subtle border-0">
                <div class="card-body text-center py-3">
                    <h5 class="mb-0 text-info fw-bold">{{ $stats['with_products'] ?? 0 }}</h5>
                    <small class="text-muted">With Products</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-2">
            <div class="card bg-warning-subtle border-0">
                <div class="card-body text-center py-3">
                    <h5 class="mb-0 text-warning fw-bold">${{ number_format($stats['total_outstanding'] ?? 0, 0) }}</h5>
                    <small class="text-muted">Outstanding</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.suppliers.index') }}" class="row g-3">
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
                        <input type="text" name="search" class="form-control"
                               placeholder="Search by name, code, company..."
                               value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="blacklisted" {{ request('status') === 'blacklisted' ? 'selected' : '' }}>Blacklisted</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="country" class="form-select">
                        <option value="">All Countries</option>
                        @php
                            $countries = App\Models\Supplier::whereNotNull('country')->distinct()->pluck('country');
                        @endphp
                        @foreach($countries as $c)
                            <option value="{{ $c }}" {{ request('country') === $c ? 'selected' : '' }}>{{ $c }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="per_page" class="form-select">
                        <option value="15" {{ request('per_page') == 15 ? 'selected' : '' }}>15 per page</option>
                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 per page</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 per page</option>
                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100 per page</option>
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
                <select class="form-select form-select-sm" id="bulkStatusSelect" style="width: 140px;">
                    <option value="">Change Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                    <option value="blacklisted">Blacklisted</option>
                </select>
                <button type="button" class="btn btn-sm btn-warning" onclick="bulkUpdateStatus()">
                    <i class="fas fa-check-circle me-1"></i> Apply
                </button>
                <button type="button" class="btn btn-sm btn-danger" onclick="bulkDelete()">
                    <i class="fas fa-trash me-1"></i> Delete
                </button>
            </div>
        </div>
    </div>

    {{-- Suppliers Table --}}
    <div class="card">
        <div class="card-body p-0">
            @if($suppliers->count() > 0)
                <form id="bulkForm" method="POST" action="{{ route('admin.suppliers.bulk-delete') }}">
                    @csrf
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 ps-4" style="width: 40px;">
                                        <input type="checkbox" class="form-check-input" id="selectAll">
                                    </th>
                                    <th class="border-0">Supplier</th>
                                    <th class="border-0 d-none d-md-table-cell">Code</th>
                                    <th class="border-0 d-none d-lg-table-cell">Company</th>
                                    <th class="border-0 d-none d-xl-table-cell">Phone</th>
                                    <th class="border-0 d-none d-xl-table-cell">Email</th>
                                    <th class="border-0 text-center">Products</th>
                                    <th class="border-0 text-end d-none d-lg-table-cell">Balance</th>
                                    <th class="border-0 text-center">Status</th>
                                    <th class="border-0 text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($suppliers as $supplier)
                                    <tr>
                                        <td class="ps-4">
                                            <input type="checkbox" name="ids[]" value="{{ $supplier->id }}"
                                                   class="form-check-input row-checkbox">
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($supplier->logo)
                                                    <img src="{{ $supplier->logo_url }}" alt="{{ $supplier->name }}"
                                                         class="rounded me-3" style="width: 44px; height: 44px; object-fit: cover;" loading="lazy">
                                                @else
                                                    <div class="rounded me-3 d-flex align-items-center justify-content-center bg-light"
                                                         style="width: 44px; height: 44px;">
                                                        <i class="fas fa-truck text-muted"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <span class="fw-semibold">
                                                        <a href="{{ route('admin.suppliers.show', $supplier->id) }}" class="text-decoration-none text-dark">
                                                            {{ $supplier->name }}
                                                        </a>
                                                    </span>
                                                    @if($supplier->contact_person)
                                                        <small class="d-block text-muted">
                                                            <i class="fas fa-user me-1"></i>{{ $supplier->contact_person }}
                                                        </small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="d-none d-md-table-cell">
                                            <span class="badge bg-light text-dark border">{{ $supplier->supplier_code }}</span>
                                        </td>
                                        <td class="d-none d-lg-table-cell">
                                            <span class="small">{{ $supplier->company_name ?: '—' }}</span>
                                        </td>
                                        <td class="d-none d-xl-table-cell">
                                            <span class="small">{{ $supplier->phone ?: '—' }}</span>
                                        </td>
                                        <td class="d-none d-xl-table-cell">
                                            <span class="small">{{ $supplier->email ?: '—' }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-primary bg-opacity-10 text-primary">
                                                {{ $supplier->products_count }}
                                            </span>
                                        </td>
                                        <td class="text-end d-none d-lg-table-cell">
                                            <span class="fw-semibold {{ $supplier->outstanding_balance > 0 ? 'text-danger' : 'text-success' }}">
                                                ${{ number_format($supplier->outstanding_balance, 2) }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @php
                                                $statusColors = ['active' => 'success', 'inactive' => 'secondary', 'blacklisted' => 'danger'];
                                                $statusIcons = ['active' => 'fa-check-circle', 'inactive' => 'fa-pause-circle', 'blacklisted' => 'fa-ban'];
                                                $color = $statusColors[$supplier->status->value] ?? 'secondary';
                                                $icon = $statusIcons[$supplier->status->value] ?? 'fa-circle';
                                            @endphp
                                            <span class="badge bg-{{ $color }} bg-opacity-10 text-{{ $color }}">
                                                <i class="fas {{ $icon }} me-1"></i>{{ $supplier->status->label() }}
                                            </span>
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="btn-group">
                                                <a href="{{ route('admin.suppliers.show', $supplier->id) }}"
                                                   class="btn btn-sm btn-outline-secondary" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.suppliers.edit', $supplier->id) }}"
                                                   class="btn btn-sm btn-outline-primary" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-outline-danger"
                                                        onclick="confirmDelete({{ $supplier->id }}, '{{ addslashes($supplier->name) }}')" title="Delete">
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
                        Showing {{ $suppliers->firstItem() }} to {{ $suppliers->lastItem() }} of {{ $suppliers->total() }} entries
                    </div>
                    <div>
                        {{ $suppliers->appends(request()->query())->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-truck fa-3x text-muted mb-3"></i>
                    <h5>No suppliers found</h5>
                    <p class="text-muted">
                        @if(request()->anyFilled(['search', 'status', 'country']))
                            No suppliers match your filters. <a href="{{ route('admin.suppliers.index') }}">Clear filters</a>
                        @else
                            Get started by creating your first supplier.
                        @endif
                    </p>
                    <a href="{{ route('admin.suppliers.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Add Supplier
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
                <h5 class="modal-title">Delete Supplier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete <strong id="deleteName"></strong>?</p>
                <div id="deleteWarning" class="alert alert-warning d-none">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <span id="deleteWarningText"></span>
                </div>
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
    $('#deleteForm').attr('action', `/admin/suppliers/${id}`);
    $('#deleteWarning').addClass('d-none');
    $('#deleteForm button[type="submit"]').prop('disabled', false);

    $.get(`/admin/suppliers/${id}/check-deletable`, function(data) {
        if (!data.deletable) {
            $('#deleteWarningText').text(`Cannot delete: has ${data.product_count} product(s). Remove associations first.`);
            $('#deleteWarning').removeClass('d-none');
            $('#deleteForm button[type="submit"]').prop('disabled', true);
        }
    });

    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}

function bulkDelete() {
    const ids = $('.row-checkbox:checked').map(function() { return $(this).val(); }).get();
    if (!ids.length) return;

    if (confirm('Are you sure you want to delete ' + ids.length + ' selected suppliers?')) {
        $('#bulkForm').attr('action', '{{ route('admin.suppliers.bulk-delete') }}').submit();
    }
}

function bulkUpdateStatus() {
    const ids = $('.row-checkbox:checked').map(function() { return $(this).val(); }).get();
    const status = $('#bulkStatusSelect').val();
    if (!ids.length || !status) return;

    if (confirm('Change status of ' + ids.length + ' suppliers to "' + status + '"?')) {
        $('<form>').attr({ method: 'POST', action: '{{ route('admin.suppliers.bulk-update-status') }}' })
            .append($('<input>').attr({ type: 'hidden', name: '_token', value: '{{ csrf_token() }}' }))
            .append($('<input>').attr({ type: 'hidden', name: 'status', value: status }))
            .append(ids.map(function(id) {
                return $('<input>').attr({ type: 'hidden', name: 'ids[]', value: id });
            }))
            .appendTo('body').submit();
    }
}

function showToast(message, type = 'info') {
    const bgClass = type === 'success' ? 'bg-success' : type === 'error' ? 'bg-danger' : 'bg-info';
    $('body').append(`
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999;">
            <div class="toast ${bgClass} text-white" role="alert">
                <div class="toast-body d-flex align-items-center">
                    <i class="fas fa-${type === 'success' ? 'check' : type === 'error' ? 'times' : 'info'} me-2"></i>
                    ${message}
                </div>
            </div>
        </div>
    `);
    const toast = new bootstrap.Toast($('.toast').last()[0], { delay: 3000 });
    toast.show();
    setTimeout(() => $('.toast').parent().remove(), 3500);
}
</script>
@endpush
