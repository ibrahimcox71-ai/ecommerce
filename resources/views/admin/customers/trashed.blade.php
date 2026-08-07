<x-layouts.admin-layout title="Trashed Customers">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Trashed Customers</h4>
            <p class="text-muted small mb-0">Deleted customers can be restored or permanently removed</p>
        </div>
        <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to Customers
        </a>
    </div>

    {{-- Search --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.customers.trashed') }}" class="row g-3">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
                        <input type="text" name="search" class="form-control"
                               placeholder="Search trashed customers..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <select name="per_page" class="form-select">
                        <option value="15" {{ request('per_page') == 15 ? 'selected' : '' }}>15 per page</option>
                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 per page</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 per page</option>
                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100 per page</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-outline-primary w-100">
                        <i class="fas fa-search me-1"></i> Search
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
                <button type="button" class="btn btn-sm btn-success" onclick="bulkRestore()">
                    <i class="fas fa-undo me-1"></i> Restore Selected
                </button>
                <button type="button" class="btn btn-sm btn-danger" onclick="bulkForceDelete()">
                    <i class="fas fa-trash-alt me-1"></i> Delete Permanently
                </button>
            </div>
        </div>
    </div>

    {{-- Trashed Table --}}
    <div class="card">
        <div class="card-body p-0">
            @if($customers->count() > 0)
                <form id="bulkForm" method="POST" action="{{ route('admin.customers.bulk-restore') }}">
                    @csrf
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 ps-4" style="width: 40px;">
                                        <input type="checkbox" class="form-check-input" id="selectAll">
                                    </th>
                                    <th class="border-0">Customer</th>
                                    <th class="border-0 d-none d-md-table-cell">Email</th>
                                    <th class="border-0">Deleted At</th>
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
                                            <div class="d-flex align-items-center">
                                                @if($customer->avatar)
                                                    <img src="{{ $customer->avatar_url }}" alt="{{ $customer->name }}"
                                                         class="rounded-circle me-3" style="width: 40px; height: 40px; object-fit: cover; opacity: 0.6;">
                                                @else
                                                    <div class="rounded-circle me-3 d-flex align-items-center justify-content-center bg-light"
                                                         style="width: 40px; height: 40px; opacity: 0.6;">
                                                        <i class="fas fa-user text-muted"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <span class="fw-semibold text-muted">{{ $customer->name }}</span>
                                                    <small class="d-block text-muted">#{{ $customer->id }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="d-none d-md-table-cell text-muted">
                                            {{ $customer->email ?? '—' }}
                                        </td>
                                        <td>
                                            <div class="small">
                                                <div>{{ $customer->deleted_at->format('M d, Y') }}</div>
                                                <small class="text-muted">{{ $customer->deleted_at->diffForHumans() }}</small>
                                            </div>
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="btn-group">
                                                <form action="{{ route('admin.customers.restore', $customer->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success" title="Restore">
                                                        <i class="fas fa-undo"></i>
                                                    </button>
                                                </form>
                                                <button type="button" class="btn btn-sm btn-outline-danger"
                                                        onclick="confirmForceDelete({{ $customer->id }}, '{{ addslashes($customer->name) }}')" title="Delete Permanently">
                                                    <i class="fas fa-trash-alt"></i>
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
                        Showing {{ $customers->firstItem() ?? 0 }} to {{ $customers->lastItem() ?? 0 }} of {{ $customers->total() }} entries
                    </div>
                    <div>
                        {{ $customers->appends(request()->query())->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-trash-alt fa-3x text-muted mb-3"></i>
                    <h5>No trashed customers</h5>
                    <p class="text-muted">
                        @if(request()->has('search'))
                            No trashed customers match your search. <a href="{{ route('admin.customers.trashed') }}">Clear search</a>
                        @else
                            Deleted customers will appear here
                        @endif
                    </p>
                    <a href="{{ route('admin.customers.index') }}" class="btn btn-primary">
                        <i class="fas fa-users me-1"></i> View Active Customers
                    </a>
                </div>
            @endif
        </div>
    </div>

</x-layouts.admin-layout>

{{-- Force Delete Modal --}}
<div class="modal fade" id="forceDeleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Permanently Delete Customer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Warning:</strong> This action cannot be undone!
                </div>
                <p>Are you sure you want to permanently delete <strong id="forceDeleteName"></strong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="forceDeleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash-alt me-1"></i> Delete Permanently
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

function confirmForceDelete(id, name) {
    $('#forceDeleteName').text(name);
    $('#forceDeleteForm').attr('action', `/admin/customers/${id}/force-delete`);
    new bootstrap.Modal(document.getElementById('forceDeleteModal')).show();
}

function bulkRestore() {
    if (confirm('Are you sure you want to restore selected customers?')) {
        $('#bulkForm').attr('action', '{{ route('admin.customers.bulk-restore') }}').submit();
    }
}

function bulkForceDelete() {
    if (confirm('Are you sure you want to permanently delete selected customers? This cannot be undone!')) {
        $('#bulkForm').attr('action', '{{ route('admin.customers.bulk-force-delete') }}')
            .attr('method', 'POST')
            .find('input[name="_method"]').remove();
        $('<input>').attr({ type: 'hidden', name: '_method', value: 'DELETE' }).appendTo('#bulkForm');
        $('<input>').attr({ type: 'hidden', name: '_token', value: '{{ csrf_token() }}' }).appendTo('#bulkForm');
        $('#bulkForm').submit();
    }
}
</script>
@endpush
