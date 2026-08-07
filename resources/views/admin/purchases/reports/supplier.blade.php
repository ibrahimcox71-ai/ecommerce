<x-layouts.admin-layout title="Supplier Purchase Report">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Supplier Purchase Report</h4>
            <p class="text-muted small mb-0">Purchase summary by supplier</p>
        </div>
        <a href="{{ route('admin.purchases.reports') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to Reports
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="GET" class="row g-2 mb-3">
                <div class="col-md-3">
                    <select name="supplier_id" class="form-select">
                        <option value="">All Suppliers</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" {{ request('supplier_id') == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
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
                            <th class="text-end">Items</th>
                            <th class="text-end">Total</th>
                            <th class="text-end">Paid</th>
                            <th class="text-end">Due</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($purchases as $purchase)
                            <tr>
                                <td><a href="{{ route('admin.purchases.show', $purchase->id) }}">{{ $purchase->po_number }}</a></td>
                                <td>{{ $purchase->supplier?->name }}</td>
                                <td>{{ $purchase->purchase_date?->format('d/m/Y') }}</td>
                                <td class="text-end">{{ $purchase->items->count() }}</td>
                                <td class="text-end fw-semibold">{{ number_format($purchase->total_amount, 2) }}</td>
                                <td class="text-end text-success">{{ number_format($purchase->paid_amount, 2) }}</td>
                                <td class="text-end {{ $purchase->due_amount > 0 ? 'text-danger' : '' }}">{{ number_format($purchase->due_amount, 2) }}</td>
                                <td><span class="badge bg-{{ $purchase->status->color() }}">{{ $purchase->status->label() }}</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="text-center py-4 text-muted">No data found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</x-layouts.admin-layout>
