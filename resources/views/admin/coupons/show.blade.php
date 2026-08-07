<x-layouts.admin-layout title="Coupon Detail">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">{{ $coupon->code }}</h4>
            <p class="text-muted small mb-0">Coupon details and usage</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.coupons.edit', $coupon) }}" class="btn btn-primary">
                <i class="fas fa-edit me-1"></i> Edit
            </a>
            <a href="{{ route('admin.coupons.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-semibold">Usage History</h6>
                    <span class="badge bg-primary">{{ $coupon->usages->count() }} uses</span>
                </div>
                <div class="card-body">
                    @if ($coupon->usages->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Customer</th>
                                        <th>Order</th>
                                        <th class="text-end">Discount</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($coupon->usages as $usage)
                                        <tr>
                                            <td>{{ $usage->user?->name ?? $usage->order?->user?->name ?? '—' }}</td>
                                            <td>
                                                @if ($usage->order)
                                                    <a href="{{ route('admin.orders.show', $usage->order) }}">#{{ $usage->order->order_number }}</a>
                                                @else
                                                    —
                                                @endif
                                            </td>
                                            <td class="text-end">${{ number_format($usage->discount_amount, 2) }}</td>
                                            <td><small>{{ $usage->created_at->format('M d, Y h:i A') }}</small></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted mb-0">No usage yet.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h6 class="mb-0 fw-semibold">Details</h6>
                </div>
                <div class="card-body small">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Code</span>
                        <span class="fw-semibold font-monospace">{{ $coupon->code }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Type</span>
                        <span>{{ $coupon->type === 'percentage' ? 'Percentage' : 'Fixed' }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Value</span>
                        <span class="fw-semibold">{{ $coupon->type === 'percentage' ? $coupon->value . '%' : '$' . number_format($coupon->value, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Min Order</span>
                        <span>{{ $coupon->min_order_amount ? '$' . number_format($coupon->min_order_amount, 2) : 'None' }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Max Discount</span>
                        <span>{{ $coupon->max_discount ? '$' . number_format($coupon->max_discount, 2) : 'None' }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Usage</span>
                        <span>{{ $coupon->usages->count() }}{{ $coupon->usage_limit > 0 ? ' / ' . $coupon->usage_limit : '' }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Status</span>
                        <span>
                            @if ($coupon->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-warning text-dark">Inactive</span>
                            @endif
                        </span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Starts</span>
                        <span>{{ $coupon->starts_at ? $coupon->starts_at->format('M d, Y') : 'Immediately' }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Expires</span>
                        <span class="{{ $coupon->expires_at?->isPast() ? 'text-danger' : '' }}">
                            {{ $coupon->expires_at ? $coupon->expires_at->format('M d, Y') : 'Never' }}
                        </span>
                    </div>
                    @if ($coupon->description)
                        <hr>
                        <p class="mb-0">{{ $coupon->description }}</p>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-white">
                    <h6 class="mb-0 fw-semibold">Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex gap-2">
                        <form method="POST" action="{{ route('admin.coupons.toggle-status', $coupon) }}">
                            @csrf
                            <button type="submit" class="btn btn-{{ $coupon->is_active ? 'warning' : 'success' }} btn-sm">
                                <i class="fas fa-{{ $coupon->is_active ? 'pause' : 'play' }} me-1"></i>
                                {{ $coupon->is_active ? 'Deactivate' : 'Activate' }}
                            </button>
                        </form>
                        <form method="POST" action="{{ route('admin.coupons.destroy', $coupon) }}" onsubmit="return confirm('Delete this coupon?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash me-1"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin-layout>
