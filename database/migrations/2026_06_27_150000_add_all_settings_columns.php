<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            // General
            $table->string('tagline')->nullable()->after('site_name');
            $table->string('default_currency', 3)->nullable()->after('robots');
            $table->string('currency_symbol', 10)->nullable()->after('default_currency');
            $table->decimal('tax_rate', 5, 2)->nullable()->after('currency_symbol');
            $table->string('timezone')->nullable()->after('tax_rate');
            $table->string('language', 10)->nullable()->after('timezone');

            // Logo
            $table->string('logo')->nullable()->after('language');

            // Favicon
            $table->string('favicon')->nullable()->after('logo');

            // Email
            $table->string('mail_mailer')->nullable()->after('favicon');
            $table->string('mail_host')->nullable()->after('mail_mailer');
            $table->string('mail_port')->nullable()->after('mail_host');
            $table->string('mail_username')->nullable()->after('mail_port');
            $table->string('mail_password')->nullable()->after('mail_username');
            $table->string('mail_encryption')->nullable()->after('mail_password');
            $table->string('mail_from_address')->nullable()->after('mail_encryption');
            $table->string('mail_from_name')->nullable()->after('mail_from_address');

            // SMS
            $table->string('sms_provider')->nullable()->after('mail_from_name');
            $table->string('sms_api_key')->nullable()->after('sms_provider');
            $table->string('sms_api_secret')->nullable()->after('sms_api_key');
            $table->string('sms_from_number')->nullable()->after('sms_api_secret');

            // Payment
            $table->string('payment_environment')->default('sandbox')->after('sms_from_number');
            $table->string('paypal_client_id')->nullable()->after('payment_environment');
            $table->string('paypal_secret')->nullable()->after('paypal_client_id');
            $table->string('stripe_publishable_key')->nullable()->after('paypal_secret');
            $table->string('stripe_secret_key')->nullable()->after('stripe_publishable_key');
            $table->string('stripe_webhook_secret')->nullable()->after('stripe_secret_key');
            $table->boolean('cod_enabled')->default(true)->after('stripe_webhook_secret');
            $table->boolean('bank_transfer_enabled')->default(true)->after('cod_enabled');

            // Shipping
            $table->decimal('flat_rate', 10, 2)->nullable()->after('bank_transfer_enabled');
            $table->decimal('free_shipping_threshold', 10, 2)->nullable()->after('flat_rate');

            // Invoice
            $table->string('invoice_prefix')->nullable()->after('free_shipping_threshold');
            $table->text('invoice_terms')->nullable()->after('invoice_prefix');
            $table->text('invoice_footer')->nullable()->after('invoice_terms');
            $table->boolean('invoice_show_logo')->default(true)->after('invoice_footer');

            // Additional SEO
            $table->string('google_analytics_id')->nullable()->after('invoice_show_logo');
            $table->string('google_tag_manager_id')->nullable()->after('google_analytics_id');

            // Social Media
            $table->string('social_facebook')->nullable()->after('google_tag_manager_id');
            $table->string('social_twitter')->nullable()->after('social_facebook');
            $table->string('social_instagram')->nullable()->after('social_twitter');
            $table->string('social_youtube')->nullable()->after('social_instagram');
            $table->string('social_linkedin')->nullable()->after('social_youtube');
            $table->string('social_pinterest')->nullable()->after('social_linkedin');
            $table->string('social_tiktok')->nullable()->after('social_pinterest');
            $table->string('social_whatsapp')->nullable()->after('social_tiktok');
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'tagline', 'default_currency', 'currency_symbol', 'tax_rate', 'timezone', 'language',
                'logo', 'favicon',
                'mail_mailer', 'mail_host', 'mail_port', 'mail_username', 'mail_password',
                'mail_encryption', 'mail_from_address', 'mail_from_name',
                'sms_provider', 'sms_api_key', 'sms_api_secret', 'sms_from_number',
                'payment_environment', 'paypal_client_id', 'paypal_secret',
                'stripe_publishable_key', 'stripe_secret_key', 'stripe_webhook_secret',
                'cod_enabled', 'bank_transfer_enabled',
                'flat_rate', 'free_shipping_threshold',
                'invoice_prefix', 'invoice_terms', 'invoice_footer', 'invoice_show_logo',
                'google_analytics_id', 'google_tag_manager_id',
                'social_facebook', 'social_twitter', 'social_instagram', 'social_youtube',
                'social_linkedin', 'social_pinterest', 'social_tiktok', 'social_whatsapp',
            ]);
        });
    }
};
