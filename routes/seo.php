<?php

use Illuminate\Support\Facades\Route;

Route::get('/sitemap.xml', [\App\Http\Controllers\Frontend\SitemapController::class, 'index'])->name('sitemap');

Route::get('/robots.txt', function () {
    $disallow = config('app.env') === 'production' ? '' : "Disallow: /";
    $sitemap = route('sitemap');
    return response(view('robots', compact('disallow', 'sitemap')))
        ->header('Content-Type', 'text/plain');
})->name('robots');
