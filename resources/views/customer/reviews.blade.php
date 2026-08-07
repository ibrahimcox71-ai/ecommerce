<x-layouts.customer-layout title="My Reviews">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">My Reviews</h4>
    </div>

    @if ($reviews->isEmpty())
        <div class="card">
            <div class="card-body text-center py-5 text-muted">
                <i class="fas fa-star fa-3x mb-3"></i>
                <p>You haven't reviewed any products yet.</p>
                <a href="{{ route('shop') }}" class="btn btn-primary">Browse Products</a>
            </div>
        </div>
    @else
        @foreach ($reviews as $review)
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body">
                    <div class="d-flex align-items-start gap-3">
                        <a href="{{ route('product.show', $review->product->slug) }}">
                            <img src="{{ $review->product->thumbnail ? asset('storage/' . $review->product->thumbnail) : 'https://placehold.co/80x80/f0f0f0/999?text=No+Image' }}"
                                 alt="{{ $review->product->name }}"
                                 style="width: 80px; height: 80px; object-fit: cover;"
                                 class="rounded">
                        </a>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <a href="{{ route('product.show', $review->product->slug) }}" class="text-decoration-none text-dark">
                                        <h6 class="fw-semibold mb-1">{{ $review->product->name }}</h6>
                                    </a>
                                    <x-star-rating :rating="$review->rating" />
                                </div>
                                <div class="text-end small text-muted">
                                    <span class="badge bg-{{ $review->status === 'approved' ? 'success' : ($review->status === 'pending' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($review->status) }}
                                    </span>
                                    <div class="mt-1">{{ $review->created_at->format('M d, Y') }}</div>
                                </div>
                            </div>
                            @if ($review->title)
                                <p class="fw-semibold mb-1 mt-2">{{ $review->title }}</p>
                            @endif
                            <p class="text-muted small mb-2">{{ $review->body }}</p>
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-outline-primary edit-review"
                                        data-review-id="{{ $review->id }}"
                                        data-rating="{{ $review->rating }}"
                                        data-title="{{ $review->title }}"
                                        data-body="{{ $review->body }}">
                                    <i class="fas fa-edit me-1"></i>Edit
                                </button>
                                <form method="POST" action="{{ route('customer.reviews.destroy', $review) }}" class="d-inline" onsubmit="return confirm('Delete this review?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash me-1"></i>Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="d-flex justify-content-center">
            {{ $reviews->links() }}
        </div>

        {{-- Edit Review Modal --}}
        <div class="modal fade" id="editReviewModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" id="editReviewForm">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Review</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Rating</label>
                                <div class="star-input">
                                    @for ($i = 5; $i >= 1; $i--)
                                        <div class="form-check form-check-inline">
                                            <input type="radio" name="rating" id="rating{{ $i }}" value="{{ $i }}" class="form-check-input">
                                            <label class="form-check-label" for="rating{{ $i }}">{{ $i }} <i class="fas fa-star text-warning"></i></label>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-outline">
                                    <input type="text" name="title" id="editTitle" class="form-control">
                                    <label class="form-label" for="editTitle">Title (Optional)</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-outline">
                                    <textarea name="body" id="editBody" class="form-control" rows="4" required></textarea>
                                    <label class="form-label" for="editBody">Your Review</label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Update Review</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    @push('scripts')
    <script>
        document.querySelectorAll('.edit-review').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.reviewId;
                document.getElementById('editReviewForm').action = '/customer/reviews/' + id;
                document.querySelector('input[name="rating"][value="' + this.dataset.rating + '"]').checked = true;
                document.getElementById('editTitle').value = this.dataset.title;
                document.getElementById('editBody').value = this.dataset.body;
                new bootstrap.Modal(document.getElementById('editReviewModal')).show();
            });
        });
    </script>
    @endpush
</x-layouts.customer-layout>
