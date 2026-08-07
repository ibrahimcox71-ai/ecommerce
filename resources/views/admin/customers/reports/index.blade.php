<x-layouts.admin-layout title="Customer Reports">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Customer Reports</h4>
            <p class="text-muted small mb-0">Analytics and insights for your customer base</p>
        </div>
        <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>

    {{-- Overview Stats --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card bg-primary-subtle border-0">
                <div class="card-body text-center py-3">
                    <h5 class="mb-0 text-primary fw-bold">{{ $stats['total'] ?? 0 }}</h5>
                    <small class="text-muted">Total Customers</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card bg-success-subtle border-0">
                <div class="card-body text-center py-3">
                    <h5 class="mb-0 text-success fw-bold">{{ $stats['active'] ?? 0 }}</h5>
                    <small class="text-muted">Active</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card bg-warning-subtle border-0">
                <div class="card-body text-center py-3">
                    <h5 class="mb-0 text-warning fw-bold">{{ $stats['suspended'] ?? 0 }}</h5>
                    <small class="text-muted">Suspended</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card bg-info-subtle border-0">
                <div class="card-body text-center py-3">
                    <h5 class="mb-0 text-info fw-bold">{{ $stats['with_orders'] ?? 0 }}</h5>
                    <small class="text-muted">With Orders</small>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- Top Customers --}}
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0">Top Customers</h6>
                    <small class="text-muted">By order count</small>
                </div>
                <div class="card-body p-0">
                    @if(count($topCustomers) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0 ps-4">#</th>
                                        <th class="border-0">Customer</th>
                                        <th class="border-0 text-center">Orders</th>
                                        <th class="border-0 text-end pe-4">Total Spent</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($topCustomers as $index => $customer)
                                        <tr>
                                            <td class="ps-4">
                                                <span class="badge bg-{{ $index < 3 ? 'warning' : 'secondary' }} bg-opacity-10 text-{{ $index < 3 ? 'warning' : 'secondary' }}">
                                                    {{ $index + 1 }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="fw-semibold small">{{ $customer['name'] }}</span>
                                                <small class="d-block text-muted">{{ $customer['email'] }}</small>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-primary bg-opacity-10 text-primary">{{ $customer['orders_count'] }}</span>
                                            </td>
                                            <td class="text-end pe-4">
                                                <span class="fw-semibold">{{ config('ecommerce.currency.symbol', '$') }}{{ number_format($customer['total_spend'], 2) }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <p class="text-muted mb-0">No customer data available</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Highest Spending --}}
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0">Highest Spending</h6>
                    <small class="text-muted">By total spend</small>
                </div>
                <div class="card-body p-0">
                    @if(count($highestSpending) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0 ps-4">#</th>
                                        <th class="border-0">Customer</th>
                                        <th class="border-0 text-center">Orders</th>
                                        <th class="border-0 text-end pe-4">Total Spent</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($highestSpending as $index => $customer)
                                        <tr>
                                            <td class="ps-4">
                                                <span class="badge bg-{{ $index < 3 ? 'danger' : 'secondary' }} bg-opacity-10 text-{{ $index < 3 ? 'danger' : 'secondary' }}">
                                                    {{ $index + 1 }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="fw-semibold small">{{ $customer['name'] }}</span>
                                                <small class="d-block text-muted">{{ $customer['email'] }}</small>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-info bg-opacity-10 text-info">{{ $customer['orders_count'] }}</span>
                                            </td>
                                            <td class="text-end pe-4">
                                                <span class="fw-semibold">{{ config('ecommerce.currency.symbol', '$') }}{{ number_format($customer['total_spend'], 2) }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <p class="text-muted mb-0">No customer data available</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-2">
        {{-- Inactive Customers --}}
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0">Inactive Customers (90 days)</h6>
                    <span class="badge bg-warning">{{ count($inactiveCustomers) }} customers</span>
                </div>
                <div class="card-body p-0">
                    @if(count($inactiveCustomers) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0 ps-4">Customer</th>
                                        <th class="border-0 d-none d-md-table-cell">Last Login</th>
                                        <th class="border-0 text-center">Orders</th>
                                        <th class="border-0 text-end pe-4">Spent</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($inactiveCustomers as $customer)
                                        <tr>
                                            <td class="ps-4">
                                                <span class="fw-semibold small">{{ $customer['name'] }}</span>
                                                <small class="d-block text-muted">{{ $customer['email'] }}</small>
                                            </td>
                                            <td class="d-none d-md-table-cell">
                                                <small>{{ $customer['last_login'] ? $customer['last_login']->diffForHumans() : 'Never' }}</small>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-secondary bg-opacity-10 text-secondary">{{ $customer['total_orders'] }}</span>
                                            </td>
                                            <td class="text-end pe-4">
                                                <span class="small">{{ config('ecommerce.currency.symbol', '$') }}{{ number_format($customer['total_spend'], 2) }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                            <p class="text-muted mb-0">No inactive customers found!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Customer Growth Chart --}}
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Customer Growth (12 Months)</h6>
                </div>
                <div class="card-body">
                    @if(count($growthData) > 0)
                        <canvas id="growthChart" height="250"></canvas>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Not enough data for growth chart</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</x-layouts.admin-layout>

@push('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    @if(count($growthData) > 0)
        const growthLabels = {!! json_encode(array_map(fn($d) => $d['period'], $growthData)) !!};
        const growthCounts = {!! json_encode(array_map(fn($d) => $d['count'], $growthData)) !!};

        new Chart(document.getElementById('growthChart'), {
            type: 'bar',
            data: {
                labels: growthLabels,
                datasets: [{
                    label: 'New Customers',
                    data: growthCounts,
                    backgroundColor: 'rgba(13, 110, 253, 0.2)',
                    borderColor: 'rgba(13, 110, 253, 1)',
                    borderWidth: 2,
                    borderRadius: 4,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    }
                }
            }
        });
    @endif
});
</script>
@endpush
