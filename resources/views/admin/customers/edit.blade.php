<x-layouts.admin-layout title="Edit Customer">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Edit Customer</h4>
            <p class="text-muted small mb-0">Update customer information</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.customers.show', $customer->id) }}" class="btn btn-outline-info">
                <i class="fas fa-eye me-1"></i> View
            </a>
            <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.customers.update', $customer->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

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
                                       id="name" name="name" value="{{ old('name', $customer->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                       id="email" name="email" value="{{ old('email', $customer->email) }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                       id="phone" name="phone" value="{{ old('phone', $customer->phone) }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">New Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                       id="password" name="password" placeholder="Leave empty to keep current">
                                <small class="text-muted">Fill only if changing password</small>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="date_of_birth" class="form-label">Date of Birth</label>
                                <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror"
                                       id="date_of_birth" name="date_of_birth"
                                       value="{{ old('date_of_birth', $customer->date_of_birth?->format('Y-m-d')) }}">
                                @error('date_of_birth')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="gender" class="form-label">Gender</label>
                                <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender">
                                    <option value="">Select</option>
                                    <option value="male" {{ old('gender', $customer->gender) === 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender', $customer->gender) === 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="other" {{ old('gender', $customer->gender) === 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="referral_code" class="form-label">Referral Code</label>
                                <input type="text" class="form-control" value="{{ $customer->referral_code }}" disabled>
                                <small class="text-muted">Cannot be changed</small>
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
                                    <option value="individual" {{ old('customer_type', $customer->customer_type?->value) === 'individual' ? 'selected' : '' }}>Individual</option>
                                    <option value="business" {{ old('customer_type', $customer->customer_type?->value) === 'business' ? 'selected' : '' }}>Business</option>
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
                                        <option value="{{ $group->id }}" {{ old('customer_group_id', $customer->customer_group_id) == $group->id ? 'selected' : '' }}>
                                            {{ $group->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('customer_group_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div id="businessFields" class="{{ old('customer_type', $customer->customer_type?->value) === 'business' ? '' : 'd-none' }}">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="company_name" class="form-label">Company Name</label>
                                    <input type="text" class="form-control @error('company_name') is-invalid @enderror"
                                           id="company_name" name="company_name"
                                           value="{{ old('company_name', $customer->company_name) }}">
                                    @error('company_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="company_registration_number" class="form-label">Registration No.</label>
                                    <input type="text" class="form-control @error('company_registration_number') is-invalid @enderror"
                                           id="company_registration_number" name="company_registration_number"
                                           value="{{ old('company_registration_number', $customer->company_registration_number) }}">
                                    @error('company_registration_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="tax_number" class="form-label">Tax Number</label>
                                    <input type="text" class="form-control @error('tax_number') is-invalid @enderror"
                                           id="tax_number" name="tax_number"
                                           value="{{ old('tax_number', $customer->tax_number) }}">
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
                                           value="{{ old('emergency_contact_name', $customer->emergency_contact_name) }}">
                                    @error('emergency_contact_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="emergency_contact_phone" class="form-label">Contact Phone</label>
                                    <input type="text" class="form-control @error('emergency_contact_phone') is-invalid @enderror"
                                           id="emergency_contact_phone" name="emergency_contact_phone"
                                           value="{{ old('emergency_contact_phone', $customer->emergency_contact_phone) }}">
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
                                          placeholder="Internal notes">{{ old('notes', $customer->notes) }}</textarea>
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
                        <div class="dropzone-wrapper border rounded p-3 text-center bg-light position-relative"
                             onclick="document.getElementById('avatar').click()"
                             ondragover="event.preventDefault()"
                             ondrop="handleDrop(event, 'avatar')">
                            @if($customer->avatar)
                                <img id="avatarPreview" src="{{ $customer->avatar_url }}" alt="{{ $customer->name }}"
                                     class="img-fluid rounded-circle mb-2"
                                     style="width: 120px; height: 120px; object-fit: cover;">
                                <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2"
                                        onclick="event.stopPropagation(); removeAvatar()">
                                    <i class="fas fa-times"></i>
                                </button>
                            @else
                                <img id="avatarPreview" src="#" alt="Preview"
                                     class="img-fluid rounded-circle d-none mb-2"
                                     style="width: 120px; height: 120px; object-fit: cover;">
                                <i class="fas fa-user fa-4x text-muted" id="avatarPlaceholder"></i>
                                <p class="text-muted small mt-2 mb-0" id="avatarText">Click or drag photo</p>
                            @endif
                        </div>
                        <input type="file" class="d-none" id="avatar" name="avatar"
                               accept="image/*" onchange="previewImage(this, 'avatar')">
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" id="remove_avatar" name="remove_avatar" value="1">
                            <label class="form-check-label text-danger small" for="remove_avatar">Remove current photo</label>
                        </div>
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
                                <option value="active" {{ old('status', $customer->status) === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="suspended" {{ old('status', $customer->status) === 'suspended' ? 'selected' : '' }}>Suspended</option>
                            </select>
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
                                   value="{{ old('reward_points', $customer->reward_points) }}" min="0">
                        </div>
                        <div class="mb-0">
                            <label for="wallet_balance" class="form-label">Wallet Balance</label>
                            <div class="input-group">
                                <span class="input-group-text">{{ config('ecommerce.currency.symbol', '$') }}</span>
                                <input type="number" step="0.01" class="form-control" id="wallet_balance"
                                       name="wallet_balance" value="{{ old('wallet_balance', $customer->wallet_balance) }}" min="0">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Quick Info --}}
                <div class="card mb-4">
                    <div class="card-header bg-transparent">
                        <h6 class="fw-bold mb-0">Quick Info</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Total Orders</span>
                            <span class="badge bg-info">{{ $customer->total_orders }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Total Spend</span>
                            <span class="fw-semibold">{{ config('ecommerce.currency.symbol', '$') }}{{ number_format($customer->total_spend, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Linked User</span>
                            <span class="small">{{ $customer->user ? 'Yes' : 'No' }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Created</span>
                            <span class="small">{{ $customer->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save me-2"></i> Update Customer
                    </button>
                    <button type="button" class="btn btn-outline-danger" onclick="confirmDelete()">
                        <i class="fas fa-trash me-2"></i> Delete Customer
                    </button>
                </div>
            </div>
        </div>
    </form>

</x-layouts.admin-layout>

{{-- Delete Confirmation Modal --}}
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Customer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete <strong>{{ $customer->name }}</strong>?</p>
                <p class="text-muted small mb-0">The customer record will be soft-deleted.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('admin.customers.destroy', $customer->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-1"></i> Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

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
            $('#remove_' + prefix).prop('checked', false);
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

function removeAvatar() {
    $('#remove_avatar').prop('checked', true);
    $('#avatarPreview').addClass('d-none');
    $('#avatarPlaceholder').removeClass('d-none');
    $('#avatarText').text('Click or drag');
}

function confirmDelete() {
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>
@endpush
