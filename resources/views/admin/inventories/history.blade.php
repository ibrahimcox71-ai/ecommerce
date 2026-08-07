<x-layouts.admin-layout title="Inventory History">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Inventory History</h4>
            <p class="text-muted small mb-0">Complete stock timeline across all warehouses</p>
        </div>
        <a href="{{ route('admin.stock-movements.index') }}" class="btn btn-outline-info">
            <i class="fas fa-exchange-alt me-1"></i> Stock Movements
        </a>
        <a href="{{ route('admin.inventories.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to Inventory
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.inventories.history') }}" class="row g-3">
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
                        <input type="text" name="search" class="form-control" placeholder="Search product or SKU..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <select name="warehouse_id" class="form-select">
                        <option value="">All Warehouses</option>
                        @foreach($warehouses as $warehouse)
                            <option value="{{ $warehouse->id }}" {{ request('warehouse_id') == $warehouse->id ? 'selected' : '' }}>{{ $warehouse->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="change_type" class="form-select">
                        <option value="">All Types</option>
                        <option value="increase" {{ request('change_type') === 'increase' ? 'selected' : '' }}>Stock In</option>
                        <option value="decrease" {{ request('change_type') === 'decrease' ? 'selected' : '' }}>Stock Out</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="reference_type" class="form-select">
                        <option value="">All References</option>
                        <option value="add" {{ request('reference_type') === 'add' ? 'selected' : '' }}>Stock In</option>
                        <option value="subtract" {{ request('reference_type') === 'subtract' ? 'selected' : '' }}>Stock Out</option>
                        <option value="reserve" {{ request('reference_type') === 'reserve' ? 'selected' : '' }}>Reserve</option>
                        <option value="release" {{ request('reference_type') === 'release' ? 'selected' : '' }}>Release</option>
                        <option value="adjustment" {{ request('reference_type') === 'adjustment' ? 'selected' : '' }}>Adjustment</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}" placeholder="From">
                </div>
                <div class="col-md-1">
                    <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}" placeholder="To">
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-outline-primary w-100">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @if($logs->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0" style="width: 90px;">Date</th>
                                <th class="border-0">Product</th>
                                <th class="border-0" style="width: 90px;">SKU</th>
                                <th class="border-0" style="width: 120px;">Warehouse</th>
                                <th class="border-0 text-center" style="width: 60px;">Before</th>
                                <th class="border-0 text-center" style="width: 70px;">Change</th>
                                <th class="border-0 text-center" style="width: 60px;">After</th>
                                <th class="border-0" style="width: 120px;">Reason</th>
                                <th class="border-0" style="width: 80px;">By</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($logs as $log)
                                @php
                                    $isIncrease = $log->quantity_change > 0;
                                @endphp
                                <tr>
                                    <td class="small text-muted">{{ $log->created_at->format('M d, H:i') }}</td>
                                    <td>
                                        <span class="small fw-semibold">
                                            {{ $log->variant ? $log->variant->product->name . ' - ' . $log->variant->name : ($log->product?->name ?? 'Deleted') }}
                                        </span>
                                    </td>
                                    <td><code class="small">{{ $log->variant?->sku ?? $log->product?->sku ?? '—' }}</code></td>
                                    <td><span class="small">{{ $log->warehouse?->name ?? '—' }}</span></td>
                                    <td class="text-center text-muted small">{{ number_format($log->quantity_before) }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-{{ $isIncrease ? 'success' : 'danger' }}">
                                            {{ $isIncrease ? '+' : '' }}{{ number_format($log->quantity_change) }}
                                        </span>
                                    </td>
                                    <td class="text-center fw-semibold small">{{ number_format($log->quantity_after) }}</td>
                                    <td><span class="small">{{ $log->reason ?: '—' }}</span></td>
                                    <td><span class="small text-muted">{{ $log->causer?->name ?? 'System' }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted small">
                        Showing {{ $logs->firstItem() }} to {{ $logs->lastItem() }} of {{ $logs->total() }} entries
                    </div>
                    <div>{{ $logs->links() }}</div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-history fa-3x text-muted mb-3"></i>
                    <h5>No history records found</h5>
                    <p class="text-muted">Stock movements will appear here.</p>
                </div>
            @endif
        </div>
    </div>

</x-layouts.admin-layout>
