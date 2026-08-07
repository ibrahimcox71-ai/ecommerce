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

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @stack('styles')
</head>
<body>
    <div class="customer-layout">

        <x-customer.sidebar />

        <div class="customer-main d-flex flex-column min-vh-100">

            @include('partials.frontend.header-minimal')

            <main class="flex-grow-1">
                <div class="container-fluid py-4">
                    <div class="row">
                        <div class="col-12">
                            <x-session-flash />

                            {{ $slot }}
                        </div>
                    </div>
                </div>
            </main>

            @include('partials.frontend.footer-minimal')

        </div>

    </div>

    @stack('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const badge = document.querySelector('.unread-notifications');
            if (!badge) return;
            fetch('{{ route("notification.unread-count") }}')
                .then(r => r.json())
                .then(d => {
                    if (d.count > 0) {
                        badge.textContent = d.count;
                        badge.style.display = '';
                    }
                });
        });
    </script>
</body>
</html>
