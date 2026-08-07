<x-layouts.admin-layout title="Review Detail">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Review Detail</h4>
            <p class="text-muted small mb-0">View and manage product review</p>
        </div>
        <a href="{{ route('admin.reviews.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to Reviews
        </a>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <div>
                        <x-star-rating :rating="$review->rating" />
                        @if ($review->title)
                            <h5 class="mt-2 mb-0">{{ $review->title }}</h5>
                        @endif
                    </div>
                    <div class="d-flex gap-2">
                        @if ($review->is_verified)
                            <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Verified Purchase</span>
                        @endif
                        @if ($review->status === 'approved')
                            <span class="badge bg-success">Approved</span>
                        @elseif ($review->status === 'pending')
                            <span class="badge bg-warning text-dark">Pending</span>
                        @else
                            <span class="badge bg-danger">Rejected</span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <p>{{ $review->body }}</p>

                    @if ($review->images->isNotEmpty())
                        <div class="mt-3">
                            <label class="form-label fw-semibold small text-muted">Review Images</label>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach ($review->images as $image)
                                    <a href="{{ $image->image_url }}" target="_blank">
                                        <img src="{{ $image->image_url }}" alt="Review image"
                                             style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px; border: 1px solid #e2e8f0;">
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="mt-3 text-muted small">
                        <i class="fas fa-thumbs-up me-1"></i> {{ $review->helpful_count }} found helpful &middot;
                        Posted {{ $review->created_at->diffForHumans() }}
                        @if ($review->verified_at)
                            &middot; <i class="fas fa-check-circle text-success me-1"></i>Verified {{ $review->verified_at->diffForHumans() }}
                        @endif
                    </div>
                </div>
                <div class="card-footer bg-white d-flex gap-2">
                    @if ($review->status !== 'approved')
                        <form method="POST" action="{{ route('admin.reviews.approve', $review) }}">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="fas fa-check me-1"></i> Approve
                            </button>
                        </form>
                    @endif
                    @if ($review->status !== 'rejected')
                        <form method="POST" action="{{ route('admin.reviews.reject', $review) }}">
                            @csrf
                            <button type="submit" class="btn btn-warning btn-sm">
                                <i class="fas fa-times me-1"></i> Reject
                            </button>
                        </form>
                    @endif
                    @if (!$review->is_verified)
                        <form method="POST" action="{{ route('admin.reviews.mark-verified', $review) }}">
                            @csrf
                            <button type="submit" class="btn btn-info btn-sm text-white">
                                <i class="fas fa-check-double me-1"></i> Mark Verified
                            </button>
                        </form>
                    @endif
                    <form method="POST" action="{{ route('admin.reviews.destroy', $review) }}" onsubmit="return confirm('Delete this review permanently?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash me-1"></i> Delete
                        </button>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-white">
                    <h6 class="mb-0 fw-semibold"><i class="fas fa-reply me-2"></i>Replies</h6>
                </div>
                <div class="card-body">
                    @if ($review->replies->isNotEmpty())
                        @foreach ($review->replies as $reply)
                            <div class="d-flex justify-content-between align-items-start mb-3 pb-3 border-bottom">
                                <div>
                                    <strong class="text-primary small">{{ $reply->admin?->name ?? 'Admin' }}</strong>
                                    <small class="text-muted ms-2">{{ $reply->created_at->diffForHumans() }}</small>
                                    <p class="mb-0 mt-1">{{ $reply->body }}</p>
                                </div>
                                <form method="POST" action="{{ route('admin.reviews.reply.delete', $reply) }}" onsubmit="return confirm('Delete this reply?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted mb-0">No replies yet.</p>
                    @endif

                    <form method="POST" action="{{ route('admin.reviews.reply', $review) }}" class="mt-3">
                        @csrf
                        <div class="mb-2">
                            <textarea name="body" class="form-control" rows="2" placeholder="Write a reply..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-paper-plane me-1"></i> Reply
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h6 class="mb-0 fw-semibold">Product</h6>
                </div>
                <div class="card-body text-center">
                    @if ($review->product)
                        <img src="{{ $review->product->images->first()?->image_url ?? 'https://placehold.co/150x150/f0f0f0/999?text=N' }}"
                             alt="" class="rounded mb-3" style="width: 120px; height: 120px; object-fit: cover;">
                        <h6>{{ $review->product->name }}</h6>
                        <a href="{{ route('admin.products.show', $review->product) }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-box me-1"></i> View Product
                        </a>
                    @endif
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h6 class="mb-0 fw-semibold">Customer</h6>
                </div>
                <div class="card-body">
                    <p class="mb-1"><strong>{{ $review->user?->name ?? 'Anonymous' }}</strong></p>
                    <p class="text-muted small mb-0">{{ $review->user?->email }}</p>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-white">
                    <h6 class="mb-0 fw-semibold">Details</h6>
                </div>
                <div class="card-body small">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Status</span>
                        <span>
                            @if ($review->status === 'approved')
                                <span class="badge bg-success">Approved</span>
                            @elseif ($review->status === 'pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                            @else
                                <span class="badge bg-danger">Rejected</span>
                            @endif
                        </span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Rating</span>
                        <span><x-star-rating :rating="$review->rating" /></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Verified</span>
                        <span>{!! $review->is_verified ? '<i class="fas fa-check-circle text-success"></i> Yes' : 'No' !!}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Helpful</span>
                        <span>{{ $review->helpful_count }} votes</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Submitted</span>
                        <span>{{ $review->created_at->format('M d, Y h:i A') }}</span>
                    </div>
                    @if ($review->verified_at)
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Verified at</span>
                            <span>{{ $review->verified_at->format('M d, Y') }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin-layout>
