<x-layouts.admin-layout title="Edit Purchase Order">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Edit {{ $purchase->po_number }}</h4>
            <p class="text-muted small mb-0">Update purchase order details</p>
        </div>
        <a href="{{ route('admin.purchases.show', $purchase->id) }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>

    <form method="POST" action="{{ route('admin.purchases.update', $purchase->id) }}" id="purchaseForm">
        @csrf @method('PUT')

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header bg-transparent">
                        <h6 class="fw-bold mb-0">Basic Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Supplier <span class="text-danger">*</span></label>
                                <select name="supplier_id" class="form-select @error('supplier_id') is-invalid @enderror" required>
                                    <option value="">Select supplier</option>
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}" {{ old('supplier_id', $purchase->supplier_id) == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                                    @endforeach
                                </select>
                                @error('supplier_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Warehouse <span class="text-danger">*</span></label>
                                <select name="warehouse_id" class="form-select @error('warehouse_id') is-invalid @enderror" required>
                                    <option value="">Select warehouse</option>
                                    @foreach($warehouses as $warehouse)
                                        <option value="{{ $warehouse->id }}" {{ old('warehouse_id', $purchase->warehouse_id) == $warehouse->id ? 'selected' : '' }}>{{ $warehouse->name }}</option>
                                    @endforeach
                                </select>
                                @error('warehouse_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Purchase Date <span class="text-danger">*</span></label>
                                <input type="date" name="purchase_date" class="form-control @error('purchase_date') is-invalid @enderror" value="{{ old('purchase_date', $purchase->purchase_date?->format('Y-m-d')) }}" required>
                                @error('purchase_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Expected Delivery</label>
                                <input type="date" name="expected_delivery_date" class="form-control @error('expected_delivery_date') is-invalid @enderror" value="{{ old('expected_delivery_date', $purchase->expected_delivery_date?->format('Y-m-d')) }}">
                                @error('expected_delivery_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Reference Number</label>
                                <input type="text" name="reference_number" class="form-control @error('reference_number') is-invalid @enderror" value="{{ old('reference_number', $purchase->reference_number) }}">
                                @error('reference_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Currency</label>
                                <select name="currency" class="form-select @error('currency') is-invalid @enderror">
                                    <option value="BDT" {{ old('currency', $purchase->currency) == 'BDT' ? 'selected' : '' }}>BDT</option>
                                    <option value="USD" {{ old('currency', $purchase->currency) == 'USD' ? 'selected' : '' }}>USD</option>
                                </select>
                                @error('currency')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Exchange Rate</label>
                                <input type="number" step="0.0001" name="exchange_rate" class="form-control" value="{{ old('exchange_rate', $purchase->exchange_rate) }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold mb-0">Products / Items</h6>
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="addItem()">
                            <i class="fas fa-plus me-1"></i> Add Item
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="itemsTable">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width:5%">#</th>
                                        <th style="width:30%">Product</th>
                                        <th style="width:10%">SKU</th>
                                        <th style="width:10%">Qty</th>
                                        <th style="width:12%">Price</th>
                                        <th style="width:10%">Disc %</th>
                                        <th style="width:10%">Tax %</th>
                                        <th style="width:10%">Total</th>
                                        <th style="width:3%"></th>
                                    </tr>
                                </thead>
                                <tbody id="itemsBody">
                                    @foreach($purchase->items as $item)
                                        <tr id="itemRow{{ $loop->index }}">
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm product-search" data-index="{{ $loop->index }}"
                                                       value="{{ $item->product_name }}" autocomplete="off">
                                                <input type="hidden" name="items[{{ $loop->index }}][product_id]" class="product-id" value="{{ $item->product_id }}">
                                                <input type="hidden" name="items[{{ $loop->index }}][product_variant_id]" class="variant-id" value="{{ $item->product_variant_id }}">
                                                <input type="hidden" name="items[{{ $loop->index }}][product_name]" class="product-name" value="{{ $item->product_name }}">
                                                <div class="product-results list-group position-absolute d-none" style="z-index:1000;max-height:200px;overflow-y:auto;width:90%"></div>
                                            </td>
                                            <td><input type="text" name="items[{{ $loop->index }}][sku]" class="form-control form-control-sm item-sku" value="{{ $item->sku }}" readonly></td>
                                            <td><input type="number" name="items[{{ $loop->index }}][quantity]" class="form-control form-control-sm item-qty" value="{{ $item->quantity }}" min="0.01" step="any" oninput="calculateRow({{ $loop->index }})"></td>
                                            <td><input type="number" name="items[{{ $loop->index }}][unit_price]" class="form-control form-control-sm item-price" value="{{ $item->unit_price }}" min="0" step="0.01" oninput="calculateRow({{ $loop->index }})"></td>
                                            <td><input type="number" name="items[{{ $loop->index }}][discount_percentage]" class="form-control form-control-sm item-disc-pct" value="{{ $item->discount_percentage }}" min="0" max="100" step="0.01" oninput="calculateRow({{ $loop->index }})"></td>
                                            <td><input type="number" name="items[{{ $loop->index }}][tax_rate]" class="form-control form-control-sm item-tax" value="{{ $item->tax_rate }}" min="0" max="100" step="0.01" oninput="calculateRow({{ $loop->index }})"></td>
                                            <td><span class="item-total fw-semibold">{{ number_format($item->total, 2) }}</span></td>
                                            <td><button type="button" class="btn btn-sm btn-outline-danger" onclick="removeItem({{ $loop->index }})"><i class="fas fa-times"></i></button></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr><td colspan="5" class="text-end fw-bold">Subtotal:</td><td colspan="3"><span id="subtotalDisplay">{{ number_format($purchase->subtotal, 2) }}</span></td><td></td></tr>
                                    <tr><td colspan="5" class="text-end fw-bold">Discount:</td><td colspan="3"><input type="number" name="discount_amount" id="discountAmount" class="form-control form-control-sm" style="width:120px;display:inline" value="{{ $purchase->discount_amount }}" step="0.01" min="0" oninput="calculateTotals()"></td><td></td></tr>
                                    <tr><td colspan="5" class="text-end fw-bold">Shipping:</td><td colspan="3"><input type="number" name="shipping_cost" id="shippingCost" class="form-control form-control-sm" style="width:120px;display:inline" value="{{ $purchase->shipping_cost }}" step="0.01" min="0" oninput="calculateTotals()"></td><td></td></tr>
                                    <tr><td colspan="5" class="text-end fw-bold">Tax:</td><td colspan="3"><input type="number" name="tax_amount" id="taxAmount" class="form-control form-control-sm" style="width:120px;display:inline" value="{{ $purchase->tax_amount }}" step="0.01" min="0" oninput="calculateTotals()"></td><td></td></tr>
                                    <tr class="table-active"><td colspan="5" class="text-end fw-bold fs-5">Grand Total:</td><td colspan="3"><span id="grandTotalDisplay" class="fs-5 fw-bold">{{ number_format($purchase->total_amount, 2) }}</span></td><td></td></tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header bg-transparent">
                        <h6 class="fw-bold mb-0">Notes & Terms</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Notes</label>
                            <textarea name="notes" class="form-control" rows="3">{{ old('notes', $purchase->notes) }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Payment Terms</label>
                            <textarea name="terms" class="form-control" rows="3">{{ old('terms', $purchase->terms) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary btn-lg w-100 mb-2">
                            <i class="fas fa-save me-2"></i> Update Purchase Order
                        </button>
                        <a href="{{ route('admin.purchases.show', $purchase->id) }}" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-times me-2"></i> Cancel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>

</x-layouts.admin-layout>

@push('scripts')
<script>
const products = @json($products);
let maxIndex = {{ $purchase->items->count() }};

function addItem() {
    const index = maxIndex++;
    const tbody = document.getElementById('itemsBody');
    const tr = document.createElement('tr');
    tr.id = `itemRow${index}`;
    tr.innerHTML = `
        <td class="text-center">${index + 1}</td>
        <td>
            <input type="text" class="form-control form-control-sm product-search" data-index="${index}" placeholder="Search product..." autocomplete="off">
            <input type="hidden" name="items[${index}][product_id]" class="product-id" value="">
            <input type="hidden" name="items[${index}][product_variant_id]" class="variant-id" value="">
            <input type="hidden" name="items[${index}][product_name]" class="product-name" value="">
            <div class="product-results list-group position-absolute d-none" style="z-index:1000;max-height:200px;overflow-y:auto;width:90%"></div>
        </td>
        <td><input type="text" name="items[${index}][sku]" class="form-control form-control-sm item-sku" readonly></td>
        <td><input type="number" name="items[${index}][quantity]" class="form-control form-control-sm item-qty" value="1" min="0.01" step="any" oninput="calculateRow(${index})"></td>
        <td><input type="number" name="items[${index}][unit_price]" class="form-control form-control-sm item-price" value="0" min="0" step="0.01" oninput="calculateRow(${index})"></td>
        <td><input type="number" name="items[${index}][discount_percentage]" class="form-control form-control-sm item-disc-pct" value="0" min="0" max="100" step="0.01" oninput="calculateRow(${index})"></td>
        <td><input type="number" name="items[${index}][tax_rate]" class="form-control form-control-sm item-tax" value="0" min="0" max="100" step="0.01" oninput="calculateRow(${index})"></td>
        <td><span class="item-total fw-semibold">0.00</span></td>
        <td><button type="button" class="btn btn-sm btn-outline-danger" onclick="removeItem(${index})"><i class="fas fa-times"></i></button></td>
    `;
    tbody.appendChild(tr);
    setupProductSearch(index);
}

function removeItem(index) {
    const row = document.getElementById(`itemRow${index}`);
    if (document.getElementById('itemsBody').children.length > 1) {
        row.remove();
        calculateTotals();
    }
}

function setupProductSearch(index) {
    const input = document.querySelector(`.product-search[data-index="${index}"]`);
    const resultsDiv = input.closest('td').querySelector('.product-results');
    let timeout;

    input.addEventListener('input', function() {
        clearTimeout(timeout);
        const query = this.value;
        if (query.length < 1) { resultsDiv.classList.add('d-none'); return; }
        timeout = setTimeout(() => {
            const filtered = products.filter(p =>
                p.name.toLowerCase().includes(query.toLowerCase()) ||
                p.sku.toLowerCase().includes(query.toLowerCase())
            );
            if (filtered.length > 0) {
                let html = '';
                filtered.forEach(p => {
                    if (p.variants && p.variants.length > 0) {
                        p.variants.forEach(v => {
                            html += `<button type="button" class="list-group-item list-group-item-action py-1 small"
                                onclick="selectProduct(${index}, ${p.id}, ${v.id}, '${p.name.replace(/'/g, "\\'")} - ${v.name.replace(/'/g, "\\'")}', '${v.sku || p.sku}', ${v.cost_price || v.price || 0})">
                                ${p.name} - ${v.name} (${v.sku || p.sku})</button>`;
                        });
                    } else {
                        html += `<button type="button" class="list-group-item list-group-item-action py-1 small"
                            onclick="selectProduct(${index}, ${p.id}, null, '${p.name.replace(/'/g, "\\'")}', '${p.sku}', ${p.cost_price || p.price || 0})">
                            ${p.name} (${p.sku})</button>`;
                    }
                });
                resultsDiv.innerHTML = html;
                resultsDiv.classList.remove('d-none');
            } else {
                resultsDiv.classList.add('d-none');
            }
        }, 200);
    });

    document.addEventListener('click', function(e) {
        if (!e.target.closest(`.product-search[data-index="${index}"]`) && !e.target.closest(`#itemRow${index} .product-results`)) {
            resultsDiv.classList.add('d-none');
        }
    });
}

function selectProduct(index, productId, variantId, name, sku, price) {
    const row = document.getElementById(`itemRow${index}`);
    row.querySelector('.product-search').value = name;
    row.querySelector('.product-id').value = productId;
    row.querySelector('.variant-id').value = variantId || '';
    row.querySelector('.product-name').value = name;
    row.querySelector('.item-sku').value = sku;
    row.querySelector('.item-price').value = price;
    row.querySelector('.product-results').classList.add('d-none');
    calculateRow(index);
    row.querySelector('.item-qty').focus();
}

function calculateRow(index) {
    const row = document.getElementById(`itemRow${index}`);
    if (!row) return;
    const qty = parseFloat(row.querySelector('.item-qty').value) || 0;
    const price = parseFloat(row.querySelector('.item-price').value) || 0;
    const discPct = parseFloat(row.querySelector('.item-disc-pct').value) || 0;
    const taxRate = parseFloat(row.querySelector('.item-tax').value) || 0;
    const subtotal = qty * price;
    const discount = subtotal * discPct / 100;
    const tax = (subtotal - discount) * taxRate / 100;
    const total = subtotal - discount + tax;
    row.querySelector('.item-total').textContent = total.toFixed(2);
    calculateTotals();
}

function calculateTotals() {
    let subtotal = 0;
    document.querySelectorAll('.item-total').forEach(el => { subtotal += parseFloat(el.textContent) || 0; });
    const discount = parseFloat(document.getElementById('discountAmount').value) || 0;
    const shipping = parseFloat(document.getElementById('shippingCost').value) || 0;
    const tax = parseFloat(document.getElementById('taxAmount').value) || 0;
    const grand = subtotal - discount + shipping + tax;
    document.getElementById('subtotalDisplay').textContent = subtotal.toFixed(2);
    document.getElementById('grandTotalDisplay').textContent = grand.toFixed(2);
}

document.querySelectorAll('.product-search').forEach(el => {
    const idx = parseInt(el.dataset.index);
    setupProductSearch(idx);
});
</script>
@endpush
