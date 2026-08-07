<x-layouts.frontend-layout title="About Us" :seoData="$seoData ?? []">
@php $title = 'About Us' @endphp

<div class="container py-4">
    <x-breadcrumb :items="[['label' => 'About Us']]" />

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="text-center mb-4 mb-md-5">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3 sizing-80 bg-primary-light">
                    <i class="fas fa-store fa-3x text-primary-custom"></i>
                </div>
                <h1 class="fw-bold text-gray-800">About {{ config('app.name') }}</h1>
                <p class="lead text-muted mx-auto" style="max-width: 600px;">Your premium destination for quality products at unbeatable prices.</p>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-body p-4">
                            <h4 class="fw-bold mb-3 text-gray-800"><i class="fas fa-bullseye me-2 text-primary-custom"></i>Our Mission</h4>
                            <p class="text-muted">We are dedicated to providing customers with an exceptional shopping experience. Our goal is to offer a wide range of high-quality products at competitive prices, backed by outstanding customer service.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-body p-4">
                            <h4 class="fw-bold mb-3 text-gray-800"><i class="fas fa-eye me-2 text-primary-custom"></i>Our Vision</h4>
                            <p class="text-muted">To become the most trusted online shopping destination by consistently delivering value, quality, and convenience to our customers. We envision a future where online shopping is seamless, enjoyable, and accessible to everyone.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-3 g-md-4 mb-4">
                <div class="col-4">
                    <div class="card border-0 rounded-4 text-center p-3 p-md-4 h-100 bg-primary-50">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle mx-auto mb-2 mb-md-3 sizing-56 bg-primary-custom">
                            <i class="fas fa-box fa-lg text-white"></i>
                        </div>
                        <h5 class="fw-bold mb-1 text-gray-800">10K+</h5>
                        <p class="small mb-0 text-gray-500">Products</p>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card border-0 rounded-4 text-center p-3 p-md-4 h-100 bg-primary-50">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle mx-auto mb-2 mb-md-3 sizing-56 bg-primary-custom">
                            <i class="fas fa-users fa-lg text-white"></i>
                        </div>
                        <h5 class="fw-bold mb-1 text-gray-800">50K+</h5>
                        <p class="small mb-0 text-gray-500">Happy Customers</p>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card border-0 rounded-4 text-center p-3 p-md-4 h-100 bg-primary-50">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle mx-auto mb-2 mb-md-3 sizing-56 bg-primary-custom">
                            <i class="fas fa-globe fa-lg text-white"></i>
                        </div>
                        <h5 class="fw-bold mb-1 text-gray-800">100+</h5>
                        <p class="small mb-0 text-gray-500">Cities Served</p>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-3 p-md-4">
                    <h4 class="fw-bold mb-3 text-gray-800"><i class="fas fa-heart me-2 text-primary-custom"></i>Why Choose Us</h4>
                    <div class="row g-2">
                        <div class="col-sm-6">
                            <p class="mb-2 text-muted"><i class="fas fa-check-circle me-2 text-success-custom"></i>Wide selection of quality products</p>
                            <p class="mb-2 text-muted"><i class="fas fa-check-circle me-2 text-success-custom"></i>Competitive prices and regular promotions</p>
                            <p class="mb-2 text-muted"><i class="fas fa-check-circle me-2 text-success-custom"></i>Free shipping on orders over $50</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-2 text-muted"><i class="fas fa-check-circle me-2 text-success-custom"></i>30-day hassle-free return policy</p>
                            <p class="mb-2 text-muted"><i class="fas fa-check-circle me-2 text-success-custom"></i>Secure payment processing</p>
                            <p class="mb-2 text-muted"><i class="fas fa-check-circle me-2 text-success-custom"></i>24/7 dedicated customer support</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mb-4">
                <a href="{{ route('shop') }}" class="btn btn-primary-modern btn-lg rounded-pill px-4 px-md-5">
                    Start Shopping <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>
</div>
</x-layouts.frontend-layout>
