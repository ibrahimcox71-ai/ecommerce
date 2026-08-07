<footer class="site-footer" role="contentinfo">
    <div class="container">
        <div class="row g-4">

            <div class="col-lg-4 col-md-6">
                <a href="{{ route('home') }}" class="footer-brand" aria-label="{{ config('app.name') }} home">
                    <span class="footer-logo-icon"><i class="fas fa-store"></i></span>
                    <span class="footer-logo-text">{{ config('app.name') }}</span>
                </a>
                <p class="footer-desc">Your premium destination for quality products at unbeatable prices. Shop with confidence with our 100% satisfaction guarantee.</p>
                <div class="footer-social">
                    <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f" aria-hidden="true"></i></a>
                    <a href="#" aria-label="X (Twitter)"><i class="fab fa-twitter" aria-hidden="true"></i></a>
                    <a href="#" aria-label="Instagram"><i class="fab fa-instagram" aria-hidden="true"></i></a>
                    <a href="#" aria-label="YouTube"><i class="fab fa-youtube" aria-hidden="true"></i></a>
                    <a href="#" aria-label="TikTok"><i class="fab fa-tiktok" aria-hidden="true"></i></a>
                </div>
            </div>

            <div class="col-lg-2 col-md-6">
                <h5>Quick Links</h5>
                <ul class="footer-links">
                    <li><a href="{{ route('about') }}">About Us</a></li>
                    <li><a href="{{ route('shop') }}">Shop All</a></li>
                    <li><a href="{{ route('flash-sale') }}">Flash Sale</a></li>
                    <li><a href="{{ route('blog') }}">Blog</a></li>
                    <li><a href="{{ route('contact') }}">Contact</a></li>
                    <li><a href="{{ route('faq') }}">FAQ</a></li>
                </ul>
            </div>

            <div class="col-lg-2 col-md-6">
                <h5>Policies</h5>
                <ul class="footer-links">
                    <li><a href="{{ route('privacy-policy') }}">Privacy Policy</a></li>
                    <li><a href="{{ route('shipping-policy') }}">Shipping Policy</a></li>
                    <li><a href="{{ route('refund-policy') }}">Refund Policy</a></li>
                    <li><a href="{{ route('terms') }}">Terms of Service</a></li>
                </ul>
            </div>

            <div class="col-lg-4 col-md-6">
                <h5>Get in Touch</h5>
                <div class="footer-contact-item">
                    <i class="fas fa-envelope" aria-hidden="true"></i>
                    <span>support@example.com</span>
                </div>
                <div class="footer-contact-item">
                    <i class="fas fa-phone" aria-hidden="true"></i>
                    <span>+1 (555) 123-4567</span>
                </div>
                <div class="footer-contact-item">
                    <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                    <span>123 Commerce St, Suite 100, New York, NY 10001</span>
                </div>
                <div class="mt-4">
                    <h5>Newsletter</h5>
                    <p class="footer-desc">Get <strong>10% OFF</strong> your first purchase!</p>
                    <form class="footer-newsletter-form" action="#" method="POST" aria-label="Newsletter signup">
                        @csrf
                        <input type="email" name="email" placeholder="Your email address" required aria-label="Email address">
                        <button type="submit" aria-label="Subscribe"><i class="fas fa-paper-plane" aria-hidden="true"></i></button>
                    </form>
                    <small class="text-gray-500 fs-8">We respect your privacy. Unsubscribe anytime.</small>
                </div>
            </div>

        </div>

        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved. Built with care.</p>
            <div class="payment-icons" aria-label="Accepted payment methods">
                <i class="fab fa-cc-visa" aria-hidden="true" title="Visa"></i>
                <i class="fab fa-cc-mastercard" aria-hidden="true" title="Mastercard"></i>
                <i class="fab fa-cc-amex" aria-hidden="true" title="American Express"></i>
                <i class="fab fa-cc-paypal" aria-hidden="true" title="PayPal"></i>
                <i class="fab fa-cc-discover" aria-hidden="true" title="Discover"></i>
                <i class="fab fa-cc-apple-pay" aria-hidden="true" title="Apple Pay"></i>
            </div>
        </div>

    </div>
</footer>
