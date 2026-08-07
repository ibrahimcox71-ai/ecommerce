<x-layouts.admin-layout title="Trashed Products">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Trashed Products</h4>
            <p class="text-muted small mb-0">Deleted products that can be restored</p>
        </div>
        <div>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to Products
            </a>
        </div>
    </div>

    {{-- Bulk Actions --}}
    <div class="d-none" id="bulkActions">
        <div class="alert alert-info d-flex align-items-center justify-content-between mb-3">
            <span><i class="fas fa-check-circle me-2"></i><span id="selectedCount">0</span> selected</span>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-sm btn-success" onclick="bulkRestore()">
                    <i class="fas fa-undo me-1"></i> Restore
                </button>
                <button type="button" class="btn btn-sm btn-danger" onclick="bulkForceDelete()">
                    <i class="fas fa-trash-alt me-1"></i> Permanent Delete
                </button>
            </div>
        </div>
    </div>

    {{-- Products Table --}}
    <div class="card">
        <div class="card-body">
            @if($products->count() > 0)
                <form id="bulkForm" method="POST">
                    @csrf
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0" style="width: 40px;">
                                        <input type="checkbox" class="form-check-input" id="selectAll">
                                    </th>
                                    <th class="border-0">Product</th>
                                    <th class="border-0">SKU</th>
                                    <th class="border-0">Deleted</th>
                                    <th class="border-0 text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                    <tr data-id="{{ $product->id }}">
                                        <td>
                                            <input type="checkbox" name="ids[]" value="{{ $product->id }}" 
                                                   class="form-check-input row-checkbox">
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($product->thumbnail)
                                                    <img src="{{ $product->thumbnail_url }}" alt="{{ $product->name }}" 
                                                         class="rounded me-3" style="width: 48px; height: 48px; object-fit: cover; opacity: 0.6;">
                                                @else
                                                    <div class="rounded me-3 d-flex align-items-center justify-content-center bg-light" 
                                                         style="width: 48px; height: 48px; opacity: 0.6;">
                                                        <i class="fas fa-box text-muted"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <span class="fw-semibold text-muted">{{ $product->name }}</span>
                                                    <small class="d-block text-muted">
                                                        {{ $product->category?->name ?? 'Uncategorized' }}
                                                    </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <code class="text-muted">{{ $product->sku }}</code>
                                        </td>
                                        <td>
                                            <span class="text-muted">{{ $product->deleted_at->format('M d, Y') }}</span>
                                            <small class="d-block text-muted">{{ $product->deleted_at->diffForHumans() }}</small>
                                        </td>
                                        <td class="text-end">
                                            <div class="btn-group">
                                                <form action="{{ route('admin.products.restore', $product->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success" title="Restore">
                                                        <i class="fas fa-undo"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.products.force-delete', $product->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Permanent Delete"
                                                            onclick="return confirm('Are you sure? This cannot be undone!');">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </form>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted small">
                        Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} entries
                    </div>
                    <div>
                        {{ $products->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-trash-alt fa-3x text-muted mb-3"></i>
                    <h5>No trashed products</h5>
                    <p class="text-muted">Products you delete will appear here</p>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Go to Products
                    </a>
                </div>
            @endif
        </div>
    </div>

</x-layouts.admin-layout>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var selectAll = document.getElementById('selectAll');
    var bulkActions = document.getElementById('bulkActions');
    var selectedCount = document.getElementById('selectedCount');
    var bulkForm = document.getElementById('bulkForm');

    if (selectAll) {
        selectAll.addEventListener('change', function() {
            document.querySelectorAll('.row-checkbox').forEach(function(cb) {
                cb.checked = selectAll.checked;
            });
            updateBulkActions();
        });
    }

    document.querySelectorAll('.row-checkbox').forEach(function(cb) {
        cb.addEventListener('change', updateBulkActions);
    });

    function updateBulkActions() {
        var checked = document.querySelectorAll('.row-checkbox:checked').length;
        if (checked > 0) {
            bulkActions.classList.remove('d-none');
            selectedCount.textContent = checked;
        } else {
            bulkActions.classList.add('d-none');
        }
    }
});

function bulkRestore() {
    if (confirm('Are you sure you want to restore selected products?')) {
        document.getElementById('bulkForm').action = '{{ route('admin.products.bulk-restore') }}';
        document.getElementById('bulkForm').submit();
    }
}

function bulkForceDelete() {
    if (confirm('Are you sure? This will permanently delete the products and cannot be undone!')) {
        document.getElementById('bulkForm').action = '{{ route('admin.products.bulk-force-delete') }}';
        document.getElementById('bulkForm').submit();
    }
}
</script>
@endpush
