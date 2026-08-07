<x-layouts.admin-layout title="Create Journal Entry">
    @push('styles')
    <style>
        .line-item td .form-control, .line-item td .form-select { font-size: 0.875rem; }
        .line-item td { vertical-align: middle; }
    </style>
    @endpush

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div><h4 class="fw-bold mb-1">Create Journal Entry</h4><p class="text-muted small mb-0">Create a new balanced journal entry</p></div>
        <a href="{{ route('admin.finance.journal-entries.index') }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i> Back</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.finance.journal-entries.store') }}" id="journalForm">
                @csrf
                <div class="row g-3 mb-4">
                    <div class="col-md-3">
                        <label class="form-label">Entry Date <span class="text-danger">*</span></label>
                        <input type="date" name="entry_date" class="form-control @error('entry_date') is-invalid @enderror" value="{{ old('entry_date', now()->format('Y-m-d')) }}" required>
                        @error('entry_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Type <span class="text-danger">*</span></label>
                        <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                            @foreach(['standard','adjusting','closing','reversing','opening'] as $type)
                                <option value="{{ $type }}" {{ old('type') === $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                            @endforeach
                        </select>
                        @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Finance Period</label>
                        <select name="finance_period_id" class="form-select">
                            <option value="">—</option>
                            @foreach($periods as $period)
                                <option value="{{ $period->id }}" {{ old('finance_period_id') == $period->id ? 'selected' : '' }}>{{ $period->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">&nbsp;</label>
                        <div class="form-check pt-2">
                            <input type="checkbox" name="is_posted" class="form-check-input" value="1" id="isPosted" {{ old('is_posted', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="isPosted">Post immediately</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Description</label>
                        <input type="text" name="description" class="form-control @error('description') is-invalid @enderror" value="{{ old('description') }}" placeholder="Brief description of this entry">
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" rows="2">{{ old('notes') }}</textarea>
                        @error('notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold mb-0">Journal Lines</h6>
                    <button type="button" class="btn btn-sm btn-success" onclick="addLine()"><i class="fas fa-plus me-1"></i> Add Line</button>
                </div>
                @error('items')<div class="alert alert-danger py-2">{{ $message }}</div>@enderror

                <div class="table-responsive">
                    <table class="table table-bordered" id="linesTable">
                        <thead class="table-light">
                            <tr><th style="width:5%">#</th><th style="width:35%">Account</th><th>Description</th><th style="width:15%">Debit</th><th style="width:15%">Credit</th><th style="width:5%"></th></tr>
                        </thead>
                        <tbody id="linesBody">
                            <tr class="line-item">
                                <td class="text-center">1</td>
                                <td>
                                    <select name="items[0][chart_of_account_id]" class="form-select form-select-sm" required>
                                        <option value="">Select Account</option>
                                        @foreach($accounts as $account)
                                            <option value="{{ $account->id }}">{{ $account->code }} - {{ $account->name }} ({{ $account->normal_balance }})</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><input type="text" name="items[0][description]" class="form-control form-control-sm" placeholder="Optional"></td>
                                <td><input type="number" name="items[0][debit]" class="form-control form-control-sm debit-input" step="0.01" min="0" value="0" onchange="calculateTotals()"></td>
                                <td><input type="number" name="items[0][credit]" class="form-control form-control-sm credit-input" step="0.01" min="0" value="0" onchange="calculateTotals()"></td>
                                <td class="text-center"><button type="button" class="btn btn-sm btn-outline-danger" onclick="removeLine(this)" disabled><i class="fas fa-times"></i></button></td>
                            </tr>
                            <tr class="line-item">
                                <td class="text-center">2</td>
                                <td>
                                    <select name="items[1][chart_of_account_id]" class="form-select form-select-sm" required>
                                        <option value="">Select Account</option>
                                        @foreach($accounts as $account)
                                            <option value="{{ $account->id }}">{{ $account->code }} - {{ $account->name }} ({{ $account->normal_balance }})</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><input type="text" name="items[1][description]" class="form-control form-control-sm" placeholder="Optional"></td>
                                <td><input type="number" name="items[1][debit]" class="form-control form-control-sm debit-input" step="0.01" min="0" value="0" onchange="calculateTotals()"></td>
                                <td><input type="number" name="items[1][credit]" class="form-control form-control-sm credit-input" step="0.01" min="0" value="0" onchange="calculateTotals()"></td>
                                <td class="text-center"><button type="button" class="btn btn-sm btn-outline-danger" onclick="removeLine(this)"><i class="fas fa-times"></i></button></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr class="table-active fw-bold">
                                <td colspan="3" class="text-end">Totals:</td>
                                <td id="totalDebit" class="text-end">0.00</td>
                                <td id="totalCredit" class="text-end">0.00</td>
                                <td></td>
                            </tr>
                            <tr id="balanceRow" class="d-none table-warning">
                                <td colspan="6" id="balanceMessage" class="text-center text-danger fw-bold"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Create Entry</button>
                    <a href="{{ route('admin.finance.journal-entries.index') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
    let lineIndex = 2;
    const accountOptions = `@json($accounts->map(fn($a) => ['id' => $a->id, 'code' => e($a->code), 'name' => e($a->name), 'normal_balance' => e($a->normal_balance)])->values())`.map(a => `<option value="${a.id}">${a.code} - ${a.name} (${a.normal_balance})</option>`).join('');

    function addLine() {
        const html = `<tr class="line-item">
            <td class="text-center">${lineIndex + 1}</td>
            <td><select name="items[${lineIndex}][chart_of_account_id]" class="form-select form-select-sm" required><option value="">Select Account</option>${accountOptions}</select></td>
            <td><input type="text" name="items[${lineIndex}][description]" class="form-control form-control-sm" placeholder="Optional"></td>
            <td><input type="number" name="items[${lineIndex}][debit]" class="form-control form-control-sm debit-input" step="0.01" min="0" value="0" onchange="calculateTotals()"></td>
            <td><input type="number" name="items[${lineIndex}][credit]" class="form-control form-control-sm credit-input" step="0.01" min="0" value="0" onchange="calculateTotals()"></td>
            <td class="text-center"><button type="button" class="btn btn-sm btn-outline-danger" onclick="removeLine(this)"><i class="fas fa-times"></i></button></td>
        </tr>`;
        document.getElementById('linesBody').insertAdjacentHTML('beforeend', html);
        lineIndex++;
        calculateTotals();
    }

    function removeLine(btn) {
        const row = btn.closest('tr');
        if (document.querySelectorAll('.line-item').length <= 2) return;
        row.remove();
        updateLineNumbers();
        calculateTotals();
    }

    function updateLineNumbers() {
        document.querySelectorAll('.line-item').forEach((row, i) => {
            row.querySelector('td:first-child').textContent = i + 1;
        });
    }

    function calculateTotals() {
        let totalDebit = 0, totalCredit = 0;
        document.querySelectorAll('.debit-input').forEach(inp => totalDebit += parseFloat(inp.value) || 0);
        document.querySelectorAll('.credit-input').forEach(inp => totalCredit += parseFloat(inp.value) || 0);
        document.getElementById('totalDebit').textContent = totalDebit.toFixed(2);
        document.getElementById('totalCredit').textContent = totalCredit.toFixed(2);

        const balanceRow = document.getElementById('balanceRow');
        const balanceMsg = document.getElementById('balanceMessage');
        const diff = Math.abs(totalDebit - totalCredit);
        if (diff > 0.01) {
            balanceRow.classList.remove('d-none');
            balanceMsg.textContent = 'Not balanced! Difference: ' + diff.toFixed(2);
        } else {
            balanceRow.classList.add('d-none');
        }
    }

    document.addEventListener('DOMContentLoaded', calculateTotals);

    document.getElementById('journalForm').addEventListener('submit', function(e) {
        let totalDebit = 0, totalCredit = 0;
        document.querySelectorAll('.debit-input').forEach(inp => totalDebit += parseFloat(inp.value) || 0);
        document.querySelectorAll('.credit-input').forEach(inp => totalCredit += parseFloat(inp.value) || 0);
        if (Math.abs(totalDebit - totalCredit) > 0.01) {
            e.preventDefault();
            alert('Journal entry must be balanced. Total debits must equal total credits.');
        }
    });
    </script>
    @endpush
</x-layouts.admin-layout>
