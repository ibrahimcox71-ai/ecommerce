<x-layouts.admin-layout title="Edit Category">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Edit Category</h4>
            <p class="text-muted small mb-0">Update category information</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.categories.show', $category->id) }}" class="btn btn-outline-info">
                <i class="fas fa-eye me-1"></i> View
            </a>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.categories.update', $category->id) }}" enctype="multipart/form-data" id="categoryForm">
        @csrf
        @method('PUT')

        <div class="row g-4">
            <div class="col-lg-8">
                {{-- Basic Information --}}
                <div class="card mb-4">
                    <div class="card-header bg-transparent">
                        <h6 class="fw-bold mb-0">Basic Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Category Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ old('name', $category->name) }}"
                                   placeholder="Enter category name" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="slug" class="form-label">Slug</label>
                                    <div class="input-group">
                                        <span class="input-group-text">/</span>
                                        <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                               id="slug" name="slug" value="{{ old('slug', $category->slug) }}"
                                               placeholder="category-slug">
                                        <button type="button" class="btn btn-outline-secondary" onclick="generateSlug()" title="Regenerate">
                                            <i class="fas fa-sync-alt"></i>
                                        </button>
                                    </div>
                                    <small class="text-muted">Leave empty to auto-generate from name</small>
                                    @error('slug')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="category_code" class="form-label">Category Code</label>
                                    <input type="text" class="form-control @error('category_code') is-invalid @enderror"
                                           id="category_code" name="category_code" value="{{ old('category_code', $category->category_code) }}"
                                           placeholder="CAT-001">
                                    <small class="text-muted">Unique identifier</small>
                                    @error('category_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="short_description" class="form-label">Short Description</label>
                            <textarea class="form-control @error('short_description') is-invalid @enderror"
                                      id="short_description" name="short_description" rows="2"
                                      placeholder="Brief description (max 500 chars)">{{ old('short_description', $category->short_description) }}</textarea>
                            <small class="text-muted">Displayed in category cards and listings</small>
                            @error('short_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-0">
                            <label for="description" class="form-label">Full Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description" name="description" rows="5"
                                      placeholder="Detailed category description">{{ old('description', $category->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- SEO Settings --}}
                <div class="card mb-4">
                    <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold mb-0">SEO Settings</h6>
                        <span class="badge bg-info">Boosts Rankings</span>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="meta_title" class="form-label">SEO Title</label>
                                    <input type="text" class="form-control @error('meta_title') is-invalid @enderror"
                                           id="meta_title" name="meta_title" value="{{ old('meta_title', $category->meta_title) }}"
                                           placeholder="SEO title" maxlength="255">
                                    <small class="text-muted">Recommended: 50-60 characters</small>
                                    @error('meta_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="canonical_url" class="form-label">Canonical URL</label>
                                    <input type="url" class="form-control @error('canonical_url') is-invalid @enderror"
                                           id="canonical_url" name="canonical_url" value="{{ old('canonical_url', $category->canonical_url) }}"
                                           placeholder="https://example.com/category">
                                    <small class="text-muted">Preferred version of this page</small>
                                    @error('canonical_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="meta_description" class="form-label">Meta Description</label>
                            <textarea class="form-control @error('meta_description') is-invalid @enderror"
                                      id="meta_description" name="meta_description" rows="2"
                                      placeholder="SEO meta description">{{ old('meta_description', $category->meta_description) }}</textarea>
                            <small class="text-muted">Recommended: 150-160 characters</small>
                            @error('meta_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-0">
                            <label for="meta_keywords" class="form-label">Meta Keywords</label>
                            <input type="text" class="form-control @error('meta_keywords') is-invalid @enderror"
                                   id="meta_keywords" name="meta_keywords" value="{{ old('meta_keywords', $category->meta_keywords) }}"
                                   placeholder="keyword1, keyword2, keyword3">
                            <small class="text-muted">Comma-separated keywords</small>
                            @error('meta_keywords')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Activity Log --}}
                <div class="card">
                    <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold mb-0">Activity Log</h6>
                        <small class="text-muted">Last 10 actions</small>
                    </div>
                    <div class="card-body p-0">
                        @php
                            $activities = $category->activityLogs()->latest()->take(10)->get();
                        @endphp
                        @if($activities->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="border-0 ps-4">Action</th>
                                            <th class="border-0">Details</th>
                                            <th class="border-0 pe-4 text-end">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($activities as $log)
                                            <tr>
                                                <td class="ps-4">
                                                    <span class="badge bg-{{ str_contains($log->description, 'created') ? 'success' : (str_contains($log->description, 'restored') ? 'info' : 'secondary') }}">
                                                        {{ $log->description }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if($log->properties)
                                                        @foreach($log->properties as $key => $value)
                                                            <small class="text-muted me-2">{{ $key }}: {{ is_array($value) ? json_encode($value) : $value }}</small>
                                                        @endforeach
                                                    @endif
                                                </td>
                                                <td class="pe-4 text-end text-muted small">
                                                    {{ $log->created_at->format('M d, Y H:i') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4 text-muted">
                                <i class="fas fa-history fa-2x mb-2"></i>
                                <p class="mb-0">No activity recorded yet</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                {{-- Media --}}
                <div class="card mb-4">
                    <div class="card-header bg-transparent">
                        <h6 class="fw-bold mb-0">Media</h6>
                    </div>
                    <div class="card-body">
                        <x-admin.category.media-uploader
                            name="image"
                            label="Category Image"
                            :currentImage="$category->image_url"
                            accept="image/*"
                            maxSize="2MB"
                            recommended="512x512px"
                            :removable="true"
                            removeName="remove_image"
                        />

                        <x-admin.category.media-uploader
                            name="thumbnail"
                            label="Thumbnail"
                            :currentImage="$category->thumbnail_url"
                            accept="image/*"
                            maxSize="1MB"
                            recommended="300x300px"
                            helpText="Small preview image. JPG, PNG, WEBP. Max 1MB."
                            :removable="true"
                            removeName="remove_thumbnail"
                        />

                        <x-admin.category.media-uploader
                            name="banner"
                            label="Banner"
                            :currentImage="$category->banner_url"
                            accept="image/*"
                            maxSize="5MB"
                            recommended="1200x400px"
                            helpText="Category page banner. JPG, PNG, WEBP. Max 5MB."
                            :removable="true"
                            removeName="remove_banner"
                        />

                        <x-admin.category.media-uploader
                            name="seo_image"
                            label="SEO Image (OG)"
                            :currentImage="$category->seo_image_url"
                            accept="image/*"
                            maxSize="2MB"
                            recommended="1200x630px"
                            helpText="Open Graph image for social sharing. JPG, PNG, WEBP. Max 2MB."
                            :removable="true"
                            removeName="remove_seo_image"
                        />

                        <div class="mb-0">
                            <label for="icon" class="form-label">Icon Class</label>
                            <input type="text" class="form-control @error('icon') is-invalid @enderror"
                                   id="icon" name="icon" value="{{ old('icon', $category->icon) }}"
                                   placeholder="fas fa-tag">
                            <small class="text-muted">Font Awesome icon class</small>
                            @error('icon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Organization --}}
                <div class="card mb-4">
                    <div class="card-header bg-transparent">
                        <h6 class="fw-bold mb-0">Organization</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="parent_id" class="form-label">Parent Category</label>
                            <select class="form-select @error('parent_id') is-invalid @enderror" id="parent_id" name="parent_id">
                                <option value="">None (Top Level)</option>
                                @foreach($parentCategories as $parent)
                                    <option value="{{ $parent->id }}" {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>
                                        {{ $parent->name }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">Select parent to create a subcategory</small>
                            @error('parent_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="sort_order" class="form-label">Sort Order</label>
                            <input type="number" class="form-control @error('sort_order') is-invalid @enderror"
                                   id="sort_order" name="sort_order" value="{{ old('sort_order', $category->sort_order) }}" min="0">
                            <small class="text-muted">Lower numbers appear first</small>
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-0">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                                <option value="active" {{ old('status', $category->status) === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $category->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="draft" {{ old('status', $category->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="hidden" {{ old('status', $category->status) === 'hidden' ? 'selected' : '' }}>Hidden</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Display Settings --}}
                <div class="card mb-4">
                    <div class="card-header bg-transparent">
                        <h6 class="fw-bold mb-0">Display Settings</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="featured" name="featured" value="1"
                                       {{ old('featured', $category->featured) ? 'checked' : '' }}>
                                <label class="form-check-label" for="featured">Featured Category</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="popular" name="popular" value="1"
                                       {{ old('popular', $category->popular) ? 'checked' : '' }}>
                                <label class="form-check-label" for="popular">Popular Category</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="show_on_homepage" name="show_on_homepage" value="1"
                                       {{ old('show_on_homepage', $category->show_on_homepage) ? 'checked' : '' }}>
                                <label class="form-check-label" for="show_on_homepage">Show on Homepage</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="show_in_mega_menu" name="show_in_mega_menu" value="1"
                                       {{ old('show_in_mega_menu', $category->show_in_mega_menu) ? 'checked' : '' }}>
                                <label class="form-check-label" for="show_in_mega_menu">Show in Mega Menu</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="show_in_mobile_menu" name="show_in_mobile_menu" value="1"
                                       {{ old('show_in_mobile_menu', $category->show_in_mobile_menu) ? 'checked' : '' }}>
                                <label class="form-check-label" for="show_in_mobile_menu">Show in Mobile Menu</label>
                            </div>
                        </div>
                        <div class="mb-0">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="show_in_sidebar" name="show_in_sidebar" value="1"
                                       {{ old('show_in_sidebar', $category->show_in_sidebar) ? 'checked' : '' }}>
                                <label class="form-check-label" for="show_in_sidebar">Show in Sidebar</label>
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
                            <span class="text-muted">Subcategories</span>
                            <span class="badge bg-secondary">{{ $category->children_count }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Active Products</span>
                            <span class="badge bg-success">{{ $category->active_product_count }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Total Products</span>
                            <span class="badge bg-primary">{{ $category->product_count }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Sort Order</span>
                            <span class="small">#{{ $category->sort_order }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Created</span>
                            <span class="small">{{ $category->created_at->format('M d, Y') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-0">
                            <span class="text-muted">Updated</span>
                            <span class="small">{{ $category->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>

                {{-- Danger Zone --}}
                <div class="card border-danger mb-4">
                    <div class="card-header bg-transparent border-danger">
                        <h6 class="fw-bold mb-0 text-danger"><i class="fas fa-exclamation-triangle me-2"></i>Danger Zone</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="button" class="btn btn-outline-info" onclick="duplicateCategory()">
                                <i class="fas fa-copy me-2"></i> Duplicate Category
                            </button>
                            <button type="button" class="btn btn-outline-danger" onclick="confirmDelete()">
                                <i class="fas fa-trash me-2"></i> Delete Category
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save me-2"></i> Update Category
                    </button>
                </div>
            </div>
        </div>
    </form>

</x-layouts.admin-layout>

{{-- Delete Modal --}}
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete <strong>{{ $category->name }}</strong>?</p>
                @if($category->children_count > 0 || $category->product_count > 0)
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        This category has
                        @if($category->children_count > 0){{ $category->children_count }} subcategory(ies)@endif
                        @if($category->children_count > 0 && $category->product_count > 0) and @endif
                        @if($category->product_count > 0){{ $category->product_count }} product(s)@endif.
                        Remove them first.
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.categories.show', $category->id) }}?move_products=1" class="btn btn-warning">
                        <i class="fas fa-arrows-alt me-1"></i> Move Products
                    </a>
                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger"
                                {{ $category->children_count > 0 || $category->product_count > 0 ? 'disabled' : '' }}>
                            <i class="fas fa-trash me-1"></i> Delete
                        </button>
                    </form>
                </div>
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

function confirmDelete() {
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}

function duplicateCategory() {
    $('<form>').attr({ method: 'POST', action: '{{ route('admin.categories.duplicate', $category->id) }}' })
        .append($('<input>').attr({ type: 'hidden', name: '_token', value: '{{ csrf_token() }}' }))
        .appendTo('body').submit();
}
</script>
@endpush
