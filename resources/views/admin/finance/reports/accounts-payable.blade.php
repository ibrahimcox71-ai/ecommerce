<x-layouts.admin-layout title="Accounts Payable">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div><h4 class="fw-bold mb-1">Accounts Payable</h4><p class="text-muted small mb-0">Outstanding payments to suppliers / unpaid purchase orders</p></div>
        <a href="{{ route('admin.finance.reports.index') }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i> Back</a>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4"><div class="card bg-danger-subtle"><div class="card-body text-center py-3"><h5 class="fw-bold mb-0 text-danger">{{ number_format($report?->total_due ?? 0, 2) }}</h5><small class="text-muted">Total Due</small></div></div></div>
        <div class="col-md-4"><div class="card bg-primary-subtle"><div class="card-body text-center py-3"><h5 class="fw-bold mb-0 text-primary">{{ $report?->invoice_count ?? 0 }}</h5><small class="text-muted">Outstanding Invoices</small></div></div></div>
        <div class="col-md-4"><div class="card bg-warning-subtle"><div class="card-body text-center py-3"><h5 class="fw-bold mb-0 text-warning">{{ number_format($report?->overdue ?? 0, 2) }}</h5><small class="text-muted">Overdue (30+ days)</small></div></div></div>
    </div>
</x-layouts.admin-layout>
