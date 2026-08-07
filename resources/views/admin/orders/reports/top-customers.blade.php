<x-layouts.admin-layout title="Top Customers Report">

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <a href="{{ route('admin.orders.reports') }}" class="text-muted text-decoration-none small">
            <i class="fas fa-arrow-left me-1"></i>Back to Reports
        </a>
        <h4 class="fw-bold mb-0 mt-1">Top Customers</h4>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Customer</th>
                        <th>Email</th>
                        <th class="text-center">Orders</th>
                        <th class="text-end">Total Spent</th>
                        <th>Last Order</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $idx => $c)
                        <tr>
                            <td>{{ $idx + 1 }}</td>
                            <td class="fw-semibold">{{ $c['user']['name'] ?? '—' }}</td>
                            <td><small>{{ $c['user']['email'] ?? '—' }}</small></td>
                            <td class="text-center">{{ $c['order_count'] }}</td>
                            <td class="text-end fw-bold text-success">{{ config('ecommerce.currency_symbol', '$') }}{{ number_format($c['total_spent'], 2) }}</td>
                            <td><small>{{ \Carbon\Carbon::parse($c['last_order_date'])->format('M d, Y') }}</small></td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center py-4 text-muted">No data available.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

</x-layouts.admin-layout>
