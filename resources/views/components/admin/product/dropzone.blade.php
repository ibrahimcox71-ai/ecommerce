@props(['name' => 'gallery', 'multiple' => true, 'accept' => 'image/*', 'label' => 'Drop images here or click to upload', 'existing' => [], 'primaryImageId' => null])

<div class="product-dropzone-wrapper">
    <div class="product-dropzone" id="dropzone-{{ $name }}" data-name="{{ $name }}" data-multiple="{{ $multiple ? 'true' : 'false' }}" tabindex="0" role="button" aria-label="{{ $label }}">
        <div class="dropzone-message">
            <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3" aria-hidden="true"></i>
            <p class="mb-1 fw-semibold">{{ $label }}</p>
            <small class="text-muted">Supported: JPEG, PNG, JPG, GIF, WebP (Max 5MB each)</small>
        </div>
        <div class="dropzone-preview row g-2 mt-3" id="preview-{{ $name }}">
            @foreach($existing as $image)
                <div class="col-auto existing-image" data-id="{{ $image['id'] ?? '' }}" data-image="{{ $image['image'] ?? '' }}">
                    <div class="product-image-item {{ ($image['is_primary'] ?? false) ? 'primary' : '' }}">
                        <img src="{{ $image['url'] ?? $image['image'] }}" alt="{{ $image['alt_text'] ?? '' }}">
                        <div class="image-actions">
                            @if(!($image['is_primary'] ?? false))
                                <button type="button" class="btn btn-sm btn-light set-primary" title="Set as Primary" aria-label="Set as primary image">
                                    <i class="fas fa-star" aria-hidden="true"></i>
                                </button>
                            @endif
                            <button type="button" class="btn btn-sm btn-danger remove-image" title="Remove" aria-label="Remove image">
                                <i class="fas fa-times" aria-hidden="true"></i>
                            </button>
                        </div>
                        @if($image['is_primary'] ?? false)
                            <div class="primary-badge">Primary</div>
                        @endif
                        <input type="hidden" name="images[{{ $loop->index ?? 0 }}][id]" value="{{ $image['id'] ?? '' }}">
                        <input type="hidden" name="images[{{ $loop->index ?? 0 }}][image]" value="{{ $image['image'] ?? '' }}">
                        <input type="hidden" name="images[{{ $loop->index ?? 0 }}][is_primary]" value="{{ ($image['is_primary'] ?? false) ? '1' : '0' }}">
                        <input type="hidden" name="images[{{ $loop->index ?? 0 }}][sort_order]" value="{{ $loop->index ?? 0 }}">
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <input type="file" name="{{ $name }}[]" id="fileInput-{{ $name }}" accept="{{ $accept }}" {{ $multiple ? 'multiple' : '' }} class="d-none" aria-label="Choose files to upload">
</div>
