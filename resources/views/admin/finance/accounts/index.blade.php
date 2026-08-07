<x-layouts.admin-layout title="Chart of Accounts">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Chart of Accounts</h4>
            <p class="text-muted small mb-0">Manage your accounting chart of accounts</p>
        </div>
        <a href="{{ route('admin.finance.accounts.create') }}" class="btn btn-primary"><i class="fas fa-plus me-1"></i> Create Account</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="GET" class="row g-2 mb-3">
                <div class="col-md-4"><input type="text" name="search" class="form-control" placeholder="Search by name or code..." value="{{ $filters['search'] ?? '' }}"></div>
                <div class="col-md-3">
                    <select name="type" class="form-select">
                        <option value="">All Types</option>
                        @foreach(['asset','liability','equity','revenue','expense','contra_asset','contra_liability','contra_equity','contra_revenue','contra_expense'] as $type)
                            <option value="{{ $type }}" {{ ($filters['type'] ?? '') === $type ? 'selected' : '' }}>{{ ucwords(str_replace('_', ' ', $type)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="is_active" class="form-select">
                        <option value="">All Status</option>
                        <option value="1" {{ ($filters['is_active'] ?? '') === '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ ($filters['is_active'] ?? '') === '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-md-1"><button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i></button></div>
                <div class="col-md-2"><a href="{{ route('admin.finance.accounts.index') }}" class="btn btn-outline-secondary w-100">Reset</a></div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr><th>Code</th><th>Name</th><th>Type</th><th>Normal</th><th class="text-end">Balance</th><th>Status</th><th class="text-center">Actions</th></tr>
                    </thead>
                    <tbody>
                        @forelse($accounts as $account)
                            <tr>
                                <td><span class="fw-semibold">{{ $account->code }}</span></td>
                                <td>
                                    <a href="{{ route('admin.finance.accounts.show', $account->id) }}" class="text-decoration-none fw-semibold">
                                        {{ $account->name }}
                                    </a>
                                    @if($account->parent)<br><small class="text-muted">{{ $account->parent->name }}</small>@endif
                                </td>
                                <td><span class="badge bg-info">{{ ucwords(str_replace('_', ' ', $account->type)) }}</span></td>
                                <td><small>{{ ucfirst($account->normal_balance) }}</small></td>
                                <td class="text-end fw-semibold">{{ number_format($account->current_balance, 2) }}</td>
                                <td>
                                    <span class="badge bg-{{ $account->is_active ? 'success' : 'secondary' }}">
                                        {{ $account->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item" href="{{ route('admin.finance.accounts.show', $account->id) }}"><i class="fas fa-eye me-2"></i>View</a></li>
                                            <li><a class="dropdown-item" href="{{ route('admin.finance.accounts.edit', $account->id) }}"><i class="fas fa-edit me-2"></i>Edit</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form method="POST" action="{{ route('admin.finance.accounts.toggle-status', $account->id) }}" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item">{{ $account->is_active ? 'Deactivate' : 'Activate' }}</button>
                                                </form>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form method="POST" action="{{ route('admin.finance.accounts.destroy', $account->id) }}" class="d-inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Delete this account?')"><i class="fas fa-trash me-2"></i>Delete</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center py-5 text-muted"><i class="fas fa-book fa-3x mb-3 d-block"></i>No accounts found</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-3">{{ $accounts->withQueryString()->links() }}</div>
        </div>
    </div>
</x-layouts.admin-layout>
