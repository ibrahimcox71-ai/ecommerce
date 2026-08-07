<x-layouts.admin-layout title="Inventory">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Inventory</h4>
            <p class="text-muted small mb-0">Manage stock across warehouses</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.stock-movements.index') }}" class="btn btn-outline-info">
                <i class="fas fa-exchange-alt me-1"></i> Movements
            </a>
            <a href="{{ route('admin.inventories.alerts') }}" class="btn btn-outline-danger position-relative">
                <i class="fas fa-bell me-1"></i> Alerts
                @if($lowStockCount + $outOfStockCount > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">{{ $lowStockCount + $outOfStockCount }}</span>
                @endif
            </a>
            <a href="{{ route('admin.inventories.low-stock') }}" class="btn btn-outline-warning position-relative">
                <i class="fas fa-exclamation-triangle me-1"></i> Low Stock
                @if($lowStockCount > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">{{ $lowStockCount }}</span>
                @endif
            </a>
            <a href="{{ route('admin.inventories.stock-in') }}" class="btn btn-success">
                <i class="fas fa-plus-circle me-1"></i> Stock In
            </a>
            <a href="{{ route('admin.inventories.stock-out') }}" class="btn btn-danger">
                <i class="fas fa-minus-circle me-1"></i> Stock Out
            </a>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0 opacity-75">Total Products</h6>
                            <h3 class="fw-bold mb-0">{{ $totalProducts }}</h3>
                        </div>
                        <i class="fas fa-box fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0 opacity-75">Total Stock Value</h6>
                            <h3 class="fw-bold mb-0">${{ number_format($totalStockValue, 2) }}</h3>
                        </div>
                        <i class="fas fa-dollar-sign fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0 opacity-75">Low Stock</h6>
                            <h3 class="fw-bold mb-0">{{ $lowStockCount }}</h3>
                        </div>
                        <i class="fas fa-exclamation-triangle fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0 opacity-75">Out of Stock</h6>
                            <h3 class="fw-bold mb-0">{{ $outOfStockCount }}</h3>
                        </div>
                        <i class="fas fa-times-circle fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.inventories.index') }}" class="row g-3">
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
                        <input type="text" name="search" class="form-control" placeholder="Search by name, SKU, or barcode..." value="{{ request('search') }}">
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
                    <select name="stock_status" class="form-select">
                        <option value="">All Stock Status</option>
                        <option value="in" {{ request('stock_status') === 'in' ? 'selected' : '' }}>In Stock</option>
                        <option value="low" {{ request('stock_status') === 'low' ? 'selected' : '' }}>Low Stock</option>
                        <option value="out" {{ request('stock_status') === 'out' ? 'selected' : '' }}>Out of Stock</option>
                        <option value="overstock" {{ request('stock_status') === 'overstock' ? 'selected' : '' }}>Overstock</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="category_id" class="form-select">
                        <option value="">All Categories</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-outline-primary w-100">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @if($inventories->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0" style="width: 50px;">Image</th>
                                <th class="border-0">Product</th>
                                <th class="border-0" style="width: 100px;">SKU</th>
                                <th class="border-0" style="width: 130px;">Warehouse</th>
                                <th class="border-0 text-center" style="width: 70px;">Stock</th>
                                <th class="border-0 text-center" style="width: 70px;">Available</th>
                                <th class="border-0 text-center" style="width: 70px;">Reserved</th>
                                <th class="border-0 text-center" style="width: 70px;">Damaged</th>
                                <th class="border-0 text-center" style="width: 90px;">Status</th>
                                <th class="border-0 text-end" style="width: 140px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($inventories as $inv)
                                @php
                                    $available = $inv->quantity - $inv->reserved_quantity;
                                    $statusClass = $available <= 0 ? 'danger' : ($available <= $inv->low_stock_threshold ? 'warning' : 'success');
                                    $statusText = $available <= 0 ? 'Out' : ($available <= $inv->low_stock_threshold ? 'Low' : 'In Stock');
                                    $productName = $inv->variant ? $inv->variant->product->name . ' - ' . $inv->variant->name : ($inv->product?->name ?? 'Deleted Product');
                                    $imageUrl = $inv->product?->thumbnail_url;
                                @endphp
                                <tr>
                                    <td>
                                        @if($imageUrl)
                                            <img src="{{ $imageUrl }}" alt="" class="rounded" style="width: 40px; height: 40px; object-fit: cover;">
                                        @else
                                            <div class="rounded bg-light d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                <i class="fas fa-box text-muted"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="fw-semibold small">{{ $productName }}</span>
                                    </td>
                                    <td><code class="small">{{ $inv->variant?->sku ?? $inv->product?->sku ?? '—' }}</code></td>
                                    <td><span class="small">{{ $inv->warehouse?->name ?? '—' }}</span></td>
                                    <td class="text-center fw-semibold">{{ number_format($inv->quantity) }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-{{ $statusClass }}">{{ number_format($available) }}</span>
                                    </td>
                                    <td class="text-center text-muted small">{{ number_format($inv->reserved_quantity) }}</td>
                                    <td class="text-center text-muted small">{{ number_format($inv->damaged_stock) }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-{{ $statusClass }}" style="min-width: 60px;">{{ $statusText }}</span>
                                    </td>
                                    <td class="text-end">
                                        <div class="btn-group">
                                            <a href="{{ route('admin.inventories.stock-in') }}?product_id={{ $inv->product_id }}&variant_id={{ $inv->product_variant_id }}&warehouse_id={{ $inv->warehouse_id }}"
                                               class="btn btn-sm btn-outline-success" title="Stock In">
                                                <i class="fas fa-plus"></i>
                                            </a>
                                            <a href="{{ route('admin.inventories.stock-out') }}?product_id={{ $inv->product_id }}&variant_id={{ $inv->product_variant_id }}&warehouse_id={{ $inv->warehouse_id }}"
                                               class="btn btn-sm btn-outline-danger" title="Stock Out">
                                                <i class="fas fa-minus"></i>
                                            </a>
                                            <a href="{{ route('admin.inventories.history') }}?search={{ $inv->product?->sku ?? $inv->variant?->sku }}"
                                               class="btn btn-sm btn-outline-info" title="History">
                                                <i class="fas fa-history"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted small">
                        Showing {{ $inventories->firstItem() }} to {{ $inventories->lastItem() }} of {{ $inventories->total() }} entries
                    </div>
                    <div>{{ $inventories->links() }}</div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-warehouse fa-3x text-muted mb-3"></i>
                    <h5>No inventory records found</h5>
                    <p class="text-muted">
                        @if(request()->anyFilled(['search', 'warehouse_id', 'stock_status']))
                            No records match your filters. <a href="{{ route('admin.inventories.index') }}">Clear filters</a>
                        @else
                            Start by adding stock to products.
                        @endif
                    </p>
                    <a href="{{ route('admin.inventories.stock-in') }}" class="btn btn-success">
                        <i class="fas fa-plus-circle me-1"></i> Stock In
                    </a>
                </div>
            @endif
        </div>
    </div>

</x-layouts.admin-layout>
