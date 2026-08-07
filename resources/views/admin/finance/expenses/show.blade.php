<x-layouts.admin-layout title="Expense Details">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">{{ $expense->expense_number }}</h4>
            <p class="text-muted small mb-0">
                <span class="badge bg-{{ $expense->status === 'approved' ? 'success' : ($expense->status === 'pending' ? 'warning' : 'secondary') }}">{{ ucfirst($expense->status) }}</span>
            </p>
        </div>
        <div class="d-flex gap-2">
            @if($expense->isApprovable())
                <form method="POST" action="{{ route('admin.finance.expenses.approve', $expense->id) }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success" onclick="return confirm('Approve this expense?')"><i class="fas fa-check-circle me-1"></i> Approve</button>
                </form>
            @endif
            @if($expense->isEditable())
                <a href="{{ route('admin.finance.expenses.edit', $expense->id) }}" class="btn btn-outline-primary"><i class="fas fa-edit me-1"></i> Edit</a>
            @endif
            <a href="{{ route('admin.finance.expenses.index') }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i> Back</a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header bg-transparent"><h6 class="fw-bold mb-0">Expense Details</h6></div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4"><label class="text-muted small text-uppercase">Category</label><p class="fw-semibold mb-0">{{ $expense->category?->name ?? '—' }}</p></div>
                        <div class="col-md-4"><label class="text-muted small text-uppercase">Amount</label><p class="fw-bold fs-5 mb-0 text-danger">{{ number_format($expense->amount, 2) }}</p></div>
                        <div class="col-md-4"><label class="text-muted small text-uppercase">Total (incl. Tax)</label><p class="fw-bold fs-5 mb-0 text-danger">{{ number_format($expense->total_amount, 2) }}</p></div>
                        <div class="col-md-4"><label class="text-muted small text-uppercase">Date</label><p class="mb-0">{{ $expense->expense_date?->format('d M, Y') }}</p></div>
                        <div class="col-md-4"><label class="text-muted small text-uppercase">Payee</label><p class="mb-0">{{ $expense->payee ?: '—' }}</p></div>
                        <div class="col-md-4"><label class="text-muted small text-uppercase">Payment Method</label><p class="mb-0">{{ $expense->payment_method ?: '—' }}</p></div>
                        @if($expense->reference_number)<div class="col-md-4"><label class="text-muted small text-uppercase">Reference</label><p class="mb-0">{{ $expense->reference_number }}</p></div>@endif
                        @if($expense->chartOfAccount)<div class="col-md-4"><label class="text-muted small text-uppercase">Account</label><p class="mb-0">{{ $expense->chartOfAccount->name }}</p></div>@endif
                        @if($expense->description)<div class="col-12"><label class="text-muted small text-uppercase">Description</label><p class="mb-0">{{ $expense->description }}</p></div>@endif
                        @if($expense->notes)<div class="col-12"><label class="text-muted small text-uppercase">Notes</label><p class="mb-0">{{ $expense->notes }}</p></div>@endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header bg-transparent"><h6 class="fw-bold mb-0">Record Info</h6></div>
                <div class="card-body">
                    <div class="mb-3"><label class="text-muted small text-uppercase">Created By</label><p class="mb-0">{{ $expense->creator?->name ?? '—' }}</p></div>
                    <div class="mb-3"><label class="text-muted small text-uppercase">Created At</label><p class="mb-0">{{ $expense->created_at?->format('d M Y, h:i A') }}</p></div>
                    @if($expense->approved_at)
                    <div class="mb-3"><label class="text-muted small text-uppercase">Approved By</label><p class="mb-0">{{ $expense->approver?->name ?? '—' }}</p></div>
                    <div class="mb-3"><label class="text-muted small text-uppercase">Approved At</label><p class="mb-0">{{ $expense->approved_at?->format('d M Y, h:i A') }}</p></div>
                    @endif
                    @if($expense->receipt)
                    <div class="mb-3">
                        <label class="text-muted small text-uppercase">Receipt</label>
                        <p class="mb-0"><a href="{{ asset('storage/' . $expense->receipt) }}" target="_blank" class="btn btn-sm btn-outline-primary"><i class="fas fa-file me-1"></i> View Receipt</a></p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin-layout>
