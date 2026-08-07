<x-layouts.admin-layout title="Coupons">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Coupons</h4>
            <p class="text-muted small mb-0">Manage discount coupons</p>
        </div>
        <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Add Coupon
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.coupons.index') }}" class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Search by code or description..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="type" class="form-select">
                        <option value="">All Types</option>
                        <option value="percentage" {{ request('type') === 'percentage' ? 'selected' : '' }}>Percentage</option>
                        <option value="fixed" {{ request('type') === 'fixed' ? 'selected' : '' }}>Fixed</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-outline-primary w-100">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @if ($coupons->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0">Code</th>
                                <th class="border-0">Type</th>
                                <th class="border-0 text-end">Value</th>
                                <th class="border-0 text-end">Min Order</th>
                                <th class="border-0 text-end">Max Discount</th>
                                <th class="border-0 text-center">Usage</th>
                                <th class="border-0">Expiry</th>
                                <th class="border-0 text-center">Status</th>
                                <th class="border-0 text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($coupons as $coupon)
                                <tr>
                                    <td>
                                        <span class="fw-semibold font-monospace">{{ $coupon->code }}</span>
                                        @if ($coupon->description)
                                            <small class="d-block text-muted text-truncate" style="max-width: 180px;">{{ $coupon->description }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($coupon->type === 'percentage')
                                            <span class="badge bg-info">Percentage</span>
                                        @else
                                            <span class="badge bg-secondary">Fixed</span>
                                        @endif
                                    </td>
                                    <td class="text-end fw-semibold">
                                        {{ $coupon->type === 'percentage' ? $coupon->value . '%' : '$' . number_format($coupon->value, 2) }}
                                    </td>
                                    <td class="text-end">
                                        {{ $coupon->min_order_amount ? '$' . number_format($coupon->min_order_amount, 2) : '—' }}
                                    </td>
                                    <td class="text-end">
                                        {{ $coupon->max_discount ? '$' . number_format($coupon->max_discount, 2) : '—' }}
                                    </td>
                                    <td class="text-center">
                                        @if ($coupon->usage_limit > 0)
                                            <small>{{ $coupon->usages_count }} / {{ $coupon->usage_limit }}</small>
                                        @else
                                            <small>{{ $coupon->usages_count }} / &infin;</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($coupon->expires_at)
                                            <small class="{{ now()->gt($coupon->expires_at) ? 'text-danger' : 'text-muted' }}">
                                                {{ $coupon->expires_at->format('M d, Y') }}
                                            </small>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($coupon->is_active && !$coupon->expires_at?->isPast())
                                            <span class="badge bg-success">Active</span>
                                        @elseif ($coupon->expires_at?->isPast())
                                            <span class="badge bg-secondary">Expired</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <div class="btn-group">
                                            <a href="{{ route('admin.coupons.show', $coupon) }}" class="btn btn-sm btn-outline-secondary" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.coupons.edit', $coupon) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="POST" action="{{ route('admin.coupons.toggle-status', $coupon) }}" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-{{ $coupon->is_active ? 'warning' : 'success' }}" title="{{ $coupon->is_active ? 'Deactivate' : 'Activate' }}">
                                                    <i class="fas fa-{{ $coupon->is_active ? 'pause' : 'play' }}"></i>
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.coupons.destroy', $coupon) }}" class="d-inline" onsubmit="return confirm('Delete coupon {{ $coupon->code }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted small">
                        Showing {{ $coupons->firstItem() }} to {{ $coupons->lastItem() }} of {{ $coupons->total() }} entries
                    </div>
                    <div>{{ $coupons->links() }}</div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-ticket-alt fa-4x text-muted mb-3"></i>
                    <h5>No coupons found</h5>
                    <p class="text-muted">
                        @if(request()->anyFilled(['search', 'type', 'status']))
                            No coupons match your filters. <a href="{{ route('admin.coupons.index') }}">Clear filters</a>
                        @else
                            Get started by creating your first coupon.
                        @endif
                    </p>
                    <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Add Coupon
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-layouts.admin-layout>
