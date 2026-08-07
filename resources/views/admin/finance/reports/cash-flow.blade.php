<x-layouts.admin-layout title="Cash Flow Statement">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div><h4 class="fw-bold mb-1">Cash Flow Statement</h4><p class="text-muted small mb-0">Operating, investing and financing activities</p></div>
        <a href="{{ route('admin.finance.reports.index') }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i> Back</a>
    </div>

    <form method="GET" class="row g-2 mb-4">
        <div class="col-md-4"><input type="date" name="date_from" class="form-control" value="{{ $filters['date_from'] ?? now()->startOfMonth()->format('Y-m-d') }}"></div>
        <div class="col-md-4"><input type="date" name="date_to" class="form-control" value="{{ $filters['date_to'] ?? now()->endOfMonth()->format('Y-m-d') }}"></div>
        <div class="col-md-2"><button type="submit" class="btn btn-primary w-100"><i class="fas fa-filter me-1"></i> Filter</button></div>
        <div class="col-md-2"><a href="{{ route('admin.finance.reports.cash-flow') }}" class="btn btn-outline-secondary w-100">Reset</a></div>
    </form>

    <div class="row g-3 mb-4">
        <div class="col-md-4"><div class="card bg-success-subtle"><div class="card-body text-center py-2"><small class="text-muted">Total Inflow</small><h5 class="mb-0 text-success">{{ number_format($report['total_inflow'], 2) }}</h5></div></div></div>
        <div class="col-md-4"><div class="card bg-danger-subtle"><div class="card-body text-center py-2"><small class="text-muted">Total Outflow</small><h5 class="mb-0 text-danger">{{ number_format($report['total_outflow'], 2) }}</h5></div></div></div>
        <div class="col-md-4"><div class="card {{ $report['net_cash_flow'] >= 0 ? 'bg-primary-subtle' : 'bg-warning-subtle' }}"><div class="card-body text-center py-2"><small class="text-muted">Net Cash Flow</small><h5 class="mb-0 {{ $report['net_cash_flow'] >= 0 ? 'text-primary' : 'text-warning' }}">{{ number_format($report['net_cash_flow'], 2) }}</h5></div></div></div>
    </div>

    <div class="row g-4">
        @foreach(['operating' => 'Operating Activities', 'investing' => 'Investing Activities', 'financing' => 'Financing Activities'] as $key => $label)
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header bg-transparent"><h6 class="fw-bold mb-0">{{ $label }}</h6></div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2"><span>Inflow</span><span class="fw-semibold text-success">{{ number_format($report[$key]['inflow'], 2) }}</span></div>
                    <div class="d-flex justify-content-between mb-2"><span>Outflow</span><span class="fw-semibold text-danger">{{ number_format($report[$key]['outflow'], 2) }}</span></div>
                    <hr>
                    <div class="d-flex justify-content-between"><span class="fw-bold">Net</span><span class="fw-bold {{ $report[$key]['net'] >= 0 ? 'text-success' : 'text-danger' }}">{{ number_format($report[$key]['net'], 2) }}</span></div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</x-layouts.admin-layout>
