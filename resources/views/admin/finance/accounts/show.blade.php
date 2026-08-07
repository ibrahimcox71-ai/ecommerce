<x-layouts.admin-layout title="Account Details">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">{{ $account->code }} - {{ $account->name }}</h4>
            <p class="text-muted small mb-0">
                <span class="badge bg-info">{{ ucwords(str_replace('_', ' ', $account->type)) }}</span>
                <span class="badge bg-{{ $account->is_active ? 'success' : 'secondary' }}">{{ $account->is_active ? 'Active' : 'Inactive' }}</span>
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.finance.accounts.edit', $account->id) }}" class="btn btn-outline-primary"><i class="fas fa-edit me-1"></i> Edit</a>
            <a href="{{ route('admin.finance.accounts.index') }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i> Back</a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header bg-transparent"><h6 class="fw-bold mb-0">Account Info</h6></div>
                <div class="card-body">
                    <div class="mb-3"><label class="text-muted small text-uppercase">Code</label><p class="fw-semibold mb-0">{{ $account->code }}</p></div>
                    <div class="mb-3"><label class="text-muted small text-uppercase">Type</label><p class="fw-semibold mb-0">{{ ucwords(str_replace('_', ' ', $account->type)) }}</p></div>
                    <div class="mb-3"><label class="text-muted small text-uppercase">Normal Balance</label><p class="fw-semibold mb-0">{{ ucfirst($account->normal_balance) }}</p></div>
                    <div class="mb-3"><label class="text-muted small text-uppercase">Parent</label><p class="fw-semibold mb-0">{{ $account->parent?->name ?? '—' }}</p></div>
                    @if($account->description)<div class="mb-3"><label class="text-muted small text-uppercase">Description</label><p class="mb-0">{{ $account->description }}</p></div>@endif
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header bg-transparent"><h6 class="fw-bold mb-0">Balance Summary</h6></div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="card bg-light"><div class="card-body text-center py-3"><small class="text-muted">Opening Balance</small><h5 class="mb-0 fw-bold">{{ number_format($account->opening_balance, 2) }}</h5></div></div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-primary-subtle"><div class="card-body text-center py-3"><small class="text-muted">Current Balance</small><h5 class="mb-0 fw-bold text-primary">{{ number_format($account->current_balance, 2) }}</h5></div></div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-info-subtle"><div class="card-body text-center py-3"><small class="text-muted">Total Balance</small><h5 class="mb-0 fw-bold text-info">{{ number_format($account->opening_balance + $account->current_balance, 2) }}</h5></div></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-transparent"><h6 class="fw-bold mb-0">Recent Journal Entries</h6></div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light"><tr><th>Entry #</th><th>Date</th><th class="text-end">Debit</th><th class="text-end">Credit</th><th>Description</th></tr></thead>
                            <tbody>
                                @forelse($account->journalEntryItems as $item)
                                    <tr>
                                        <td><a href="{{ route('admin.finance.journal-entries.show', $item->journal_entry_id) }}" class="text-decoration-none">{{ $item->journalEntry?->entry_number }}</a></td>
                                        <td><small>{{ $item->journalEntry?->entry_date?->format('d/m/Y') }}</small></td>
                                        <td class="text-end">{{ $item->debit > 0 ? number_format($item->debit, 2) : '—' }}</td>
                                        <td class="text-end">{{ $item->credit > 0 ? number_format($item->credit, 2) : '—' }}</td>
                                        <td><small>{{ $item->description ?: '—' }}</small></td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="text-center py-4 text-muted">No journal entries for this account</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin-layout>
