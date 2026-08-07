<x-layouts.admin-layout title="Create Recurring Expense">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div><h4 class="fw-bold mb-1">Create Recurring Expense</h4><p class="text-muted small mb-0">Set up a recurring expense</p></div>
        <a href="{{ route('admin.finance.recurring-expenses.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.finance.recurring-expenses.store') }}">
                @csrf
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Category <span class="text-danger">*</span></label>
                        <select name="expense_category_id" class="form-select" required>
                            <option value="">Select</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" @selected(old('expense_category_id') == $cat->id)>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Amount <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="amount" class="form-control" value="{{ old('amount') }}" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Interval <span class="text-danger">*</span></label>
                        <select name="interval" class="form-select" required>
                            <option value="">Select</option>
                            <option value="daily" @selected(old('interval') == 'daily')>Daily</option>
                            <option value="weekly" @selected(old('interval') == 'weekly')>Weekly</option>
                            <option value="bi_weekly" @selected(old('interval') == 'bi_weekly')>Bi-Weekly</option>
                            <option value="monthly" @selected(old('interval') == 'monthly')>Monthly</option>
                            <option value="quarterly" @selected(old('interval') == 'quarterly')>Quarterly</option>
                            <option value="semi_annually" @selected(old('interval') == 'semi_annually')>Semi-Annually</option>
                            <option value="annually" @selected(old('interval') == 'annually')>Annually</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Account</label>
                        <select name="chart_of_account_id" class="form-select">
                            <option value="">—</option>
                            @foreach($accounts as $acc)
                                <option value="{{ $acc->id }}" @selected(old('chart_of_account_id') == $acc->id)>{{ $acc->code }} - {{ $acc->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Payee</label>
                        <input type="text" name="payee" class="form-control" value="{{ old('payee') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Start Date <span class="text-danger">*</span></label>
                        <input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">End Date</label>
                        <input type="date" name="end_date" class="form-control" value="{{ old('end_date') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Max Occurrences</label>
                        <input type="number" min="1" name="max_occurrences" class="form-control" value="{{ old('max_occurrences') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Payment Method</label>
                        <input type="text" name="payment_method" class="form-control" value="{{ old('payment_method') }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="2">{{ old('description') }}</textarea>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Create</button>
                    <a href="{{ route('admin.finance.recurring-expenses.index') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.admin-layout>
