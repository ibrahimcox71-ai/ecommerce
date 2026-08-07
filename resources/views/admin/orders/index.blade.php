<x-layouts.admin-layout title="Orders">

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Orders</h4>
        <p class="text-muted small mb-0">Manage all customer orders</p>
    </div>
    <div class="d-flex gap-2">
        <div class="dropdown">
            <button class="btn btn-outline-success dropdown-toggle" data-bs-toggle="dropdown">
                <i class="fas fa-download me-1"></i> Export
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="{{ route('admin.orders.export.csv', request()->query()) }}"><i class="fas fa-file-csv me-2 text-success"></i>CSV</a></li>
                <li><a class="dropdown-item" href="{{ route('admin.orders.export.excel', request()->query()) }}"><i class="fas fa-file-excel me-2 text-primary"></i>Excel</a></li>
            </ul>
        </div>
        <a href="{{ route('admin.orders.reports.index') }}" class="btn btn-outline-info">
            <i class="fas fa-chart-bar me-1"></i> Reports
        </a>
        <a href="{{ route('admin.orders.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Create Order
        </a>
    </div>
</div>

<div class="row g-2 mb-4">
    <div class="col-6 col-md">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-2">
                <small class="text-muted">Total</small>
                <h6 class="fw-bold mb-0">{{ $statusCounts['all'] }}</h6>
            </div>
        </div>
    </div>
    <div class="col-6 col-md">
        <div class="card border-0 shadow-sm bg-warning bg-opacity-10">
            <div class="card-body text-center py-2">
                <small class="text-muted">Pending</small>
                <h6 class="fw-bold mb-0 text-warning">{{ $statusCounts['pending'] }}</h6>
            </div>
        </div>
    </div>
    <div class="col-6 col-md">
        <div class="card border-0 shadow-sm bg-primary bg-opacity-10">
            <div class="card-body text-center py-2">
                <small class="text-muted">Processing</small>
                <h6 class="fw-bold mb-0 text-primary">{{ $statusCounts['processing'] }}</h6>
            </div>
        </div>
    </div>
    <div class="col-6 col-md">
        <div class="card border-0 shadow-sm bg-dark bg-opacity-10">
            <div class="card-body text-center py-2">
                <small class="text-muted">Shipped</small>
                <h6 class="fw-bold mb-0">{{ $statusCounts['shipping'] + $statusCounts['ready_to_ship'] + $statusCounts['out_for_delivery'] }}</h6>
            </div>
        </div>
    </div>
    <div class="col-6 col-md">
        <div class="card border-0 shadow-sm bg-success bg-opacity-10">
            <div class="card-body text-center py-2">
                <small class="text-muted">Delivered</small>
                <h6 class="fw-bold mb-0 text-success">{{ $statusCounts['delivered'] + $statusCounts['completed'] }}</h6>
            </div>
        </div>
    </div>
    <div class="col-6 col-md">
        <div class="card border-0 shadow-sm bg-danger bg-opacity-10">
            <div class="card-body text-center py-2">
                <small class="text-muted">Cancelled</small>
                <h6 class="fw-bold mb-0 text-danger">{{ $statusCounts['cancelled'] }}</h6>
            </div>
        </div>
    </div>
</div>

{{-- Status Tabs --}}
<ul class="nav nav-tabs mb-4">
    <li class="nav-item">
        <a class="nav-link {{ !request('status') && !request('payment_status') ? 'active' : '' }}"
           href="{{ route('admin.orders.index') }}">
            All <span class="badge bg-secondary ms-1">{{ $statusCounts['all'] }}</span>
        </a>
    </li>
    @php
        $statusTabs = [
            'pending' => ['bg-warning text-dark', $statusCounts['pending']],
            'confirmed' => ['bg-info', $statusCounts['confirmed']],
            'processing' => ['bg-primary', $statusCounts['processing']],
            'packing' => ['bg-secondary', $statusCounts['packing']],
            'ready_to_ship' => ['bg-dark', $statusCounts['ready_to_ship']],
            'shipping' => ['bg-dark', $statusCounts['shipping']],
            'out_for_delivery' => ['bg-info', $statusCounts['out_for_delivery']],
            'delivered' => ['bg-success', $statusCounts['delivered']],
            'completed' => ['bg-success', $statusCounts['completed']],
            'cancelled' => ['bg-danger', $statusCounts['cancelled']],
            'returned' => ['bg-warning text-dark', $statusCounts['returned']],
            'refunded' => ['bg-secondary', $statusCounts['refunded']],
        ];
    @endphp
    @foreach($statusTabs as $key => [$badgeClass, $count])
        @if($count > 0)
        <li class="nav-item">
            <a class="nav-link {{ request('status') === $key ? 'active' : '' }}"
               href="{{ route('admin.orders.index', array_merge(request()->except('status'), ['status' => $key])) }}">
                {{ ucwords(str_replace('_', ' ', $key)) }}
                <span class="badge {{ $badgeClass }} ms-1">{{ $count }}</span>
            </a>
        </li>
        @endif
    @endforeach
</ul>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form method="GET" class="row g-2 mb-3">
            <div class="col-md-3">
                <input type="text" name="search" class="form-control" placeholder="Search order #, customer, phone..."
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <select name="payment_status" class="form-select">
                    <option value="">All Payments</option>
                    <option value="paid" @selected(request('payment_status') === 'paid')>Paid</option>
                    <option value="partial" @selected(request('payment_status') === 'partial')>Partial</option>
                    <option value="pending" @selected(request('payment_status') === 'pending')>Pending</option>
                    <option value="failed" @selected(request('payment_status') === 'failed')>Failed</option>
                    <option value="refunded" @selected(request('payment_status') === 'refunded')>Refunded</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="order_origin" class="form-select">
                    <option value="">All Origins</option>
                    <option value="website" @selected(request('order_origin') === 'website')>Website</option>
                    <option value="manual" @selected(request('order_origin') === 'manual')>Manual</option>
                    <option value="pos" @selected(request('order_origin') === 'pos')>POS</option>
                </select>
            </div>
            <div class="col-md-2">
                <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}" placeholder="From">
            </div>
            <div class="col-md-2">
                <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}" placeholder="To">
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i></button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Order #</th>
                        <th>Customer</th>
                        <th class="text-center">Items</th>
                        <th class="text-end">Total</th>
                        <th>Payment</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td>
                                <a href="{{ route('admin.orders.show', $order) }}" class="fw-semibold text-decoration-none">
                                    {{ $order->order_number }}
                                </a>
                                @if($order->order_origin !== 'website')
                                    <br><small class="badge bg-light text-muted">{{ ucfirst($order->order_origin) }}</small>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    @php $name = $order->shipping_address['name'] ?? ($order->user?->name ?? 'Guest'); @endphp
                                    <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center fw-bold"
                                         style="width: 32px; height: 32px; font-size: 12px;">
                                        {{ strtoupper(substr($name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <span class="fw-semibold small">{{ $name }}</span>
                                        @if($order->user)
                                            <br><small class="text-muted" style="font-size: 11px;">{{ $order->user->email }}</small>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">{{ $order->getItemCount() }}</td>
                            <td class="text-end fw-semibold">{{ config('ecommerce.currency_symbol', '$') }}{{ number_format($order->total, 2) }}</td>
                            <td>
                                <span class="badge {{ $order->paymentStatusBadge() }}">{{ ucfirst($order->payment_status) }}</span>
                                <br><small class="text-muted">{{ $order->payment?->methodLabel() ?? '—' }}</small>
                            </td>
                            <td>
                                @php $s = App\Enums\OrderStatus::tryFrom($order->status); @endphp
                                @if($s)
                                    <span class="badge {{ $s->badgeClass() }}">{{ $s->label() }}</span>
                                @else
                                    <span class="badge bg-light text-dark">{{ ucfirst($order->status) }}</span>
                                @endif
                            </td>
                            <td><small class="text-muted">{{ $order->created_at->format('M d, Y') }}</small></td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="{{ route('admin.orders.show', $order) }}"><i class="fas fa-eye me-2"></i>View</a></li>
                                        @if($order->isEditable())
                                            <li><a class="dropdown-item" href="{{ route('admin.orders.edit', $order) }}"><i class="fas fa-edit me-2"></i>Edit</a></li>
                                        @endif
                                        <li><a class="dropdown-item" href="{{ route('admin.orders.print', $order) }}" target="_blank"><i class="fas fa-print me-2"></i>Print</a></li>
                                        <li><a class="dropdown-item" href="{{ route('admin.orders.invoice', $order) }}" target="_blank"><i class="fas fa-file-invoice me-2"></i>Invoice</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form method="POST" action="{{ route('admin.orders.duplicate', $order) }}" class="d-inline">
                                                @csrf
                                                <button type="submit" class="dropdown-item"><i class="fas fa-copy me-2"></i>Duplicate</button>
                                            </form>
                                        </li>
                                        @if($order->isDeletable())
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form method="POST" action="{{ route('admin.orders.destroy', $order) }}" class="d-inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Delete this order?')"><i class="fas fa-trash me-2"></i>Delete</button>
                                                </form>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="fas fa-shopping-cart fa-3x mb-3 d-block"></i>
                                No orders found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-3">
            <small class="text-muted">Showing {{ $orders->firstItem() ?? 0 }} to {{ $orders->lastItem() ?? 0 }} of {{ $orders->total() }} entries</small>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.orders.export.csv', request()->query()) }}" class="btn btn-sm btn-outline-success">
                    <i class="fas fa-file-csv me-1"></i> CSV
                </a>
                <a href="{{ route('admin.orders.export.excel', request()->query()) }}" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-file-excel me-1"></i> Excel
                </a>
            </div>
        </div>

        <div class="d-flex justify-content-center mt-3">
            {{ $orders->withQueryString()->links() }}
        </div>
    </div>
</div>

</x-layouts.admin-layout>
