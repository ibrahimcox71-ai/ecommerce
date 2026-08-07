<x-layouts.admin-layout title="Create Supplier">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Create Supplier</h4>
            <p class="text-muted small mb-0">Add a new supplier or vendor</p>
        </div>
        <a href="{{ route('admin.suppliers.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>

    <form method="POST" action="{{ route('admin.suppliers.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header bg-transparent">
                        <h6 class="fw-bold mb-0">Basic Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Supplier Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                       id="name" name="name" value="{{ old('name') }}"
                                       placeholder="Enter supplier name" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="company_name" class="form-label">Company Name</label>
                                <input type="text" class="form-control @error('company_name') is-invalid @enderror"
                                       id="company_name" name="company_name" value="{{ old('company_name') }}"
                                       placeholder="Enter company name">
                                @error('company_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="contact_person" class="form-label">Contact Person</label>
                                <input type="text" class="form-control @error('contact_person') is-invalid @enderror"
                                       id="contact_person" name="contact_person" value="{{ old('contact_person') }}"
                                       placeholder="Full name">
                                @error('contact_person')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                       id="email" name="email" value="{{ old('email') }}"
                                       placeholder="supplier@company.com">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                       id="phone" name="phone" value="{{ old('phone') }}"
                                       placeholder="+1 (555) 123-4567">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="alternative_phone" class="form-label">Alternative Phone</label>
                                <input type="text" class="form-control @error('alternative_phone') is-invalid @enderror"
                                       id="alternative_phone" name="alternative_phone" value="{{ old('alternative_phone') }}"
                                       placeholder="Alternative contact number">
                                @error('alternative_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="website" class="form-label">Website</label>
                                <input type="url" class="form-control @error('website') is-invalid @enderror"
                                       id="website" name="website" value="{{ old('website') }}"
                                       placeholder="https://example.com">
                                @error('website')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description" name="description" rows="3"
                                      placeholder="Notes about the supplier">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header bg-transparent">
                        <h6 class="fw-bold mb-0">Business Registration</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="trade_license_number" class="form-label">Trade License Number</label>
                                <input type="text" class="form-control @error('trade_license_number') is-invalid @enderror"
                                       id="trade_license_number" name="trade_license_number" value="{{ old('trade_license_number') }}"
                                       placeholder="e.g., TL-2024-001">
                                @error('trade_license_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="tax_vat_number" class="form-label">Tax / VAT Number</label>
                                <input type="text" class="form-control @error('tax_vat_number') is-invalid @enderror"
                                       id="tax_vat_number" name="tax_vat_number" value="{{ old('tax_vat_number') }}"
                                       placeholder="e.g., VAT-12345678">
                                @error('tax_vat_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header bg-transparent">
                        <h6 class="fw-bold mb-0">Address Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="country" class="form-label">Country</label>
                                <input type="text" class="form-control @error('country') is-invalid @enderror"
                                       id="country" name="country" value="{{ old('country') }}"
                                       placeholder="e.g., United States">
                                @error('country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="state" class="form-label">State</label>
                                <input type="text" class="form-control @error('state') is-invalid @enderror"
                                       id="state" name="state" value="{{ old('state') }}"
                                       placeholder="e.g., California">
                                @error('state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="city" class="form-label">City</label>
                                <input type="text" class="form-control @error('city') is-invalid @enderror"
                                       id="city" name="city" value="{{ old('city') }}"
                                       placeholder="e.g., Los Angeles">
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="postal_code" class="form-label">Postal Code</label>
                                <input type="text" class="form-control @error('postal_code') is-invalid @enderror"
                                       id="postal_code" name="postal_code" value="{{ old('postal_code') }}"
                                       placeholder="e.g., 90001">
                                @error('postal_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-8 mb-3">
                                <label for="full_address" class="form-label">Full Address</label>
                                <textarea class="form-control @error('full_address') is-invalid @enderror"
                                          id="full_address" name="full_address" rows="2"
                                          placeholder="Street address, building, etc.">{{ old('full_address') }}</textarea>
                                @error('full_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header bg-transparent">
                        <h6 class="fw-bold mb-0">Purchase Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="payment_terms" class="form-label">Payment Terms</label>
                                <select class="form-select @error('payment_terms') is-invalid @enderror" id="payment_terms" name="payment_terms">
                                    <option value="">Select terms</option>
                                    <option value="Due on Receipt" {{ old('payment_terms') === 'Due on Receipt' ? 'selected' : '' }}>Due on Receipt</option>
                                    <option value="Net 15" {{ old('payment_terms') === 'Net 15' ? 'selected' : '' }}>Net 15</option>
                                    <option value="Net 30" {{ old('payment_terms') === 'Net 30' ? 'selected' : '' }}>Net 30</option>
                                    <option value="Net 45" {{ old('payment_terms') === 'Net 45' ? 'selected' : '' }}>Net 45</option>
                                    <option value="Net 60" {{ old('payment_terms') === 'Net 60' ? 'selected' : '' }}>Net 60</option>
                                    <option value="Net 90" {{ old('payment_terms') === 'Net 90' ? 'selected' : '' }}>Net 90</option>
                                </select>
                                @error('payment_terms')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="credit_limit" class="form-label">Credit Limit ($)</label>
                                <input type="number" step="0.01" min="0"
                                       class="form-control @error('credit_limit') is-invalid @enderror"
                                       id="credit_limit" name="credit_limit" value="{{ old('credit_limit') }}"
                                       placeholder="e.g., 10000.00">
                                @error('credit_limit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="currency" class="form-label">Currency</label>
                                <select class="form-select @error('currency') is-invalid @enderror" id="currency" name="currency">
                                    <option value="USD" {{ old('currency', 'USD') === 'USD' ? 'selected' : '' }}>USD - US Dollar</option>
                                    <option value="EUR" {{ old('currency') === 'EUR' ? 'selected' : '' }}>EUR - Euro</option>
                                    <option value="GBP" {{ old('currency') === 'GBP' ? 'selected' : '' }}>GBP - British Pound</option>
                                    <option value="BDT" {{ old('currency') === 'BDT' ? 'selected' : '' }}>BDT - Bangladeshi Taka</option>
                                    <option value="INR" {{ old('currency') === 'INR' ? 'selected' : '' }}>INR - Indian Rupee</option>
                                    <option value="CAD" {{ old('currency') === 'CAD' ? 'selected' : '' }}>CAD - Canadian Dollar</option>
                                    <option value="AUD" {{ old('currency') === 'AUD' ? 'selected' : '' }}>AUD - Australian Dollar</option>
                                </select>
                                @error('currency')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="bank_information" class="form-label">Bank Information</label>
                            <textarea class="form-control @error('bank_information') is-invalid @enderror"
                                      id="bank_information" name="bank_information" rows="3"
                                      placeholder="Bank name, account number, routing number, SWIFT/BIC, etc.">{{ old('bank_information') }}</textarea>
                            @error('bank_information')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="outstanding_balance" class="form-label">Opening Outstanding Balance ($)</label>
                                <input type="number" step="0.01" min="0"
                                       class="form-control @error('outstanding_balance') is-invalid @enderror"
                                       id="outstanding_balance" name="outstanding_balance"
                                       value="{{ old('outstanding_balance', 0) }}">
                                @error('outstanding_balance')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="last_purchase_date" class="form-label">Last Purchase Date</label>
                                <input type="date" class="form-control @error('last_purchase_date') is-invalid @enderror"
                                       id="last_purchase_date" name="last_purchase_date"
                                       value="{{ old('last_purchase_date') }}">
                                @error('last_purchase_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header bg-transparent">
                        <h6 class="fw-bold mb-0">Supplier Logo</h6>
                    </div>
                    <div class="card-body">
                        <div class="col-md-6">
                            <div class="dropzone-wrapper border rounded p-3 text-center bg-light"
                                 onclick="document.getElementById('logo').click()"
                                 ondragover="event.preventDefault()"
                                 ondrop="handleDrop(event, 'logo')">
                                <img id="logoPreview" src="#" alt="Preview"
                                     class="img-fluid rounded d-none mb-2" style="max-height: 150px;">
                                <i class="fas fa-image fa-3x text-muted" id="logoPlaceholder"></i>
                                <p class="text-muted small mt-2 mb-0" id="logoText">Click or drag logo here</p>
                            </div>
                            <input type="file" class="d-none" id="logo" name="logo"
                                   accept="image/*" onchange="previewImage(this, 'logo')">
                            <small class="text-muted d-block mt-2">JPG, PNG, WEBP. Max 2MB.</small>
                            @error('logo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header bg-transparent">
                        <h6 class="fw-bold mb-0">Status</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                                <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="blacklisted" {{ old('status') === 'blacklisted' ? 'selected' : '' }}>Blacklisted</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <small class="text-muted">Inactive suppliers won't appear in purchase orders</small>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header bg-transparent">
                        <h6 class="fw-bold mb-0">Supplier Code</h6>
                    </div>
                    <div class="card-body">
                        <p class="mb-0">
                            <span class="badge bg-dark fs-6 px-3 py-2">{{ \App\Models\Supplier::generateCode() }}</span>
                        </p>
                        <small class="text-muted d-block mt-2">Auto-generated unique code</small>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save me-2"></i> Create Supplier
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
