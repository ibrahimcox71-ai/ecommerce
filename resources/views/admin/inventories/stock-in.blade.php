<x-layouts.admin-layout title="Stock In">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Stock In</h4>
            <p class="text-muted small mb-0">Add stock to inventory</p>
        </div>
        <a href="{{ route('admin.inventories.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to Inventory
        </a>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Add Stock</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.inventories.stock-in.store') }}">
                        @csrf

                        {{-- Barcode Scanner --}}
                        <div class="mb-4">
                            <label class="form-label">Barcode Scanner</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="fas fa-barcode"></i></span>
                                <input type="text" class="form-control" id="barcodeInput" placeholder="Scan or type barcode..." autofocus>
                                <button type="button" class="btn btn-outline-primary" onclick="lookupBarcode()">
                                    <i class="fas fa-search"></i> Lookup
                                </button>
                            </div>
                            <small class="text-muted">Scan barcode to auto-fill product details</small>
                            <div id="barcodeResult" class="mt-2 small"></div>
                        </div>

                        <hr>

                        <div class="mb-3">
                            <label for="product_search" class="form-label">Search Product <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
                                <input type="text" class="form-control" id="product_search"
                                       placeholder="Search by name, SKU, or barcode..."
                                       value="{{ request('product_id') ? (App\Models\Product::find(request('product_id'))?->name ?? '') : '' }}"
                                       autocomplete="off">
                                <input type="hidden" name="product_id" id="product_id" value="{{ request('product_id') }}" required>
                                <input type="hidden" name="product_variant_id" id="product_variant_id" value="{{ request('variant_id') }}">
                            </div>
                            <div id="productResults" class="list-group position-absolute shadow-sm d-none" style="z-index: 1000; max-height: 300px; overflow-y: auto; width: calc(100% - 2.5rem);"></div>
                            @error('product_id')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="warehouse_id" class="form-label">Warehouse <span class="text-danger">*</span></label>
                            <select name="warehouse_id" id="warehouse_id" class="form-select @error('warehouse_id') is-invalid @enderror" required>
                                <option value="">Select warehouse</option>
                                @foreach($warehouses as $warehouse)
                                    <option value="{{ $warehouse->id }}" {{ old('warehouse_id', request('warehouse_id')) == $warehouse->id ? 'selected' : '' }}>
                                        {{ $warehouse->name }} ({{ $warehouse->code }})
                                    </option>
                                @endforeach
                            </select>
                            @error('warehouse_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('quantity') is-invalid @enderror"
                                   id="quantity" name="quantity" value="{{ old('quantity') }}"
                                   min="1" placeholder="Enter quantity to add" required>
                            @error('quantity')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="reason" class="form-label">Reason</label>
                            <input type="text" class="form-control @error('reason') is-invalid @enderror"
                                   id="reason" name="reason" value="{{ old('reason', 'Stock In') }}"
                                   placeholder="e.g., Purchase order received, Return, etc.">
                            @error('reason')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-0">
                            <label for="note" class="form-label">Note</label>
                            <textarea class="form-control @error('note') is-invalid @enderror"
                                      id="note" name="note" rows="2" placeholder="Optional notes">{{ old('note') }}</textarea>
                            @error('note')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-plus-circle me-2"></i> Add Stock
                            </button>
                            <button type="reset" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-undo me-2"></i> Reset
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Tips</h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0 small">
                        <li class="mb-2">
                            <i class="fas fa-barcode text-primary me-2"></i>
                            Use the barcode scanner for quick product lookup
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-plus-circle text-success me-2"></i>
                            Enter the quantity to add to current stock
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-warehouse text-info me-2"></i>
                            Select the correct warehouse location
                        </li>
                        <li>
                            <i class="fas fa-sticky-note text-muted me-2"></i>
                            Add a reason for record keeping
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</x-layouts.admin-layout>

@push('scripts')
<script>
let searchTimeout;

document.getElementById('product_search').addEventListener('input', function() {
    clearTimeout(searchTimeout);
    const query = this.value;
    if (query.length < 1) {
        document.getElementById('productResults').classList.add('d-none');
        return;
    }
    searchTimeout = setTimeout(() => searchProducts(query), 300);
});

function searchProducts(query) {
    axios.get('{{ route('admin.inventories.get-products') }}', {
        params: { search: query }
    }).then(function(response) {
        const results = response.data;
        const container = document.getElementById('productResults');
        if (results.length > 0) {
            let html = '';
            results.forEach(function(item) {
                html += `<button type="button" class="list-group-item list-group-item-action"
                                 onclick="selectProduct(${item.id}, '${item.variant_id ?? null}', '${item.text.replace(/'/g, "\\'")}')">
                            <span class="small">${item.text}</span>
                            ${item.barcode ? `<code class="float-end small">${item.barcode}</code>` : ''}
                         </button>`;
            });
            container.innerHTML = html;
            container.classList.remove('d-none');
        } else {
            container.classList.add('d-none');
        }
    });
}

function selectProduct(id, variantId, text) {
    document.getElementById('product_id').value = id;
    document.getElementById('product_variant_id').value = (variantId && variantId !== 'null') ? variantId : '';
    document.getElementById('product_search').value = text;
    document.getElementById('productResults').classList.add('d-none');
}

document.addEventListener('click', function(e) {
    const container = document.getElementById('productResults');
    if (!e.target.closest('#product_search') && !e.target.closest('#productResults')) {
        container.classList.add('d-none');
    }
});

function lookupBarcode() {
    const barcode = document.getElementById('barcodeInput').value.trim();
    if (!barcode) return;

    axios.get('{{ route('admin.inventories.barcode-lookup') }}', {
        params: { barcode: barcode }
    }).then(function(response) {
        const data = response.data;
        const resultDiv = document.getElementById('barcodeResult');
        if (data.success) {
            if (data.type === 'product') {
                selectProduct(data.data.id, null, data.data.name + ' (' + data.data.sku + ')');
            } else {
                selectProduct(data.data.product_id, data.data.id, data.data.name + ' (' + data.data.sku + ')');
            }
            resultDiv.innerHTML = '<span class="text-success"><i class="fas fa-check-circle"></i> Product found: ' + data.data.name + '</span>';
            document.getElementById('barcodeInput').value = '';
        } else {
            resultDiv.innerHTML = '<span class="text-danger"><i class="fas fa-times-circle"></i> ' + data.message + '</span>';
        }
    }).catch(function() {
        document.getElementById('barcodeResult').innerHTML = '<span class="text-danger"><i class="fas fa-times-circle"></i> Error looking up barcode</span>';
    });
}

document.getElementById('barcodeInput').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        lookupBarcode();
    }
});
</script>
@endpush
