<x-layouts.admin-layout title="Create Customer">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Create Customer</h4>
            <p class="text-muted small mb-0">Add a new customer to your store</p>
        </div>
        <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>

    <form method="POST" action="{{ route('admin.customers.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="row g-4">
            {{-- Main Content --}}
            <div class="col-lg-8">
                {{-- Basic Information --}}
                <div class="card mb-4">
                    <div class="card-header bg-transparent">
                        <h6 class="fw-bold mb-0">Basic Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                       id="name" name="name" value="{{ old('name') }}" placeholder="Enter full name" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                       id="email" name="email" value="{{ old('email') }}" placeholder="customer@example.com">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                       id="phone" name="phone" value="{{ old('phone') }}" placeholder="+1 (555) 123-4567">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                       id="password" name="password" placeholder="Leave empty for no auth">
                                <small class="text-muted">Set if customer should be able to login</small>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="date_of_birth" class="form-label">Date of Birth</label>
                                <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror"
                                       id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}">
                                @error('date_of_birth')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="gender" class="form-label">Gender</label>
                                <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender">
                                    <option value="">Select Gender</option>
                                    <option value="male" {{ old('gender') === 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="other" {{ old('gender') === 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="referral_code" class="form-label">Referral Code</label>
                                <input type="text" class="form-control @error('referral_code') is-invalid @enderror"
                                       id="referral_code" name="referral_code" value="{{ old('referral_code') }}"
                                       placeholder="Auto-generated if empty">
                                <small class="text-muted">Unique referral code</small>
                                @error('referral_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Customer Type --}}
                <div class="card mb-4">
                    <div class="card-header bg-transparent">
                        <h6 class="fw-bold mb-0">Customer Type</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="customer_type" class="form-label">Type</label>
                                <select class="form-select @error('customer_type') is-invalid @enderror" id="customer_type" name="customer_type">
                                    <option value="individual" {{ old('customer_type', 'individual') === 'individual' ? 'selected' : '' }}>Individual</option>
                                    <option value="business" {{ old('customer_type') === 'business' ? 'selected' : '' }}>Business</option>
                                </select>
                                @error('customer_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="customer_group_id" class="form-label">Customer Group</label>
                                <select class="form-select @error('customer_group_id') is-invalid @enderror" id="customer_group_id" name="customer_group_id">
                                    <option value="">No Group</option>
                                    @foreach($groups as $group)
                                        <option value="{{ $group->id }}" {{ old('customer_group_id') == $group->id ? 'selected' : '' }}>
                                            {{ $group->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('customer_group_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div id="businessFields" class="{{ old('customer_type') === 'business' ? '' : 'd-none' }}">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="company_name" class="form-label">Company Name</label>
                                    <input type="text" class="form-control @error('company_name') is-invalid @enderror"
                                           id="company_name" name="company_name" value="{{ old('company_name') }}" placeholder="Company name">
                                    @error('company_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="company_registration_number" class="form-label">Registration No.</label>
                                    <input type="text" class="form-control @error('company_registration_number') is-invalid @enderror"
                                           id="company_registration_number" name="company_registration_number"
                                           value="{{ old('company_registration_number') }}" placeholder="Registration number">
                                    @error('company_registration_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="tax_number" class="form-label">Tax Number</label>
                                    <input type="text" class="form-control @error('tax_number') is-invalid @enderror"
                                           id="tax_number" name="tax_number" value="{{ old('tax_number') }}" placeholder="Tax/VAT number">
                                    @error('tax_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Emergency Contact --}}
                <div class="card mb-4">
                    <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold mb-0">Emergency Contact</h6>
                        <button type="button" class="btn btn-sm btn-link p-0" data-bs-toggle="collapse" data-bs-target="#emergencyCollapse">
                            <i class="fas fa-chevron-down"></i>
                        </button>
                    </div>
                    <div class="collapse show" id="emergencyCollapse">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="emergency_contact_name" class="form-label">Contact Name</label>
                                    <input type="text" class="form-control @error('emergency_contact_name') is-invalid @enderror"
                                           id="emergency_contact_name" name="emergency_contact_name"
                                           value="{{ old('emergency_contact_name') }}" placeholder="Emergency contact name">
                                    @error('emergency_contact_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="emergency_contact_phone" class="form-label">Contact Phone</label>
                                    <input type="text" class="form-control @error('emergency_contact_phone') is-invalid @enderror"
                                           id="emergency_contact_phone" name="emergency_contact_phone"
                                           value="{{ old('emergency_contact_phone') }}" placeholder="Emergency contact phone">
                                    @error('emergency_contact_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Notes --}}
                <div class="card mb-4">
                    <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold mb-0">Notes</h6>
                        <button type="button" class="btn btn-sm btn-link p-0" data-bs-toggle="collapse" data-bs-target="#notesCollapse">
                            <i class="fas fa-chevron-down"></i>
                        </button>
                    </div>
                    <div class="collapse show" id="notesCollapse">
                        <div class="card-body">
                            <div class="mb-0">
                                <textarea class="form-control @error('notes') is-invalid @enderror"
                                          id="notes" name="notes" rows="4"
                                          placeholder="Internal notes about this customer">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="col-lg-4">
                {{-- Avatar --}}
                <div class="card mb-4">
                    <div class="card-header bg-transparent">
                        <h6 class="fw-bold mb-0">Photo</h6>
                    </div>
                    <div class="card-body text-center">
                        <div class="dropzone-wrapper border rounded p-3 text-center bg-light"
                             onclick="document.getElementById('avatar').click()"
                             ondragover="event.preventDefault()"
                             ondrop="handleDrop(event, 'avatar')">
                            <img id="avatarPreview" src="#" alt="Preview"
                                 class="img-fluid rounded-circle d-none mb-2"
                                 style="width: 120px; height: 120px; object-fit: cover;">
                            <i class="fas fa-user fa-4x text-muted" id="avatarPlaceholder"></i>
                            <p class="text-muted small mt-2 mb-0" id="avatarText">Click or drag photo</p>
                        </div>
                        <input type="file" class="d-none" id="avatar" name="avatar"
                               accept="image/*" onchange="previewImage(this, 'avatar')">
                        <small class="text-muted d-block mt-2">JPG, PNG, WEBP. Max 2MB</small>
                        @error('avatar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Status --}}
                <div class="card mb-4">
                    <div class="card-header bg-transparent">
                        <h6 class="fw-bold mb-0">Status</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <select class="form-select" id="status" name="status">
                                <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="suspended" {{ old('status') === 'suspended' ? 'selected' : '' }}>Suspended</option>
                            </select>
                            <small class="text-muted">Suspended customers cannot log in or place orders</small>
                        </div>
                    </div>
                </div>

                {{-- Wallet & Points --}}
                <div class="card mb-4">
                    <div class="card-header bg-transparent">
                        <h6 class="fw-bold mb-0">Wallet & Points</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="reward_points" class="form-label">Reward Points</label>
                            <input type="number" class="form-control" id="reward_points" name="reward_points"
                                   value="{{ old('reward_points', 0) }}" min="0">
                        </div>
                        <div class="mb-0">
                            <label for="wallet_balance" class="form-label">Wallet Balance</label>
                            <div class="input-group">
                                <span class="input-group-text">{{ config('ecommerce.currency.symbol', '$') }}</span>
                                <input type="number" step="0.01" class="form-control" id="wallet_balance"
                                       name="wallet_balance" value="{{ old('wallet_balance', 0) }}" min="0">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save me-2"></i> Create Customer
                    </button>
                    <button type="reset" class="btn btn-outline-secondary">
                        <i class="fas fa-undo me-2"></i> Reset Form
                    </button>
                </div>
            </div>
        </div>
    </form>

</x-layouts.admin-layout>

@push('scripts')
<script>
$('#customer_type').change(function() {
    if ($(this).val() === 'business') {
        $('#businessFields').removeClass('d-none');
    } else {
        $('#businessFields').addClass('d-none');
    }
});

function previewImage(input, prefix) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            $('#' + prefix + 'Preview').attr('src', e.target.result).removeClass('d-none');
            $('#' + prefix + 'Placeholder').addClass('d-none');
            $('#' + prefix + 'Text').text(input.files[0].name);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function handleDrop(event, prefix) {
    event.preventDefault();
    const files = event.dataTransfer.files;
    if (files.length > 0) {
        const input = document.getElementById(prefix);
        input.files = files;
        previewImage(input, prefix);
    }
}

document.querySelectorAll('.dropzone-wrapper').forEach(el => {
    el.addEventListener('dragover', function(e) {
        this.classList.add('border-primary');
    });
    el.addEventListener('dragleave', function(e) {
        this.classList.remove('border-primary');
    });
    el.addEventListener('drop', function(e) {
        this.classList.remove('border-primary');
    });
});
</script>
@endpush
