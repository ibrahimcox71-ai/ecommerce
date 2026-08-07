@props(['brands' => []])
@if($brands->isNotEmpty())
    <section class="mb-5">
        <div class="section-header">
            <div class="section-header-left">
                <span class="section-bar"></span>
                <h3>Shop by Brand</h3>
            </div>
        </div>
        <div class="brand-slider-v2 swiper">
            <div class="swiper-wrapper">
                @foreach($brands as $brand)
                    <div class="swiper-slide">
                        <a href="{{ route('brand.show', $brand->slug) }}" class="brand-card-v2">
                            @if($brand->image)
                                <img src="{{ asset('storage/' . $brand->image) }}" alt="{{ $brand->name }}" loading="lazy">
                            @else
                                <span class="brand-placeholder">{{ $brand->name[0] }}</span>
                            @endif
                            <span class="brand-name">{{ $brand->name }}</span>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
