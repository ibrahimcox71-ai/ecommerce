<x-layouts.admin-layout title="Budget Details">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">{{ $budget->name }}</h4>
            <p class="text-muted small mb-0">
                <span class="badge bg-info">{{ ucfirst(str_replace('_', ' ', $budget->period)) }}</span>
                <span class="badge bg-{{ $budget->status === 'active' ? 'success' : ($budget->status === 'completed' ? 'primary' : 'secondary') }} ms-1">{{ ucfirst($budget->status) }}</span>
            </p>
        </div>
        <a href="{{ route('admin.finance.budgets.index') }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i> Back</a>
    </div>

    @php $overallPct = $budget->total_budget > 0 ? round($budget->total_spent / $budget->total_budget * 100, 1) : 0; @endphp

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card bg-light"><div class="card-body text-center py-2"><small class="text-muted">Period</small><h5 class="mb-0">{{ $budget->start_date?->format('M d') }} - {{ $budget->end_date?->format('M d, Y') }}</h5></div></div>
        </div>
        <div class="col-md-3">
            <div class="card bg-primary-subtle"><div class="card-body text-center py-2"><small class="text-muted">Budget</small><h5 class="mb-0 text-primary">{{ number_format($budget->total_budget, 2) }}</h5></div></div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger-subtle"><div class="card-body text-center py-2"><small class="text-muted">Spent</small><h5 class="mb-0 text-danger">{{ number_format($budget->total_spent, 2) }}</h5></div></div>
        </div>
        <div class="col-md-3">
            <div class="card {{ $budget->total_remaining >= 0 ? 'bg-success-subtle' : 'bg-danger-subtle' }}"><div class="card-body text-center py-2"><small class="text-muted">Remaining</small><h5 class="mb-0 {{ $budget->total_remaining >= 0 ? 'text-success' : 'text-danger' }}">{{ number_format($budget->total_remaining, 2) }}</h5></div></div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between mb-1"><span class="fw-semibold">Overall Progress</span><span>{{ $overallPct }}%</span></div>
            <div class="progress" style="height:20px">
                <div class="progress-bar {{ $overallPct > 100 ? 'bg-danger' : ($overallPct > 80 ? 'bg-warning' : 'bg-success') }}" style="width:{{ min($overallPct, 100) }}%">
                    {{ $overallPct }}%
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-transparent"><h6 class="fw-bold mb-0">Budget Items</h6></div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr><th>Category</th><th class="text-end">Budgeted</th><th class="text-end">Spent</th><th class="text-end">Remaining</th><th>Usage</th><th>Status</th></tr>
                    </thead>
                    <tbody>
                        @foreach($budget->items as $item)
                            @php $pct = $item->getUsagePercentage(); @endphp
                            <tr>
                                <td class="fw-semibold">{{ $item->category_name }}</td>
                                <td class="text-end">{{ number_format($item->budgeted_amount, 2) }}</td>
                                <td class="text-end text-danger">{{ number_format($item->spent_amount, 2) }}</td>
                                <td class="text-end fw-bold {{ $item->remaining_amount < 0 ? 'text-danger' : 'text-success' }}">{{ number_format($item->remaining_amount, 2) }}</td>
                                <td style="min-width:120px">
                                    <div class="progress" style="height:8px">
                                        <div class="progress-bar {{ $pct > 100 ? 'bg-danger' : ($pct > 80 ? 'bg-warning' : 'bg-success') }}" style="width:{{ min($pct, 100) }}%"></div>
                                    </div>
                                    <small class="text-muted">{{ $pct }}%</small>
                                </td>
                                <td>
                                    @if($item->isOverBudget())
                                        <span class="badge bg-danger">Over Budget</span>
                                    @else
                                        <span class="badge bg-success">On Track</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.admin-layout>
