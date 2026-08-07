<x-layouts.frontend-layout>
@php $title = 'Order Failed' @endphp

<div class="container py-5">
    <div class="text-center mb-5">
        <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3 sizing-96 bg-danger-light">
            <i class="fas fa-times-circle text-danger" style="font-size: 3rem;"></i>
        </div>
        <h1 class="fw-bold text-gray-800">Order Failed</h1>
        <p class="fs-5 text-gray-500">We're sorry, but your order could not be processed.</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-6 text-center">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body py-4">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3 sizing-64 bg-warning-light">
                        <i class="fas fa-exclamation-triangle fa-2x text-warning"></i>
                    </div>
                    <h5 class="text-gray-800">What went wrong?</h5>
                    <p class="text-muted">There was an issue processing your payment. Your card has not been charged.</p>
                    <hr>
                    <p class="mb-0 text-muted">Please try again or choose a different payment method.</p>
                </div>
            </div>
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('checkout') }}" class="btn btn-lg rounded-pill px-4 btn-primary-modern">
                    <i class="fas fa-redo me-2"></i>Try Again
                </a>
                <a href="{{ route('shop') }}" class="btn btn-lg rounded-pill px-4 border-gray-300 text-gray-600">
                    Continue Shopping
                </a>
            </div>
        </div>
    </div>
</div>
</x-layouts.frontend-layout>
