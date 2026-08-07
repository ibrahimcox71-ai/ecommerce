@props(['variant' => [], 'index' => 0, 'attributes' => []])

<div class="variant-row card mb-2 variant-item" data-index="{{ $index }}">
    <div class="card-body py-2">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <span class="fw-semibold variant-number">Variant #{{ $index + 1 }}</span>
            <button type="button" class="btn btn-sm btn-outline-danger remove-variant" aria-label="Remove variant #{{ $index + 1 }}">
                <i class="fas fa-times" aria-hidden="true"></i> Remove
            </button>
        </div>
        <div class="row g-2">
            <div class="col-md-3">
                <label class="form-label small">Variant Name <span class="text-danger">*</span></label>
                <input type="text" name="variants[{{ $index }}][name]" class="form-control form-control-sm"
                    value="{{ $variant['name'] ?? '' }}" placeholder="e.g. Red, Large">
            </div>
            <div class="col-md-2">
                <label class="form-label small">SKU</label>
                <input type="text" name="variants[{{ $index }}][sku]" class="form-control form-control-sm variant-sku"
                    value="{{ $variant['sku'] ?? '' }}" placeholder="Auto">
            </div>
            <div class="col-md-2">
                <label class="form-label small">Price</label>
                <input type="number" name="variants[{{ $index }}][price]" class="form-control form-control-sm variant-price"
                    value="{{ $variant['price'] ?? '' }}" step="0.01" min="0" placeholder="Inherit">
            </div>
            <div class="col-md-2">
                <label class="form-label small">Stock</label>
                <input type="number" name="variants[{{ $index }}][stock]" class="form-control form-control-sm variant-stock"
                    value="{{ $variant['stock'] ?? 0 }}" min="0">
            </div>
            <div class="col-md-1">
                <label class="form-label small">Active</label>
                <div class="form-check form-switch mt-1">
                    <input type="checkbox" class="form-check-input" name="variants[{{ $index }}][status]" value="1"
                        {{ !isset($variant['status']) || $variant['status'] ? 'checked' : '' }}
                        aria-label="Variant {{ $index + 1 }} active status">
                </div>
            </div>
            <div class="col-md-2">
                <label class="form-label small">Image</label>
                <input type="file" name="variants[{{ $index }}][image_file]" class="form-control form-control-sm" accept="image/*" aria-label="Upload variant image">
            </div>
        </div>

        @if(count($attributes) > 0)
            <div class="row g-2 mt-2">
                <div class="col-12">
                    <label class="form-label small text-muted">Attribute Values</label>
                </div>
                @foreach($attributes as $attribute)
                    <div class="col-auto">
                        <select name="variants[{{ $index }}][attribute_values][]" class="form-select form-select-sm" aria-label="{{ $attribute->name }}">
                            <option value="">{{ $attribute->name }}</option>
                            @foreach($attribute->values as $value)
                                <option value="{{ $value->id }}"
                                    {{ in_array($value->id, $variant['attribute_values'] ?? []) ? 'selected' : '' }}>
                                    {{ $value->value }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endforeach
            </div>
        @endif

        @if(isset($variant['id']) && $variant['id'] > 0)
            <input type="hidden" name="variants[{{ $index }}][id]" value="{{ $variant['id'] }}">
        @endif
    </div>
</div>
