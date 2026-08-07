<x-layouts.admin-layout title="Create Order">

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <a href="{{ route('admin.orders.index') }}" class="text-muted text-decoration-none small">
            <i class="fas fa-arrow-left me-1"></i>Back to Orders
        </a>
        <h4 class="fw-bold mb-0 mt-1">Create New Order</h4>
        <p class="text-muted small mb-0">Create a manual order for a customer</p>
    </div>
</div>

<form method="POST" action="{{ route('admin.orders.store') }}" id="orderForm">
    @csrf

    <div class="row g-4">
        <div class="col-lg-8">
            {{-- Customer Selection --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="fw-bold mb-0"><i class="fas fa-user me-2 text-primary"></i>Customer</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Select Customer</label>
                            <select name="user_id" class="form-select" id="customerSelect">
                                <option value="">Guest Checkout</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}"
                                        data-name="{{ $customer->name }}"
                                        data-email="{{ $customer->email }}"
                                        data-phone="{{ $customer->phone }}"
                                        {{ $selectedCustomer && $selectedCustomer->id === $customer->id ? 'selected' : '' }}>
                                        {{ $customer->name }} ({{ $customer->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Payment Method</label>
                            <select name="payment_method" class="form-select">
                                <option value="cod">Cash on Delivery</option>
                                <option value="bank_transfer">Bank Transfer</option>
                                <option value="card">Card</option>
                                <option value="mobile_banking">Mobile Banking</option>
                                <option value="wallet">Wallet</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Order Items --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0"><i class="fas fa-box me-2 text-primary"></i>Order Items</h5>
                    <button type="button" class="btn btn-sm btn-outline-primary" id="addItemBtn">
                        <i class="fas fa-plus me-1"></i>Add Item
                    </button>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0" id="itemsTable">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 35%;">Product</th>
                                    <th style="width: 10%;">Qty</th>
                                    <th style="width: 15%;">Price</th>
                                    <th style="width: 10%;">Discount</th>
                                    <th style="width: 15%;">Subtotal</th>
                                    <th style="width: 5%;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="item-row">
                                    <td>
                                        <select name="items[0][product_id]" class="form-select form-select-sm product-select">
                                            <option value="">Search product...</option>
                                            @foreach($products as $product)
                                                <option value="{{ $product->id }}"
                                                    data-name="{{ $product->name }}"
                                                    data-sku="{{ $product->sku }}"
                                                    data-price="{{ $product->price }}">
                                                    {{ $product->name }} ({{ $product->sku }})
                                                </option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="items[0][product_name]" class="product-name">
                                        <input type="hidden" name="items[0][product_sku]" class="product-sku">
                                    </td>
                                    <td>
                                        <input type="number" name="items[0][quantity]" class="form-control form-control-sm item-qty" value="1" min="1" step="1">
                                    </td>
                                    <td>
                                        <input type="number" name="items[0][unit_price]" class="form-control form-control-sm item-price" step="0.01" min="0">
                                    </td>
                                    <td>
                                        <input type="number" name="items[0][discount]" class="form-control form-control-sm item-discount" step="0.01" min="0" value="0">
                                    </td>
                                    <td>
                                        <input type="number" name="items[0][subtotal]" class="form-control form-control-sm item-subtotal" step="0.01" readonly>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-outline-danger remove-item" disabled>
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="3"></td>
                                    <td class="text-end fw-semibold">Subtotal:</td>
                                    <td class="text-end fw-bold" id="subtotalDisplay">$0.00</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="3"></td>
                                    <td class="text-end fw-semibold">Shipping:</td>
                                    <td class="text-end">
                                        <input type="number" name="shipping_cost" id="shippingCost" class="form-control form-control-sm text-end" step="0.01" min="0" value="0" style="width: 130px;">
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="3"></td>
                                    <td class="text-end fw-semibold">Tax Rate (%):</td>
                                    <td class="text-end">
                                        <div class="input-group input-group-sm" style="width: 130px; margin-left: auto;">
                                            <input type="number" name="tax_rate" id="taxRate" class="form-control text-end" step="0.01" min="0" value="{{ config('ecommerce.tax_rate', 0) }}">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="3"></td>
                                    <td class="text-end fw-semibold">Tax Amount:</td>
                                    <td class="text-end fw-bold" id="taxDisplay">$0.00</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="3"></td>
                                    <td class="text-end fw-semibold">Discount:</td>
                                    <td class="text-end">
                                        <input type="number" name="coupon_discount" id="couponDiscount" class="form-control form-control-sm text-end" step="0.01" min="0" value="0" style="width: 130px;">
                                    </td>
                                    <td></td>
                                </tr>
                                <tr class="border-top">
                                    <td colspan="3"></td>
                                    <td class="text-end fw-bold fs-5">Total:</td>
                                    <td class="text-end fw-bold fs-5 text-primary" id="totalDisplay">$0.00</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Shipping Info --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="fw-bold mb-0"><i class="fas fa-truck me-2 text-primary"></i>Shipping Information</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-2">
                            <label class="form-label small fw-semibold">Method</label>
                            <select name="shipping_method" class="form-select">
                                <option value="standard">Standard</option>
                                <option value="express">Express</option>
                                <option value="overnight">Overnight</option>
                                <option value="free">Free</option>
                            </select>
                        </div>
                        <div class="col-md-10"></div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold">Name</label>
                            <input type="text" name="shipping_address[name]" class="form-control" value="{{ $selectedCustomer?->name ?? old('shipping_address.name') }}" id="shipName">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold">Email</label>
                            <input type="email" name="shipping_address[email]" class="form-control" value="{{ $selectedCustomer?->email ?? old('shipping_address.email') }}" id="shipEmail">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold">Phone</label>
                            <input type="text" name="shipping_address[phone]" class="form-control" value="{{ $selectedCustomer?->phone ?? old('shipping_address.phone') }}" id="shipPhone">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Address Line 1</label>
                            <input type="text" name="shipping_address[address_line1]" class="form-control" value="{{ old('shipping_address.address_line1') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Address Line 2</label>
                            <input type="text" name="shipping_address[address_line2]" class="form-control" value="{{ old('shipping_address.address_line2') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-semibold">City</label>
                            <input type="text" name="shipping_address[city]" class="form-control" value="{{ old('shipping_address.city') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-semibold">State</label>
                            <input type="text" name="shipping_address[state]" class="form-control" value="{{ old('shipping_address.state') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-semibold">ZIP</label>
                            <input type="text" name="shipping_address[zip]" class="form-control" value="{{ old('shipping_address.zip') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-semibold">Country</label>
                            <input type="text" name="shipping_address[country]" class="form-control" value="{{ old('shipping_address.country', 'US') }}">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Notes --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="fw-bold mb-0"><i class="fas fa-sticky-note me-2 text-primary"></i>Notes</h5>
                </div>
                <div class="card-body">
                    <textarea name="notes" class="form-control" rows="3" placeholder="Internal notes...">{{ old('notes') }}</textarea>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            {{-- Order Summary --}}
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white py-3">
                    <h6 class="fw-bold mb-0"><i class="fas fa-receipt me-2 text-primary"></i>Order Summary</h6>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr>
                            <td class="text-muted">Items</td>
                            <td class="text-end" id="itemCount">0</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Subtotal</td>
                            <td class="text-end" id="summarySubtotal">$0.00</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Shipping</td>
                            <td class="text-end" id="summaryShipping">$0.00</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Tax</td>
                            <td class="text-end" id="summaryTax">$0.00</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Discount</td>
                            <td class="text-end text-danger" id="summaryDiscount">-$0.00</td>
                        </tr>
                        <tr class="border-top">
                            <td class="fw-bold">Grand Total</td>
                            <td class="text-end fw-bold fs-5 text-primary" id="summaryTotal">$0.00</td>
                        </tr>
                    </table>
                </div>
            </div>

            {{-- Submit --}}
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <button type="submit" class="btn btn-primary w-100 btn-lg" id="submitBtn">
                        <i class="fas fa-save me-2"></i>Create Order
                    </button>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary w-100 mt-2">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let rowIndex = 1;

    function calculateRow(row) {
        const qty = parseFloat(row.querySelector('.item-qty').value) || 0;
        const price = parseFloat(row.querySelector('.item-price').value) || 0;
        const discount = parseFloat(row.querySelector('.item-discount').value) || 0;
        const subtotal = (qty * price) - discount;
        row.querySelector('.item-subtotal').value = subtotal.toFixed(2);
        calculateTotal();
    }

    function calculateTotal() {
        let subtotal = 0;
        let itemCount = 0;
        document.querySelectorAll('.item-row').forEach(row => {
            subtotal += parseFloat(row.querySelector('.item-subtotal').value) || 0;
            itemCount += parseInt(row.querySelector('.item-qty').value) || 0;
        });

        const shipping = parseFloat(document.getElementById('shippingCost').value) || 0;
        const taxRate = parseFloat(document.getElementById('taxRate').value) || 0;
        const discount = parseFloat(document.getElementById('couponDiscount').value) || 0;
        const taxAmount = subtotal * (taxRate / 100);
        const total = subtotal + shipping + taxAmount - discount;

        document.getElementById('subtotalDisplay').textContent = '$' + subtotal.toFixed(2);
        document.getElementById('taxDisplay').textContent = '$' + taxAmount.toFixed(2);
        document.getElementById('totalDisplay').textContent = '$' + Math.max(0, total).toFixed(2);

        document.getElementById('itemCount').textContent = itemCount;
        document.getElementById('summarySubtotal').textContent = '$' + subtotal.toFixed(2);
        document.getElementById('summaryShipping').textContent = '$' + shipping.toFixed(2);
        document.getElementById('summaryTax').textContent = '$' + taxAmount.toFixed(2);
        document.getElementById('summaryDiscount').textContent = '-$' + discount.toFixed(2);
        document.getElementById('summaryTotal').textContent = '$' + Math.max(0, total).toFixed(2);
    }

    function addItemRow() {
        const tbody = document.querySelector('#itemsTable tbody');
        const row = document.querySelector('.item-row').cloneNode(true);

        row.querySelectorAll('select, input').forEach(el => {
            const name = el.getAttribute('name');
            if (name) {
                el.setAttribute('name', name.replace(/\[\d+\]/, '[' + rowIndex + ']'));
            }
            if (el.type !== 'hidden') {
                el.value = el.classList.contains('item-qty') ? '1' : el.classList.contains('item-discount') ? '0' : '';
            }
        });

        row.querySelector('.remove-item').disabled = false;
        tbody.appendChild(row);

        row.querySelectorAll('.item-qty, .item-price, .item-discount').forEach(el => {
            el.addEventListener('input', () => calculateRow(row));
        });

        const productSelect = row.querySelector('.product-select');
        productSelect.addEventListener('change', function() {
            const option = this.options[this.selectedIndex];
            if (option.value) {
                row.querySelector('.product-name').value = option.dataset.name;
                row.querySelector('.product-sku').value = option.dataset.sku;
                row.querySelector('.item-price').value = option.dataset.price;
                calculateRow(row);
            }
        });

        row.querySelector('.remove-item').addEventListener('click', function() {
            if (document.querySelectorAll('.item-row').length > 1) {
                row.remove();
                calculateTotal();
            }
        });

        rowIndex++;
    }

    document.getElementById('addItemBtn').addEventListener('click', addItemRow);

    document.querySelectorAll('.item-row').forEach(row => {
        row.querySelectorAll('.item-qty, .item-price, .item-discount').forEach(el => {
            el.addEventListener('input', () => calculateRow(row));
        });

        const productSelect = row.querySelector('.product-select');
        productSelect.addEventListener('change', function() {
            const option = this.options[this.selectedIndex];
            if (option.value) {
                row.querySelector('.product-name').value = option.dataset.name;
                row.querySelector('.product-sku').value = option.dataset.sku;
                row.querySelector('.item-price').value = option.dataset.price;
                calculateRow(row);
            }
        });
    });

    document.getElementById('shippingCost').addEventListener('input', calculateTotal);
    document.getElementById('taxRate').addEventListener('input', calculateTotal);
    document.getElementById('couponDiscount').addEventListener('input', calculateTotal);

    document.getElementById('customerSelect').addEventListener('change', function() {
        const option = this.options[this.selectedIndex];
        if (option.value) {
            document.getElementById('shipName').value = option.dataset.name || '';
            document.getElementById('shipEmail').value = option.dataset.email || '';
            document.getElementById('shipPhone').value = option.dataset.phone || '';
        }
    });

    calculateTotal();
});
</script>
@endpush

</x-layouts.admin-layout>
