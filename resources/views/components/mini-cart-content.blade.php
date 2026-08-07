@props(['cart' => null])

@php
    $cart = $cart ?? \App\Models\Cart::where('session_id', session()->getId())->first();
@endphp

<h6 class="fw-bold mb-3 text-gray-900">
    Shopping Cart
    <span class="text-muted fw-normal ms-1" id="miniCartCount">({{ $cart ? $cart->items->count() : 0 }})</span>
</h6>

<div id="miniCartItems" class="custom-scrollbar mini-cart-scroll">
    @if ($cart && $cart->items->isNotEmpty())
        @foreach ($cart->items as $item)
            <div class="d-flex align-items-center gap-3 mb-3 mini-cart-item" data-item-id="{{ $item->id }}">
                <img src="{{ $item->product?->thumbnail ? asset('storage/' . $item->product->thumbnail) : 'https://placehold.co/64x64/f0f0f0/999?text=N' }}"
                     alt="{{ $item->product?->name ?? 'Product' }}"
                     loading="lazy"
                     class="rounded sizing-64 object-cover radius-sm">
                <div class="flex-grow-1">
                    <a href="{{ $item->product ? route('product.show', $item->product->slug) : '#' }}" class="text-decoration-none small fw-semibold text-gray-800 text-truncate d-block">
                        {{ $item->product?->name ?? 'Unknown Product' }}
                    </a>
                    @if ($item->variant)
                        <small class="text-muted d-block">{{ $item->variant->name ?? 'Default' }}</small>
                    @endif
                    <div class="d-flex justify-content-between align-items-center mt-1">
                        <span class="fw-bold fs-7 text-primary-custom">${{ number_format($item->unit_price * $item->quantity, 2) }}</span>
                        <span class="text-muted fs-8">Qty: {{ $item->quantity }}</span>
                    </div>
                </div>
                <button class="btn btn-sm btn-link text-muted mini-cart-remove p-0" data-item-id="{{ $item->id }}" title="Remove" aria-label="Remove {{ $item->product?->name ?? 'item' }} from cart">
                    <i class="fas fa-times" aria-hidden="true"></i>
                </button>
            </div>
        @endforeach
    @else
        <div class="text-center py-4">
            <i class="fas fa-shopping-bag fs-1 text-gray-300 mb-3 d-block" aria-hidden="true"></i>
            <p class="text-muted small mb-0">Your cart is empty</p>
            <a href="{{ route('shop') }}" class="btn btn-sm btn-primary rounded-pill mt-3">Start Shopping</a>
        </div>
    @endif
</div>

@if ($cart && $cart->items->isNotEmpty())
    <hr class="my-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <span class="fw-semibold fs-7">Subtotal</span>
        <span class="fw-bold fs-5 text-primary-custom" id="miniCartSubtotal">${{ number_format($cart->subtotal, 2) }}</span>
    </div>
    <div class="d-grid gap-2">
        <a href="{{ route('cart') }}" class="btn btn-outline-primary btn-sm rounded-pill">
            View Cart <i class="fas fa-arrow-right ms-1" aria-hidden="true"></i>
        </a>
        <a href="{{ route('checkout') }}" class="btn btn-primary btn-sm rounded-pill">
            Checkout <i class="fas fa-lock ms-1" aria-hidden="true"></i>
        </a>
    </div>
@endif

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const dropdown = document.getElementById('miniCartDropdown');
    const body = document.getElementById('miniCartItems');
    if (!dropdown) return;

    function loadMiniCart() {
        fetch('{{ route("cart") }}?mini=1', {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(data => {
            body.innerHTML = data.html;
            const badge = document.querySelector('.cart-count-badge');
            if (badge && data.cart) badge.textContent = data.cart.items_count;
        })
        .catch(() => {});
    }

    const cartLink = document.getElementById('cartDropdown');
    if (cartLink) {
        cartLink.addEventListener('click', function(e) {
            if (body.querySelector('.text-center.py-4') || !body.querySelector('.mini-cart-item')) {
                loadMiniCart();
            }
        });
    }

    dropdown.addEventListener('click', function(e) {
        const btn = e.target.closest('.mini-cart-remove');
        if (!btn) return;
        const itemId = btn.dataset.itemId;
        fetch('{{ route("cart.remove") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ item_id: itemId })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) { loadMiniCart(); }
        });
    });
});
</script>
@endpush
