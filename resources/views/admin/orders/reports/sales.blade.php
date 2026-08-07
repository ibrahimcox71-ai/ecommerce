<x-layouts.admin-layout title="Sales Report">

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <a href="{{ route('admin.orders.reports') }}" class="text-muted text-decoration-none small">
            <i class="fas fa-arrow-left me-1"></i>Back to Reports
        </a>
        <h4 class="fw-bold mb-0 mt-1">Sales Report</h4>
    </div>
    <form method="GET" class="d-flex gap-2">
        <input type="date" name="date_from" class="form-control form-control-sm" value="{{ $dateFrom }}">
        <input type="date" name="date_to" class="form-control form-control-sm" value="{{ $dateTo }}">
        <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-search"></i></button>
    </form>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-primary bg-opacity-10">
            <div class="card-body text-center">
                <small class="text-muted text-uppercase fw-semibold" style="font-size: 11px;">Total Orders</small>
                <h3 class="fw-bold mt-1 text-primary">{{ $report['total_orders'] }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-success bg-opacity-10">
            <div class="card-body text-center">
                <small class="text-muted text-uppercase fw-semibold" style="font-size: 11px;">Total Revenue</small>
                <h3 class="fw-bold mt-1 text-success">{{ config('ecommerce.currency_symbol', '$') }}{{ number_format($report['total_revenue'], 2) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-info bg-opacity-10">
            <div class="card-body text-center">
                <small class="text-muted text-uppercase fw-semibold" style="font-size: 11px;">Avg Order Value</small>
                <h3 class="fw-bold mt-1 text-info">{{ config('ecommerce.currency_symbol', '$') }}{{ number_format($report['avg_order_value'], 2) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-warning bg-opacity-10">
            <div class="card-body text-center">
                <small class="text-muted text-uppercase fw-semibold" style="font-size: 11px;">Total Shipping</small>
                <h3 class="fw-bold mt-1 text-warning">{{ config('ecommerce.currency_symbol', '$') }}{{ number_format($report['total_shipping'], 2) }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <small class="text-muted text-uppercase fw-semibold" style="font-size: 11px;">Total Paid</small>
                <h5 class="fw-bold mt-1 text-success">{{ config('ecommerce.currency_symbol', '$') }}{{ number_format($report['total_paid'], 2) }}</h5>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <small class="text-muted text-uppercase fw-semibold" style="font-size: 11px;">Total Tax</small>
                <h5 class="fw-bold mt-1">{{ config('ecommerce.currency_symbol', '$') }}{{ number_format($report['total_tax'], 2) }}</h5>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <small class="text-muted text-uppercase fw-semibold" style="font-size: 11px;">Total Discount</small>
                <h5 class="fw-bold mt-1 text-danger">{{ config('ecommerce.currency_symbol', '$') }}{{ number_format($report['total_discount'], 2) }}</h5>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <small class="text-muted text-uppercase fw-semibold" style="font-size: 11px;">Revenue Per Order</small>
                <h5 class="fw-bold mt-1 text-info">{{ config('ecommerce.currency_symbol', '$') }}{{ number_format($report['avg_order_value'], 2) }}</h5>
            </div>
        </div>
    </div>
</div>

</x-layouts.admin-layout>
