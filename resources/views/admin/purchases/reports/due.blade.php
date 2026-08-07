<x-layouts.admin-layout title="Outstanding Due Report">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Outstanding Due Report</h4>
            <p class="text-muted small mb-0">Unpaid and partially paid purchase orders</p>
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
                <div class="col-md-3">
                    <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}" placeholder="From">
                </div>
                <div class="col-md-3">
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
                            <th class="text-end">Total</th>
                            <th class="text-end">Paid</th>
                            <th class="text-end">Due</th>
                            <th>Payment Status</th>
                            <th>Days Overdue</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($purchases as $purchase)
                            @php
                                $daysOverdue = $purchase->expected_delivery_date ? now()->diffInDays($purchase->expected_delivery_date, false) : 0;
                            @endphp
                            <tr>
                                <td><a href="{{ route('admin.purchases.show', $purchase->id) }}">{{ $purchase->po_number }}</a></td>
                                <td>{{ $purchase->supplier?->name }}</td>
                                <td>{{ $purchase->purchase_date?->format('d/m/Y') }}</td>
                                <td class="text-end fw-semibold">{{ number_format($purchase->total_amount, 2) }}</td>
                                <td class="text-end text-success">{{ number_format($purchase->paid_amount, 2) }}</td>
                                <td class="text-end text-danger fw-bold">{{ number_format($purchase->due_amount, 2) }}</td>
                                <td><span class="badge bg-{{ $purchase->payment_status->color() }}">{{ $purchase->payment_status->label() }}</span></td>
                                <td>
                                    @if($daysOverdue > 0)
                                        <span class="badge bg-danger">{{ (int)$daysOverdue }} days</span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="text-center py-4 text-muted">No outstanding dues found.</td></tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr class="fw-bold">
                            <td colspan="3" class="text-end">Totals:</td>
                            <td class="text-end">{{ number_format($purchases->sum('total_amount'), 2) }}</td>
                            <td class="text-end">{{ number_format($purchases->sum('paid_amount'), 2) }}</td>
                            <td class="text-end text-danger">{{ number_format($purchases->sum('due_amount'), 2) }}</td>
                            <td colspan="2"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

</x-layouts.admin-layout>
