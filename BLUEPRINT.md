# E-Commerce Platform — BLUEPRINT.md (A to Z)

> This file is the single source of truth for the project. Give it to any AI agent (opencode, Cursor, Copilot, etc.) together with a task, and the agent can work on anything from a tiny bug fix to a full new module without guessing.
>
> **Stack:** Laravel 12 · PHP 8.2 · SQLite (local) · Bootstrap 5.3 · Vite 7 · spatie/laravel-permission · barryvdh/laravel-dompdf ^3.1 · Chart.js 4.4.1 · ApexCharts 3.45.1

---

## 1. What This Project Is

A full-featured e-commerce platform with **two front-ends**:

| Area | URL prefix | Users | Files |
|------|-----------|-------|-------|
| **Storefront (public)** | `/` | Visitors + customers | `routes/web.php`, `routes/seo.php` |
| **Customer account** | `/customer/*` | Logged-in customers (guard: `web`) | `routes/customer.php` |
| **Admin panel** | `/admin/*` | Admins (guard: `admin`) | `routes/admin.php` (~330 routes) |
| **API (stub)** | `/api/v1/*` | Future mobile app | `routes/api.php` |

**Scale:** 64 models · 245 blade views · 34 services · 13 repositories · 17 policies · 97 migrations · 20 enums · 20 PHPUnit feature tests.

**Guards:** `web` (customers) and `admin` (staff). Two separate auth flows in `app/Http/Controllers/Auth/` (CustomerAuthController, AdminAuthController).

---

## 2. Local Environment (Laragon, Windows)

- Domain: `http://ecommerce.test` (Laragon virtual host → `public/`)
- PHP 8.2+ CLI must be on PATH for `php artisan ...` (Laragon → PHP → add to PATH)
- Database: **SQLite** at `database/database.sqlite` (see `.env` — `DB_CONNECTION=sqlite`)
- Mail: `MAIL_MAILER=log` (emails written to `storage/logs/laravel.log`)
- Queue: `QUEUE_CONNECTION=sync` · Cache: `file` · Session: `file`

### First-time / fresh clone setup
```bash
composer install
copy .env.example .env        # then set APP_KEY & APP_URL=http://ecommerce.test
php artisan key:generate
php artisan storage:link      # REQUIRED — see Gotchas #1
php artisan migrate --seed    # PermissionSeeder, roles, demo data
npm install && npm run build
```

### Daily dev workflow
```bash
npm run dev          # Vite HMR (terminal 1)
php artisan serve    # only if NOT using Laragon vhost; with Laragon just open http://ecommerce.test
php artisan queue:listen --tries=1 --timeout=0   # if QUEUE_CONNECTION=database
php artisan pail     # live log viewer (optional)
```

---

## 3. Directory Map (what lives where)

```
routes/                     web.php (storefront) · admin.php · customer.php · auth.php · seo.php · api.php · console.php
app/
  Http/Controllers/         Frontend/ · Customer/ · Admin/(+module subdirs) · Auth/ · API/ · Payment/ · Webhook/
  Http/Requests/            Form validation, grouped by domain (Product/, Cart/, Checkout/, Finance/, ...)
  Http/Middleware/          AdminMiddleware · CustomerMiddleware · SecurityHeadersMiddleware
  Services/                 Business logic layer (see §5)
  Repositories/             BaseRepository + per-entity repositories (Product, Order, Cart, ...)
  Policies/                 BasePolicy + per-entity policies (see §5)
  Models/                   64 Eloquent models
  Enums/                    20 typed enums, each with label() and color() methods
  Traits/                   HasSlug · HasCache · HasCreatedBy · HasImageAccessors · HasScope · HasLoginHistory · LogsActivity · ApiResponse
  Helpers/helpers.php       Global functions: formatPrice, generateOrderNumber, ratingStars, truncateText, getGravatar, ...
  Services/SEOService.php   SEO + JSON-LD schema builder
  View/Components/          Blade components: x-layouts.*, x-admin.*, x-frontend.*
  Support/ · Actions/ · Observers/ · Jobs/ · Events/ · Listeners/ · Notifications/ · Mail/
resources/
  views/                    frontend/ (22 views) · admin/ · customer/ (9 views) · auth/ · layouts/ · partials/ · components/ · emails/
  sass/                     app.scss (frontend) · admin.scss (admin) · product.scss
  js/                       app.js · frontend.js · product.js · admin-dashboard.js · bootstrap.js
database/
  migrations/ (97)          migrations/seeders
  seeders/                  PermissionSeeder, RoleSeeder(s), AdminUserSeeder, DemoDataSeeder, ...
public/                     index.php · images/no-image.svg · storage/ (JUNCTION → storage/app/public)
tests/                      Feature/ · Unit/ (PHPUnit)
```

---

## 4. Architecture Rules (Golden Rules for AI Agents)

**Request flow:** `Route → Middleware → Controller → FormRequest (validation) → Service → Repository → Model → DB`
**Authorization:** `Policy` (Spatie `BasePolicy` with `before()` bypass for `super-admin`).

### MUST follow these conventions for every change:

1. **Controllers stay thin.** All business logic goes in a Service. CRUD services extend `App\Services\BaseService` (all/paginate/findById/findOrFail/create/update/delete/count) backed by a `BaseRepository`.
2. **All validation** in FormRequest classes (not in controllers).
3. **RBAC:** every admin route group/policy uses permission names in `{group}.{type}` format (e.g. `products.create`, `orders.export`, `settings.manage`). Groups are defined in `App\Enums\PermissionGroup`; types: view, create, edit, delete, restore, export, import, approve, reject, publish, unpublish, manage. New feature ⇒ add group to enum + PermissionSeeder.
4. **Enums over strings.** Statuses are `App\Enums\*` (OrderStatus, PaymentStatus, ProductStatus, ...) cast in models, each with `label()`/`color()`. Use `$enum->value` for comparisons/storage.
5. **Policies:** authorize with `Gate`/`$this->authorize()`; every policy extends `BasePolicy` so `super-admin` bypasses automatically.
6. **Models:** always define `$fillable`, `$casts`, relationships, scopes in `scopeXxx()` form, and accessors via `Attribute::make(get: ...)` (snake_case accessor ⇒ camel_case property, e.g. `current_price` ⇒ `$product->current_price`).
7. **Slugs auto-generated** via `HasSlug` trait or model `booted()` (Product generates slug+SKU+published_at on create). Don't manually set slugs.
8. **Soft deletes** on core entities; deleted rows must stay queryable with `withTrashed()`.
9. **DB writes** go through Eloquent — never raw SQL in controllers (exceptions: reports).
10. **Eager-load** relationships everywhere (`with([...])`) — the codebase has an N+1 ban.
11. **Security:** escape with `{{ }}` (no `{!! !!}` unless sanitized), CSRF on all forms, files via storage, no secrets in code.
12. **No fake or mock data fallbacks** in production controllers or chart assets. All UI widgets must gracefully handle empty database states (0 values / empty tables) — render flat zero series and empty labels, never invented numbers.

---

## 5. Key Classes & Where Things Hook In

### Service layer (34 services)
`BaseService` → concrete services. Domain services: ProductService, OrderService, CartService, CheckoutService, InventoryService, PurchaseService, PaymentService, InvoiceService, ShippingService, TaxService, CouponService (part of Cart), ReviewService, SEOService, ImageUploadService, ReportService, ExportService, NotificationService, Finance* (AccountingService, FinanceDashboardService, FinanceReportService, ...), UserService, RoleService, PermissionService, CustomerService, CustomerGroupService, SupplierService, CategoryService, BrandService, AnalyticsService.

### Automated PDF invoices (`InvoiceService` + `barryvdh/laravel-dompdf`)
- `InvoiceService::generateInvoiceNumber()` → `INV-YYYYMMDD-XXXXXX` (helper `generateInvoiceNumber()` in `app/Helpers/helpers.php`).
- `InvoiceService::generateInvoice(Order)` stamps `invoice_number` + `invoice_at` (idempotent — skips if already set) on order confirmation/completion.
- `InvoiceService::getInvoiceData(Order)` → itemized payload (store, customer billing/shipping, items, summary, payment) rendered to PDF via dompdf.
- Admin downloads: `GET /admin/orders/{order}/invoice` (route `admin.orders.invoice` → `Order\OrderController@invoice`) — button on Latest Orders list & Order Details.
- **Mail integration:** customer confirmation email should attach the generated PDF invoice — `OrderConfirmedMail` is **planned, NOT yet implemented** (no `app/Mail/*` classes exist).

### Repositories (13)
`BaseRepository` (all/paginate/findById/findOrFail/create/update/delete/count) + Product, Order, Cart, Category, Brand, Supplier, Purchase, Review, Blog, Customer, CustomerGroup repositories.

### Policies (17)
`BasePolicy` + Product? (no—Brand, Category, Inventory, Supplier, Purchase, User, Role, Permission, Warehouse, ChartOfAccount, JournalEntry, Transaction, Expense, Tax, Budget, FinancePeriod).

### Key models
- **Product** (`app/Models/Product.php`) — 60+ columns: price/cost_price/tax/discount/stock/variants/meta/SEO fields. Accessors: `current_price`, `sale_price`, `is_in_stock`, `total_stock`, `average_rating`, `review_count`, `price_after_tax`, `profit`, `profit_margin`, `thumbnail_url`, `og_image_url`. Scopes: `published()`, `active()`, `inStock()`, `lowStock()`, `outOfStock()`, `withDiscount()`, `search()`, `featured()`, `trending()`, `bestSeller()`, `newArrival()`. Relations: category, subCategory, childCategory, brand, images, variants(+attributeValues), warehouses, inventories, orders, reviews, wishlists, activityLogs.
- **Order** — status via OrderStatus enum, payment via PaymentStatus; items pivot `order_items`; coupons, shipping, invoice.
- **User / Admin / Customer** — separate auth models; customers also have `customers` table entities? (User = web guard; Admin = admin guard).
- **Setting** — site-wide config; `Setting::getSeoDefaults()` supplies SEO defaults.

---

## 6. Route Map (complete)

### Storefront (`web.php`)
```
GET  /                          home
GET  /shop | /search            shop/search (ShopController)
GET  /category/{slug}           category.show
GET  /brand/{slug}              brand.show
GET  /product/{slug}            product.show   ← PRODUCT DETAIL (ProductController@show)
POST /cart/...                  cart add/update/remove/clear/coupon apply-remove/summary
GET  /checkout + POST place, GET success/failed/{orderId}, summary, shipping-rates
GET  /order/invoice/{orderId}   PDF invoice
GET  /order/track/{orderNumber?}
GET  /wishlist, POST /wishlist/toggle|add, DELETE /wishlist/{product}, GET /wishlist/count
POST /product/{product}/review, POST /review/{review}/helpful
GET  /notification/unread-count, /latest
GET  /flash-sale
GET  /about /contact /faq /blog /terms /privacy-policy /shipping-policy /refund-policy  (static pages loop, SEO per page)
```

### SEO (`seo.php`)
```
GET  /sitemap.xml   (SitemapController)
GET  /robots.txt    (disallow all in non-production)
```

### Customer (`customer.php`) — middleware `customer` (web guard)
```
/customer/login|register (guest) · /customer/logout
/customer/dashboard · /profile (+update, password, sessions, login-history)
/customer/orders · /orders/{order}
/customer/wishlist · /addresses (full CRUD + setDefault) · /reviews (list/update/delete)
/customer/notifications (list, markAsRead, read-all, destroy)
```

### Auth (`auth.php`)
```
/login /register /forgot-password /reset-password (web)
admin/* password reset (admin guard)
/verify-email + email/verify/{id}/{hash} (signed, throttle:6,1)
```

### Admin (`admin.php`) — middleware `admin` (admin guard)
`/admin/login` (guest:admin) → authenticated area:
```
dashboard (DashboardController@index + JSON @data) · profile(+password, login-history)
roles (CRUD + bulk-delete) · permissions (CRUD + bulk-delete + generate-all) · users (CRUD + bulk actions + reset-password + toggle-status)
settings (permission:settings.manage, logo/favicon/og-image uploads)
categories (CRUD + sub/child) · brands · products (CRUD + images + bulk) · reviews
coupons · flash-sales · customers + customer-groups + reports
orders (list/show/status/invoice-PDF/export/reports) · returns · track
inventory · stock-movements · warehouses · suppliers · purchases (+payments/returns/goods-receipts)
finance: dashboard · chart-of-accounts · journal-entries · expenses (+categories, recurring) · taxes · budgets · periods · payment-methods · transactions · reports
cms: pages · blogs · banners · sliders · menus · faq
system: settings · activity-logs · login-histories · backup
```
Route names: `admin.roles.index`, `admin.products.create`, `admin.finance.dashboard` etc. (per-resource `->names([...])` blocks).

### API (`api.php`) — prefix `/api/v1`
Stub cart endpoints (CartController) + placeholder login/register/user/logout. **Not production-ready.**

---

## 7. Frontend & Assets

- **Vite entries** (`vite.config.js`): `resources/sass/app.scss`, `product.scss`, `admin.scss` + `resources/js/app.js`, `product.js`, `frontend.js`, `admin-dashboard.js`.
- **Admin dashboard charts** (`resources/js/admin-dashboard.js`, loaded ONLY on the dashboard view via `@push('scripts') @vite('resources/js/admin-dashboard.js')` in `dashboard.blade.php` — never inline `<script>`): Chart.js 4.4.1 (Revenue Overview area w/ gradient — `#revenueChart` canvas, `responsive:true, maintainAspectRatio:false`) and ApexCharts 3.45.1 (Order Status donut `#orderStatusChart`, Sales by Category bars `#categoryChart`, Customer Growth area `#customerGrowthChart`) — both npm-installed and bundled locally (NO CDN).
- **Dashboard data is 100% real DB records** (`Order`, `Customer`, `Purchase`, `OrderItem` via `DashboardController@data` → `GET /admin/dashboard-data?period=week|month|year`). **No mock/placeholder data anywhere.** Empty-state handling: when records/sales are 0, series normalize to flat zero values with real period labels — Chart.js draws a flat 0-line, ApexCharts draws empty axes/ring — never blank broken containers, never invented numbers. Chart wrappers carry inline `min-height: 280px; position: relative` (admin.scss: `.dashboard-card .chart-container/.chart-container-sm { height: 280px }`).
- Layouts: `resources/views/components/layouts/frontend-layout.blade.php` (storefront), `layouts/customer.blade.php`, `layouts/guest.blade.php`, admin layout under `resources/views/layouts/` / admin partials.
- Storefront views use `<x-layouts.frontend-layout :title="..." :seoData="$seoData ?? []">` (see §8 title precedence).
- Reusable admin components: `x-admin.crud-header`, `x-admin.stat-cards`, `x-admin.bulk-actions`, `x-admin.empty-state`.
- Bootstrap 5.3 + Font Awesome via CDN (preload+media swap), AOS, Swiper in frontend JS.
- **Do not inline CSS/JS in blades** — add to `resources/sass/admin.scss` / `resources/js/frontend.js` and rebuild (`npm run build`).

---

## 8. SEO System (important)

- `App\Services\SEOService` builds: metaTitle, metaDescription, canonicalUrl, OG/Twitter tags, robots, JSON-LD schemas (WebSite, Organization, + entity schema for Product/Page/Blog/Category/Brand, BreadcrumbList).
- Controllers call `$seo->forProduct($product)` etc., then `$seo->build()` and pass `seoData` to the view.
- The layout component resolves the title like this (**do not reorder — fixed bug**):
  ```php
  $_metaTitle = $metaTitle ?? $_seo['metaTitle'] ?? $title ?? config('app.name');
  $_metaDescription = $metaDescription ?: ($_seo['metaDescription'] ?? '');
  ```
  → SEO-generated titles win over the static `title` prop.
- Product SEO fields (meta_title, meta_description, canonical_url, og_image, schema_markup) live on the product row; `SEOService::forProduct()` falls back to name/description.

---

## 9. Images & Files (critical — we've fixed storage bugs here)

- **Uploads** stored on `storage/app/public/...`; DB stores **relative path only** (e.g. `products/2026/07/cea5afbd-...webp`). Never store URLs/absolute paths in DB.
- `public/storage` must be a **junction/symlink** → `storage/app/public`. On Windows Laragon, verify with:
  ```powershell
  Get-Item public\storage | Select LinkType, Target   # must show Junction
  ```
  Fix: `php artisan storage:link` (delete empty `public/storage` dir first if it exists as a plain folder).
- `App\Services\ImageUploadService` handles validation/upload/resize; `App\Traits\HasImageAccessors` provides `image_url` style accessors with placeholder fallback `public/images/no-image.svg`.
- Blade pattern:
  ```blade
  <img src="{{ $product->thumbnail_url }}" alt="{{ $product->name }}" onerror="this.src='{{ asset('images/no-image.svg') }}'">
  ```
- WebP conversion + responsive srcset are on the roadmap (not implemented).

---

## 10. Tests & Verification (run before finishing any task)

```bash
php artisan test                    # full PHPUnit suite (Feature/ + Unit/)
php artisan test --filter=ProductTest   # single file
php artisan test --filter=test_xxx      # single test
vendor/bin/pint --test               # style check (or: vendor/bin/pint  to auto-fix)
php artisan route:list --path=admin  # inspect routes
php artisan migrate:status           # migrations health
php artisan optimize:clear           # after changing config/routes/views caches
npm run build                        # after touching sass/js (or leave `npm run dev` running)
```

Manual smoke test: load `http://ecommerce.test`, a product page, admin login `/admin/login` (seed admin from `AdminUserSeeder`), and verify images resolve (HTTP 200).

---

## 11. A-to-Z Recipe: Add a New Feature/Module (follow this order)

1. **Migration** — `php artisan make:migration create_xyz_table`; add indexes for FK + commonly queried columns. Run `php artisan migrate`.
2. **Model** — fillable, casts, relationships, scopes, `booted()` hooks. Use traits (`HasSlug`, `HasCreatedBy`, `LogsActivity`, `SoftDeletes` as needed).
3. **Enum** (if statuses/types) — `App\Enums\XyzStatus` with `label()`/`color()`; register cast in model.
4. **Repository** (optional for CRUD) — extend `BaseRepository`, bind in `AppServiceProvider`.
5. **Service** — extend `BaseService` or plain service class; all business logic here.
6. **FormRequest** — rules/authorize; wire into controller method.
7. **Policy** — extend `BasePolicy`; permission `{group}.{type}`.
8. **Permission** — add `PermissionGroup` case + seed row in `PermissionSeeder` (then `php artisan db:seed --class=PermissionSeeder`).
9. **Controller** — thin; resolve service via DI; return views/redirects with flash.
10. **Routes** — admin.php resource + bulk actions; register with `->middleware('permission:xyz.view')` if needed (pattern: permission middleware on the route group/prefix).
11. **Views** — use `x-admin.crud-header` / `x-admin.stat-cards` / `x-admin.bulk-actions` components; reuse list/table patterns from a sibling module.
12. **Frontend** (if public-facing) — route in web.php, controller in Frontend/, view with `<x-layouts.frontend-layout :title="..." :seoData="$seoData ?? []">`, SEOService call.
13. **Tests** — Feature test asserting create/read/update/delete + permission denial.
14. **Verify** — `php artisan test`, `pint`, manual smoke test.

---

## 12. Common Fixes (from real incidents on this project)

| Symptom | Cause → Fix |
|---------|-------------|
| Product page title = "Product" | Layout title precedence (`seoData` was shadowed) → order must be `$metaTitle ?? $_seo['metaTitle'] ?? $title` (see §8). |
| Images 404 (`/storage/...`) | `public/storage` was a plain empty dir, not a junction → `Remove-Item public\storage -Recurse -Force` then `php artisan storage:link`. |
| `No application encryption key` in log | `.env` missing `APP_KEY` → `php artisan key:generate`. |
| Blanks CSS/JS after edit | Vite not running / not rebuilt → `npm run dev` or `npm run build`. |
| 404 on admin routes | Route cache stale → `php artisan route:clear` (or `optimize:clear`). |
| Permission denied (403) in admin | Role missing `{group}.{type}` permission → run `PermissionSeeder`, or `permissions/generate-all`. |
| Admin `/admin/settings` → 403 "User is not logged in" | Spatie `permission:` middleware checks the **`web` guard** by default → pass the guard explicitly: `permission:settings.manage,admin`. |
| Blank/white chart cards on admin dashboard | Charts are real-data only: empty DB → series normalize to flat zeros (never mock). If still blank: libs must be bundled locally via Vite (no CDN), chart wrappers need `min-height: 280px; position: relative`, and the `@push('scripts') @vite('resources/js/admin-dashboard.js')` stack must render in the admin layout (`@stack('scripts')`). |
| 500 after DB change | `php artisan migrate` + `php artisan config:clear` + `view:clear`. |

---

## 13. Gotchas & Warnings for AI Agents

1. **NEVER edit `vendor/`** — framework code; changes vanish on `composer install`.
2. **NEVER commit `.env`** — it holds APP_KEY/secrets; work from `.env.example` for new variables.
3. **Don't bypass RBAC** — keep `permission:` middleware and policy checks; new routes need matching permissions.
4. **DB is SQLite locally** — avoid MySQL-only SQL; use Eloquent/scopes, not `DB::raw` (unless already in a Report).
5. **Enums cast in models** — comparing `status` to a string breaks; compare to enum (`ProductStatus::Active`).
6. **Accessor vs column collision** — a column like `price` and accessor `current_price` coexist; don't add columns named like existing accessors.
7. **Blade escaping** — `{{ }}` by default; `@json()` for JS data, never `{!! !!}` with user input.
8. **Windows + Laragon**: use `pwsh`/PowerShell; symlinks need admin or Developer Mode — junctions from `storage:link` work without admin.
9. **Order number generation** uses `uniqid()` — fine, don't change format (invoices/PDFs depend on it).
10. **Tests exist and must pass** — run `php artisan test` after changes; do not delete tests.
11. **Spatie permission guard** — admin routes with `permission:` middleware must pass the guard explicitly (`permission:xyz.view,admin`); the default `web` guard causes 403s for logged-in admins (see §12).

---

## 14. Handy Commands

```bash
php artisan route:list                 # all routes
php artisan make:model Xyz -m -c -r    # model + migration + controller + resource routes
php artisan make:request XyzRequest    # form request
php artisan make:policy XyzPolicy --model=Xyz
php artisan db:seed --class=PermissionSeeder
php artisan storage:link               # storage symlink/junction
php artisan optimize:clear             # clear all caches
php artisan tinker                     # REPL for data checks
```

---

*Keep this file up to date whenever architecture, routes, or conventions change.*
