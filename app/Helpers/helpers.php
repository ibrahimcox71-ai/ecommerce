<?php

use Illuminate\Support\Number;

if (!function_exists('formatPrice')) {
    function formatPrice(float $amount, ?string $currency = null): string
    {
        $currency = $currency ?? config('ecommerce.currency', 'USD');
        return Number::currency($amount, $currency);
    }
}

if (!function_exists('generateOrderNumber')) {
    function generateOrderNumber(): string
    {
        return 'ORD-' . strtoupper(uniqid());
    }
}

if (!function_exists('generateInvoiceNumber')) {
    function generateInvoiceNumber(): string
    {
        return 'INV-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
    }
}

if (!function_exists('generateTrackingNumber')) {
    function generateTrackingNumber(): string
    {
        return 'TRK' . date('Ymd') . strtoupper(substr(uniqid(), -8));
    }
}

if (!function_exists('getGravatar')) {
    function getGravatar(string $email, int $size = 80): string
    {
        $hash = md5(strtolower(trim($email)));
        return "https://www.gravatar.com/avatar/{$hash}?s={$size}&d=mp";
    }
}

if (!function_exists('truncateText')) {
    function truncateText(string $text, int $length = 100): string
    {
        if (strlen($text) <= $length) {
            return $text;
        }
        return substr($text, 0, $length) . '...';
    }
}

if (!function_exists('ratingStars')) {
    function ratingStars(float $rating): string
    {
        $full = floor($rating);
        $half = $rating - $full >= 0.5;
        $empty = 5 - $full - ($half ? 1 : 0);
        $html = '';

        for ($i = 0; $i < $full; $i++) {
            $html .= '<i class="fas fa-star text-warning"></i>';
        }

        if ($half) {
            $html .= '<i class="fas fa-star-half-alt text-warning"></i>';
        }

        for ($i = 0; $i < $empty; $i++) {
            $html .= '<i class="far fa-star text-warning"></i>';
        }

        return $html;
    }
}
