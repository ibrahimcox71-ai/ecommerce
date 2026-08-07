<x-layouts.admin-layout title="Order Reports">

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Order Reports</h4>
        <p class="text-muted small mb-0">Analytics and insights for orders and sales</p>
    </div>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Back to Orders
    </a>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <small class="text-muted text-uppercase fw-semibold" style="font-size: 11px; letter-spacing: 0.5px;">Sales Report</small>
                        <h5 class="fw-bold mt-2">Sales Overview</h5>
                        <p class="text-muted small">Revenue, orders, and averages</p>
                    </div>
                    <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                        <i class="fas fa-chart-line text-primary fa-lg"></i>
                    </div>
                </div>
                <a href="{{ route('admin.orders.reports.sales') }}" class="btn btn-sm btn-outline-primary mt-3 w-100">
                    <i class="fas fa-eye me-1"></i> View Report
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <small class="text-muted text-uppercase fw-semibold" style="font-size: 11px; letter-spacing: 0.5px;">Daily Orders</small>
                        <h5 class="fw-bold mt-2">Daily Breakdown</h5>
                        <p class="text-muted small">Last 30 days order activity</p>
                    </div>
                    <div class="rounded-circle bg-success bg-opacity-10 p-3">
                        <i class="fas fa-calendar-day text-success fa-lg"></i>
                    </div>
                </div>
                <a href="{{ route('admin.orders.reports.daily') }}" class="btn btn-sm btn-outline-success mt-3 w-100">
                    <i class="fas fa-eye me-1"></i> View Report
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <small class="text-muted text-uppercase fw-semibold" style="font-size: 11px; letter-spacing: 0.5px;">Monthly Orders</small>
                        <h5 class="fw-bold mt-2">Monthly Breakdown</h5>
                        <p class="text-muted small">Last 12 months order activity</p>
                    </div>
                    <div class="rounded-circle bg-info bg-opacity-10 p-3">
                        <i class="fas fa-calendar-alt text-info fa-lg"></i>
                    </div>
                </div>
                <a href="{{ route('admin.orders.reports.monthly') }}" class="btn btn-sm btn-outline-info mt-3 w-100">
                    <i class="fas fa-eye me-1"></i> View Report
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <small class="text-muted text-uppercase fw-semibold" style="font-size: 11px; letter-spacing: 0.5px;">Top Customers</small>
                        <h5 class="fw-bold mt-2">Top Customers</h5>
                        <p class="text-muted small">Highest spending customers</p>
                    </div>
                    <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                        <i class="fas fa-trophy text-warning fa-lg"></i>
                    </div>
                </div>
                <a href="{{ route('admin.orders.reports.top-customers') }}" class="btn btn-sm btn-outline-warning mt-3 w-100">
                    <i class="fas fa-eye me-1"></i> View Report
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <small class="text-muted text-uppercase fw-semibold" style="font-size: 11px; letter-spacing: 0.5px;">Top Products</small>
                        <h5 class="fw-bold mt-2">Top Products</h5>
                        <p class="text-muted small">Best selling products</p>
                    </div>
                    <div class="rounded-circle bg-danger bg-opacity-10 p-3">
                        <i class="fas fa-crown text-danger fa-lg"></i>
                    </div>
                </div>
                <a href="{{ route('admin.orders.reports.top-products') }}" class="btn btn-sm btn-outline-danger mt-3 w-100">
                    <i class="fas fa-eye me-1"></i> View Report
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <small class="text-muted text-uppercase fw-semibold" style="font-size: 11px; letter-spacing: 0.5px;">Cancelled Orders</small>
                        <h5 class="fw-bold mt-2">Cancelled Orders</h5>
                        <p class="text-muted small">Cancellation analysis</p>
                    </div>
                    <div class="rounded-circle bg-secondary bg-opacity-10 p-3">
                        <i class="fas fa-ban text-secondary fa-lg"></i>
                    </div>
                </div>
                <a href="{{ route('admin.orders.reports.cancelled') }}" class="btn btn-sm btn-outline-secondary mt-3 w-100">
                    <i class="fas fa-eye me-1"></i> View Report
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <small class="text-muted text-uppercase fw-semibold" style="font-size: 11px; letter-spacing: 0.5px;">Returned Orders</small>
                        <h5 class="fw-bold mt-2">Returned Orders</h5>
                        <p class="text-muted small">Return & refund analysis</p>
                    </div>
                    <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                        <i class="fas fa-undo text-warning fa-lg"></i>
                    </div>
                </div>
                <a href="{{ route('admin.orders.reports.returned') }}" class="btn btn-sm btn-outline-warning mt-3 w-100">
                    <i class="fas fa-eye me-1"></i> View Report
                </a>
            </div>
        </div>
    </div>
</div>

</x-layouts.admin-layout>
