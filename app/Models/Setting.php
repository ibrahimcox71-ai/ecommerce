<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        // General
        'site_name',
        'tagline',
        'default_currency',
        'currency_symbol',
        'tax_rate',
        'timezone',
        'language',

        // Logo & Favicon
        'logo',
        'favicon',

        // Email
        'mail_mailer',
        'mail_host',
        'mail_port',
        'mail_username',
        'mail_password',
        'mail_encryption',
        'mail_from_address',
        'mail_from_name',

        // SMS
        'sms_provider',
        'sms_api_key',
        'sms_api_secret',
        'sms_from_number',

        // Payment
        'payment_environment',
        'paypal_client_id',
        'paypal_secret',
        'stripe_publishable_key',
        'stripe_secret_key',
        'stripe_webhook_secret',
        'cod_enabled',
        'bank_transfer_enabled',

        // Shipping
        'flat_rate',
        'free_shipping_threshold',

        // Invoice
        'invoice_prefix',
        'invoice_terms',
        'invoice_footer',
        'invoice_show_logo',

        // SEO
        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical_url',
        'og_image',
        'og_type',
        'schema_markup',
        'robots',
        'google_analytics_id',
        'google_tag_manager_id',

        // Social Media
        'social_facebook',
        'social_twitter',
        'social_instagram',
        'social_youtube',
        'social_linkedin',
        'social_pinterest',
        'social_tiktok',
        'social_whatsapp',
    ];

    protected function casts(): array
    {
        return [
            'og_type' => 'string',
            'tax_rate' => 'decimal:2',
            'flat_rate' => 'decimal:2',
            'free_shipping_threshold' => 'decimal:2',
            'cod_enabled' => 'boolean',
            'bank_transfer_enabled' => 'boolean',
            'invoice_show_logo' => 'boolean',
        ];
    }

    public static function getSeoDefaults(): self
    {
        return cache()->remember('seo_settings', 3600, function () {
            return self::first() ?? new self();
        });
    }

    public static function getSettings(): self
    {
        return cache()->remember('app_settings', 3600, function () {
            return self::first() ?? new self();
        });
    }

    public static function clearCache(): void
    {
        cache()->forget('seo_settings');
        cache()->forget('app_settings');
    }
}
