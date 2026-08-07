@props([
    'route' => null,
    'perPage' => 15,
    'total' => 0,
    'from' => 0,
    'to' => 0,
    'deleteUrl' => '',
    'statusUrl' => '',
])

<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2 mb-3">
    <div class="d-flex align-items-center gap-2 flex-wrap bulk-actions d-none" aria-live="polite" aria-atomic="true">
        <span class="text-muted small selected-count">0 selected</span>
        <select class="form-select form-select-sm" id="bulkStatusSelect" aria-label="Bulk action">
            <option value="">-- Actions --</option>
            <option value="active">Set Active</option>
            <option value="inactive">Set Inactive</option>
        </select>
        <button type="button" class="btn btn-primary btn-sm" id="bulkStatusUpdate" aria-label="Apply status update">
            <i class="fas fa-check me-1" aria-hidden="true"></i> Update
        </button>
        <button type="button" class="btn btn-danger btn-sm" id="bulkDelete" aria-label="Delete selected">
            <i class="fas fa-trash me-1" aria-hidden="true"></i> Delete
        </button>
    </div>
    <div class="d-flex align-items-center gap-2 ms-auto">
        <small class="text-muted">
            Showing {{ $from }} to {{ $to }} of {{ $total }} entries
        </small>
        <select class="form-select form-select-sm" id="perPageSelect" aria-label="Items per page" onchange="window.location.href='{{ $route ? route($route) : url()->current() }}?per_page='+this.value">
            <option value="15" @selected($perPage == 15)>15</option>
            <option value="25" @selected($perPage == 25)>25</option>
            <option value="50" @selected($perPage == 50)>50</option>
            <option value="100" @selected($perPage == 100)>100</option>
        </select>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function () {
    const $selectAll = $('#selectAll');
    const $checkboxes = $('.table-checkbox');
    const $bulkActions = $('.bulk-actions');
    const $selectedCount = $('.selected-count');
    const $bulkDelete = $('#bulkDelete');
    const $bulkStatusUpdate = $('#bulkStatusUpdate');
    const deleteUrl = '{{ $deleteUrl ?? "" }}';
    const statusUrl = '{{ $statusUrl ?? "" }}';

    $selectAll?.on('change', function () {
        $checkboxes.prop('checked', this.checked);
        updateBulkActions();
    });

    $checkboxes?.on('change', function () {
        if ($selectAll) $selectAll.prop('checked', $checkboxes.length === $checkboxes.filter(':checked').length);
        updateBulkActions();
    });

    function updateBulkActions() {
        const checked = $checkboxes.filter(':checked');
        if (checked.length > 0) {
            $bulkActions.removeClass('d-none');
            $selectedCount.text(checked.length + ' selected');
        } else {
            $bulkActions.addClass('d-none');
        }
    }

    $bulkDelete?.on('click', function () {
        const ids = $checkboxes.filter(':checked').map(function () { return $(this).val(); }).get();
        if (ids.length === 0) return;
        if (!confirm('Are you sure you want to delete ' + ids.length + ' item(s)?')) return;
        $.post(deleteUrl, { ids: ids, _token: '{{ csrf_token() }}', _method: 'DELETE' }, function () { location.reload(); });
    });

    $bulkStatusUpdate?.on('click', function () {
        const ids = $checkboxes.filter(':checked').map(function () { return $(this).val(); }).get();
        const status = $('#bulkStatusSelect').val();
        if (ids.length === 0 || !status) return;
        $.post(statusUrl, { ids: ids, status: status, _token: '{{ csrf_token() }}' }, function () { location.reload(); });
    });
});
</script>
@endpush
