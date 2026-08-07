<x-layouts.admin-layout title="Stock Movements">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Stock Movements</h4>
            <p class="text-muted small mb-0">Track all stock movement activities</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.stock-movements.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> New Movement
            </a>
            <a href="{{ route('admin.inventories.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to Inventory
            </a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.stock-movements.index') }}" class="row g-3">
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
                        <input type="text" name="search" class="form-control" placeholder="Search product, ref #..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <select name="movement_type" class="form-select">
                        <option value="">All Types</option>
                        @foreach($movementTypes as $val => $label)
                            <option value="{{ $val }}" {{ request('movement_type') === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
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
                    <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}" placeholder="From">
                </div>
                <div class="col-md-2">
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
            @if($movements->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0" style="width: 140px;">Reference</th>
                                <th class="border-0">Date</th>
                                <th class="border-0">Product</th>
                                <th class="border-0 text-center" style="width: 100px;">Type</th>
                                <th class="border-0" style="width: 120px;">From</th>
                                <th class="border-0" style="width: 120px;">To</th>
                                <th class="border-0 text-center" style="width: 80px;">Qty</th>
                                <th class="border-0" style="width: 140px;">Reason</th>
                                <th class="border-0" style="width: 100px;">By</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($movements as $m)
                                @php
                                    $typeColors = [
                                        'stock_in' => 'success',
                                        'stock_out' => 'danger',
                                        'adjustment' => 'warning',
                                        'transfer' => 'info',
                                        'return' => 'primary',
                                        'damage' => 'danger',
                                        'lost' => 'secondary',
                                    ];
                                    $typeLabels = [
                                        'stock_in' => 'Stock In',
                                        'stock_out' => 'Stock Out',
                                        'adjustment' => 'Adjustment',
                                        'transfer' => 'Transfer',
                                        'return' => 'Return',
                                        'damage' => 'Damage',
                                        'lost' => 'Lost',
                                    ];
                                @endphp
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.stock-movements.show', $m->id) }}" class="text-decoration-none">
                                            <code class="small">{{ $m->reference_number }}</code>
                                        </a>
                                    </td>
                                    <td class="small text-muted">{{ $m->created_at->format('M d, H:i') }}</td>
                                    <td>
                                        <span class="small fw-semibold">
                                            {{ $m->variant ? $m->variant->product->name . ' - ' . $m->variant->name : ($m->product?->name ?? 'Deleted') }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-{{ $typeColors[$m->movement_type] ?? 'secondary' }}">
                                            {{ $typeLabels[$m->movement_type] ?? $m->movement_type }}
                                        </span>
                                    </td>
                                    <td><span class="small">{{ $m->fromWarehouse?->name ?? '—' }}</span></td>
                                    <td><span class="small">{{ $m->toWarehouse?->name ?? '—' }}</span></td>
                                    <td class="text-center fw-semibold">{{ number_format($m->quantity) }}</td>
                                    <td><span class="small text-muted">{{ $m->reason ?: '—' }}</span></td>
                                    <td><span class="small text-muted">{{ $m->causer?->name ?? 'System' }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted small">
                        Showing {{ $movements->firstItem() }} to {{ $movements->lastItem() }} of {{ $movements->total() }} entries
                    </div>
                    <div>{{ $movements->links() }}</div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-exchange-alt fa-3x text-muted mb-3"></i>
                    <h5>No stock movements found</h5>
                    <p class="text-muted">
                        @if(request()->anyFilled(['search', 'movement_type', 'warehouse_id', 'date_from', 'date_to']))
                            No movements match your filters. <a href="{{ route('admin.stock-movements.index') }}">Clear filters</a>
                        @else
                            Record your first stock movement to see it here.
                        @endif
                    </p>
                    <a href="{{ route('admin.stock-movements.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> New Movement
                    </a>
                </div>
            @endif
        </div>
    </div>

</x-layouts.admin-layout>
