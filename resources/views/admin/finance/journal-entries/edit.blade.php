<x-layouts.admin-layout title="Edit Journal Entry">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div><h4 class="fw-bold mb-1">Edit Journal Entry</h4><p class="text-muted small mb-0">{{ $entry->entry_number }}</p></div>
        <a href="{{ route('admin.finance.journal-entries.show', $entry->id) }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i> Back</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.finance.journal-entries.update', $entry->id) }}">
                @csrf @method('PUT')
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label class="form-label">Entry Date <span class="text-danger">*</span></label>
                        <input type="date" name="entry_date" class="form-control" value="{{ old('entry_date', $entry->entry_date?->format('Y-m-d')) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Type <span class="text-danger">*</span></label>
                        <select name="type" class="form-select" required>
                            @foreach(['standard','adjusting','closing','reversing','opening'] as $type)
                                <option value="{{ $type }}" {{ old('type', $entry->type) === $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Finance Period</label>
                        <select name="finance_period_id" class="form-select">
                            <option value="">—</option>
                            @foreach($periods as $period)
                                <option value="{{ $period->id }}" {{ old('finance_period_id', $entry->finance_period_id) == $period->id ? 'selected' : '' }}>{{ $period->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Description</label>
                        <input type="text" name="description" class="form-control" value="{{ old('description', $entry->description) }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-control" rows="2">{{ old('notes', $entry->notes) }}</textarea>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light"><tr><th>Account</th><th>Description</th><th class="text-end">Debit</th><th class="text-end">Credit</th></tr></thead>
                        <tbody>
                            @foreach($entry->items as $i => $item)
                                <tr>
                                    <td>
                                        <select name="items[{{ $i }}][chart_of_account_id]" class="form-select form-select-sm" required>
                                            <option value="">Select Account</option>
                                            @foreach($accounts as $account)
                                                <option value="{{ $account->id }}" {{ $item->chart_of_account_id === $account->id ? 'selected' : '' }}>{{ $account->code }} - {{ $account->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><input type="text" name="items[{{ $i }}][description]" class="form-control form-control-sm" value="{{ $item->description }}"></td>
                                    <td><input type="number" name="items[{{ $i }}][debit]" class="form-control form-control-sm" step="0.01" min="0" value="{{ $item->debit }}"></td>
                                    <td><input type="number" name="items[{{ $i }}][credit]" class="form-control form-control-sm" step="0.01" min="0" value="{{ $item->credit }}"></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Update Entry</button>
            </form>
        </div>
    </div>
</x-layouts.admin-layout>
