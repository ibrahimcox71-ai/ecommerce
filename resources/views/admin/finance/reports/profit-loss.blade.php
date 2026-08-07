<x-layouts.admin-layout title="Profit & Loss Statement">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div><h4 class="fw-bold mb-1">Profit & Loss Statement</h4><p class="text-muted small mb-0">Revenue, expenses and net profit</p></div>
        <a href="{{ route('admin.finance.reports.index') }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i> Back to Reports</a>
    </div>

    <form method="GET" class="row g-2 mb-4">
        <div class="col-md-4"><input type="date" name="date_from" class="form-control" value="{{ $filters['date_from'] ?? now()->startOfMonth()->format('Y-m-d') }}"></div>
        <div class="col-md-4"><input type="date" name="date_to" class="form-control" value="{{ $filters['date_to'] ?? now()->endOfMonth()->format('Y-m-d') }}"></div>
        <div class="col-md-2"><button type="submit" class="btn btn-primary w-100"><i class="fas fa-filter me-1"></i> Filter</button></div>
        <div class="col-md-2"><a href="{{ route('admin.finance.reports.profit-loss') }}" class="btn btn-outline-secondary w-100">Reset</a></div>
    </form>

    <div class="row g-3 mb-4">
        <div class="col-md-4"><div class="card bg-success-subtle border-0"><div class="card-body text-center py-3"><h5 class="fw-bold mb-0 text-success">{{ number_format($report['total_revenue'], 2) }}</h5><small class="text-muted">Total Revenue</small></div></div></div>
        <div class="col-md-4"><div class="card bg-danger-subtle border-0"><div class="card-body text-center py-3"><h5 class="fw-bold mb-0 text-danger">{{ number_format($report['total_expenses'], 2) }}</h5><small class="text-muted">Total Expenses</small></div></div></div>
        <div class="col-md-4"><div class="card {{ $report['net_profit'] >= 0 ? 'bg-primary-subtle' : 'bg-warning-subtle' }} border-0"><div class="card-body text-center py-3"><h5 class="fw-bold mb-0 {{ $report['net_profit'] >= 0 ? 'text-primary' : 'text-warning' }}">{{ number_format($report['net_profit'], 2) }}</h5><small class="text-muted">Net Profit (Margin: {{ $report['profit_margin'] }}%)</small></div></div></div>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card"><div class="card-header bg-transparent"><h6 class="fw-bold mb-0">Revenue</h6></div><div class="card-body text-center py-4"><h3 class="fw-bold text-success">{{ number_format($report['total_revenue'], 2) }}</h3><p class="text-muted small mb-0">Gross Revenue</p></div></div>
        </div>
        <div class="col-lg-6">
            <div class="card"><div class="card-header bg-transparent"><h6 class="fw-bold mb-0">Expenses Breakdown</h6></div><div class="card-body p-0">
                <div class="table-responsive"><table class="table mb-0"><thead class="table-light"><tr><th>Category</th><th class="text-end">Amount</th></tr></thead>
                    <tbody>
                        @forelse($report['expense_breakdown'] as $exp)
                            <tr><td>{{ $exp['category'] }}</td><td class="text-end fw-semibold text-danger">{{ number_format($exp['amount'], 2) }}</td></tr>
                        @empty
                            <tr><td colspan="2" class="text-center text-muted py-3">No expenses</td></tr>
                        @endforelse
                    </tbody>
                    <tfoot><tr class="table-active"><td class="fw-bold">Total Expenses</td><td class="text-end fw-bold text-danger">{{ number_format($report['total_expenses'], 2) }}</td></tr></tfoot>
                </table></div>
            </div></div>
        </div>
    </div>
</x-layouts.admin-layout>
