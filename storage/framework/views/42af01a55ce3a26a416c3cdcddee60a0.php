<?php if (isset($component)) { $__componentOriginaleac9542bb5e3f887e862d1d96c472e9b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaleac9542bb5e3f887e862d1d96c472e9b = $attributes; } ?>
<?php $component = App\View\Components\Layouts\FrontendLayout::resolve(['title' => 'Shopping Cart'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.frontend-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\FrontendLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php $title = 'Cart' ?>

<div class="cart-page">
    <div class="container py-4">
        <?php if (isset($component)) { $__componentOriginale19f62b34dfe0bfdf95075badcb45bc2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumb','data' => ['items' => [['label' => 'Cart']]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('breadcrumb'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([['label' => 'Cart']])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2)): ?>
<?php $attributes = $__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2; ?>
<?php unset($__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale19f62b34dfe0bfdf95075badcb45bc2)): ?>
<?php $component = $__componentOriginale19f62b34dfe0bfdf95075badcb45bc2; ?>
<?php unset($__componentOriginale19f62b34dfe0bfdf95075badcb45bc2); ?>
<?php endif; ?>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="section-bar"></div>
                    <h3 class="fw-bold mb-0">Shopping Cart</h3>
                    <?php if($cart && $cart->items->isNotEmpty()): ?>
                        <span class="cart-items-count-badge"><?php echo e($cart->items->sum('quantity')); ?> items</span>
                    <?php endif; ?>
                </div>

                <?php if($cart && $cart->items->isNotEmpty()): ?>
                    
                    <div class="cart-table-header d-none d-md-flex">
                        <span class="th-product">Product</span>
                        <span class="th-price">Price</span>
                        <span class="th-qty">Quantity</span>
                        <span class="th-total">Subtotal</span>
                        <span class="th-remove"></span>
                    </div>

                    
                    <div class="cart-items-list" id="cartItemsList">
                        <?php $__currentLoopData = $cart->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="cart-item" data-item-id="<?php echo e($item->id); ?>">
                                <div class="cart-item-main">
                                    <div class="cart-item-image">
                                        <a href="<?php echo e($item->product ? route('product.show', $item->product->slug) : '#'); ?>">
                                            <img src="<?php echo e($item->getProductImage() ?? 'https://placehold.co/120x120/f0f0f0/999?text=N'); ?>"
                                                 alt="<?php echo e($item->getProductTitle()); ?>"
                                                 loading="lazy">
                                        </a>
                                    </div>
                                    <div class="cart-item-details">
                                        <a href="<?php echo e($item->product ? route('product.show', $item->product->slug) : '#'); ?>" class="cart-item-name">
                                            <?php echo e($item->product?->name ?? 'Deleted Product'); ?>

                                        </a>
                                        <?php if($item->variant): ?>
                                            <div class="cart-item-variant"><?php echo e($item->variant->getAttributesList()); ?></div>
                                        <?php endif; ?>
                                        <div class="cart-item-mobile-price d-md-none">
                                            <span class="cart-item-current-price">$<?php echo e(number_format($item->unit_price, 2)); ?></span>
                                        </div>
                                        <button class="cart-item-remove-mobile d-md-none" data-item-id="<?php echo e($item->id); ?>" aria-label="Remove item">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                    <div class="cart-item-price-cell d-none d-md-block">
                                        <span class="cart-item-price">$<?php echo e(number_format($item->unit_price, 2)); ?></span>
                                        <?php if($item->discount > 0): ?>
                                            <span class="cart-item-old-price">$<?php echo e(number_format($item->unit_price + $item->discount, 2)); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="cart-item-qty-cell">
                                        <div class="cart-qty-selector">
                                            <button class="cart-qty-btn cart-qty-dec" data-item-id="<?php echo e($item->id); ?>" aria-label="Decrease quantity">-</button>
                                            <input type="text" class="cart-qty-input" value="<?php echo e($item->quantity); ?>" readonly>
                                            <button class="cart-qty-btn cart-qty-inc" data-item-id="<?php echo e($item->id); ?>" aria-label="Increase quantity">+</button>
                                        </div>
                                    </div>
                                    <div class="cart-item-total-cell d-none d-md-block">
                                        <span class="cart-item-subtotal" id="subtotal-<?php echo e($item->id); ?>">$<?php echo e(number_format($item->subtotal, 2)); ?></span>
                                    </div>
                                    <div class="cart-item-remove-cell d-none d-md-flex">
                                        <button class="cart-item-remove" data-item-id="<?php echo e($item->id); ?>" aria-label="Remove item">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    
                    <div class="cart-actions">
                        <div class="cart-action-left">
                            <a href="<?php echo e(route('shop')); ?>" class="btn-continue-shopping">
                                <i class="fas fa-arrow-left"></i> Continue Shopping
                            </a>
                            <button class="btn-clear-cart" id="clearCartBtn">
                                <i class="fas fa-trash-alt"></i> Clear Cart
                            </button>
                        </div>
                        <div class="cart-action-right">
                            <button class="btn-update-cart" id="updateCartBtn">
                                <i class="fas fa-sync"></i> Update Cart
                            </button>
                        </div>
                    </div>

                    
                    <div class="cart-coupon-section">
                        <div class="coupon-row">
                            <div class="coupon-input-wrap">
                                <i class="fas fa-tag"></i>
                                <input type="text" id="cartCouponInput" placeholder="Enter coupon code" aria-label="Coupon code">
                                <button type="button" id="cartApplyCoupon" class="btn-apply-coupon">Apply</button>
                            </div>
                            <?php if($cart->coupon_id): ?>
                                <div class="applied-coupon">
                                    <span class="applied-coupon-code"><?php echo e($cart->coupon->code ?? 'Coupon'); ?></span>
                                    <button class="remove-coupon-btn" id="removeCouponBtn"><i class="fas fa-times"></i></button>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    
                    <div class="cart-shipping-estimate">
                        <div class="shipping-estimate-header" data-bs-toggle="collapse" data-bs-target="#shippingEstimate">
                            <i class="fas fa-truck"></i>
                            <span>Estimate Shipping</span>
                            <i class="fas fa-chevron-down ms-auto"></i>
                        </div>
                        <div class="collapse" id="shippingEstimate">
                            <div class="shipping-estimate-body">
                                <div class="row g-2">
                                    <div class="col-md-4">
                                        <input type="text" class="form-control form-control-sm" placeholder="Country">
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control form-control-sm" placeholder="State">
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control form-control-sm" placeholder="ZIP Code">
                                    </div>
                                </div>
                                <button class="btn btn-sm btn-primary mt-2">Calculate Shipping</button>
                            </div>
                        </div>
                    </div>

                    
                    <div class="cart-gift-option">
                        <label class="gift-toggle">
                            <i class="fas fa-gift"></i>
                            <span>This order contains a gift</span>
                            <input type="checkbox" class="form-check-input ms-auto">
                        </label>
                    </div>
                <?php else: ?>
                    <div class="empty-cart-state">
                        <div class="empty-cart-icon"><i class="fas fa-shopping-bag"></i></div>
                        <h4>Your cart is empty</h4>
                        <p>Looks like you haven't added anything to your cart yet.</p>
                        <a href="<?php echo e(route('shop')); ?>" class="btn btn-primary rounded-pill px-4 py-2">Start Shopping</a>
                    </div>
                <?php endif; ?>
            </div>

            
            <div class="col-lg-4">
                <div class="cart-summary-sticky">
                    <div class="order-summary-card">
                        <h5 class="summary-title">Order Summary</h5>

                        <div class="summary-rows">
                            <div class="summary-row">
                                <span class="summary-label">Subtotal</span>
                                <span class="summary-value" id="summarySubtotal">$<?php echo e(number_format($cart?->subtotal ?? 0, 2)); ?></span>
                            </div>
                            <?php if($cart && $cart->coupon_discount > 0): ?>
                                <div class="summary-row discount">
                                    <span class="summary-label">Discount</span>
                                    <span class="summary-value text-success" id="summaryDiscount">-$<?php echo e(number_format($cart->coupon_discount, 2)); ?></span>
                                </div>
                            <?php endif; ?>
                            <div class="summary-row">
                                <span class="summary-label">Shipping</span>
                                <span class="summary-value" id="summaryShipping">
                                    <?php if($cart && $cart->shipping_cost > 0): ?>
                                        $<?php echo e(number_format($cart->shipping_cost, 2)); ?>

                                    <?php else: ?>
                                        <span class="free-badge-sm">FREE</span>
                                    <?php endif; ?>
                                </span>
                            </div>
                            <div class="summary-row">
                                <span class="summary-label">Tax</span>
                                <span class="summary-value" id="summaryTax">$<?php echo e(number_format($cart?->tax_amount ?? 0, 2)); ?></span>
                            </div>
                        </div>

                        <div class="summary-divider"></div>

                        <div class="summary-total">
                            <span class="total-label">Total</span>
                            <span class="total-value" id="summaryTotal">$<?php echo e(number_format($cart?->total ?? 0, 2)); ?></span>
                        </div>

                        <?php if($cart && $cart->items->isNotEmpty()): ?>
                            <a href="<?php echo e(route('checkout')); ?>" class="btn-checkout-proceed">
                                <i class="fas fa-lock"></i> Proceed to Checkout
                            </a>
                        <?php endif; ?>

                        <div class="summary-trust">
                            <div class="trust-badge-row">
                                <i class="fas fa-shield-alt"></i>
                                <span>Secure checkout with SSL encryption</span>
                            </div>
                            <div class="trust-badge-row">
                                <i class="fas fa-undo"></i>
                                <span>30-day easy returns</span>
                            </div>
                            <div class="trust-badge-row">
                                <i class="fas fa-headset"></i>
                                <span>24/7 customer support</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('styles'); ?>
<style>
.cart-page { min-height: 60vh; }
.section-bar { width: 4px; height: 28px; background: linear-gradient(180deg, var(--primary), var(--secondary)); border-radius: 2px; flex-shrink: 0; }
.cart-items-count-badge { font-size: 12px; color: var(--gray-500); background: #F3F4F6; padding: 4px 12px; border-radius: 20px; font-weight: 500; }
.cart-table-header { display: flex; align-items: center; padding: 12px 16px; background: #F9FAFB; border-radius: 12px; font-size: 12px; font-weight: 600; color: var(--gray-500); text-transform: uppercase; letter-spacing: .3px; margin-bottom: 12px; }
.th-product { flex: 1; }
.th-price { width: 100px; text-align: center; }
.th-qty { width: 120px; text-align: center; }
.th-total { width: 110px; text-align: right; }
.th-remove { width: 44px; }
.cart-item { background: #fff; border: 1px solid #F3F4F6; border-radius: 14px; margin-bottom: 10px; transition: all .2s; }
.cart-item:hover { border-color: #E5E7EB; box-shadow: 0 2px 8px rgba(0,0,0,.04); }
.cart-item-main { display: flex; align-items: center; gap: 12px; padding: 16px; }
.cart-item-image { width: 90px; height: 90px; flex-shrink: 0; border-radius: 10px; overflow: hidden; background: #FAFAFA; }
.cart-item-image img { width: 100%; height: 100%; object-fit: cover; }
.cart-item-details { flex: 1; min-width: 0; }
.cart-item-name { font-size: 15px; font-weight: 600; color: var(--gray-800); text-decoration: none; display: block; margin-bottom: 4px; }
.cart-item-name:hover { color: var(--primary); }
.cart-item-variant { font-size: 12px; color: var(--gray-500); margin-bottom: 4px; }
.cart-item-mobile-price { margin-top: 6px; }
.cart-item-current-price { font-size: 16px; font-weight: 700; color: var(--gray-800); }
.cart-item-remove-mobile { border: none; background: none; color: #D1D5DB; font-size: 16px; cursor: pointer; padding: 4px; }
.cart-item-price-cell { width: 100px; text-align: center; }
.cart-item-price { font-size: 14px; font-weight: 600; color: var(--gray-800); display: block; }
.cart-item-old-price { font-size: 12px; color: #D1D5DB; text-decoration: line-through; }
.cart-item-qty-cell { width: 120px; display: flex; justify-content: center; }
.cart-qty-selector { display: inline-flex; align-items: center; border: 1px solid #E5E7EB; border-radius: 10px; overflow: hidden; }
.cart-qty-btn { width: 34px; height: 34px; border: none; background: transparent; color: var(--gray-600); font-size: 14px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: background .15s; }
.cart-qty-btn:hover { background: #F3F4F6; }
.cart-qty-input { width: 38px; height: 34px; border: none; text-align: center; font-size: 14px; font-weight: 600; background: transparent; outline: none; }
.cart-item-total-cell { width: 110px; text-align: right; }
.cart-item-subtotal { font-size: 16px; font-weight: 700; color: var(--gray-800); }
.cart-item-remove-cell { width: 44px; justify-content: center; }
.cart-item-remove { width: 32px; height: 32px; border-radius: 50%; border: none; background: transparent; color: #D1D5DB; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all .2s; font-size: 14px; }
.cart-item-remove:hover { background: rgba(239,68,68,.1); color: #EF4444; }
.cart-actions { display: flex; justify-content: space-between; align-items: center; margin-top: 16px; flex-wrap: wrap; gap: 10px; }
.cart-action-left { display: flex; gap: 10px; }
.btn-continue-shopping, .btn-clear-cart, .btn-update-cart { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: 10px; font-size: 13px; font-weight: 500; cursor: pointer; transition: all .2s; text-decoration: none; }
.btn-continue-shopping { border: 1px solid #E5E7EB; background: #fff; color: var(--gray-600); }
.btn-continue-shopping:hover { border-color: var(--primary); color: var(--primary); }
.btn-clear-cart { border: none; background: rgba(239,68,68,.08); color: #EF4444; }
.btn-clear-cart:hover { background: rgba(239,68,68,.15); }
.btn-update-cart { border: 1px solid #E5E7EB; background: #fff; color: var(--gray-600); }
.btn-update-cart:hover { border-color: var(--primary); color: var(--primary); }
.cart-coupon-section { margin-top: 16px; padding: 16px; background: #FAFAFA; border-radius: 14px; }
.coupon-row { display: flex; flex-direction: column; gap: 10px; }
.coupon-input-wrap { display: flex; gap: 8px; align-items: center; background: #fff; border: 1px solid #E5E7EB; border-radius: 10px; padding: 0 12px; }
.coupon-input-wrap i { color: #D1D5DB; }
.coupon-input-wrap input { flex: 1; border: none; padding: 10px 8px; font-size: 13px; outline: none; }
.coupon-input-wrap input:focus + .btn-apply-coupon { background: var(--primary); color: #fff; }
.btn-apply-coupon { padding: 6px 16px; border-radius: 8px; border: none; background: #F3F4F6; color: var(--gray-600); font-weight: 600; font-size: 12px; cursor: pointer; transition: all .2s; }
.btn-apply-coupon:hover { background: var(--primary); color: #fff; }
.applied-coupon { display: inline-flex; align-items: center; gap: 8px; background: rgba(16,185,129,.1); padding: 6px 12px; border-radius: 8px; width: fit-content; }
.applied-coupon-code { font-size: 13px; font-weight: 600; color: #059669; }
.remove-coupon-btn { border: none; background: none; color: #059669; cursor: pointer; font-size: 12px; padding: 2px; }
.cart-shipping-estimate { margin-top: 10px; border: 1px solid #F3F4F6; border-radius: 14px; overflow: hidden; }
.shipping-estimate-header { display: flex; align-items: center; gap: 10px; padding: 14px 16px; cursor: pointer; font-size: 14px; font-weight: 500; color: var(--gray-700); }
.shipping-estimate-body { padding: 16px; border-top: 1px solid #F3F4F6; background: #FAFAFA; }
.cart-gift-option { margin-top: 10px; background: #fff; border: 1px solid #F3F4F6; border-radius: 14px; padding: 14px 16px; }
.gift-toggle { display: flex; align-items: center; gap: 10px; cursor: pointer; font-size: 14px; color: var(--gray-700); margin: 0; }
.gift-toggle i { color: var(--primary); }
.empty-cart-state { text-align: center; padding: 60px 20px; }
.empty-cart-icon { font-size: 64px; color: #D1D5DB; margin-bottom: 16px; }
.empty-cart-state h4 { font-weight: 700; color: var(--gray-800); margin-bottom: 8px; }
.empty-cart-state p { color: var(--gray-500); margin-bottom: 20px; }
.cart-summary-sticky { position: sticky; top: calc(var(--header-height) + 24px); }
.order-summary-card { background: #fff; border: 1px solid #E5E7EB; border-radius: 16px; padding: 24px; }
.summary-title { font-size: 18px; font-weight: 700; margin-bottom: 20px; }
.summary-rows { display: flex; flex-direction: column; gap: 12px; }
.summary-row { display: flex; justify-content: space-between; align-items: center; }
.summary-label { font-size: 14px; color: var(--gray-500); }
.summary-value { font-size: 14px; font-weight: 600; color: var(--gray-800); }
.summary-row.discount .summary-value { color: #059669; }
.free-badge-sm { font-size: 12px; font-weight: 700; color: #059669; background: rgba(16,185,129,.1); padding: 2px 8px; border-radius: 4px; }
.summary-divider { height: 1px; background: #F3F4F6; margin: 16px 0; }
.summary-total { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
.total-label { font-size: 16px; font-weight: 700; color: var(--gray-800); }
.total-value { font-size: 24px; font-weight: 900; color: var(--gray-900); }
.btn-checkout-proceed { display: flex; align-items: center; justify-content: center; gap: 8px; width: 100%; padding: 14px; border-radius: 12px; border: none; background: var(--gradient-primary); color: #fff; font-weight: 700; font-size: 15px; cursor: pointer; text-decoration: none; transition: all .25s; box-shadow: 0 4px 14px rgba(245,114,36,.3); }
.btn-checkout-proceed:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(245,114,36,.35); color: #fff; }
.summary-trust { margin-top: 16px; display: flex; flex-direction: column; gap: 8px; }
.trust-badge-row { display: flex; align-items: center; gap: 8px; font-size: 12px; color: var(--gray-500); }
.trust-badge-row i { font-size: 13px; color: var(--success); }
@media (max-width: 767.98px) { .cart-item-main { flex-wrap: wrap; } .cart-item-qty-cell { width: auto; } .cart-item-price-cell, .cart-item-total-cell, .cart-item-remove-cell { display: none; } .order-summary-card { padding: 16px; } .total-value { font-size: 20px; } }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const csrf = document.querySelector('meta[name="csrf-token"]')?.content;

    function updateCartSummary() {
        fetch('<?php echo e(route("cart.summary")); ?>')
            .then(r => r.json())
            .then(d => {
                if (d.error) return;
                document.getElementById('summarySubtotal').textContent = '$' + d.subtotal.toFixed(2);
                document.getElementById('summaryTotal').textContent = '$' + d.total.toFixed(2);
                if (document.getElementById('summaryShipping')) document.getElementById('summaryShipping').textContent = d.shipping_cost > 0 ? '$' + d.shipping_cost.toFixed(2) : '<span class="free-badge-sm">FREE</span>';
                if (document.getElementById('summaryTax')) document.getElementById('summaryTax').textContent = '$' + d.tax_amount.toFixed(2);
                if (document.getElementById('summaryDiscount')) document.getElementById('summaryDiscount').textContent = '-$' + d.coupon_discount.toFixed(2);
                updateCartCount();
            });
    }

    // Quantity buttons
    document.querySelectorAll('.cart-qty-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const itemId = this.dataset.itemId;
            const input = this.closest('.cart-qty-selector').querySelector('.cart-qty-input');
            let qty = parseInt(input.value);
            if (this.classList.contains('cart-qty-inc')) qty++;
            else if (qty > 1) qty--;
            else return;

            fetch('<?php echo e(route("cart.update")); ?>', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf },
                body: JSON.stringify({ item_id: itemId, quantity: qty })
            })
            .then(r => r.json())
            .then(d => {
                if (d.success) {
                    input.value = qty;
                    const subtotalEl = document.getElementById('subtotal-' + itemId);
                    if (subtotalEl && d.item_subtotal !== null) {
                        subtotalEl.textContent = '$' + d.item_subtotal.toFixed(2);
                    }
                    updateCartSummary();
                    const countEl = document.querySelector('.cart-items-count-badge');
                    if (countEl && d.cart) {
                        countEl.textContent = d.cart.items_count + ' items';
                    }
                    if (d.cart && d.cart.items_count === 0) location.reload();
                }
            });
        });
    });

    // Remove item
    document.querySelectorAll('.cart-item-remove, .cart-item-remove-mobile').forEach(btn => {
        btn.addEventListener('click', function() {
            const itemId = this.dataset.itemId;
            fetch('<?php echo e(route("cart.remove")); ?>', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf },
                body: JSON.stringify({ item_id: itemId })
            })
            .then(r => r.json())
            .then(d => { if (d.success) location.reload(); });
        });
    });

    // Clear cart
    document.getElementById('clearCartBtn')?.addEventListener('click', function() {
        if (!confirm('Clear your entire cart?')) return;
        fetch('<?php echo e(route("cart.clear")); ?>', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf }
        })
        .then(r => r.json())
        .then(d => { if (d.success) location.reload(); });
    });

    // Apply coupon
    document.getElementById('cartApplyCoupon')?.addEventListener('click', function() {
        const code = document.getElementById('cartCouponInput').value;
        if (!code) return;
        fetch('<?php echo e(route("cart.coupon.apply")); ?>', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf },
            body: JSON.stringify({ code: code })
        })
        .then(r => r.json())
        .then(d => { showToast(d.message, d.success ? 'success' : 'error'); if (d.success) location.reload(); });
    });

    // Remove coupon
    document.getElementById('removeCouponBtn')?.addEventListener('click', function() {
        fetch('<?php echo e(route("cart.coupon.remove")); ?>', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf }
        })
        .then(r => r.json())
        .then(d => { if (d.success) location.reload(); });
    });
});
</script>
<?php $__env->stopPush(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaleac9542bb5e3f887e862d1d96c472e9b)): ?>
<?php $attributes = $__attributesOriginaleac9542bb5e3f887e862d1d96c472e9b; ?>
<?php unset($__attributesOriginaleac9542bb5e3f887e862d1d96c472e9b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaleac9542bb5e3f887e862d1d96c472e9b)): ?>
<?php $component = $__componentOriginaleac9542bb5e3f887e862d1d96c472e9b; ?>
<?php unset($__componentOriginaleac9542bb5e3f887e862d1d96c472e9b); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\frontend\cart.blade.php ENDPATH**/ ?>