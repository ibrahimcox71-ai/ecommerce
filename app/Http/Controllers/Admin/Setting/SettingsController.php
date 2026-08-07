<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function index(): View
    {
        $settings = Setting::getSettings();

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $settings = Setting::first();

        if (!$settings) {
            $settings = new Setting();
        }

        $tab = $request->input('_tab', 'general');

        $rules = match ($tab) {
            'general' => [
                'site_name' => 'nullable|string|max:255',
                'tagline' => 'nullable|string|max:500',
                'default_currency' => 'nullable|string|max:3',
                'currency_symbol' => 'nullable|string|max:10',
                'tax_rate' => 'nullable|numeric|min:0|max:100',
                'timezone' => 'nullable|string|max:255',
                'language' => 'nullable|string|max:10',
            ],
            'logo' => [
                'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
                'favicon' => 'nullable|image|mimes:ico,png,jpg,jpeg,webp,svg|max:1024',
            ],
            'email' => [
                'mail_mailer' => 'nullable|string|max:255',
                'mail_host' => 'nullable|string|max:255',
                'mail_port' => 'nullable|string|max:10',
                'mail_username' => 'nullable|string|max:255',
                'mail_password' => 'nullable|string|max:255',
                'mail_encryption' => 'nullable|string|max:50',
                'mail_from_address' => 'nullable|email|max:255',
                'mail_from_name' => 'nullable|string|max:255',
            ],
            'sms' => [
                'sms_provider' => 'nullable|string|max:255',
                'sms_api_key' => 'nullable|string|max:255',
                'sms_api_secret' => 'nullable|string|max:255',
                'sms_from_number' => 'nullable|string|max:50',
            ],
            'payment' => [
                'payment_environment' => 'nullable|string|in:sandbox,live',
                'paypal_client_id' => 'nullable|string|max:255',
                'paypal_secret' => 'nullable|string|max:255',
                'stripe_publishable_key' => 'nullable|string|max:255',
                'stripe_secret_key' => 'nullable|string|max:255',
                'stripe_webhook_secret' => 'nullable|string|max:255',
                'cod_enabled' => 'nullable|boolean',
                'bank_transfer_enabled' => 'nullable|boolean',
            ],
            'shipping' => [
                'flat_rate' => 'nullable|numeric|min:0',
                'free_shipping_threshold' => 'nullable|numeric|min:0',
            ],
            'invoice' => [
                'invoice_prefix' => 'nullable|string|max:50',
                'invoice_terms' => 'nullable|string',
                'invoice_footer' => 'nullable|string',
                'invoice_show_logo' => 'nullable|boolean',
            ],
            'seo' => [
                'meta_title' => 'nullable|string|max:255',
                'meta_description' => 'nullable|string|max:500',
                'meta_keywords' => 'nullable|string|max:500',
                'canonical_url' => 'nullable|url|max:255',
                'og_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
                'og_type' => 'nullable|string|max:50',
                'schema_markup' => 'nullable|string',
                'robots' => 'nullable|string|max:100',
                'google_analytics_id' => 'nullable|string|max:50',
                'google_tag_manager_id' => 'nullable|string|max:50',
            ],
            'social' => [
                'social_facebook' => 'nullable|string|max:255',
                'social_twitter' => 'nullable|string|max:255',
                'social_instagram' => 'nullable|string|max:255',
                'social_youtube' => 'nullable|string|max:255',
                'social_linkedin' => 'nullable|string|max:255',
                'social_pinterest' => 'nullable|string|max:255',
                'social_tiktok' => 'nullable|string|max:255',
                'social_whatsapp' => 'nullable|string|max:255',
            ],
            default => [],
        };

        $validated = $request->validate($rules);

        if ($tab === 'logo' || $tab === 'general') {
            if ($request->hasFile('logo')) {
                if ($settings->logo) {
                    Storage::disk('public')->delete($settings->logo);
                }
                $validated['logo'] = $request->file('logo')->store('settings/logo', 'public');
            } else {
                unset($validated['logo']);
            }

            if ($request->hasFile('favicon')) {
                if ($settings->favicon) {
                    Storage::disk('public')->delete($settings->favicon);
                }
                $validated['favicon'] = $request->file('favicon')->store('settings/favicon', 'public');
            } else {
                unset($validated['favicon']);
            }
        }

        if ($tab === 'seo' && $request->hasFile('og_image')) {
            if ($settings->og_image) {
                Storage::disk('public')->delete($settings->og_image);
            }
            $validated['og_image'] = $request->file('og_image')->store('settings/seo', 'public');
        } else {
            unset($validated['og_image']);
        }

        if (in_array($tab, ['payment', 'invoice'])) {
            foreach ($validated as $key => $value) {
                if (in_array($key, ['cod_enabled', 'bank_transfer_enabled', 'invoice_show_logo'])) {
                    $validated[$key] = filter_var($value, FILTER_VALIDATE_BOOLEAN);
                }
            }
        }

        $settings->fill($validated);
        $settings->save();

        Setting::clearCache();

        return redirect()
            ->route('admin.settings.index', ['tab' => $tab])
            ->with('success', 'Settings updated successfully!');
    }

    public function removeLogo(): RedirectResponse
    {
        $settings = Setting::first();
        if ($settings && $settings->logo) {
            Storage::disk('public')->delete($settings->logo);
            $settings->logo = null;
            $settings->save();
            Setting::clearCache();
        }

        return redirect()
            ->route('admin.settings.index', ['tab' => 'logo'])
            ->with('success', 'Logo removed successfully.');
    }

    public function removeFavicon(): RedirectResponse
    {
        $settings = Setting::first();
        if ($settings && $settings->favicon) {
            Storage::disk('public')->delete($settings->favicon);
            $settings->favicon = null;
            $settings->save();
            Setting::clearCache();
        }

        return redirect()
            ->route('admin.settings.index', ['tab' => 'favicon'])
            ->with('success', 'Favicon removed successfully.');
    }

    public function removeOgImage(): RedirectResponse
    {
        $settings = Setting::first();
        if ($settings && $settings->og_image) {
            Storage::disk('public')->delete($settings->og_image);
            $settings->og_image = null;
            $settings->save();
            Setting::clearCache();
        }

        return redirect()
            ->route('admin.settings.index', ['tab' => 'seo'])
            ->with('success', 'OG image removed successfully.');
    }
}
