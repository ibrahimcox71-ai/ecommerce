@props(['title' => 'Stay in the Loop', 'subtitle' => 'Subscribe to get special offers and updates.'])
<section class="mb-5">
    <div class="newsletter-card rounded-4 p-5 text-center text-white">
        <h2 class="fw-bold mb-2">{{ $title }}</h2>
        <p class="mb-4 text-white-50">{{ $subtitle }}</p>
        <form class="newsletter-form mx-auto" style="max-width: 480px;" method="POST" action="{{ route('newsletter.subscribe') }}">
            @csrf
            <div class="input-group">
                <input type="email" name="email" class="form-control form-control-lg border-0" placeholder="Enter your email" required aria-label="Email for newsletter">
                <button type="submit" class="btn btn-light px-4 fw-semibold">Subscribe</button>
            </div>
        </form>
    </div>
</section>
