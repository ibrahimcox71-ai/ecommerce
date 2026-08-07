<?php if (isset($component)) { $__componentOriginaledc75c655a063d12a477f2c8d8f324fc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc = $attributes; } ?>
<?php $component = App\View\Components\Layouts\AdminLayout::resolve(['title' => 'Stock In'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Stock In</h4>
            <p class="text-muted small mb-0">Add stock to inventory</p>
        </div>
        <a href="<?php echo e(route('admin.inventories.index')); ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to Inventory
        </a>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Add Stock</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?php echo e(route('admin.inventories.stock-in.store')); ?>">
                        <?php echo csrf_field(); ?>

                        
                        <div class="mb-4">
                            <label class="form-label">Barcode Scanner</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="fas fa-barcode"></i></span>
                                <input type="text" class="form-control" id="barcodeInput" placeholder="Scan or type barcode..." autofocus>
                                <button type="button" class="btn btn-outline-primary" onclick="lookupBarcode()">
                                    <i class="fas fa-search"></i> Lookup
                                </button>
                            </div>
                            <small class="text-muted">Scan barcode to auto-fill product details</small>
                            <div id="barcodeResult" class="mt-2 small"></div>
                        </div>

                        <hr>

                        <div class="mb-3">
                            <label for="product_search" class="form-label">Search Product <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
                                <input type="text" class="form-control" id="product_search"
                                       placeholder="Search by name, SKU, or barcode..."
                                       value="<?php echo e(request('product_id') ? (App\Models\Product::find(request('product_id'))?->name ?? '') : ''); ?>"
                                       autocomplete="off">
                                <input type="hidden" name="product_id" id="product_id" value="<?php echo e(request('product_id')); ?>" required>
                                <input type="hidden" name="product_variant_id" id="product_variant_id" value="<?php echo e(request('variant_id')); ?>">
                            </div>
                            <div id="productResults" class="list-group position-absolute shadow-sm d-none" style="z-index: 1000; max-height: 300px; overflow-y: auto; width: calc(100% - 2.5rem);"></div>
                            <?php $__errorArgs = ['product_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback d-block"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-3">
                            <label for="warehouse_id" class="form-label">Warehouse <span class="text-danger">*</span></label>
                            <select name="warehouse_id" id="warehouse_id" class="form-select <?php $__errorArgs = ['warehouse_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                <option value="">Select warehouse</option>
                                <?php $__currentLoopData = $warehouses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $warehouse): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($warehouse->id); ?>" <?php echo e(old('warehouse_id', request('warehouse_id')) == $warehouse->id ? 'selected' : ''); ?>>
                                        <?php echo e($warehouse->name); ?> (<?php echo e($warehouse->code); ?>)
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['warehouse_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity <span class="text-danger">*</span></label>
                            <input type="number" class="form-control <?php $__errorArgs = ['quantity'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   id="quantity" name="quantity" value="<?php echo e(old('quantity')); ?>"
                                   min="1" placeholder="Enter quantity to add" required>
                            <?php $__errorArgs = ['quantity'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-3">
                            <label for="reason" class="form-label">Reason</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['reason'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   id="reason" name="reason" value="<?php echo e(old('reason', 'Stock In')); ?>"
                                   placeholder="e.g., Purchase order received, Return, etc.">
                            <?php $__errorArgs = ['reason'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-0">
                            <label for="note" class="form-label">Note</label>
                            <textarea class="form-control <?php $__errorArgs = ['note'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                      id="note" name="note" rows="2" placeholder="Optional notes"><?php echo e(old('note')); ?></textarea>
                            <?php $__errorArgs = ['note'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-plus-circle me-2"></i> Add Stock
                            </button>
                            <button type="reset" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-undo me-2"></i> Reset
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Tips</h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0 small">
                        <li class="mb-2">
                            <i class="fas fa-barcode text-primary me-2"></i>
                            Use the barcode scanner for quick product lookup
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-plus-circle text-success me-2"></i>
                            Enter the quantity to add to current stock
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-warehouse text-info me-2"></i>
                            Select the correct warehouse location
                        </li>
                        <li>
                            <i class="fas fa-sticky-note text-muted me-2"></i>
                            Add a reason for record keeping
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaledc75c655a063d12a477f2c8d8f324fc)): ?>
<?php $attributes = $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc; ?>
<?php unset($__attributesOriginaledc75c655a063d12a477f2c8d8f324fc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaledc75c655a063d12a477f2c8d8f324fc)): ?>
<?php $component = $__componentOriginaledc75c655a063d12a477f2c8d8f324fc; ?>
<?php unset($__componentOriginaledc75c655a063d12a477f2c8d8f324fc); ?>
<?php endif; ?>

<?php $__env->startPush('scripts'); ?>
<script>
let searchTimeout;

document.getElementById('product_search').addEventListener('input', function() {
    clearTimeout(searchTimeout);
    const query = this.value;
    if (query.length < 1) {
        document.getElementById('productResults').classList.add('d-none');
        return;
    }
    searchTimeout = setTimeout(() => searchProducts(query), 300);
});

function searchProducts(query) {
    axios.get('<?php echo e(route('admin.inventories.get-products')); ?>', {
        params: { search: query }
    }).then(function(response) {
        const results = response.data;
        const container = document.getElementById('productResults');
        if (results.length > 0) {
            let html = '';
            results.forEach(function(item) {
                html += `<button type="button" class="list-group-item list-group-item-action"
                                 onclick="selectProduct(${item.id}, '${item.variant_id ?? null}', '${item.text.replace(/'/g, "\\'")}')">
                            <span class="small">${item.text}</span>
                            ${item.barcode ? `<code class="float-end small">${item.barcode}</code>` : ''}
                         </button>`;
            });
            container.innerHTML = html;
            container.classList.remove('d-none');
        } else {
            container.classList.add('d-none');
        }
    });
}

function selectProduct(id, variantId, text) {
    document.getElementById('product_id').value = id;
    document.getElementById('product_variant_id').value = (variantId && variantId !== 'null') ? variantId : '';
    document.getElementById('product_search').value = text;
    document.getElementById('productResults').classList.add('d-none');
}

document.addEventListener('click', function(e) {
    const container = document.getElementById('productResults');
    if (!e.target.closest('#product_search') && !e.target.closest('#productResults')) {
        container.classList.add('d-none');
    }
});

function lookupBarcode() {
    const barcode = document.getElementById('barcodeInput').value.trim();
    if (!barcode) return;

    axios.get('<?php echo e(route('admin.inventories.barcode-lookup')); ?>', {
        params: { barcode: barcode }
    }).then(function(response) {
        const data = response.data;
        const resultDiv = document.getElementById('barcodeResult');
        if (data.success) {
            if (data.type === 'product') {
                selectProduct(data.data.id, null, data.data.name + ' (' + data.data.sku + ')');
            } else {
                selectProduct(data.data.product_id, data.data.id, data.data.name + ' (' + data.data.sku + ')');
            }
            resultDiv.innerHTML = '<span class="text-success"><i class="fas fa-check-circle"></i> Product found: ' + data.data.name + '</span>';
            document.getElementById('barcodeInput').value = '';
        } else {
            resultDiv.innerHTML = '<span class="text-danger"><i class="fas fa-times-circle"></i> ' + data.message + '</span>';
        }
    }).catch(function() {
        document.getElementById('barcodeResult').innerHTML = '<span class="text-danger"><i class="fas fa-times-circle"></i> Error looking up barcode</span>';
    });
}

document.getElementById('barcodeInput').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        lookupBarcode();
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\admin\inventories\stock-in.blade.php ENDPATH**/ ?>