<x-layouts.admin-layout title="Journal Entry {{ $entry->entry_number }}">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">{{ $entry->entry_number }}</h4>
            <p class="text-muted small mb-0">
                <span class="badge bg-{{ $entry->type === 'standard' ? 'primary' : ($entry->type === 'adjusting' ? 'warning' : ($entry->type === 'closing' ? 'danger' : ($entry->type === 'reversing' ? 'info' : 'secondary'))) }}">{{ ucfirst($entry->type) }}</span>
                @if($entry->is_posted)<span class="badge bg-success ms-1">Posted</span>@else<span class="badge bg-warning text-dark ms-1">Draft</span>@endif
            </p>
        </div>
        <div class="d-flex gap-2">
            @if(!$entry->is_posted)
                <a href="{{ route('admin.finance.journal-entries.edit', $entry->id) }}" class="btn btn-outline-primary"><i class="fas fa-edit me-1"></i> Edit</a>
                <form method="POST" action="{{ route('admin.finance.journal-entries.post', $entry->id) }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success" onclick="return confirm('Post this entry?')"><i class="fas fa-check-circle me-1"></i> Post</button>
                </form>
            @else
                <form method="POST" action="{{ route('admin.finance.journal-entries.reverse', $entry->id) }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-warning" onclick="return confirm('Create a reversing entry?')"><i class="fas fa-undo me-1"></i> Reverse</button>
                </form>
            @endif
            <a href="{{ route('admin.finance.journal-entries.index') }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i> Back</a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-transparent"><h6 class="fw-bold mb-0">Entry Lines</h6></div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <thead class="table-light">
                                <tr><th>Account Code</th><th>Account Name</th><th>Description</th><th class="text-end">Debit</th><th class="text-end">Credit</th></tr>
                            </thead>
                            <tbody>
                                @foreach($entry->items as $item)
                                    <tr>
                                        <td>{{ $item->chartOfAccount?->code }}</td>
                                        <td>{{ $item->chartOfAccount?->name }}</td>
                                        <td><small>{{ $item->description ?: '—' }}</small></td>
                                        <td class="text-end">{{ $item->debit > 0 ? number_format($item->debit, 2) : '—' }}</td>
                                        <td class="text-end">{{ $item->credit > 0 ? number_format($item->credit, 2) : '—' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="table-active fw-bold">
                                    <td colspan="3" class="text-end">Totals:</td>
                                    <td class="text-end">{{ number_format($entry->total_debit, 2) }}</td>
                                    <td class="text-end">{{ number_format($entry->total_credit, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header bg-transparent"><h6 class="fw-bold mb-0">Details</h6></div>
                <div class="card-body">
                    <div class="mb-3"><label class="text-muted small text-uppercase">Entry Date</label><p class="fw-semibold mb-0">{{ $entry->entry_date?->format('d M, Y') }}</p></div>
                    @if($entry->description)
                    <div class="mb-3"><label class="text-muted small text-uppercase">Description</label><p class="mb-0">{{ $entry->description }}</p></div>
                    @endif
                    @if($entry->financePeriod)
                    <div class="mb-3"><label class="text-muted small text-uppercase">Period</label><p class="mb-0">{{ $entry->financePeriod->name }}</p></div>
                    @endif
                    <div class="mb-3"><label class="text-muted small text-uppercase">Created By</label><p class="mb-0">{{ $entry->creator?->name ?? '—' }}</p></div>
                    @if($entry->is_posted)
                    <div class="mb-3"><label class="text-muted small text-uppercase">Posted By</label><p class="mb-0">{{ $entry->postedBy?->name ?? '—' }}</p></div>
                    <div class="mb-3"><label class="text-muted small text-uppercase">Posted At</label><p class="mb-0">{{ $entry->posted_at?->format('d M Y, h:i A') }}</p></div>
                    @endif
                </div>
            </div>
            @if($entry->notes)
            <div class="card">
                <div class="card-header bg-transparent"><h6 class="fw-bold mb-0">Notes</h6></div>
                <div class="card-body"><p class="small mb-0">{{ $entry->notes }}</p></div>
            </div>
            @endif
        </div>
    </div>
</x-layouts.admin-layout>
