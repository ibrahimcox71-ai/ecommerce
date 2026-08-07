(function() {
    'use strict';

    document.addEventListener('DOMContentLoaded', function() {
        const mainImage = document.getElementById('mainProductImage');
        const thumbnails = document.querySelectorAll('.thumbnail-item:not(.video-thumb)');
        const thumbWrapper = document.getElementById('thumbnailsWrapper');
        const galleryPrev = document.getElementById('galleryPrev');
        const galleryNext = document.getElementById('galleryNext');
        const fullscreenBtn = document.getElementById('fullscreenBtn');
        const zoomLens = document.getElementById('imageZoomLens');
        const zoomResult = document.getElementById('imageZoomResult');
        const qtyInput = document.getElementById('qtyInput');
        const qtyDec = document.getElementById('qtyDecrease');
        const qtyInc = document.getElementById('qtyIncrease');
        const stickyQty = document.getElementById('stickyQty');
        const stickyQtyDec = document.getElementById('stickyQtyDec');
        const stickyQtyInc = document.getElementById('stickyQtyInc');
        const csrf = document.querySelector('meta[name="csrf-token"]')?.content;
        let currentImageIndex = 0;
        const images = Array.from(document.querySelectorAll('.thumbnail-item')).filter(t => !t.classList.contains('video-thumb')).map(t => ({ src: t.dataset.image, zoom: t.dataset.zoom }));

        // Thumbnail Click
        document.querySelectorAll('.thumbnail-item').forEach((thumb, idx) => {
            thumb.addEventListener('click', function() {
                if (this.classList.contains('video-thumb')) return;
                document.querySelectorAll('.thumbnail-item').forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                currentImageIndex = idx;
                mainImage.src = this.dataset.image;
                mainImage.dataset.zoom = this.dataset.zoom;
                if (zoomResult.style.display === 'block') zoomResult.style.backgroundImage = `url(${this.dataset.zoom})`;
            });
        });

        // Gallery Navigation
        function navigateGallery(dir) {
            if (images.length === 0) return;
            currentImageIndex = (currentImageIndex + dir + images.length) % images.length;
            const target = document.querySelectorAll('.thumbnail-item')[currentImageIndex];
            if (target) { target.click(); target.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' }); }
        }
        galleryPrev?.addEventListener('click', () => navigateGallery(-1));
        galleryNext?.addEventListener('click', () => navigateGallery(1));

        // Keyboard
        document.addEventListener('keydown', function(e) {
            if (e.key === 'ArrowLeft') navigateGallery(-1);
            if (e.key === 'ArrowRight') navigateGallery(1);
            if (e.key === 'Escape') { if (document.fullscreenElement) document.exitFullscreen(); }
        });

        // Zoom
        const mainContainer = document.getElementById('mainImageContainer');
        if (mainContainer && window.innerWidth >= 1200) {
            mainContainer.addEventListener('mousemove', function(e) {
                const rect = this.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                const w = rect.width, h = rect.height;
                const lensW = 160, lensH = 160;
                let lensX = Math.max(0, Math.min(x - lensW / 2, w - lensW));
                let lensY = Math.max(0, Math.min(y - lensH / 2, h - lensH));
                zoomLens.style.cssText = `display:block;left:${lensX}px;top:${lensY}px;`;
                zoomResult.style.cssText = `display:block;background-image:url(${mainImage.dataset.zoom || mainImage.src});background-size:${w*3}px ${h*3}px;background-position:-${lensX*3}px -${lensY*3}px;`;
            });
            mainContainer.addEventListener('mouseleave', function() {
                zoomLens.style.display = 'none';
                zoomResult.style.display = 'none';
            });
        }

        // Fullscreen
        fullscreenBtn?.addEventListener('click', function() {
            const img = document.createElement('img');
            img.src = mainImage.dataset.zoom || mainImage.src;
            img.style.cssText = 'max-width:90%;max-height:90%;object-fit:contain;border-radius:8px;';
            const overlay = document.createElement('div');
            overlay.style.cssText = 'position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,.95);display:flex;align-items:center;justify-content:center;cursor:zoom-out;';
            overlay.appendChild(img);
            overlay.addEventListener('click', () => overlay.remove());
            document.body.appendChild(overlay);
        });

        // Swipe
        let touchStartX = 0;
        mainContainer?.addEventListener('touchstart', function(e) { touchStartX = e.changedTouches[0].screenX; });
        mainContainer?.addEventListener('touchend', function(e) {
            const diff = touchStartX - e.changedTouches[0].screenX;
            if (Math.abs(diff) > 50) navigateGallery(diff > 0 ? 1 : -1);
        });

        // Quantity
        function updateQty(val) {
            const min = parseInt(qtyInput.min) || 0;
            const max = parseInt(qtyInput.max) || 99;
            val = Math.max(min, Math.min(max, val));
            qtyInput.value = val;
            if (stickyQty) stickyQty.value = val;
        }
        qtyDec?.addEventListener('click', () => updateQty(parseInt(qtyInput.value) - 1));
        qtyInc?.addEventListener('click', () => updateQty(parseInt(qtyInput.value) + 1));
        qtyInput?.addEventListener('change', function() { updateQty(parseInt(this.value) || 1); });
        stickyQtyDec?.addEventListener('click', () => updateQty(parseInt(qtyInput.value) - 1));
        stickyQtyInc?.addEventListener('click', () => updateQty(parseInt(qtyInput.value) + 1));

        // Sticky Buy Bar
        const stickyBar = document.getElementById('stickyBuyBar');
        const tabsSection = document.getElementById('productTabsSection');
        if (stickyBar && tabsSection) {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    stickyBar.classList.toggle('visible', entry.boundingClientRect.top <= 0);
                });
            }, { threshold: 0 });
            observer.observe(tabsSection);
        }

        // Tabs
        const tabBtns = document.querySelectorAll('.tab-nav-btn');
        tabBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                tabBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
                const panel = document.getElementById('tab-' + this.dataset.tab);
                if (panel) panel.classList.add('active');
            });
        });

        // Add to Cart
        const cartAddUrl = window.routeUrls?.cartAdd ?? '/cart/add';
        const checkoutUrl = window.routeUrls?.checkout ?? '/checkout';
        document.querySelectorAll('[data-product-id]').forEach(btn => {
            btn.addEventListener('click', function(e) {
                if (this.disabled) return;
                const isBuyNow = this.classList.contains('btn-buy-now') || this.classList.contains('sticky-buy') || this.classList.contains('ms-buy');
                const pid = this.dataset.productId;
                const qty = qtyInput ? qtyInput.value : 1;
                fetch(cartAddUrl, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf },
                    body: JSON.stringify({ product_id: pid, quantity: qty })
                })
                .then(r => r.json())
                .then(d => {
                    if (d.success) {
                        showToast('Added to cart!', 'success');
                        updateCartCount();
                        if (isBuyNow) { setTimeout(() => { window.location.href = checkoutUrl; }, 600); }
                    } else { showToast(d.message || 'Error', 'error'); }
                });
            });
        });

        // Variant Selection
        document.querySelectorAll('.variant-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const group = this.closest('.variant-group');
                group.querySelectorAll('.variant-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                const label = group.querySelector('.selected-value');
                if (label) label.textContent = this.dataset.value;
            });
        });

        // Share Copy
        document.getElementById('copyShareLink')?.addEventListener('click', function() {
            const input = document.getElementById('shareUrlInput');
            input.select();
            navigator.clipboard?.writeText(input.value);
            this.innerHTML = '<i class="fas fa-check"></i>';
            setTimeout(() => { this.innerHTML = '<i class="fas fa-copy"></i>'; }, 2000);
        });
        document.querySelector('.share-link.copy')?.addEventListener('click', function() {
            navigator.clipboard?.writeText(this.dataset.url);
            this.innerHTML = '<i class="fas fa-check"></i>';
            setTimeout(() => { this.innerHTML = '<i class="fas fa-link"></i>'; }, 2000);
        });

        // Coupon
        document.getElementById('applyCouponBtn')?.addEventListener('click', function() {
            const code = document.getElementById('couponInput').value;
            if (!code) return;
            fetch(window.routeUrls?.cartCouponApply ?? '/cart/coupon', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf },
                body: JSON.stringify({ code: code })
            })
            .then(r => r.json())
            .then(d => showToast(d.message, d.success ? 'success' : 'error'));
        });

        // Sticky Qty Sync
        if (stickyQty) {
            stickyQty.addEventListener('change', function() { qtyInput.value = this.value; });
        }
    });
})();
