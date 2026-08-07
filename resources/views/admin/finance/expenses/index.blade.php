<x-layouts.admin-layout title="Expenses">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div><h4 class="fw-bold mb-1">Expenses</h4><p class="text-muted small mb-0">Manage business expenses</p></div>
        <a href="{{ route('admin.finance.expenses.create') }}" class="btn btn-primary"><i class="fas fa-plus me-1"></i> New Expense</a>
    </div>

    <div class="row g-2 mb-4">
        <div class="col-3"><div class="card bg-success-subtle border-0"><div class="card-body text-center py-2"><h5 class="fw-bold mb-0 text-success">{{ number_format($stats['total_approved'], 2) }}</h5><small class="text-muted">Approved</small></div></div></div>
        <div class="col-3"><div class="card bg-warning-subtle border-0"><div class="card-body text-center py-2"><h5 class="fw-bold mb-0 text-warning">{{ number_format($stats['total_pending'], 2) }}</h5><small class="text-muted">Pending</small></div></div></div>
        <div class="col-3"><div class="card bg-primary-subtle border-0"><div class="card-body text-center py-2"><h5 class="fw-bold mb-0 text-primary">{{ $stats['approved_count'] }}</h5><small class="text-muted">Approved Count</small></div></div></div>
        <div class="col-3"><div class="card bg-warning-subtle border-0"><div class="card-body text-center py-2"><h5 class="fw-bold mb-0 text-warning">{{ $stats['pending_count'] }}</h5><small class="text-muted">Pending Count</small></div></div></div>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="GET" class="row g-2 mb-3">
                <div class="col-md-3"><input type="text" name="search" class="form-control" placeholder="Search..." value="{{ $filters['search'] ?? '' }}"></div>
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="approved" {{ ($filters['status'] ?? '') === 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="pending" {{ ($filters['status'] ?? '') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="cancelled" {{ ($filters['status'] ?? '') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="category_id" class="form-select">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ ($filters['category_id'] ?? '') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2"><input type="date" name="date_from" class="form-control" value="{{ $filters['date_from'] ?? '' }}"></div>
                <div class="col-md-2"><input type="date" name="date_to" class="form-control" value="{{ $filters['date_to'] ?? '' }}"></div>
                <div class="col-md-1"><button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i></button></div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr><th>#</th><th>Category</th><th class="text-end">Amount</th><th>Payee</th><th>Date</th><th>Status</th><th class="text-center">Actions</th></tr>
                    </thead>
                    <tbody>
                        @forelse($expenses as $expense)
                            <tr>
                                <td><a href="{{ route('admin.finance.expenses.show', $expense->id) }}" class="fw-semibold text-decoration-none">{{ $expense->expense_number }}</a></td>
                                <td>{{ $expense->category?->name ?? '—' }}</td>
                                <td class="text-end fw-semibold">{{ number_format($expense->total_amount, 2) }}</td>
                                <td><small>{{ $expense->payee ?: '—' }}</small></td>
                                <td><small>{{ $expense->expense_date?->format('d/m/Y') }}</small></td>
                                <td>
                                    <span class="badge bg-{{ $expense->status === 'approved' ? 'success' : ($expense->status === 'pending' ? 'warning' : 'secondary') }}">
                                        {{ ucfirst($expense->status) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item" href="{{ route('admin.finance.expenses.show', $expense->id) }}"><i class="fas fa-eye me-2"></i>View</a></li>
                                            @if($expense->isEditable())
                                                <li><a class="dropdown-item" href="{{ route('admin.finance.expenses.edit', $expense->id) }}"><i class="fas fa-edit me-2"></i>Edit</a></li>
                                            @endif
                                            @if($expense->isApprovable())
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <form method="POST" action="{{ route('admin.finance.expenses.approve', $expense->id) }}" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="dropdown-item text-success"><i class="fas fa-check-circle me-2"></i>Approve</button>
                                                    </form>
                                                </li>
                                            @endif
                                            @if($expense->isEditable() && $expense->status !== 'cancelled')
                                                <li>
                                                    <form method="POST" action="{{ route('admin.finance.expenses.cancel', $expense->id) }}" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Cancel this expense?')"><i class="fas fa-ban me-2"></i>Cancel</button>
                                                    </form>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center py-5 text-muted"><i class="fas fa-receipt fa-3x mb-3 d-block"></i>No expenses found</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-3">
                <small class="text-muted">Showing {{ $expenses->firstItem() ?? 0 }} to {{ $expenses->lastItem() ?? 0 }} of {{ $expenses->total() }}</small>
                <a href="{{ route('admin.finance.expenses.export.csv', request()->query()) }}" class="btn btn-sm btn-outline-success"><i class="fas fa-file-csv me-1"></i> CSV</a>
            </div>
            <div class="d-flex justify-content-center mt-3">{{ $expenses->withQueryString()->links() }}</div>
        </div>
    </div>
</x-layouts.admin-layout>
