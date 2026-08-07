<x-layouts.admin-layout title="Purchase Orders">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Purchase Orders</h4>
            <p class="text-muted small mb-0">Manage supplier purchase orders</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.purchases.reports') }}" class="btn btn-outline-info">
                <i class="fas fa-chart-bar me-1"></i> Reports
            </a>
            <a href="{{ route('admin.purchases.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Create PO
            </a>
        </div>
    </div>

    <div class="row g-2 mb-4">
        <div class="col-6 col-md-2">
            <div class="card bg-secondary-subtle border-0">
                <div class="card-body text-center py-3">
                    <h5 class="fw-bold mb-0">{{ $stats['total'] }}</h5>
                    <small class="text-muted">Total</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-2">
            <div class="card bg-warning-subtle border-0">
                <div class="card-body text-center py-3">
                    <h5 class="fw-bold mb-0 text-warning">{{ $stats['pending'] }}</h5>
                    <small class="text-muted">Pending</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-2">
            <div class="card bg-success-subtle border-0">
                <div class="card-body text-center py-3">
                    <h5 class="fw-bold mb-0 text-success">{{ $stats['completed'] }}</h5>
                    <small class="text-muted">Completed</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-2">
            <div class="card bg-primary-subtle border-0">
                <div class="card-body text-center py-3">
                    <h5 class="fw-bold mb-0 text-primary">{{ number_format($stats['total_amount'], 2) }}</h5>
                    <small class="text-muted">Total Amount</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-2">
            <div class="card bg-success-subtle border-0">
                <div class="card-body text-center py-3">
                    <h5 class="fw-bold mb-0 text-success">{{ number_format($stats['total_paid'], 2) }}</h5>
                    <small class="text-muted">Total Paid</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-2">
            <div class="card bg-danger-subtle border-0">
                <div class="card-body text-center py-3">
                    <h5 class="fw-bold mb-0 text-danger">{{ number_format($stats['total_due'], 2) }}</h5>
                    <small class="text-muted">Total Due</small>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="GET" class="row g-2 mb-3">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" placeholder="Search PO, supplier, warehouse..." value="{{ $filters['search'] ?? '' }}">
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        @foreach(App\Enums\PurchaseStatus::cases() as $status)
                            <option value="{{ $status->value }}" {{ ($filters['status'] ?? '') == $status->value ? 'selected' : '' }}>{{ $status->label() }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="payment_status" class="form-select">
                        <option value="">All Payment</option>
                        @foreach(App\Enums\PurchasePaymentStatus::cases() as $ps)
                            <option value="{{ $ps->value }}" {{ ($filters['payment_status'] ?? '') == $ps->value ? 'selected' : '' }}>{{ $ps->label() }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="supplier_id" class="form-select">
                        <option value="">All Suppliers</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" {{ ($filters['supplier_id'] ?? '') == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="warehouse_id" class="form-select">
                        <option value="">All Warehouses</option>
                        @foreach($warehouses as $warehouse)
                            <option value="{{ $warehouse->id }}" {{ ($filters['warehouse_id'] ?? '') == $warehouse->id ? 'selected' : '' }}>{{ $warehouse->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i></button>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>PO Number</th>
                            <th>Supplier</th>
                            <th>Warehouse</th>
                            <th class="text-end">Items</th>
                            <th class="text-end">Total</th>
                            <th class="text-end">Paid</th>
                            <th class="text-end">Due</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($purchases as $purchase)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.purchases.show', $purchase->id) }}" class="fw-semibold text-decoration-none">
                                        {{ $purchase->po_number }}
                                    </a>
                                    @if($purchase->reference_number)
                                        <br><small class="text-muted">{{ $purchase->reference_number }}</small>
                                    @endif
                                </td>
                                <td>
                                    <span class="fw-semibold">{{ $purchase->supplier?->name }}</span>
                                    @if($purchase->supplier?->supplier_code)
                                        <br><small class="text-muted">{{ $purchase->supplier->supplier_code }}</small>
                                    @endif
                                </td>
                                <td>{{ $purchase->warehouse?->name }}</td>
                                <td class="text-end">{{ $purchase->items_count ?? $purchase->items->count() }}</td>
                                <td class="text-end fw-semibold">{{ number_format($purchase->total_amount, 2) }}</td>
                                <td class="text-end text-success">{{ number_format($purchase->paid_amount, 2) }}</td>
                                <td class="text-end {{ $purchase->due_amount > 0 ? 'text-danger' : '' }}">{{ number_format($purchase->due_amount, 2) }}</td>
                                <td>
                                    <span class="badge bg-{{ $purchase->status->color() }}">{{ $purchase->status->label() }}</span>
                                    <br>
                                    <small class="badge bg-{{ $purchase->payment_status->color() }} mt-1">{{ $purchase->payment_status->label() }}</small>
                                </td>
                                <td>
                                    <small>{{ $purchase->purchase_date?->format('d/m/Y') }}</small>
                                    <br><small class="text-muted">{{ $purchase->created_at?->diffForHumans() }}</small>
                                </td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item" href="{{ route('admin.purchases.show', $purchase->id) }}"><i class="fas fa-eye me-2"></i>View</a></li>
                                            @if($purchase->isEditable())
                                                <li><a class="dropdown-item" href="{{ route('admin.purchases.edit', $purchase->id) }}"><i class="fas fa-edit me-2"></i>Edit</a></li>
                                            @endif
                                            @if($purchase->isApprovable())
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <form method="POST" action="{{ route('admin.purchases.approve', $purchase->id) }}" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="dropdown-item text-success"><i class="fas fa-check-circle me-2"></i>Approve</button>
                                                    </form>
                                                </li>
                                                <li>
                                                    <form method="POST" action="{{ route('admin.purchases.reject', $purchase->id) }}" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Reject this purchase order?')"><i class="fas fa-times-circle me-2"></i>Reject</button>
                                                    </form>
                                                </li>
                                            @endif
                                            @if($purchase->isCancellable() && !$purchase->isApprovable())
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <form method="POST" action="{{ route('admin.purchases.cancel', $purchase->id) }}" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Cancel this purchase order?')"><i class="fas fa-ban me-2"></i>Cancel</button>
                                                    </form>
                                                </li>
                                            @endif
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item" href="{{ route('admin.purchases.clone', $purchase->id) }}"><i class="fas fa-copy me-2"></i>Clone</a></li>
                                            <li><a class="dropdown-item" href="{{ route('admin.purchases.print', $purchase->id) }}" target="_blank"><i class="fas fa-print me-2"></i>Print</a></li>
                                            @if($purchase->isDeletable())
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <form method="POST" action="{{ route('admin.purchases.destroy', $purchase->id) }}" class="d-inline">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Delete this purchase order?')"><i class="fas fa-trash me-2"></i>Delete</button>
                                                    </form>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center py-5 text-muted">
                                    <i class="fas fa-shopping-cart fa-3x mb-3 d-block"></i>
                                    No purchase orders found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3">
                <small class="text-muted">Showing {{ $purchases->firstItem() ?? 0 }} to {{ $purchases->lastItem() ?? 0 }} of {{ $purchases->total() }} entries</small>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.purchases.export.csv', request()->query()) }}" class="btn btn-sm btn-outline-success">
                        <i class="fas fa-file-csv me-1"></i> CSV
                    </a>
                    <a href="{{ route('admin.purchases.export.excel', request()->query()) }}" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-file-excel me-1"></i> Excel
                    </a>
                </div>
            </div>

            <div class="d-flex justify-content-center mt-3">
                {{ $purchases->withQueryString()->links() }}
            </div>
        </div>
    </div>

</x-layouts.admin-layout>
