class CheckoutManager {
    constructor() {
        this.form = document.getElementById('checkoutForm');
        if (!this.form) return;
        this.csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
        this.init();
    }

    init() {
        this.initSavedAddresses();
        this.initBillingToggle();
        this.initShippingMethods();
        this.initFormSubmit();
    }

    initSavedAddresses() {
        document.querySelectorAll('.saved-address').forEach(radio => {
            radio.addEventListener('change', (e) => {
                if (!e.target.checked) return;
                const d = e.target.dataset;
                const prefix = 'shipping_address';
                this.setFieldValue(`${prefix}[name]`, d.name);
                this.setFieldValue(`${prefix}[email]`, d.email);
                this.setFieldValue(`${prefix}[phone]`, d.phone);
                this.setFieldValue(`${prefix}[address_line1]`, d.line1);
                this.setFieldValue(`${prefix}[address_line2]`, d.line2);
                this.setFieldValue(`${prefix}[city]`, d.city);
                this.setFieldValue(`${prefix}[state]`, d.state);
                this.setFieldValue(`${prefix}[zip]`, d.zip);
                this.setFieldValue(`${prefix}[country]`, d.country || 'US');
            });
        });
    }

    initBillingToggle() {
        const checkbox = document.getElementById('billingSame');
        const fields = document.getElementById('billingFields');
        if (!checkbox || !fields) return;

        checkbox.addEventListener('change', () => {
            const checked = checkbox.checked;
            fields.style.display = checked ? 'none' : 'block';
            fields.querySelectorAll('input, select').forEach(el => {
                el.required = !checked && el.closest('.row')?.querySelector('.form-label .text-danger') ? true : false;
            });
        });
    }

    initShippingMethods() {
        document.querySelectorAll('.shipping-method').forEach(radio => {
            radio.addEventListener('change', (e) => {
                if (!e.target.checked) return;
                const cost = parseFloat(e.target.dataset.cost) || 0;
                this.updateTotals(cost);
            });
        });
    }

    updateTotals(shippingCost) {
        const subtotal = parseFloat(document.getElementById('summarySubtotal')?.dataset?.baseSubtotal || 0);
        const discount = parseFloat(document.getElementById('summaryDiscount')?.dataset?.discount || 0);
        const taxRate = parseFloat(document.getElementById('summaryTax')?.dataset?.taxRate || 0);
        const afterCoupon = subtotal - discount;
        const tax = afterCoupon * (taxRate / 100);
        const total = afterCoupon + shippingCost + tax;

        const shipEl = document.getElementById('summaryShipping');
        const totalEl = document.getElementById('summaryTotal');
        if (shipEl) shipEl.textContent = '$' + shippingCost.toFixed(2);
        if (totalEl) totalEl.textContent = '$' + total.toFixed(2);
    }

    initFormSubmit() {
        const btn = document.getElementById('placeOrderBtn');
        if (!btn) return;

        this.form.addEventListener('submit', (e) => {
            e.preventDefault();
            if (btn.disabled) return;

            if (!this.form.checkValidity()) {
                this.form.reportValidity();
                return;
            }

            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';

            const formData = new FormData(this.form);
            formData.set('billing_same', document.getElementById('billingSame')?.checked ? '1' : '0');

            fetch(this.form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': this.csrfToken,
                    'Accept': 'application/json',
                },
                body: formData,
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    window.location.href = data.redirect;
                } else {
                    this.showError(data.message || 'Failed to place order.');
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fas fa-lock me-2"></i>Place Order';
                }
            })
            .catch(() => {
                this.showError('A network error occurred. Please try again.');
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-lock me-2"></i>Place Order';
            });
        });
    }

    setFieldValue(name, value) {
        const el = this.form.querySelector(`[name="${name}"]`);
        if (el) el.value = value || '';
    }

    showError(message) {
        const container = document.getElementById('checkoutAlert') || (() => {
            const div = document.createElement('div');
            div.id = 'checkoutAlert';
            div.className = 'alert alert-danger alert-dismissible fade show';
            div.role = 'alert';
            this.form.prepend(div);
            return div;
        })();
        container.innerHTML = `
            <i class="fas fa-exclamation-circle me-2"></i>${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        container.style.display = 'block';
    }
}

document.addEventListener('DOMContentLoaded', () => {
    window.checkoutManager = new CheckoutManager();
});
