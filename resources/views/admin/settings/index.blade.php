<x-layouts.admin-layout title="Settings">
    @php
        $currentTab = request('tab', 'general');
        $tabs = [
            'general' => ['label' => 'General', 'icon' => 'fas fa-cog'],
            'logo' => ['label' => 'Logo', 'icon' => 'fas fa-image'],
            'favicon' => ['label' => 'Favicon', 'icon' => 'fas fa-star'],
            'email' => ['label' => 'Email', 'icon' => 'fas fa-envelope'],
            'sms' => ['label' => 'SMS', 'icon' => 'fas fa-sms'],
            'payment' => ['label' => 'Payment', 'icon' => 'fas fa-credit-card'],
            'shipping' => ['label' => 'Shipping', 'icon' => 'fas fa-truck'],
            'invoice' => ['label' => 'Invoice', 'icon' => 'fas fa-file-invoice'],
            'seo' => ['label' => 'SEO', 'icon' => 'fas fa-search'],
            'social' => ['label' => 'Social Media', 'icon' => 'fas fa-share-alt'],
        ];
    @endphp

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Settings</h4>
            <p class="text-muted small mb-0">Manage your store configuration</p>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-transparent p-0">
            <ul class="nav nav-tabs" id="settingsTabs" role="tablist">
                @foreach($tabs as $key => $tab)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $currentTab === $key ? 'active' : '' }}"
                                id="{{ $key }}-tab"
                                data-bs-toggle="tab"
                                data-bs-target="#{{ $key }}"
                                type="button"
                                role="tab"
                                aria-controls="{{ $key }}"
                                aria-selected="{{ $currentTab === $key ? 'true' : 'false' }}">
                            <i class="{{ $tab['icon'] }} me-1"></i>
                            {{ $tab['label'] }}
                        </button>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_tab" id="currentTab" value="{{ $currentTab }}">

                <div class="tab-content" id="settingsTabContent">
                    {{-- General Tab --}}
                    <div class="tab-pane fade {{ $currentTab === 'general' ? 'show active' : '' }}" id="general" role="tabpanel">
                        <div class="row g-4">
                            <div class="col-lg-8">
                                <div class="mb-3">
                                    <label for="site_name" class="form-label">Site Name</label>
                                    <input type="text" class="form-control @error('site_name') is-invalid @enderror"
                                           id="site_name" name="site_name" value="{{ old('site_name', $settings->site_name) }}"
                                           placeholder="Your store name">
                                    @error('site_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="tagline" class="form-label">Tagline</label>
                                    <input type="text" class="form-control @error('tagline') is-invalid @enderror"
                                           id="tagline" name="tagline" value="{{ old('tagline', $settings->tagline) }}"
                                           placeholder="Short description of your store">
                                    @error('tagline')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="default_currency" class="form-label">Currency</label>
                                        <select class="form-select @error('default_currency') is-invalid @enderror"
                                                id="default_currency" name="default_currency">
                                            <option value="">Select currency</option>
                                            @foreach(['USD' => 'US Dollar', 'EUR' => 'Euro', 'GBP' => 'British Pound', 'INR' => 'Indian Rupee', 'CAD' => 'Canadian Dollar', 'AUD' => 'Australian Dollar', 'JPY' => 'Japanese Yen', 'CNY' => 'Chinese Yuan', 'BRL' => 'Brazilian Real', 'MXN' => 'Mexican Peso', 'AED' => 'UAE Dirham', 'SAR' => 'Saudi Riyal'] as $code => $name)
                                                <option value="{{ $code }}" {{ old('default_currency', $settings->default_currency) === $code ? 'selected' : '' }}>{{ $name }} ({{ $code }})</option>
                                            @endforeach
                                        </select>
                                        @error('default_currency')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="currency_symbol" class="form-label">Currency Symbol</label>
                                        <input type="text" class="form-control @error('currency_symbol') is-invalid @enderror"
                                               id="currency_symbol" name="currency_symbol"
                                               value="{{ old('currency_symbol', $settings->currency_symbol) }}"
                                               placeholder="$" maxlength="10">
                                        @error('currency_symbol')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="tax_rate" class="form-label">Tax Rate (%)</label>
                                        <input type="number" step="0.01" min="0" max="100"
                                               class="form-control @error('tax_rate') is-invalid @enderror"
                                               id="tax_rate" name="tax_rate"
                                               value="{{ old('tax_rate', $settings->tax_rate) }}"
                                               placeholder="0">
                                        @error('tax_rate')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-0">
                                    <div class="col-md-6">
                                        <label for="timezone" class="form-label">Timezone</label>
                                        <select class="form-select @error('timezone') is-invalid @enderror"
                                                id="timezone" name="timezone">
                                            @foreach(timezone_identifiers_list() as $tz)
                                                <option value="{{ $tz }}" {{ old('timezone', $settings->timezone) === $tz ? 'selected' : '' }}>{{ $tz }}</option>
                                            @endforeach
                                        </select>
                                        @error('timezone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="language" class="form-label">Language</label>
                                        <select class="form-select @error('language') is-invalid @enderror"
                                                id="language" name="language">
                                            <option value="en" {{ old('language', $settings->language) === 'en' ? 'selected' : '' }}>English</option>
                                            <option value="ar" {{ old('language', $settings->language) === 'ar' ? 'selected' : '' }}>العربية</option>
                                            <option value="fr" {{ old('language', $settings->language) === 'fr' ? 'selected' : '' }}>Français</option>
                                            <option value="es" {{ old('language', $settings->language) === 'es' ? 'selected' : '' }}>Español</option>
                                            <option value="de" {{ old('language', $settings->language) === 'de' ? 'selected' : '' }}>Deutsch</option>
                                            <option value="tr" {{ old('language', $settings->language) === 'tr' ? 'selected' : '' }}>Türkçe</option>
                                            <option value="ur" {{ old('language', $settings->language) === 'ur' ? 'selected' : '' }}>اردو</option>
                                        </select>
                                        @error('language')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="card bg-light border-0">
                                    <div class="card-body">
                                        <h6 class="fw-bold mb-2"><i class="fas fa-info-circle me-1"></i> General Settings</h6>
                                        <p class="small text-muted mb-0">
                                            Configure your store's basic information including name, currency, and regional settings.
                                            These values are used throughout your storefront and admin panel.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Logo Tab --}}
                    <div class="tab-pane fade {{ $currentTab === 'logo' ? 'show active' : '' }}" id="logo" role="tabpanel">
                        <div class="row g-4">
                            <div class="col-lg-8">
                                <div class="mb-3">
                                    <label class="form-label">Current Logo</label>
                                    @if($settings->logo)
                                        <div class="border rounded p-4 mb-2 text-center bg-light">
                                            <img src="{{ Storage::url($settings->logo) }}"
                                                 alt="Store Logo" class="img-fluid"
                                                 style="max-height: 120px;">
                                        </div>
                                        <div class="d-flex gap-2">
                                            <button type="button" class="btn btn-sm btn-outline-danger"
                                                    onclick="event.preventDefault(); document.getElementById('removeLogoForm').submit();">
                                                <i class="fas fa-trash me-1"></i> Remove Logo
                                            </button>
                                        </div>
                                    @else
                                        <div class="border rounded p-4 mb-2 text-center bg-light">
                                            <i class="fas fa-image fa-3x text-muted"></i>
                                            <p class="text-muted small mt-2 mb-0">No logo uploaded</p>
                                        </div>
                                    @endif
                                </div>

                                <div class="mb-0">
                                    <label for="logo" class="form-label">Upload New Logo</label>
                                    <input type="file" class="form-control @error('logo') is-invalid @enderror"
                                           id="logo" name="logo" accept="image/*">
                                    <small class="text-muted d-block mt-1">
                                        Recommended: 200x60px. Supported: JPG, PNG, WEBP, SVG. Max 2MB.
                                    </small>
                                    @error('logo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="card bg-light border-0">
                                    <div class="card-body">
                                        <h6 class="fw-bold mb-2"><i class="fas fa-info-circle me-1"></i> Logo</h6>
                                        <p class="small text-muted mb-0">
                                            Upload your store logo. It will appear in the header of your storefront,
                                            emails, and invoices. For best results, use a transparent PNG.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Favicon Tab --}}
                    <div class="tab-pane fade {{ $currentTab === 'favicon' ? 'show active' : '' }}" id="favicon" role="tabpanel">
                        <div class="row g-4">
                            <div class="col-lg-8">
                                <div class="mb-3">
                                    <label class="form-label">Current Favicon</label>
                                    @if($settings->favicon)
                                        <div class="border rounded p-4 mb-2 text-center bg-light" style="max-width: 200px;">
                                            <img src="{{ Storage::url($settings->favicon) }}"
                                                 alt="Favicon" style="max-height: 64px;">
                                        </div>
                                        <div class="d-flex gap-2">
                                            <button type="button" class="btn btn-sm btn-outline-danger"
                                                    onclick="event.preventDefault(); document.getElementById('removeFaviconForm').submit();">
                                                <i class="fas fa-trash me-1"></i> Remove Favicon
                                            </button>
                                        </div>
                                    @else
                                        <div class="border rounded p-4 mb-2 text-center bg-light" style="max-width: 200px;">
                                            <i class="fas fa-star fa-3x text-muted"></i>
                                            <p class="text-muted small mt-2 mb-0">No favicon uploaded</p>
                                        </div>
                                    @endif
                                </div>

                                <div class="mb-0">
                                    <label for="favicon" class="form-label">Upload New Favicon</label>
                                    <input type="file" class="form-control @error('favicon') is-invalid @enderror"
                                           id="favicon" name="favicon" accept=".ico,.png,.jpg,.jpeg,.webp,.svg">
                                    <small class="text-muted d-block mt-1">
                                        Recommended: 32x32px or 16x16px. Supported: ICO, PNG, JPG, SVG. Max 1MB.
                                    </small>
                                    @error('favicon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="card bg-light border-0">
                                    <div class="card-body">
                                        <h6 class="fw-bold mb-2"><i class="fas fa-info-circle me-1"></i> Favicon</h6>
                                        <p class="small text-muted mb-0">
                                            Upload a favicon that will appear in the browser tab. ICO format is
                                            recommended for best compatibility across all browsers.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Email Tab --}}
                    <div class="tab-pane fade {{ $currentTab === 'email' ? 'show active' : '' }}" id="email" role="tabpanel">
                        <div class="row g-4">
                            <div class="col-lg-8">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="mail_mailer" class="form-label">Mail Driver</label>
                                        <select class="form-select @error('mail_mailer') is-invalid @enderror"
                                                id="mail_mailer" name="mail_mailer">
                                            <option value="smtp" {{ old('mail_mailer', $settings->mail_mailer) === 'smtp' ? 'selected' : '' }}>SMTP</option>
                                            <option value="sendmail" {{ old('mail_mailer', $settings->mail_mailer) === 'sendmail' ? 'selected' : '' }}>Sendmail</option>
                                            <option value="mailgun" {{ old('mail_mailer', $settings->mail_mailer) === 'mailgun' ? 'selected' : '' }}>Mailgun</option>
                                            <option value="postmark" {{ old('mail_mailer', $settings->mail_mailer) === 'postmark' ? 'selected' : '' }}>Postmark</option>
                                            <option value="ses" {{ old('mail_mailer', $settings->mail_mailer) === 'ses' ? 'selected' : '' }}>Amazon SES</option>
                                            <option value="log" {{ old('mail_mailer', $settings->mail_mailer) === 'log' ? 'selected' : '' }}>Log (local testing)</option>
                                        </select>
                                        @error('mail_mailer')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="mail_host" class="form-label">SMTP Host</label>
                                        <input type="text" class="form-control @error('mail_host') is-invalid @enderror"
                                               id="mail_host" name="mail_host"
                                               value="{{ old('mail_host', $settings->mail_host) }}"
                                               placeholder="smtp.example.com">
                                        @error('mail_host')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="mail_port" class="form-label">SMTP Port</label>
                                        <input type="text" class="form-control @error('mail_port') is-invalid @enderror"
                                               id="mail_port" name="mail_port"
                                               value="{{ old('mail_port', $settings->mail_port) }}"
                                               placeholder="587">
                                        @error('mail_port')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="mail_username" class="form-label">SMTP Username</label>
                                        <input type="text" class="form-control @error('mail_username') is-invalid @enderror"
                                               id="mail_username" name="mail_username"
                                               value="{{ old('mail_username', $settings->mail_username) }}"
                                               placeholder="your@email.com">
                                        @error('mail_username')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="mail_password" class="form-label">SMTP Password</label>
                                        <input type="password" class="form-control @error('mail_password') is-invalid @enderror"
                                               id="mail_password" name="mail_password"
                                               value="{{ old('mail_password', $settings->mail_password) }}"
                                               placeholder="Enter password">
                                        @error('mail_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="mail_encryption" class="form-label">Encryption</label>
                                        <select class="form-select @error('mail_encryption') is-invalid @enderror"
                                                id="mail_encryption" name="mail_encryption">
                                            <option value="">None</option>
                                            <option value="tls" {{ old('mail_encryption', $settings->mail_encryption) === 'tls' ? 'selected' : '' }}>TLS</option>
                                            <option value="ssl" {{ old('mail_encryption', $settings->mail_encryption) === 'ssl' ? 'selected' : '' }}>SSL</option>
                                        </select>
                                        @error('mail_encryption')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="mail_from_address" class="form-label">From Address</label>
                                        <input type="email" class="form-control @error('mail_from_address') is-invalid @enderror"
                                               id="mail_from_address" name="mail_from_address"
                                               value="{{ old('mail_from_address', $settings->mail_from_address) }}"
                                               placeholder="noreply@example.com">
                                        @error('mail_from_address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="mail_from_name" class="form-label">From Name</label>
                                        <input type="text" class="form-control @error('mail_from_name') is-invalid @enderror"
                                               id="mail_from_name" name="mail_from_name"
                                               value="{{ old('mail_from_name', $settings->mail_from_name) }}"
                                               placeholder="Your Store Name">
                                        @error('mail_from_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-0">
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Email settings override the values in your <code>.env</code> file when configured here.
                                        For production, consider using a transactional email service.
                                    </small>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="card bg-light border-0">
                                    <div class="card-body">
                                        <h6 class="fw-bold mb-2"><i class="fas fa-info-circle me-1"></i> Email Settings</h6>
                                        <p class="small text-muted mb-0">
                                            Configure your mail server settings to send transactional emails
                                            like order confirmations, invoices, and password resets to your customers.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- SMS Tab --}}
                    <div class="tab-pane fade {{ $currentTab === 'sms' ? 'show active' : '' }}" id="sms" role="tabpanel">
                        <div class="row g-4">
                            <div class="col-lg-8">
                                <div class="mb-3">
                                    <label for="sms_provider" class="form-label">SMS Provider</label>
                                    <select class="form-select @error('sms_provider') is-invalid @enderror"
                                            id="sms_provider" name="sms_provider">
                                        <option value="">Select provider</option>
                                        <option value="twilio" {{ old('sms_provider', $settings->sms_provider) === 'twilio' ? 'selected' : '' }}>Twilio</option>
                                        <option value="vonage" {{ old('sms_provider', $settings->sms_provider) === 'vonage' ? 'selected' : '' }}>Vonage (Nexmo)</option>
                                        <option value="aws" {{ old('sms_provider', $settings->sms_provider) === 'aws' ? 'selected' : '' }}>Amazon SNS</option>
                                        <option value="clickatell" {{ old('sms_provider', $settings->sms_provider) === 'clickatell' ? 'selected' : '' }}>Clickatell</option>
                                        <option value="msg91" {{ old('sms_provider', $settings->sms_provider) === 'msg91' ? 'selected' : '' }}>MSG91</option>
                                        <option value="nexmo" {{ old('sms_provider', $settings->sms_provider) === 'nexmo' ? 'selected' : '' }}>Nexmo</option>
                                    </select>
                                    @error('sms_provider')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="sms_api_key" class="form-label">API Key / SID</label>
                                        <input type="text" class="form-control @error('sms_api_key') is-invalid @enderror"
                                               id="sms_api_key" name="sms_api_key"
                                               value="{{ old('sms_api_key', $settings->sms_api_key) }}"
                                               placeholder="Enter API key">
                                        @error('sms_api_key')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="sms_api_secret" class="form-label">API Secret / Token</label>
                                        <input type="password" class="form-control @error('sms_api_secret') is-invalid @enderror"
                                               id="sms_api_secret" name="sms_api_secret"
                                               value="{{ old('sms_api_secret', $settings->sms_api_secret) }}"
                                               placeholder="Enter API secret">
                                        @error('sms_api_secret')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-0">
                                    <label for="sms_from_number" class="form-label">From Number</label>
                                    <input type="text" class="form-control @error('sms_from_number') is-invalid @enderror"
                                           id="sms_from_number" name="sms_from_number"
                                           value="{{ old('sms_from_number', $settings->sms_from_number) }}"
                                           placeholder="+1234567890">
                                    <small class="text-muted d-block mt-1">
                                        Phone number registered with your SMS provider (with country code).
                                    </small>
                                    @error('sms_from_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="card bg-light border-0">
                                    <div class="card-body">
                                        <h6 class="fw-bold mb-2"><i class="fas fa-info-circle me-1"></i> SMS Settings</h6>
                                        <p class="small text-muted mb-0">
                                            Configure SMS notifications for order updates, tracking information,
                                            and alerts. Requires a supported SMS provider account.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Payment Tab --}}
                    <div class="tab-pane fade {{ $currentTab === 'payment' ? 'show active' : '' }}" id="payment" role="tabpanel">
                        <div class="row g-4">
                            <div class="col-lg-8">
                                <div class="mb-3">
                                    <label for="payment_environment" class="form-label">Environment</label>
                                    <div class="d-flex gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="payment_environment"
                                                   id="env_sandbox" value="sandbox"
                                                   {{ old('payment_environment', $settings->payment_environment) === 'sandbox' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="env_sandbox">
                                                <i class="fas fa-flask text-warning me-1"></i> Sandbox (Testing)
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="payment_environment"
                                                   id="env_live" value="live"
                                                   {{ old('payment_environment', $settings->payment_environment) === 'live' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="env_live">
                                                <i class="fas fa-globe text-success me-1"></i> Live (Production)
                                            </label>
                                        </div>
                                    </div>
                                    @error('payment_environment')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="card mb-3 border">
                                    <div class="card-header bg-transparent">
                                        <h6 class="fw-bold mb-0"><i class="fab fa-paypal me-1 text-blue"></i> PayPal</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3 mb-md-0">
                                                <label for="paypal_client_id" class="form-label">Client ID</label>
                                                <input type="text" class="form-control @error('paypal_client_id') is-invalid @enderror"
                                                       id="paypal_client_id" name="paypal_client_id"
                                                       value="{{ old('paypal_client_id', $settings->paypal_client_id) }}"
                                                       placeholder="PayPal Client ID">
                                                @error('paypal_client_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label for="paypal_secret" class="form-label">Secret</label>
                                                <input type="password" class="form-control @error('paypal_secret') is-invalid @enderror"
                                                       id="paypal_secret" name="paypal_secret"
                                                       value="{{ old('paypal_secret', $settings->paypal_secret) }}"
                                                       placeholder="PayPal Secret">
                                                @error('paypal_secret')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card mb-3 border">
                                    <div class="card-header bg-transparent">
                                        <h6 class="fw-bold mb-0"><i class="fab fa-stripe me-1 text-purple"></i> Stripe</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4 mb-3 mb-md-0">
                                                <label for="stripe_publishable_key" class="form-label">Publishable Key</label>
                                                <input type="text" class="form-control @error('stripe_publishable_key') is-invalid @enderror"
                                                       id="stripe_publishable_key" name="stripe_publishable_key"
                                                       value="{{ old('stripe_publishable_key', $settings->stripe_publishable_key) }}"
                                                       placeholder="pk_test_...">
                                                @error('stripe_publishable_key')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4 mb-3 mb-md-0">
                                                <label for="stripe_secret_key" class="form-label">Secret Key</label>
                                                <input type="password" class="form-control @error('stripe_secret_key') is-invalid @enderror"
                                                       id="stripe_secret_key" name="stripe_secret_key"
                                                       value="{{ old('stripe_secret_key', $settings->stripe_secret_key) }}"
                                                       placeholder="sk_test_...">
                                                @error('stripe_secret_key')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4">
                                                <label for="stripe_webhook_secret" class="form-label">Webhook Secret</label>
                                                <input type="password" class="form-control @error('stripe_webhook_secret') is-invalid @enderror"
                                                       id="stripe_webhook_secret" name="stripe_webhook_secret"
                                                       value="{{ old('stripe_webhook_secret', $settings->stripe_webhook_secret) }}"
                                                       placeholder="whsec_...">
                                                @error('stripe_webhook_secret')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-0">
                                    <label class="form-label">Payment Methods</label>
                                    <div class="d-flex gap-4">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="cod_enabled"
                                                   name="cod_enabled" value="1"
                                                   {{ old('cod_enabled', $settings->cod_enabled) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="cod_enabled">
                                                <i class="fas fa-money-bill-wave me-1 text-success"></i> Cash on Delivery
                                            </label>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="bank_transfer_enabled"
                                                   name="bank_transfer_enabled" value="1"
                                                   {{ old('bank_transfer_enabled', $settings->bank_transfer_enabled) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="bank_transfer_enabled">
                                                <i class="fas fa-university me-1 text-primary"></i> Bank Transfer
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="card bg-light border-0">
                                    <div class="card-body">
                                        <h6 class="fw-bold mb-2"><i class="fas fa-info-circle me-1"></i> Payment Settings</h6>
                                        <p class="small text-muted mb-0">
                                            Configure payment gateways and methods for your store. Use sandbox mode
                                            for testing before going live. Keep your API credentials secure.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Shipping Tab --}}
                    <div class="tab-pane fade {{ $currentTab === 'shipping' ? 'show active' : '' }}" id="shipping" role="tabpanel">
                        <div class="row g-4">
                            <div class="col-lg-8">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="flat_rate" class="form-label">Flat Shipping Rate ($)</label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" step="0.01" min="0"
                                                   class="form-control @error('flat_rate') is-invalid @enderror"
                                                   id="flat_rate" name="flat_rate"
                                                   value="{{ old('flat_rate', $settings->flat_rate) }}"
                                                   placeholder="10.00">
                                            @error('flat_rate')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <small class="text-muted">Default flat shipping charge for all orders</small>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="free_shipping_threshold" class="form-label">Free Shipping Threshold ($)</label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" step="0.01" min="0"
                                                   class="form-control @error('free_shipping_threshold') is-invalid @enderror"
                                                   id="free_shipping_threshold" name="free_shipping_threshold"
                                                   value="{{ old('free_shipping_threshold', $settings->free_shipping_threshold) }}"
                                                   placeholder="100.00">
                                            @error('free_shipping_threshold')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <small class="text-muted">Orders above this amount get free shipping. Leave empty to disable.</small>
                                    </div>
                                </div>

                                <div class="mb-0">
                                    <label class="form-label">Shipping Methods</label>
                                    <div class="border rounded p-3 bg-light">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-shipping-fast text-primary me-2"></i>
                                            <span>Standard Flat Rate</span>
                                            <span class="ms-auto badge bg-primary">Active</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-gift text-success me-2"></i>
                                            <span>Free Shipping</span>
                                            <span class="ms-auto badge bg-{{ $settings->free_shipping_threshold ? 'success' : 'secondary' }}">
                                                {{ $settings->free_shipping_threshold ? 'Active (over $' . number_format($settings->free_shipping_threshold, 2) . ')' : 'Disabled' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="card bg-light border-0">
                                    <div class="card-body">
                                        <h6 class="fw-bold mb-2"><i class="fas fa-info-circle me-1"></i> Shipping Settings</h6>
                                        <p class="small text-muted mb-0">
                                            Configure your shipping rates and free shipping threshold.
                                            These settings apply to all orders unless overridden by product-specific rules.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Invoice Tab --}}
                    <div class="tab-pane fade {{ $currentTab === 'invoice' ? 'show active' : '' }}" id="invoice" role="tabpanel">
                        <div class="row g-4">
                            <div class="col-lg-8">
                                <div class="mb-3">
                                    <label for="invoice_prefix" class="form-label">Invoice Prefix</label>
                                    <input type="text" class="form-control @error('invoice_prefix') is-invalid @enderror"
                                           id="invoice_prefix" name="invoice_prefix"
                                           value="{{ old('invoice_prefix', $settings->invoice_prefix) }}"
                                           placeholder="INV-">
                                    <small class="text-muted">Prefix for invoice numbers (e.g., INV-0001)</small>
                                    @error('invoice_prefix')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="invoice_show_logo"
                                               name="invoice_show_logo" value="1"
                                               {{ old('invoice_show_logo', $settings->invoice_show_logo) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="invoice_show_logo">
                                            Show logo on invoices
                                        </label>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="invoice_terms" class="form-label">Terms & Conditions</label>
                                    <textarea class="form-control @error('invoice_terms') is-invalid @enderror"
                                              id="invoice_terms" name="invoice_terms" rows="4"
                                              placeholder="Payment terms, return policy, etc.">{{ old('invoice_terms', $settings->invoice_terms) }}</textarea>
                                    <small class="text-muted">Displayed at the bottom of invoices</small>
                                    @error('invoice_terms')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-0">
                                    <label for="invoice_footer" class="form-label">Footer Text</label>
                                    <textarea class="form-control @error('invoice_footer') is-invalid @enderror"
                                              id="invoice_footer" name="invoice_footer" rows="2"
                                              placeholder="Thank you for your business!">{{ old('invoice_footer', $settings->invoice_footer) }}</textarea>
                                    @error('invoice_footer')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="card bg-light border-0">
                                    <div class="card-body">
                                        <h6 class="fw-bold mb-2"><i class="fas fa-info-circle me-1"></i> Invoice Settings</h6>
                                        <p class="small text-muted mb-0">
                                            Customize how your invoices look. The prefix helps you identify your
                                            invoices, and the terms section protects your business.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- SEO Tab --}}
                    <div class="tab-pane fade {{ $currentTab === 'seo' ? 'show active' : '' }}" id="seo" role="tabpanel">
                        <div class="row g-4">
                            <div class="col-lg-8">
                                <h6 class="fw-bold mb-3">Default Meta Tags</h6>

                                <div class="mb-3">
                                    <label for="meta_title" class="form-label">Default Meta Title</label>
                                    <input type="text" class="form-control @error('meta_title') is-invalid @enderror"
                                           id="meta_title" name="meta_title"
                                           value="{{ old('meta_title', $settings->meta_title) }}"
                                           placeholder="Your Site Name">
                                    <small class="text-muted">Recommended: 50-60 characters. Used as fallback when no page-specific title is set.</small>
                                    @error('meta_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="meta_description" class="form-label">Default Meta Description</label>
                                    <textarea class="form-control @error('meta_description') is-invalid @enderror"
                                              id="meta_description" name="meta_description" rows="3"
                                              placeholder="Describe your store...">{{ old('meta_description', $settings->meta_description) }}</textarea>
                                    <small class="text-muted">Recommended: 150-160 characters. Displayed in search results.</small>
                                    @error('meta_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="meta_keywords" class="form-label">Meta Keywords</label>
                                    <input type="text" class="form-control @error('meta_keywords') is-invalid @enderror"
                                           id="meta_keywords" name="meta_keywords"
                                           value="{{ old('meta_keywords', $settings->meta_keywords) }}"
                                           placeholder="keyword1, keyword2, keyword3">
                                    <small class="text-muted">Comma-separated list of keywords</small>
                                    @error('meta_keywords')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="canonical_url" class="form-label">Default Canonical URL</label>
                                    <input type="url" class="form-control @error('canonical_url') is-invalid @enderror"
                                           id="canonical_url" name="canonical_url"
                                           value="{{ old('canonical_url', $settings->canonical_url) }}"
                                           placeholder="{{ url('/') }}">
                                    <small class="text-muted">Default canonical URL for your store</small>
                                    @error('canonical_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="robots" class="form-label">Robots Meta Tag</label>
                                    <select class="form-select @error('robots') is-invalid @enderror"
                                            id="robots" name="robots">
                                        <option value="index,follow" {{ old('robots', $settings->robots) === 'index,follow' ? 'selected' : '' }}>index, follow</option>
                                        <option value="noindex,follow" {{ old('robots', $settings->robots) === 'noindex,follow' ? 'selected' : '' }}>noindex, follow</option>
                                        <option value="index,nofollow" {{ old('robots', $settings->robots) === 'index,nofollow' ? 'selected' : '' }}>index, nofollow</option>
                                        <option value="noindex,nofollow" {{ old('robots', $settings->robots) === 'noindex,nofollow' ? 'selected' : '' }}>noindex, nofollow</option>
                                    </select>
                                    @error('robots')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <hr class="my-4">
                                <h6 class="fw-bold mb-3">Open Graph</h6>

                                <div class="mb-3">
                                    <label for="og_type" class="form-label">Default OG Type</label>
                                    <select class="form-select @error('og_type') is-invalid @enderror"
                                            id="og_type" name="og_type">
                                        <option value="website" {{ old('og_type', $settings->og_type) === 'website' ? 'selected' : '' }}>Website</option>
                                        <option value="article" {{ old('og_type', $settings->og_type) === 'article' ? 'selected' : '' }}>Article</option>
                                        <option value="product" {{ old('og_type', $settings->og_type) === 'product' ? 'selected' : '' }}>Product</option>
                                        <option value="store" {{ old('og_type', $settings->og_type) === 'store' ? 'selected' : '' }}>Store</option>
                                    </select>
                                    @error('og_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Default OG Image</label>
                                    @if($settings->og_image)
                                        <div class="border rounded p-2 mb-2 d-inline-block">
                                            <img src="{{ Storage::url($settings->og_image) }}"
                                                 alt="OG Image" style="max-height: 80px;">
                                        </div>
                                        <div class="mb-2">
                                            <button type="button" class="btn btn-sm btn-outline-danger"
                                                    onclick="event.preventDefault(); document.getElementById('removeOgImageForm').submit();">
                                                <i class="fas fa-trash me-1"></i> Remove Image
                                            </button>
                                        </div>
                                    @endif
                                    <input type="file" class="form-control @error('og_image') is-invalid @enderror"
                                           id="og_image" name="og_image" accept="image/*">
                                    <small class="text-muted d-block mt-1">Recommended: 1200x630px. Used when sharing links on social media.</small>
                                    @error('og_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="schema_markup" class="form-label">Default Schema Markup (JSON-LD)</label>
                                    <textarea class="form-control font-monospace @error('schema_markup') is-invalid @enderror"
                                              id="schema_markup" name="schema_markup" rows="6"
                                              placeholder='{ "@@context": "https://schema.org", ... }'>{{ old('schema_markup', $settings->schema_markup) }}</textarea>
                                    <small class="text-muted">Custom JSON-LD structured data added to all pages</small>
                                    @error('schema_markup')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <hr class="my-4">
                                <h6 class="fw-bold mb-3">Tracking & Analytics</h6>

                                <div class="row mb-0">
                                    <div class="col-md-6">
                                        <label for="google_analytics_id" class="form-label">Google Analytics ID</label>
                                        <input type="text" class="form-control @error('google_analytics_id') is-invalid @enderror"
                                               id="google_analytics_id" name="google_analytics_id"
                                               value="{{ old('google_analytics_id', $settings->google_analytics_id) }}"
                                               placeholder="G-XXXXXXXXXX">
                                        <small class="text-muted">Measurement ID for Google Analytics 4</small>
                                        @error('google_analytics_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="google_tag_manager_id" class="form-label">Google Tag Manager ID</label>
                                        <input type="text" class="form-control @error('google_tag_manager_id') is-invalid @enderror"
                                               id="google_tag_manager_id" name="google_tag_manager_id"
                                               value="{{ old('google_tag_manager_id', $settings->google_tag_manager_id) }}"
                                               placeholder="GTM-XXXXXXX">
                                        <small class="text-muted">Container ID for Google Tag Manager</small>
                                        @error('google_tag_manager_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="card bg-light border-0">
                                    <div class="card-body">
                                        <h6 class="fw-bold mb-2"><i class="fas fa-info-circle me-1"></i> SEO Settings</h6>
                                        <p class="small text-muted mb-0">
                                            Configure default SEO metadata for your store. These values serve as
                                            fallbacks when individual pages don't have their own SEO settings set.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Social Media Tab --}}
                    <div class="tab-pane fade {{ $currentTab === 'social' ? 'show active' : '' }}" id="social" role="tabpanel">
                        <div class="row g-4">
                            <div class="col-lg-8">
                                <p class="text-muted small mb-3">
                                    Add your social media profile URLs. These will appear in your store footer
                                    and any social sharing widgets.
                                </p>

                                @php
                                    $socials = [
                                        'social_facebook' => ['label' => 'Facebook', 'icon' => 'fab fa-facebook', 'color' => '#1877F2', 'placeholder' => 'https://facebook.com/yourpage'],
                                        'social_twitter' => ['label' => 'Twitter / X', 'icon' => 'fab fa-twitter', 'color' => '#1DA1F2', 'placeholder' => 'https://twitter.com/yourhandle'],
                                        'social_instagram' => ['label' => 'Instagram', 'icon' => 'fab fa-instagram', 'color' => '#E4405F', 'placeholder' => 'https://instagram.com/yourhandle'],
                                        'social_youtube' => ['label' => 'YouTube', 'icon' => 'fab fa-youtube', 'color' => '#FF0000', 'placeholder' => 'https://youtube.com/@yourchannel'],
                                        'social_linkedin' => ['label' => 'LinkedIn', 'icon' => 'fab fa-linkedin', 'color' => '#0A66C2', 'placeholder' => 'https://linkedin.com/company/yourcompany'],
                                        'social_pinterest' => ['label' => 'Pinterest', 'icon' => 'fab fa-pinterest', 'color' => '#BD081C', 'placeholder' => 'https://pinterest.com/yourhandle'],
                                        'social_tiktok' => ['label' => 'TikTok', 'icon' => 'fab fa-tiktok', 'color' => '#000000', 'placeholder' => 'https://tiktok.com/@yourhandle'],
                                        'social_whatsapp' => ['label' => 'WhatsApp', 'icon' => 'fab fa-whatsapp', 'color' => '#25D366', 'placeholder' => 'https://wa.me/1234567890'],
                                    ];
                                @endphp

                                @foreach($socials as $key => $social)
                                    <div class="mb-3">
                                        <label for="{{ $key }}" class="form-label">
                                            <i class="{{ $social['icon'] }}" style="color: {{ $social['color'] }}"></i>
                                            {{ $social['label'] }}
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="{{ $social['icon'] }}"></i></span>
                                            <input type="url" class="form-control @error($key) is-invalid @enderror"
                                                   id="{{ $key }}" name="{{ $key }}"
                                                   value="{{ old($key, $settings->$key) }}"
                                                   placeholder="{{ $social['placeholder'] }}">
                                            @error($key)
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="col-lg-4">
                                <div class="card bg-light border-0">
                                    <div class="card-body">
                                        <h6 class="fw-bold mb-2"><i class="fas fa-info-circle me-1"></i> Social Media</h6>
                                        <p class="small text-muted mb-0">
                                            Link your social media profiles to increase your online presence.
                                            These links will appear in your store footer and help customers
                                            connect with you on their preferred platforms.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-top d-flex justify-content-between align-items-center">
                    <div>
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save me-2"></i> Save Settings
                        </button>
                    </div>
                    <small class="text-muted">
                        <i class="fas fa-clock me-1"></i> Last updated: {{ $settings->updated_at ? $settings->updated_at->format('M d, Y H:i') : 'Never' }}
                    </small>
                </div>
            </form>

            {{-- Remove forms --}}
            <form id="removeLogoForm" method="POST" action="{{ route('admin.settings.remove-logo') }}" class="d-none">
                @csrf
            </form>
            <form id="removeFaviconForm" method="POST" action="{{ route('admin.settings.remove-favicon') }}" class="d-none">
                @csrf
            </form>
            <form id="removeOgImageForm" method="POST" action="{{ route('admin.settings.remove-og-image') }}" class="d-none">
                @csrf
            </form>
        </div>
    </div>
</x-layouts.admin-layout>

@push('scripts')
<script>
    document.querySelectorAll('[data-bs-toggle="tab"]').forEach(tab => {
        tab.addEventListener('shown.bs.tab', function (e) {
            document.getElementById('currentTab').value = e.target.dataset.bsTarget.replace('#', '');
            const url = new URL(window.location);
            url.searchParams.set('tab', e.target.dataset.bsTarget.replace('#', ''));
            window.history.replaceState({}, '', url);
        });
    });
</script>
@endpush
