<x-layouts.frontend-layout>
@php $title = 'Terms of Service' @endphp

<div class="container py-4">
    <x-breadcrumb :items="[['label' => 'Terms of Service']]" />

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card-premium border">
                <div class="card-body p-4 p-md-5">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <span class="icon-circle bg-primary-light text-primary-custom">
                            <i class="fas fa-file-contract"></i>
                        </span>
                        <div>
                            <h1 class="fw-bold mb-1 text-gray-800">Terms of Service</h1>
                            <p class="text-muted mb-0">Last updated: June 27, 2026</p>
                        </div>
                    </div>

                    <h5 class="fw-bold mt-4 mb-3 text-gray-800">1. Acceptance of Terms</h5>
                    <p class="text-muted">By accessing and using {{ config('app.name') }}, you agree to be bound by these Terms of Service. If you do not agree to these terms, please do not use our website.</p>

                    <h5 class="fw-bold mt-4 mb-3 text-gray-800">2. Account Registration</h5>
                    <p class="text-muted">To access certain features, you must create an account. You are responsible for maintaining the confidentiality of your account credentials and for all activities that occur under your account. You must provide accurate and complete information when creating your account.</p>

                    <h5 class="fw-bold mt-4 mb-3 text-gray-800">3. Products and Pricing</h5>
                    <p class="text-muted">We strive to provide accurate product descriptions and pricing. However, we do not warrant that product descriptions, pricing, or other content is error-free, complete, or current. We reserve the right to correct any errors and to change or update information at any time without prior notice.</p>

                    <h5 class="fw-bold mt-4 mb-3 text-gray-800">4. Orders and Payment</h5>
                    <p class="text-muted">By placing an order, you are making an offer to purchase a product. We reserve the right to accept or decline any order. Payment must be received in full before we process and ship your order. All prices are in USD and exclude applicable taxes and shipping fees.</p>

                    <h5 class="fw-bold mt-4 mb-3 text-gray-800">5. Shipping and Delivery</h5>
                    <p class="text-muted">We will ship products to the address provided during checkout. Delivery times are estimates and are not guaranteed. We are not responsible for delays caused by shipping carriers or customs processing.</p>

                    <h5 class="fw-bold mt-4 mb-3 text-gray-800">6. Returns and Refunds</h5>
                    <p class="text-muted">You may return most items within 30 days of delivery for a full refund. Items must be in their original condition and packaging. Please refer to our <a href="{{ route('refund-policy') }}" class="text-primary-custom">Refund Policy</a> for detailed information.</p>

                    <h5 class="fw-bold mt-4 mb-3 text-gray-800">7. Intellectual Property</h5>
                    <p class="text-muted">All content on this website, including text, graphics, logos, images, and software, is the property of {{ config('app.name') }} and is protected by copyright laws. You may not reproduce, distribute, or create derivative works without our express written permission.</p>

                    <h5 class="fw-bold mt-4 mb-3 text-gray-800">8. Prohibited Conduct</h5>
                    <p class="text-muted">You agree not to: use the website for any unlawful purpose; attempt to gain unauthorized access to any portion of the website; interfere with or disrupt the website or servers; use automated systems to access the website; or engage in any conduct that restricts others from using the website.</p>

                    <h5 class="fw-bold mt-4 mb-3 text-gray-800">9. Limitation of Liability</h5>
                    <p class="text-muted">{{ config('app.name') }} shall not be liable for any indirect, incidental, special, consequential, or punitive damages arising out of your use of the website or purchase of products. Our total liability shall not exceed the amount paid by you for the specific product in question.</p>

                    <h5 class="fw-bold mt-4 mb-3 text-gray-800">10. Changes to Terms</h5>
                    <p class="text-muted">We reserve the right to modify these terms at any time. Changes will be effective immediately upon posting. Your continued use of the website after changes constitutes acceptance of the modified terms.</p>

                    <h5 class="fw-bold mt-4 mb-3 text-gray-800">11. Contact Us</h5>
                    <p class="text-muted">If you have any questions about these Terms of Service, please contact us at <a href="{{ route('contact') }}" class="text-primary-custom">support@ecommerce.test</a>.</p>
                </div>
            </div>
        </div>
    </div>
</div>
</x-layouts.frontend-layout>
