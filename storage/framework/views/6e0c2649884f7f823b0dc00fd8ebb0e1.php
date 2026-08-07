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
<?php $title = 'Privacy Policy' ?>

<div class="container py-4">
    <?php if (isset($component)) { $__componentOriginale19f62b34dfe0bfdf95075badcb45bc2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumb','data' => ['items' => [['label' => 'Privacy Policy']]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('breadcrumb'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([['label' => 'Privacy Policy']])]); ?>
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
                            <i class="fas fa-shield-alt"></i>
                        </span>
                        <div>
                            <h1 class="fw-bold mb-1 text-gray-800">Privacy Policy</h1>
                            <p class="text-muted mb-0">Last updated: June 27, 2026</p>
                        </div>
                    </div>

                    <h5 class="fw-bold mt-4 mb-3 text-gray-800">1. Information We Collect</h5>
                    <p class="text-muted">We collect information you provide directly, including:</p>
                    <ul class="text-muted">
                        <li>Account information (name, email, password)</li>
                        <li>Payment and billing information</li>
                        <li>Shipping addresses</li>
                        <li>Order history and preferences</li>
                        <li>Communications with our support team</li>
                    </ul>

                    <h5 class="fw-bold mt-4 mb-3 text-gray-800">2. How We Use Your Information</h5>
                    <p class="text-muted">We use your information to:</p>
                    <ul class="text-muted">
                        <li>Process and fulfill your orders</li>
                        <li>Send order updates and shipping notifications</li>
                        <li>Provide customer support</li>
                        <li>Improve our website and services</li>
                        <li>Send promotional communications (with your consent)</li>
                        <li>Prevent fraud and ensure security</li>
                    </ul>

                    <h5 class="fw-bold mt-4 mb-3 text-gray-800">3. Information Sharing</h5>
                    <p class="text-muted">We do not sell your personal information. We may share your information with:</p>
                    <ul class="text-muted">
                        <li>Payment processors to complete transactions</li>
                        <li>Shipping carriers to deliver your orders</li>
                        <li>Service providers who assist in operating our website</li>
                        <li>Law enforcement when required by law</li>
                    </ul>

                    <h5 class="fw-bold mt-4 mb-3 text-gray-800">4. Data Security</h5>
                    <p class="text-muted">We implement appropriate security measures to protect your personal information. However, no method of transmission over the internet is 100% secure, and we cannot guarantee absolute security.</p>

                    <h5 class="fw-bold mt-4 mb-3 text-gray-800">5. Cookies</h5>
                    <p class="text-muted">We use cookies to enhance your browsing experience, analyze site traffic, and personalize content. You can control cookie settings through your browser preferences.</p>

                    <h5 class="fw-bold mt-4 mb-3 text-gray-800">6. Your Rights</h5>
                    <p class="text-muted">You have the right to:</p>
                    <ul class="text-muted">
                        <li>Access your personal information</li>
                        <li>Correct inaccurate data</li>
                        <li>Request deletion of your data</li>
                        <li>Opt-out of marketing communications</li>
                        <li>Export your data</li>
                    </ul>

                    <h5 class="fw-bold mt-4 mb-3 text-gray-800">7. Data Retention</h5>
                    <p class="text-muted">We retain your information for as long as your account is active or as needed to provide services. We may also retain information as required by law or for legitimate business purposes.</p>

                    <h5 class="fw-bold mt-4 mb-3 text-gray-800">8. Changes to This Policy</h5>
                    <p class="text-muted">We may update this privacy policy from time to time. We will notify you of any changes by posting the new policy on this page and updating the "Last updated" date.</p>

                    <h5 class="fw-bold mt-4 mb-3 text-gray-800">9. Contact Us</h5>
                    <p class="text-muted">If you have questions about this Privacy Policy, please contact us at <a href="<?php echo e(route('contact')); ?>" class="text-primary-custom">support@ecommerce.test</a>.</p>
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
<?php /**PATH C:\laragon\www\ecommerce\resources\views\frontend\privacy-policy.blade.php ENDPATH**/ ?>