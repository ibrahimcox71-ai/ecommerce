<x-layouts.admin-layout title="Reviews">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Reviews</h4>
            <p class="text-muted small mb-0">Manage product reviews and ratings</p>
        </div>
        <div>
            <span class="badge bg-warning text-dark fs-6 px-3 py-2">
                <i class="fas fa-clock me-1"></i>
                {{ \App\Models\Review::pending()->count() }} pending
            </span>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.reviews.index') }}" class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Search reviews, users, products..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="rating" class="form-select">
                        <option value="">All Ratings</option>
                        @for ($i = 5; $i >= 1; $i--)
                            <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>{{ $i }} Star</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="verified" class="form-select">
                        <option value="">All</option>
                        <option value="1" {{ request('verified') === '1' ? 'selected' : '' }}>Verified Purchase</option>
                        <option value="0" {{ request('verified') === '0' ? 'selected' : '' }}>Unverified</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-outline-primary w-100">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @if ($reviews->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0">Product</th>
                                <th class="border-0">Customer</th>
                                <th class="border-0 text-center">Rating</th>
                                <th class="border-0">Review</th>
                                <th class="border-0 text-center">Images</th>
                                <th class="border-0 text-center">Verified</th>
                                <th class="border-0 text-center">Status</th>
                                <th class="border-0 text-center">Date</th>
                                <th class="border-0 text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reviews as $review)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $review->product?->images->first()?->image_url ?? 'https://placehold.co/48x48/f0f0f0/999?text=N' }}"
                                                 alt="" class="rounded me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                            <small class="fw-semibold text-truncate" style="max-width: 150px;">{{ $review->product?->name }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <small class="fw-semibold">{{ $review->user?->name ?? 'Anonymous' }}</small>
                                        <small class="d-block text-muted">{{ $review->user?->email }}</small>
                                    </td>
                                    <td class="text-center">
                                        <x-star-rating :rating="$review->rating" />
                                    </td>
                                    <td style="max-width: 200px;">
                                        @if ($review->title)
                                            <small class="fw-semibold d-block text-truncate">{{ $review->title }}</small>
                                        @endif
                                        <small class="text-muted d-block text-truncate">{{ $review->body }}</small>
                                    </td>
                                    <td class="text-center">
                                        @if ($review->images->count() > 0)
                                            <span class="badge bg-info">{{ $review->images->count() }}</span>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($review->is_verified)
                                            <i class="fas fa-check-circle text-success" title="Verified Purchase"></i>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($review->status === 'approved')
                                            <span class="badge bg-success">Approved</span>
                                        @elseif ($review->status === 'pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @else
                                            <span class="badge bg-danger">Rejected</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <small class="text-muted">{{ $review->created_at->format('M d, Y') }}</small>
                                    </td>
                                    <td class="text-end">
                                        <div class="btn-group">
                                            <a href="{{ route('admin.reviews.show', $review) }}" class="btn btn-sm btn-outline-secondary" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if ($review->status !== 'approved')
                                                <form method="POST" action="{{ route('admin.reviews.approve', $review) }}" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-success" title="Approve">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            @if ($review->status !== 'rejected')
                                                <form method="POST" action="{{ route('admin.reviews.reject', $review) }}" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-warning" title="Reject">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            <form method="POST" action="{{ route('admin.reviews.destroy', $review) }}" class="d-inline" onsubmit="return confirm('Delete this review?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted small">
                        Showing {{ $reviews->firstItem() }} to {{ $reviews->lastItem() }} of {{ $reviews->total() }} entries
                    </div>
                    <div>{{ $reviews->links() }}</div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-star fa-4x text-muted mb-3"></i>
                    <h5>No reviews found</h5>
                    <p class="text-muted">
                        @if(request()->anyFilled(['search', 'status', 'rating', 'verified']))
                            No reviews match your filters. <a href="{{ route('admin.reviews.index') }}">Clear filters</a>
                        @else
                            No reviews yet.
                        @endif
                    </p>
                </div>
            @endif
        </div>
    </div>
</x-layouts.admin-layout>
