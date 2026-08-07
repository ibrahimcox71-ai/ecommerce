<x-layouts.customer-layout title="Wishlist">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">My Wishlist</h4>
        @if ($wishlists->isNotEmpty())
            <span class="text-muted">{{ $wishlists->count() }} item(s)</span>
        @endif
    </div>

    @if ($wishlists->isEmpty())
        <div class="card">
            <div class="card-body text-center py-5 text-muted">
                <i class="fas fa-heart fa-3x mb-3"></i>
                <p>Your wishlist is empty.</p>
                <a href="{{ route('shop') }}" class="btn btn-primary">Browse Products</a>
            </div>
        </div>
    @else
        <div class="row g-3">
            @foreach ($wishlists as $wishlist)
                @php $product = $wishlist->product @endphp
                <div class="col-md-6 col-lg-4 wishlist-item">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="row g-0 h-100">
                            <div class="col-4">
                                <a href="{{ route('product.show', $product->slug) }}">
                                    <img src="{{ $product->thumbnail ? asset('storage/' . $product->thumbnail) : 'https://placehold.co/200x200/f0f0f0/999?text=No+Image' }}"
                                         alt="{{ $product->name }}"
                                         class="img-fluid rounded-start h-100"
                                         style="object-fit: cover;">
                                </a>
                            </div>
                            <div class="col-8">
                                <div class="card-body d-flex flex-column h-100 py-2">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <small class="text-muted text-uppercase">{{ $product->brand?->name }}</small>
                                            <a href="{{ route('product.show', $product->slug) }}" class="text-decoration-none text-dark">
                                                <h6 class="fw-semibold mb-1" style="display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden;">
                                                    {{ $product->name }}
                                                </h6>
                                            </a>
                                        </div>
                                        <button class="btn btn-sm btn-link text-danger p-0 remove-wishlist" data-product-id="{{ $product->id }}" title="Remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                    <div class="mb-1">
                                        <x-star-rating :rating="$product->average_rating" />
                                        <small class="text-muted">({{ $product->review_count }})</small>
                                    </div>
                                    <div class="mt-auto d-flex justify-content-between align-items-center">
                                        <span class="fw-bold text-primary">
                                            @if ($product->has_discount)
                                                ${{ number_format($product->current_price, 2) }}
                                                <small class="text-muted text-decoration-line-through">${{ number_format($product->price, 2) }}</small>
                                            @else
                                                ${{ number_format($product->price, 2) }}
                                            @endif
                                        </span>
                                        <form method="POST" action="{{ route('cart') }}" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="btn btn-primary btn-sm" title="Add to Cart">
                                                <i class="fas fa-shopping-cart me-1"></i>Add
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    @push('scripts')
    <script>
        document.querySelectorAll('.remove-wishlist').forEach(btn => {
            btn.addEventListener('click', function() {
                const productId = this.dataset.productId;
                const card = this.closest('.wishlist-item');

                fetch('{{ route("wishlist.toggle") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                    },
                    body: JSON.stringify({ product_id: productId })
                })
                .then(r => r.json())
                .then(d => {
                    if (d.status === 'success') {
                        card.remove();
                        const remaining = document.querySelectorAll('.wishlist-item').length;
                        if (remaining === 0) location.reload();
                    }
                });
            });
        });
    </script>
    @endpush
</x-layouts.customer-layout>
