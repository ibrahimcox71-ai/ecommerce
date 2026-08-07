<?php if (isset($component)) { $__componentOriginaledc75c655a063d12a477f2c8d8f324fc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc = $attributes; } ?>
<?php $component = App\View\Components\Layouts\AdminLayout::resolve(['title' => 'Edit Brand'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Edit Brand</h4>
            <p class="text-muted small mb-0">Update brand information</p>
        </div>
        <div class="d-flex gap-2">
            <a href="<?php echo e(route('admin.brands.show', $brand->id)); ?>" class="btn btn-outline-info">
                <i class="fas fa-eye me-1"></i> View
            </a>
            <a href="<?php echo e(route('admin.brands.index')); ?>" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    <form method="POST" action="<?php echo e(route('admin.brands.update', $brand->id)); ?>" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="row g-4">
            
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header bg-transparent">
                        <h6 class="fw-bold mb-0">Basic Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Brand Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="name" name="name" value="<?php echo e(old('name', $brand->name)); ?>"
                                       placeholder="Enter brand name" required>
                                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="brand_code" class="form-label">Brand Code</label>
                                <input type="text" class="form-control <?php $__errorArgs = ['brand_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="brand_code" name="brand_code" value="<?php echo e(old('brand_code', $brand->brand_code)); ?>"
                                       placeholder="e.g., BRN-001">
                                <small class="text-muted">Unique identifier code</small>
                                <?php $__errorArgs = ['brand_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        
                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug</label>
                            <div class="input-group">
                                <span class="input-group-text">/</span>
                                <input type="text" class="form-control <?php $__errorArgs = ['slug'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="slug" name="slug" value="<?php echo e(old('slug', $brand->slug)); ?>"
                                       placeholder="brand-slug">
                                <button type="button" class="btn btn-outline-secondary" onclick="generateSlug()">
                                    <i class="fas fa-sync-alt"></i>
                                </button>
                            </div>
                            <small class="text-muted">Leave empty to auto-generate from name</small>
                            <?php $__errorArgs = ['slug'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                      id="description" name="description" rows="4"
                                      placeholder="Brand description"><?php echo e(old('description', $brand->description)); ?></textarea>
                            <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="website" class="form-label">Website</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-globe"></i></span>
                                    <input type="url" class="form-control <?php $__errorArgs = ['website'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           id="website" name="website" value="<?php echo e(old('website', $brand->website)); ?>"
                                           placeholder="https://example.com">
                                </div>
                                <?php $__errorArgs = ['website'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           id="email" name="email" value="<?php echo e(old('email', $brand->email)); ?>"
                                           placeholder="contact@brand.com">
                                </div>
                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    <input type="text" class="form-control <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           id="phone" name="phone" value="<?php echo e(old('phone', $brand->phone)); ?>"
                                           placeholder="+1 (555) 123-4567">
                                </div>
                                <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        
                        <div class="mb-0">
                            <label for="country" class="form-label">Country</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                <input type="text" class="form-control <?php $__errorArgs = ['country'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="country" name="country" value="<?php echo e(old('country', $brand->country)); ?>"
                                       placeholder="e.g., United States">
                            </div>
                            <?php $__errorArgs = ['country'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>

                
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
                                        <?php if($brand->image): ?>
                                            <img id="imagePreview" src="<?php echo e($brand->image_url); ?>" alt="<?php echo e($brand->name); ?>"
                                                 class="img-fluid rounded mb-2" style="max-height: 120px;">
                                            <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2"
                                                    onclick="event.stopPropagation(); removeImage('image')">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        <?php else: ?>
                                            <img id="imagePreview" src="#" alt="Preview"
                                                 class="img-fluid rounded d-none mb-2" style="max-height: 120px;">
                                            <i class="fas fa-image fa-3x text-muted" id="imagePlaceholder"></i>
                                            <p class="text-muted small mt-2 mb-0" id="imageText">Click or drag</p>
                                        <?php endif; ?>
                                    </div>
                                    <input type="file" class="d-none" id="image" name="image"
                                           accept="image/*" onchange="previewImage(this, 'image')">
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="checkbox" id="remove_image" name="remove_image" value="1">
                                        <label class="form-check-label text-danger small" for="remove_image">
                                            Remove current image
                                        </label>
                                    </div>
                                    <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Brand Logo</label>
                                    <div class="dropzone-wrapper border rounded p-3 text-center bg-light position-relative"
                                         onclick="document.getElementById('logo').click()"
                                         ondragover="event.preventDefault()"
                                         ondrop="handleDrop(event, 'logo')">
                                        <?php if($brand->logo): ?>
                                            <img id="logoPreview" src="<?php echo e($brand->logo_url); ?>" alt="<?php echo e($brand->name); ?>"
                                                 class="img-fluid rounded mb-2" style="max-height: 120px;">
                                            <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2"
                                                    onclick="event.stopPropagation(); removeImage('logo')">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        <?php else: ?>
                                            <img id="logoPreview" src="#" alt="Preview"
                                                 class="img-fluid rounded d-none mb-2" style="max-height: 120px;">
                                            <i class="fas fa-building fa-3x text-muted" id="logoPlaceholder"></i>
                                            <p class="text-muted small mt-2 mb-0" id="logoText">Click or drag</p>
                                        <?php endif; ?>
                                    </div>
                                    <input type="file" class="d-none" id="logo" name="logo"
                                           accept="image/*" onchange="previewImage(this, 'logo')">
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="checkbox" id="remove_logo" name="remove_logo" value="1">
                                        <label class="form-check-label text-danger small" for="remove_logo">
                                            Remove current logo
                                        </label>
                                    </div>
                                    <?php $__errorArgs = ['logo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Banner Image</label>
                                    <div class="dropzone-wrapper border rounded p-3 text-center bg-light position-relative"
                                         onclick="document.getElementById('banner').click()"
                                         ondragover="event.preventDefault()"
                                         ondrop="handleDrop(event, 'banner')">
                                        <?php if($brand->banner): ?>
                                            <img id="bannerPreview" src="<?php echo e($brand->banner_url); ?>" alt="<?php echo e($brand->name); ?>"
                                                 class="img-fluid rounded mb-2" style="max-height: 120px;">
                                            <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2"
                                                    onclick="event.stopPropagation(); removeImage('banner')">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        <?php else: ?>
                                            <img id="bannerPreview" src="#" alt="Preview"
                                                 class="img-fluid rounded d-none mb-2" style="max-height: 120px;">
                                            <i class="fas fa-image fa-3x text-muted" id="bannerPlaceholder"></i>
                                            <p class="text-muted small mt-2 mb-0" id="bannerText">Click or drag</p>
                                        <?php endif; ?>
                                    </div>
                                    <input type="file" class="d-none" id="banner" name="banner"
                                           accept="image/*" onchange="previewImage(this, 'banner')">
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="checkbox" id="remove_banner" name="remove_banner" value="1">
                                        <label class="form-check-label text-danger small" for="remove_banner">
                                            Remove current banner
                                        </label>
                                    </div>
                                    <?php $__errorArgs = ['banner'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                
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
                                    <input type="text" class="form-control <?php $__errorArgs = ['meta_title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           id="meta_title" name="meta_title" value="<?php echo e(old('meta_title', $brand->meta_title)); ?>"
                                           placeholder="SEO title">
                                    <small class="text-muted">Recommended: 50-60 characters</small>
                                    <?php $__errorArgs = ['meta_title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="canonical_url" class="form-label">Canonical URL</label>
                                    <input type="url" class="form-control <?php $__errorArgs = ['canonical_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           id="canonical_url" name="canonical_url" value="<?php echo e(old('canonical_url', $brand->canonical_url)); ?>"
                                           placeholder="https://example.com/brand-page">
                                    <small class="text-muted">Preferred URL for SEO</small>
                                    <?php $__errorArgs = ['canonical_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="mb-3">
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
                                          placeholder="SEO description"><?php echo e(old('meta_description', $brand->meta_description)); ?></textarea>
                                <small class="text-muted">Recommended: 150-160 characters</small>
                                <?php $__errorArgs = ['meta_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="mb-3">
                                <label for="meta_keywords" class="form-label">Meta Keywords</label>
                                <input type="text" class="form-control <?php $__errorArgs = ['meta_keywords'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="meta_keywords" name="meta_keywords" value="<?php echo e(old('meta_keywords', $brand->meta_keywords)); ?>"
                                       placeholder="keyword1, keyword2, keyword3">
                                <small class="text-muted">Comma-separated keywords</small>
                                <?php $__errorArgs = ['meta_keywords'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="mb-0">
                                <label class="form-label">Open Graph Image</label>
                                <div class="dropzone-wrapper border rounded p-3 text-center bg-light position-relative"
                                     onclick="document.getElementById('og_image').click()"
                                     ondragover="event.preventDefault()"
                                     ondrop="handleDrop(event, 'og_image')">
                                    <?php if($brand->og_image): ?>
                                        <img id="og_imagePreview" src="<?php echo e($brand->og_image_url); ?>" alt="OG Image"
                                             class="img-fluid rounded mb-2" style="max-height: 120px;">
                                        <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2"
                                                onclick="event.stopPropagation(); removeImage('og_image')">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    <?php else: ?>
                                        <img id="og_imagePreview" src="#" alt="Preview"
                                             class="img-fluid rounded d-none mb-2" style="max-height: 120px;">
                                        <i class="fas fa-share-alt fa-3x text-muted" id="og_imagePlaceholder"></i>
                                        <p class="text-muted small mt-2 mb-0" id="og_imageText">Click or drag</p>
                                    <?php endif; ?>
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
                                <?php $__errorArgs = ['og_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                    </div>
                </div>

                
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
                                        <span class="small text-muted ms-2"><?php echo e($brand->created_at->diffForHumans()); ?></span>
                                    </div>
                                    <p class="small mb-0">By <?php echo e($brand->activityLogs()->where('description', 'like', '%created%')->first()?->causer?->name ?? 'System'); ?></p>
                                </div>
                            </div>
                            <div class="tm-item">
                                <div class="tmtm-inner">
                                    <div class="tm-group">
                                        <span class="badge bg-info">Updated</span>
                                        <span class="small text-muted ms-2"><?php echo e($brand->updated_at->diffForHumans()); ?></span>
                                    </div>
                                    <p class="small mb-0">By <?php echo e($brand->activityLogs()->where('description', 'like', '%updated%')->first()?->causer?->name ?? 'System'); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="col-lg-4">
                
                <div class="card mb-4">
                    <div class="card-header bg-transparent">
                        <h6 class="fw-bold mb-0">Status & Visibility</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="status" name="status">
                                <option value="active" <?php echo e(old('status', $brand->status->value) === 'active' ? 'selected' : ''); ?>>Active</option>
                                <option value="inactive" <?php echo e(old('status', $brand->status->value) === 'inactive' ? 'selected' : ''); ?>>Inactive</option>
                                <option value="hidden" <?php echo e(old('status', $brand->status->value) === 'hidden' ? 'selected' : ''); ?>>Hidden</option>
                            </select>
                            <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label d-block">Flags</label>
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" id="featured" name="featured" value="1"
                                       <?php echo e(old('featured', $brand->featured) ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="featured">
                                    <i class="fas fa-star text-warning me-1"></i> Featured
                                </label>
                            </div>
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" id="popular" name="popular" value="1"
                                       <?php echo e(old('popular', $brand->popular) ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="popular">
                                    <i class="fas fa-fire text-info me-1"></i> Popular
                                </label>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_hidden" name="is_hidden" value="1"
                                       <?php echo e(old('is_hidden', $brand->is_hidden) ? 'checked' : ''); ?>>
                                <label class="form-check-label text-muted" for="is_hidden">
                                    <i class="fas fa-eye-slash me-1"></i> Hidden from listings
                                </label>
                            </div>
                        </div>

                        <div class="mb-0">
                            <label for="sort_order" class="form-label">Sort Order</label>
                            <input type="number" class="form-control <?php $__errorArgs = ['sort_order'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   id="sort_order" name="sort_order" value="<?php echo e(old('sort_order', $brand->sort_order)); ?>" min="0">
                            <small class="text-muted">Lower numbers appear first</small>
                            <?php $__errorArgs = ['sort_order'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>

                
                <div class="card mb-4">
                    <div class="card-header bg-transparent">
                        <h6 class="fw-bold mb-0">Quick Info</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Total Products</span>
                            <span class="badge bg-primary"><?php echo e($brand->products_count); ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Brand Code</span>
                            <span class="small"><?php echo e($brand->brand_code ?? '—'); ?></span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Created</span>
                            <span class="small"><?php echo e($brand->created_at->format('M d, Y')); ?></span>
                        </div>
                    </div>
                </div>

                
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


<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Brand</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete <strong><?php echo e($brand->name); ?></strong>?</p>
                <?php if($brand->products()->count() > 0): ?>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        This brand has <?php echo e($brand->products()->count()); ?> products. Please remove them first.
                    </div>
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="<?php echo e(route('admin.brands.destroy', $brand->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-danger" <?php echo e($brand->products()->count() > 0 ? 'disabled' : ''); ?>>
                        <i class="fas fa-trash me-1"></i> Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
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
    $('<form>').attr({ method: 'POST', action: `/admin/brands/<?php echo e($brand->id); ?>/duplicate` })
        .append($('<input>').attr({ type: 'hidden', name: '_token', value: '<?php echo e(csrf_token()); ?>' }))
        .appendTo('body').submit();
}

function confirmDelete() {
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\admin\brands\edit.blade.php ENDPATH**/ ?>