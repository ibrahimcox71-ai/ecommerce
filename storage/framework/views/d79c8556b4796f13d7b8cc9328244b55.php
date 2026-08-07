<?php if (isset($component)) { $__componentOriginaleac9542bb5e3f887e862d1d96c472e9b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaleac9542bb5e3f887e862d1d96c472e9b = $attributes; } ?>
<?php $component = App\View\Components\Layouts\FrontendLayout::resolve(['title' => 'Product','seoData' => $seoData ?? []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.frontend-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\FrontendLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php $title = $product->name ?>


<div class="product-detail-page pb-5">
    <div class="container">
        <div class="row g-4 g-xl-5">

            
            <div class="col-12 pt-3 pb-2">
                <?php if (isset($component)) { $__componentOriginale19f62b34dfe0bfdf95075badcb45bc2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumb','data' => ['class' => 'product-breadcrumb','items' => [
                    ['label' => 'Shop', 'url' => route('shop')],
                    ['label' => $product->category?->name ?? 'Products', 'url' => $product->category ? route('category.show', $product->category->slug) : '#'],
                    ['label' => $product->name],
                ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('breadcrumb'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'product-breadcrumb','items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                    ['label' => 'Shop', 'url' => route('shop')],
                    ['label' => $product->category?->name ?? 'Products', 'url' => $product->category ? route('category.show', $product->category->slug) : '#'],
                    ['label' => $product->name],
                ])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2)): ?>
<?php $attributes = $__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2; ?>
<?php unset($__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale19f62b34dfe0bfdf95075badcb45bc2)): ?>
<?php $component = $__componentOriginale19f62b34dfe0bfdf95075badcb45bc2; ?>
<?php unset($__componentOriginale19f62b34dfe0bfdf95075badcb45bc2); ?>
<?php endif; ?>
            </div>

            
            <div class="col-12">
                <h1 class="product-title mb-0"><?php echo e($product->name); ?></h1>
            </div>

            
            <div class="col-lg-6">
                <div class="product-gallery-wrapper">
                    
                    <div class="product-gallery-badges">
                        <?php if($product->has_discount): ?>
                            <span class="gallery-badge badge-discount">-<?php echo e($product->discount_type === 'percentage' ? $product->discount . '%' : '$' . number_format($product->discount, 2)); ?> OFF</span>
                        <?php endif; ?>
                        <?php if($product->is_new_arrival): ?>
                            <span class="gallery-badge badge-new">New Arrival</span>
                        <?php endif; ?>
                        <?php if($product->is_out_of_stock): ?>
                            <span class="gallery-badge badge-oos">Sold Out</span>
                        <?php elseif($product->is_low_stock): ?>
                            <span class="gallery-badge badge-low-stock">Only <?php echo e($product->stock); ?> Left</span>
                        <?php endif; ?>
                        <?php if($product->free_shipping ?? false): ?>
                            <span class="gallery-badge badge-free-ship">Free Shipping</span>
                        <?php endif; ?>
                    </div>

                    
                    <?php $_primaryImg = $product->images->first()?->image_url ?? $product->thumbnail_url ?? asset('images/no-image.svg'); ?>
                    <div class="main-image-container" id="mainImageContainer">
                        <div class="main-image-wrapper">
                            <img src="<?php echo e($_primaryImg); ?>"
                                 alt="<?php echo e($product->name); ?>"
                                 id="mainProductImage"
                                 class="main-product-image"
                                 data-zoom="<?php echo e($_primaryImg); ?>">
                            <div class="image-zoom-lens" id="imageZoomLens"></div>
                            <div class="image-zoom-result" id="imageZoomResult"></div>
                        </div>
                        <button class="gallery-nav prev" id="galleryPrev" aria-label="Previous image"><i class="fas fa-chevron-left"></i></button>
                        <button class="gallery-nav next" id="galleryNext" aria-label="Next image"><i class="fas fa-chevron-right"></i></button>
                        <button class="gallery-fullscreen-btn" id="fullscreenBtn" aria-label="View fullscreen"><i class="fas fa-expand"></i></button>
                    </div>

                    
                    <div class="thumbnail-strip" id="thumbnailStrip">
                        <button class="thumb-scroll-btn left" id="thumbScrollLeft" aria-label="Scroll thumbnails left"><i class="fas fa-chevron-left"></i></button>
                        <div class="thumbnails-wrapper" id="thumbnailsWrapper">
                            <?php $__empty_1 = true; $__currentLoopData = $product->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="thumbnail-item <?php echo e($loop->first ? 'active' : ''); ?>"
                                     data-image="<?php echo e($image->image_url); ?>"
                                     data-zoom="<?php echo e($image->image_url); ?>"
                                     role="button" tabindex="0"
                                     aria-label="View image <?php echo e($loop->iteration); ?>">
                                    <img src="<?php echo e($image->image_url); ?>" alt="<?php echo e($image->alt_text ?? $product->name . ' ' . $loop->iteration); ?>" loading="lazy">
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <div class="thumbnail-item active" data-image="<?php echo e($_primaryImg); ?>" role="button" tabindex="0">
                                    <img src="<?php echo e($_primaryImg); ?>" alt="<?php echo e($product->name); ?>">
                                </div>
                            <?php endif; ?>
                            <?php if($product->video_url): ?>
                                <div class="thumbnail-item video-thumb" data-video="<?php echo e($product->video_url); ?>" role="button" tabindex="0" aria-label="View product video">
                                    <i class="fas fa-play"></i>
                                    <img src="https://placehold.co/100x100/1a1a2e/fff?text=Video" alt="Video">
                                </div>
                            <?php endif; ?>
                        </div>
                        <button class="thumb-scroll-btn right" id="thumbScrollRight" aria-label="Scroll thumbnails right"><i class="fas fa-chevron-right"></i></button>
                    </div>
                </div>
            </div>

            
            <div class="col-lg-6 align-self-start">
                <div class="product-info-wrapper sticky-product-info">

                    
                    <?php if($product->brand): ?>
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <a href="<?php echo e(route('brand.show', $product->brand->slug)); ?>" class="product-brand-link">
                                <?php echo e($product->brand->name); ?>

                            </a>
                            <?php if($product->brand->featured ?? false): ?>
                                <span class="badge bg-success-subtle text-success-emphasis rounded-pill px-3 py-1 fs-sm fw-semibold">
                                    <i class="fas fa-check-circle me-1"></i>Verified
                                </span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    
                    <div class="d-flex align-items-center gap-2 mb-2 flex-wrap">
                        <span class="info-badge badge-seller">
                            <i class="fas fa-store me-1"></i><?php echo e(config('app.name')); ?>

                        </span>
                        <span class="info-badge badge-response">
                            <i class="fas fa-clock me-1"></i>Response &lt; 1h
                        </span>
                    </div>

                    
                    <div class="d-flex flex-wrap align-items-center gap-3 mb-4">
                        <div class="d-flex align-items-center gap-2">
                            <div class="rating-stars-display">
                                <?php for($i = 1; $i <= 5; $i++): ?>
                                    <?php if($i <= floor($product->average_rating)): ?>
                                        <i class="fas fa-star"></i>
                                    <?php elseif($i - 0.5 <= $product->average_rating): ?>
                                        <i class="fas fa-star-half-alt"></i>
                                    <?php else: ?>
                                        <i class="far fa-star"></i>
                                    <?php endif; ?>
                                <?php endfor; ?>
                            </div>
                            <a href="#reviews-section" class="fw-semibold text-body text-decoration-none fs-sm">
                                <?php echo e(number_format($product->average_rating, 1)); ?>

                                <span class="text-muted fw-normal">(<?php echo e($product->review_count); ?> reviews)</span>
                            </a>
                        </div>
                        <span class="text-muted fs-sm d-flex align-items-center gap-1">
                            <i class="fas fa-shopping-bag"></i> <?php echo e($totalSold ?? 0); ?> sold
                        </span>
                        <span class="text-muted fs-sm">SKU: <strong class="text-body"><?php echo e($product->sku); ?></strong></span>
                    </div>

                    
                    <div class="product-price-section mb-4">
                        <div class="d-flex align-items-baseline gap-3 flex-wrap">
                            <span class="current-price">$<?php echo e(number_format($product->current_price, 2)); ?></span>
                            <?php if($product->has_discount): ?>
                                <span class="old-price">$<?php echo e(number_format($product->price, 2)); ?></span>
                                <span class="discount-badge-lg">-<?php echo e($product->discount_percentage); ?>%</span>
                            <?php endif; ?>
                        </div>
                        <?php if($product->has_discount): ?>
                            <div class="text-success fw-semibold fs-sm mt-1 mb-2">
                                <i class="fas fa-leaf me-1"></i>You save <strong>$<?php echo e(number_format($product->price - $product->current_price, 2)); ?></strong>
                            </div>
                        <?php endif; ?>
                        <div class="d-flex flex-wrap align-items-center gap-3 mt-1">
                            <span class="text-muted fs-xs">Tax included. <a href="#" class="text-decoration-underline" data-bs-toggle="tooltip" title="Estimated tax based on your location">Learn more</a></span>
                            <?php if($product->max_order_quantity > 1): ?>
                                <span class="badge bg-info-subtle text-info-emphasis rounded-pill px-3 py-1 fs-xs fw-semibold">
                                    <i class="fas fa-boxes me-1"></i>Bulk discounts available
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>

                    
                    <div class="d-flex flex-wrap gap-2 mb-4">
                        <?php if($product->is_out_of_stock): ?>
                            <div class="stock-badge out-of-stock"><i class="fas fa-times-circle me-1"></i> Out of Stock</div>
                        <?php elseif($product->is_low_stock): ?>
                            <div class="stock-badge low-stock"><i class="fas fa-exclamation-triangle me-1"></i> Only <?php echo e($product->stock); ?> left in stock</div>
                        <?php else: ?>
                            <div class="stock-badge in-stock"><i class="fas fa-check-circle me-1"></i> In Stock</div>
                        <?php endif; ?>
                        <?php if($product->unlimited_stock): ?>
                            <div class="stock-badge unlimited"><i class="fas fa-infinity me-1"></i> Unlimited Stock</div>
                        <?php endif; ?>
                    </div>

                    
                    <?php if($product->variants->isNotEmpty()): ?>
                        <div class="mb-4" id="variantSection">
                            <?php $groupedAttributes = $product->variants->flatMap->attributeValues->groupBy(fn($av) => $av->attribute?->name ?? 'Option'); ?>
                            <?php $__currentLoopData = $groupedAttributes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attrName => $attrValues): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="variant-group">
                                    <label class="variant-label"><?php echo e($attrName); ?>: <span class="selected-value" id="selected_<?php echo e(Str::slug($attrName)); ?>"><?php echo e($attrValues->first()?->value ?? 'Select'); ?></span></label>
                                    <div class="variant-options">
                                        <?php $__currentLoopData = $attrValues->unique('value'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $av): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <button class="variant-btn <?php echo e($loop->first ? 'active' : ''); ?>"
                                                    data-attribute="<?php echo e(Str::slug($attrName)); ?>"
                                                    data-value="<?php echo e($av->value); ?>"
                                                    data-variant-id="<?php echo e($av->pivot->product_variant_id ?? ''); ?>"
                                                    type="button"
                                                    aria-label="<?php echo e($attrName); ?>: <?php echo e($av->value); ?>"><?php echo e($av->value); ?></button>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endif; ?>

                    
                    <div class="mb-4">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div>
                                <label class="fs-sm fw-semibold text-body-secondary mb-2 d-block">Quantity</label>
                                <div class="quantity-selector">
                                    <button class="qty-btn" id="qtyDecrease" aria-label="Decrease quantity" <?php echo e(!$product->is_in_stock ? 'disabled' : ''); ?>><i class="fas fa-minus"></i></button>
                                    <input type="number" id="qtyInput" value="<?php echo e($product->min_order_quantity ?: 1); ?>" min="<?php echo e($product->min_order_quantity ?: 1); ?>" max="<?php echo e($product->max_order_quantity ?: 99); ?>" step="1" aria-label="Quantity">
                                    <button class="qty-btn" id="qtyIncrease" aria-label="Increase quantity" <?php echo e(!$product->is_in_stock ? 'disabled' : ''); ?>><i class="fas fa-plus"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex gap-3 mb-3 flex-wrap">
                            <button type="button" class="btn-atc btn-ripple flex-fill" id="addToCartBtn"
                                    data-product-id="<?php echo e($product->id); ?>"
                                    <?php echo e(!$product->is_in_stock ? 'disabled' : ''); ?>>
                                <i class="fas fa-shopping-bag"></i>
                                <span><?php echo e($product->is_in_stock ? 'Add to Cart' : 'Sold Out'); ?></span>
                            </button>
                            <button type="button" class="btn-buy-now btn-ripple flex-fill" id="buyNowBtn"
                                    data-product-id="<?php echo e($product->id); ?>"
                                    <?php echo e(!$product->is_in_stock ? 'disabled' : ''); ?>>
                                <i class="fas fa-bolt"></i>
                                <span>Buy Now</span>
                            </button>
                        </div>
                        <div class="d-flex gap-2 flex-wrap">
                            <button class="action-icon-btn wishlist-btn" data-product-id="<?php echo e($product->id); ?>" aria-label="Add to wishlist">
                                <i class="far fa-heart"></i><span>Wishlist</span>
                            </button>
                            <button class="action-icon-btn compare-btn" data-product-id="<?php echo e($product->id); ?>" aria-label="Add to compare">
                                <i class="fas fa-random"></i><span>Compare</span>
                            </button>
                            <button class="action-icon-btn share-btn" data-bs-toggle="modal" data-bs-target="#shareModal" aria-label="Share product">
                                <i class="fas fa-share-alt"></i><span>Share</span>
                            </button>
                            <button class="action-icon-btn report-btn" data-bs-toggle="modal" data-bs-target="#reportModal" aria-label="Report product">
                                <i class="fas fa-flag"></i><span>Report</span>
                            </button>
                        </div>
                    </div>

                    
                    <div class="row g-2 mb-3">
                        <div class="col-md-4">
                            <div class="icon-card">
                                <div class="icon-card-icon"><i class="fas fa-truck"></i></div>
                                <div class="icon-card-text"><strong>Free Delivery</strong><span>Est. <?php echo e(date('D, M d', strtotime('+5 days'))); ?> - <?php echo e(date('D, M d', strtotime('+8 days'))); ?></span></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="icon-card">
                                <div class="icon-card-icon"><i class="fas fa-undo"></i></div>
                                <div class="icon-card-text"><strong>30-Day Returns</strong><span>Easy & hassle-free</span></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="icon-card">
                                <div class="icon-card-icon"><i class="fas fa-shield-alt"></i></div>
                                <div class="icon-card-text"><strong>1 Year Warranty</strong><span>Manufacturer included</span></div>
                            </div>
                        </div>
                    </div>

                    
                    <div class="emi-section mb-3">
                        <i class="fas fa-credit-card"></i>
                        <div class="emi-text">
                            <strong>4 interest-free payments</strong> of <strong>$<?php echo e(number_format($product->current_price / 4, 2)); ?></strong>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#emiModal">Learn more</a>
                        </div>
                    </div>

                    
                    <div class="coupon-section mb-3">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="coupon-icon-wrap"><i class="fas fa-tag"></i></div>
                            <div class="flex-grow-1">
                                <small class="text-muted fw-semibold">HAVE A COUPON?</small>
                                <div class="input-group mt-1">
                                    <input type="text" id="couponInput" class="form-control border-end-0" placeholder="Enter code" aria-label="Coupon code">
                                    <button type="button" class="btn btn-primary px-3" id="applyCouponBtn">Apply</button>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex gap-2 flex-wrap">
                            <span class="coupon-chip"><i class="fas fa-bolt"></i> SAVE10</span>
                            <span class="coupon-chip"><i class="fas fa-bolt"></i> FREESHIP</span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


<section class="py-5 bg-body-tertiary" id="productTabsSection">
    <div class="container">
        <ul class="nav nav-tabs-custom" id="productTabsNav" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-description" type="button" role="tab" aria-selected="true">
                    <i class="fas fa-file-alt me-2"></i>Description
                </button>
            </li>
            <?php if($product->specifications): ?>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-specifications" type="button" role="tab" aria-selected="false">
                        <i class="fas fa-list me-2"></i>Specifications
                    </button>
                </li>
            <?php endif; ?>
            <li class="nav-item" role="presentation">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-reviews" type="button" role="tab" aria-selected="false">
                    <i class="fas fa-star me-2"></i>Reviews (<?php echo e($reviews->total()); ?>)
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-qa" type="button" role="tab" aria-selected="false">
                    <i class="fas fa-question-circle me-2"></i>Q&A
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-warranty" type="button" role="tab" aria-selected="false">
                    <i class="fas fa-shield-alt me-2"></i>Warranty
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-shipping" type="button" role="tab" aria-selected="false">
                    <i class="fas fa-truck me-2"></i>Shipping
                </button>
            </li>
        </ul>

        <div class="tab-content p-4 bg-white rounded-bottom-3 border border-top-0 shadow-sm">
            
            <div class="tab-pane fade show active" id="tab-description" role="tabpanel">
                <div class="description-content">
                    <?php if($product->short_description): ?>
                        <p class="fs-5 text-body-secondary lh-lg mb-4"><?php echo e($product->short_description); ?></p>
                    <?php endif; ?>
                    <div class="description-body">
                        <?php echo nl2br(e($product->description)); ?>

                    </div>
                </div>
            </div>

            
            <?php if($product->specifications): ?>
                <div class="tab-pane fade" id="tab-specifications" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-borderless specs-table">
                            <tbody>
                                <?php $__currentLoopData = $product->specifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="text-muted fw-medium px-0 py-3" style="width:35%"><?php echo e($key); ?></td>
                                        <td class="fw-semibold px-0 py-3"><?php echo e(is_array($value) ? implode(', ', $value) : $value); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>

            
            <div class="tab-pane fade" id="tab-reviews" role="tabpanel">
                <div id="reviews-section">
                    <div class="d-flex flex-wrap align-items-start gap-4 mb-4">
                        <div class="d-flex gap-4 flex-wrap flex-fill">
                            <div class="text-center p-4 bg-body-tertiary rounded-3" style="min-width:160px">
                                <div class="display-3 fw-black lh-1 mb-1"><?php echo e(number_format($product->average_rating, 1)); ?></div>
                                <div class="rating-stars-display justify-content-center mb-1">
                                    <?php for($i = 1; $i <= 5; $i++): ?>
                                        <i class="fas fa-star <?php echo e($i <= round($product->average_rating) ? 'active' : ''); ?>"></i>
                                    <?php endfor; ?>
                                </div>
                                <small class="text-muted"><?php echo e($reviews->total()); ?> reviews</small>
                            </div>
                            <div class="flex-fill">
                                <?php for($i = 5; $i >= 1; $i--): ?>
                                    <?php $pct = $reviews->total() > 0 ? round(($ratingBreakdown[$i] / $reviews->total()) * 100) : 0; ?>
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <span class="text-muted small" style="min-width:40px"><?php echo e($i); ?> <i class="fas fa-star text-warning"></i></span>
                                        <div class="progress flex-fill" style="height:8px">
                                            <div class="progress-bar bg-warning" style="width:<?php echo e($pct); ?>%"></div>
                                        </div>
                                        <span class="text-muted small" style="min-width:24px"><?php echo e($ratingBreakdown[$i]); ?></span>
                                    </div>
                                <?php endfor; ?>
                            </div>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="d-flex align-items-center gap-2">
                                <label class="text-muted small">Sort by:</label>
                                <select class="form-select form-select-sm" style="width:auto" onchange="window.location.href=this.value">
                                    <option value="<?php echo e(request()->fullUrlWithQuery(['review_sort' => 'latest'])); ?>" <?php if(request('review_sort', 'latest') === 'latest'): echo 'selected'; endif; ?>>Most Recent</option>
                                    <option value="<?php echo e(request()->fullUrlWithQuery(['review_sort' => 'highest'])); ?>" <?php if(request('review_sort') === 'highest'): echo 'selected'; endif; ?>>Highest Rated</option>
                                    <option value="<?php echo e(request()->fullUrlWithQuery(['review_sort' => 'lowest'])); ?>" <?php if(request('review_sort') === 'lowest'): echo 'selected'; endif; ?>>Lowest Rated</option>
                                    <option value="<?php echo e(request()->fullUrlWithQuery(['review_sort' => 'oldest'])); ?>" <?php if(request('review_sort') === 'oldest'): echo 'selected'; endif; ?>>Oldest</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    
                    <?php if(auth()->guard('web')->check()): ?>
                        <?php $hasReviewed = \App\Models\Review::where('user_id', auth()->guard('web')->id())->where('product_id', $product->id)->exists(); ?>
                        <?php if(!$hasReviewed): ?>
                            <div class="bg-body-tertiary rounded-3 p-4 mb-4">
                                <h5 class="mb-3"><i class="fas fa-pen me-2"></i>Write a Review</h5>
                                <form method="POST" action="<?php echo e(route('review.store', $product)); ?>" enctype="multipart/form-data">
                                    <?php echo csrf_field(); ?>
                                    <div class="d-flex align-items-center gap-3 mb-3">
                                        <label class="fw-medium">Your Rating <span class="text-danger">*</span></label>
                                        <div class="star-input-group">
                                            <?php for($i = 5; $i >= 1; $i--): ?>
                                                <input type="radio" name="rating" id="star<?php echo e($i); ?>" value="<?php echo e($i); ?>" <?php echo e($i === 5 ? 'checked' : ''); ?>>
                                                <label for="star<?php echo e($i); ?>"><i class="fas fa-star"></i></label>
                                            <?php endfor; ?>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <input type="text" name="title" class="form-control" placeholder="Review title (optional)">
                                    </div>
                                    <div class="mb-3">
                                        <textarea name="body" class="form-control" rows="4" required placeholder="Share your experience..."></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="btn btn-outline-secondary btn-sm"><i class="fas fa-camera me-1"></i>Add photos (max 5)<input type="file" name="images[]" class="d-none" multiple accept="image/*"></label>
                                    </div>
                                    <button type="submit" class="btn btn-primary px-4"><i class="fas fa-paper-plane me-2"></i>Submit Review</button>
                                </form>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="bg-body-tertiary rounded-3 p-4 text-center mb-4">
                            <p class="mb-0"><i class="fas fa-lock me-2"></i><a href="<?php echo e(route('login')); ?>" class="fw-semibold">Sign in</a> to write a review.</p>
                        </div>
                    <?php endif; ?>

                    
                    <div class="reviews-list">
                        <?php $__empty_1 = true; $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="review-card">
                                <div class="d-flex gap-3 align-items-start mb-2">
                                    <div class="reviewer-avatar rounded-circle bg-primary d-flex align-items-center justify-content-center text-white fw-bold flex-shrink-0"><?php echo e(strtoupper(substr($review->user?->name ?? 'A', 0, 1))); ?></div>
                                    <div class="flex-fill">
                                        <div class="d-flex align-items-center gap-2 flex-wrap">
                                            <strong><?php echo e($review->user?->name ?? 'Anonymous'); ?></strong>
                                            <?php if($review->is_verified): ?>
                                                <span class="badge bg-success-subtle text-success-emphasis rounded-pill"><i class="fas fa-check-circle me-1"></i>Verified Purchase</span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="d-flex align-items-center gap-2 mt-1">
                                            <div class="rating-stars-display" style="font-size:13px">
                                                <?php for($i = 1; $i <= 5; $i++): ?>
                                                    <i class="fas fa-star <?php echo e($i <= $review->rating ? 'active' : ''); ?>"></i>
                                                <?php endfor; ?>
                                            </div>
                                            <span class="text-muted small"><?php echo e($review->created_at->diffForHumans()); ?></span>
                                        </div>
                                    </div>
                                </div>
                                <?php if($review->title): ?>
                                    <h6 class="fw-bold mb-1"><?php echo e($review->title); ?></h6>
                                <?php endif; ?>
                                <p class="text-body-secondary mb-2"><?php echo e($review->body); ?></p>
                                <?php if($review->images->isNotEmpty()): ?>
                                    <div class="d-flex gap-2 mb-2">
                                        <?php $__currentLoopData = $review->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <a href="<?php echo e($img->image_url); ?>" target="_blank" class="review-img-link">
                                                <img src="<?php echo e($img->image_url); ?>" alt="Review image" loading="lazy">
                                            </a>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                <?php endif; ?>
                                <button class="btn btn-sm btn-outline-secondary rounded-pill helpful-btn" data-review-id="<?php echo e($review->id); ?>">
                                    <i class="far fa-thumbs-up me-1"></i> Helpful (<span class="helpful-count"><?php echo e($review->helpful_count); ?></span>)
                                </button>
                                <?php if($review->replies->isNotEmpty()): ?>
                                    <div class="mt-3 ps-4 border-start border-2">
                                        <?php $__currentLoopData = $review->replies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reply): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="mb-2">
                                                <strong class="text-primary small"><?php echo e($reply->admin?->name ?? 'Store'); ?></strong>
                                                <span class="text-muted small ms-2"><?php echo e($reply->created_at->diffForHumans()); ?></span>
                                                <p class="small text-body-secondary mt-1 mb-0"><?php echo e($reply->body); ?></p>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="text-center py-5 text-muted">
                                <i class="fas fa-comment-slash fs-1 mb-3 d-block"></i>
                                <p>No reviews yet. Be the first to review this product!</p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if($reviews->hasPages()): ?>
                        <div class="d-flex justify-content-center mt-4"><?php echo e($reviews->links()); ?></div>
                    <?php endif; ?>
                </div>
            </div>

            
            <div class="tab-pane fade" id="tab-qa" role="tabpanel">
                <div class="text-center py-4">
                    <i class="fas fa-question-circle fs-1 text-primary mb-3 d-block"></i>
                    <h5 class="fw-bold">Have a question?</h5>
                    <p class="text-muted mb-3">Search for answers or ask a question about this product.</p>
                    <div class="d-flex gap-2 mx-auto mb-3" style="max-width:400px">
                        <input type="text" class="form-control" placeholder="Search questions...">
                        <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                    </div>
                    <button class="btn btn-outline-primary"><i class="fas fa-plus me-2"></i>Ask a Question</button>
                </div>
            </div>

            
            <div class="tab-pane fade" id="tab-warranty" role="tabpanel">
                <div class="text-center py-4" style="max-width:600px;margin:0 auto">
                    <div class="icon-circle mx-auto mb-3"><i class="fas fa-shield-alt"></i></div>
                    <h5 class="fw-bold">Warranty Information</h5>
                    <?php if($product->warranty_type): ?>
                        <p class="mb-1"><strong>Warranty Type:</strong> <?php echo e(ucfirst($product->warranty_type)); ?></p>
                    <?php endif; ?>
                    <?php if($product->warranty_period): ?>
                        <p class="mb-1"><strong>Warranty Period:</strong> <?php echo e($product->warranty_period); ?> months</p>
                    <?php endif; ?>
                    <p class="text-body-secondary">This product comes with a manufacturer warranty against defects in materials and workmanship. For warranty claims, please contact our support team with your order number.</p>
                </div>
            </div>

            
            <div class="tab-pane fade" id="tab-shipping" role="tabpanel">
                <div class="text-center py-4" style="max-width:600px;margin:0 auto">
                    <div class="icon-circle mx-auto mb-3"><i class="fas fa-truck"></i></div>
                    <h5 class="fw-bold">Shipping Information</h5>
                    <div class="row g-3 mt-2">
                        <div class="col-md-4">
                            <div class="bg-body-tertiary rounded-3 p-3">
                                <strong class="d-block">Standard</strong>
                                <small class="text-muted d-block">5-8 business days</small>
                                <span class="badge bg-success-subtle text-success-emphasis mt-1">FREE</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-body-tertiary rounded-3 p-3">
                                <strong class="d-block">Express</strong>
                                <small class="text-muted d-block">2-3 business days</small>
                                <span class="fw-semibold mt-1 d-block">$12.99</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-body-tertiary rounded-3 p-3">
                                <strong class="d-block">Overnight</strong>
                                <small class="text-muted d-block">1 business day</small>
                                <span class="fw-semibold mt-1 d-block">$24.99</span>
                            </div>
                        </div>
                    </div>
                    <p class="text-muted small mt-3 mb-0">Orders placed before 2 PM EST ship same day. Free returns within 30 days.</p>
                </div>
            </div>
        </div>
    </div>
</section>


<?php if($relatedProducts->isNotEmpty()): ?>
    <section class="py-5">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <span class="section-bar"></span>
                        <h3 class="fw-bold mb-0">Related Products</h3>
                    </div>
                    <p class="text-muted mb-0">Customers who viewed this also viewed</p>
                </div>
                <a href="<?php echo e(route('shop')); ?>" class="btn btn-outline-primary rounded-pill btn-sm">View All <i class="fas fa-arrow-right ms-1"></i></a>
            </div>
            <div class="row g-3 g-md-4 row-cols-2 row-cols-md-3 row-cols-lg-4">
                <?php $__currentLoopData = $relatedProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $relProduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if (isset($component)) { $__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.product-card','data' => ['product' => $relProduct]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('product-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['product' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($relProduct)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a)): ?>
<?php $attributes = $__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a; ?>
<?php unset($__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a)): ?>
<?php $component = $__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a; ?>
<?php unset($__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a); ?>
<?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>
<?php endif; ?>


<?php if($alsoBought->isNotEmpty()): ?>
    <section class="py-5 bg-body-tertiary">
        <div class="container">
            <div class="d-flex align-items-center gap-2 mb-4">
                <span class="section-bar"></span>
                <h3 class="fw-bold mb-0">Frequently Bought Together</h3>
            </div>
            <div class="row g-3 g-md-4 row-cols-2 row-cols-md-3 row-cols-lg-4">
                <?php $__currentLoopData = $alsoBought; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alsoProduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if (isset($component)) { $__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.product-card','data' => ['product' => $alsoProduct]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('product-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['product' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($alsoProduct)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a)): ?>
<?php $attributes = $__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a; ?>
<?php unset($__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a)): ?>
<?php $component = $__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a; ?>
<?php unset($__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a); ?>
<?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>
<?php endif; ?>


<section class="py-5">
    <div class="container">
        <div class="row g-3">
            <div class="col-6 col-md">
                <div class="d-flex align-items-center gap-3 p-3 bg-white rounded-3 border shadow-sm h-100">
                    <div class="trust-icon-circle"><i class="fas fa-lock"></i></div>
                    <div><strong class="d-block small">Secure Checkout</strong><small class="text-muted">SSL encrypted</small></div>
                </div>
            </div>
            <div class="col-6 col-md">
                <div class="d-flex align-items-center gap-3 p-3 bg-white rounded-3 border shadow-sm h-100">
                    <div class="trust-icon-circle"><i class="fas fa-check-circle"></i></div>
                    <div><strong class="d-block small">100% Original</strong><small class="text-muted">Authentic guaranteed</small></div>
                </div>
            </div>
            <div class="col-6 col-md">
                <div class="d-flex align-items-center gap-3 p-3 bg-white rounded-3 border shadow-sm h-100">
                    <div class="trust-icon-circle"><i class="fas fa-undo"></i></div>
                    <div><strong class="d-block small">Easy Returns</strong><small class="text-muted">30-day policy</small></div>
                </div>
            </div>
            <div class="col-6 col-md">
                <div class="d-flex align-items-center gap-3 p-3 bg-white rounded-3 border shadow-sm h-100">
                    <div class="trust-icon-circle"><i class="fas fa-truck"></i></div>
                    <div><strong class="d-block small">Fast Shipping</strong><small class="text-muted">Free over $50</small></div>
                </div>
            </div>
            <div class="col-6 col-md">
                <div class="d-flex align-items-center gap-3 p-3 bg-white rounded-3 border shadow-sm h-100">
                    <div class="trust-icon-circle"><i class="fas fa-headset"></i></div>
                    <div><strong class="d-block small">24/7 Support</strong><small class="text-muted">We're here to help</small></div>
                </div>
            </div>
        </div>
    </div>
</section>


<div class="sticky-buy-bar" id="stickyBuyBar">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between gap-3">
            <div class="d-flex align-items-center gap-3">
                <img src="<?php echo e($product->images->first()?->image_url ?? ($product->thumbnail ? asset('storage/' . $product->thumbnail) : 'https://placehold.co/50x50/f0f0f0/999?text=N')); ?>"
                     alt="<?php echo e($product->name); ?>" class="rounded-2 border" style="width:48px;height:48px;object-fit:cover">
                <div>
                    <div class="fw-semibold text-truncate" style="max-width:280px"><?php echo e($product->name); ?></div>
                    <div class="fw-bold fs-5">$<?php echo e(number_format($product->current_price, 2)); ?></div>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <div class="d-flex align-items-center border rounded-2 overflow-hidden">
                    <button class="btn btn-light border-0 px-2" id="stickyQtyDec">-</button>
                    <input type="text" id="stickyQty" value="1" class="border-0 text-center fw-semibold" style="width:36px;height:34px;outline:none" readonly>
                    <button class="btn btn-light border-0 px-2" id="stickyQtyInc">+</button>
                </div>
                <button class="btn btn-primary rounded-2 fw-bold px-4 btn-ripple sticky-atc" data-product-id="<?php echo e($product->id); ?>" <?php echo e(!$product->is_in_stock ? 'disabled' : ''); ?>>
                    <i class="fas fa-shopping-bag me-2"></i>Add to Cart
                </button>
                <button class="btn btn-warning text-white rounded-2 fw-bold px-4 btn-ripple sticky-buy" data-product-id="<?php echo e($product->id); ?>" <?php echo e(!$product->is_in_stock ? 'disabled' : ''); ?>>
                    <i class="fas fa-bolt me-2"></i>Buy Now
                </button>
            </div>
        </div>
    </div>
</div>


<div class="mobile-sticky-bar" id="mobileStickyBar">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between gap-2">
            <div class="d-flex align-items-center gap-2">
                <img src="<?php echo e($product->images->first()?->image_url ?? ($product->thumbnail ? asset('storage/' . $product->thumbnail) : 'https://placehold.co/40x40/f0f0f0/999?text=N')); ?>"
                     alt="" class="rounded-1 border" style="width:36px;height:36px;object-fit:cover">
                <div>
                    <div class="fw-bold">$<?php echo e(number_format($product->current_price, 2)); ?></div>
                    <?php if($product->has_discount): ?>
                        <small class="text-muted text-decoration-line-through">$<?php echo e(number_format($product->price, 2)); ?></small>
                    <?php endif; ?>
                </div>
            </div>
            <div class="d-flex align-items-center gap-1">
                <button class="btn btn-light border rounded-2 p-2 ms-wishlist wishlist-btn" data-product-id="<?php echo e($product->id); ?>" aria-label="Wishlist">
                    <i class="far fa-heart"></i>
                </button>
                <button class="btn btn-primary rounded-2 px-3 fw-bold btn-ripple ms-atc" data-product-id="<?php echo e($product->id); ?>" <?php echo e(!$product->is_in_stock ? 'disabled' : ''); ?>>
                    <i class="fas fa-shopping-bag me-1"></i> Cart
                </button>
                <button class="btn btn-warning text-white rounded-2 px-3 fw-bold btn-ripple ms-buy" data-product-id="<?php echo e($product->id); ?>" <?php echo e(!$product->is_in_stock ? 'disabled' : ''); ?>>
                    <i class="fas fa-bolt me-1"></i> Buy
                </button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="shareModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title"><i class="fas fa-share-alt me-2"></i>Share</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted small">Share this product with your friends:</p>
                <div class="d-flex gap-2 flex-wrap mb-3">
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo e(urlencode(request()->url())); ?>" target="_blank" class="share-link facebook" aria-label="Share on Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://twitter.com/intent/tweet?text=<?php echo e(urlencode($product->name)); ?>&url=<?php echo e(urlencode(request()->url())); ?>" target="_blank" class="share-link twitter" aria-label="Share on Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="https://wa.me/?text=<?php echo e(urlencode($product->name . ' - ' . request()->url())); ?>" target="_blank" class="share-link whatsapp" aria-label="Share on WhatsApp"><i class="fab fa-whatsapp"></i></a>
                    <a href="https://pinterest.com/pin/create/button/?url=<?php echo e(urlencode(request()->url())); ?>&description=<?php echo e(urlencode($product->name)); ?>" target="_blank" class="share-link pinterest" aria-label="Share on Pinterest"><i class="fab fa-pinterest-p"></i></a>
                    <a href="mailto:?subject=<?php echo e(urlencode($product->name)); ?>&body=<?php echo e(urlencode('Check out this product: ' . $product->name . ' - ' . request()->url())); ?>" class="share-link email" aria-label="Share via Email"><i class="fas fa-envelope"></i></a>
                    <button class="share-link copy" data-url="<?php echo e(request()->url()); ?>" aria-label="Copy link"><i class="fas fa-link"></i></button>
                </div>
                <div class="input-group">
                    <input type="text" class="form-control" value="<?php echo e(request()->url()); ?>" readonly id="shareUrlInput">
                    <button class="btn btn-primary" id="copyShareLink"><i class="fas fa-copy"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="emiModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title"><i class="fas fa-credit-card me-2"></i>EMI Options</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Available EMI plans for <strong>$<?php echo e(number_format($product->current_price, 2)); ?></strong></p>
                <div class="row g-3">
                    <div class="col-4">
                        <div class="emi-plan border rounded-3 p-3 text-center active">
                            <div class="fw-bold fs-5">3 Months</div>
                            <div class="text-body-secondary">$<?php echo e(number_format($product->current_price / 3, 2)); ?>/mo</div>
                            <div class="text-success small fw-semibold">0% Interest</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="emi-plan border rounded-3 p-3 text-center">
                            <div class="fw-bold fs-5">6 Months</div>
                            <div class="text-body-secondary">$<?php echo e(number_format($product->current_price / 6, 2)); ?>/mo</div>
                            <div class="text-success small fw-semibold">0% Interest</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="emi-plan border rounded-3 p-3 text-center">
                            <div class="fw-bold fs-5">12 Months</div>
                            <div class="text-body-secondary">$<?php echo e(number_format(($product->current_price * 1.1) / 12, 2)); ?>/mo</div>
                            <div class="text-warning small fw-semibold">10% Interest</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="reportModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title"><i class="fas fa-flag me-2"></i>Report Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Reason for reporting</label>
                        <select class="form-select" required>
                            <option value="">Select a reason...</option>
                            <option>Incorrect price</option>
                            <option>Wrong description</option>
                            <option>Counterfeit product</option>
                            <option>Inappropriate content</option>
                            <option>Other</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Additional details</label>
                        <textarea class="form-control" rows="3" placeholder="Provide more information..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-danger w-100">Submit Report</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('styles'); ?>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/sass/product.scss']); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/js/product-page.js']); ?>
<?php $__env->stopPush(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaleac9542bb5e3f887e862d1d96c472e9b)): ?>
<?php $attributes = $__attributesOriginaleac9542bb5e3f887e862d1d96c472e9b; ?>
<?php unset($__attributesOriginaleac9542bb5e3f887e862d1d96c472e9b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaleac9542bb5e3f887e862d1d96c472e9b)): ?>
<?php $component = $__componentOriginaleac9542bb5e3f887e862d1d96c472e9b; ?>
<?php unset($__componentOriginaleac9542bb5e3f887e862d1d96c472e9b); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\frontend\product.blade.php ENDPATH**/ ?>