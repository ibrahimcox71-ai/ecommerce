<x-layouts.admin-layout title="Inventory Reports">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Inventory Reports</h4>
            <p class="text-muted small mb-0">Stock value, movement analysis, and warehouse breakdown</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.inventories.export.csv') }}" class="btn btn-outline-success">
                <i class="fas fa-file-csv me-1"></i> Export CSV
            </a>
            <a href="{{ route('admin.inventories.export.excel') }}" class="btn btn-outline-primary">
                <i class="fas fa-file-excel me-1"></i> Export Excel
            </a>
            <a href="{{ route('admin.inventories.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.inventories.reports') }}" class="row g-3">
                <div class="col-md-3">
                    <select name="warehouse_id" class="form-select">
                        <option value="">All Warehouses</option>
                        @foreach($warehouses as $warehouse)
                            <option value="{{ $warehouse->id }}" {{ request('warehouse_id') == $warehouse->id ? 'selected' : '' }}>{{ $warehouse->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}" placeholder="From date">
                </div>
                <div class="col-md-3">
                    <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}" placeholder="To date">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-outline-primary w-100">Generate Report</button>
                </div>
            </form>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="text-muted small mb-1">Total Inventory Value</div>
                    <h4 class="fw-bold text-primary mb-0">${{ number_format($totalInventoryValue, 2) }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="text-muted small mb-1">Low Stock Items</div>
                    <h4 class="fw-bold text-warning mb-0">{{ $lowStockCount }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="text-muted small mb-1">Out of Stock Items</div>
                    <h4 class="fw-bold text-danger mb-0">{{ $outOfStockCount }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="text-muted small mb-1">Warehouses</div>
                    <h4 class="fw-bold text-info mb-0">{{ $warehouses->count() }}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Stock Movement Summary</h6>
                </div>
                <div class="card-body">
                    @php
                        $stockIn = $movementSummary->where('movement_type', 'in')->first();
                        $stockOut = $movementSummary->where('movement_type', 'out')->first();
                    @endphp
                    <div class="text-center mb-4">
                        <div class="row">
                            <div class="col-6">
                                <div class="p-3 bg-success bg-opacity-10 rounded">
                                    <div class="text-success small">Stock In</div>
                                    <h3 class="fw-bold mb-0 text-success">{{ number_format($stockIn?->total_quantity ?? 0) }}</h3>
                                    <small class="text-muted">{{ number_format($stockIn?->total_transactions ?? 0) }} transactions</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 bg-danger bg-opacity-10 rounded">
                                    <div class="text-danger small">Stock Out</div>
                                    <h3 class="fw-bold mb-0 text-danger">{{ number_format($stockOut?->total_quantity ?? 0) }}</h3>
                                    <small class="text-muted">{{ number_format($stockOut?->total_transactions ?? 0) }} transactions</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($stockIn || $stockOut)
                        @php
                            $total = ($stockIn?->total_quantity ?? 0) + ($stockOut?->total_quantity ?? 0);
                            $inPct = $total > 0 ? (($stockIn?->total_quantity ?? 0) / $total) * 100 : 0;
                        @endphp
                        <div class="progress" style="height: 25px;">
                            <div class="progress-bar bg-success" style="width: {{ $inPct }}%">{{ number_format($inPct, 1) }}% In</div>
                            <div class="progress-bar bg-danger" style="width: {{ 100 - $inPct }}%">{{ number_format(100 - $inPct, 1) }}% Out</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Stock Value by Warehouse</h6>
                </div>
                <div class="card-body p-0">
                    @if($stockValueSummary->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0 ps-4">Warehouse</th>
                                        <th class="border-0 text-end">Items</th>
                                        <th class="border-0 text-end">Units</th>
                                        <th class="border-0 pe-4 text-end">Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($stockValueSummary as $sv)
                                        <tr>
                                            <td class="ps-4"><span class="fw-semibold small">{{ $sv->warehouse?->name ?? 'Unknown' }}</span></td>
                                            <td class="text-end text-muted small">{{ number_format($sv->total_items) }}</td>
                                            <td class="text-end text-muted small">{{ number_format($sv->total_quantity) }}</td>
                                            <td class="pe-4 text-end fw-semibold">${{ number_format($sv->stock_value, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-chart-bar fa-2x mb-2"></i>
                            <p class="mb-0">No data available</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Warehouse Stock Summary</h6>
                </div>
                <div class="card-body p-0">
                    @if($stockSummaryByWarehouse->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0 ps-4">Warehouse</th>
                                        <th class="border-0 text-end">Total Items</th>
                                        <th class="border-0 text-end">Total Units</th>
                                        <th class="border-0 text-end">Low Stock</th>
                                        <th class="border-0 text-end">Out of Stock</th>
                                        <th class="border-0 pe-4 text-end">Stock Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($stockSummaryByWarehouse as $summary)
                                        <tr>
                                            <td class="ps-4"><span class="fw-semibold small">{{ $summary['warehouse'] }}</span></td>
                                            <td class="text-end">{{ number_format($summary['total_items']) }}</td>
                                            <td class="text-end">{{ number_format($summary['total_quantity']) }}</td>
                                            <td class="text-end">
                                                <span class="badge bg-{{ $summary['low_stock'] > 0 ? 'warning' : 'success' }}">{{ $summary['low_stock'] }}</span>
                                            </td>
                                            <td class="text-end">
                                                <span class="badge bg-{{ $summary['out_of_stock'] > 0 ? 'danger' : 'success' }}">{{ $summary['out_of_stock'] }}</span>
                                            </td>
                                            <td class="pe-4 text-end fw-semibold">${{ number_format($summary['value'], 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-warehouse fa-2x mb-2"></i>
                            <p class="mb-0">No warehouse data available</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</x-layouts.admin-layout>
