@props(['products' => [], 'endDate' => null])
@if($products->isNotEmpty())
    <section class="flash-sale-v2 mb-5">
        <div class="flash-bg-pattern">
            <i class="fas fa-bolt" aria-hidden="true"></i>
        </div>
        <div class="flash-content">
            <div class="flash-header">
                <div class="flash-title-section">
                    <div class="flash-icon">
                        <i class="fas fa-bolt" aria-hidden="true"></i>
                    </div>
                    <div>
                        <h2 class="flash-title">Flash Sale</h2>
                        <p class="flash-subtitle">Limited time offers ending soon</p>
                    </div>
                </div>
                <div class="flash-timer-v2" data-end="{{ $endDate ?? now()->addDays(3) }}">
                    <div class="timer-block">
                        <span class="timer-num" id="fsd-days">00</span>
                        <span class="timer-label">Days</span>
                    </div>
                    <span class="timer-sep">:</span>
                    <div class="timer-block">
                        <span class="timer-num" id="fsd-hours">00</span>
                        <span class="timer-label">Hours</span>
                    </div>
                    <span class="timer-sep">:</span>
                    <div class="timer-block">
                        <span class="timer-num" id="fsd-mins">00</span>
                        <span class="timer-label">Mins</span>
                    </div>
                    <span class="timer-sep">:</span>
                    <div class="timer-block">
                        <span class="timer-num" id="fsd-secs">00</span>
                        <span class="timer-label">Secs</span>
                    </div>
                </div>
            </div>
            <div class="flash-products-grid">
                @foreach($products->take(4) as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
            <div class="flash-cta">
                <a href="{{ route('flash-sale') }}" class="btn btn-light rounded-pill px-4">View All Deals <i class="fas fa-arrow-right ms-1" aria-hidden="true"></i></a>
            </div>
        </div>
    </section>
@endif
