<x-layouts.admin-layout title="Warehouse Details">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">{{ $warehouse->name }}</h4>
            <p class="text-muted small mb-0">Warehouse details and inventory summary</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.warehouses.edit', $warehouse->id) }}" class="btn btn-primary">
                <i class="fas fa-edit me-1"></i> Edit
            </a>
            <a href="{{ route('admin.warehouses.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Basic Information</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <dl class="mb-0">
                                <dt class="text-muted small">Name</dt>
                                <dd class="fw-semibold">{{ $warehouse->name }}</dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <dl class="mb-0">
                                <dt class="text-muted small">Code</dt>
                                <dd><code>{{ $warehouse->code }}</code></dd>
                            </dl>
                        </div>
                    </div>
                    @if($warehouse->manager_name)
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <dl class="mb-0">
                                    <dt class="text-muted small">Warehouse Manager</dt>
                                    <dd class="fw-semibold">{{ $warehouse->manager_name }}</dd>
                                </dl>
                            </div>
                        </div>
                    @endif
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <dl class="mb-0">
                                <dt class="text-muted small">Address</dt>
                                <dd>{{ $warehouse->address ?: 'Not set' }}</dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <dl class="mb-0">
                                <dt class="text-muted small">City, State</dt>
                                <dd>{{ $warehouse->city ?: '—' }}{{ $warehouse->city && $warehouse->state ? ', ' : '' }}{{ $warehouse->state ?: '' }}</dd>
                            </dl>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <dl class="mb-0">
                                <dt class="text-muted small">Country</dt>
                                <dd>{{ $warehouse->country ?: 'Not set' }}</dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <dl class="mb-0">
                                <dt class="text-muted small">Postal Code</dt>
                                <dd>{{ $warehouse->postal_code ?: 'Not set' }}</dd>
                            </dl>
                        </div>
                    </div>
                    @if($warehouse->phone || $warehouse->email)
                        <hr>
                        <div class="row">
                            @if($warehouse->phone)
                                <div class="col-md-6">
                                    <dl class="mb-0">
                                        <dt class="text-muted small">Phone</dt>
                                        <dd>{{ $warehouse->phone }}</dd>
                                    </dl>
                                </div>
                            @endif
                            @if($warehouse->email)
                                <div class="col-md-6">
                                    <dl class="mb-0">
                                        <dt class="text-muted small">Email</dt>
                                        <dd>{{ $warehouse->email }}</dd>
                                    </dl>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Recent Stock Movements</h6>
                </div>
                <div class="card-body p-0">
                    @if($recentMovements->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0 ps-4">Reference</th>
                                        <th class="border-0">Product</th>
                                        <th class="border-0 text-center">Type</th>
                                        <th class="border-0 text-center">Qty</th>
                                        <th class="border-0 pe-4">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentMovements as $m)
                                        <tr>
                                            <td class="ps-4"><code class="small">{{ $m->reference_number }}</code></td>
                                            <td><span class="small">{{ $m->product?->name ?? '—' }}</span></td>
                                            <td class="text-center">
                                                <span class="badge bg-{{ $m->movement_type === 'stock_in' ? 'success' : ($m->movement_type === 'stock_out' ? 'danger' : 'info') }}">
                                                    {{ ucfirst(str_replace('_', ' ', $m->movement_type)) }}
                                                </span>
                                            </td>
                                            <td class="text-center fw-semibold">{{ number_format($m->quantity) }}</td>
                                            <td class="pe-4 text-muted small">{{ $m->created_at->format('M d, H:i') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-exchange-alt fa-2x mb-2"></i>
                            <p class="mb-0">No recent movements</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Status</h6>
                </div>
                <div class="card-body text-center">
                    <div class="d-flex justify-content-center gap-2 mb-0">
                        @if($warehouse->status)
                            <span class="badge bg-success"><i class="fas fa-check me-1"></i> Active</span>
                        @else
                            <span class="badge bg-secondary"><i class="fas fa-times me-1"></i> Inactive</span>
                        @endif
                        @if($warehouse->is_default)
                            <span class="badge bg-info"><i class="fas fa-star me-1"></i> Default</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Inventory Summary</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Total Items</span>
                        <span class="badge bg-primary">{{ $warehouse->inventories_count }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Total Value</span>
                        <span class="fw-semibold">${{ number_format($totalValue ?? 0, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Low Stock</span>
                        <span class="badge bg-warning">{{ $lowStockCount }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Out of Stock</span>
                        <span class="badge bg-danger">{{ $outOfStockCount }}</span>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Details</h6>
                </div>
                <div class="card-body">
                    <dl class="mb-2">
                        <dt class="text-muted small">Created</dt>
                        <dd class="mb-0">{{ $warehouse->created_at->format('M d, Y H:i') }}</dd>
                    </dl>
                    <dl class="mb-2">
                        <dt class="text-muted small">Updated</dt>
                        <dd class="mb-0">{{ $warehouse->updated_at->format('M d, Y H:i') }}</dd>
                    </dl>
                    <dl class="mb-0">
                        <dt class="text-muted small">Sort Order</dt>
                        <dd class="mb-0">{{ $warehouse->sort_order }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

</x-layouts.admin-layout>
