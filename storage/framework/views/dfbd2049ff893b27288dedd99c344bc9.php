<?php if (isset($component)) { $__componentOriginala5b7d55eb9299c3bd54b070f8a2d3d0f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala5b7d55eb9299c3bd54b070f8a2d3d0f = $attributes; } ?>
<?php $component = App\View\Components\Layouts\CustomerLayout::resolve(['title' => 'My Reviews'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.customer-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\CustomerLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">My Reviews</h4>
    </div>

    <?php if($reviews->isEmpty()): ?>
        <div class="card">
            <div class="card-body text-center py-5 text-muted">
                <i class="fas fa-star fa-3x mb-3"></i>
                <p>You haven't reviewed any products yet.</p>
                <a href="<?php echo e(route('shop')); ?>" class="btn btn-primary">Browse Products</a>
            </div>
        </div>
    <?php else: ?>
        <?php $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body">
                    <div class="d-flex align-items-start gap-3">
                        <a href="<?php echo e(route('product.show', $review->product->slug)); ?>">
                            <img src="<?php echo e($review->product->thumbnail ? asset('storage/' . $review->product->thumbnail) : 'https://placehold.co/80x80/f0f0f0/999?text=No+Image'); ?>"
                                 alt="<?php echo e($review->product->name); ?>"
                                 style="width: 80px; height: 80px; object-fit: cover;"
                                 class="rounded">
                        </a>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <a href="<?php echo e(route('product.show', $review->product->slug)); ?>" class="text-decoration-none text-dark">
                                        <h6 class="fw-semibold mb-1"><?php echo e($review->product->name); ?></h6>
                                    </a>
                                    <?php if (isset($component)) { $__componentOriginalfa87e49ca3cdf62358bbc468aaf3394b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfa87e49ca3cdf62358bbc468aaf3394b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.star-rating','data' => ['rating' => $review->rating]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('star-rating'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['rating' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($review->rating)]); ?>
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
                                </div>
                                <div class="text-end small text-muted">
                                    <span class="badge bg-<?php echo e($review->status === 'approved' ? 'success' : ($review->status === 'pending' ? 'warning' : 'danger')); ?>">
                                        <?php echo e(ucfirst($review->status)); ?>

                                    </span>
                                    <div class="mt-1"><?php echo e($review->created_at->format('M d, Y')); ?></div>
                                </div>
                            </div>
                            <?php if($review->title): ?>
                                <p class="fw-semibold mb-1 mt-2"><?php echo e($review->title); ?></p>
                            <?php endif; ?>
                            <p class="text-muted small mb-2"><?php echo e($review->body); ?></p>
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-outline-primary edit-review"
                                        data-review-id="<?php echo e($review->id); ?>"
                                        data-rating="<?php echo e($review->rating); ?>"
                                        data-title="<?php echo e($review->title); ?>"
                                        data-body="<?php echo e($review->body); ?>">
                                    <i class="fas fa-edit me-1"></i>Edit
                                </button>
                                <form method="POST" action="<?php echo e(route('customer.reviews.destroy', $review)); ?>" class="d-inline" onsubmit="return confirm('Delete this review?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash me-1"></i>Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <div class="d-flex justify-content-center">
            <?php echo e($reviews->links()); ?>

        </div>

        
        <div class="modal fade" id="editReviewModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" id="editReviewForm">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Review</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Rating</label>
                                <div class="star-input">
                                    <?php for($i = 5; $i >= 1; $i--): ?>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" name="rating" id="rating<?php echo e($i); ?>" value="<?php echo e($i); ?>" class="form-check-input">
                                            <label class="form-check-label" for="rating<?php echo e($i); ?>"><?php echo e($i); ?> <i class="fas fa-star text-warning"></i></label>
                                        </div>
                                    <?php endfor; ?>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-outline">
                                    <input type="text" name="title" id="editTitle" class="form-control">
                                    <label class="form-label" for="editTitle">Title (Optional)</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-outline">
                                    <textarea name="body" id="editBody" class="form-control" rows="4" required></textarea>
                                    <label class="form-label" for="editBody">Your Review</label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Update Review</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php $__env->startPush('scripts'); ?>
    <script>
        document.querySelectorAll('.edit-review').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.reviewId;
                document.getElementById('editReviewForm').action = '/customer/reviews/' + id;
                document.querySelector('input[name="rating"][value="' + this.dataset.rating + '"]').checked = true;
                document.getElementById('editTitle').value = this.dataset.title;
                document.getElementById('editBody').value = this.dataset.body;
                new bootstrap.Modal(document.getElementById('editReviewModal')).show();
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
<?php /**PATH C:\laragon\www\ecommerce\resources\views\customer\reviews.blade.php ENDPATH**/ ?>