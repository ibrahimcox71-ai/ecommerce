@php
    $_seo = $seoData ?? [];
    $_metaTitle = $metaTitle ?? $_seo['metaTitle'] ?? config('app.name');
    $_metaDescription = $metaDescription ?? $_seo['metaDescription'] ?? '';
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#F57224">

    <title>{{ $_metaTitle }}</title>

    @isset($_metaDescription)
    <meta name="description" content="{{ $_metaDescription }}">
    @endisset

    @isset($_seo['canonicalUrl'])
    <link rel="canonical" href="{{ $_seo['canonicalUrl'] }}">
    @endisset

    <meta property="og:title" content="{{ $_seo['ogTitle'] ?? $_metaTitle }}">
    @isset($_seo['ogDescription'])
    <meta property="og:description" content="{{ $_seo['ogDescription'] }}">
    @endisset
    <meta property="og:url" content="{{ $_seo['ogUrl'] ?? request()->url() }}">
    <meta property="og:type" content="website">

    <meta name="twitter:card" content="summary_large_image">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @stack('styles')
</head>
<body class="bg-light">
    <main>
        <div class="container">
            <div class="row justify-content-center align-items-center min-vh-100">
                <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
                    <div class="text-center mb-4">
                        <a href="{{ route('home') }}" class="text-decoration-none">
                            <span class="d-inline-flex align-items-center gap-2 fs-2 fw-bold text-gray-900">
                                <span class="d-inline-flex align-items-center justify-content-center" style="width:44px;height:44px;background:linear-gradient(135deg,var(--primary),var(--secondary));border-radius:var(--radius-sm);color:#fff;font-size:1.2rem;">
                                    <i class="fas fa-store"></i>
                                </span>
                                {{ config('app.name') }}
                            </span>
                        </a>
                    </div>
                    <div class="card-premium border">
                        <div class="card-body p-4">
                            {{ $slot }}
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        <small class="text-gray-500">&copy; {{ date('Y') }} {{ config('app.name') }}</small>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @stack('scripts')
</body>
</html>
