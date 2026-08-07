@props([
    'name' => 'image',
    'label' => 'Image',
    'currentImage' => null,
    'accept' => 'image/*',
    'maxSize' => '2MB',
    'recommended' => '512x512px',
    'helpText' => null,
    'removable' => false,
    'removeName' => 'remove_image',
])

<div class="mb-3">
    <label class="form-label fw-medium">{{ $label }}</label>

    <div class="border rounded-3 p-3 text-center bg-light-subtle upload-zone"
         id="previewContainer_{{ $name }}"
         tabindex="0"
         role="button"
         aria-label="Click or drop to upload {{ $label }}"
         ondragover="event.preventDefault()"
         ondrop="handleMediaDrop(event, '{{ $name }}')">
        @if($currentImage)
            <img id="preview_{{ $name }}"
                 src="{{ $currentImage }}"
                 alt="{{ $label }} preview"
                 class="img-fluid rounded mb-2 upload-preview">
        @else
            <img id="preview_{{ $name }}"
                 src="#"
                 alt="{{ $label }} preview"
                 class="img-fluid rounded mb-2 d-none upload-preview">
        @endif
        <div id="placeholder_{{ $name }}" class="py-3 {{ $currentImage ? 'd-none' : '' }}">
            <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-2" aria-hidden="true"></i>
            <p class="text-muted small mb-0">Drop file here or click to browse</p>
        </div>
    </div>

    <input type="file"
           class="form-control mt-2 @error($name) is-invalid @enderror"
           id="input_{{ $name }}"
           name="{{ $name }}"
           accept="{{ $accept }}"
           aria-label="Choose {{ $label }} file"
           onchange="previewMediaFile(this, '{{ $name }}')">

    <div class="d-flex justify-content-between align-items-start mt-1">
        <small class="text-muted">
            {{ $helpText ?? "Accepted: JPG, PNG, WEBP. Max {$maxSize}. Recommended: {$recommended}" }}
        </small>
        @if($removable && $currentImage)
            <div class="form-check ms-2">
                <input class="form-check-input" type="checkbox"
                       id="{{ $removeName }}"
                       name="{{ $removeName }}" value="1"
                       onchange="toggleRemoveMedia('{{ $name }}', this)">
                <label class="form-check-label text-danger small" for="{{ $removeName }}">
                    <i class="fas fa-trash-alt me-1" aria-hidden="true"></i>Remove
                </label>
            </div>
        @endif
    </div>

    @error($name)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>

@push('scripts')
<script>
function previewMediaFile(input, name) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('preview_' + name);
            preview.src = e.target.result;
            preview.classList.remove('d-none');
            document.getElementById('placeholder_' + name).classList.add('d-none');
            const removeCheckbox = document.getElementById('{{ $removeName }}');
            if (removeCheckbox) removeCheckbox.checked = false;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function handleMediaDrop(event, name) {
    event.preventDefault();
    const files = event.dataTransfer.files;
    if (files.length > 0) {
        const input = document.getElementById('input_' + name);
        input.files = files;
        previewMediaFile(input, name);
    }
}

function toggleRemoveMedia(name, checkbox) {
    const preview = document.getElementById('preview_' + name);
    const placeholder = document.getElementById('placeholder_' + name);
    const input = document.getElementById('input_' + name);

    if (checkbox.checked) {
        preview.classList.add('d-none');
        placeholder.classList.remove('d-none');
        input.value = '';
    } else {
        @if($currentImage)
        preview.classList.remove('d-none');
        placeholder.classList.add('d-none');
        @endif
    }
}
</script>
@endpush
