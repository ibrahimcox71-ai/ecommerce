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
<?php $title = 'Shipping Policy' ?>

<div class="container py-4">
    <?php if (isset($component)) { $__componentOriginale19f62b34dfe0bfdf95075badcb45bc2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumb','data' => ['items' => [['label' => 'Shipping Policy']]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('breadcrumb'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([['label' => 'Shipping Policy']])]); ?>
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
                            <i class="fas fa-truck"></i>
                        </span>
                        <div>
                            <h1 class="fw-bold mb-1 text-gray-800">Shipping Policy</h1>
                            <p class="text-muted mb-0">Last updated: June 27, 2026</p>
                        </div>
                    </div>

                    <h5 class="fw-bold mt-4 mb-3 text-gray-800">1. Free Shipping</h5>
                    <p class="text-muted">We offer free standard shipping on all orders over $50 within the continental United States. Free shipping is automatically applied at checkout when your order qualifies.</p>

                    <h5 class="fw-bold mt-4 mb-3 text-gray-800">2. Shipping Options</h5>
                    <div class="table-responsive rounded-3 border">
                        <table class="table mb-0">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="fw-semibold text-gray-800">Shipping Method</th>
                                    <th class="fw-semibold text-gray-800">Estimated Delivery</th>
                                    <th class="fw-semibold text-gray-800">Cost</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Standard Shipping</td>
                                    <td>3-5 business days</td>
                                    <td>Free (orders $50+) / $5.99</td>
                                </tr>
                                <tr>
                                    <td>Express Shipping</td>
                                    <td>1-2 business days</td>
                                    <td>$12.99</td>
                                </tr>
                                <tr>
                                    <td>Overnight Shipping</td>
                                    <td>Next business day</td>
                                    <td>$24.99</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h5 class="fw-bold mt-4 mb-3 text-gray-800">3. Order Processing</h5>
                    <p class="text-muted">Orders are processed within 1-2 business days. Orders placed on weekends or holidays will be processed on the next business day. You will receive a confirmation email once your order has shipped.</p>

                    <h5 class="fw-bold mt-4 mb-3 text-gray-800">4. Tracking Your Order</h5>
                    <p class="text-muted">Once your order ships, you will receive a tracking number via email. You can track your package using the carrier's website or through your account dashboard on our website.</p>

                    <h5 class="fw-bold mt-4 mb-3 text-gray-800">5. Shipping Restrictions</h5>
                    <p class="text-muted">Currently, we only ship within the United States. We do not ship to P.O. boxes for express or overnight shipping. Some oversized or hazardous items may have additional shipping restrictions.</p>

                    <h5 class="fw-bold mt-4 mb-3 text-gray-800">6. Delivery Issues</h5>
                    <p class="text-muted">If your package is lost or damaged during shipping, please contact our support team within 48 hours of the expected delivery date. We will work with the carrier to resolve the issue and may offer a replacement or refund.</p>

                    <h5 class="fw-bold mt-4 mb-3 text-gray-800">7. Incorrect Address</h5>
                    <p class="text-muted">Please ensure your shipping address is correct when placing an order. We are not responsible for orders shipped to incorrect addresses provided by the customer. Additional shipping charges may apply to reship orders.</p>

                    <h5 class="fw-bold mt-4 mb-3 text-gray-800">8. Contact Us</h5>
                    <p class="text-muted">For shipping inquiries, please contact us at <a href="<?php echo e(route('contact')); ?>" class="text-primary-custom">support@ecommerce.test</a>.</p>
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
<?php /**PATH C:\laragon\www\ecommerce\resources\views\frontend\shipping-policy.blade.php ENDPATH**/ ?>