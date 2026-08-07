<x-layouts.admin-layout title="Purchase Report">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Purchase Report</h4>
            <p class="text-muted small mb-0">Purchase order summary</p>
        </div>
        <a href="{{ route('admin.purchases.reports') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to Reports
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="GET" class="row g-2 mb-3">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        @foreach(App\Enums\PurchaseStatus::cases() as $s)
                            <option value="{{ $s->value }}" {{ request('status') == $s->value ? 'selected' : '' }}>{{ $s->label() }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}" placeholder="From">
                </div>
                <div class="col-md-2">
                    <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}" placeholder="To">
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i></button>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>PO Number</th>
                            <th>Supplier</th>
                            <th>Date</th>
                            <th>Items</th>
                            <th class="text-end">Subtotal</th>
                            <th class="text-end">Discount</th>
                            <th class="text-end">Tax</th>
                            <th class="text-end">Shipping</th>
                            <th class="text-end">Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($purchases as $purchase)
                            <tr>
                                <td><a href="{{ route('admin.purchases.show', $purchase->id) }}">{{ $purchase->po_number }}</a></td>
                                <td>{{ $purchase->supplier?->name }}</td>
                                <td>{{ $purchase->purchase_date?->format('d/m/Y') }}</td>
                                <td>{{ $purchase->items->count() }}</td>
                                <td class="text-end">{{ number_format($purchase->subtotal, 2) }}</td>
                                <td class="text-end">{{ number_format($purchase->discount_amount, 2) }}</td>
                                <td class="text-end">{{ number_format($purchase->tax_amount, 2) }}</td>
                                <td class="text-end">{{ number_format($purchase->shipping_cost, 2) }}</td>
                                <td class="text-end fw-semibold">{{ number_format($purchase->total_amount, 2) }}</td>
                                <td><span class="badge bg-{{ $purchase->status->color() }}">{{ $purchase->status->label() }}</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="10" class="text-center py-4 text-muted">No data found.</td></tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr class="fw-bold">
                            <td colspan="4" class="text-end">Totals:</td>
                            <td class="text-end">{{ number_format($purchases->sum('subtotal'), 2) }}</td>
                            <td class="text-end">{{ number_format($purchases->sum('discount_amount'), 2) }}</td>
                            <td class="text-end">{{ number_format($purchases->sum('tax_amount'), 2) }}</td>
                            <td class="text-end">{{ number_format($purchases->sum('shipping_cost'), 2) }}</td>
                            <td class="text-end">{{ number_format($purchases->sum('total_amount'), 2) }}</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

</x-layouts.admin-layout>
