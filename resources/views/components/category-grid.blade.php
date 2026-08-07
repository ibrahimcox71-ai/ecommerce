@props(['categories' => []])
@if($categories->isNotEmpty())
    <section class="mb-5">
        <div class="section-header">
            <div class="section-header-left">
                <span class="section-bar"></span>
                <h3>Featured Categories</h3>
            </div>
            <a href="{{ route('shop') }}" class="section-link">View All <i class="fas fa-arrow-right ms-1" aria-hidden="true"></i></a>
        </div>
        <div class="row g-3 g-md-4 row-cols-2 row-cols-md-3 row-cols-lg-4">
            @foreach($categories as $category)
                <div class="col">
                    <a href="{{ route('category.show', $category->slug) }}" class="text-decoration-none">
                        <div class="card border-0 shadow-sm rounded-4 text-center p-4 h-100">
                            <div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center sizing-64 bg-primary-50 text-primary-custom" style="font-size: 1.5rem;">
                                <i class="{{ $category->icon ?? 'fas fa-folder' }}" aria-hidden="true"></i>
                            </div>
                            <h6 class="fw-semibold mb-1 text-gray-800">{{ $category->name }}</h6>
                            <small class="text-muted">{{ $category->products_count ?? 0 }} products</small>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </section>
@endif
