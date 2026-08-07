import './bootstrap';
import './cart';
import './checkout';

import Swiper from 'swiper';
import { Autoplay, Pagination, Navigation, Grid } from 'swiper/modules';

import AOS from 'aos';

AOS.init({
    duration: 600,
    once: true,
    offset: 80,
    easing: 'ease-out-cubic'
});

// Hero Slider
const heroSwiper = new Swiper('.hero-swiper', {
    modules: [Autoplay, Pagination, Navigation],
    loop: true,
    speed: 800,
    autoplay: {
        delay: 6000,
        disableOnInteraction: false,
    },
    pagination: {
        el: '.hero-pagination',
        clickable: true,
    },
    navigation: {
        nextEl: '.hero-button-next',
        prevEl: '.hero-button-prev',
    },
    effect: 'fade',
    fadeEffect: {
        crossFade: true
    }
});

// Product Carousels
const productSwiper = document.querySelectorAll('.product-carousel-swiper');
productSwiper.forEach(el => {
    new Swiper(el, {
        modules: [Autoplay, Pagination, Navigation, Grid],
        slidesPerView: 2,
        spaceBetween: 16,
        speed: 600,
        breakpoints: {
            480: { slidesPerView: 2, spaceBetween: 16 },
            768: { slidesPerView: 3, spaceBetween: 20 },
            992: { slidesPerView: 4, spaceBetween: 24 },
            1200: { slidesPerView: 5, spaceBetween: 24 }
        },
        pagination: {
            el: el.querySelector('.swiper-pagination'),
            clickable: true,
        },
        navigation: {
            nextEl: el.querySelector('.swiper-button-next'),
            prevEl: el.querySelector('.swiper-button-prev'),
        }
    });
});

// Search suggestions toggle
const searchInput = document.querySelector('.search-input');
const searchSuggestions = document.getElementById('searchSuggestions');
if (searchInput && searchSuggestions) {
    searchInput.addEventListener('focus', () => {
        searchSuggestions.classList.add('active');
        searchInput.setAttribute('aria-expanded', 'true');
    });
    document.addEventListener('click', (e) => {
        if (!e.target.closest('.search-container')) {
            searchSuggestions.classList.remove('active');
            searchInput.setAttribute('aria-expanded', 'false');
        }
    });
    searchInput.addEventListener('input', function() {
        if (this.value.length > 0) {
            searchSuggestions.innerHTML = '<div class="p-3"><div class="skeleton-line mb-2"></div><div class="skeleton-line-sm"></div></div>';
        } else {
            searchSuggestions.innerHTML = '<div class="p-3 text-center text-muted small">Type to search products...</div>';
        }
    });
}

// Smooth scroll for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        const href = this.getAttribute('href');
        if (href !== '#') {
            const target = document.querySelector(href);
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }
    });
});

// Live visitor counter simulation
const liveVisitorEl = document.getElementById('liveVisitorCount');
if (liveVisitorEl) {
    const base = 142;
    const visitors = base + Math.floor(Math.random() * 58);
    liveVisitorEl.textContent = visitors;
    setInterval(() => {
        const change = Math.floor(Math.random() * 5) - 2;
        const current = parseInt(liveVisitorEl.textContent) || base;
        liveVisitorEl.textContent = Math.max(base, current + change);
    }, 8000);
}

// Ripple effect
document.addEventListener('click', function(e) {
    const btn = e.target.closest('.btn-ripple');
    if (!btn) return;
    const ripple = document.createElement('span');
    ripple.classList.add('ripple-effect');
    const rect = btn.getBoundingClientRect();
    const size = Math.max(rect.width, rect.height);
    ripple.style.width = ripple.style.height = size + 'px';
    ripple.style.left = (e.clientX - rect.left - size / 2) + 'px';
    ripple.style.top = (e.clientY - rect.top - size / 2) + 'px';
    btn.appendChild(ripple);
    ripple.addEventListener('animationend', () => ripple.remove());
});

// Back to top button
const backToTop = document.getElementById('backToTop');
if (backToTop) {
    backToTop.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
    window.addEventListener('scroll', () => {
        backToTop.classList.toggle('visible', window.scrollY > 400);
    });
}

// Header scroll effect
const header = document.querySelector('.main-header');
if (header) {
    window.addEventListener('scroll', () => {
        header.classList.toggle('header-scrolled', window.scrollY > 10);
    });
}

// Announcement close
const announcementClose = document.querySelector('.announcement-close');
if (announcementClose) {
    announcementClose.addEventListener('click', function() {
        const bar = document.querySelector('.announcement-bar');
        bar.style.height = '0';
        bar.style.padding = '0';
        bar.style.overflow = 'hidden';
        setTimeout(() => bar.remove(), 300);
    });
}

// Recently purchased popup
const productNames = [
    'iPhone 15 Pro Max', 'Samsung Galaxy S24', 'MacBook Air M3',
    'AirPods Pro 2', 'Apple Watch Ultra', 'Sony WH-1000XM5',
    'Dyson V15 Detect', 'Nintendo Switch OLED', 'PS5 Slim'
];

function showRecentlyPurchased() {
    const popup = document.getElementById('recentlyPurchasedPopup');
    if (!popup) return;
    const name = productNames.sort(() => Math.random() - 0.5).slice(0, 1)[0];
    const minutes = Math.floor(Math.random() * 15) + 1;
    popup.innerHTML = `
        <div class="recently-purchased-popup" role="status" aria-live="polite">
            <img src="https://picsum.photos/seed/${Date.now()}/100/100" alt="" class="rp-img" loading="lazy">
            <div class="rp-info">
                <strong>${name}</strong>
                <p>Someone purchased this</p>
                <small>${minutes} min ago</small>
            </div>
            <button class="rp-close touch-target" onclick="this.closest('.recently-purchased-popup').remove()" aria-label="Close">&times;</button>
        </div>
    `;
    setTimeout(() => {
        const el = popup.querySelector('.recently-purchased-popup');
        if (el) { el.style.opacity = '0'; setTimeout(() => el.remove(), 300); }
    }, 6000);
}

setTimeout(showRecentlyPurchased, 5000);
setInterval(showRecentlyPurchased, 45000);
