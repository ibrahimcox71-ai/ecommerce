<x-layouts.admin-layout title="Edit Brand">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Edit Brand</h4>
            <p class="text-muted small mb-0">Update brand information</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.brands.show', $brand->id) }}" class="btn btn-outline-info">
                <i class="fas fa-eye me-1"></i> View
            </a>
            <a href="{{ route('admin.brands.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.brands.update', $brand->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-4">
            {{-- Main Content --}}
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header bg-transparent">
                        <h6 class="fw-bold mb-0">Basic Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Brand Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                       id="name" name="name" value="{{ old('name', $brand->name) }}"
                                       placeholder="Enter brand name" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="brand_code" class="form-label">Brand Code</label>
                                <input type="text" class="form-control @error('brand_code') is-invalid @enderror"
                                       id="brand_code" name="brand_code" value="{{ old('brand_code', $brand->brand_code) }}"
                                       placeholder="e.g., BRN-001">
                                <small class="text-muted">Unique identifier code</small>
                                @error('brand_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Slug --}}
                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug</label>
                            <div class="input-group">
                                <span class="input-group-text">/</span>
                                <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                       id="slug" name="slug" value="{{ old('slug', $brand->slug) }}"
                                       placeholder="brand-slug">
                                <button type="button" class="btn btn-outline-secondary" onclick="generateSlug()">
                                    <i class="fas fa-sync-alt"></i>
                                </button>
                            </div>
                            <small class="text-muted">Leave empty to auto-generate from name</small>
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description" name="description" rows="4"
                                      placeholder="Brand description">{{ old('description', $brand->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Contact Info --}}
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="website" class="form-label">Website</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-globe"></i></span>
                                    <input type="url" class="form-control @error('website') is-invalid @enderror"
                                           id="website" name="website" value="{{ old('website', $brand->website) }}"
                                           placeholder="https://example.com">
                                </div>
                                @error('website')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                           id="email" name="email" value="{{ old('email', $brand->email) }}"
                                           placeholder="contact@brand.com">
                                </div>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                           id="phone" name="phone" value="{{ old('phone', $brand->phone) }}"
                                           placeholder="+1 (555) 123-4567">
                                </div>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Country --}}
                        <div class="mb-0">
                            <label for="country" class="form-label">Country</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                <input type="text" class="form-control @error('country') is-invalid @enderror"
                                       id="country" name="country" value="{{ old('country', $brand->country) }}"
                                       placeholder="e.g., United States">
                            </div>
                            @error('country')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Media Section --}}
                <div class="card mb-4">
                    <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold mb-0">Media</h6>
                        <button type="button" class="btn btn-sm btn-link p-0" data-bs-toggle="collapse" data-bs-target="#mediaCollapse">
                            <i class="fas fa-chevron-down"></i>
                        </button>
                    </div>
                    <div class="collapse show" id="mediaCollapse">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Brand Image</label>
                                    <div class="dropzone-wrapper border rounded p-3 text-center bg-light position-relative"
                                         onclick="document.getElementById('image').click()"
                                         ondragover="event.preventDefault()"
                                         ondrop="handleDrop(event, 'image')">
                                        @if($brand->image)
                                            <img id="imagePreview" src="{{ $brand->image_url }}" alt="{{ $brand->name }}"
                                                 class="img-fluid rounded mb-2" style="max-height: 120px;">
                                            <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2"
                                                    onclick="event.stopPropagation(); removeImage('image')">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        @else
                                            <img id="imagePreview" src="#" alt="Preview"
                                                 class="img-fluid rounded d-none mb-2" style="max-height: 120px;">
                                            <i class="fas fa-image fa-3x text-muted" id="imagePlaceholder"></i>
                                            <p class="text-muted small mt-2 mb-0" id="imageText">Click or drag</p>
                                        @endif
                                    </div>
                                    <input type="file" class="d-none" id="image" name="image"
                                           accept="image/*" onchange="previewImage(this, 'image')">
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="checkbox" id="remove_image" name="remove_image" value="1">
                                        <label class="form-check-label text-danger small" for="remove_image">
                                            Remove current image
                                        </label>
                                    </div>
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Brand Logo</label>
                                    <div class="dropzone-wrapper border rounded p-3 text-center bg-light position-relative"
                                         onclick="document.getElementById('logo').click()"
                                         ondragover="event.preventDefault()"
                                         ondrop="handleDrop(event, 'logo')">
                                        @if($brand->logo)
                                            <img id="logoPreview" src="{{ $brand->logo_url }}" alt="{{ $brand->name }}"
                                                 class="img-fluid rounded mb-2" style="max-height: 120px;">
                                            <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2"
                                                    onclick="event.stopPropagation(); removeImage('logo')">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        @else
                                            <img id="logoPreview" src="#" alt="Preview"
                                                 class="img-fluid rounded d-none mb-2" style="max-height: 120px;">
                                            <i class="fas fa-building fa-3x text-muted" id="logoPlaceholder"></i>
                                            <p class="text-muted small mt-2 mb-0" id="logoText">Click or drag</p>
                                        @endif
                                    </div>
                                    <input type="file" class="d-none" id="logo" name="logo"
                                           accept="image/*" onchange="previewImage(this, 'logo')">
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="checkbox" id="remove_logo" name="remove_logo" value="1">
                                        <label class="form-check-label text-danger small" for="remove_logo">
                                            Remove current logo
                                        </label>
                                    </div>
                                    @error('logo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Banner Image</label>
                                    <div class="dropzone-wrapper border rounded p-3 text-center bg-light position-relative"
                                         onclick="document.getElementById('banner').click()"
                                         ondragover="event.preventDefault()"
                                         ondrop="handleDrop(event, 'banner')">
                                        @if($brand->banner)
                                            <img id="bannerPreview" src="{{ $brand->banner_url }}" alt="{{ $brand->name }}"
                                                 class="img-fluid rounded mb-2" style="max-height: 120px;">
                                            <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2"
                                                    onclick="event.stopPropagation(); removeImage('banner')">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        @else
                                            <img id="bannerPreview" src="#" alt="Preview"
                                                 class="img-fluid rounded d-none mb-2" style="max-height: 120px;">
                                            <i class="fas fa-image fa-3x text-muted" id="bannerPlaceholder"></i>
                                            <p class="text-muted small mt-2 mb-0" id="bannerText">Click or drag</p>
                                        @endif
                                    </div>
                                    <input type="file" class="d-none" id="banner" name="banner"
                                           accept="image/*" onchange="previewImage(this, 'banner')">
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="checkbox" id="remove_banner" name="remove_banner" value="1">
                                        <label class="form-check-label text-danger small" for="remove_banner">
                                            Remove current banner
                                        </label>
                                    </div>
                                    @error('banner')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SEO Section --}}
                <div class="card mb-4">
                    <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold mb-0">SEO Settings</h6>
                        <button type="button" class="btn btn-sm btn-link p-0" data-bs-toggle="collapse" data-bs-target="#seoCollapse">
                            <i class="fas fa-chevron-down"></i>
                        </button>
                    </div>
                    <div class="collapse show" id="seoCollapse">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="meta_title" class="form-label">Meta Title</label>
                                    <input type="text" class="form-control @error('meta_title') is-invalid @enderror"
                                           id="meta_title" name="meta_title" value="{{ old('meta_title', $brand->meta_title) }}"
                                           placeholder="SEO title">
                                    <small class="text-muted">Recommended: 50-60 characters</small>
                                    @error('meta_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="canonical_url" class="form-label">Canonical URL</label>
                                    <input type="url" class="form-control @error('canonical_url') is-invalid @enderror"
                                           id="canonical_url" name="canonical_url" value="{{ old('canonical_url', $brand->canonical_url) }}"
                                           placeholder="https://example.com/brand-page">
                                    <small class="text-muted">Preferred URL for SEO</small>
                                    @error('canonical_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="meta_description" class="form-label">Meta Description</label>
                                <textarea class="form-control @error('meta_description') is-invalid @enderror"
                                          id="meta_description" name="meta_description" rows="3"
                                          placeholder="SEO description">{{ old('meta_description', $brand->meta_description) }}</textarea>
                                <small class="text-muted">Recommended: 150-160 characters</small>
                                @error('meta_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="meta_keywords" class="form-label">Meta Keywords</label>
                                <input type="text" class="form-control @error('meta_keywords') is-invalid @enderror"
                                       id="meta_keywords" name="meta_keywords" value="{{ old('meta_keywords', $brand->meta_keywords) }}"
                                       placeholder="keyword1, keyword2, keyword3">
                                <small class="text-muted">Comma-separated keywords</small>
                                @error('meta_keywords')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-0">
                                <label class="form-label">Open Graph Image</label>
                                <div class="dropzone-wrapper border rounded p-3 text-center bg-light position-relative"
                                     onclick="document.getElementById('og_image').click()"
                                     ondragover="event.preventDefault()"
                                     ondrop="handleDrop(event, 'og_image')">
                                    @if($brand->og_image)
                                        <img id="og_imagePreview" src="{{ $brand->og_image_url }}" alt="OG Image"
                                             class="img-fluid rounded mb-2" style="max-height: 120px;">
                                        <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2"
                                                onclick="event.stopPropagation(); removeImage('og_image')">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    @else
                                        <img id="og_imagePreview" src="#" alt="Preview"
                                             class="img-fluid rounded d-none mb-2" style="max-height: 120px;">
                                        <i class="fas fa-share-alt fa-3x text-muted" id="og_imagePlaceholder"></i>
                                        <p class="text-muted small mt-2 mb-0" id="og_imageText">Click or drag</p>
                                    @endif
                                </div>
                                <input type="file" class="d-none" id="og_image" name="og_image"
                                       accept="image/*" onchange="previewImage(this, 'og_image')">
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" id="remove_og_image" name="remove_og_image" value="1">
                                    <label class="form-check-label text-danger small" for="remove_og_image">
                                        Remove current image
                                    </label>
                                </div>
                                <small class="text-muted d-block mt-2">JPG, PNG, WEBP. Max 2MB. 1200x630px recommended</small>
                                @error('og_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Activity Log --}}
                <div class="card">
                    <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold mb-0">Activity Log</h6>
                    </div>
                    <div class="card-body">
                        <div class="timeline timeline-simple">
                            <div class="tm-item">
                                <div class="tmtm-inner">
                                    <div class="tm-group">
                                        <span class="badge bg-success">Created</span>
                                        <span class="small text-muted ms-2">{{ $brand->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="small mb-0">By {{ $brand->activityLogs()->where('description', 'like', '%created%')->first()?->causer?->name ?? 'System' }}</p>
                                </div>
                            </div>
                            <div class="tm-item">
                                <div class="tmtm-inner">
                                    <div class="tm-group">
                                        <span class="badge bg-info">Updated</span>
                                        <span class="small text-muted ms-2">{{ $brand->updated_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="small mb-0">By {{ $brand->activityLogs()->where('description', 'like', '%updated%')->first()?->causer?->name ?? 'System' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="col-lg-4">
                {{-- Status & Flags --}}
                <div class="card mb-4">
                    <div class="card-header bg-transparent">
                        <h6 class="fw-bold mb-0">Status & Visibility</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                                <option value="active" {{ old('status', $brand->status->value) === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $brand->status->value) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="hidden" {{ old('status', $brand->status->value) === 'hidden' ? 'selected' : '' }}>Hidden</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label d-block">Flags</label>
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" id="featured" name="featured" value="1"
                                       {{ old('featured', $brand->featured) ? 'checked' : '' }}>
                                <label class="form-check-label" for="featured">
                                    <i class="fas fa-star text-warning me-1"></i> Featured
                                </label>
                            </div>
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" id="popular" name="popular" value="1"
                                       {{ old('popular', $brand->popular) ? 'checked' : '' }}>
                                <label class="form-check-label" for="popular">
                                    <i class="fas fa-fire text-info me-1"></i> Popular
                                </label>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_hidden" name="is_hidden" value="1"
                                       {{ old('is_hidden', $brand->is_hidden) ? 'checked' : '' }}>
                                <label class="form-check-label text-muted" for="is_hidden">
                                    <i class="fas fa-eye-slash me-1"></i> Hidden from listings
                                </label>
                            </div>
                        </div>

                        <div class="mb-0">
                            <label for="sort_order" class="form-label">Sort Order</label>
                            <input type="number" class="form-control @error('sort_order') is-invalid @enderror"
                                   id="sort_order" name="sort_order" value="{{ old('sort_order', $brand->sort_order) }}" min="0">
                            <small class="text-muted">Lower numbers appear first</small>
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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
                            <span class="text-muted">Total Products</span>
                            <span class="badge bg-primary">{{ $brand->products_count }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Brand Code</span>
                            <span class="small">{{ $brand->brand_code ?? '—' }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Created</span>
                            <span class="small">{{ $brand->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save me-2"></i> Update Brand
                    </button>
                    <button type="button" class="btn btn-outline-info" onclick="duplicateBrand()">
                        <i class="fas fa-copy me-2"></i> Duplicate Brand
                    </button>
                    <button type="button" class="btn btn-outline-danger" onclick="confirmDelete()">
                        <i class="fas fa-trash me-2"></i> Delete Brand
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
                <h5 class="modal-title">Delete Brand</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete <strong>{{ $brand->name }}</strong>?</p>
                @if($brand->products()->count() > 0)
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        This brand has {{ $brand->products()->count() }} products. Please remove them first.
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('admin.brands.destroy', $brand->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" {{ $brand->products()->count() > 0 ? 'disabled' : '' }}>
                        <i class="fas fa-trash me-1"></i> Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function generateSlug() {
    const name = $('#name').val();
    if (name) {
        $('#slug').val(name.toLowerCase()
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/(^-|-$)/g, '')
        );
    }
}

$('#name').on('input', function() {
    if (!$('#slug').data('manual')) {
        generateSlug();
    }
});

$('#slug').on('input', function() {
    $(this).data('manual', true);
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

$('#remove_image').change(function() {
    if ($(this).prop('checked')) {
        $('#image').val('');
        $('#imagePreview').addClass('d-none');
        $('#imagePlaceholder').removeClass('d-none');
        $('#imageText').text('Click or drag');
    }
});

$('#remove_logo').change(function() {
    if ($(this).prop('checked')) {
        $('#logo').val('');
        $('#logoPreview').addClass('d-none');
        $('#logoPlaceholder').removeClass('d-none');
        $('#logoText').text('Click or drag');
    }
});

$('#remove_banner').change(function() {
    if ($(this).prop('checked')) {
        $('#banner').val('');
        $('#bannerPreview').addClass('d-none');
        $('#bannerPlaceholder').removeClass('d-none');
        $('#bannerText').text('Click or drag');
    }
});

$('#remove_og_image').change(function() {
    if ($(this).prop('checked')) {
        $('#og_image').val('');
        $('#og_imagePreview').addClass('d-none');
        $('#og_imagePlaceholder').removeClass('d-none');
        $('#og_imageText').text('Click or drag');
    }
});

function removeImage(type) {
    const checkbox = $('#remove_' + type);
    checkbox.prop('checked', true);
    $('#' + type + 'Preview').addClass('d-none');
    $('#' + type + 'Placeholder').removeClass('d-none');
    $('#' + type + 'Text').text('Click or drag');
}

function duplicateBrand() {
    $('<form>').attr({ method: 'POST', action: `/admin/brands/{{ $brand->id }}/duplicate` })
        .append($('<input>').attr({ type: 'hidden', name: '_token', value: '{{ csrf_token() }}' }))
        .appendTo('body').submit();
}

function confirmDelete() {
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>
@endpush
