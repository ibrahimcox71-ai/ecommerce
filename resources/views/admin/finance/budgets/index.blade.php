<x-layouts.admin-layout title="Budgets">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div><h4 class="fw-bold mb-1">Budgets</h4><p class="text-muted small mb-0">Track and manage budgets</p></div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.finance.budgets.report') }}" class="btn btn-outline-info"><i class="fas fa-chart-bar me-1"></i> Report</a>
            <a href="{{ route('admin.finance.budgets.create') }}" class="btn btn-primary"><i class="fas fa-plus me-1"></i> Create Budget</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="GET" class="row g-2 mb-3">
                <div class="col-md-4">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="active" {{ ($filters['status'] ?? '') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="completed" {{ ($filters['status'] ?? '') === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ ($filters['status'] ?? '') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="period" class="form-select">
                        <option value="">All Periods</option>
                        @foreach(['monthly','quarterly','semi_annually','annually','custom'] as $p)
                            <option value="{{ $p }}" {{ ($filters['period'] ?? '') === $p ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $p)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-1"><button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i></button></div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr><th>Name</th><th>Period</th><th>Duration</th><th class="text-end">Budget</th><th class="text-end">Spent</th><th class="text-end">Remaining</th><th>Progress</th><th>Status</th><th class="text-center">Actions</th></tr>
                    </thead>
                    <tbody>
                        @forelse($budgets as $budget)
                            @php $pct = $budget->total_budget > 0 ? round($budget->total_spent / $budget->total_budget * 100, 1) : 0; @endphp
                            <tr>
                                <td><a href="{{ route('admin.finance.budgets.show', $budget->id) }}" class="fw-semibold text-decoration-none">{{ $budget->name }}</a></td>
                                <td><span class="badge bg-info">{{ ucfirst(str_replace('_', ' ', $budget->period)) }}</span></td>
                                <td><small>{{ $budget->start_date?->format('d/m/Y') }} - {{ $budget->end_date?->format('d/m/Y') }}</small></td>
                                <td class="text-end fw-semibold">{{ number_format($budget->total_budget, 2) }}</td>
                                <td class="text-end fw-semibold text-danger">{{ number_format($budget->total_spent, 2) }}</td>
                                <td class="text-end fw-semibold {{ $budget->total_remaining < 0 ? 'text-danger' : 'text-success' }}">{{ number_format($budget->total_remaining, 2) }}</td>
                                <td style="min-width:120px">
                                    <div class="progress" style="height:8px">
                                        <div class="progress-bar {{ $pct > 100 ? 'bg-danger' : ($pct > 80 ? 'bg-warning' : 'bg-success') }}" style="width:{{ min($pct, 100) }}%"></div>
                                    </div>
                                    <small class="text-muted">{{ $pct }}%</small>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $budget->status === 'active' ? 'success' : ($budget->status === 'completed' ? 'primary' : 'secondary') }}">
                                        {{ ucfirst($budget->status) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item" href="{{ route('admin.finance.budgets.show', $budget->id) }}"><i class="fas fa-eye me-2"></i>View</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form method="POST" action="{{ route('admin.finance.budgets.destroy', $budget->id) }}" class="d-inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Delete this budget?')"><i class="fas fa-trash me-2"></i>Delete</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="9" class="text-center py-5 text-muted"><i class="fas fa-calculator fa-3x mb-3 d-block"></i>No budgets found</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-3">{{ $budgets->withQueryString()->links() }}</div>
        </div>
    </div>
</x-layouts.admin-layout>
