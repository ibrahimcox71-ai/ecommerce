<?php if (isset($component)) { $__componentOriginaledc75c655a063d12a477f2c8d8f324fc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc = $attributes; } ?>
<?php $component = App\View\Components\Layouts\AdminLayout::resolve(['title' => 'Review Detail'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Review Detail</h4>
            <p class="text-muted small mb-0">View and manage product review</p>
        </div>
        <a href="<?php echo e(route('admin.reviews.index')); ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to Reviews
        </a>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <div>
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
                        <?php if($review->title): ?>
                            <h5 class="mt-2 mb-0"><?php echo e($review->title); ?></h5>
                        <?php endif; ?>
                    </div>
                    <div class="d-flex gap-2">
                        <?php if($review->is_verified): ?>
                            <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Verified Purchase</span>
                        <?php endif; ?>
                        <?php if($review->status === 'approved'): ?>
                            <span class="badge bg-success">Approved</span>
                        <?php elseif($review->status === 'pending'): ?>
                            <span class="badge bg-warning text-dark">Pending</span>
                        <?php else: ?>
                            <span class="badge bg-danger">Rejected</span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-body">
                    <p><?php echo e($review->body); ?></p>

                    <?php if($review->images->isNotEmpty()): ?>
                        <div class="mt-3">
                            <label class="form-label fw-semibold small text-muted">Review Images</label>
                            <div class="d-flex flex-wrap gap-2">
                                <?php $__currentLoopData = $review->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a href="<?php echo e($image->image_url); ?>" target="_blank">
                                        <img src="<?php echo e($image->image_url); ?>" alt="Review image"
                                             style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px; border: 1px solid #e2e8f0;">
                                    </a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="mt-3 text-muted small">
                        <i class="fas fa-thumbs-up me-1"></i> <?php echo e($review->helpful_count); ?> found helpful &middot;
                        Posted <?php echo e($review->created_at->diffForHumans()); ?>

                        <?php if($review->verified_at): ?>
                            &middot; <i class="fas fa-check-circle text-success me-1"></i>Verified <?php echo e($review->verified_at->diffForHumans()); ?>

                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-footer bg-white d-flex gap-2">
                    <?php if($review->status !== 'approved'): ?>
                        <form method="POST" action="<?php echo e(route('admin.reviews.approve', $review)); ?>">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="fas fa-check me-1"></i> Approve
                            </button>
                        </form>
                    <?php endif; ?>
                    <?php if($review->status !== 'rejected'): ?>
                        <form method="POST" action="<?php echo e(route('admin.reviews.reject', $review)); ?>">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-warning btn-sm">
                                <i class="fas fa-times me-1"></i> Reject
                            </button>
                        </form>
                    <?php endif; ?>
                    <?php if(!$review->is_verified): ?>
                        <form method="POST" action="<?php echo e(route('admin.reviews.mark-verified', $review)); ?>">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-info btn-sm text-white">
                                <i class="fas fa-check-double me-1"></i> Mark Verified
                            </button>
                        </form>
                    <?php endif; ?>
                    <form method="POST" action="<?php echo e(route('admin.reviews.destroy', $review)); ?>" onsubmit="return confirm('Delete this review permanently?')">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash me-1"></i> Delete
                        </button>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-white">
                    <h6 class="mb-0 fw-semibold"><i class="fas fa-reply me-2"></i>Replies</h6>
                </div>
                <div class="card-body">
                    <?php if($review->replies->isNotEmpty()): ?>
                        <?php $__currentLoopData = $review->replies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reply): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="d-flex justify-content-between align-items-start mb-3 pb-3 border-bottom">
                                <div>
                                    <strong class="text-primary small"><?php echo e($reply->admin?->name ?? 'Admin'); ?></strong>
                                    <small class="text-muted ms-2"><?php echo e($reply->created_at->diffForHumans()); ?></small>
                                    <p class="mb-0 mt-1"><?php echo e($reply->body); ?></p>
                                </div>
                                <form method="POST" action="<?php echo e(route('admin.reviews.reply.delete', $reply)); ?>" onsubmit="return confirm('Delete this reply?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <p class="text-muted mb-0">No replies yet.</p>
                    <?php endif; ?>

                    <form method="POST" action="<?php echo e(route('admin.reviews.reply', $review)); ?>" class="mt-3">
                        <?php echo csrf_field(); ?>
                        <div class="mb-2">
                            <textarea name="body" class="form-control" rows="2" placeholder="Write a reply..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-paper-plane me-1"></i> Reply
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h6 class="mb-0 fw-semibold">Product</h6>
                </div>
                <div class="card-body text-center">
                    <?php if($review->product): ?>
                        <img src="<?php echo e($review->product->images->first()?->image_url ?? 'https://placehold.co/150x150/f0f0f0/999?text=N'); ?>"
                             alt="" class="rounded mb-3" style="width: 120px; height: 120px; object-fit: cover;">
                        <h6><?php echo e($review->product->name); ?></h6>
                        <a href="<?php echo e(route('admin.products.show', $review->product)); ?>" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-box me-1"></i> View Product
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h6 class="mb-0 fw-semibold">Customer</h6>
                </div>
                <div class="card-body">
                    <p class="mb-1"><strong><?php echo e($review->user?->name ?? 'Anonymous'); ?></strong></p>
                    <p class="text-muted small mb-0"><?php echo e($review->user?->email); ?></p>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-white">
                    <h6 class="mb-0 fw-semibold">Details</h6>
                </div>
                <div class="card-body small">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Status</span>
                        <span>
                            <?php if($review->status === 'approved'): ?>
                                <span class="badge bg-success">Approved</span>
                            <?php elseif($review->status === 'pending'): ?>
                                <span class="badge bg-warning text-dark">Pending</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Rejected</span>
                            <?php endif; ?>
                        </span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Rating</span>
                        <span><?php if (isset($component)) { $__componentOriginalfa87e49ca3cdf62358bbc468aaf3394b = $component; } ?>
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
<?php endif; ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Verified</span>
                        <span><?php echo $review->is_verified ? '<i class="fas fa-check-circle text-success"></i> Yes' : 'No'; ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Helpful</span>
                        <span><?php echo e($review->helpful_count); ?> votes</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Submitted</span>
                        <span><?php echo e($review->created_at->format('M d, Y h:i A')); ?></span>
                    </div>
                    <?php if($review->verified_at): ?>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Verified at</span>
                            <span><?php echo e($review->verified_at->format('M d, Y')); ?></span>
                        </div>
                    <?php endif; ?>
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
<?php /**PATH C:\laragon\www\ecommerce\resources\views\admin\reviews\show.blade.php ENDPATH**/ ?>