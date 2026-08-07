<x-layouts.admin-layout title="New Stock Movement">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">New Stock Movement</h4>
            <p class="text-muted small mb-0">Record stock movement (stock in, out, transfer, damage, etc.)</p>
        </div>
        <a href="{{ route('admin.stock-movements.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Movement Details</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.stock-movements.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label class="form-label">Barcode Scanner</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="fas fa-barcode"></i></span>
                                <input type="text" class="form-control" id="barcodeInput" placeholder="Scan or type barcode..." autofocus>
                                <button type="button" class="btn btn-outline-primary" onclick="lookupBarcode()">
                                    <i class="fas fa-search"></i> Lookup
                                </button>
                            </div>
                            <div id="barcodeResult" class="mt-2 small"></div>
                        </div>

                        <hr>

                        <div class="mb-3">
                            <label for="product_search" class="form-label">Search Product <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
                                <input type="text" class="form-control" id="product_search"
                                       placeholder="Search by name, SKU, or barcode..." autocomplete="off">
                                <input type="hidden" name="product_id" id="product_id" required>
                                <input type="hidden" name="product_variant_id" id="product_variant_id">
                            </div>
                            <div id="productResults" class="list-group position-absolute shadow-sm d-none" style="z-index: 1000; max-height: 300px; overflow-y: auto; width: calc(100% - 2.5rem);"></div>
                            @error('product_id')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="movement_type" class="form-label">Movement Type <span class="text-danger">*</span></label>
                            <select name="movement_type" id="movement_type" class="form-select" required>
                                <option value="">Select type</option>
                                @foreach($movementTypes as $val => $label)
                                    <option value="{{ $val }}" {{ old('movement_type') === $val ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row" id="transferFields">
                            <div class="col-md-6 mb-3">
                                <label for="from_warehouse_id" class="form-label">From Warehouse</label>
                                <select name="from_warehouse_id" id="from_warehouse_id" class="form-select">
                                    <option value="">Select source warehouse</option>
                                    @foreach($warehouses as $warehouse)
                                        <option value="{{ $warehouse->id }}" {{ old('from_warehouse_id') == $warehouse->id ? 'selected' : '' }}>{{ $warehouse->name }} ({{ $warehouse->code }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="to_warehouse_id" class="form-label">To Warehouse</label>
                                <select name="to_warehouse_id" id="to_warehouse_id" class="form-select">
                                    <option value="">Select destination warehouse</option>
                                    @foreach($warehouses as $warehouse)
                                        <option value="{{ $warehouse->id }}" {{ old('to_warehouse_id') == $warehouse->id ? 'selected' : '' }}>{{ $warehouse->name }} ({{ $warehouse->code }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="quantity" name="quantity"
                                   value="{{ old('quantity') }}" min="1" placeholder="Enter quantity" required>
                        </div>

                        <div class="mb-3">
                            <label for="reason" class="form-label">Reason</label>
                            <input type="text" class="form-control" id="reason" name="reason"
                                   value="{{ old('reason') }}" placeholder="e.g., Purchase order, Transfer, Damage">
                        </div>

                        <div class="mb-0">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control" id="notes" name="notes" rows="2" placeholder="Optional notes">{{ old('notes') }}</textarea>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-2"></i> Record Movement
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
            <div class="card mb-4">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Movement Types</h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0 small">
                        <li class="mb-2"><i class="fas fa-plus-circle text-success me-2"></i><strong>Stock In</strong> - Add stock to warehouse</li>
                        <li class="mb-2"><i class="fas fa-minus-circle text-danger me-2"></i><strong>Stock Out</strong> - Remove stock from warehouse</li>
                        <li class="mb-2"><i class="fas fa-exchange-alt text-info me-2"></i><strong>Transfer</strong> - Move stock between warehouses</li>
                        <li class="mb-2"><i class="fas fa-balance-scale text-warning me-2"></i><strong>Adjustment</strong> - Correct stock levels</li>
                        <li class="mb-2"><i class="fas fa-undo text-primary me-2"></i><strong>Return</strong> - Customer returns</li>
                        <li class="mb-2"><i class="fas fa-exclamation-circle text-danger me-2"></i><strong>Damage</strong> - Damaged stock</li>
                        <li class="mb-0"><i class="fas fa-question-circle text-secondary me-2"></i><strong>Lost</strong> - Missing stock</li>
                    </ul>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Tips</h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0 small">
                        <li class="mb-2"><i class="fas fa-barcode text-primary me-2"></i>Scan barcode for quick product selection</li>
                        <li class="mb-2"><i class="fas fa-warehouse text-info me-2"></i>Select correct source/destination warehouse</li>
                        <li class="mb-0"><i class="fas fa-sticky-note text-muted me-2"></i>Always add a reason for audit trail</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</x-layouts.admin-layout>

@push('scripts')
<script>
let searchTimeout;

document.addEventListener('DOMContentLoaded', function() {
    toggleTransferFields();

    document.getElementById('movement_type').addEventListener('change', toggleTransferFields);
    document.getElementById('product_search').addEventListener('input', function() {
        clearTimeout(searchTimeout);
        const query = this.value;
        if (query.length < 1) {
            document.getElementById('productResults').classList.add('d-none');
            return;
        }
        searchTimeout = setTimeout(() => searchProducts(query), 300);
    });
});

function toggleTransferFields() {
    const type = document.getElementById('movement_type').value;
    const transferFields = document.getElementById('transferFields');
    const fromLabel = document.querySelector('label[for="from_warehouse_id"]');
    const toLabel = document.querySelector('label[for="to_warehouse_id"]');

    transferFields.style.display = 'flex';

    if (type === 'transfer') {
        document.getElementById('from_warehouse_id').required = true;
        document.getElementById('to_warehouse_id').required = true;
        fromLabel.textContent = 'From Warehouse *';
        toLabel.textContent = 'To Warehouse *';
    } else if (['stock_out', 'damage', 'lost'].includes(type)) {
        document.getElementById('from_warehouse_id').required = true;
        document.getElementById('to_warehouse_id').required = false;
        document.getElementById('to_warehouse_id').closest('.col-md-6').style.display = 'none';
        document.getElementById('from_warehouse_id').closest('.col-md-6').className = 'col-md-12 mb-3';
        fromLabel.textContent = 'Warehouse *';
    } else if (['stock_in', 'return'].includes(type)) {
        document.getElementById('from_warehouse_id').required = false;
        document.getElementById('to_warehouse_id').required = true;
        document.getElementById('from_warehouse_id').closest('.col-md-6').style.display = 'none';
        document.getElementById('to_warehouse_id').closest('.col-md-6').className = 'col-md-12 mb-3';
        toLabel.textContent = 'Warehouse *';
    } else {
        transferFields.style.display = 'none';
    }
}

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
