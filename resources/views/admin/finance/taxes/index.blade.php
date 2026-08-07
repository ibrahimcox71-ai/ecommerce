<x-layouts.admin-layout title="Tax Management">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div><h4 class="fw-bold mb-1">Tax Management</h4><p class="text-muted small mb-0">Manage tax groups, rates, and view tax collected</p></div>
    </div>

    <div class="row g-4">
        <div class="col-lg-5">
            <div class="card mb-4">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0">Tax Groups</h6>
                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createGroupModal"><i class="fas fa-plus me-1"></i> Add Group</button>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light"><tr><th>Name</th><th class="text-center">Rates</th><th>Status</th><th class="text-center">Actions</th></tr></thead>
                            <tbody>
                                @forelse($groups as $group)
                                    <tr>
                                        <td>
                                            <span class="fw-semibold">{{ $group->name }}</span>
                                            @if($group->is_default)<span class="badge bg-info ms-1">Default</span>@endif
                                        </td>
                                        <td class="text-center">{{ $group->tax_rates_count }}</td>
                                        <td><span class="badge bg-{{ $group->is_active ? 'success' : 'secondary' }}">{{ $group->is_active ? 'Active' : 'Inactive' }}</span></td>
                                        <td class="text-center">
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editGroupModal{{ $group->id }}"><i class="fas fa-edit me-2"></i>Edit</a></li>
                                                    <li>
                                                        <form method="POST" action="{{ route('admin.finance.taxes.groups.destroy', $group->id) }}" class="d-inline">
                                                            @csrf @method('DELETE')
                                                            <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Delete this group?')"><i class="fas fa-trash me-2"></i>Delete</button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="text-center py-4 text-muted">No tax groups</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-transparent"><h6 class="fw-bold mb-0">Tax Summary</h6></div>
                <div class="card-body">
                    <div class="text-center">
                        <h2 class="fw-bold text-primary">{{ number_format($totalTaxCollected, 2) }}</h2>
                        <p class="text-muted small">Total Tax Collected</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0">Tax Rates</h6>
                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createRateModal"><i class="fas fa-plus me-1"></i> Add Rate</button>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light"><tr><th>Name</th><th>Rate</th><th>Group</th><th>Region</th><th>Compound</th><th>Status</th><th class="text-center">Actions</th></tr></thead>
                            <tbody>
                                @forelse($rates as $rate)
                                    <tr>
                                        <td class="fw-semibold">{{ $rate->name }}</td>
                                        <td><span class="badge bg-primary">{{ $rate->rate }}%</span></td>
                                        <td><small>{{ $rate->taxGroup?->name }}</small></td>
                                        <td><small>{{ $rate->region ?: '—' }}</small></td>
                                        <td>{!! $rate->is_compound ? '<span class="badge bg-info">Yes</span>' : '<span class="badge bg-secondary">No</span>' !!}</td>
                                        <td><span class="badge bg-{{ $rate->is_active ? 'success' : 'secondary' }}">{{ $rate->is_active ? 'Active' : 'Inactive' }}</span></td>
                                        <td class="text-center">
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editRateModal{{ $rate->id }}"><i class="fas fa-edit me-2"></i>Edit</a></li>
                                                    <li>
                                                        <form method="POST" action="{{ route('admin.finance.taxes.rates.destroy', $rate->id) }}" class="d-inline">
                                                            @csrf @method('DELETE')
                                                            <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Delete this rate?')"><i class="fas fa-trash me-2"></i>Delete</button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="7" class="text-center py-4 text-muted">No tax rates</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($rates->hasPages())<div class="card-footer d-flex justify-content-center">{{ $rates->withQueryString()->links() }}</div>@endif
            </div>
        </div>
    </div>

    {{-- Create Group Modal --}}
    <div class="modal fade" id="createGroupModal" tabindex="-1">
        <div class="modal-dialog"><div class="modal-content">
            <form method="POST" action="{{ route('admin.finance.taxes.groups.store') }}">
                @csrf
                <div class="modal-header"><h5 class="modal-title">Create Tax Group</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="mb-3"><label class="form-label">Name <span class="text-danger">*</span></label><input type="text" name="name" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="2"></textarea></div>
                    <div class="form-check mb-2"><input type="checkbox" name="is_active" class="form-check-input" value="1" checked><label class="form-check-label">Active</label></div>
                    <div class="form-check"><input type="checkbox" name="is_default" class="form-check-input" value="1"><label class="form-check-label">Set as Default</label></div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn btn-primary">Create</button></div>
            </form>
        </div></div>
    </div>

    {{-- Create Rate Modal --}}
    <div class="modal fade" id="createRateModal" tabindex="-1">
        <div class="modal-dialog"><div class="modal-content">
            <form method="POST" action="{{ route('admin.finance.taxes.rates.store') }}">
                @csrf
                <div class="modal-header"><h5 class="modal-title">Create Tax Rate</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="mb-3"><label class="form-label">Group <span class="text-danger">*</span></label>
                        <select name="tax_group_id" class="form-select" required>
                            @foreach($groups as $g)<option value="{{ $g->id }}">{{ $g->name }}</option>@endforeach
                        </select>
                    </div>
                    <div class="mb-3"><label class="form-label">Name <span class="text-danger">*</span></label><input type="text" name="name" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label">Rate (%) <span class="text-danger">*</span></label><input type="number" name="rate" class="form-control" step="0.01" min="0" max="100" required></div>
                    <div class="mb-3"><label class="form-label">Region</label><input type="text" name="region" class="form-control" placeholder="e.g., US, EU, or leave blank"></div>
                    <div class="mb-3"><label class="form-label">Priority</label><input type="number" name="priority" class="form-control" value="0" min="0"></div>
                    <div class="form-check mb-2"><input type="checkbox" name="is_compound" class="form-check-input" value="1"><label class="form-check-label">Compound Tax</label></div>
                    <div class="form-check mb-2"><input type="checkbox" name="is_active" class="form-check-input" value="1" checked><label class="form-check-label">Active</label></div>
                    <div class="mb-3"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="2"></textarea></div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn btn-primary">Create</button></div>
            </form>
        </div></div>
    </div>

    {{-- Edit Group Modals --}}
    @foreach($groups as $group)
    <div class="modal fade" id="editGroupModal{{ $group->id }}" tabindex="-1">
        <div class="modal-dialog"><div class="modal-content">
            <form method="POST" action="{{ route('admin.finance.taxes.groups.update', $group->id) }}">
                @csrf
                <div class="modal-header"><h5 class="modal-title">Edit Tax Group</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="mb-3"><label class="form-label">Name <span class="text-danger">*</span></label><input type="text" name="name" class="form-control" value="{{ $group->name }}" required></div>
                    <div class="mb-3"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="2">{{ $group->description }}</textarea></div>
                    <div class="form-check mb-2"><input type="checkbox" name="is_active" class="form-check-input" value="1" {{ $group->is_active ? 'checked' : '' }}><label class="form-check-label">Active</label></div>
                    <div class="form-check"><input type="checkbox" name="is_default" class="form-check-input" value="1" {{ $group->is_default ? 'checked' : '' }}><label class="form-check-label">Set as Default</label></div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn btn-primary">Update</button></div>
            </form>
        </div></div>
    </div>
    @endforeach

    {{-- Edit Rate Modals --}}
    @foreach($rates as $rate)
    <div class="modal fade" id="editRateModal{{ $rate->id }}" tabindex="-1">
        <div class="modal-dialog"><div class="modal-content">
            <form method="POST" action="{{ route('admin.finance.taxes.rates.update', $rate->id) }}">
                @csrf
                <div class="modal-header"><h5 class="modal-title">Edit Tax Rate</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="mb-3"><label class="form-label">Group <span class="text-danger">*</span></label>
                        <select name="tax_group_id" class="form-select" required>
                            @foreach($groups as $g)<option value="{{ $g->id }}" {{ $rate->tax_group_id === $g->id ? 'selected' : '' }}>{{ $g->name }}</option>@endforeach
                        </select>
                    </div>
                    <div class="mb-3"><label class="form-label">Name <span class="text-danger">*</span></label><input type="text" name="name" class="form-control" value="{{ $rate->name }}" required></div>
                    <div class="mb-3"><label class="form-label">Rate (%) <span class="text-danger">*</span></label><input type="number" name="rate" class="form-control" step="0.01" min="0" max="100" value="{{ $rate->rate }}" required></div>
                    <div class="mb-3"><label class="form-label">Region</label><input type="text" name="region" class="form-control" value="{{ $rate->region }}"></div>
                    <div class="mb-3"><label class="form-label">Priority</label><input type="number" name="priority" class="form-control" value="{{ $rate->priority }}" min="0"></div>
                    <div class="form-check mb-2"><input type="checkbox" name="is_compound" class="form-check-input" value="1" {{ $rate->is_compound ? 'checked' : '' }}><label class="form-check-label">Compound Tax</label></div>
                    <div class="form-check mb-2"><input type="checkbox" name="is_active" class="form-check-input" value="1" {{ $rate->is_active ? 'checked' : '' }}><label class="form-check-label">Active</label></div>
                    <div class="mb-3"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="2">{{ $rate->description }}</textarea></div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn btn-primary">Update</button></div>
            </form>
        </div></div>
    </div>
    @endforeach
</x-layouts.admin-layout>
