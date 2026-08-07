<x-layouts.customer-layout title="{{ isset($address) ? 'Edit Address' : 'Add Address' }}">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('customer.addresses') }}" class="text-muted text-decoration-none small">
                <i class="fas fa-arrow-left me-1"></i>Back to Addresses
            </a>
            <h4 class="fw-bold mb-0 mt-1">{{ isset($address) ? 'Edit Address' : 'Add New Address' }}</h4>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ isset($address) ? route('customer.addresses.update', $address) : route('customer.addresses.store') }}">
                @csrf
                @if (isset($address))
                    @method('PUT')
                @endif

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-outline">
                            <input type="text" name="name" id="name" class="form-control"
                                   value="{{ old('name', $address->name ?? '') }}" required>
                            <label class="form-label" for="name">Full Name</label>
                        </div>
                        @error('name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <div class="form-outline">
                            <input type="text" name="phone" id="phone" class="form-control"
                                   value="{{ old('phone', $address->phone ?? '') }}">
                            <label class="form-label" for="phone">Phone Number</label>
                        </div>
                        @error('phone')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-outline">
                            <input type="email" name="email" id="email" class="form-control"
                                   value="{{ old('email', $address->email ?? '') }}">
                            <label class="form-label" for="email">Email Address</label>
                        </div>
                        @error('email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <select name="type" id="type" class="form-select">
                            <option value="shipping" @selected(old('type', $address->type ?? '') === 'shipping')>Shipping</option>
                            <option value="billing" @selected(old('type', $address->type ?? '') === 'billing')>Billing</option>
                        </select>
                        <label class="form-label" for="type">Address Type</label>
                        @error('type')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <div class="form-outline">
                        <input type="text" name="address_line1" id="address_line1" class="form-control"
                               value="{{ old('address_line1', $address->address_line1 ?? '') }}" required>
                        <label class="form-label" for="address_line1">Address Line 1</label>
                    </div>
                    @error('address_line1')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <div class="form-outline">
                        <input type="text" name="address_line2" id="address_line2" class="form-control"
                               value="{{ old('address_line2', $address->address_line2 ?? '') }}">
                        <label class="form-label" for="address_line2">Address Line 2 (Optional)</label>
                    </div>
                    @error('address_line2')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="form-outline">
                            <input type="text" name="city" id="city" class="form-control"
                                   value="{{ old('city', $address->city ?? '') }}" required>
                            <label class="form-label" for="city">City</label>
                        </div>
                        @error('city')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <div class="form-outline">
                            <input type="text" name="state" id="state" class="form-control"
                                   value="{{ old('state', $address->state ?? '') }}">
                            <label class="form-label" for="state">State / Province</label>
                        </div>
                        @error('state')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <div class="form-outline">
                            <input type="text" name="zip" id="zip" class="form-control"
                                   value="{{ old('zip', $address->zip ?? '') }}">
                            <label class="form-label" for="zip">ZIP / Postal Code</label>
                        </div>
                        @error('zip')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="form-outline">
                            <input type="text" name="country" id="country" class="form-control"
                                   value="{{ old('country', $address->country ?? '') }}" required>
                            <label class="form-label" for="country">Country</label>
                        </div>
                        @error('country')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <div class="form-check form-switch mt-2">
                            <input type="hidden" name="is_default" value="0">
                            <input type="checkbox" name="is_default" id="is_default" class="form-check-input" value="1"
                                   @checked(old('is_default', $address->is_default ?? false))>
                            <label class="form-check-label" for="is_default">Set as default address</label>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i>{{ isset($address) ? 'Update Address' : 'Save Address' }}
                </button>
            </form>
        </div>
    </div>
</x-layouts.customer-layout>
