<x-layouts.frontend-layout>
@php $title = 'Blog' @endphp

<div class="container py-4">
    <x-breadcrumb :items="[['label' => 'Blog']]" />

    <div class="text-center mb-5">
        <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3 sizing-72 bg-primary-light">
            <i class="fas fa-newspaper fa-2x text-primary-custom"></i>
        </div>
        <h1 class="fw-bold text-gray-800">Our Blog</h1>
        <p class="text-muted" style="max-width: 500px; margin: 0 auto;">Stay updated with the latest news, tips, and trends.</p>
    </div>

    <div class="row g-4">
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="rounded-top-4 d-flex align-items-center justify-content-center" style="height: 200px; background: linear-gradient(135deg, var(--primary-50), #E0E7FF);">
                    <i class="fas fa-shopping-bag fa-4x text-primary-custom" style="opacity: 0.4;"></i>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-2">
                        <span class="badge rounded-pill px-3 py-1 me-2 bg-primary-custom text-white">Shopping Tips</span>
                        <small class="text-muted">Jun 25, 2026</small>
                    </div>
                    <h5 class="fw-bold card-title text-gray-800">10 Tips for Smart Online Shopping</h5>
                    <p class="card-text text-muted">Discover how to make the most of your online shopping experience with these expert tips and tricks.</p>
                </div>
                <div class="card-footer bg-transparent border-0 pb-4 px-4">
                    <a href="#" class="text-decoration-none fw-semibold text-primary-custom">
                        Read More <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="rounded-top-4 d-flex align-items-center justify-content-center" style="height: 200px; background: linear-gradient(135deg, #D1FAE5, #A7F3D0);">
                    <i class="fas fa-laptop fa-4x text-success-custom" style="opacity: 0.4;"></i>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-2">
                        <span class="badge rounded-pill px-3 py-1 me-2 bg-success text-white">Technology</span>
                        <small class="text-muted">Jun 22, 2026</small>
                    </div>
                    <h5 class="fw-bold card-title text-gray-800">Best Tech Gadgets of 2026</h5>
                    <p class="card-text text-muted">Explore the most innovative technology products that are trending this year.</p>
                </div>
                <div class="card-footer bg-transparent border-0 pb-4 px-4">
                    <a href="#" class="text-decoration-none fw-semibold text-primary-custom">
                        Read More <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="rounded-top-4 d-flex align-items-center justify-content-center" style="height: 200px; background: linear-gradient(135deg, #FEF3C7, #FDE68A);">
                    <i class="fas fa-tshirt fa-4x text-warning" style="opacity: 0.4;"></i>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-2">
                        <span class="badge rounded-pill px-3 py-1 me-2 bg-warning text-dark">Fashion</span>
                        <small class="text-muted">Jun 18, 2026</small>
                    </div>
                    <h5 class="fw-bold card-title text-gray-800">Summer Fashion Trends to Watch</h5>
                    <p class="card-text text-muted">Get inspired by the latest fashion trends and update your wardrobe this season.</p>
                </div>
                <div class="card-footer bg-transparent border-0 pb-4 px-4">
                    <a href="#" class="text-decoration-none fw-semibold text-primary-custom">
                        Read More <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="rounded-top-4 d-flex align-items-center justify-content-center" style="height: 200px; background: linear-gradient(135deg, #DBEAFE, #BFDBFE);">
                    <i class="fas fa-home fa-4x text-info" style="opacity: 0.4;"></i>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-2">
                        <span class="badge rounded-pill px-3 py-1 me-2 bg-info text-white">Home & Living</span>
                        <small class="text-muted">Jun 15, 2026</small>
                    </div>
                    <h5 class="fw-bold card-title text-gray-800">Create Your Dream Living Space</h5>
                    <p class="card-text text-muted">Transform your home with these simple and affordable decoration ideas.</p>
                </div>
                <div class="card-footer bg-transparent border-0 pb-4 px-4">
                    <a href="#" class="text-decoration-none fw-semibold text-primary-custom">
                        Read More <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="rounded-top-4 d-flex align-items-center justify-content-center" style="height: 200px; background: linear-gradient(135deg, #FCE7F3, #FBCFE8);">
                    <i class="fas fa-heart fa-4x" style="color: #EC4899; opacity: 0.4;"></i>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-2">
                        <span class="badge rounded-pill px-3 py-1 me-2" style="background: #EC4899;">Wellness</span>
                        <small class="text-muted">Jun 12, 2026</small>
                    </div>
                    <h5 class="fw-bold card-title text-gray-800">Self-Care Essentials You Need</h5>
                    <p class="card-text text-muted">Discover the best beauty and wellness products for your daily self-care routine.</p>
                </div>
                <div class="card-footer bg-transparent border-0 pb-4 px-4">
                    <a href="#" class="text-decoration-none fw-semibold text-primary-custom">
                        Read More <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="rounded-top-4 d-flex align-items-center justify-content-center" style="height: 200px; background: linear-gradient(135deg, #E0E7FF, #C7D2FE);">
                    <i class="fas fa-truck fa-4x" style="opacity: 0.4;"></i>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-2">
                        <span class="badge rounded-pill px-3 py-1 me-2" style="background: var(--secondary);">Shipping</span>
                        <small class="text-muted">Jun 10, 2026</small>
                    </div>
                    <h5 class="fw-bold card-title text-gray-800">Understanding Our Shipping Process</h5>
                    <p class="card-text text-muted">Learn how we ensure your orders are delivered safely and on time, every time.</p>
                </div>
                <div class="card-footer bg-transparent border-0 pb-4 px-4">
                    <a href="#" class="text-decoration-none fw-semibold text-primary-custom">
                        Read More <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mt-5">
        <p class="text-muted">More articles coming soon. Subscribe to our newsletter to stay updated!</p>
    </div>
</div>
</x-layouts.frontend-layout>
