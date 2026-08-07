<?php if (isset($component)) { $__componentOriginaleac9542bb5e3f887e862d1d96c472e9b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaleac9542bb5e3f887e862d1d96c472e9b = $attributes; } ?>
<?php $component = App\View\Components\Layouts\FrontendLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.frontend-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\FrontendLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php $title = 'Refund Policy' ?>

<div class="container py-4">
    <?php if (isset($component)) { $__componentOriginale19f62b34dfe0bfdf95075badcb45bc2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumb','data' => ['items' => [['label' => 'Refund Policy']]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('breadcrumb'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([['label' => 'Refund Policy']])]); ?>
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

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card-premium border">
                <div class="card-body p-4 p-md-5">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <span class="icon-circle bg-primary-light text-primary-custom">
                            <i class="fas fa-undo-alt"></i>
                        </span>
                        <div>
                            <h1 class="fw-bold mb-1 text-gray-800">Refund Policy</h1>
                            <p class="text-muted mb-0">Last updated: June 27, 2026</p>
                        </div>
                    </div>

                    <div class="bg-primary-50 rounded-3 p-3 mb-4 d-flex align-items-center gap-2">
                        <i class="fas fa-info-circle text-primary-custom flex-shrink-0"></i>
                        <strong class="text-gray-800">30-Day Return Policy:</strong>
                        <span class="text-muted">We accept returns within 30 days of delivery for most items.</span>
                    </div>

                    <h5 class="fw-bold mt-4 mb-3 text-gray-800">1. Eligibility for Returns</h5>
                    <p class="text-muted">To be eligible for a return, your item must be:</p>
                    <ul class="text-muted">
                        <li>Returned within 30 days of delivery</li>
                        <li>In its original, unused condition</li>
                        <li>In the original packaging with all tags attached</li>
                        <li>Accompanied by the original receipt or proof of purchase</li>
                    </ul>

                    <h5 class="fw-bold mt-4 mb-3 text-gray-800">2. Non-Returnable Items</h5>
                    <p class="text-muted">The following items cannot be returned:</p>
                    <ul class="text-muted">
                        <li>Gift cards</li>
                        <li>Downloadable software or digital products</li>
                        <li>Personalized or custom-made items</li>
                        <li>Intimate or sanitary goods</li>
                        <li>Hazardous materials</li>
                    </ul>

                    <h5 class="fw-bold mt-4 mb-3 text-gray-800">3. How to Initiate a Return</h5>
                    <ol class="text-muted">
                        <li>Log in to your account and go to Order History</li>
                        <li>Select the order containing the item you want to return</li>
                        <li>Click "Return Item" and select the reason for return</li>
                        <li>Print the prepaid return shipping label</li>
                        <li>Pack the item securely in its original packaging</li>
                        <li>Drop off the package at the designated carrier location</li>
                    </ol>

                    <h5 class="fw-bold mt-4 mb-3 text-gray-800">4. Refund Processing</h5>
                    <p class="text-muted">Once we receive and inspect your returned item, we will send you an email notification. Refunds are processed within 5-7 business days and will be credited to your original payment method.</p>

                    <h5 class="fw-bold mt-4 mb-3 text-gray-800">5. Partial Refunds</h5>
                    <p class="text-muted">Partial refunds may be issued for:</p>
                    <ul class="text-muted">
                        <li>Items returned with visible signs of use or damage</li>
                        <li>Items returned without original packaging or tags</li>
                        <li>Items returned after the 30-day window (case-by-case basis)</li>
                    </ul>

                    <h5 class="fw-bold mt-4 mb-3 text-gray-800">6. Exchanges</h5>
                    <p class="text-muted">We offer exchanges for items of equal or lesser value. If you need an exchange, please initiate a return and place a new order for the desired item.</p>

                    <h5 class="fw-bold mt-4 mb-3 text-gray-800">7. Damaged or Defective Items</h5>
                    <p class="text-muted">If you received a damaged or defective item, please contact us within 48 hours of delivery with photos of the damage. We will arrange a free return and send a replacement or issue a full refund.</p>

                    <h5 class="fw-bold mt-4 mb-3 text-gray-800">8. Contact Us</h5>
                    <p class="text-muted">For return or refund inquiries, please contact us at <a href="<?php echo e(route('contact')); ?>" class="text-primary-custom">support@ecommerce.test</a>.</p>
                </div>
            </div>
        </div>
    </div>
</div>
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
<?php /**PATH C:\laragon\www\ecommerce\resources\views\frontend\refund-policy.blade.php ENDPATH**/ ?>