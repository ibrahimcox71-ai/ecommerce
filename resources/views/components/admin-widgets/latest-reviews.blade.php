@props(['reviews' => []])
@if($reviews->isNotEmpty())
    <div class="dashboard-widget">
        <h6 class="fw-semibold mb-3"><i class="fas fa-star me-2 text-warning" aria-hidden="true"></i>Latest Reviews</h6>
        @foreach($reviews as $review)
            <div class="d-flex gap-2 mb-2 pb-2 border-bottom">
                <x-star-rating :rating="$review->rating ?? 5" />
                <div>
                    <strong class="small">{{ $review->user?->name ?? 'Anonymous' }}</strong>
                    <p class="small text-muted mb-0">{{ Str::limit($review->body ?? '', 60) }}</p>
                </div>
            </div>
        @endforeach
    </div>
@endif
