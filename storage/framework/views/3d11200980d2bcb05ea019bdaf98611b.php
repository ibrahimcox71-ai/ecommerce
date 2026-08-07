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
<?php $title = 'FAQ' ?>

<div class="container py-4">
    <?php if (isset($component)) { $__componentOriginale19f62b34dfe0bfdf95075badcb45bc2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumb','data' => ['items' => [['label' => 'FAQ']]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('breadcrumb'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([['label' => 'FAQ']])]); ?>
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
            <div class="text-center mb-5">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3 sizing-72 bg-primary-light">
                    <i class="fas fa-question-circle fa-2x text-primary-custom"></i>
                </div>
                <h1 class="fw-bold text-gray-800">Frequently Asked Questions</h1>
                <p class="text-muted">Find answers to common questions about shopping, orders, and our policies.</p>
            </div>

            <div class="accordion accordion-premium" id="faqAccordion">
                <div class="accordion-item border-0 shadow-sm mb-3 rounded-4 overflow-hidden">
                    <h2 class="accordion-header">
                        <button class="accordion-button fw-semibold text-gray-800" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                            How do I place an order?
                        </button>
                    </h2>
                    <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted">
                            Simply browse our shop, add products to your cart, and proceed to checkout. You can pay using credit/debit cards, PayPal, or other available payment methods. Once your order is confirmed, you'll receive an email with your order details.
                        </div>
                    </div>
                </div>

                <div class="accordion-item border-0 shadow-sm mb-3 rounded-4 overflow-hidden">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-semibold text-gray-800" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                            What is the shipping policy?
                        </button>
                    </h2>
                    <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted">
                            We offer free shipping on all orders over $50. Standard shipping takes 3-5 business days. Express shipping (1-2 business days) is available at checkout for an additional fee. We ship to all addresses within the country.
                        </div>
                    </div>
                </div>

                <div class="accordion-item border-0 shadow-sm mb-3 rounded-4 overflow-hidden">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-semibold text-gray-800" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                            How do I return a product?
                        </button>
                    </h2>
                    <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted">
                            You can return most items within 30 days of delivery. Go to your order history, select the order, and click "Return Item." Pack the item in its original packaging and we'll arrange a free pickup. Refunds are processed within 5-7 business days after we receive the returned item.
                        </div>
                    </div>
                </div>

                <div class="accordion-item border-0 shadow-sm mb-3 rounded-4 overflow-hidden">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-semibold text-gray-800" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                            Can I cancel or modify my order?
                        </button>
                    </h2>
                    <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted">
                            You can cancel or modify your order within 1 hour of placing it. After that, the order may have already been processed for shipping. Please contact our support team immediately if you need to make changes.
                        </div>
                    </div>
                </div>

                <div class="accordion-item border-0 shadow-sm mb-3 rounded-4 overflow-hidden">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-semibold text-gray-800" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                            How do I track my order?
                        </button>
                    </h2>
                    <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted">
                            Once your order ships, you'll receive a tracking number via email. You can use this number to track your package on our website or the carrier's website. You can also view your order status in your account dashboard.
                        </div>
                    </div>
                </div>

                <div class="accordion-item border-0 shadow-sm mb-3 rounded-4 overflow-hidden">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-semibold text-gray-800" type="button" data-bs-toggle="collapse" data-bs-target="#faq6">
                            Do you offer international shipping?
                        </button>
                    </h2>
                    <div id="faq6" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted">
                            Currently, we only ship within the country. We are working on expanding our shipping services internationally. Subscribe to our newsletter to be notified when international shipping becomes available.
                        </div>
                    </div>
                </div>

                <div class="accordion-item border-0 shadow-sm mb-3 rounded-4 overflow-hidden">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-semibold text-gray-800" type="button" data-bs-toggle="collapse" data-bs-target="#faq7">
                            How do I create an account?
                        </button>
                    </h2>
                    <div id="faq7" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted">
                            Click the "Register" button at the top of the page and fill in your details. Having an account allows you to track orders, save items to your wishlist, and enjoy a faster checkout experience.
                        </div>
                    </div>
                </div>

                <div class="accordion-item border-0 shadow-sm mb-3 rounded-4 overflow-hidden">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-semibold text-gray-800" type="button" data-bs-toggle="collapse" data-bs-target="#faq8">
                            What payment methods do you accept?
                        </button>
                    </h2>
                    <div id="faq8" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted">
                            We accept Visa, MasterCard, American Express, PayPal, and bank transfers. All transactions are processed securely using SSL encryption to protect your financial information.
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-5">
                <p class="text-muted mb-3">Can't find what you're looking for?</p>
                <a href="<?php echo e(route('contact')); ?>" class="btn btn-primary-modern rounded-pill px-4">
                    <i class="fas fa-envelope me-2"></i>Contact Our Support Team
                </a>
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
<?php /**PATH C:\laragon\www\ecommerce\resources\views\frontend\faq.blade.php ENDPATH**/ ?>