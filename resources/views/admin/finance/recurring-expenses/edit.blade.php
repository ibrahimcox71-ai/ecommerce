<x-layouts.admin-layout title="Edit Recurring Expense">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div><h4 class="fw-bold mb-1">Edit Recurring Expense</h4></div>
        <a href="{{ route('admin.finance.recurring-expenses.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.finance.recurring-expenses.update', $recurring->id) }}">
                @csrf @method('PUT')
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Category <span class="text-danger">*</span></label>
                        <select name="expense_category_id" class="form-select" required>
                            <option value="">Select</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" @selected(old('expense_category_id', $recurring->expense_category_id) == $cat->id)>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Amount <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="amount" class="form-control" value="{{ old('amount', $recurring->amount) }}" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Interval <span class="text-danger">*</span></label>
                        <select name="interval" class="form-select" required>
                            <option value="">Select</option>
                            <option value="daily" @selected(old('interval', $recurring->interval) == 'daily')>Daily</option>
                            <option value="weekly" @selected(old('interval', $recurring->interval) == 'weekly')>Weekly</option>
                            <option value="bi_weekly" @selected(old('interval', $recurring->interval) == 'bi_weekly')>Bi-Weekly</option>
                            <option value="monthly" @selected(old('interval', $recurring->interval) == 'monthly')>Monthly</option>
                            <option value="quarterly" @selected(old('interval', $recurring->interval) == 'quarterly')>Quarterly</option>
                            <option value="semi_annually" @selected(old('interval', $recurring->interval) == 'semi_annually')>Semi-Annually</option>
                            <option value="annually" @selected(old('interval', $recurring->interval) == 'annually')>Annually</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Account</label>
                        <select name="chart_of_account_id" class="form-select">
                            <option value="">—</option>
                            @foreach($accounts as $acc)
                                <option value="{{ $acc->id }}" @selected(old('chart_of_account_id', $recurring->chart_of_account_id) == $acc->id)>{{ $acc->code }} - {{ $acc->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Payee</label>
                        <input type="text" name="payee" class="form-control" value="{{ old('payee', $recurring->payee) }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Start Date <span class="text-danger">*</span></label>
                        <input type="date" name="start_date" class="form-control" value="{{ old('start_date', $recurring->start_date?->format('Y-m-d')) }}" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">End Date</label>
                        <input type="date" name="end_date" class="form-control" value="{{ old('end_date', $recurring->end_date?->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="active" @selected(old('status', $recurring->status) == 'active')>Active</option>
                            <option value="paused" @selected(old('status', $recurring->status) == 'paused')>Paused</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="2">{{ old('description', $recurring->description) }}</textarea>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Update</button>
                    <a href="{{ route('admin.finance.recurring-expenses.index') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.admin-layout>
