<x-layouts.admin-layout title="Tax Summary">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div><h4 class="fw-bold mb-1">Tax Summary Report</h4><p class="text-muted small mb-0">Tax collected by rate and period</p></div>
        <a href="{{ route('admin.finance.reports.index') }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i> Back</a>
    </div>

    <form method="GET" class="row g-2 mb-4">
        <div class="col-md-4"><input type="date" name="date_from" class="form-control" value="{{ $filters['date_from'] ?? '' }}"></div>
        <div class="col-md-4"><input type="date" name="date_to" class="form-control" value="{{ $filters['date_to'] ?? '' }}"></div>
        <div class="col-md-2"><button type="submit" class="btn btn-primary w-100"><i class="fas fa-filter me-1"></i> Filter</button></div>
        <div class="col-md-2"><a href="{{ route('admin.finance.reports.tax-summary') }}" class="btn btn-outline-secondary w-100">Reset</a></div>
    </form>

    <div class="card"><div class="card-header bg-transparent"><h6 class="fw-bold mb-0">Tax Collected</h6></div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light"><tr><th>Tax Rate</th><th class="text-end">Rate (%)</th><th class="text-end">Total Collected</th><th class="text-end">Transactions</th></tr></thead>
                <tbody>
                    @forelse($report['taxes'] as $tax)
                    <tr><td class="fw-semibold">{{ $tax['rate_name'] }}</td><td class="text-end">{{ $tax['rate'] }}%</td><td class="text-end fw-semibold text-primary">{{ number_format($tax['total_amount'], 2) }}</td><td class="text-end">{{ $tax['transaction_count'] }}</td></tr>
                    @empty
                    <tr><td colspan="4" class="text-center py-4 text-muted">No tax collected</td></tr>
                    @endforelse
                </tbody>
                <tfoot><tr class="table-active"><td colspan="2" class="fw-bold">Grand Total</td><td class="text-end fw-bold">{{ number_format($report['grand_total'], 2) }}</td><td></td></tr></tfoot>
            </table>
        </div>
    </div>
</x-layouts.admin-layout>
