<x-layouts.admin-layout title="Trial Balance">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div><h4 class="fw-bold mb-1">Trial Balance</h4><p class="text-muted small mb-0">All account balances with debits and credits</p></div>
        <a href="{{ route('admin.finance.reports.index') }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i> Back</a>
    </div>

    <form method="GET" class="row g-2 mb-4">
        <div class="col-md-4"><input type="date" name="date_from" class="form-control" value="{{ $filters['date_from'] ?? '' }}"></div>
        <div class="col-md-4"><input type="date" name="date_to" class="form-control" value="{{ $filters['date_to'] ?? '' }}"></div>
        <div class="col-md-2"><button type="submit" class="btn btn-primary w-100"><i class="fas fa-filter me-1"></i> Filter</button></div>
        <div class="col-md-2"><a href="{{ route('admin.finance.reports.trial-balance') }}" class="btn btn-outline-secondary w-100">Reset</a></div>
    </form>

    <div class="card"><div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr><th>Code</th><th>Account</th><th>Type</th><th class="text-end">Opening</th><th class="text-end">Movement</th><th class="text-end">Closing</th></tr>
                </thead>
                <tbody>
                    @php
                        $totalOpening = 0; $totalClosing = 0;
                    @endphp
                    @forelse($accounts as $acc)
                        @php
                            $totalOpening += $acc['opening_balance'];
                            $totalClosing += $acc['closing_balance'];
                        @endphp
                        <tr>
                            <td>{{ $acc['code'] }}</td>
                            <td class="fw-semibold">{{ $acc['name'] }}</td>
                            <td><span class="badge bg-info">{{ ucfirst(str_replace('_', ' ', $acc['type'])) }}</span></td>
                            <td class="text-end">{{ number_format($acc['opening_balance'], 2) }}</td>
                            <td class="text-end {{ $acc['movement'] >= 0 ? 'text-success' : 'text-danger' }}">{{ number_format($acc['movement'], 2) }}</td>
                            <td class="text-end fw-semibold">{{ number_format($acc['closing_balance'], 2) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center py-4 text-muted">No accounts found</td></tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr class="table-active fw-bold">
                        <td colspan="3" class="text-end">Totals:</td>
                        <td class="text-end">{{ number_format($totalOpening, 2) }}</td>
                        <td></td>
                        <td class="text-end">{{ number_format($totalClosing, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div></div>
</x-layouts.admin-layout>
