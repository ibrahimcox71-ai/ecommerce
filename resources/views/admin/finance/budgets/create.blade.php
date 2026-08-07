<x-layouts.admin-layout title="Create Budget">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div><h4 class="fw-bold mb-1">Create Budget</h4><p class="text-muted small mb-0">Define a new budget and allocate funds</p></div>
        <a href="{{ route('admin.finance.budgets.index') }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i> Back</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.finance.budgets.store') }}">
                @csrf
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Period <span class="text-danger">*</span></label>
                        <select name="period" class="form-select @error('period') is-invalid @enderror" required>
                            @foreach(['monthly','quarterly','semi_annually','annually','custom'] as $p)
                                <option value="{{ $p }}" {{ old('period') === $p ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $p)) }}</option>
                            @endforeach
                        </select>
                        @error('period')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Start Date</label>
                        <input type="date" name="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date', now()->format('Y-m-d')) }}" required>
                        @error('start_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">End Date</label>
                        <input type="date" name="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date', now()->addMonth()->format('Y-m-d')) }}" required>
                        @error('end_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" rows="2">{{ old('notes') }}</textarea>
                        @error('notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <h6 class="fw-bold mb-3">Budget Items</h6>
                @error('items')<div class="alert alert-danger py-2">{{ $message }}</div>@enderror
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr><th>Category</th><th class="text-end">Budgeted Amount</th><th>Notes</th><th style="width:50px"></th></tr>
                        </thead>
                        <tbody id="budgetItems">
                            <tr>
                                <td>
                                    <select name="items[0][expense_category_id]" class="form-select form-select-sm">
                                        <option value="">— Select Category —</option>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                    <input type="text" name="items[0][category_name]" class="form-control form-control-sm mt-1" placeholder="Or type custom name">
                                </td>
                                <td><input type="number" name="items[0][budgeted_amount]" class="form-control form-control-sm text-end budget-amount" step="0.01" min="0" value="0" onchange="updateTotal()"></td>
                                <td><input type="text" name="items[0][notes]" class="form-control form-control-sm"></td>
                                <td class="text-center"><button type="button" class="btn btn-sm btn-outline-danger" onclick="removeBudgetItem(this)" disabled><i class="fas fa-times"></i></button></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr class="table-active">
                                <td class="text-end fw-bold">Total Budget:</td>
                                <td class="text-end fw-bold" id="totalBudget">0.00</td>
                                <td colspan="2"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <button type="button" class="btn btn-sm btn-success mb-3" onclick="addBudgetItem()"><i class="fas fa-plus me-1"></i> Add Item</button>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Create Budget</button>
                    <a href="{{ route('admin.finance.budgets.index') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
    let itemIndex = 1;
    const catOptions = `@foreach($categories as $cat)<option value="{{ $cat->id }}">{{ $cat->name }}</option>@endforeach`;

    function addBudgetItem() {
        const html = `<tr>
            <td>
                <select name="items[${itemIndex}][expense_category_id]" class="form-select form-select-sm"><option value="">— Select Category —</option>${catOptions}</select>
                <input type="text" name="items[${itemIndex}][category_name]" class="form-control form-control-sm mt-1" placeholder="Or type custom name">
            </td>
            <td><input type="number" name="items[${itemIndex}][budgeted_amount]" class="form-control form-control-sm text-end budget-amount" step="0.01" min="0" value="0" onchange="updateTotal()"></td>
            <td><input type="text" name="items[${itemIndex}][notes]" class="form-control form-control-sm"></td>
            <td class="text-center"><button type="button" class="btn btn-sm btn-outline-danger" onclick="removeBudgetItem(this)"><i class="fas fa-times"></i></button></td>
        </tr>`;
        document.getElementById('budgetItems').insertAdjacentHTML('beforeend', html);
        itemIndex++;
    }

    function removeBudgetItem(btn) {
        const row = btn.closest('tr');
        if (document.querySelectorAll('#budgetItems tr').length <= 1) return;
        row.remove();
        updateTotal();
    }

    function updateTotal() {
        let total = 0;
        document.querySelectorAll('.budget-amount').forEach(inp => total += parseFloat(inp.value) || 0);
        document.getElementById('totalBudget').textContent = total.toFixed(2);
    }
    </script>
    @endpush
</x-layouts.admin-layout>
