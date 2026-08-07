<x-layouts.admin-layout title="Create Brand">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Create Brand</h4>
            <p class="text-muted small mb-0">Add a new product brand</p>
        </div>
        <a href="{{ route('admin.brands.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>

    <form method="POST" action="{{ route('admin.brands.store') }}" enctype="multipart/form-data">
        @csrf

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
                                       id="name" name="name" value="{{ old('name') }}"
                                       placeholder="Enter brand name" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="brand_code" class="form-label">Brand Code</label>
                                <input type="text" class="form-control @error('brand_code') is-invalid @enderror"
                                       id="brand_code" name="brand_code" value="{{ old('brand_code') }}"
                                       placeholder="e.g., BRN-001">
                                <small class="text-muted">Unique identifier code (optional)</small>
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
                                       id="slug" name="slug" value="{{ old('slug') }}"
                                       placeholder="auto-generated-from-name">
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
                                      placeholder="Brand description">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Contact Info --}}
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="website" class="form-label">Website</label>
                                <input type="url" class="form-control @error('website') is-invalid @enderror"
                                       id="website" name="website" value="{{ old('website') }}"
                                       placeholder="https://example.com">
                                @error('website')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                       id="email" name="email" value="{{ old('email') }}"
                                       placeholder="contact@brand.com">
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

                        {{-- Country --}}
                        <div class="mb-0">
                            <label for="country" class="form-label">Country</label>
                            <input type="text" class="form-control @error('country') is-invalid @enderror"
                                   id="country" name="country" value="{{ old('country') }}"
                                   placeholder="e.g., United States">
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
                                <div class="col-md-6 mb-3">
                                    <label for="image" class="form-label">Brand Image</label>
                                    <div class="dropzone-wrapper border rounded p-3 text-center bg-light"
                                         onclick="document.getElementById('image').click()"
                                         ondragover="event.preventDefault()"
                                         ondrop="handleDrop(event, 'image')">
                                        <img id="imagePreview" src="#" alt="Preview"
                                             class="img-fluid rounded d-none mb-2" style="max-height: 150px;">
                                        <i class="fas fa-image fa-3x text-muted" id="imagePlaceholder"></i>
                                        <p class="text-muted small mt-2 mb-0" id="imageText">Click or drag image here</p>
                                    </div>
                                    <input type="file" class="d-none" id="image" name="image"
                                           accept="image/*" onchange="previewImage(this, 'image')">
                                    <small class="text-muted d-block mt-2">JPG, PNG, WEBP, SVG. Max 2MB</small>
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="logo" class="form-label">Brand Logo</label>
                                    <div class="dropzone-wrapper border rounded p-3 text-center bg-light"
                                         onclick="document.getElementById('logo').click()"
                                         ondragover="event.preventDefault()"
                                         ondrop="handleDrop(event, 'logo')">
                                        <img id="logoPreview" src="#" alt="Preview"
                                             class="img-fluid rounded d-none mb-2" style="max-height: 150px;">
                                        <i class="fas fa-building fa-3x text-muted" id="logoPlaceholder"></i>
                                        <p class="text-muted small mt-2 mb-0" id="logoText">Click or drag logo here</p>
                                    </div>
                                    <input type="file" class="d-none" id="logo" name="logo"
                                           accept="image/*" onchange="previewImage(this, 'logo')">
                                    <small class="text-muted d-block mt-2">JPG, PNG, WEBP, SVG. Max 2MB. 512x512px recommended</small>
                                    @error('logo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-0">
                                <label for="banner" class="form-label">Banner Image</label>
                                <div class="dropzone-wrapper border rounded p-3 text-center bg-light"
                                     onclick="document.getElementById('banner').click()"
                                     ondragover="event.preventDefault()"
                                     ondrop="handleDrop(event, 'banner')">
                                    <img id="bannerPreview" src="#" alt="Preview"
                                         class="img-fluid rounded d-none mb-2" style="max-height: 150px;">
                                    <i class="fas fa-image fa-3x text-muted" id="bannerPlaceholder"></i>
                                    <p class="text-muted small mt-2 mb-0" id="bannerText">Click or drag banner here</p>
                                </div>
                                <input type="file" class="d-none" id="banner" name="banner"
                                       accept="image/*" onchange="previewImage(this, 'banner')">
                                <small class="text-muted d-block mt-2">JPG, PNG, WEBP. Max 3MB. 1200x400px recommended</small>
                                @error('banner')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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
                                           id="meta_title" name="meta_title" value="{{ old('meta_title') }}"
                                           placeholder="SEO title (defaults to brand name)">
                                    <small class="text-muted">Recommended: 50-60 characters</small>
                                    @error('meta_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="canonical_url" class="form-label">Canonical URL</label>
                                    <input type="url" class="form-control @error('canonical_url') is-invalid @enderror"
                                           id="canonical_url" name="canonical_url" value="{{ old('canonical_url') }}"
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
                                          placeholder="SEO description (optional)">{{ old('meta_description') }}</textarea>
                                <small class="text-muted">Recommended: 150-160 characters</small>
                                @error('meta_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="meta_keywords" class="form-label">Meta Keywords</label>
                                <input type="text" class="form-control @error('meta_keywords') is-invalid @enderror"
                                       id="meta_keywords" name="meta_keywords" value="{{ old('meta_keywords') }}"
                                       placeholder="keyword1, keyword2, keyword3">
                                <small class="text-muted">Comma-separated keywords</small>
                                @error('meta_keywords')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-0">
                                <label for="og_image" class="form-label">Open Graph Image</label>
                                <div class="dropzone-wrapper border rounded p-3 text-center bg-light"
                                     onclick="document.getElementById('og_image').click()"
                                     ondragover="event.preventDefault()"
                                     ondrop="handleDrop(event, 'og_image')">
                                    <img id="og_imagePreview" src="#" alt="Preview"
                                         class="img-fluid rounded d-none mb-2" style="max-height: 150px;">
                                    <i class="fas fa-share-alt fa-3x text-muted" id="og_imagePlaceholder"></i>
                                    <p class="text-muted small mt-2 mb-0" id="og_imageText">Click or drag image here</p>
                                </div>
                                <input type="file" class="d-none" id="og_image" name="og_image"
                                       accept="image/*" onchange="previewImage(this, 'og_image')">
                                <small class="text-muted d-block mt-2">JPG, PNG, WEBP. Max 2MB. 1200x630px recommended</small>
                                @error('og_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="col-lg-4">
                {{-- Status --}}
                <div class="card mb-4">
                    <div class="card-header bg-transparent">
                        <h6 class="fw-bold mb-0">Status & Visibility</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                                <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="hidden" {{ old('status') === 'hidden' ? 'selected' : '' }}>Hidden</option>
                            </select>
                            <small class="text-muted">Control brand visibility on the storefront</small>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label d-block">Flags</label>
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" id="featured" name="featured" value="1"
                                       {{ old('featured') ? 'checked' : '' }}>
                                <label class="form-check-label" for="featured">
                                    <i class="fas fa-star text-warning me-1"></i> Featured Brand
                                </label>
                            </div>
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" id="popular" name="popular" value="1"
                                       {{ old('popular') ? 'checked' : '' }}>
                                <label class="form-check-label" for="popular">
                                    <i class="fas fa-fire text-info me-1"></i> Popular Brand
                                </label>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_hidden" name="is_hidden" value="1"
                                       {{ old('is_hidden') ? 'checked' : '' }}>
                                <label class="form-check-label text-muted" for="is_hidden">
                                    <i class="fas fa-eye-slash me-1"></i> Hidden from listings
                                </label>
                            </div>
                        </div>

                        {{-- Sort Order --}}
                        <div class="mb-0">
                            <label for="sort_order" class="form-label">Sort Order</label>
                            <input type="number" class="form-control @error('sort_order') is-invalid @enderror"
                                   id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
                            <small class="text-muted">Lower numbers appear first</small>
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save me-2"></i> Create Brand
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
