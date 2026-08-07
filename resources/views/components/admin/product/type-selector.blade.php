@props(['selected' => 'simple'])

<div class="mb-3">
    <label class="form-label fw-semibold">Product Type</label>
    <div class="row g-2" role="radiogroup" aria-label="Product type selection">
        <div class="col-4">
            <input type="radio" class="btn-check" name="product_type" id="typeSimple" value="simple" autocomplete="off"
                {{ $selected === 'simple' ? 'checked' : '' }}>
            <label class="btn btn-outline-primary w-100 text-start py-3 px-3" for="typeSimple" aria-describedby="simpleDesc">
                <div class="d-flex align-items-center gap-3">
                    <i class="fas fa-box fa-lg" aria-hidden="true"></i>
                    <div>
                        <div class="fw-semibold">Simple</div>
                        <small class="opacity-75" id="simpleDesc">Single product, no variants</small>
                    </div>
                </div>
            </label>
        </div>
        <div class="col-4">
            <input type="radio" class="btn-check" name="product_type" id="typeVariable" value="variable" autocomplete="off"
                {{ $selected === 'variable' ? 'checked' : '' }}>
            <label class="btn btn-outline-primary w-100 text-start py-3 px-3" for="typeVariable" aria-describedby="variableDesc">
                <div class="d-flex align-items-center gap-3">
                    <i class="fas fa-layer-group fa-lg" aria-hidden="true"></i>
                    <div>
                        <div class="fw-semibold">Variable</div>
                        <small class="opacity-75" id="variableDesc">Size, Color, Custom options</small>
                    </div>
                </div>
            </label>
        </div>
        <div class="col-4">
            <input type="radio" class="btn-check" name="product_type" id="typeDigital" value="digital" autocomplete="off"
                {{ $selected === 'digital' ? 'checked' : '' }}>
            <label class="btn btn-outline-primary w-100 text-start py-3 px-3" for="typeDigital" aria-describedby="digitalDesc">
                <div class="d-flex align-items-center gap-3">
                    <i class="fas fa-download fa-lg" aria-hidden="true"></i>
                    <div>
                        <div class="fw-semibold">Digital</div>
                        <small class="opacity-75" id="digitalDesc">Downloadable files, keys</small>
                    </div>
                </div>
            </label>
        </div>
    </div>
</div>
