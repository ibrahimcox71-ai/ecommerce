<?php if (isset($component)) { $__componentOriginaledc75c655a063d12a477f2c8d8f324fc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc = $attributes; } ?>
<?php $component = App\View\Components\Layouts\AdminLayout::resolve(['title' => 'Edit Product'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

    <?php $__env->startPush('styles'); ?>
        <?php echo app('Illuminate\Foundation\Vite')(['resources/sass/product.scss']); ?>
    <?php $__env->stopPush(); ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Edit Product</h4>
            <p class="text-muted small mb-0">Update product information</p>
        </div>
        <div class="d-flex gap-2">
            <a href="<?php echo e(route('admin.products.show', $product->id)); ?>" class="btn btn-outline-info">
                <i class="fas fa-eye me-1"></i> View
            </a>
            <a href="<?php echo e(route('admin.products.index')); ?>" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    <form action="<?php echo e(route('admin.products.update', $product->id)); ?>" method="POST" enctype="multipart/form-data" id="productForm" data-product-id="<?php echo e($product->id); ?>">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="row g-4">

            
            <div class="col-lg-8">

                
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="fw-semibold mb-0"><i class="fas fa-info-circle me-2"></i>Basic Information</h6>
                    </div>
                    <div class="card-body">
                        <?php if (isset($component)) { $__componentOriginal6687bc4b30894fe917cab30dddeb2b6f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6687bc4b30894fe917cab30dddeb2b6f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.product.type-selector','data' => ['selected' => ''.e(old('product_type', $product->product_type)).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.product.type-selector'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['selected' => ''.e(old('product_type', $product->product_type)).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6687bc4b30894fe917cab30dddeb2b6f)): ?>
<?php $attributes = $__attributesOriginal6687bc4b30894fe917cab30dddeb2b6f; ?>
<?php unset($__attributesOriginal6687bc4b30894fe917cab30dddeb2b6f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6687bc4b30894fe917cab30dddeb2b6f)): ?>
<?php $component = $__componentOriginal6687bc4b30894fe917cab30dddeb2b6f; ?>
<?php unset($__componentOriginal6687bc4b30894fe917cab30dddeb2b6f); ?>
<?php endif; ?>

                        <div class="row g-3">
                            <div class="col-md-8">
                                <label for="name" class="form-label">Product Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="name" name="name" value="<?php echo e(old('name', $product->name)); ?>" required>
                                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-md-4">
                                <label for="sku" class="form-label">SKU</label>
                                <input type="text" class="form-control <?php $__errorArgs = ['sku'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="sku" name="sku" value="<?php echo e(old('sku', $product->sku)); ?>" placeholder="Auto-generated">
                                <?php $__errorArgs = ['sku'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-md-6">
                                <label for="slug" class="form-label">URL Slug</label>
                                <input type="text" class="form-control <?php $__errorArgs = ['slug'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="slug" name="slug" value="<?php echo e(old('slug', $product->slug)); ?>" placeholder="Auto-generated">
                                <?php $__errorArgs = ['slug'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-md-6">
                                <label for="barcode" class="form-label">Barcode</label>
                                <input type="text" class="form-control <?php $__errorArgs = ['barcode'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="barcode" name="barcode" value="<?php echo e(old('barcode', $product->barcode)); ?>">
                                <?php $__errorArgs = ['barcode'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="fw-semibold mb-0"><i class="fas fa-align-left me-2"></i>Descriptions</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="short_description" class="form-label">Short Description</label>
                            <textarea class="form-control <?php $__errorArgs = ['short_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                      id="short_description" name="short_description" rows="2"
                                      placeholder="Brief summary for product cards"><?php echo e(old('short_description', $product->short_description)); ?></textarea>
                            <?php $__errorArgs = ['short_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Full Description</label>
                            <textarea class="form-control rich-editor <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                      id="description" name="description" rows="8"
                                      placeholder="Detailed product description"><?php echo e(old('description', $product->description)); ?></textarea>
                            <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>

                
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="fw-semibold mb-0"><i class="fas fa-dollar-sign me-2"></i>Pricing</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="price" class="form-label">Regular Price <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><?php echo e(config('ecommerce.currency_symbol')); ?></span>
                                    <input type="number" class="form-control <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           id="price" name="price" value="<?php echo e(old('price', $product->price)); ?>"
                                           step="0.01" min="0" required>
                                </div>
                                <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-md-4">
                                <label for="cost_price" class="form-label">Cost Price</label>
                                <div class="input-group">
                                    <span class="input-group-text"><?php echo e(config('ecommerce.currency_symbol')); ?></span>
                                    <input type="number" class="form-control <?php $__errorArgs = ['cost_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           id="cost_price" name="cost_price" value="<?php echo e(old('cost_price', $product->cost_price)); ?>"
                                           step="0.01" min="0">
                                </div>
                                <?php $__errorArgs = ['cost_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-md-4">
                                <label for="tax" class="form-label">Tax Rate (%)</label>
                                <div class="input-group">
                                    <input type="number" class="form-control <?php $__errorArgs = ['tax'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           id="tax" name="tax" value="<?php echo e(old('tax', $product->tax)); ?>"
                                           step="0.01" min="0" max="100">
                                    <select class="form-select" name="tax_type" style="max-width:130px;">
                                        <option value="exclusive" <?php echo e(old('tax_type', $product->tax_type ?? 'exclusive') === 'exclusive' ? 'selected' : ''); ?>>Exclusive</option>
                                        <option value="inclusive" <?php echo e(old('tax_type', $product->tax_type) === 'inclusive' ? 'selected' : ''); ?>>Inclusive</option>
                                    </select>
                                </div>
                                <?php $__errorArgs = ['tax'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-md-4">
                                <label for="discount" class="form-label">Discount</label>
                                <div class="input-group">
                                    <input type="number" class="form-control <?php $__errorArgs = ['discount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           id="discount" name="discount" value="<?php echo e(old('discount', $product->discount)); ?>"
                                           step="0.01" min="0">
                                    <select class="form-select" name="discount_type" style="max-width:100px;">
                                        <option value="percentage" <?php echo e(old('discount_type', $product->discount_type ?? 'percentage') === 'percentage' ? 'selected' : ''); ?>>%</option>
                                        <option value="fixed" <?php echo e(old('discount_type', $product->discount_type) === 'fixed' ? 'selected' : ''); ?>><?php echo e(config('ecommerce.currency_symbol')); ?></option>
                                    </select>
                                </div>
                                <?php $__errorArgs = ['discount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-md-4">
                                <label for="discount_start" class="form-label">Discount Start</label>
                                <input type="datetime-local" class="form-control <?php $__errorArgs = ['discount_start'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="discount_start" name="discount_start"
                                       value="<?php echo e(old('discount_start', $product->discount_start?->format('Y-m-d\TH:i'))); ?>">
                                <?php $__errorArgs = ['discount_start'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-md-4">
                                <label for="discount_end" class="form-label">Discount End</label>
                                <input type="datetime-local" class="form-control <?php $__errorArgs = ['discount_end'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="discount_end" name="discount_end"
                                       value="<?php echo e(old('discount_end', $product->discount_end?->format('Y-m-d\TH:i'))); ?>">
                                <?php $__errorArgs = ['discount_end'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-md-4">
                                <label for="currency" class="form-label">Currency</label>
                                <select class="form-select" name="currency" id="currency">
                                    <option value="USD" <?php echo e(old('currency', $product->currency ?? 'USD') === 'USD' ? 'selected' : ''); ?>>USD ($)</option>
                                    <option value="EUR" <?php echo e(old('currency', $product->currency) === 'EUR' ? 'selected' : ''); ?>>EUR (€)</option>
                                    <option value="GBP" <?php echo e(old('currency', $product->currency) === 'GBP' ? 'selected' : ''); ?>>GBP (£)</option>
                                    <option value="BDT" <?php echo e(old('currency', $product->currency) === 'BDT' ? 'selected' : ''); ?>>BDT (৳)</option>
                                    <option value="INR" <?php echo e(old('currency', $product->currency) === 'INR' ? 'selected' : ''); ?>>INR (₹)</option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-3">
                            <?php if (isset($component)) { $__componentOriginal4c9dc37717d7f95141469bba501e6ed8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4c9dc37717d7f95141469bba501e6ed8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.product.profit-calculator','data' => ['price' => old('price', $product->price),'costPrice' => old('cost_price', $product->cost_price),'tax' => old('tax', $product->tax),'taxType' => old('tax_type', $product->tax_type ?? 'exclusive'),'discount' => old('discount', $product->discount),'discountType' => old('discount_type', $product->discount_type ?? 'percentage')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.product.profit-calculator'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['price' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('price', $product->price)),'cost-price' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('cost_price', $product->cost_price)),'tax' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('tax', $product->tax)),'tax-type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('tax_type', $product->tax_type ?? 'exclusive')),'discount' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('discount', $product->discount)),'discount-type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('discount_type', $product->discount_type ?? 'percentage'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4c9dc37717d7f95141469bba501e6ed8)): ?>
<?php $attributes = $__attributesOriginal4c9dc37717d7f95141469bba501e6ed8; ?>
<?php unset($__attributesOriginal4c9dc37717d7f95141469bba501e6ed8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4c9dc37717d7f95141469bba501e6ed8)): ?>
<?php $component = $__componentOriginal4c9dc37717d7f95141469bba501e6ed8; ?>
<?php unset($__componentOriginal4c9dc37717d7f95141469bba501e6ed8); ?>
<?php endif; ?>
                        </div>
                    </div>
                </div>

                
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="fw-semibold mb-0"><i class="fas fa-boxes me-2"></i>Inventory</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label for="stock" class="form-label">Stock Quantity <span class="text-danger">*</span></label>
                                <input type="number" class="form-control <?php $__errorArgs = ['stock'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="stock" name="stock" value="<?php echo e(old('stock', $product->stock)); ?>" min="0" required>
                                <?php $__errorArgs = ['stock'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-md-3">
                                <label for="low_stock_threshold" class="form-label">Low Stock Alert</label>
                                <input type="number" class="form-control <?php $__errorArgs = ['low_stock_threshold'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="low_stock_threshold" name="low_stock_threshold"
                                       value="<?php echo e(old('low_stock_threshold', $product->low_stock_threshold ?? 10)); ?>" min="0">
                                <?php $__errorArgs = ['low_stock_threshold'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-md-3">
                                <label for="min_stock" class="form-label">Minimum Stock</label>
                                <input type="number" class="form-control <?php $__errorArgs = ['min_stock'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="min_stock" name="min_stock"
                                       value="<?php echo e(old('min_stock', $product->min_stock)); ?>" min="0">
                                <small class="text-muted">Safety stock level</small>
                                <?php $__errorArgs = ['min_stock'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="unlimited_stock"
                                           name="unlimited_stock" value="1" <?php echo e(old('unlimited_stock', $product->unlimited_stock) ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="unlimited_stock">Unlimited Stock</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="fw-semibold mb-0"><i class="fas fa-images me-2"></i>Images</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="thumbnail" class="form-label">Featured Image</label>
                                <?php if($product->thumbnail): ?>
                                    <div class="mb-2 position-relative d-inline-block" id="currentThumbnail">
                                        <img src="<?php echo e($product->thumbnail_url); ?>" class="img-thumbnail" style="max-height: 150px;">
                                        <button type="button" class="btn btn-sm btn-outline-danger position-absolute top-0 end-0 m-1" id="removeThumbnailBtn" title="Remove image">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                    <input type="hidden" name="remove_thumbnail" id="removeThumbnail" value="0">
                                <?php endif; ?>
                                <input type="file" class="form-control <?php $__errorArgs = ['thumbnail'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="thumbnail" name="thumbnail" accept="image/*">
                                <small class="text-muted">Recommended: 800x800px. Max 5MB.</small>
                                <div id="thumbnailPreview" class="mt-2 d-none">
                                    <img src="" class="img-thumbnail" style="max-height: 150px;">
                                </div>
                                <?php $__errorArgs = ['thumbnail'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Gallery Images <small class="text-muted">(Drag & Drop)</small></label>
                                <?php if (isset($component)) { $__componentOriginal11f14d122de2b6fcd1070092f56ce2b8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal11f14d122de2b6fcd1070092f56ce2b8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.product.dropzone','data' => ['name' => 'gallery','label' => 'Drop images here or click to upload','existing' => $product->images->map(fn($img) => [
                                        'id' => $img->id,
                                        'image' => $img->image,
                                        'url' => $img->image_url,
                                        'is_primary' => $img->is_primary,
                                        'alt_text' => $img->alt_text,
                                    ])->toArray()]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.product.dropzone'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'gallery','label' => 'Drop images here or click to upload','existing' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($product->images->map(fn($img) => [
                                        'id' => $img->id,
                                        'image' => $img->image,
                                        'url' => $img->image_url,
                                        'is_primary' => $img->is_primary,
                                        'alt_text' => $img->alt_text,
                                    ])->toArray())]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal11f14d122de2b6fcd1070092f56ce2b8)): ?>
<?php $attributes = $__attributesOriginal11f14d122de2b6fcd1070092f56ce2b8; ?>
<?php unset($__attributesOriginal11f14d122de2b6fcd1070092f56ce2b8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal11f14d122de2b6fcd1070092f56ce2b8)): ?>
<?php $component = $__componentOriginal11f14d122de2b6fcd1070092f56ce2b8; ?>
<?php unset($__componentOriginal11f14d122de2b6fcd1070092f56ce2b8); ?>
<?php endif; ?>
                            </div>
                        </div>
                        <div class="mt-3">
                            <label for="video_url" class="form-label">Video URL</label>
                            <input type="url" class="form-control <?php $__errorArgs = ['video_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   id="video_url" name="video_url" value="<?php echo e(old('video_url', $product->video_url)); ?>"
                                   placeholder="https://youtube.com/...">
                            <?php $__errorArgs = ['video_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>

                
                <div class="card mb-4" id="variantsSection" style="display: <?php echo e($product->product_type === 'variable' ? 'block' : 'none'); ?>;">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="fw-semibold mb-0"><i class="fas fa-layer-group me-2"></i>Product Variants</h6>
                        <button type="button" class="btn btn-sm btn-outline-primary" id="addVariantBtn">
                            <i class="fas fa-plus me-1"></i> Add Variant
                        </button>
                    </div>
                    <div class="card-body">
                        <div id="variantsContainer">
                            <?php if($product->variants->count() > 0): ?>
                                <?php $__currentLoopData = $product->variants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $variant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if (isset($component)) { $__componentOriginale0ffbe00031802743e7ec9d8ece62051 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale0ffbe00031802743e7ec9d8ece62051 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.product.variant-row','data' => ['variant' => array_merge($variant->toArray(), ['id' => $variant->id, 'attribute_values' => $variant->attributeValues->pluck('attribute_value_id')->toArray()]),'index' => $index,'attributes' => $attributes]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.product.variant-row'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(array_merge($variant->toArray(), ['id' => $variant->id, 'attribute_values' => $variant->attributeValues->pluck('attribute_value_id')->toArray()])),'index' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($index),'attributes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($attributes)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale0ffbe00031802743e7ec9d8ece62051)): ?>
<?php $attributes = $__attributesOriginale0ffbe00031802743e7ec9d8ece62051; ?>
<?php unset($__attributesOriginale0ffbe00031802743e7ec9d8ece62051); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale0ffbe00031802743e7ec9d8ece62051)): ?>
<?php $component = $__componentOriginale0ffbe00031802743e7ec9d8ece62051; ?>
<?php unset($__componentOriginale0ffbe00031802743e7ec9d8ece62051); ?>
<?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php elseif(old('variants')): ?>
                                <?php $__currentLoopData = old('variants'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $variant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if (isset($component)) { $__componentOriginale0ffbe00031802743e7ec9d8ece62051 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale0ffbe00031802743e7ec9d8ece62051 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.product.variant-row','data' => ['variant' => $variant,'index' => $index,'attributes' => $attributes]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.product.variant-row'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($variant),'index' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($index),'attributes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($attributes)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale0ffbe00031802743e7ec9d8ece62051)): ?>
<?php $attributes = $__attributesOriginale0ffbe00031802743e7ec9d8ece62051; ?>
<?php unset($__attributesOriginale0ffbe00031802743e7ec9d8ece62051); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale0ffbe00031802743e7ec9d8ece62051)): ?>
<?php $component = $__componentOriginale0ffbe00031802743e7ec9d8ece62051; ?>
<?php unset($__componentOriginale0ffbe00031802743e7ec9d8ece62051); ?>
<?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </div>
                        <div class="text-muted small mt-2" id="noVariantsMsg" style="display: <?php echo e($product->variants->count() > 0 ? 'none' : 'block'); ?>;">
                            <i class="fas fa-info-circle me-1"></i> No variants added yet. Click "Add Variant" to create product variations.
                        </div>
                    </div>
                </div>

                
                <div class="card mb-4" id="digitalSection" style="display: <?php echo e($product->product_type === 'digital' ? 'block' : 'none'); ?>;">
                    <div class="card-header">
                        <h6 class="fw-semibold mb-0"><i class="fas fa-download me-2"></i>Digital Download</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-check mb-3">
                            <input type="checkbox" class="form-check-input" id="is_virtual"
                                   name="is_virtual" value="1" <?php echo e(old('is_virtual', $product->is_virtual) ? 'checked' : ''); ?>>
                            <label class="form-check-label" for="is_virtual">This is a virtual/digital product</label>
                        </div>
                        <div class="mb-3">
                            <label for="download_link" class="form-label">Download Link</label>
                            <input type="url" class="form-control <?php $__errorArgs = ['download_link'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   id="download_link" name="download_link" value="<?php echo e(old('download_link', $product->download_link)); ?>"
                                   placeholder="https://example.com/download/file.zip">
                            <?php $__errorArgs = ['download_link'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>

                
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="fw-semibold mb-0"><i class="fas fa-search me-2"></i>SEO</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="meta_title" class="form-label">Meta Title</label>
                                <input type="text" class="form-control <?php $__errorArgs = ['meta_title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="meta_title" name="meta_title" value="<?php echo e(old('meta_title', $product->meta_title)); ?>"
                                       maxlength="255" placeholder="SEO title">
                                <small class="text-muted"><span id="metaTitleCount"><?php echo e(strlen(old('meta_title', $product->meta_title ?? ''))); ?></span>/255 characters</small>
                                <?php $__errorArgs = ['meta_title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-md-6">
                                <label for="canonical_url" class="form-label">Canonical URL</label>
                                <input type="url" class="form-control <?php $__errorArgs = ['canonical_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="canonical_url" name="canonical_url" value="<?php echo e(old('canonical_url', $product->canonical_url)); ?>"
                                       placeholder="https://example.com/product">
                                <?php $__errorArgs = ['canonical_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-md-6">
                                <label for="meta_description" class="form-label">Meta Description</label>
                                <textarea class="form-control <?php $__errorArgs = ['meta_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                          id="meta_description" name="meta_description" rows="3"
                                          maxlength="500" placeholder="SEO description"><?php echo e(old('meta_description', $product->meta_description)); ?></textarea>
                                <small class="text-muted"><span id="metaDescCount"><?php echo e(strlen(old('meta_description', $product->meta_description ?? ''))); ?></span>/500 characters</small>
                                <?php $__errorArgs = ['meta_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-md-6">
                                <label for="meta_keywords" class="form-label">Meta Keywords</label>
                                <input type="text" class="form-control <?php $__errorArgs = ['meta_keywords'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="meta_keywords" name="meta_keywords" value="<?php echo e(old('meta_keywords', $product->meta_keywords)); ?>"
                                       placeholder="keyword1, keyword2, keyword3">
                                <?php $__errorArgs = ['meta_keywords'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-md-6">
                                <label for="og_image" class="form-label">Open Graph Image</label>
                                <?php if($product->og_image): ?>
                                    <div class="mb-2 position-relative d-inline-block" id="currentOgImage">
                                        <img src="<?php echo e($product->og_image_url); ?>" class="img-thumbnail" style="max-height: 80px;">
                                        <button type="button" class="btn btn-sm btn-outline-danger position-absolute top-0 end-0 m-1" id="removeOgImageBtn" title="Remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                    <input type="hidden" name="remove_og_image" id="removeOgImage" value="0">
                                <?php endif; ?>
                                <input type="file" class="form-control <?php $__errorArgs = ['og_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="og_image" name="og_image" accept="image/*">
                                <small class="text-muted">1200x630px recommended for social sharing</small>
                                <?php $__errorArgs = ['og_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-md-6">
                                <label for="schema_markup" class="form-label">Schema Markup (JSON-LD)</label>
                                <textarea class="form-control <?php $__errorArgs = ['schema_markup'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                          id="schema_markup" name="schema_markup" rows="3"
                                          placeholder='{"@context":"https://schema.org/"}'><?php echo e(old('schema_markup', $product->schema_markup)); ?></textarea>
                                <small class="text-muted">Custom JSON-LD structured data</small>
                                <?php $__errorArgs = ['schema_markup'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="col-lg-4">

                
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="fw-semibold mb-0"><i class="fas fa-toggle-on me-2"></i>Status</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="status" class="form-label">Product Status</label>
                            <select class="form-select <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="status" name="status">
                                <option value="draft" <?php echo e(old('status', $product->status->value) === 'draft' ? 'selected' : ''); ?>>Draft</option>
                                <option value="active" <?php echo e(old('status', $product->status->value) === 'active' ? 'selected' : ''); ?>>Published</option>
                                <option value="hidden" <?php echo e(old('status', $product->status->value) === 'hidden' ? 'selected' : ''); ?>>Hidden</option>
                                <option value="inactive" <?php echo e(old('status', $product->status->value) === 'inactive' ? 'selected' : ''); ?>>Inactive</option>
                                <option value="archived" <?php echo e(old('status', $product->status->value) === 'archived' ? 'selected' : ''); ?>>Archived</option>
                            </select>
                            <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <hr>
                        <div class="form-check form-switch mb-2">
                            <input type="checkbox" class="form-check-input" id="featured"
                                   name="featured" value="1" <?php echo e(old('featured', $product->featured) ? 'checked' : ''); ?>>
                            <label class="form-check-label" for="featured">Featured Product</label>
                        </div>
                        <div class="form-check form-switch mb-2">
                            <input type="checkbox" class="form-check-input" id="trending"
                                   name="trending" value="1" <?php echo e(old('trending', $product->trending) ? 'checked' : ''); ?>>
                            <label class="form-check-label" for="trending">Trending</label>
                        </div>
                        <div class="form-check form-switch mb-2">
                            <input type="checkbox" class="form-check-input" id="best_seller"
                                   name="best_seller" value="1" <?php echo e(old('best_seller', $product->best_seller) ? 'checked' : ''); ?>>
                            <label class="form-check-label" for="best_seller">Best Seller</label>
                        </div>
                        <div class="form-check form-switch">
                            <input type="checkbox" class="form-check-input" id="is_new_arrival"
                                   name="is_new_arrival" value="1" <?php echo e(old('is_new_arrival', $product->is_new_arrival) ? 'checked' : ''); ?>>
                            <label class="form-check-label" for="is_new_arrival">New Arrival</label>
                        </div>
                    </div>
                </div>

                
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="fw-semibold mb-0"><i class="fas fa-sitemap me-2"></i>Organization</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Category <span class="text-danger">*</span></label>
                            <select class="form-select <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="category_id" name="category_id" required>
                                <option value="">Select Category</option>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($category->id); ?>" <?php echo e(old('category_id', $product->category_id) == $category->id ? 'selected' : ''); ?>>
                                        <?php echo e($category->name); ?>

                                    </option>
                                    <?php if($category->children->count() > 0): ?>
                                        <?php $__currentLoopData = $category->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($child->id); ?>" <?php echo e(old('category_id', $product->category_id) == $child->id ? 'selected' : ''); ?>>
                                                &nbsp;&nbsp;&nbsp;└ <?php echo e($child->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="mb-3">
                            <label for="sub_category_id" class="form-label">Sub Category</label>
                            <select class="form-select <?php $__errorArgs = ['sub_category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    id="sub_category_id" name="sub_category_id">
                                <option value="">Select Sub Category</option>
                            </select>
                            <?php $__errorArgs = ['sub_category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="mb-3">
                            <label for="child_category_id" class="form-label">Child Category</label>
                            <select class="form-select <?php $__errorArgs = ['child_category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    id="child_category_id" name="child_category_id">
                                <option value="">Select Child Category</option>
                            </select>
                            <?php $__errorArgs = ['child_category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="mb-3">
                            <label for="brand_id" class="form-label">Brand</label>
                            <select class="form-select <?php $__errorArgs = ['brand_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="brand_id" name="brand_id">
                                <option value="">Select Brand</option>
                                <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($brand->id); ?>" <?php echo e(old('brand_id', $product->brand_id) == $brand->id ? 'selected' : ''); ?>>
                                        <?php echo e($brand->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['brand_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>

                
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="fw-semibold mb-0"><i class="fas fa-tags me-2"></i>Tags</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="tags_string" class="form-label">Product Tags</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['tags'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   id="tags_string" name="tags_string"
                                   value="<?php echo e(old('tags_string', is_array($product->tags) ? implode(', ', $product->tags) : $product->tags)); ?>"
                                   placeholder="tag1, tag2, tag3">
                            <small class="text-muted">Separate tags with commas</small>
                            <?php $__errorArgs = ['tags'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>

                
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="fw-semibold mb-0"><i class="fas fa-truck me-2"></i>Shipping & Dimensions</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-6">
                                <label for="weight" class="form-label">Weight</label>
                                <input type="number" class="form-control <?php $__errorArgs = ['weight'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="weight" name="weight" value="<?php echo e(old('weight', $product->weight)); ?>" step="0.01" min="0">
                                <?php $__errorArgs = ['weight'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-6">
                                <label for="weight_unit" class="form-label">Unit</label>
                                <select class="form-select" name="weight_unit">
                                    <option value="kg" <?php echo e(old('weight_unit', $product->weight_unit ?? 'kg') === 'kg' ? 'selected' : ''); ?>>kg</option>
                                    <option value="g" <?php echo e(old('weight_unit', $product->weight_unit) === 'g' ? 'selected' : ''); ?>>g</option>
                                    <option value="lb" <?php echo e(old('weight_unit', $product->weight_unit) === 'lb' ? 'selected' : ''); ?>>lb</option>
                                    <option value="oz" <?php echo e(old('weight_unit', $product->weight_unit) === 'oz' ? 'selected' : ''); ?>>oz</option>
                                </select>
                            </div>
                            <div class="col-4">
                                <label for="length" class="form-label">Length</label>
                                <input type="number" class="form-control" name="length" value="<?php echo e(old('length', $product->length)); ?>" step="0.01" min="0">
                            </div>
                            <div class="col-4">
                                <label for="width" class="form-label">Width</label>
                                <input type="number" class="form-control" name="width" value="<?php echo e(old('width', $product->width)); ?>" step="0.01" min="0">
                            </div>
                            <div class="col-4">
                                <label for="height" class="form-label">Height</label>
                                <input type="number" class="form-control" name="height" value="<?php echo e(old('height', $product->height)); ?>" step="0.01" min="0">
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="fw-semibold mb-0"><i class="fas fa-shield-alt me-2"></i>Warranty</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-7">
                                <label for="warranty_type" class="form-label">Type</label>
                                <select class="form-select" name="warranty_type">
                                    <option value="no_warranty" <?php echo e(old('warranty_type', $product->warranty_type ?? 'no_warranty') === 'no_warranty' ? 'selected' : ''); ?>>No Warranty</option>
                                    <option value="manufacturer" <?php echo e(old('warranty_type', $product->warranty_type) === 'manufacturer' ? 'selected' : ''); ?>>Manufacturer</option>
                                    <option value="seller" <?php echo e(old('warranty_type', $product->warranty_type) === 'seller' ? 'selected' : ''); ?>>Seller</option>
                                </select>
                            </div>
                            <div class="col-5">
                                <label for="warranty_period" class="form-label">Period (months)</label>
                                <input type="number" class="form-control" name="warranty_period" value="<?php echo e(old('warranty_period', $product->warranty_period)); ?>" min="1">
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="fw-semibold mb-0"><i class="fas fa-shopping-cart me-2"></i>Order Limits</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-6">
                                <label for="min_order_quantity" class="form-label">Min Order</label>
                                <input type="number" class="form-control" name="min_order_quantity"
                                       value="<?php echo e(old('min_order_quantity', $product->min_order_quantity ?? 1)); ?>" min="1">
                            </div>
                            <div class="col-6">
                                <label for="max_order_quantity" class="form-label">Max Order</label>
                                <input type="number" class="form-control" name="max_order_quantity"
                                       value="<?php echo e(old('max_order_quantity', $product->max_order_quantity)); ?>" min="1">
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="fw-semibold mb-0"><i class="fas fa-chart-bar me-2"></i>Quick Stats</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Created</span>
                            <span><?php echo e($product->created_at->format('M d, Y')); ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Last Updated</span>
                            <span><?php echo e($product->updated_at->format('M d, Y')); ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Variants</span>
                            <span class="badge bg-secondary"><?php echo e($product->variants->count()); ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Total Stock</span>
                            <span class="badge bg-<?php echo e($product->is_out_of_stock ? 'danger' : ($product->is_low_stock ? 'warning' : 'success')); ?>">
                                <?php echo e($product->total_stock ?? '∞'); ?>

                            </span>
                        </div>
                        <?php if($product->profit_margin > 0): ?>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Profit Margin</span>
                                <span class="badge bg-<?php echo e($product->profit_margin > 30 ? 'success' : ($product->profit_margin > 15 ? 'warning' : 'danger')); ?>">
                                    <?php echo e($product->profit_margin); ?>%
                                </span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save me-2"></i> Update Product
                    </button>
                    <button type="submit" name="continue_editing" value="1" class="btn btn-outline-primary">
                        <i class="fas fa-save me-2"></i> Save & Continue Editing
                    </button>
                    <div class="btn-group">
                        <a href="<?php echo e(route('admin.products.duplicate', $product->id)); ?>" class="btn btn-outline-secondary">
                            <i class="fas fa-copy me-1"></i> Duplicate
                        </a>
                        <button type="button" class="btn btn-outline-danger"
                                onclick="confirmDelete(<?php echo e($product->id); ?>, '<?php echo e(addslashes($product->name)); ?>')">
                            <i class="fas fa-trash me-1"></i> Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete <strong id="deleteName"></strong>?</p>
                    <p class="text-muted small mb-0">The product will be moved to trash.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteForm" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-1"></i> Delete
                        </button>
                    </form>
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
<?php echo app('Illuminate\Foundation\Vite')(['resources/js/product.js']); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Product type toggling
    var typeInputs = document.querySelectorAll('input[name="product_type"]');
    var variantsSection = document.getElementById('variantsSection');
    var digitalSection = document.getElementById('digitalSection');

    function toggleProductType(type) {
        variantsSection.style.display = type === 'variable' ? 'block' : 'none';
        digitalSection.style.display = type === 'digital' ? 'block' : 'none';
        if (type === 'digital') {
            document.getElementById('is_virtual').checked = true;
        }
    }

    typeInputs.forEach(function(input) {
        input.addEventListener('change', function() {
            if (this.checked) toggleProductType(this.value);
        });
    });

    toggleProductType(document.querySelector('input[name="product_type"]:checked')?.value || 'simple');

    // Auto slug from name
    var nameInput = document.getElementById('name');
    var slugInput = document.getElementById('slug');
    if (nameInput && slugInput) {
        nameInput.addEventListener('input', function() {
            if (!slugInput.dataset.edited) {
                slugInput.value = slugify(this.value);
            }
        });
        slugInput.addEventListener('input', function() {
            this.dataset.edited = this.value.length > 0 ? '1' : '';
        });
    }

    // Meta character counts
    var metaTitle = document.getElementById('meta_title');
    var metaDesc = document.getElementById('meta_description');
    var titleCount = document.getElementById('metaTitleCount');
    var descCount = document.getElementById('metaDescCount');

    if (metaTitle && titleCount) {
        metaTitle.addEventListener('input', function() {
            titleCount.textContent = this.value.length;
        });
    }
    if (metaDesc && descCount) {
        metaDesc.addEventListener('input', function() {
            descCount.textContent = this.value.length;
        });
    }

    // Load subcategories on page load
    var categorySelect = document.getElementById('category_id');
    var subCategorySelect = document.getElementById('sub_category_id');
    var childCategorySelect = document.getElementById('child_category_id');

    function loadSubCategories(categoryId, selectedSubId, selectedChildId) {
        if (!categoryId) {
            subCategorySelect.innerHTML = '<option value="">Select Sub Category</option>';
            childCategorySelect.innerHTML = '<option value="">Select Child Category</option>';
            return;
        }

        subCategorySelect.innerHTML = '<option value="">Loading...</option>';

        fetch('/admin/products/get-sub-categories/' + categoryId)
            .then(function(r) { return r.json(); })
            .then(function(response) {
                var html = '<option value="">Select Sub Category</option>';
                response.data.forEach(function(sub) {
                    var selected = sub.id == selectedSubId ? 'selected' : '';
                    html += '<option value="' + sub.id + '" ' + selected + '>' + sub.name + '</option>';
                });
                subCategorySelect.innerHTML = html;

                if (selectedSubId) {
                    loadChildCategories(selectedSubId, selectedChildId);
                }
            });
    }

    function loadChildCategories(subCategoryId, selectedChildId) {
        if (!subCategoryId) {
            childCategorySelect.innerHTML = '<option value="">Select Child Category</option>';
            return;
        }

        childCategorySelect.innerHTML = '<option value="">Loading...</option>';

        fetch('/admin/products/get-sub-categories/' + subCategoryId)
            .then(function(r) { return r.json(); })
            .then(function(response) {
                var html = '<option value="">Select Child Category</option>';
                response.data.forEach(function(child) {
                    var selected = child.id == selectedChildId ? 'selected' : '';
                    html += '<option value="' + child.id + '" ' + selected + '>' + child.name + '</option>';
                });
                childCategorySelect.innerHTML = html;
            });
    }

    // Initial load
    <?php if($product->category_id): ?>
    loadSubCategories(<?php echo e($product->category_id); ?>, <?php echo e($product->sub_category_id ?? 'null'); ?>, <?php echo e($product->child_category_id ?? 'null'); ?>);
    <?php endif; ?>

    if (categorySelect) {
        categorySelect.addEventListener('change', function() {
            var selectedSub = subCategorySelect.value;
            loadSubCategories(this.value, null, null);
        });
    }

    if (subCategorySelect) {
        subCategorySelect.addEventListener('change', function() {
            var selectedChild = childCategorySelect.value;
            loadChildCategories(this.value, null);
        });
    }

    // Thumbnail preview
    var thumbnailInput = document.getElementById('thumbnail');
    var thumbnailPreview = document.getElementById('thumbnailPreview');
    var removeThumbnailBtn = document.getElementById('removeThumbnailBtn');
    var removeThumbnail = document.getElementById('removeThumbnail');

    if (thumbnailInput) {
        thumbnailInput.addEventListener('change', function() {
            var file = this.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    thumbnailPreview.classList.remove('d-none');
                    thumbnailPreview.querySelector('img').src = e.target.result;
                    var currentThumb = document.getElementById('currentThumbnail');
                    if (currentThumb) currentThumb.style.display = 'none';
                };
                reader.readAsDataURL(file);
            }
        });
    }

    if (removeThumbnailBtn && removeThumbnail) {
        removeThumbnailBtn.addEventListener('click', function() {
            document.getElementById('currentThumbnail').style.display = 'none';
            removeThumbnail.value = '1';
            thumbnailInput.value = '';
        });
    }

    // OG image remove
    var removeOgImageBtn = document.getElementById('removeOgImageBtn');
    var removeOgImage = document.getElementById('removeOgImage');
    if (removeOgImageBtn && removeOgImage) {
        removeOgImageBtn.addEventListener('click', function() {
            document.getElementById('currentOgImage').style.display = 'none';
            removeOgImage.value = '1';
        });
    }

    // Profit calculator
    function updateProfitCalc() {
        var price = parseFloat(document.getElementById('price')?.value || 0);
        var costPrice = parseFloat(document.getElementById('cost_price')?.value || 0);
        var tax = parseFloat(document.getElementById('tax')?.value || 0);
        var discount = parseFloat(document.getElementById('discount')?.value || 0);
        var discountType = document.querySelector('select[name="discount_type"]')?.value || 'percentage';
        var salePrice = discount > 0
            ? (discountType === 'percentage' ? price - (price * discount / 100) : price - discount)
            : price;
        var profit = salePrice - costPrice;
        var margin = salePrice > 0 ? (profit / salePrice) * 100 : 0;
        var taxAmount = tax > 0 ? salePrice * tax / 100 : 0;
        var afterTax = salePrice + taxAmount;

        document.getElementById('calcSalePrice').textContent = '<?php echo e(config('ecommerce.currency_symbol')); ?>' + salePrice.toFixed(2);
        document.getElementById('calcCostPrice').textContent = '<?php echo e(config('ecommerce.currency_symbol')); ?>' + costPrice.toFixed(2);
        document.getElementById('calcProfit').textContent = '<?php echo e(config('ecommerce.currency_symbol')); ?>' + profit.toFixed(2);
        document.getElementById('calcMargin').textContent = margin.toFixed(1) + '%';
        document.getElementById('calcTax').textContent = '<?php echo e(config('ecommerce.currency_symbol')); ?>' + taxAmount.toFixed(2);
        document.getElementById('calcAfterTax').textContent = '<?php echo e(config('ecommerce.currency_symbol')); ?>' + afterTax.toFixed(2);
    }

    ['price', 'cost_price', 'tax', 'discount'].forEach(function(id) {
        var el = document.getElementById(id);
        if (el) el.addEventListener('input', updateProfitCalc);
    });
    document.querySelector('select[name="discount_type"]')?.addEventListener('change', updateProfitCalc);
    updateProfitCalc();

    // Delete confirmation
    window.confirmDelete = function(id, name) {
        document.getElementById('deleteName').textContent = name;
        document.getElementById('deleteForm').action = '<?php echo e(url('admin/products')); ?>/' + id;
        new bootstrap.Modal(document.getElementById('deleteModal')).show();
    };
});

function slugify(text) {
    return text.toString().toLowerCase()
        .replace(/\s+/g, '-')
        .replace(/[^\w\-]+/g, '')
        .replace(/\-\-+/g, '-')
        .replace(/^-+/, '')
        .replace(/-+$/, '');
}
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\admin\products\edit.blade.php ENDPATH**/ ?>