<x-layouts.admin-layout title="Inventory Alerts">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Inventory Alerts</h4>
            <p class="text-muted small mb-0">Items requiring immediate attention</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.inventories.low-stock') }}" class="btn btn-outline-warning">
                <i class="fas fa-exclamation-triangle me-1"></i> Low Stock View
            </a>
            <a href="{{ route('admin.inventories.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card bg-warning text-white border-0">
                <div class="card-body d-flex align-items-center">
                    <i class="fas fa-exclamation-triangle fa-3x me-3 opacity-75"></i>
                    <div>
                        <h3 class="fw-bold mb-0">{{ $lowStockCount }}</h3>
                        <p class="mb-0 opacity-75">Low Stock Items</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white border-0">
                <div class="card-body d-flex align-items-center">
                    <i class="fas fa-times-circle fa-3x me-3 opacity-75"></i>
                    <div>
                        <h3 class="fw-bold mb-0">{{ $outOfStockCount }}</h3>
                        <p class="mb-0 opacity-75">Out of Stock Items</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white border-0">
                <div class="card-body d-flex align-items-center">
                    <i class="fas fa-boxes fa-3x me-3 opacity-75"></i>
                    <div>
                        <h3 class="fw-bold mb-0">{{ $overstockItems->count() }}</h3>
                        <p class="mb-0 opacity-75">Overstock Items</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-primary text-white border-0">
                <div class="card-body d-flex align-items-center">
                    <i class="fas fa-sync-alt fa-3x me-3 opacity-75"></i>
                    <div>
                        <h3 class="fw-bold mb-0">{{ $needsReorder->count() }}</h3>
                        <p class="mb-0 opacity-75">Needs Reorder</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0 text-warning"><i class="fas fa-exclamation-triangle me-2"></i>Low Stock Items</h6>
                    <span class="badge bg-warning">{{ $lowStockItems->count() }}</span>
                </div>
                <div class="card-body p-0">
                    @if($lowStockItems->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($lowStockItems as $item)
                                <div class="list-group-item list-group-item-action border-0 d-flex justify-content-between align-items-center">
                                    <div class="small">
                                        <span class="fw-semibold">{{ $item->variant ? $item->variant->product->name . ' - ' . $item->variant->name : ($item->product?->name ?? 'Deleted') }}</span>
                                        <br><span class="text-muted">{{ $item->warehouse?->name }}</span>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge bg-warning">{{ $item->quantity - $item->reserved_quantity }} left</span>
                                        <br><small class="text-muted">Threshold: {{ $item->low_stock_threshold }}</small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                            <p class="mb-0">No low stock items</p>
                        </div>
                    @endif
                </div>
                <div class="card-footer bg-transparent text-center">
                    <a href="{{ route('admin.inventories.low-stock') }}" class="btn btn-sm btn-warning">View All Low Stock</a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0 text-danger"><i class="fas fa-times-circle me-2"></i>Out of Stock Items</h6>
                    <span class="badge bg-danger">{{ $outOfStockItems->count() }}</span>
                </div>
                <div class="card-body p-0">
                    @if($outOfStockItems->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($outOfStockItems as $item)
                                <div class="list-group-item list-group-item-action border-0 d-flex justify-content-between align-items-center">
                                    <div class="small">
                                        <span class="fw-semibold">{{ $item->variant ? $item->variant->product->name . ' - ' . $item->variant->name : ($item->product?->name ?? 'Deleted') }}</span>
                                        <br><span class="text-muted">{{ $item->warehouse?->name }}</span>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge bg-danger">0 available</span>
                                        <br><small class="text-muted">Last updated: {{ $item->updated_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                            <p class="mb-0">No out of stock items</p>
                        </div>
                    @endif
                </div>
                <div class="card-footer bg-transparent text-center">
                    <a href="{{ route('admin.inventories.low-stock') }}" class="btn btn-sm btn-danger">View All Out of Stock</a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0 text-info"><i class="fas fa-boxes me-2"></i>Overstock Items</h6>
                    <span class="badge bg-info">{{ $overstockItems->count() }}</span>
                </div>
                <div class="card-body p-0">
                    @if($overstockItems->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($overstockItems as $item)
                                <div class="list-group-item list-group-item-action border-0 d-flex justify-content-between align-items-center">
                                    <div class="small">
                                        <span class="fw-semibold">{{ $item->variant ? $item->variant->product->name . ' - ' . $item->variant->name : ($item->product?->name ?? 'Deleted') }}</span>
                                        <br><span class="text-muted">{{ $item->warehouse?->name }}</span>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge bg-info">{{ $item->quantity }} units</span>
                                        <br><small class="text-muted">Max: {{ $item->maximum_stock }}</small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                            <p class="mb-0">No overstock items</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0 text-primary"><i class="fas fa-sync-alt me-2"></i>Needs Reorder</h6>
                    <span class="badge bg-primary">{{ $needsReorder->count() }}</span>
                </div>
                <div class="card-body p-0">
                    @if($needsReorder->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($needsReorder as $item)
                                <div class="list-group-item list-group-item-action border-0 d-flex justify-content-between align-items-center">
                                    <div class="small">
                                        <span class="fw-semibold">{{ $item->variant ? $item->variant->product->name . ' - ' . $item->variant->name : ($item->product?->name ?? 'Deleted') }}</span>
                                        <br><span class="text-muted">{{ $item->warehouse?->name }}</span>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge bg-primary">{{ $item->quantity - $item->reserved_quantity }} available</span>
                                        <br><small class="text-muted">Reorder at: {{ $item->reorder_level }}</small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                            <p class="mb-0">No items need reorder</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</x-layouts.admin-layout>
