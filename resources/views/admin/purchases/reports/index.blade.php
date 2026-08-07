<x-layouts.admin-layout title="Purchase Reports">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Purchase Reports</h4>
            <p class="text-muted small mb-0">Analyze purchase performance</p>
        </div>
        <a href="{{ route('admin.purchases.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>

    <div class="row g-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-file-invoice fa-3x text-primary mb-3"></i>
                    <h5>Purchase Report</h5>
                    <p class="text-muted small">View all purchase orders with date filters</p>
                    <a href="{{ route('admin.purchases.reports.purchase') }}" class="btn btn-outline-primary">
                        <i class="fas fa-eye me-1"></i> View Report
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-truck fa-3x text-success mb-3"></i>
                    <h5>Supplier Report</h5>
                    <p class="text-muted small">Purchase summary by supplier</p>
                    <a href="{{ route('admin.purchases.reports.supplier') }}" class="btn btn-outline-success">
                        <i class="fas fa-eye me-1"></i> View Report
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-money-bill-wave fa-3x text-info mb-3"></i>
                    <h5>Payment Report</h5>
                    <p class="text-muted small">Track all purchase payments</p>
                    <a href="{{ route('admin.purchases.reports.payment') }}" class="btn btn-outline-info">
                        <i class="fas fa-eye me-1"></i> View Report
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-exclamation-triangle fa-3x text-danger mb-3"></i>
                    <h5>Outstanding Due Report</h5>
                    <p class="text-muted small">View unpaid and partially paid purchases</p>
                    <a href="{{ route('admin.purchases.reports.due') }}" class="btn btn-outline-danger">
                        <i class="fas fa-eye me-1"></i> View Report
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-undo fa-3x text-warning mb-3"></i>
                    <h5>Purchase Return Report</h5>
                    <p class="text-muted small">Track returned items and refunds</p>
                    <a href="{{ route('admin.purchases.reports.return') }}" class="btn btn-outline-warning">
                        <i class="fas fa-eye me-1"></i> View Report
                    </a>
                </div>
            </div>
        </div>
    </div>

</x-layouts.admin-layout>
