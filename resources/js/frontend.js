/**
 * Toast Notification System
 */
function showToast(message, type) {
    const container = document.getElementById('toastContainer');
    if (!container) return;
    const icons = { success: 'fa-check-circle', error: 'fa-exclamation-circle', info: 'fa-info-circle', warning: 'fa-exclamation-triangle' };
    const toast = document.createElement('div');
    toast.className = 'toast-v2 toast-' + (type || 'success');
    toast.innerHTML = '<i class="fas ' + (icons[type] || icons.info) + '"></i> ' + message +
        '<button class="toast-close" onclick="this.parentElement.remove()">&times;</button>';
    container.appendChild(toast);
    requestAnimationFrame(() => { toast.style.opacity = '1'; });
    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateX(100%)';
        setTimeout(() => toast.remove(), 300);
    }, 4000);
}

function updateWishlistCount() {
    const badge = document.querySelector('.wishlist-count-badge');
    if (!badge) return;
    badge.textContent = '...';
    fetch(window.routeUrls.wishlistCount)
        .then(r => r.json())
        .then(d => {
            badge.textContent = d.count;
            badge.style.display = d.count > 0 ? 'flex' : 'none';
        });
}

function updateNotificationCount() {
    const badge = document.querySelector('.notification-count-badge');
    if (!badge) return;
    fetch(window.routeUrls.notificationUnread)
        .then(r => r.json())
        .then(d => {
            badge.textContent = d.count;
            badge.style.display = d.count > 0 ? 'flex' : 'none';
        });
}

function updateCartCount() {
    const badges = document.querySelectorAll('.cart-count-badge');
    if (!badges.length) return;
    fetch(window.routeUrls.cartSummary)
        .then(r => r.json())
        .then(d => {
            badges.forEach(b => {
                const count = d.items_count || 0;
                b.textContent = count;
                b.style.display = count > 0 ? 'flex' : 'none';
                b.classList.add('bounce-in');
                setTimeout(() => b.classList.remove('bounce-in'), 400);
            });
        });
}

function initFlashTimers() {
    function updateHeaderFlashTimer() {
        const timer = document.getElementById('headerFlashTimer');
        if (!timer) return;
        const end = new Date();
        end.setDate(end.getDate() + 2);
        end.setHours(23, 59, 59);
        function tick() {
            const diff = end - new Date();
            if (diff <= 0) return;
            const h = Math.floor((diff / (1000 * 60 * 60)) % 24);
            const m = Math.floor((diff / (1000 * 60)) % 60);
            const s = Math.floor((diff / 1000) % 60);
            timer.querySelector('.fh-hours').textContent = String(h).padStart(2, '0');
            timer.querySelector('.fh-mins').textContent = String(m).padStart(2, '0');
            timer.querySelector('.fh-secs').textContent = String(s).padStart(2, '0');
        }
        tick();
        setInterval(tick, 1000);
    }
    updateHeaderFlashTimer();
}

/**
 * Ripple Effect for buttons
 */
function initRippleEffect() {
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.btn-ripple');
        if (!btn) return;
        const rect = btn.getBoundingClientRect();
        const ripple = document.createElement('span');
        ripple.className = 'ripple-effect';
        const size = Math.max(rect.width, rect.height);
        ripple.style.width = ripple.style.height = size + 'px';
        ripple.style.left = (e.clientX - rect.left - size / 2) + 'px';
        ripple.style.top = (e.clientY - rect.top - size / 2) + 'px';
        btn.appendChild(ripple);
        ripple.addEventListener('animationend', () => ripple.remove());
    });
}

/**
 * Back to Top
 */
function initBackToTop() {
    const btn = document.getElementById('backToTop');
    if (!btn) return;
    window.addEventListener('scroll', function() {
        btn.classList.toggle('visible', window.scrollY > 400);
    }, { passive: true });
    btn.addEventListener('click', function() {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
}

/**
 * Skip to content
 */
function initSkipLink() {
    const skip = document.querySelector('[data-skip-link]');
    if (!skip) return;
    skip.addEventListener('click', function(e) {
        e.preventDefault();
        const main = document.getElementById('main-content');
        if (main) {
            main.setAttribute('tabindex', '-1');
            main.focus();
            main.addEventListener('blur', () => main.removeAttribute('tabindex'), { once: true });
        }
    });
}

/**
 * Search Autocomplete
 */
function initSearchAutocomplete() {
    const searchInput = document.querySelector('.search-input');
    const suggestions = document.getElementById('searchSuggestions');
    if (!searchInput || !suggestions) return;

    let debounceTimer;
    searchInput.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        const q = this.value.trim();
        if (q.length < 2) { suggestions.classList.remove('active'); return; }
        debounceTimer = setTimeout(() => {
            fetch(window.routeUrls.search + '?q=' + encodeURIComponent(q) + '&suggestions=1')
                .then(r => r.json())
                .then(data => {
                    if (data.html) {
                        suggestions.innerHTML = data.html;
                        suggestions.classList.add('active');
                    }
                });
        }, 300);
    });

    searchInput.addEventListener('focus', function() {
        if (this.value.trim().length >= 2) suggestions.classList.add('active');
    });

    document.addEventListener('click', function(e) {
        if (!e.target.closest('.search-container')) {
            suggestions.classList.remove('active');
        }
    });

    searchInput.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') suggestions.classList.remove('active');
    });
}

/**
 * Recently Viewed Tracking
 */
function initRecentlyViewed() {
    const productId = document.querySelector('[data-track-view]')?.dataset?.trackView;
    if (!productId) return;
    try {
        let viewed = JSON.parse(localStorage.getItem('recently_viewed') || '[]');
        viewed = viewed.filter(id => id !== productId);
        viewed.unshift(productId);
        if (viewed.length > 20) viewed = viewed.slice(0, 20);
        localStorage.setItem('recently_viewed', JSON.stringify(viewed));
    } catch(e) {}
}

/**
 * Init everything on DOM ready
 */
document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

    updateWishlistCount();
    updateCartCount();
    if (document.querySelector('.notification-count-badge')) updateNotificationCount();
    initRippleEffect();
    initBackToTop();
    initSkipLink();
    initSearchAutocomplete();
    initRecentlyViewed();

    // Wishlist toggle
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.wishlist-btn');
        if (!btn) return;
        const productId = btn.dataset.productId;
        const icon = btn.querySelector('i');
        btn.classList.add('loading');
        fetch(window.routeUrls.wishlistToggle, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
            body: JSON.stringify({ product_id: productId })
        })
        .then(r => r.json())
        .then(d => {
            btn.classList.remove('loading');
            if (d.status === 'success') {
                if (d.added) {
                    icon.className = 'fas fa-heart';
                    btn.classList.add('active');
                    btn.style.animation = 'none';
                    void btn.offsetHeight;
                    btn.style.animation = 'wishlistPop 0.4s ease';
                    showToast('Added to wishlist!', 'success');
                } else {
                    icon.className = 'far fa-heart';
                    btn.classList.remove('active');
                    showToast('Removed from wishlist', 'info');
                }
                updateWishlistCount();
            } else if (d.status === 'error' && d.message?.includes('login')) {
                window.location.href = window.routeUrls.login;
            }
        });
    });

    // Add to Cart - general handler
    document.addEventListener('submit', function(e) {
        const form = e.target.closest('form[data-add-to-cart-form]');
        if (!form || e.type !== 'submit') return;
        e.preventDefault();
        const btn = form.querySelector('[data-add-to-cart]');
        const pid = btn ? btn.dataset.productId : form.querySelector('[name="product_id"]')?.value;
        const qty = form.querySelector('[name="quantity"]')?.value || 1;

        btn.classList.add('loading');
        btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';

        fetch(window.routeUrls.cartAdd, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
            body: JSON.stringify({ product_id: pid, quantity: qty })
        })
        .then(r => r.json())
        .then(d => {
            btn.classList.remove('loading');
            if (d.success) {
                btn.innerHTML = '<i class="fas fa-check"></i> Added';
                setTimeout(() => {
                    btn.innerHTML = '<i class="fas fa-shopping-cart me-2"></i>Add to Cart';
                }, 2000);
                showToast('Added to cart!', 'success');
                updateCartCount();
            } else {
                btn.innerHTML = '<i class="fas fa-shopping-cart me-2"></i>Add to Cart';
                showToast(d.message || 'Error adding to cart', 'error');
            }
        });
    });

    // Quick Add to Cart (product cards)
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.add-to-cart-quick');
        if (!btn) return;
        const pid = btn.dataset.productId;
        if (!pid || btn.disabled) return;

        btn.classList.add('loading');
        btn.innerHTML = '<span class="spinner-border spinner-border-sm" style="width:14px;height:14px;border-width:2px"></span>';

        fetch(window.routeUrls.cartAdd, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
            body: JSON.stringify({ product_id: pid, quantity: 1 })
        })
        .then(r => r.json())
        .then(d => {
            btn.classList.remove('loading');
            if (d.success) {
                btn.innerHTML = '<i class="fas fa-check"></i>';
                btn.style.background = '#10B981';
                setTimeout(() => {
                    btn.innerHTML = '<i class="fas fa-plus"></i>';
                    btn.style.background = '';
                }, 1500);
                showToast('Added to cart!', 'success');
                updateCartCount();
            } else {
                btn.innerHTML = '<i class="fas fa-plus"></i>';
                showToast(d.message || 'Error', 'error');
            }
        });
    });

    // Header search form enhancement
    const searchForm = document.querySelector('.search-wrapper');
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            const input = this.querySelector('.search-input');
            if (!input.value.trim()) e.preventDefault();
        });
    }

    initFlashTimers();

    // Sticky header scroll
    const header = document.querySelector('.main-header');
    if (header) {
        window.addEventListener('scroll', function() {
            header.classList.toggle('header-scrolled', window.scrollY > 10);
        }, { passive: true });
    }
});

document.addEventListener('ajaxComplete', function() {
    updateCartCount();
    updateWishlistCount();
});