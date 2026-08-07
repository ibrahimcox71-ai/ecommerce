<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach($urls as $url)
    <url>
        <loc>{{ $url['loc'] }}</loc>
        @if(!empty($url['lastmod']))
        <lastmod>{{ $url['lastmod'] instanceof \Carbon\Carbon ? $url['lastmod']->toIso8601String() : \Carbon\Carbon::parse($url['lastmod'])->toIso8601String() }}</lastmod>
        @endif
        <changefreq>{{ $url['changefreq'] }}</changefreq>
        <priority>{{ $url['priority'] }}</priority>
    </url>
    @endforeach
</urlset>
