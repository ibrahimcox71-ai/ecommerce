<x-layouts.frontend-layout title="Flash Sale" :seoData="$seoData ?? []">
@php $title = 'Flash Sale' @endphp

<div class="flash-sale-page">
    {{-- Hero Banner --}}
    <div class="flash-sale-hero-v2">
        <div class="flash-hero-bg-pattern"><i class="fas fa-bolt"></i></div>
        <div class="container">
            <div class="flash-hero-content text-center">
                <div class="flash-hero-icon">
                    <i class="fas fa-bolt"></i>
                </div>
                <h1 class="flash-hero-title">Flash Sale</h1>
                <p class="flash-hero-subtitle">Limited time offers with massive discounts. Don't miss out!</p>
                <div class="flash-hero-timer" id="flashCountdown">
                    <div class="timer-block">
                        <span class="timer-num" id="fd-hours">00</span>
                        <span class="timer-label">Hours</span>
                    </div>
                    <span class="timer-sep">:</span>
                    <div class="timer-block">
                        <span class="timer-num" id="fd-mins">00</span>
                        <span class="timer-label">Minutes</span>
                    </div>
                    <span class="timer-sep">:</span>
                    <div class="timer-block">
                        <span class="timer-num" id="fd-secs">00</span>
                        <span class="timer-label">Seconds</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container py-4">
        <x-breadcrumb :items="[['label' => 'Flash Sale']]" />

        @if ($products->isNotEmpty())
            <div class="row g-3 g-md-4 row-cols-2 row-cols-md-3 row-cols-lg-4">
                @foreach ($products as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
            <div class="d-flex justify-content-center mt-4">
                {{ $products->links() }}
            </div>
        @else
            <div class="text-center py-5 empty-state-flash">
                <i class="fas fa-clock fa-4x text-gray-300 mb-3"></i>
                <h5 class="fw-bold">No flash sale products available</h5>
                <p class="text-muted mb-3">Check back later for new deals.</p>
                <a href="{{ route('shop') }}" class="btn btn-primary rounded-pill px-4">Browse All Products</a>
            </div>
        @endif
    </div>
</div>

@push('styles')
<style>
.flash-sale-hero-v2 {
    background: radial-gradient(ellipse at top right, rgba(245,114,36,.28), transparent 55%), linear-gradient(135deg, #171717 0%, #212121 65%, #2B2B2B 100%);
    padding: 48px 20px 56px;
    position: relative;
    overflow: hidden;
    margin-bottom: 8px;
}
.flash-hero-bg-pattern {
    position: absolute; inset: 0; opacity: 0.04; display: flex; align-items: center; justify-content: center;
    font-size: 300px; pointer-events: none; color: #F57224;
}
.flash-hero-icon {
    width: 80px; height: 80px; border-radius: 50%;
    background: linear-gradient(135deg, #F57224, #D0520A);
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 20px; font-size: 36px; color: #fff;
    box-shadow: 0 8px 24px rgba(245,114,36,.4);
}
.flash-hero-title {
    font-size: 40px; font-weight: 900; color: #fff; letter-spacing: -1px; margin-bottom: 8px;
}
@media (max-width: 767.98px) { .flash-hero-title { font-size: 28px; } }
.flash-hero-subtitle { font-size: 16px; color: #FFFFFF; max-width: 500px; margin: 0 auto 24px; }
.flash-hero-timer {
    display: inline-flex; align-items: center; gap: 12px;
    background: rgba(255,255,255,.1); backdrop-filter: blur(12px);
    padding: 12px 24px; border-radius: 16px; border: 1px solid rgba(255,255,255,.12);
}
.flash-hero-timer .timer-block { text-align: center; }
.flash-hero-timer .timer-num {
    font-size: 32px; font-weight: 800; color: #fff; display: block; line-height: 1;
    min-width: 48px;
}
.flash-hero-timer .timer-label { font-size: 11px; color: rgba(255,255,255,.5); text-transform: uppercase; letter-spacing: .5px; }
.flash-hero-timer .timer-sep { font-size: 28px; font-weight: 700; color: rgba(255,255,255,.3); }
@media (max-width: 767.98px) {
    .flash-hero-timer { padding: 10px 16px; }
    .flash-hero-timer .timer-num { font-size: 24px; min-width: 36px; }
}
.empty-state-flash { padding: 60px 20px; }
</style>
@endpush

@push('scripts')
<script>
(function() {
    var endDate = new Date();
    endDate.setHours(23, 59, 59);
    endDate.setDate(endDate.getDate() + 3);
    function tick() {
        var diff = endDate - new Date();
        if (diff <= 0) return;
        document.getElementById('fd-hours').textContent = String(Math.floor((diff / (1000 * 60 * 60)) % 24)).padStart(2, '0');
        document.getElementById('fd-mins').textContent = String(Math.floor((diff / (1000 * 60)) % 60)).padStart(2, '0');
        document.getElementById('fd-secs').textContent = String(Math.floor((diff / 1000) % 60)).padStart(2, '0');
    }
    tick();
    setInterval(tick, 1000);
})();
</script>
@endpush
</x-layouts.frontend-layout>