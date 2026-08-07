<x-layouts.customer-layout title="Addresses">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">My Addresses</h4>
        <a href="{{ route('customer.addresses.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i>Add New
        </a>
    </div>

    @if ($addresses->isEmpty())
        <div class="card">
            <div class="card-body text-center py-5 text-muted">
                <i class="fas fa-map-marker-alt fa-3x mb-3"></i>
                <p>No addresses saved yet.</p>
                <a href="{{ route('customer.addresses.create') }}" class="btn btn-primary">Add New Address</a>
            </div>
        </div>
    @else
        <div class="row g-3">
            @foreach ($addresses as $address)
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <span class="badge bg-{{ $address->type === 'shipping' ? 'info' : 'secondary' }} me-1">
                                        {{ ucfirst($address->type) }}
                                    </span>
                                    @if ($address->is_default)
                                        <span class="badge bg-success">Default</span>
                                    @endif
                                </div>
                                <div class="d-flex gap-1">
                                    @if (!$address->is_default)
                                        <form method="POST" action="{{ route('customer.addresses.default', $address) }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-link text-success p-0 me-2" title="Set as default">
                                                <i class="fas fa-check-circle"></i>
                                            </button>
                                        </form>
                                    @endif
                                    <a href="{{ route('customer.addresses.edit', $address) }}" class="btn btn-sm btn-link text-primary p-0 me-2" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="{{ route('customer.addresses.destroy', $address) }}" class="d-inline" onsubmit="return confirm('Delete this address?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-link text-danger p-0" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <p class="mb-1 fw-semibold">{{ $address->name }}</p>
                            <p class="mb-1 text-muted small">{{ $address->address_line1 }}</p>
                            @if ($address->address_line2)
                                <p class="mb-1 text-muted small">{{ $address->address_line2 }}</p>
                            @endif
                            <p class="mb-1 text-muted small">
                                {{ $address->city }}{{ $address->state ? ', ' . $address->state : '' }}{{ $address->zip ? ' ' . $address->zip : '' }}
                            </p>
                            <p class="mb-0 text-muted small">{{ $address->country }}</p>
                            @if ($address->phone)
                                <p class="mb-0 text-muted small mt-1"><i class="fas fa-phone me-1"></i>{{ $address->phone }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</x-layouts.customer-layout>
