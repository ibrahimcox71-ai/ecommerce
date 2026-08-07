<x-layouts.admin-layout title="Budget vs Actual Report">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div><h4 class="fw-bold mb-1">Budget vs Actual Report</h4></div>
        <div>
            <select id="budgetSelect" class="form-select form-select-sm d-inline-block w-auto" onchange="window.location.href='?budget_id='+this.value">
                <option value="">Select Budget</option>
                @foreach($budgets as $b)
                    <option value="{{ $b->id }}" @selected(($data['budget'] ?? null)?->id == $b->id)>{{ $b->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    @if($data['budget'] ?? null)
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card bg-primary-subtle border-0">
                    <div class="card-body text-center py-3">
                        <h5 class="fw-bold text-primary mb-1">{{ number_format($data['total_budgeted'], 2) }}</h5>
                        <small class="text-muted">Budgeted</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning-subtle border-0">
                    <div class="card-body text-center py-3">
                        <h5 class="fw-bold text-warning mb-1">{{ number_format($data['total_spent'], 2) }}</h5>
                        <small class="text-muted">Actual Spent</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-{{ $data['variance'] >= 0 ? 'success' : 'danger' }}-subtle border-0">
                    <div class="card-body text-center py-3">
                        <h5 class="fw-bold text-{{ $data['variance'] >= 0 ? 'success' : 'danger' }} mb-1">{{ number_format(abs($data['variance']), 2) }}</h5>
                        <small class="text-muted">{{ $data['variance'] >= 0 ? 'Under Budget' : 'Over Budget' }}</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info-subtle border-0">
                    <div class="card-body text-center py-3">
                        <h5 class="fw-bold text-info mb-1">{{ number_format($data['utilization_percentage'], 1) }}%</h5>
                        <small class="text-muted">Utilization</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Category</th>
                                <th class="text-end">Budgeted</th>
                                <th class="text-end">Actual</th>
                                <th class="text-end">Variance</th>
                                <th class="text-end">Utilization</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['items'] as $item)
                                <tr>
                                    <td>{{ $item['name'] }}</td>
                                    <td class="text-end">{{ number_format($item['budgeted'], 2) }}</td>
                                    <td class="text-end">{{ number_format($item['actual'], 2) }}</td>
                                    <td class="text-end text-{{ $item['variance'] >= 0 ? 'success' : 'danger' }}">{{ number_format($item['variance'], 2) }}</td>
                                    <td class="text-end">{{ number_format($item['utilization'], 1) }}%</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-5">
            <i class="bi bi-pie-chart" style="font-size: 3rem; color: var(--bs-gray-400);"></i>
            <p class="text-muted mt-3">Select a budget to view the report.</p>
        </div>
    @endif
</x-layouts.admin-layout>
