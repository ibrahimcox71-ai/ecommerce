@props(['title' => config('app.name'), 'metaDescription' => '', 'canonicalUrl' => null, 'seoData' => []])

@php
    $_seo = $seoData ?? [];
    $_metaTitle = $metaTitle ?? $_seo['metaTitle'] ?? $title ?? config('app.name');
    $_metaDescription = $metaDescription ?: ($_seo['metaDescription'] ?? '');
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#F57224">

    <title>{{ $_metaTitle }}</title>

    @if($_metaDescription)
    <meta name="description" content="{{ $_metaDescription }}">
    @endif

    @if(!empty($_seo['robots']))
    <meta name="robots" content="{{ $_seo['robots'] }}">
    @endif

    @if(!empty($_seo['canonicalUrl']))
    <link rel="canonical" href="{{ $_seo['canonicalUrl'] }}">
    @endif

    <meta property="og:site_name" content="{{ $_seo['ogSiteName'] ?? config('app.name') }}">
    <meta property="og:url" content="{{ $_seo['ogUrl'] ?? request()->url() }}">
    <meta property="og:type" content="{{ $_seo['ogType'] ?? 'website' }}">
    <meta property="og:title" content="{{ $_seo['ogTitle'] ?? $_metaTitle }}">
    @if(!empty($_seo['ogDescription']))
    <meta property="og:description" content="{{ $_seo['ogDescription'] }}">
    @endif
    @if(!empty($_seo['ogImage']))
    <meta property="og:image" content="{{ $_seo['ogImage'] }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    @endif

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $_seo['ogTitle'] ?? $_metaTitle }}">
    @if(!empty($_seo['ogDescription']))
    <meta name="twitter:description" content="{{ $_seo['ogDescription'] }}">
    @endif
    @if(!empty($_seo['ogImage']))
    <meta name="twitter:image" content="{{ $_seo['ogImage'] }}">
    @endif

    @if(!empty($_seo['schemas']))
        @foreach($_seo['schemas'] as $schema)
    <script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
        @endforeach
    @endif

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" media="print" onload="this.media='all'">

    <link rel="preload" as="style" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" media="print" onload="this.media='all'">
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"></noscript>

    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/js/frontend.js'])
    @stack('styles')
</head>
<body>

    <a href="#main-content" class="skip-to-content btn btn-primary position-absolute start-0 z-3" style="transform: translateY(-100%); transition: transform 0.2s;" data-skip-link>
        Skip to main content
    </a>

    @include('partials.frontend.announcement')
    @include('partials.frontend.header')
    @include('partials.frontend.mega-menu')

    <main id="main-content">
        {{ $slot }}
    </main>

    @include('partials.frontend.footer')

    @include('partials.frontend.mobile-nav')

    <div class="toast-container-v2" id="toastContainer" role="alert" aria-live="polite" aria-atomic="true"></div>

    @php
        $_routeUrls = [
            'wishlistToggle' => route('wishlist.toggle'),
            'wishlistCount' => route('wishlist.count'),
            'cartAdd' => route('cart.add'),
            'cartSummary' => route('cart.summary'),
            'cartCouponApply' => route('cart.coupon.apply'),
            'checkout' => route('checkout'),
            'search' => route('search'),
            'login' => route('login'),
            'notificationUnread' => route('notification.unread-count'),
        ];
    @endphp
    <script>window.routeUrls = @json($_routeUrls);</script>

    <div class="floating-elements" role="complementary" aria-label="Quick actions">
        <button class="floating-btn back-to-top touch-target" id="backToTop" aria-label="Back to top" tabindex="0">
            <i class="fas fa-chevron-up" aria-hidden="true"></i>
        </button>
    </div>

    <div id="recentlyPurchasedPopup"></div>

    @stack('scripts')
</body>
</html>
