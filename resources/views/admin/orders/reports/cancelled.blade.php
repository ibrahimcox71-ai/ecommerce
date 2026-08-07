<x-layouts.admin-layout title="Cancelled Orders Report">

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <a href="{{ route('admin.orders.reports') }}" class="text-muted text-decoration-none small">
            <i class="fas fa-arrow-left me-1"></i>Back to Reports
        </a>
        <h4 class="fw-bold mb-0 mt-1">Cancelled Orders</h4>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm bg-danger bg-opacity-10">
            <div class="card-body text-center">
                <small class="text-muted text-uppercase fw-semibold" style="font-size: 11px;">Total Cancelled</small>
                <h3 class="fw-bold mt-1 text-danger">{{ $cancelled['count'] }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm bg-warning bg-opacity-10">
            <div class="card-body text-center">
                <small class="text-muted text-uppercase fw-semibold" style="font-size: 11px;">Total Amount</small>
                <h3 class="fw-bold mt-1 text-warning">{{ config('ecommerce.currency_symbol', '$') }}{{ number_format($cancelled['total_amount'], 2) }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Order #</th>
                        <th>Customer</th>
                        <th class="text-end">Amount</th>
                        <th>Cancelled At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cancelled['orders'] as $co)
                        <tr>
                            <td><a href="{{ route('admin.orders.show', $co['id']) }}" class="fw-semibold text-decoration-none">{{ $co['order_number'] }}</a></td>
                            <td>{{ $co['user']['name'] ?? 'N/A' }}</td>
                            <td class="text-end fw-semibold">{{ config('ecommerce.currency_symbol', '$') }}{{ number_format($co['total'], 2) }}</td>
                            <td>{{ \Carbon\Carbon::parse($co['cancelled_at'])->format('M d, Y h:i A') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center py-4 text-muted">No cancelled orders.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

</x-layouts.admin-layout>
