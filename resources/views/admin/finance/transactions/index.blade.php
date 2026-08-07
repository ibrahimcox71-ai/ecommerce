<x-layouts.admin-layout title="Transactions">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div><h4 class="fw-bold mb-1">Transactions</h4><p class="text-muted small mb-0">View all financial transactions</p></div>
        <a href="{{ route('admin.finance.transactions.export.csv', request()->query()) }}" class="btn btn-outline-success"><i class="fas fa-file-csv me-1"></i> Export CSV</a>
    </div>

    <div class="row g-2 mb-4">
        <div class="col-6 col-md-3">
            <div class="card bg-success-subtle border-0"><div class="card-body text-center py-2"><h5 class="fw-bold mb-0 text-success">{{ number_format($stats['total_inflow'], 2) }}</h5><small class="text-muted">Total Inflow</small></div></div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card bg-danger-subtle border-0"><div class="card-body text-center py-2"><h5 class="fw-bold mb-0 text-danger">{{ number_format($stats['total_outflow'], 2) }}</h5><small class="text-muted">Total Outflow</small></div></div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card bg-primary-subtle border-0"><div class="card-body text-center py-2"><h5 class="fw-bold mb-0 text-primary">{{ $stats['total_count'] }}</h5><small class="text-muted">Total Transactions</small></div></div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card bg-warning-subtle border-0"><div class="card-body text-center py-2"><h5 class="fw-bold mb-0 text-warning">{{ $stats['pending_count'] }}</h5><small class="text-muted">Pending</small></div></div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="GET" class="row g-2 mb-3">
                <div class="col-md-3"><input type="text" name="search" class="form-control" placeholder="Search..." value="{{ $filters['search'] ?? '' }}"></div>
                <div class="col-md-2">
                    <select name="type" class="form-select">
                        <option value="">All Types</option>
                        @foreach(['sale','purchase','expense','payment_received','payment_sent','refund','transfer','deposit','withdrawal','adjustment'] as $type)
                            <option value="{{ $type }}" {{ ($filters['type'] ?? '') === $type ? 'selected' : '' }}>{{ ucwords(str_replace('_', ' ', $type)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="direction" class="form-select">
                        <option value="">All Directions</option>
                        <option value="inflow" {{ ($filters['direction'] ?? '') === 'inflow' ? 'selected' : '' }}>Inflow</option>
                        <option value="outflow" {{ ($filters['direction'] ?? '') === 'outflow' ? 'selected' : '' }}>Outflow</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="completed" {{ ($filters['status'] ?? '') === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="pending" {{ ($filters['status'] ?? '') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="failed" {{ ($filters['status'] ?? '') === 'failed' ? 'selected' : '' }}>Failed</option>
                    </select>
                </div>
                <div class="col-md-2"><input type="date" name="date_from" class="form-control" value="{{ $filters['date_from'] ?? '' }}" placeholder="From"></div>
                <div class="col-md-1"><button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i></button></div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr><th>#</th><th>Type</th><th class="text-end">Amount</th><th class="text-end">Fee</th><th class="text-end">Net</th><th>Method</th><th>Date</th><th>Direction</th><th>Status</th><th class="text-center">Actions</th></tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $t)
                            <tr>
                                <td><small>{{ $t->transaction_number }}</small></td>
                                <td><span class="badge bg-{{ $t->type === 'sale' ? 'success' : ($t->type === 'expense' || $t->type === 'refund' ? 'danger' : 'primary') }}">{{ str_replace('_', ' ', $t->type) }}</span></td>
                                <td class="text-end fw-semibold">{{ number_format($t->amount, 2) }}</td>
                                <td class="text-end text-muted">{{ $t->fee > 0 ? number_format($t->fee, 2) : '—' }}</td>
                                <td class="text-end fw-bold {{ $t->direction === 'inflow' ? 'text-success' : 'text-danger' }}">{{ number_format($t->net_amount, 2) }}</td>
                                <td><small>{{ $t->payment_method ?: '—' }}</small></td>
                                <td><small>{{ $t->transaction_date?->format('d/m/Y') }}</small></td>
                                <td><span class="badge bg-{{ $t->direction === 'inflow' ? 'success' : ($t->direction === 'outflow' ? 'danger' : 'secondary') }}">{{ ucfirst($t->direction) }}</span></td>
                                <td><span class="badge bg-{{ $t->status === 'completed' ? 'success' : ($t->status === 'failed' ? 'danger' : 'warning') }}">{{ $t->status }}</span></td>
                                <td class="text-center">
                                    <a href="{{ route('admin.finance.transactions.show', $t->id) }}" class="btn btn-sm btn-outline-secondary"><i class="fas fa-eye"></i></a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="10" class="text-center py-5 text-muted"><i class="fas fa-exchange-alt fa-3x mb-3 d-block"></i>No transactions found</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-3">{{ $transactions->withQueryString()->links() }}</div>
        </div>
    </div>
</x-layouts.admin-layout>
