<x-layouts.admin-layout title="Edit Order {{ $order->order_number }}">

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <a href="{{ route('admin.orders.show', $order) }}" class="text-muted text-decoration-none small">
            <i class="fas fa-arrow-left me-1"></i>Back to Order
        </a>
        <h4 class="fw-bold mb-0 mt-1">Edit Order #{{ $order->order_number }}</h4>
        <p class="text-muted small mb-0">Update order details and items</p>
    </div>
</div>

<form method="POST" action="{{ route('admin.orders.update', $order) }}" id="orderForm">
    @csrf @method('PUT')

    <div class="row g-4">
        <div class="col-lg-8">
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
                                    <th>Product</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-end">Price</th>
                                    <th class="text-end">Discount</th>
                                    <th class="text-end">Subtotal</th>
                                    <th class="text-center"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $idx => $item)
                                <tr class="item-row">
                                    <td>
                                        <input type="text" name="items[{{ $idx }}][product_name]" class="form-control form-control-sm" value="{{ $item->product_name }}" required>
                                        <input type="hidden" name="items[{{ $idx }}][product_id]" value="{{ $item->product_id }}">
                                        <input type="hidden" name="items[{{ $idx }}][product_sku]" value="{{ $item->product_sku }}">
                                        @if($item->product_sku)
                                            <small class="text-muted">{{ $item->product_sku }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <input type="number" name="items[{{ $idx }}][quantity]" class="form-control form-control-sm item-qty text-center" value="{{ $item->quantity }}" min="1" step="1">
                                    </td>
                                    <td>
                                        <input type="number" name="items[{{ $idx }}][unit_price]" class="form-control form-control-sm item-price text-end" step="0.01" min="0" value="{{ $item->unit_price }}">
                                    </td>
                                    <td>
                                        <input type="number" name="items[{{ $idx }}][discount]" class="form-control form-control-sm item-discount text-end" step="0.01" min="0" value="{{ $item->discount }}">
                                    </td>
                                    <td>
                                        <input type="number" name="items[{{ $idx }}][subtotal]" class="form-control form-control-sm item-subtotal text-end" step="0.01" readonly value="{{ $item->subtotal }}">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-outline-danger remove-item" {{ $loop->first ? 'disabled' : '' }}>
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="4" class="text-end fw-semibold">Subtotal:</td>
                                    <td class="text-end fw-bold" id="subtotalDisplay">${{ number_format($order->subtotal, 2) }}</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-end fw-semibold">Shipping:</td>
                                    <td class="text-end">
                                        <input type="number" name="shipping_cost" id="shippingCost" class="form-control form-control-sm text-end" step="0.01" min="0" value="{{ $order->shipping_cost }}" style="width: 130px; margin-left: auto;">
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-end fw-semibold">Tax Amount:</td>
                                    <td class="text-end fw-bold" id="taxDisplay">${{ number_format($order->tax_amount, 2) }}</td>
                                    <td></td>
                                </tr>
                                <tr class="border-top">
                                    <td colspan="4" class="text-end fw-bold fs-5">Total:</td>
                                    <td class="text-end fw-bold fs-5 text-primary" id="totalDisplay">${{ number_format($order->total, 2) }}</td>
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
                    <h5 class="fw-bold mb-0"><i class="fas fa-truck me-2 text-primary"></i>Shipping & Tracking</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold">Method</label>
                            <select name="shipping_method" class="form-select">
                                <option value="standard" @selected($order->shipping_method === 'standard')>Standard</option>
                                <option value="express" @selected($order->shipping_method === 'express')>Express</option>
                                <option value="overnight" @selected($order->shipping_method === 'overnight')>Overnight</option>
                                <option value="free" @selected($order->shipping_method === 'free')>Free</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold">Carrier</label>
                            <select name="carrier" class="form-select">
                                <option value="">Select Carrier</option>
                                <option value="UPS" @selected($order->carrier === 'UPS')>UPS</option>
                                <option value="FedEx" @selected($order->carrier === 'FedEx')>FedEx</option>
                                <option value="USPS" @selected($order->carrier === 'USPS')>USPS</option>
                                <option value="DHL" @selected($order->carrier === 'DHL')>DHL</option>
                                <option value="Aramex" @selected($order->carrier === 'Aramex')>Aramex</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold">Tracking #</label>
                            <input type="text" name="tracking_number" class="form-control" value="{{ $order->tracking_number }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Tracking URL</label>
                            <input type="url" name="tracking_url" class="form-control" value="{{ $order->tracking_url }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Estimated Delivery</label>
                            <input type="date" name="estimated_delivery" class="form-control" value="{{ $order->estimated_delivery?->format('Y-m-d') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold">Name</label>
                            <input type="text" name="shipping_address[name]" class="form-control" value="{{ $order->shipping_address['name'] ?? '' }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold">Email</label>
                            <input type="email" name="shipping_address[email]" class="form-control" value="{{ $order->shipping_address['email'] ?? '' }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold">Phone</label>
                            <input type="text" name="shipping_address[phone]" class="form-control" value="{{ $order->shipping_address['phone'] ?? '' }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Address</label>
                            <input type="text" name="shipping_address[address_line1]" class="form-control" value="{{ $order->shipping_address['address_line1'] ?? '' }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Address Line 2</label>
                            <input type="text" name="shipping_address[address_line2]" class="form-control" value="{{ $order->shipping_address['address_line2'] ?? '' }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-semibold">City</label>
                            <input type="text" name="shipping_address[city]" class="form-control" value="{{ $order->shipping_address['city'] ?? '' }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-semibold">State</label>
                            <input type="text" name="shipping_address[state]" class="form-control" value="{{ $order->shipping_address['state'] ?? '' }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-semibold">ZIP</label>
                            <input type="text" name="shipping_address[zip]" class="form-control" value="{{ $order->shipping_address['zip'] ?? '' }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-semibold">Country</label>
                            <input type="text" name="shipping_address[country]" class="form-control" value="{{ $order->shipping_address['country'] ?? 'US' }}">
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
                    <textarea name="notes" class="form-control" rows="3">{{ $order->notes }}</textarea>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white py-3">
                    <h6 class="fw-bold mb-0"><i class="fas fa-receipt me-2 text-primary"></i>Order Summary</h6>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr><td class="text-muted">Order #</td><td class="text-end fw-semibold">{{ $order->order_number }}</td></tr>
                        <tr><td class="text-muted">Status</td><td class="text-end"><span class="badge {{ $order->statusBadge() }}">{{ ucfirst($order->status) }}</span></td></tr>
                        <tr><td class="text-muted">Payment</td><td class="text-end"><span class="badge {{ $order->paymentStatusBadge() }}">{{ ucfirst($order->payment_status) }}</span></td></tr>
                        <tr><td class="text-muted">Date</td><td class="text-end">{{ $order->created_at->format('M d, Y') }}</td></tr>
                    </table>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <button type="submit" class="btn btn-primary w-100 btn-lg">
                        <i class="fas fa-save me-2"></i>Update Order
                    </button>
                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-outline-secondary w-100 mt-2">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let rowIndex = {{ $order->items->count() }};

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
        document.querySelectorAll('.item-row').forEach(row => {
            subtotal += parseFloat(row.querySelector('.item-subtotal').value) || 0;
        });

        const shipping = parseFloat(document.getElementById('shippingCost').value) || 0;
        const total = subtotal + shipping;

        document.getElementById('subtotalDisplay').textContent = '$' + subtotal.toFixed(2);
        document.getElementById('totalDisplay').textContent = '$' + Math.max(0, total).toFixed(2);
    }

    function addItemRow() {
        const tbody = document.querySelector('#itemsTable tbody');
        const template = document.querySelector('.item-row');
        const row = template.cloneNode(true);

        row.querySelectorAll('input').forEach(el => {
            const name = el.getAttribute('name');
            if (name) {
                el.setAttribute('name', name.replace(/\[\d+\]/, '[' + rowIndex + ']'));
            }
            if (el.type !== 'hidden' && !el.classList.contains('remove-item')) {
                el.value = el.classList.contains('item-qty') ? '1' : el.classList.contains('item-discount') ? '0' : '';
            }
        });

        row.querySelector('.remove-item').disabled = false;
        tbody.appendChild(row);

        row.querySelectorAll('.item-qty, .item-price, .item-discount').forEach(el => {
            el.addEventListener('input', () => calculateRow(row));
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
        row.querySelector('.remove-item').addEventListener('click', function() {
            if (document.querySelectorAll('.item-row').length > 1) {
                row.remove();
                calculateTotal();
            }
        });
    });

    document.getElementById('shippingCost').addEventListener('input', calculateTotal);
    calculateTotal();
});
</script>
@endpush

</x-layouts.admin-layout>
