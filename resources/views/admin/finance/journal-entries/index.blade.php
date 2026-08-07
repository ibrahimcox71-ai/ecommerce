<x-layouts.admin-layout title="Journal Entries">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div><h4 class="fw-bold mb-1">Journal Entries</h4><p class="text-muted small mb-0">Manage accounting journal entries</p></div>
        <a href="{{ route('admin.finance.journal-entries.create') }}" class="btn btn-primary"><i class="fas fa-plus me-1"></i> New Entry</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="GET" class="row g-2 mb-3">
                <div class="col-md-3"><input type="text" name="search" class="form-control" placeholder="Search entry number..." value="{{ $filters['search'] ?? '' }}"></div>
                <div class="col-md-2">
                    <select name="type" class="form-select">
                        <option value="">All Types</option>
                        @foreach(['standard','adjusting','closing','reversing','opening'] as $type)
                            <option value="{{ $type }}" {{ ($filters['type'] ?? '') === $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="is_posted" class="form-select">
                        <option value="">All Status</option>
                        <option value="posted" {{ ($filters['is_posted'] ?? '') === 'posted' ? 'selected' : '' }}>Posted</option>
                        <option value="draft" {{ ($filters['is_posted'] ?? '') === 'draft' ? 'selected' : '' }}>Draft</option>
                    </select>
                </div>
                <div class="col-md-2"><input type="date" name="date_from" class="form-control" value="{{ $filters['date_from'] ?? '' }}" placeholder="From"></div>
                <div class="col-md-2"><input type="date" name="date_to" class="form-control" value="{{ $filters['date_to'] ?? '' }}" placeholder="To"></div>
                <div class="col-md-1"><button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i></button></div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr><th>Entry #</th><th>Type</th><th>Description</th><th class="text-end">Debit</th><th class="text-end">Credit</th><th>Date</th><th>Status</th><th class="text-center">Actions</th></tr>
                    </thead>
                    <tbody>
                        @forelse($entries as $entry)
                            <tr>
                                <td><a href="{{ route('admin.finance.journal-entries.show', $entry->id) }}" class="fw-semibold text-decoration-none">{{ $entry->entry_number }}</a></td>
                                <td><span class="badge bg-{{ $entry->type === 'standard' ? 'primary' : ($entry->type === 'adjusting' ? 'warning' : ($entry->type === 'closing' ? 'danger' : ($entry->type === 'reversing' ? 'info' : 'secondary'))) }}">{{ ucfirst($entry->type) }}</span></td>
                                <td><small>{{ Str::limit($entry->description, 40) ?: '—' }}</small></td>
                                <td class="text-end">{{ number_format($entry->total_debit, 2) }}</td>
                                <td class="text-end">{{ number_format($entry->total_credit, 2) }}</td>
                                <td><small>{{ $entry->entry_date?->format('d/m/Y') }}</small></td>
                                <td>
                                    @if($entry->is_posted)
                                        <span class="badge bg-success">Posted</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Draft</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item" href="{{ route('admin.finance.journal-entries.show', $entry->id) }}"><i class="fas fa-eye me-2"></i>View</a></li>
                                            @if(!$entry->is_posted)
                                                <li><a class="dropdown-item" href="{{ route('admin.finance.journal-entries.edit', $entry->id) }}"><i class="fas fa-edit me-2"></i>Edit</a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <form method="POST" action="{{ route('admin.finance.journal-entries.post', $entry->id) }}" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="dropdown-item text-success"><i class="fas fa-check-circle me-2"></i>Post</button>
                                                    </form>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <form method="POST" action="{{ route('admin.finance.journal-entries.destroy', $entry->id) }}" class="d-inline">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Delete this entry?')"><i class="fas fa-trash me-2"></i>Delete</button>
                                                    </form>
                                                </li>
                                            @else
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <form method="POST" action="{{ route('admin.finance.journal-entries.reverse', $entry->id) }}" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="dropdown-item text-warning" onclick="return confirm('Reverse this entry? This will create a reversing entry.')"><i class="fas fa-undo me-2"></i>Reverse</button>
                                                    </form>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="text-center py-5 text-muted"><i class="fas fa-journal-whills fa-3x mb-3 d-block"></i>No journal entries found</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-3">{{ $entries->withQueryString()->links() }}</div>
        </div>
    </div>
</x-layouts.admin-layout>
