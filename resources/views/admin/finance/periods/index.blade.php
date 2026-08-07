<x-layouts.admin-layout title="Finance Periods">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div><h4 class="fw-bold mb-1">Finance Periods</h4><p class="text-muted small mb-0">Manage accounting periods</p></div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createPeriodModal"><i class="fas fa-plus me-1"></i> Add Period</button>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr><th>Name</th><th>Start Date</th><th>End Date</th><th>Status</th><th>Closed By</th><th>Closed At</th><th class="text-center">Actions</th></tr>
                    </thead>
                    <tbody>
                        @forelse($periods as $period)
                            <tr>
                                <td class="fw-semibold">{{ $period->name }}</td>
                                <td>{{ $period->start_date?->format('d/m/Y') }}</td>
                                <td>{{ $period->end_date?->format('d/m/Y') }}</td>
                                <td>
                                    <span class="badge bg-{{ $period->status === 'open' ? 'success' : ($period->status === 'closed' ? 'secondary' : 'danger') }}">
                                        {{ ucfirst($period->status) }}
                                    </span>
                                </td>
                                <td>{{ $period->closedBy?->name ?? '—' }}</td>
                                <td>{{ $period->closed_at?->format('d/m/Y H:i') ?? '—' }}</td>
                                <td class="text-center">
                                    @if($period->isOpen())
                                    <div class="btn-group btn-group-sm">
                                        <form method="POST" action="{{ route('admin.finance.periods.close', $period->id) }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-success" onclick="return confirm('Close this period?')" title="Close"><i class="fas fa-check"></i></button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.finance.periods.destroy', $period->id) }}" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Delete?')" title="Delete"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </div>
                                    @elseif($period->isClosed())
                                        <form method="POST" action="{{ route('admin.finance.periods.lock', $period->id) }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Lock this period? This cannot be undone.')"><i class="fas fa-lock me-1"></i> Lock</button>
                                        </form>
                                    @else
                                        <span class="text-muted">Locked</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center py-5 text-muted"><i class="fas fa-calendar-alt fa-3x mb-3 d-block"></i>No periods defined</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($periods->hasPages())<div class="card-footer d-flex justify-content-center">{{ $periods->links() }}</div>@endif
    </div>

    {{-- Create Period Modal --}}
    <div class="modal fade" id="createPeriodModal" tabindex="-1">
        <div class="modal-dialog"><div class="modal-content">
            <form method="POST" action="{{ route('admin.finance.periods.store') }}">
                @csrf
                <div class="modal-header"><h5 class="modal-title">Create Period</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="mb-3"><label class="form-label">Name <span class="text-danger">*</span></label><input type="text" name="name" class="form-control" placeholder="e.g., Q3 2026" required></div>
                    <div class="row g-3">
                        <div class="col-6"><label class="form-label">Start Date <span class="text-danger">*</span></label><input type="date" name="start_date" class="form-control" required></div>
                        <div class="col-6"><label class="form-label">End Date <span class="text-danger">*</span></label><input type="date" name="end_date" class="form-control" required></div>
                    </div>
                    <div class="mt-3"><label class="form-label">Notes</label><textarea name="notes" class="form-control" rows="2"></textarea></div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn btn-primary">Create</button></div>
            </form>
        </div></div>
    </div>
</x-layouts.admin-layout>
