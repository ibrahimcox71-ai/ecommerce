<?php if (isset($component)) { $__componentOriginaledc75c655a063d12a477f2c8d8f324fc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc = $attributes; } ?>
<?php $component = App\View\Components\Layouts\AdminLayout::resolve(['title' => 'Create Category'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Create Category</h4>
            <p class="text-muted small mb-0">Add a new product category</p>
        </div>
        <a href="<?php echo e(route('admin.categories.index')); ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>

    <form method="POST" action="<?php echo e(route('admin.categories.store')); ?>" enctype="multipart/form-data" id="categoryForm">
        <?php echo csrf_field(); ?>

        <div class="row g-4">
            <div class="col-lg-8">
                
                <div class="card mb-4">
                    <div class="card-header bg-transparent">
                        <h6 class="fw-bold mb-0">Basic Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Category Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   id="name" name="name" value="<?php echo e(old('name')); ?>"
                                   placeholder="Enter category name" required>
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

                        <div class="row g-3">
                            <div class="col-md-6">
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
                                               id="slug" name="slug" value="<?php echo e(old('slug')); ?>"
                                               placeholder="auto-generated">
                                        <button type="button" class="btn btn-outline-secondary" onclick="generateSlug()" title="Regenerate">
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
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="category_code" class="form-label">Category Code</label>
                                    <input type="text" class="form-control <?php $__errorArgs = ['category_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           id="category_code" name="category_code" value="<?php echo e(old('category_code')); ?>"
                                           placeholder="CAT-001">
                                    <small class="text-muted">Unique identifier (optional)</small>
                                    <?php $__errorArgs = ['category_code'];
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
                                      placeholder="Brief description (max 500 chars)"><?php echo e(old('short_description')); ?></textarea>
                            <small class="text-muted">Displayed in category cards and listings</small>
                            <?php $__errorArgs = ['short_description'];
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
                            <label for="description" class="form-label">Full Description</label>
                            <textarea class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                      id="description" name="description" rows="5"
                                      placeholder="Detailed category description"><?php echo e(old('description')); ?></textarea>
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
                    </div>
                </div>

                
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
                                    <input type="text" class="form-control <?php $__errorArgs = ['meta_title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           id="meta_title" name="meta_title" value="<?php echo e(old('meta_title')); ?>"
                                           placeholder="SEO title" maxlength="255">
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
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="canonical_url" class="form-label">Canonical URL</label>
                                    <input type="url" class="form-control <?php $__errorArgs = ['canonical_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           id="canonical_url" name="canonical_url" value="<?php echo e(old('canonical_url')); ?>"
                                           placeholder="https://example.com/category">
                                    <small class="text-muted">Preferred version of this page</small>
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
                                      id="meta_description" name="meta_description" rows="2"
                                      placeholder="SEO meta description"><?php echo e(old('meta_description')); ?></textarea>
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

                        <div class="mb-0">
                            <label for="meta_keywords" class="form-label">Meta Keywords</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['meta_keywords'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   id="meta_keywords" name="meta_keywords" value="<?php echo e(old('meta_keywords')); ?>"
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
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                
                <div class="card mb-4">
                    <div class="card-header bg-transparent">
                        <h6 class="fw-bold mb-0">Media</h6>
                    </div>
                    <div class="card-body">
                        <?php if (isset($component)) { $__componentOriginalc5fc9ae25a3453387752c18751bff3e8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc5fc9ae25a3453387752c18751bff3e8 = $attributes; } ?>
<?php $component = App\View\Components\Admin\Category\MediaUploader::resolve(['name' => 'image','label' => 'Category Image','currentImage' => null,'accept' => 'image/*','maxSize' => '2MB','recommended' => '512x512px'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.category.media-uploader'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Admin\Category\MediaUploader::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc5fc9ae25a3453387752c18751bff3e8)): ?>
<?php $attributes = $__attributesOriginalc5fc9ae25a3453387752c18751bff3e8; ?>
<?php unset($__attributesOriginalc5fc9ae25a3453387752c18751bff3e8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc5fc9ae25a3453387752c18751bff3e8)): ?>
<?php $component = $__componentOriginalc5fc9ae25a3453387752c18751bff3e8; ?>
<?php unset($__componentOriginalc5fc9ae25a3453387752c18751bff3e8); ?>
<?php endif; ?>

                        <?php if (isset($component)) { $__componentOriginalc5fc9ae25a3453387752c18751bff3e8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc5fc9ae25a3453387752c18751bff3e8 = $attributes; } ?>
<?php $component = App\View\Components\Admin\Category\MediaUploader::resolve(['name' => 'thumbnail','label' => 'Thumbnail','currentImage' => null,'accept' => 'image/*','maxSize' => '1MB','recommended' => '300x300px','helpText' => 'Small preview image. JPG, PNG, WEBP. Max 1MB.'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.category.media-uploader'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Admin\Category\MediaUploader::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc5fc9ae25a3453387752c18751bff3e8)): ?>
<?php $attributes = $__attributesOriginalc5fc9ae25a3453387752c18751bff3e8; ?>
<?php unset($__attributesOriginalc5fc9ae25a3453387752c18751bff3e8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc5fc9ae25a3453387752c18751bff3e8)): ?>
<?php $component = $__componentOriginalc5fc9ae25a3453387752c18751bff3e8; ?>
<?php unset($__componentOriginalc5fc9ae25a3453387752c18751bff3e8); ?>
<?php endif; ?>

                        <?php if (isset($component)) { $__componentOriginalc5fc9ae25a3453387752c18751bff3e8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc5fc9ae25a3453387752c18751bff3e8 = $attributes; } ?>
<?php $component = App\View\Components\Admin\Category\MediaUploader::resolve(['name' => 'banner','label' => 'Banner','currentImage' => null,'accept' => 'image/*','maxSize' => '5MB','recommended' => '1200x400px','helpText' => 'Category page banner. JPG, PNG, WEBP. Max 5MB.'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.category.media-uploader'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Admin\Category\MediaUploader::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc5fc9ae25a3453387752c18751bff3e8)): ?>
<?php $attributes = $__attributesOriginalc5fc9ae25a3453387752c18751bff3e8; ?>
<?php unset($__attributesOriginalc5fc9ae25a3453387752c18751bff3e8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc5fc9ae25a3453387752c18751bff3e8)): ?>
<?php $component = $__componentOriginalc5fc9ae25a3453387752c18751bff3e8; ?>
<?php unset($__componentOriginalc5fc9ae25a3453387752c18751bff3e8); ?>
<?php endif; ?>

                        <?php if (isset($component)) { $__componentOriginalc5fc9ae25a3453387752c18751bff3e8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc5fc9ae25a3453387752c18751bff3e8 = $attributes; } ?>
<?php $component = App\View\Components\Admin\Category\MediaUploader::resolve(['name' => 'seo_image','label' => 'SEO Image (OG)','currentImage' => null,'accept' => 'image/*','maxSize' => '2MB','recommended' => '1200x630px','helpText' => 'Open Graph image for social sharing. JPG, PNG, WEBP. Max 2MB.'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.category.media-uploader'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Admin\Category\MediaUploader::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc5fc9ae25a3453387752c18751bff3e8)): ?>
<?php $attributes = $__attributesOriginalc5fc9ae25a3453387752c18751bff3e8; ?>
<?php unset($__attributesOriginalc5fc9ae25a3453387752c18751bff3e8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc5fc9ae25a3453387752c18751bff3e8)): ?>
<?php $component = $__componentOriginalc5fc9ae25a3453387752c18751bff3e8; ?>
<?php unset($__componentOriginalc5fc9ae25a3453387752c18751bff3e8); ?>
<?php endif; ?>

                        <div class="mb-0">
                            <label for="icon" class="form-label">Icon Class</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['icon'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   id="icon" name="icon" value="<?php echo e(old('icon')); ?>"
                                   placeholder="fas fa-tag">
                            <small class="text-muted">Font Awesome icon class (e.g., fas fa-tag)</small>
                            <?php $__errorArgs = ['icon'];
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
                        <h6 class="fw-bold mb-0">Organization</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="parent_id" class="form-label">Parent Category</label>
                            <select class="form-select <?php $__errorArgs = ['parent_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="parent_id" name="parent_id">
                                <option value="">None (Top Level)</option>
                                <?php $__currentLoopData = $parentCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($parent->id); ?>" <?php echo e(old('parent_id') == $parent->id ? 'selected' : ''); ?>>
                                        <?php echo e($parent->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <small class="text-muted">Select parent to create a subcategory</small>
                            <?php $__errorArgs = ['parent_id'];
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
                            <label for="sort_order" class="form-label">Sort Order</label>
                            <input type="number" class="form-control <?php $__errorArgs = ['sort_order'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   id="sort_order" name="sort_order" value="<?php echo e(old('sort_order', 0)); ?>" min="0">
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

                        <div class="mb-0">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="status" name="status">
                                <option value="active" <?php echo e(old('status', 'active') === 'active' ? 'selected' : ''); ?>>Active</option>
                                <option value="inactive" <?php echo e(old('status') === 'inactive' ? 'selected' : ''); ?>>Inactive</option>
                                <option value="draft" <?php echo e(old('status') === 'draft' ? 'selected' : ''); ?>>Draft</option>
                                <option value="hidden" <?php echo e(old('status') === 'hidden' ? 'selected' : ''); ?>>Hidden</option>
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
                    </div>
                </div>

                
                <div class="card mb-4">
                    <div class="card-header bg-transparent">
                        <h6 class="fw-bold mb-0">Display Settings</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="featured" name="featured" value="1"
                                       <?php echo e(old('featured') ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="featured">Featured Category</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="popular" name="popular" value="1"
                                       <?php echo e(old('popular') ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="popular">Popular Category</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="show_on_homepage" name="show_on_homepage" value="1"
                                       <?php echo e(old('show_on_homepage') ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="show_on_homepage">Show on Homepage</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="show_in_mega_menu" name="show_in_mega_menu" value="1"
                                       <?php echo e(old('show_in_mega_menu') ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="show_in_mega_menu">Show in Mega Menu</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="show_in_mobile_menu" name="show_in_mobile_menu" value="1"
                                       <?php echo e(old('show_in_mobile_menu') ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="show_in_mobile_menu">Show in Mobile Menu</label>
                            </div>
                        </div>
                        <div class="mb-0">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="show_in_sidebar" name="show_in_sidebar" value="1"
                                       <?php echo e(old('show_in_sidebar') ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="show_in_sidebar">Show in Sidebar</label>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save me-2"></i> Create Category
                    </button>
                    <button type="reset" class="btn btn-outline-secondary">
                        <i class="fas fa-undo me-2"></i> Reset Form
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

$('#name').on('blur', function() {
    if (!$('#slug').val()) {
        generateSlug();
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\admin\categories\create.blade.php ENDPATH**/ ?>