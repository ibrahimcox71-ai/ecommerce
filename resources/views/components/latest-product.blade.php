@props(['products' => [], 'title' => 'New Arrivals'])
@if($products->isNotEmpty())
    <section class="mb-5">
        <div class="section-header">
            <div class="section-header-left">
                <span class="section-bar"></span>
                <h3>{{ $title }}</h3>
            </div>
            <a href="{{ route('shop', ['sort' => 'latest']) }}" class="section-link">View All <i class="fas fa-arrow-right ms-1" aria-hidden="true"></i></a>
        </div>
        <div class="row g-3 g-md-4 row-cols-2 row-cols-md-3 row-cols-lg-4">
            @foreach($products as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>
    </section>
@endif
