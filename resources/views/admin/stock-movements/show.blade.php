<x-layouts.admin-layout title="Stock Movement Details">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Stock Movement</h4>
            <p class="text-muted small mb-0">Reference: <code>{{ $movement->reference_number }}</code></p>
        </div>
        <a href="{{ route('admin.stock-movements.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Movement Information</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <dl class="mb-0">
                                <dt class="text-muted small">Reference Number</dt>
                                <dd class="fw-semibold"><code>{{ $movement->reference_number }}</code></dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <dl class="mb-0">
                                <dt class="text-muted small">Date</dt>
                                <dd class="fw-semibold">{{ $movement->created_at->format('F d, Y H:i:s') }}</dd>
                            </dl>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <dl class="mb-0">
                                <dt class="text-muted small">Movement Type</dt>
                                <dd>
                                    @php
                                        $colors = ['stock_in'=>'success','stock_out'=>'danger','adjustment'=>'warning','transfer'=>'info','return'=>'primary','damage'=>'danger','lost'=>'secondary'];
                                        $labels = ['stock_in'=>'Stock In','stock_out'=>'Stock Out','adjustment'=>'Adjustment','transfer'=>'Transfer','return'=>'Return','damage'=>'Damage','lost'=>'Lost'];
                                    @endphp
                                    <span class="badge bg-{{ $colors[$movement->movement_type] ?? 'secondary' }}">
                                        {{ $labels[$movement->movement_type] ?? $movement->movement_type }}
                                    </span>
                                </dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <dl class="mb-0">
                                <dt class="text-muted small">Quantity</dt>
                                <dd class="fw-bold h4 mb-0">{{ number_format($movement->quantity) }}</dd>
                            </dl>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <dl class="mb-0">
                                <dt class="text-muted small">Product</dt>
                                <dd class="fw-semibold">{{ $movement->product?->name ?? 'Deleted Product' }}</dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <dl class="mb-0">
                                <dt class="text-muted small">SKU</dt>
                                <dd><code>{{ $movement->product?->sku ?? '—' }}</code></dd>
                            </dl>
                        </div>
                    </div>
                    @if($movement->variant)
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <dl class="mb-0">
                                    <dt class="text-muted small">Variant</dt>
                                    <dd class="fw-semibold">{{ $movement->variant->name }}</dd>
                                </dl>
                            </div>
                            <div class="col-md-6">
                                <dl class="mb-0">
                                    <dt class="text-muted small">Variant SKU</dt>
                                    <dd><code>{{ $movement->variant->sku }}</code></dd>
                                </dl>
                            </div>
                        </div>
                    @endif
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <dl class="mb-0">
                                <dt class="text-muted small">From Warehouse</dt>
                                <dd>{{ $movement->fromWarehouse?->name ?? '—' }}</dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <dl class="mb-0">
                                <dt class="text-muted small">To Warehouse</dt>
                                <dd>{{ $movement->toWarehouse?->name ?? '—' }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Stock Levels</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Before</span>
                        <span class="fw-semibold">{{ number_format($movement->quantity_before) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Change</span>
                        <span class="fw-semibold text-{{ $movement->quantity_change > 0 ? 'success' : ($movement->quantity_change < 0 ? 'danger' : 'secondary') }}">
                            {{ $movement->quantity_change > 0 ? '+' : '' }}{{ number_format($movement->quantity_change ?? $movement->quantity) }}
                        </span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">After</span>
                        <span class="fw-semibold">{{ number_format($movement->quantity_after) }}</span>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Additional Info</h6>
                </div>
                <div class="card-body">
                    <dl class="mb-2">
                        <dt class="text-muted small">Reason</dt>
                        <dd class="mb-0">{{ $movement->reason ?: '—' }}</dd>
                    </dl>
                    @if($movement->notes)
                        <dl class="mb-2">
                            <dt class="text-muted small">Notes</dt>
                            <dd class="mb-0">{{ $movement->notes }}</dd>
                        </dl>
                    @endif
                    <dl class="mb-2">
                        <dt class="text-muted small">Recorded By</dt>
                        <dd class="mb-0">{{ $movement->causer?->name ?? 'System' }}</dd>
                    </dl>
                    <dl class="mb-0">
                        <dt class="text-muted small">Updated</dt>
                        <dd class="mb-0">{{ $movement->updated_at->format('M d, Y H:i') }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

</x-layouts.admin-layout>
