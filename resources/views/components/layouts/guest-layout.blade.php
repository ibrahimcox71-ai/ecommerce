@props(['title' => config('app.name'), 'metaDescription' => '', 'canonicalUrl' => null])

@php
    $_seoTitle = $title ?? config('app.name');
    $_seoDesc = $metaDescription ?? '';
    $_canonical = $canonicalUrl ?? request()->url();
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#F57224">
    <title>{{ $_seoTitle }} - {{ config('app.name') }}</title>

    @if($_seoDesc)
    <meta name="description" content="{{ $_seoDesc }}">
    @endif

    <meta name="robots" content="noindex,nofollow">
    <link rel="canonical" href="{{ $_canonical }}">

    <meta property="og:site_name" content="{{ config('app.name') }}">
    <meta property="og:url" content="{{ $_canonical }}">
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $_seoTitle }} - {{ config('app.name') }}">
    @if($_seoDesc)
    <meta property="og:description" content="{{ $_seoDesc }}">
    @endif

    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="{{ $_seoTitle }} - {{ config('app.name') }}">
    @if($_seoDesc)
    <meta name="twitter:description" content="{{ $_seoDesc }}">
    @endif

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" media="print" onload="this.media='all'">
    <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"></noscript>

    <link rel="preload" as="style" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" media="print" onload="this.media='all'">
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"></noscript>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="auth-bg">

    <a href="#auth-main-content" class="skip-to-content btn btn-primary position-absolute start-0 z-3" style="transform: translateY(-100%); transition: transform 0.2s;" data-skip-link>
        Skip to main content
    </a>

    <div id="auth-main-content">
        <div class="container">
            <div class="row justify-content-center align-items-center min-vh-100 py-5">
                <div class="col-12 d-flex flex-column align-items-center">
                    <div class="text-center mb-4">
                        <a href="{{ route('home') }}" class="text-decoration-none">
                            <span class="d-inline-flex align-items-center gap-2 fs-2 fw-bold text-gray-900">
                                <span class="d-inline-flex align-items-center justify-content-center" style="width:44px;height:44px;background:linear-gradient(135deg,var(--primary),var(--secondary));border-radius:var(--radius-sm);color:#fff;font-size:1.2rem;">
                                    <i class="fas fa-store" aria-hidden="true"></i>
                                </span>
                                {{ config('app.name') }}
                            </span>
                        </a>
                    </div>

                    <x-session-flash />

                    <div class="card-premium auth-card border-0 mx-auto" style="max-width: 420px; width: 100%; border-radius: 16px;">
                        <div class="card-body p-4 p-md-5">
                            {{ $slot }}
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        <small class="text-gray-500">&copy; {{ date('Y') }} {{ config('app.name') }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
