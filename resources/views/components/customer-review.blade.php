@props(['reviews' => []])
@if($reviews->isNotEmpty())
    <section class="mb-5">
        <div class="section-header">
            <div class="section-header-left">
                <span class="section-bar"></span>
                <h3>What Our Customers Say</h3>
            </div>
        </div>
        <div class="row g-4">
            @foreach($reviews as $review)
                <div class="col-md-6 col-lg-3">
                    <div class="card border-0 shadow-sm rounded-4 h-100 p-4">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="rounded-circle bg-primary-50 d-flex align-items-center justify-content-center sizing-44 text-primary-custom fw-bold">
                                {{ $review->user?->name[0] ?? 'A' }}
                            </div>
                            <div>
                                <strong class="text-gray-800">{{ $review->user?->name ?? 'Anonymous' }}</strong>
                                <x-star-rating :rating="$review->rating" />
                            </div>
                        </div>
                        <p class="text-muted small mb-0">"{{ Str::limit($review->body ?? '', 120) }}"</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endif
