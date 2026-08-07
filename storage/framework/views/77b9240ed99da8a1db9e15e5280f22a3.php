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
<?php $title = 'Contact Us' ?>

<div class="container py-4">
    <?php if (isset($component)) { $__componentOriginale19f62b34dfe0bfdf95075badcb45bc2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumb','data' => ['items' => [['label' => 'Contact Us']]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('breadcrumb'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([['label' => 'Contact Us']])]); ?>
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

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-3 p-md-4">
                    <h3 class="fw-bold mb-4 text-gray-800">Get in Touch</h3>
                    <p class="text-muted mb-4">Have a question or need assistance? Fill out the form below and our team will get back to you within 24 hours.</p>

                    <form>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-semibold">Full Name</label>
                                <input type="text" class="form-control radius-md" id="name" placeholder="Your name" required>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label fw-semibold">Email Address</label>
                                <input type="email" class="form-control radius-md" id="email" placeholder="Your email" required>
                            </div>
                            <div class="col-12">
                                <label for="subject" class="form-label fw-semibold">Subject</label>
                                <input type="text" class="form-control radius-md" id="subject" placeholder="How can we help?" required>
                            </div>
                            <div class="col-12">
                                <label for="message" class="form-label fw-semibold">Message</label>
                                <textarea class="form-control radius-md" id="message" rows="5" placeholder="Write your message here..." required></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary-modern rounded-pill px-4">
                                    <i class="fas fa-paper-plane me-2"></i>Send Message
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-3 p-md-4">
                    <h5 class="fw-bold mb-4 text-gray-800">Contact Information</h5>

                    <div class="d-flex mb-4">
                        <div class="flex-shrink-0">
                            <div class="d-flex align-items-center justify-content-center sizing-44 bg-primary-light radius-md">
                                <i class="fas fa-map-marker-alt text-primary-custom"></i>
                            </div>
                        </div>
                        <div class="ms-3">
                            <h6 class="fw-semibold mb-1 text-gray-800">Address</h6>
                            <p class="text-muted small mb-0">123 Commerce Street<br>Business District, NY 10001</p>
                        </div>
                    </div>

                    <div class="d-flex mb-4">
                        <div class="flex-shrink-0">
                            <div class="d-flex align-items-center justify-content-center sizing-44 bg-primary-light radius-md">
                                <i class="fas fa-phone text-primary-custom"></i>
                            </div>
                        </div>
                        <div class="ms-3">
                            <h6 class="fw-semibold mb-1 text-gray-800">Phone</h6>
                            <p class="text-muted small mb-0">+1 (555) 123-4567</p>
                        </div>
                    </div>

                    <div class="d-flex mb-4">
                        <div class="flex-shrink-0">
                            <div class="d-flex align-items-center justify-content-center sizing-44 bg-primary-light radius-md">
                                <i class="fas fa-envelope text-primary-custom"></i>
                            </div>
                        </div>
                        <div class="ms-3">
                            <h6 class="fw-semibold mb-1 text-gray-800">Email</h6>
                            <p class="text-muted small mb-0">support@ecommerce.test</p>
                        </div>
                    </div>

                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <div class="d-flex align-items-center justify-content-center sizing-44 bg-primary-light radius-md">
                                <i class="fas fa-clock text-primary-custom"></i>
                            </div>
                        </div>
                        <div class="ms-3">
                            <h6 class="fw-semibold mb-1 text-gray-800">Business Hours</h6>
                            <p class="text-muted small mb-0">Mon - Fri: 9:00 AM - 6:00 PM<br>Sat: 10:00 AM - 4:00 PM</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-3 p-md-4">
                    <h5 class="fw-bold mb-3 text-gray-800">Follow Us</h5>
                    <div class="d-flex gap-2">
                        <a href="#" class="btn rounded-circle d-flex align-items-center justify-content-center sizing-40 bg-primary-light text-primary-custom border-0">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="btn rounded-circle d-flex align-items-center justify-content-center sizing-40 bg-primary-light text-primary-custom border-0">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="btn rounded-circle d-flex align-items-center justify-content-center sizing-40 bg-primary-light text-primary-custom border-0">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="btn rounded-circle d-flex align-items-center justify-content-center sizing-40 bg-primary-light text-primary-custom border-0">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
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
<?php /**PATH C:\laragon\www\ecommerce\resources\views\frontend\contact.blade.php ENDPATH**/ ?>