<x-layouts.admin-layout title="Daily Orders Report">

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <a href="{{ route('admin.orders.reports') }}" class="text-muted text-decoration-none small">
            <i class="fas fa-arrow-left me-1"></i>Back to Reports
        </a>
        <h4 class="fw-bold mb-0 mt-1">Daily Orders (Last 30 Days)</h4>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Date</th>
                        <th class="text-center">Total Orders</th>
                        <th class="text-end">Revenue</th>
                        <th class="text-center">Cancelled</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($daily as $day)
                        <tr>
                            <td class="fw-semibold">{{ $day['date'] }}</td>
                            <td class="text-center">{{ $day['total_orders'] }}</td>
                            <td class="text-end fw-semibold text-success">{{ config('ecommerce.currency_symbol', '$') }}{{ number_format($day['revenue'], 2) }}</td>
                            <td class="text-center">{{ $day['cancelled'] }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center py-4 text-muted">No data available.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

</x-layouts.admin-layout>
