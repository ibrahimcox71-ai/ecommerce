@props(['slides' => []])
@if($slides->isNotEmpty())
    <section class="hero-slider-v2 swiper mb-5" aria-label="Featured promotions">
        <div class="swiper-wrapper">
            @foreach($slides as $slide)
                <div class="swiper-slide">
                    <div class="hero-slide-content" style="background: linear-gradient(135deg, {{ $slide['bg_start'] ?? 'var(--primary)' }}, {{ $slide['bg_end'] ?? 'var(--secondary)' }});">
                        <div class="container">
                            <div class="row align-items-center">
                                <div class="col-lg-6">
                                    <h1 class="hero-title-xlarge text-white">{{ $slide['title'] ?? '' }}</h1>
                                    <p class="hero-subtitle text-white">{{ $slide['subtitle'] ?? '' }}</p>
                                    @if($slide['cta_url'] ?? false)
                                        <a href="{{ $slide['cta_url'] }}" class="btn btn-light btn-lg rounded-pill px-4 mt-3">
                                            {{ $slide['cta_text'] ?? 'Shop Now' }} <i class="fas fa-arrow-right ms-2" aria-hidden="true"></i>
                                        </a>
                                    @endif
                                </div>
                                @if($slide['image'] ?? false)
                                    <div class="col-lg-6 text-center">
                                        <img src="{{ $slide['image'] }}" alt="{{ $slide['title'] ?? '' }}" class="img-fluid hero-slide-img" loading="lazy">
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="swiper-pagination hero-pagination" aria-hidden="true"></div>
    </section>
@endif
