class CartManager {
    constructor() {
        this.csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
        this.initAddToCartButtons();
        this.updateCartBadge();
    }

    initAddToCartButtons() {
        document.addEventListener('click', (e) => {
            const btn = e.target.closest('[data-add-to-cart]');
            if (!btn) return;

            e.preventDefault();
            const form = btn.closest('form') || btn.dataset;
            const productId = btn.dataset.productId || form.querySelector('[name="product_id"]')?.value;
            const variantId = btn.dataset.variantId || form.querySelector('[name="product_variant_id"]')?.value;
            const qtyInput = form.querySelector('[name="quantity"]');
            const quantity = qtyInput ? parseInt(qtyInput.value) || 1 : 1;

            this.add(productId, quantity, variantId, btn);
        });
    }

    add(productId, quantity, variantId, btn) {
        const originalHtml = btn?.innerHTML;

        if (btn) {
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
        }

        fetch('/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': this.csrfToken,
            },
            body: JSON.stringify({
                product_id: productId,
                quantity: quantity,
                product_variant_id: variantId || null,
            }),
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                this.showToast('success', data.message);
                this.updateCartBadge(data.cart);
            } else {
                this.showToast('danger', data.message || 'Failed to add item.');
            }
        })
        .catch(() => {
            this.showToast('danger', 'An error occurred.');
        })
        .finally(() => {
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = originalHtml;
            }
        });
    }

    updateCartBadge(cart) {
        if (cart) {
            const badges = document.querySelectorAll('.cart-count-badge');
            badges.forEach(b => { b.textContent = cart.items_count; });
            const miniCount = document.getElementById('miniCartCount');
            if (miniCount) miniCount.textContent = cart.items_count;
            const miniSub = document.getElementById('miniCartSubtotal');
            if (miniSub && cart.subtotal !== undefined) {
                miniSub.textContent = '$' + cart.subtotal.toFixed(2);
            }
            return;
        }

        fetch('/cart/summary')
            .then(r => r.json())
            .then(data => {
                const badges = document.querySelectorAll('.cart-count-badge');
                badges.forEach(b => { b.textContent = data.items_count; });
            });
    }

    showToast(type, message) {
        const container = document.getElementById('toastContainer');
        if (!container) {
            const div = document.createElement('div');
            div.id = 'toastContainer';
            div.style.cssText = 'position:fixed;top:20px;right:20px;z-index:9999';
            document.body.appendChild(div);
        }

        const toast = document.createElement('div');
        toast.className = `alert alert-${type} alert-dismissible fade show`;
        toast.role = 'alert';
        toast.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        document.getElementById('toastContainer').appendChild(toast);

        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    window.cartManager = new CartManager();
});
