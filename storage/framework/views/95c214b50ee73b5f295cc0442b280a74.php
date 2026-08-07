<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['cart' => null]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['cart' => null]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $cart = $cart ?? \App\Models\Cart::where('session_id', session()->getId())->first();
?>

<h6 class="fw-bold mb-3 text-gray-900">
    Shopping Cart
    <span class="text-muted fw-normal ms-1" id="miniCartCount">(<?php echo e($cart ? $cart->items->count() : 0); ?>)</span>
</h6>

<div id="miniCartItems" class="custom-scrollbar mini-cart-scroll">
    <?php if($cart && $cart->items->isNotEmpty()): ?>
        <?php $__currentLoopData = $cart->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="d-flex align-items-center gap-3 mb-3 mini-cart-item" data-item-id="<?php echo e($item->id); ?>">
                <img src="<?php echo e($item->product?->thumbnail ? asset('storage/' . $item->product->thumbnail) : 'https://placehold.co/64x64/f0f0f0/999?text=N'); ?>"
                     alt="<?php echo e($item->product?->name ?? 'Product'); ?>"
                     loading="lazy"
                     class="rounded sizing-64 object-cover radius-sm">
                <div class="flex-grow-1">
                    <a href="<?php echo e($item->product ? route('product.show', $item->product->slug) : '#'); ?>" class="text-decoration-none small fw-semibold text-gray-800 text-truncate d-block">
                        <?php echo e($item->product?->name ?? 'Unknown Product'); ?>

                    </a>
                    <?php if($item->variant): ?>
                        <small class="text-muted d-block"><?php echo e($item->variant->name ?? 'Default'); ?></small>
                    <?php endif; ?>
                    <div class="d-flex justify-content-between align-items-center mt-1">
                        <span class="fw-bold fs-7 text-primary-custom">$<?php echo e(number_format($item->unit_price * $item->quantity, 2)); ?></span>
                        <span class="text-muted fs-8">Qty: <?php echo e($item->quantity); ?></span>
                    </div>
                </div>
                <button class="btn btn-sm btn-link text-muted mini-cart-remove p-0" data-item-id="<?php echo e($item->id); ?>" title="Remove" aria-label="Remove <?php echo e($item->product?->name ?? 'item'); ?> from cart">
                    <i class="fas fa-times" aria-hidden="true"></i>
                </button>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php else: ?>
        <div class="text-center py-4">
            <i class="fas fa-shopping-bag fs-1 text-gray-300 mb-3 d-block" aria-hidden="true"></i>
            <p class="text-muted small mb-0">Your cart is empty</p>
            <a href="<?php echo e(route('shop')); ?>" class="btn btn-sm btn-primary rounded-pill mt-3">Start Shopping</a>
        </div>
    <?php endif; ?>
</div>

<?php if($cart && $cart->items->isNotEmpty()): ?>
    <hr class="my-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <span class="fw-semibold fs-7">Subtotal</span>
        <span class="fw-bold fs-5 text-primary-custom" id="miniCartSubtotal">$<?php echo e(number_format($cart->subtotal, 2)); ?></span>
    </div>
    <div class="d-grid gap-2">
        <a href="<?php echo e(route('cart')); ?>" class="btn btn-outline-primary btn-sm rounded-pill">
            View Cart <i class="fas fa-arrow-right ms-1" aria-hidden="true"></i>
        </a>
        <a href="<?php echo e(route('checkout')); ?>" class="btn btn-primary btn-sm rounded-pill">
            Checkout <i class="fas fa-lock ms-1" aria-hidden="true"></i>
        </a>
    </div>
<?php endif; ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const dropdown = document.getElementById('miniCartDropdown');
    const body = document.getElementById('miniCartItems');
    if (!dropdown) return;

    function loadMiniCart() {
        fetch('<?php echo e(route("cart")); ?>?mini=1', {
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
        fetch('<?php echo e(route("cart.remove")); ?>', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>' },
            body: JSON.stringify({ item_id: itemId })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) { loadMiniCart(); }
        });
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\components\mini-cart-content.blade.php ENDPATH**/ ?>