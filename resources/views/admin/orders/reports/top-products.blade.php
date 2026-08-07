<x-layouts.admin-layout title="Top Products Report">

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <a href="{{ route('admin.orders.reports') }}" class="text-muted text-decoration-none small">
            <i class="fas fa-arrow-left me-1"></i>Back to Reports
        </a>
        <h4 class="fw-bold mb-0 mt-1">Top Selling Products</h4>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Product</th>
                        <th>SKU</th>
                        <th class="text-center">Total Sold</th>
                        <th class="text-end">Total Revenue</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $idx => $p)
                        <tr>
                            <td>{{ $idx + 1 }}</td>
                            <td class="fw-semibold">{{ $p['product_name'] }}</td>
                            <td>{{ $p['product_sku'] ?? '—' }}</td>
                            <td class="text-center">{{ $p['total_qty'] }}</td>
                            <td class="text-end fw-bold text-success">{{ config('ecommerce.currency_symbol', '$') }}{{ number_format($p['total_revenue'], 2) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center py-4 text-muted">No data available.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

</x-layouts.admin-layout>
