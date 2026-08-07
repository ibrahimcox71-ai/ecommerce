<x-layouts.admin-layout title="{{ $supplier->name }}">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">{{ $supplier->name }}</h4>
            <p class="text-muted small mb-0">
                <span class="badge bg-dark me-1">{{ $supplier->supplier_code }}</span>
                Supplier details and purchase information
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.suppliers.edit', $supplier->id) }}" class="btn btn-primary">
                <i class="fas fa-edit me-1"></i> Edit
            </a>
            <a href="{{ route('admin.suppliers.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            {{-- Basic Information --}}
            <div class="card mb-4">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Basic Information</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small text-uppercase">Company Name</label>
                            <p class="fw-semibold mb-0">{{ $supplier->company_name ?: '—' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small text-uppercase">Contact Person</label>
                            <p class="fw-semibold mb-0">{{ $supplier->contact_person ?: '—' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small text-uppercase">Email</label>
                            <p class="fw-semibold mb-0">
                                @if($supplier->email)
                                    <a href="mailto:{{ $supplier->email }}">{{ $supplier->email }}</a>
                                @else
                                    —
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small text-uppercase">Phone</label>
                            <p class="fw-semibold mb-0">
                                @if($supplier->phone)
                                    <a href="tel:{{ $supplier->phone }}">{{ $supplier->phone }}</a>
                                @else
                                    —
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small text-uppercase">Alternative Phone</label>
                            <p class="fw-semibold mb-0">{{ $supplier->alternative_phone ?: '—' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small text-uppercase">Website</label>
                            <p class="fw-semibold mb-0">
                                @if($supplier->website)
                                    <a href="{{ $supplier->website }}" target="_blank" rel="noopener">
                                        <i class="fas fa-external-link-alt me-1"></i>{{ $supplier->website }}
                                    </a>
                                @else
                                    —
                                @endif
                            </p>
                        </div>
                    </div>
                    @if($supplier->description)
                        <div class="mb-0">
                            <label class="text-muted small text-uppercase">Description</label>
                            <p class="mb-0">{{ $supplier->description }}</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Business Registration --}}
            <div class="card mb-4">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Business Registration</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small text-uppercase">Trade License Number</label>
                            <p class="fw-semibold mb-0">{{ $supplier->trade_license_number ?: '—' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small text-uppercase">Tax / VAT Number</label>
                            <p class="fw-semibold mb-0">{{ $supplier->tax_vat_number ?: '—' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Address Information --}}
            <div class="card mb-4">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Address</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="text-muted small text-uppercase">Country</label>
                            <p class="fw-semibold mb-0">{{ $supplier->country ?: '—' }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="text-muted small text-uppercase">State</label>
                            <p class="fw-semibold mb-0">{{ $supplier->state ?: '—' }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="text-muted small text-uppercase">City</label>
                            <p class="fw-semibold mb-0">{{ $supplier->city ?: '—' }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="text-muted small text-uppercase">Postal Code</label>
                            <p class="fw-semibold mb-0">{{ $supplier->postal_code ?: '—' }}</p>
                        </div>
                    </div>
                    @if($supplier->full_address)
                        <div class="mb-0">
                            <label class="text-muted small text-uppercase">Full Address</label>
                            <p class="mb-0">{{ $supplier->full_address }}</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Purchase Information --}}
            <div class="card mb-4">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Purchase Information</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="text-muted small text-uppercase">Payment Terms</label>
                            <p class="fw-semibold mb-0">{{ $supplier->payment_terms ?: '—' }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="text-muted small text-uppercase">Credit Limit</label>
                            <p class="fw-semibold mb-0">
                                @if($supplier->credit_limit)
                                    ${{ number_format($supplier->credit_limit, 2) }}
                                @else
                                    —
                                @endif
                            </p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="text-muted small text-uppercase">Currency</label>
                            <p class="fw-semibold mb-0">{{ $supplier->currency }}</p>
                        </div>
                    </div>
                    @if($supplier->bank_information)
                        <div class="mb-3">
                            <label class="text-muted small text-uppercase">Bank Information</label>
                            <p class="mb-0">{{ $supplier->bank_information }}</p>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-6">
                            <label class="text-muted small text-uppercase">Outstanding Balance</label>
                            <h4 class="fw-bold {{ $supplier->outstanding_balance > 0 ? 'text-danger' : 'text-success' }} mb-0">
                                ${{ number_format($supplier->outstanding_balance, 2) }}
                            </h4>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small text-uppercase">Last Purchase Date</label>
                            <p class="fw-semibold mb-0">
                                @if($supplier->last_purchase_date)
                                    {{ $supplier->last_purchase_date->format('F d, Y') }}
                                @else
                                    No purchases yet
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Activity Log --}}
            <div class="card">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Activity Log</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm mb-0">
                            <thead>
                                <tr>
                                    <th>Action</th>
                                    <th>Description</th>
                                    <th>By</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($supplier->activityLogs as $log)
                                    <tr>
                                        <td>
                                            <span class="badge bg-info">{{ $log->description }}</span>
                                        </td>
                                        <td class="small">{{ $log->description }}</td>
                                        <td class="small">{{ $log->causer?->name ?? 'System' }}</td>
                                        <td class="small text-muted">{{ $log->created_at->diffForHumans() }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-3">No activity recorded</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            {{-- Logo Card --}}
            <div class="card mb-4">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Supplier Logo</h6>
                </div>
                <div class="card-body text-center">
                    @if($supplier->logo)
                        <img src="{{ $supplier->logo_url }}" alt="{{ $supplier->name }}"
                             class="img-fluid rounded" style="max-height: 150px;">
                    @else
                        <div class="py-4">
                            <i class="fas fa-truck fa-4x text-muted"></i>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Status Card --}}
            <div class="card mb-4">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Status</h6>
                </div>
                <div class="card-body">
                    @php
                        $statusColors = ['active' => 'success', 'inactive' => 'secondary', 'blacklisted' => 'danger'];
                        $statusIcons = ['active' => 'fa-check-circle', 'inactive' => 'fa-pause-circle', 'blacklisted' => 'fa-ban'];
                        $color = $statusColors[$supplier->status->value] ?? 'secondary';
                        $icon = $statusIcons[$supplier->status->value] ?? 'fa-circle';
                    @endphp
                    <div class="text-center mb-3">
                        <span class="badge bg-{{ $color }} fs-6 px-3 py-2">
                            <i class="fas {{ $icon }} me-1"></i>{{ $supplier->status->label() }}
                        </span>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted">Supplier Code</span>
                        <span class="fw-semibold">{{ $supplier->supplier_code }}</span>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted">Total Products</span>
                        <span class="badge bg-primary rounded-pill">{{ $supplier->products_count }}</span>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted">Outstanding</span>
                        <span class="fw-semibold text-danger">${{ number_format($supplier->outstanding_balance, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between py-2">
                        <span class="text-muted">Member Since</span>
                        <span class="fw-semibold">{{ $supplier->created_at->format('M Y') }}</span>
                    </div>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="d-grid gap-2">
                <a href="{{ route('admin.suppliers.edit', $supplier->id) }}" class="btn btn-primary">
                    <i class="fas fa-edit me-2"></i> Edit Supplier
                </a>
                @can('suppliers.delete')
                    <button type="button" class="btn btn-outline-danger" onclick="quickDelete()">
                        <i class="fas fa-trash me-2"></i> Delete Supplier
                    </button>
                @endcan
            </div>
        </div>
    </div>

</x-layouts.admin-layout>

@push('scripts')
<script>
function quickDelete() {
    if (confirm('Are you sure you want to delete {{ $supplier->name }}?')) {
        $('<form>').attr({ method: 'POST', action: '{{ route('admin.suppliers.destroy', $supplier->id) }}' })
            .append($('<input>').attr({ type: 'hidden', name: '_token', value: '{{ csrf_token() }}' }))
            .append($('<input>').attr({ type: 'hidden', name: '_method', value: 'DELETE' }))
            .appendTo('body').submit();
    }
}
</script>
@endpush
