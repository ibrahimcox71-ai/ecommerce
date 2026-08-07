<?php if (isset($component)) { $__componentOriginala5b7d55eb9299c3bd54b070f8a2d3d0f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala5b7d55eb9299c3bd54b070f8a2d3d0f = $attributes; } ?>
<?php $component = App\View\Components\Layouts\CustomerLayout::resolve(['title' => 'Wishlist'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.customer-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\CustomerLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">My Wishlist</h4>
        <?php if($wishlists->isNotEmpty()): ?>
            <span class="text-muted"><?php echo e($wishlists->count()); ?> item(s)</span>
        <?php endif; ?>
    </div>

    <?php if($wishlists->isEmpty()): ?>
        <div class="card">
            <div class="card-body text-center py-5 text-muted">
                <i class="fas fa-heart fa-3x mb-3"></i>
                <p>Your wishlist is empty.</p>
                <a href="<?php echo e(route('shop')); ?>" class="btn btn-primary">Browse Products</a>
            </div>
        </div>
    <?php else: ?>
        <div class="row g-3">
            <?php $__currentLoopData = $wishlists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $wishlist): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $product = $wishlist->product ?>
                <div class="col-md-6 col-lg-4 wishlist-item">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="row g-0 h-100">
                            <div class="col-4">
                                <a href="<?php echo e(route('product.show', $product->slug)); ?>">
                                    <img src="<?php echo e($product->thumbnail ? asset('storage/' . $product->thumbnail) : 'https://placehold.co/200x200/f0f0f0/999?text=No+Image'); ?>"
                                         alt="<?php echo e($product->name); ?>"
                                         class="img-fluid rounded-start h-100"
                                         style="object-fit: cover;">
                                </a>
                            </div>
                            <div class="col-8">
                                <div class="card-body d-flex flex-column h-100 py-2">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <small class="text-muted text-uppercase"><?php echo e($product->brand?->name); ?></small>
                                            <a href="<?php echo e(route('product.show', $product->slug)); ?>" class="text-decoration-none text-dark">
                                                <h6 class="fw-semibold mb-1" style="display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden;">
                                                    <?php echo e($product->name); ?>

                                                </h6>
                                            </a>
                                        </div>
                                        <button class="btn btn-sm btn-link text-danger p-0 remove-wishlist" data-product-id="<?php echo e($product->id); ?>" title="Remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                    <div class="mb-1">
                                        <?php if (isset($component)) { $__componentOriginalfa87e49ca3cdf62358bbc468aaf3394b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfa87e49ca3cdf62358bbc468aaf3394b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.star-rating','data' => ['rating' => $product->average_rating]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('star-rating'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['rating' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($product->average_rating)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfa87e49ca3cdf62358bbc468aaf3394b)): ?>
<?php $attributes = $__attributesOriginalfa87e49ca3cdf62358bbc468aaf3394b; ?>
<?php unset($__attributesOriginalfa87e49ca3cdf62358bbc468aaf3394b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfa87e49ca3cdf62358bbc468aaf3394b)): ?>
<?php $component = $__componentOriginalfa87e49ca3cdf62358bbc468aaf3394b; ?>
<?php unset($__componentOriginalfa87e49ca3cdf62358bbc468aaf3394b); ?>
<?php endif; ?>
                                        <small class="text-muted">(<?php echo e($product->review_count); ?>)</small>
                                    </div>
                                    <div class="mt-auto d-flex justify-content-between align-items-center">
                                        <span class="fw-bold text-primary">
                                            <?php if($product->has_discount): ?>
                                                $<?php echo e(number_format($product->current_price, 2)); ?>

                                                <small class="text-muted text-decoration-line-through">$<?php echo e(number_format($product->price, 2)); ?></small>
                                            <?php else: ?>
                                                $<?php echo e(number_format($product->price, 2)); ?>

                                            <?php endif; ?>
                                        </span>
                                        <form method="POST" action="<?php echo e(route('cart')); ?>" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="btn btn-primary btn-sm" title="Add to Cart">
                                                <i class="fas fa-shopping-cart me-1"></i>Add
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>

    <?php $__env->startPush('scripts'); ?>
    <script>
        document.querySelectorAll('.remove-wishlist').forEach(btn => {
            btn.addEventListener('click', function() {
                const productId = this.dataset.productId;
                const card = this.closest('.wishlist-item');

                fetch('<?php echo e(route("wishlist.toggle")); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                    },
                    body: JSON.stringify({ product_id: productId })
                })
                .then(r => r.json())
                .then(d => {
                    if (d.status === 'success') {
                        card.remove();
                        const remaining = document.querySelectorAll('.wishlist-item').length;
                        if (remaining === 0) location.reload();
                    }
                });
            });
        });
    </script>
    <?php $__env->stopPush(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala5b7d55eb9299c3bd54b070f8a2d3d0f)): ?>
<?php $attributes = $__attributesOriginala5b7d55eb9299c3bd54b070f8a2d3d0f; ?>
<?php unset($__attributesOriginala5b7d55eb9299c3bd54b070f8a2d3d0f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala5b7d55eb9299c3bd54b070f8a2d3d0f)): ?>
<?php $component = $__componentOriginala5b7d55eb9299c3bd54b070f8a2d3d0f; ?>
<?php unset($__componentOriginala5b7d55eb9299c3bd54b070f8a2d3d0f); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\customer\wishlist.blade.php ENDPATH**/ ?>