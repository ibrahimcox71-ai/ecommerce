<?php if (isset($component)) { $__componentOriginaledc75c655a063d12a477f2c8d8f324fc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc = $attributes; } ?>
<?php $component = App\View\Components\Layouts\AdminLayout::resolve(['title' => 'Settings'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <?php
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
    ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Settings</h4>
            <p class="text-muted small mb-0">Manage your store configuration</p>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-transparent p-0">
            <ul class="nav nav-tabs" id="settingsTabs" role="tablist">
                <?php $__currentLoopData = $tabs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $tab): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link <?php echo e($currentTab === $key ? 'active' : ''); ?>"
                                id="<?php echo e($key); ?>-tab"
                                data-bs-toggle="tab"
                                data-bs-target="#<?php echo e($key); ?>"
                                type="button"
                                role="tab"
                                aria-controls="<?php echo e($key); ?>"
                                aria-selected="<?php echo e($currentTab === $key ? 'true' : 'false'); ?>">
                            <i class="<?php echo e($tab['icon']); ?> me-1"></i>
                            <?php echo e($tab['label']); ?>

                        </button>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>

        <div class="card-body">
            <form method="POST" action="<?php echo e(route('admin.settings.update')); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="_tab" id="currentTab" value="<?php echo e($currentTab); ?>">

                <div class="tab-content" id="settingsTabContent">
                    
                    <div class="tab-pane fade <?php echo e($currentTab === 'general' ? 'show active' : ''); ?>" id="general" role="tabpanel">
                        <div class="row g-4">
                            <div class="col-lg-8">
                                <div class="mb-3">
                                    <label for="site_name" class="form-label">Site Name</label>
                                    <input type="text" class="form-control <?php $__errorArgs = ['site_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           id="site_name" name="site_name" value="<?php echo e(old('site_name', $settings->site_name)); ?>"
                                           placeholder="Your store name">
                                    <?php $__errorArgs = ['site_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="mb-3">
                                    <label for="tagline" class="form-label">Tagline</label>
                                    <input type="text" class="form-control <?php $__errorArgs = ['tagline'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           id="tagline" name="tagline" value="<?php echo e(old('tagline', $settings->tagline)); ?>"
                                           placeholder="Short description of your store">
                                    <?php $__errorArgs = ['tagline'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="default_currency" class="form-label">Currency</label>
                                        <select class="form-select <?php $__errorArgs = ['default_currency'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                id="default_currency" name="default_currency">
                                            <option value="">Select currency</option>
                                            <?php $__currentLoopData = ['USD' => 'US Dollar', 'EUR' => 'Euro', 'GBP' => 'British Pound', 'INR' => 'Indian Rupee', 'CAD' => 'Canadian Dollar', 'AUD' => 'Australian Dollar', 'JPY' => 'Japanese Yen', 'CNY' => 'Chinese Yuan', 'BRL' => 'Brazilian Real', 'MXN' => 'Mexican Peso', 'AED' => 'UAE Dirham', 'SAR' => 'Saudi Riyal']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($code); ?>" <?php echo e(old('default_currency', $settings->default_currency) === $code ? 'selected' : ''); ?>><?php echo e($name); ?> (<?php echo e($code); ?>)</option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <?php $__errorArgs = ['default_currency'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="currency_symbol" class="form-label">Currency Symbol</label>
                                        <input type="text" class="form-control <?php $__errorArgs = ['currency_symbol'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               id="currency_symbol" name="currency_symbol"
                                               value="<?php echo e(old('currency_symbol', $settings->currency_symbol)); ?>"
                                               placeholder="$" maxlength="10">
                                        <?php $__errorArgs = ['currency_symbol'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="tax_rate" class="form-label">Tax Rate (%)</label>
                                        <input type="number" step="0.01" min="0" max="100"
                                               class="form-control <?php $__errorArgs = ['tax_rate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               id="tax_rate" name="tax_rate"
                                               value="<?php echo e(old('tax_rate', $settings->tax_rate)); ?>"
                                               placeholder="0">
                                        <?php $__errorArgs = ['tax_rate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>

                                <div class="row mb-0">
                                    <div class="col-md-6">
                                        <label for="timezone" class="form-label">Timezone</label>
                                        <select class="form-select <?php $__errorArgs = ['timezone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                id="timezone" name="timezone">
                                            <?php $__currentLoopData = timezone_identifiers_list(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tz): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($tz); ?>" <?php echo e(old('timezone', $settings->timezone) === $tz ? 'selected' : ''); ?>><?php echo e($tz); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <?php $__errorArgs = ['timezone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="language" class="form-label">Language</label>
                                        <select class="form-select <?php $__errorArgs = ['language'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                id="language" name="language">
                                            <option value="en" <?php echo e(old('language', $settings->language) === 'en' ? 'selected' : ''); ?>>English</option>
                                            <option value="ar" <?php echo e(old('language', $settings->language) === 'ar' ? 'selected' : ''); ?>>العربية</option>
                                            <option value="fr" <?php echo e(old('language', $settings->language) === 'fr' ? 'selected' : ''); ?>>Français</option>
                                            <option value="es" <?php echo e(old('language', $settings->language) === 'es' ? 'selected' : ''); ?>>Español</option>
                                            <option value="de" <?php echo e(old('language', $settings->language) === 'de' ? 'selected' : ''); ?>>Deutsch</option>
                                            <option value="tr" <?php echo e(old('language', $settings->language) === 'tr' ? 'selected' : ''); ?>>Türkçe</option>
                                            <option value="ur" <?php echo e(old('language', $settings->language) === 'ur' ? 'selected' : ''); ?>>اردو</option>
                                        </select>
                                        <?php $__errorArgs = ['language'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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

                    
                    <div class="tab-pane fade <?php echo e($currentTab === 'logo' ? 'show active' : ''); ?>" id="logo" role="tabpanel">
                        <div class="row g-4">
                            <div class="col-lg-8">
                                <div class="mb-3">
                                    <label class="form-label">Current Logo</label>
                                    <?php if($settings->logo): ?>
                                        <div class="border rounded p-4 mb-2 text-center bg-light">
                                            <img src="<?php echo e(Storage::url($settings->logo)); ?>"
                                                 alt="Store Logo" class="img-fluid"
                                                 style="max-height: 120px;">
                                        </div>
                                        <div class="d-flex gap-2">
                                            <button type="button" class="btn btn-sm btn-outline-danger"
                                                    onclick="event.preventDefault(); document.getElementById('removeLogoForm').submit();">
                                                <i class="fas fa-trash me-1"></i> Remove Logo
                                            </button>
                                        </div>
                                    <?php else: ?>
                                        <div class="border rounded p-4 mb-2 text-center bg-light">
                                            <i class="fas fa-image fa-3x text-muted"></i>
                                            <p class="text-muted small mt-2 mb-0">No logo uploaded</p>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="mb-0">
                                    <label for="logo" class="form-label">Upload New Logo</label>
                                    <input type="file" class="form-control <?php $__errorArgs = ['logo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           id="logo" name="logo" accept="image/*">
                                    <small class="text-muted d-block mt-1">
                                        Recommended: 200x60px. Supported: JPG, PNG, WEBP, SVG. Max 2MB.
                                    </small>
                                    <?php $__errorArgs = ['logo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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

                    
                    <div class="tab-pane fade <?php echo e($currentTab === 'favicon' ? 'show active' : ''); ?>" id="favicon" role="tabpanel">
                        <div class="row g-4">
                            <div class="col-lg-8">
                                <div class="mb-3">
                                    <label class="form-label">Current Favicon</label>
                                    <?php if($settings->favicon): ?>
                                        <div class="border rounded p-4 mb-2 text-center bg-light" style="max-width: 200px;">
                                            <img src="<?php echo e(Storage::url($settings->favicon)); ?>"
                                                 alt="Favicon" style="max-height: 64px;">
                                        </div>
                                        <div class="d-flex gap-2">
                                            <button type="button" class="btn btn-sm btn-outline-danger"
                                                    onclick="event.preventDefault(); document.getElementById('removeFaviconForm').submit();">
                                                <i class="fas fa-trash me-1"></i> Remove Favicon
                                            </button>
                                        </div>
                                    <?php else: ?>
                                        <div class="border rounded p-4 mb-2 text-center bg-light" style="max-width: 200px;">
                                            <i class="fas fa-star fa-3x text-muted"></i>
                                            <p class="text-muted small mt-2 mb-0">No favicon uploaded</p>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="mb-0">
                                    <label for="favicon" class="form-label">Upload New Favicon</label>
                                    <input type="file" class="form-control <?php $__errorArgs = ['favicon'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           id="favicon" name="favicon" accept=".ico,.png,.jpg,.jpeg,.webp,.svg">
                                    <small class="text-muted d-block mt-1">
                                        Recommended: 32x32px or 16x16px. Supported: ICO, PNG, JPG, SVG. Max 1MB.
                                    </small>
                                    <?php $__errorArgs = ['favicon'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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

                    
                    <div class="tab-pane fade <?php echo e($currentTab === 'email' ? 'show active' : ''); ?>" id="email" role="tabpanel">
                        <div class="row g-4">
                            <div class="col-lg-8">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="mail_mailer" class="form-label">Mail Driver</label>
                                        <select class="form-select <?php $__errorArgs = ['mail_mailer'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                id="mail_mailer" name="mail_mailer">
                                            <option value="smtp" <?php echo e(old('mail_mailer', $settings->mail_mailer) === 'smtp' ? 'selected' : ''); ?>>SMTP</option>
                                            <option value="sendmail" <?php echo e(old('mail_mailer', $settings->mail_mailer) === 'sendmail' ? 'selected' : ''); ?>>Sendmail</option>
                                            <option value="mailgun" <?php echo e(old('mail_mailer', $settings->mail_mailer) === 'mailgun' ? 'selected' : ''); ?>>Mailgun</option>
                                            <option value="postmark" <?php echo e(old('mail_mailer', $settings->mail_mailer) === 'postmark' ? 'selected' : ''); ?>>Postmark</option>
                                            <option value="ses" <?php echo e(old('mail_mailer', $settings->mail_mailer) === 'ses' ? 'selected' : ''); ?>>Amazon SES</option>
                                            <option value="log" <?php echo e(old('mail_mailer', $settings->mail_mailer) === 'log' ? 'selected' : ''); ?>>Log (local testing)</option>
                                        </select>
                                        <?php $__errorArgs = ['mail_mailer'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="mail_host" class="form-label">SMTP Host</label>
                                        <input type="text" class="form-control <?php $__errorArgs = ['mail_host'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               id="mail_host" name="mail_host"
                                               value="<?php echo e(old('mail_host', $settings->mail_host)); ?>"
                                               placeholder="smtp.example.com">
                                        <?php $__errorArgs = ['mail_host'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="mail_port" class="form-label">SMTP Port</label>
                                        <input type="text" class="form-control <?php $__errorArgs = ['mail_port'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               id="mail_port" name="mail_port"
                                               value="<?php echo e(old('mail_port', $settings->mail_port)); ?>"
                                               placeholder="587">
                                        <?php $__errorArgs = ['mail_port'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="mail_username" class="form-label">SMTP Username</label>
                                        <input type="text" class="form-control <?php $__errorArgs = ['mail_username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               id="mail_username" name="mail_username"
                                               value="<?php echo e(old('mail_username', $settings->mail_username)); ?>"
                                               placeholder="your@email.com">
                                        <?php $__errorArgs = ['mail_username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="mail_password" class="form-label">SMTP Password</label>
                                        <input type="password" class="form-control <?php $__errorArgs = ['mail_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               id="mail_password" name="mail_password"
                                               value="<?php echo e(old('mail_password', $settings->mail_password)); ?>"
                                               placeholder="Enter password">
                                        <?php $__errorArgs = ['mail_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="mail_encryption" class="form-label">Encryption</label>
                                        <select class="form-select <?php $__errorArgs = ['mail_encryption'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                id="mail_encryption" name="mail_encryption">
                                            <option value="">None</option>
                                            <option value="tls" <?php echo e(old('mail_encryption', $settings->mail_encryption) === 'tls' ? 'selected' : ''); ?>>TLS</option>
                                            <option value="ssl" <?php echo e(old('mail_encryption', $settings->mail_encryption) === 'ssl' ? 'selected' : ''); ?>>SSL</option>
                                        </select>
                                        <?php $__errorArgs = ['mail_encryption'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="mail_from_address" class="form-label">From Address</label>
                                        <input type="email" class="form-control <?php $__errorArgs = ['mail_from_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               id="mail_from_address" name="mail_from_address"
                                               value="<?php echo e(old('mail_from_address', $settings->mail_from_address)); ?>"
                                               placeholder="noreply@example.com">
                                        <?php $__errorArgs = ['mail_from_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="mail_from_name" class="form-label">From Name</label>
                                        <input type="text" class="form-control <?php $__errorArgs = ['mail_from_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               id="mail_from_name" name="mail_from_name"
                                               value="<?php echo e(old('mail_from_name', $settings->mail_from_name)); ?>"
                                               placeholder="Your Store Name">
                                        <?php $__errorArgs = ['mail_from_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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

                    
                    <div class="tab-pane fade <?php echo e($currentTab === 'sms' ? 'show active' : ''); ?>" id="sms" role="tabpanel">
                        <div class="row g-4">
                            <div class="col-lg-8">
                                <div class="mb-3">
                                    <label for="sms_provider" class="form-label">SMS Provider</label>
                                    <select class="form-select <?php $__errorArgs = ['sms_provider'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            id="sms_provider" name="sms_provider">
                                        <option value="">Select provider</option>
                                        <option value="twilio" <?php echo e(old('sms_provider', $settings->sms_provider) === 'twilio' ? 'selected' : ''); ?>>Twilio</option>
                                        <option value="vonage" <?php echo e(old('sms_provider', $settings->sms_provider) === 'vonage' ? 'selected' : ''); ?>>Vonage (Nexmo)</option>
                                        <option value="aws" <?php echo e(old('sms_provider', $settings->sms_provider) === 'aws' ? 'selected' : ''); ?>>Amazon SNS</option>
                                        <option value="clickatell" <?php echo e(old('sms_provider', $settings->sms_provider) === 'clickatell' ? 'selected' : ''); ?>>Clickatell</option>
                                        <option value="msg91" <?php echo e(old('sms_provider', $settings->sms_provider) === 'msg91' ? 'selected' : ''); ?>>MSG91</option>
                                        <option value="nexmo" <?php echo e(old('sms_provider', $settings->sms_provider) === 'nexmo' ? 'selected' : ''); ?>>Nexmo</option>
                                    </select>
                                    <?php $__errorArgs = ['sms_provider'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="sms_api_key" class="form-label">API Key / SID</label>
                                        <input type="text" class="form-control <?php $__errorArgs = ['sms_api_key'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               id="sms_api_key" name="sms_api_key"
                                               value="<?php echo e(old('sms_api_key', $settings->sms_api_key)); ?>"
                                               placeholder="Enter API key">
                                        <?php $__errorArgs = ['sms_api_key'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="sms_api_secret" class="form-label">API Secret / Token</label>
                                        <input type="password" class="form-control <?php $__errorArgs = ['sms_api_secret'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               id="sms_api_secret" name="sms_api_secret"
                                               value="<?php echo e(old('sms_api_secret', $settings->sms_api_secret)); ?>"
                                               placeholder="Enter API secret">
                                        <?php $__errorArgs = ['sms_api_secret'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>

                                <div class="mb-0">
                                    <label for="sms_from_number" class="form-label">From Number</label>
                                    <input type="text" class="form-control <?php $__errorArgs = ['sms_from_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           id="sms_from_number" name="sms_from_number"
                                           value="<?php echo e(old('sms_from_number', $settings->sms_from_number)); ?>"
                                           placeholder="+1234567890">
                                    <small class="text-muted d-block mt-1">
                                        Phone number registered with your SMS provider (with country code).
                                    </small>
                                    <?php $__errorArgs = ['sms_from_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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

                    
                    <div class="tab-pane fade <?php echo e($currentTab === 'payment' ? 'show active' : ''); ?>" id="payment" role="tabpanel">
                        <div class="row g-4">
                            <div class="col-lg-8">
                                <div class="mb-3">
                                    <label for="payment_environment" class="form-label">Environment</label>
                                    <div class="d-flex gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="payment_environment"
                                                   id="env_sandbox" value="sandbox"
                                                   <?php echo e(old('payment_environment', $settings->payment_environment) === 'sandbox' ? 'checked' : ''); ?>>
                                            <label class="form-check-label" for="env_sandbox">
                                                <i class="fas fa-flask text-warning me-1"></i> Sandbox (Testing)
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="payment_environment"
                                                   id="env_live" value="live"
                                                   <?php echo e(old('payment_environment', $settings->payment_environment) === 'live' ? 'checked' : ''); ?>>
                                            <label class="form-check-label" for="env_live">
                                                <i class="fas fa-globe text-success me-1"></i> Live (Production)
                                            </label>
                                        </div>
                                    </div>
                                    <?php $__errorArgs = ['payment_environment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="card mb-3 border">
                                    <div class="card-header bg-transparent">
                                        <h6 class="fw-bold mb-0"><i class="fab fa-paypal me-1 text-blue"></i> PayPal</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3 mb-md-0">
                                                <label for="paypal_client_id" class="form-label">Client ID</label>
                                                <input type="text" class="form-control <?php $__errorArgs = ['paypal_client_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                       id="paypal_client_id" name="paypal_client_id"
                                                       value="<?php echo e(old('paypal_client_id', $settings->paypal_client_id)); ?>"
                                                       placeholder="PayPal Client ID">
                                                <?php $__errorArgs = ['paypal_client_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="paypal_secret" class="form-label">Secret</label>
                                                <input type="password" class="form-control <?php $__errorArgs = ['paypal_secret'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                       id="paypal_secret" name="paypal_secret"
                                                       value="<?php echo e(old('paypal_secret', $settings->paypal_secret)); ?>"
                                                       placeholder="PayPal Secret">
                                                <?php $__errorArgs = ['paypal_secret'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
                                                <input type="text" class="form-control <?php $__errorArgs = ['stripe_publishable_key'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                       id="stripe_publishable_key" name="stripe_publishable_key"
                                                       value="<?php echo e(old('stripe_publishable_key', $settings->stripe_publishable_key)); ?>"
                                                       placeholder="pk_test_...">
                                                <?php $__errorArgs = ['stripe_publishable_key'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                            <div class="col-md-4 mb-3 mb-md-0">
                                                <label for="stripe_secret_key" class="form-label">Secret Key</label>
                                                <input type="password" class="form-control <?php $__errorArgs = ['stripe_secret_key'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                       id="stripe_secret_key" name="stripe_secret_key"
                                                       value="<?php echo e(old('stripe_secret_key', $settings->stripe_secret_key)); ?>"
                                                       placeholder="sk_test_...">
                                                <?php $__errorArgs = ['stripe_secret_key'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="stripe_webhook_secret" class="form-label">Webhook Secret</label>
                                                <input type="password" class="form-control <?php $__errorArgs = ['stripe_webhook_secret'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                       id="stripe_webhook_secret" name="stripe_webhook_secret"
                                                       value="<?php echo e(old('stripe_webhook_secret', $settings->stripe_webhook_secret)); ?>"
                                                       placeholder="whsec_...">
                                                <?php $__errorArgs = ['stripe_webhook_secret'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
                                                   <?php echo e(old('cod_enabled', $settings->cod_enabled) ? 'checked' : ''); ?>>
                                            <label class="form-check-label" for="cod_enabled">
                                                <i class="fas fa-money-bill-wave me-1 text-success"></i> Cash on Delivery
                                            </label>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="bank_transfer_enabled"
                                                   name="bank_transfer_enabled" value="1"
                                                   <?php echo e(old('bank_transfer_enabled', $settings->bank_transfer_enabled) ? 'checked' : ''); ?>>
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

                    
                    <div class="tab-pane fade <?php echo e($currentTab === 'shipping' ? 'show active' : ''); ?>" id="shipping" role="tabpanel">
                        <div class="row g-4">
                            <div class="col-lg-8">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="flat_rate" class="form-label">Flat Shipping Rate ($)</label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" step="0.01" min="0"
                                                   class="form-control <?php $__errorArgs = ['flat_rate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                   id="flat_rate" name="flat_rate"
                                                   value="<?php echo e(old('flat_rate', $settings->flat_rate)); ?>"
                                                   placeholder="10.00">
                                            <?php $__errorArgs = ['flat_rate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                        <small class="text-muted">Default flat shipping charge for all orders</small>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="free_shipping_threshold" class="form-label">Free Shipping Threshold ($)</label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" step="0.01" min="0"
                                                   class="form-control <?php $__errorArgs = ['free_shipping_threshold'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                   id="free_shipping_threshold" name="free_shipping_threshold"
                                                   value="<?php echo e(old('free_shipping_threshold', $settings->free_shipping_threshold)); ?>"
                                                   placeholder="100.00">
                                            <?php $__errorArgs = ['free_shipping_threshold'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
                                            <span class="ms-auto badge bg-<?php echo e($settings->free_shipping_threshold ? 'success' : 'secondary'); ?>">
                                                <?php echo e($settings->free_shipping_threshold ? 'Active (over $' . number_format($settings->free_shipping_threshold, 2) . ')' : 'Disabled'); ?>

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

                    
                    <div class="tab-pane fade <?php echo e($currentTab === 'invoice' ? 'show active' : ''); ?>" id="invoice" role="tabpanel">
                        <div class="row g-4">
                            <div class="col-lg-8">
                                <div class="mb-3">
                                    <label for="invoice_prefix" class="form-label">Invoice Prefix</label>
                                    <input type="text" class="form-control <?php $__errorArgs = ['invoice_prefix'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           id="invoice_prefix" name="invoice_prefix"
                                           value="<?php echo e(old('invoice_prefix', $settings->invoice_prefix)); ?>"
                                           placeholder="INV-">
                                    <small class="text-muted">Prefix for invoice numbers (e.g., INV-0001)</small>
                                    <?php $__errorArgs = ['invoice_prefix'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="invoice_show_logo"
                                               name="invoice_show_logo" value="1"
                                               <?php echo e(old('invoice_show_logo', $settings->invoice_show_logo) ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="invoice_show_logo">
                                            Show logo on invoices
                                        </label>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="invoice_terms" class="form-label">Terms & Conditions</label>
                                    <textarea class="form-control <?php $__errorArgs = ['invoice_terms'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                              id="invoice_terms" name="invoice_terms" rows="4"
                                              placeholder="Payment terms, return policy, etc."><?php echo e(old('invoice_terms', $settings->invoice_terms)); ?></textarea>
                                    <small class="text-muted">Displayed at the bottom of invoices</small>
                                    <?php $__errorArgs = ['invoice_terms'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="mb-0">
                                    <label for="invoice_footer" class="form-label">Footer Text</label>
                                    <textarea class="form-control <?php $__errorArgs = ['invoice_footer'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                              id="invoice_footer" name="invoice_footer" rows="2"
                                              placeholder="Thank you for your business!"><?php echo e(old('invoice_footer', $settings->invoice_footer)); ?></textarea>
                                    <?php $__errorArgs = ['invoice_footer'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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

                    
                    <div class="tab-pane fade <?php echo e($currentTab === 'seo' ? 'show active' : ''); ?>" id="seo" role="tabpanel">
                        <div class="row g-4">
                            <div class="col-lg-8">
                                <h6 class="fw-bold mb-3">Default Meta Tags</h6>

                                <div class="mb-3">
                                    <label for="meta_title" class="form-label">Default Meta Title</label>
                                    <input type="text" class="form-control <?php $__errorArgs = ['meta_title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           id="meta_title" name="meta_title"
                                           value="<?php echo e(old('meta_title', $settings->meta_title)); ?>"
                                           placeholder="Your Site Name">
                                    <small class="text-muted">Recommended: 50-60 characters. Used as fallback when no page-specific title is set.</small>
                                    <?php $__errorArgs = ['meta_title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="mb-3">
                                    <label for="meta_description" class="form-label">Default Meta Description</label>
                                    <textarea class="form-control <?php $__errorArgs = ['meta_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                              id="meta_description" name="meta_description" rows="3"
                                              placeholder="Describe your store..."><?php echo e(old('meta_description', $settings->meta_description)); ?></textarea>
                                    <small class="text-muted">Recommended: 150-160 characters. Displayed in search results.</small>
                                    <?php $__errorArgs = ['meta_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="mb-3">
                                    <label for="meta_keywords" class="form-label">Meta Keywords</label>
                                    <input type="text" class="form-control <?php $__errorArgs = ['meta_keywords'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           id="meta_keywords" name="meta_keywords"
                                           value="<?php echo e(old('meta_keywords', $settings->meta_keywords)); ?>"
                                           placeholder="keyword1, keyword2, keyword3">
                                    <small class="text-muted">Comma-separated list of keywords</small>
                                    <?php $__errorArgs = ['meta_keywords'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="mb-3">
                                    <label for="canonical_url" class="form-label">Default Canonical URL</label>
                                    <input type="url" class="form-control <?php $__errorArgs = ['canonical_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           id="canonical_url" name="canonical_url"
                                           value="<?php echo e(old('canonical_url', $settings->canonical_url)); ?>"
                                           placeholder="<?php echo e(url('/')); ?>">
                                    <small class="text-muted">Default canonical URL for your store</small>
                                    <?php $__errorArgs = ['canonical_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="mb-3">
                                    <label for="robots" class="form-label">Robots Meta Tag</label>
                                    <select class="form-select <?php $__errorArgs = ['robots'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            id="robots" name="robots">
                                        <option value="index,follow" <?php echo e(old('robots', $settings->robots) === 'index,follow' ? 'selected' : ''); ?>>index, follow</option>
                                        <option value="noindex,follow" <?php echo e(old('robots', $settings->robots) === 'noindex,follow' ? 'selected' : ''); ?>>noindex, follow</option>
                                        <option value="index,nofollow" <?php echo e(old('robots', $settings->robots) === 'index,nofollow' ? 'selected' : ''); ?>>index, nofollow</option>
                                        <option value="noindex,nofollow" <?php echo e(old('robots', $settings->robots) === 'noindex,nofollow' ? 'selected' : ''); ?>>noindex, nofollow</option>
                                    </select>
                                    <?php $__errorArgs = ['robots'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <hr class="my-4">
                                <h6 class="fw-bold mb-3">Open Graph</h6>

                                <div class="mb-3">
                                    <label for="og_type" class="form-label">Default OG Type</label>
                                    <select class="form-select <?php $__errorArgs = ['og_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            id="og_type" name="og_type">
                                        <option value="website" <?php echo e(old('og_type', $settings->og_type) === 'website' ? 'selected' : ''); ?>>Website</option>
                                        <option value="article" <?php echo e(old('og_type', $settings->og_type) === 'article' ? 'selected' : ''); ?>>Article</option>
                                        <option value="product" <?php echo e(old('og_type', $settings->og_type) === 'product' ? 'selected' : ''); ?>>Product</option>
                                        <option value="store" <?php echo e(old('og_type', $settings->og_type) === 'store' ? 'selected' : ''); ?>>Store</option>
                                    </select>
                                    <?php $__errorArgs = ['og_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Default OG Image</label>
                                    <?php if($settings->og_image): ?>
                                        <div class="border rounded p-2 mb-2 d-inline-block">
                                            <img src="<?php echo e(Storage::url($settings->og_image)); ?>"
                                                 alt="OG Image" style="max-height: 80px;">
                                        </div>
                                        <div class="mb-2">
                                            <button type="button" class="btn btn-sm btn-outline-danger"
                                                    onclick="event.preventDefault(); document.getElementById('removeOgImageForm').submit();">
                                                <i class="fas fa-trash me-1"></i> Remove Image
                                            </button>
                                        </div>
                                    <?php endif; ?>
                                    <input type="file" class="form-control <?php $__errorArgs = ['og_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           id="og_image" name="og_image" accept="image/*">
                                    <small class="text-muted d-block mt-1">Recommended: 1200x630px. Used when sharing links on social media.</small>
                                    <?php $__errorArgs = ['og_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="mb-3">
                                    <label for="schema_markup" class="form-label">Default Schema Markup (JSON-LD)</label>
                                    <textarea class="form-control font-monospace <?php $__errorArgs = ['schema_markup'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                              id="schema_markup" name="schema_markup" rows="6"
                                              placeholder='{ "@context": "https://schema.org", ... }'><?php echo e(old('schema_markup', $settings->schema_markup)); ?></textarea>
                                    <small class="text-muted">Custom JSON-LD structured data added to all pages</small>
                                    <?php $__errorArgs = ['schema_markup'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <hr class="my-4">
                                <h6 class="fw-bold mb-3">Tracking & Analytics</h6>

                                <div class="row mb-0">
                                    <div class="col-md-6">
                                        <label for="google_analytics_id" class="form-label">Google Analytics ID</label>
                                        <input type="text" class="form-control <?php $__errorArgs = ['google_analytics_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               id="google_analytics_id" name="google_analytics_id"
                                               value="<?php echo e(old('google_analytics_id', $settings->google_analytics_id)); ?>"
                                               placeholder="G-XXXXXXXXXX">
                                        <small class="text-muted">Measurement ID for Google Analytics 4</small>
                                        <?php $__errorArgs = ['google_analytics_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="google_tag_manager_id" class="form-label">Google Tag Manager ID</label>
                                        <input type="text" class="form-control <?php $__errorArgs = ['google_tag_manager_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               id="google_tag_manager_id" name="google_tag_manager_id"
                                               value="<?php echo e(old('google_tag_manager_id', $settings->google_tag_manager_id)); ?>"
                                               placeholder="GTM-XXXXXXX">
                                        <small class="text-muted">Container ID for Google Tag Manager</small>
                                        <?php $__errorArgs = ['google_tag_manager_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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

                    
                    <div class="tab-pane fade <?php echo e($currentTab === 'social' ? 'show active' : ''); ?>" id="social" role="tabpanel">
                        <div class="row g-4">
                            <div class="col-lg-8">
                                <p class="text-muted small mb-3">
                                    Add your social media profile URLs. These will appear in your store footer
                                    and any social sharing widgets.
                                </p>

                                <?php
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
                                ?>

                                <?php $__currentLoopData = $socials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $social): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="mb-3">
                                        <label for="<?php echo e($key); ?>" class="form-label">
                                            <i class="<?php echo e($social['icon']); ?>" style="color: <?php echo e($social['color']); ?>"></i>
                                            <?php echo e($social['label']); ?>

                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="<?php echo e($social['icon']); ?>"></i></span>
                                            <input type="url" class="form-control <?php $__errorArgs = [$key];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                   id="<?php echo e($key); ?>" name="<?php echo e($key); ?>"
                                                   value="<?php echo e(old($key, $settings->$key)); ?>"
                                                   placeholder="<?php echo e($social['placeholder']); ?>">
                                            <?php $__errorArgs = [$key];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                        <i class="fas fa-clock me-1"></i> Last updated: <?php echo e($settings->updated_at ? $settings->updated_at->format('M d, Y H:i') : 'Never'); ?>

                    </small>
                </div>
            </form>

            
            <form id="removeLogoForm" method="POST" action="<?php echo e(route('admin.settings.remove-logo')); ?>" class="d-none">
                <?php echo csrf_field(); ?>
            </form>
            <form id="removeFaviconForm" method="POST" action="<?php echo e(route('admin.settings.remove-favicon')); ?>" class="d-none">
                <?php echo csrf_field(); ?>
            </form>
            <form id="removeOgImageForm" method="POST" action="<?php echo e(route('admin.settings.remove-og-image')); ?>" class="d-none">
                <?php echo csrf_field(); ?>
            </form>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaledc75c655a063d12a477f2c8d8f324fc)): ?>
<?php $attributes = $__attributesOriginaledc75c655a063d12a477f2c8d8f324fc; ?>
<?php unset($__attributesOriginaledc75c655a063d12a477f2c8d8f324fc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaledc75c655a063d12a477f2c8d8f324fc)): ?>
<?php $component = $__componentOriginaledc75c655a063d12a477f2c8d8f324fc; ?>
<?php unset($__componentOriginaledc75c655a063d12a477f2c8d8f324fc); ?>
<?php endif; ?>

<?php $__env->startPush('scripts'); ?>
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
<?php $__env->stopPush(); ?>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\admin\settings\index.blade.php ENDPATH**/ ?>