<x-layouts.admin-layout title="Payment Methods">
    <x-admin.crud-header
        title="Payment Methods"
        subtitle="Manage payment methods"
        :buttons="[
            ['label' => 'Add Method', 'modal' => 'createPaymentMethodModal', 'icon' => 'bi bi-plus-lg'],
        ]"
    />

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Type</th>
                            <th class="text-center">Default</th>
                            <th>Status</th>
                            <th>Sort</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($methods as $method)
                            <tr>
                                <td class="fw-semibold">{{ $method->name }}</td>
                                <td><span class="badge bg-info">{{ $method->type }}</span></td>
                                <td class="text-center">{!! $method->is_default ? '<i class="bi bi-check-circle-fill text-success"></i>' : '—' !!}</td>
                                <td>
                                    <span class="badge bg-{{ $method->is_active ? 'success' : 'secondary' }}">
                                        {{ $method->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>{{ $method->sort_order }}</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-outline-primary" title="Edit"
                                            data-bs-toggle="modal" data-bs-target="#editMethodModal-{{ $method->id }}">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <form method="POST" action="{{ route('admin.finance.payment-methods.destroy', $method->id) }}" class="d-inline" onsubmit="return confirm('Delete this method?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <x-admin.empty-state icon="bi bi-credit-card" message="No payment methods found." />
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($methods->hasPages())<div class="card-footer d-flex justify-content-center">{{ $methods->links() }}</div>@endif
    </div>

    {{-- Create Modal --}}
    <div class="modal fade" id="createPaymentMethodModal" tabindex="-1">
        <div class="modal-dialog"><div class="modal-content">
            <form method="POST" action="{{ route('admin.finance.payment-methods.store') }}">
                @csrf
                <div class="modal-header"><h5 class="modal-title">Add Payment Method</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="mb-3"><label class="form-label">Name <span class="text-danger">*</span></label><input type="text" name="name" class="form-control" required></div>
                    <div class="mb-3">
                        <label class="form-label">Type <span class="text-danger">*</span></label>
                        <select name="type" class="form-select" required>
                            <option value="">Select</option>
                            <option value="cash">Cash</option>
                            <option value="bank">Bank Transfer</option>
                            <option value="mobile">Mobile Payment</option>
                            <option value="credit">Credit Card</option>
                            <option value="online">Online Payment</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="mb-3"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="2"></textarea></div>
                    <div class="form-check mb-3">
                        <input type="checkbox" name="is_default" class="form-check-input" value="1" id="createIsDefault">
                        <label class="form-check-label" for="createIsDefault">Set as default</label>
                    </div>
                    <div class="mb-3"><label class="form-label">Sort Order</label><input type="number" name="sort_order" class="form-control" value="0"></div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn btn-primary">Create</button></div>
            </form>
        </div></div>
    </div>
</x-layouts.admin-layout>
