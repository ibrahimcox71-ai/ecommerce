<x-layouts.admin-layout title="Finance Dashboard">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Finance Dashboard</h4>
            <p class="text-muted small mb-0">Financial overview and key metrics</p>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-xl-2 col-md-4 col-6">
            <div class="card bg-success-subtle border-0 h-100">
                <div class="card-body text-center py-3">
                    <h5 class="fw-bold mb-0 text-success">{{ number_format($overview['total_revenue'], 2) }}</h5>
                    <small class="text-muted">Total Revenue</small>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-6">
            <div class="card bg-danger-subtle border-0 h-100">
                <div class="card-body text-center py-3">
                    <h5 class="fw-bold mb-0 text-danger">{{ number_format($overview['total_expenses'], 2) }}</h5>
                    <small class="text-muted">Total Expenses</small>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-6">
            <div class="card {{ $overview['net_profit'] >= 0 ? 'bg-primary-subtle' : 'bg-warning-subtle' }} border-0 h-100">
                <div class="card-body text-center py-3">
                    <h5 class="fw-bold mb-0 {{ $overview['net_profit'] >= 0 ? 'text-primary' : 'text-warning' }}">{{ number_format($overview['net_profit'], 2) }}</h5>
                    <small class="text-muted">Net Profit</small>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-6">
            <div class="card bg-info-subtle border-0 h-100">
                <div class="card-body text-center py-3">
                    <h5 class="fw-bold mb-0 text-info">{{ number_format($overview['cash_inflow'], 2) }}</h5>
                    <small class="text-muted">Cash Inflow</small>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-6">
            <div class="card bg-warning-subtle border-0 h-100">
                <div class="card-body text-center py-3">
                    <h5 class="fw-bold mb-0 text-warning">{{ number_format($overview['cash_outflow'], 2) }}</h5>
                    <small class="text-muted">Cash Outflow</small>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-6">
            <div class="card bg-secondary-subtle border-0 h-100">
                <div class="card-body text-center py-3">
                    <h5 class="fw-bold mb-0">{{ $overview['total_transactions'] }}</h5>
                    <small class="text-muted">Transactions</small>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0">Revenue vs Expenses</h6>
                    <div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-outline-secondary active" data-period="monthly">Monthly</button>
                        <button type="button" class="btn btn-outline-secondary" data-period="quarterly">Quarterly</button>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="revenueExpenseChart" height="300"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Expense by Category</h6>
                </div>
                <div class="card-body">
                    <canvas id="expenseCategoryChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0">Recent Transactions</h6>
                    <a href="{{ route('admin.finance.transactions.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light"><tr><th>#</th><th>Type</th><th class="text-end">Amount</th><th>Date</th><th>Status</th></tr></thead>
                            <tbody>
                                @forelse($recentTransactions as $t)
                                    <tr>
                                        <td><small>{{ $t['transaction_number'] }}</small></td>
                                        <td><span class="badge bg-{{ $t['type'] === 'sale' ? 'success' : 'danger' }}">{{ ucfirst($t['type']) }}</span></td>
                                        <td class="text-end fw-semibold {{ $t['direction'] === 'inflow' ? 'text-success' : 'text-danger' }}">{{ number_format($t['amount'], 2) }}</td>
                                        <td><small>{{ \Carbon\Carbon::parse($t['transaction_date'])->format('d/m/Y') }}</small></td>
                                        <td><span class="badge bg-{{ $t['status'] === 'completed' ? 'success' : 'warning' }}">{{ $t['status'] }}</span></td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="text-center py-4 text-muted">No transactions yet</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Account Summary</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light"><tr><th>Type</th><th class="text-end">Count</th><th class="text-end">Balance</th></tr></thead>
                            <tbody>
                                @foreach($overview['account_balances'] as $type => $balance)
                                    <tr>
                                        <td><span class="fw-semibold">{{ ucfirst($type) }}</span></td>
                                        <td class="text-end">-</td>
                                        <td class="text-end fw-semibold">{{ number_format((float)$balance, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin-layout>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
const ctx1 = document.getElementById('revenueExpenseChart').getContext('2d');
new Chart(ctx1, {
    type: 'line',
    data: {
        labels: {!! json_encode($chartData['labels']) !!},
        datasets: [
            { label: 'Revenue', data: {!! json_encode($chartData['revenue']) !!}, borderColor: '#10b981', backgroundColor: 'rgba(16,185,129,0.1)', fill: true, tension: 0.4 },
            { label: 'Expenses', data: {!! json_encode($chartData['expenses']) !!}, borderColor: '#ef4444', backgroundColor: 'rgba(239,68,68,0.1)', fill: true, tension: 0.4 }
        ]
    },
    options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'top' } } }
});

const ctx2 = document.getElementById('expenseCategoryChart').getContext('2d');
new Chart(ctx2, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode(collect($expenseByCategory)->pluck('category')) !!},
        datasets: [{ data: {!! json_encode(collect($expenseByCategory)->pluck('total')) !!}, backgroundColor: ['#3b82f6','#10b981','#f59e0b','#ef4444','#8b5cf6','#06b6d4','#ec4899','#f97316'] }]
    },
    options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom', labels: { boxWidth: 12, padding: 8 } } } }
});
</script>
@endpush
