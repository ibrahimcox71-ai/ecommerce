<?php

use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\Customer\CustomerController;
use App\Http\Controllers\Admin\Customer\CustomerGroupController;
use App\Http\Controllers\Admin\Customer\ReportController as CustomerReportController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\Order\OrderController;
use App\Http\Controllers\Admin\Order\ReportController;
use App\Http\Controllers\Admin\Order\ReturnController;
use App\Http\Controllers\Admin\Permission\PermissionController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PurchaseController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\Role\RoleController;
use App\Http\Controllers\Admin\Setting\SettingsController;
use App\Http\Controllers\Admin\StockMovementController;
use App\Http\Controllers\Admin\Finance\AccountController as FinanceAccountController;
use App\Http\Controllers\Admin\Finance\BudgetController as FinanceBudgetController;
use App\Http\Controllers\Admin\Finance\DashboardController as FinanceDashboardController;
use App\Http\Controllers\Admin\Finance\ExpenseCategoryController as FinanceExpenseCategoryController;
use App\Http\Controllers\Admin\Finance\ExpenseController as FinanceExpenseController;
use App\Http\Controllers\Admin\Finance\JournalEntryController as FinanceJournalEntryController;
use App\Http\Controllers\Admin\Finance\PaymentMethodController as FinancePaymentMethodController;
use App\Http\Controllers\Admin\Finance\PeriodController as FinancePeriodController;
use App\Http\Controllers\Admin\Finance\RecurringExpenseController as FinanceRecurringExpenseController;
use App\Http\Controllers\Admin\Finance\ReportController as FinanceReportController;
use App\Http\Controllers\Admin\Finance\TaxController as FinanceTaxController;
use App\Http\Controllers\Admin\Finance\TransactionController as FinanceTransactionController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\User\UserController;
use App\Http\Controllers\Admin\WarehouseController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\ProfileController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {

    Route::middleware('guest:admin')->group(function () {

        Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login']);
    });

    Route::middleware(['admin'])->group(function () {

        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard-data', [DashboardController::class, 'data'])->name('dashboard.data');

        Route::get('/profile', [ProfileController::class, 'showAdminProfile'])->name('profile');
        Route::put('/profile', [ProfileController::class, 'updateAdminProfile'])->name('profile.update');
        Route::put('/profile/password', [ProfileController::class, 'changeAdminPassword'])->name('profile.password');
        Route::get('/login-history', [ProfileController::class, 'loginHistory'])->name('login.history');

        // Role Management
        Route::resource('roles', RoleController::class)->names([
            'index' => 'roles.index',
            'create' => 'roles.create',
            'store' => 'roles.store',
            'show' => 'roles.show',
            'edit' => 'roles.edit',
            'update' => 'roles.update',
            'destroy' => 'roles.destroy',
        ]);

        Route::prefix('roles')->name('roles.')->group(function () {
            Route::post('/bulk-delete', [RoleController::class, 'bulkDelete'])->name('bulk-delete');
        });

        // Permission Management
        Route::resource('permissions', PermissionController::class)->names([
            'index' => 'permissions.index',
            'create' => 'permissions.create',
            'store' => 'permissions.store',
            'edit' => 'permissions.edit',
            'update' => 'permissions.update',
            'destroy' => 'permissions.destroy',
        ]);

        Route::prefix('permissions')->name('permissions.')->group(function () {
            Route::post('/bulk-delete', [PermissionController::class, 'bulkDelete'])->name('bulk-delete');
            Route::get('/generate-all', [PermissionController::class, 'generateAll'])->name('generate');
        });

        // User Management
        Route::resource('users', UserController::class)->names([
            'index' => 'users.index',
            'create' => 'users.create',
            'store' => 'users.store',
            'show' => 'users.show',
            'edit' => 'users.edit',
            'update' => 'users.update',
            'destroy' => 'users.destroy',
        ]);

        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/{user}/login-history', [UserController::class, 'loginHistory'])->name('login-history');
            Route::post('/{user}/reset-password', [UserController::class, 'resetPassword'])->name('reset-password');
            Route::post('/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('toggle-status');
            Route::post('/bulk-delete', [UserController::class, 'bulkDelete'])->name('bulk-delete');
            Route::post('/bulk-restore', [UserController::class, 'bulkRestore'])->name('bulk-restore');
            Route::post('/bulk-assign-role', [UserController::class, 'bulkAssignRole'])->name('bulk-assign-role');
        });

        // Settings
        Route::prefix('settings')->middleware('permission:settings.manage,admin')->name('settings')->group(function () {
            Route::get('/', [SettingsController::class, 'index'])->name('.index');
            Route::post('/', [SettingsController::class, 'update'])->name('.update');
            Route::post('/remove-logo', [SettingsController::class, 'removeLogo'])->name('.remove-logo');
            Route::post('/remove-favicon', [SettingsController::class, 'removeFavicon'])->name('.remove-favicon');
            Route::post('/remove-og-image', [SettingsController::class, 'removeOgImage'])->name('.remove-og-image');
        });

        // Category Routes
        Route::resource('categories', CategoryController::class)->names([
            'index' => 'categories.index',
            'create' => 'categories.create',
            'store' => 'categories.store',
            'show' => 'categories.show',
            'edit' => 'categories.edit',
            'update' => 'categories.update',
            'destroy' => 'categories.destroy',
        ]);

        Route::prefix('categories')->name('categories.')->group(function () {
            Route::get('/trashed', [CategoryController::class, 'trashed'])->name('trashed');
            Route::post('/{id}/restore', [CategoryController::class, 'restore'])->name('restore');
            Route::delete('/{id}/force-delete', [CategoryController::class, 'forceDelete'])->name('force-delete');
            Route::post('/bulk-restore', [CategoryController::class, 'bulkRestore'])->name('bulk-restore');
            Route::post('/bulk-delete', [CategoryController::class, 'bulkDelete'])->name('bulk-delete');
            Route::post('/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('toggle-status');
            Route::post('/update-sort', [CategoryController::class, 'updateSort'])->name('update-sort');
            Route::post('/{id}/remove-image', [CategoryController::class, 'removeImage'])->name('remove-image');
            Route::get('/data-table', [CategoryController::class, 'dataTable'])->name('data-table');
            Route::get('/tree', [CategoryController::class, 'tree'])->name('tree');
            Route::post('/{category}/duplicate', [CategoryController::class, 'duplicate'])->name('duplicate');
            Route::post('/bulk-update-status', [CategoryController::class, 'bulkUpdateStatus'])->name('bulk-update-status');
            Route::post('/bulk-force-delete', [CategoryController::class, 'bulkForceDelete'])->name('bulk-force-delete');
            Route::get('/{category}/check-deletable', [CategoryController::class, 'checkDeletable'])->name('check-deletable');
            Route::get('/{category}/children', [CategoryController::class, 'getChildren'])->name('get-children');
            Route::get('/stats', [CategoryController::class, 'stats'])->name('stats');
            Route::get('/search-suggestions', [CategoryController::class, 'searchSuggestions'])->name('search-suggestions');
            Route::post('/{category}/move-products', [CategoryController::class, 'moveProducts'])->name('move-products');
        });

        // Brand Routes
        Route::resource('brands', BrandController::class)->names([
            'index' => 'brands.index',
            'create' => 'brands.create',
            'store' => 'brands.store',
            'show' => 'brands.show',
            'edit' => 'brands.edit',
            'update' => 'brands.update',
            'destroy' => 'brands.destroy',
        ]);

        Route::prefix('brands')->name('brands.')->group(function () {
            Route::get('/trashed', [BrandController::class, 'trashed'])->name('trashed');
            Route::post('/{id}/restore', [BrandController::class, 'restore'])->name('restore');
            Route::delete('/{id}/force-delete', [BrandController::class, 'forceDelete'])->name('force-delete');
            Route::post('/bulk-restore', [BrandController::class, 'bulkRestore'])->name('bulk-restore');
            Route::post('/bulk-delete', [BrandController::class, 'bulkDelete'])->name('bulk-delete');
            Route::post('/{brand}/toggle-status', [BrandController::class, 'toggleStatus'])->name('toggle-status');
            Route::post('/{brand}/toggle-featured', [BrandController::class, 'toggleFeatured'])->name('toggle-featured');
            Route::post('/{brand}/toggle-popular', [BrandController::class, 'togglePopular'])->name('toggle-popular');
            Route::post('/update-sort', [BrandController::class, 'updateSort'])->name('update-sort');
            Route::post('/{brand}/remove-image', [BrandController::class, 'removeImage'])->name('remove-image');
            Route::get('/data-table', [BrandController::class, 'dataTable'])->name('data-table');
            Route::post('/{brand}/duplicate', [BrandController::class, 'duplicate'])->name('duplicate');
            Route::post('/bulk-update-status', [BrandController::class, 'bulkUpdateStatus'])->name('bulk-update-status');
            Route::post('/bulk-force-delete', [BrandController::class, 'bulkForceDelete'])->name('bulk-force-delete');
            Route::get('/{brand}/check-deletable', [BrandController::class, 'checkDeletable'])->name('check-deletable');
            Route::get('/stats', [BrandController::class, 'stats'])->name('stats');
            Route::get('/search-suggestions', [BrandController::class, 'searchSuggestions'])->name('search-suggestions');
        });

        // Supplier Routes
        Route::resource('suppliers', SupplierController::class)->names([
            'index' => 'suppliers.index',
            'create' => 'suppliers.create',
            'store' => 'suppliers.store',
            'show' => 'suppliers.show',
            'edit' => 'suppliers.edit',
            'update' => 'suppliers.update',
            'destroy' => 'suppliers.destroy',
        ]);

        Route::prefix('suppliers')->name('suppliers.')->group(function () {
            Route::get('/trashed', [SupplierController::class, 'trashed'])->name('trashed');
            Route::post('/{id}/restore', [SupplierController::class, 'restore'])->name('restore');
            Route::delete('/{id}/force-delete', [SupplierController::class, 'forceDelete'])->name('force-delete');
            Route::post('/bulk-restore', [SupplierController::class, 'bulkRestore'])->name('bulk-restore');
            Route::post('/bulk-delete', [SupplierController::class, 'bulkDelete'])->name('bulk-delete');
            Route::post('/{supplier}/toggle-status', [SupplierController::class, 'toggleStatus'])->name('toggle-status');
            Route::post('/{supplier}/remove-image', [SupplierController::class, 'removeImage'])->name('remove-image');
            Route::get('/data-table', [SupplierController::class, 'dataTable'])->name('data-table');
            Route::post('/bulk-update-status', [SupplierController::class, 'bulkUpdateStatus'])->name('bulk-update-status');
            Route::post('/bulk-force-delete', [SupplierController::class, 'bulkForceDelete'])->name('bulk-force-delete');
            Route::get('/{supplier}/check-deletable', [SupplierController::class, 'checkDeletable'])->name('check-deletable');
            Route::get('/stats', [SupplierController::class, 'stats'])->name('stats');
            Route::get('/search-suggestions', [SupplierController::class, 'searchSuggestions'])->name('search-suggestions');
        });

        // Product Routes
        Route::resource('products', ProductController::class)->names([
            'index' => 'products.index',
            'create' => 'products.create',
            'store' => 'products.store',
            'show' => 'products.show',
            'edit' => 'products.edit',
            'update' => 'products.update',
            'destroy' => 'products.destroy',
        ]);

        // Product Additional Routes
        Route::prefix('products')->name('products.')->group(function () {
            Route::get('/trashed', [ProductController::class, 'trashed'])->name('trashed');
            Route::post('/{id}/restore', [ProductController::class, 'restore'])->name('restore');
            Route::delete('/{id}/force-delete', [ProductController::class, 'forceDelete'])->name('force-delete');
            Route::post('/bulk-restore', [ProductController::class, 'bulkRestore'])->name('bulk-restore');
            Route::post('/bulk-delete', [ProductController::class, 'bulkDelete'])->name('bulk-delete');
            Route::post('/bulk-force-delete', [ProductController::class, 'bulkForceDelete'])->name('bulk-force-delete');
            Route::post('/bulk-update-status', [ProductController::class, 'bulkUpdateStatus'])->name('bulk-update-status');
            Route::post('/bulk-edit', [ProductController::class, 'bulkEdit'])->name('bulk-edit');
            Route::get('/{product}/quick-edit', [ProductController::class, 'quickEdit'])->name('quick-edit');
            Route::put('/{product}/quick-update', [ProductController::class, 'quickUpdate'])->name('quick-update');
            Route::post('/{product}/toggle-status', [ProductController::class, 'toggleStatus'])->name('toggle-status');
            Route::post('/{product}/toggle-featured', [ProductController::class, 'toggleFeatured'])->name('toggle-featured');
            Route::post('/{product}/toggle-trending', [ProductController::class, 'toggleTrending'])->name('toggle-trending');
            Route::post('/{product}/toggle-best-seller', [ProductController::class, 'toggleBestSeller'])->name('toggle-best-seller');
            Route::post('/{product}/toggle-new-arrival', [ProductController::class, 'toggleNewArrival'])->name('toggle-new-arrival');
            Route::post('/update-sort', [ProductController::class, 'updateSort'])->name('update-sort');
            Route::get('/get-sub-categories/{categoryId}', [ProductController::class, 'getSubCategories'])->name('get-sub-categories');
            Route::post('/{product}/remove-image/{imageId}', [ProductController::class, 'removeImage'])->name('remove-image');
            Route::post('/{product}/set-primary-image/{imageId}', [ProductController::class, 'setPrimaryImage'])->name('set-primary-image');
            Route::get('/{id}/duplicate', [ProductController::class, 'duplicate'])->name('duplicate');
            Route::get('/data-table', [ProductController::class, 'dataTable'])->name('data-table');
            Route::get('/export/csv', [ProductController::class, 'exportCsv'])->name('export.csv');
            Route::get('/export/excel', [ProductController::class, 'exportExcel'])->name('export.excel');
            Route::get('/search-suggestions', [ProductController::class, 'searchSuggestions'])->name('search-suggestions');
        });

        // Warehouse Routes
        Route::resource('warehouses', WarehouseController::class)->names([
            'index' => 'warehouses.index',
            'create' => 'warehouses.create',
            'store' => 'warehouses.store',
            'show' => 'warehouses.show',
            'edit' => 'warehouses.edit',
            'update' => 'warehouses.update',
            'destroy' => 'warehouses.destroy',
        ]);

        Route::prefix('warehouses')->name('warehouses.')->group(function () {
            Route::get('/trashed', [WarehouseController::class, 'trashed'])->name('trashed');
            Route::post('/{id}/restore', [WarehouseController::class, 'restore'])->name('restore');
            Route::delete('/{id}/force-delete', [WarehouseController::class, 'forceDelete'])->name('force-delete');
            Route::post('/bulk-restore', [WarehouseController::class, 'bulkRestore'])->name('bulk-restore');
            Route::post('/bulk-delete', [WarehouseController::class, 'bulkDelete'])->name('bulk-delete');
            Route::post('/{warehouse}/toggle-status', [WarehouseController::class, 'toggleStatus'])->name('toggle-status');
            Route::post('/update-sort', [WarehouseController::class, 'updateSort'])->name('update-sort');
            Route::get('/data-table', [WarehouseController::class, 'dataTable'])->name('data-table');
            Route::post('/{warehouse}/set-default', [WarehouseController::class, 'setDefault'])->name('set-default');
            Route::get('/stats', [WarehouseController::class, 'stats'])->name('stats');
            Route::get('/search-suggestions', [WarehouseController::class, 'searchSuggestions'])->name('search-suggestions');
        });

        // Stock Movement Routes
        Route::resource('stock-movements', StockMovementController::class)->names([
            'index' => 'stock-movements.index',
            'create' => 'stock-movements.create',
            'store' => 'stock-movements.store',
            'show' => 'stock-movements.show',
        ]);

        Route::prefix('stock-movements')->name('stock-movements.')->group(function () {
            Route::post('/transfer', [StockMovementController::class, 'transfer'])->name('transfer');
            Route::post('/adjust', [StockMovementController::class, 'adjust'])->name('adjust');
            Route::get('/warehouse-stock', [StockMovementController::class, 'getWarehouseStock'])->name('warehouse-stock');
            Route::get('/recent', [StockMovementController::class, 'getRecentMovements'])->name('recent');
        });

        // Purchase Routes
        Route::resource('purchases', PurchaseController::class)->names([
            'index' => 'purchases.index',
            'create' => 'purchases.create',
            'store' => 'purchases.store',
            'show' => 'purchases.show',
            'edit' => 'purchases.edit',
            'update' => 'purchases.update',
            'destroy' => 'purchases.destroy',
        ]);

        Route::prefix('purchases')->name('purchases.')->group(function () {
            Route::post('/{id}/approve', [PurchaseController::class, 'approve'])->name('approve');
            Route::post('/{id}/reject', [PurchaseController::class, 'reject'])->name('reject');
            Route::post('/{id}/mark-ordered', [PurchaseController::class, 'markOrdered'])->name('mark-ordered');
            Route::post('/{id}/cancel', [PurchaseController::class, 'cancel'])->name('cancel');
            Route::post('/{id}/clone', [PurchaseController::class, 'clone'])->name('clone');
            Route::get('/{id}/print', [PurchaseController::class, 'print'])->name('print');
            Route::post('/{id}/receive', [PurchaseController::class, 'goodsReceipt'])->name('receive');
            Route::post('/{id}/payment', [PurchaseController::class, 'addPayment'])->name('payment');
            Route::post('/{id}/return', [PurchaseController::class, 'returnGoods'])->name('return');
            Route::get('/get-products', [PurchaseController::class, 'getProducts'])->name('get-products');
            Route::get('/export/csv', [PurchaseController::class, 'exportCsv'])->name('export.csv');
            Route::get('/export/excel', [PurchaseController::class, 'exportExcel'])->name('export.excel');

            // Report Routes
            Route::get('/reports', [PurchaseController::class, 'reports'])->name('reports');
            Route::get('/reports/purchase', [PurchaseController::class, 'purchaseReport'])->name('reports.purchase');
            Route::get('/reports/supplier', [PurchaseController::class, 'supplierReport'])->name('reports.supplier');
            Route::get('/reports/payment', [PurchaseController::class, 'paymentReport'])->name('reports.payment');
            Route::get('/reports/due', [PurchaseController::class, 'outstandingDueReport'])->name('reports.due');
            Route::get('/reports/return', [PurchaseController::class, 'returnReport'])->name('reports.return');
        });

        // Order Routes
        Route::prefix('orders')->name('orders.')->group(function () {
            Route::get('/', [OrderController::class, 'index'])->name('index');
            Route::get('/create', [OrderController::class, 'create'])->name('create');
            Route::post('/', [OrderController::class, 'store'])->name('store');
            Route::get('/{order}', [OrderController::class, 'show'])->name('show');
            Route::get('/{order}/edit', [OrderController::class, 'edit'])->name('edit');
            Route::put('/{order}', [OrderController::class, 'update'])->name('update');
            Route::delete('/{order}', [OrderController::class, 'destroy'])->name('destroy');
            Route::post('/{order}/update-status', [OrderController::class, 'updateStatus'])->name('update-status');
            Route::post('/{order}/update-tracking', [OrderController::class, 'updateTracking'])->name('update-tracking');
            Route::post('/{order}/mark-paid', [OrderController::class, 'markPaid'])->name('mark-paid');
            Route::post('/{order}/mark-partial-paid', [OrderController::class, 'markPartialPaid'])->name('mark-partial-paid');
            Route::post('/{order}/mark-failed', [OrderController::class, 'markFailed'])->name('mark-failed');
            Route::post('/{order}/refund', [OrderController::class, 'refund'])->name('refund');
            Route::post('/{order}/duplicate', [OrderController::class, 'duplicate'])->name('duplicate');
            Route::get('/{order}/print', [OrderController::class, 'print'])->name('print');
            Route::get('/{order}/invoice', [OrderController::class, 'invoice'])->name('invoice');
            Route::get('/get-products', [OrderController::class, 'getProducts'])->name('get-products');
            Route::get('/get-customers', [OrderController::class, 'getCustomers'])->name('get-customers');
            Route::get('/export/csv', [OrderController::class, 'exportCsv'])->name('export.csv');
            Route::get('/export/excel', [OrderController::class, 'exportExcel'])->name('export.excel');

            // Report Routes
            Route::prefix('reports')->name('reports.')->group(function () {
                Route::get('/', [ReportController::class, 'index'])->name('index');
                Route::get('/sales', [ReportController::class, 'sales'])->name('sales');
                Route::get('/daily', [ReportController::class, 'daily'])->name('daily');
                Route::get('/monthly', [ReportController::class, 'monthly'])->name('monthly');
                Route::get('/top-customers', [ReportController::class, 'topCustomers'])->name('top-customers');
                Route::get('/top-products', [ReportController::class, 'topProducts'])->name('top-products');
                Route::get('/cancelled', [ReportController::class, 'cancelled'])->name('cancelled');
                Route::get('/returned', [ReportController::class, 'returned'])->name('returned');
            });

            // Return Routes
            Route::prefix('returns')->name('returns.')->group(function () {
                Route::get('/', [ReturnController::class, 'index'])->name('index');
                Route::get('/{return}', [ReturnController::class, 'show'])->name('show');
                Route::post('/{return}/approve', [ReturnController::class, 'approve'])->name('approve');
                Route::post('/{return}/reject', [ReturnController::class, 'reject'])->name('reject');
                Route::post('/{return}/process-refund', [ReturnController::class, 'processRefund'])->name('process-refund');
            });
        });

        // Customer Routes
        Route::prefix('customers')->name('customers.')->group(function () {
            Route::get('/', [CustomerController::class, 'index'])->name('index');
            Route::get('/create', [CustomerController::class, 'create'])->name('create');
            Route::post('/', [CustomerController::class, 'store'])->name('store');
            Route::get('/trashed', [CustomerController::class, 'trashed'])->name('trashed');
            Route::get('/{customer}', [CustomerController::class, 'show'])->name('show');
            Route::get('/{customer}/edit', [CustomerController::class, 'edit'])->name('edit');
            Route::put('/{customer}', [CustomerController::class, 'update'])->name('update');
            Route::delete('/{customer}', [CustomerController::class, 'destroy'])->name('destroy');
            Route::post('/{id}/restore', [CustomerController::class, 'restore'])->name('restore');
            Route::delete('/{id}/force-delete', [CustomerController::class, 'forceDelete'])->name('force-delete');
            Route::post('/bulk-delete', [CustomerController::class, 'bulkDelete'])->name('bulk-delete');
            Route::post('/bulk-restore', [CustomerController::class, 'bulkRestore'])->name('bulk-restore');
            Route::post('/bulk-force-delete', [CustomerController::class, 'bulkForceDelete'])->name('bulk-force-delete');
            Route::post('/{customer}/toggle-status', [CustomerController::class, 'toggleStatus'])->name('toggle-status');
            Route::post('/{customer}/remove-avatar', [CustomerController::class, 'removeAvatar'])->name('remove-avatar');
            Route::get('/{customer}/login-history', [CustomerController::class, 'loginHistory'])->name('login-history');
            Route::get('/data-table', [CustomerController::class, 'dataTable'])->name('data-table');
            Route::get('/search-suggestions', [CustomerController::class, 'searchSuggestions'])->name('search-suggestions');
            Route::get('/stats', [CustomerController::class, 'stats'])->name('stats');

            // Customer Groups
            Route::prefix('groups')->name('groups.')->group(function () {
                Route::get('/', [CustomerGroupController::class, 'index'])->name('index');
                Route::get('/create', [CustomerGroupController::class, 'create'])->name('create');
                Route::post('/', [CustomerGroupController::class, 'store'])->name('store');
                Route::get('/trashed', [CustomerGroupController::class, 'trashed'])->name('trashed');
                Route::get('/{customerGroup}/edit', [CustomerGroupController::class, 'edit'])->name('edit');
                Route::put('/{customerGroup}', [CustomerGroupController::class, 'update'])->name('update');
                Route::delete('/{customerGroup}', [CustomerGroupController::class, 'destroy'])->name('destroy');
                Route::post('/{id}/restore', [CustomerGroupController::class, 'restore'])->name('restore');
                Route::delete('/{id}/force-delete', [CustomerGroupController::class, 'forceDelete'])->name('force-delete');
                Route::post('/bulk-delete', [CustomerGroupController::class, 'bulkDelete'])->name('bulk-delete');
                Route::post('/bulk-restore', [CustomerGroupController::class, 'bulkRestore'])->name('bulk-restore');
                Route::post('/bulk-force-delete', [CustomerGroupController::class, 'bulkForceDelete'])->name('bulk-force-delete');
                Route::post('/{customerGroup}/toggle-status', [CustomerGroupController::class, 'toggleStatus'])->name('toggle-status');
                Route::get('/search-suggestions', [CustomerGroupController::class, 'searchSuggestions'])->name('search-suggestions');
                Route::get('/stats', [CustomerGroupController::class, 'stats'])->name('stats');
            });

            // Customer Reports
            Route::prefix('reports')->name('reports.')->group(function () {
                Route::get('/', [CustomerReportController::class, 'index'])->name('index');
                Route::get('/top-customers', [CustomerReportController::class, 'topCustomers'])->name('top-customers');
                Route::get('/highest-spending', [CustomerReportController::class, 'highestSpending'])->name('highest-spending');
                Route::get('/inactive', [CustomerReportController::class, 'inactive'])->name('inactive');
                Route::get('/growth', [CustomerReportController::class, 'growth'])->name('growth');
                Route::get('/export/csv', [CustomerReportController::class, 'exportCsv'])->name('export.csv');
            });
        });

        // Review Routes
        Route::prefix('reviews')->name('reviews.')->group(function () {
            Route::get('/', [ReviewController::class, 'index'])->name('index');
            Route::get('/{review}', [ReviewController::class, 'show'])->name('show');
            Route::post('/{review}/approve', [ReviewController::class, 'approve'])->name('approve');
            Route::post('/{review}/reject', [ReviewController::class, 'reject'])->name('reject');
            Route::delete('/{review}', [ReviewController::class, 'destroy'])->name('destroy');
            Route::post('/{review}/reply', [ReviewController::class, 'reply'])->name('reply');
            Route::delete('/reply/{reply}', [ReviewController::class, 'deleteReply'])->name('reply.delete');
            Route::post('/{review}/mark-verified', [ReviewController::class, 'markVerified'])->name('mark-verified');
        });

        // Coupon Routes
        Route::resource('coupons', CouponController::class)->names([
            'index' => 'coupons.index',
            'create' => 'coupons.create',
            'store' => 'coupons.store',
            'show' => 'coupons.show',
            'edit' => 'coupons.edit',
            'update' => 'coupons.update',
            'destroy' => 'coupons.destroy',
        ]);

        Route::post('/coupons/{coupon}/toggle-status', [CouponController::class, 'toggleStatus'])->name('coupons.toggle-status');

        // Blog Routes
        Route::prefix('blog')->name('blog.')->group(function () {
            Route::get('/', function () {
                return view('admin.blog.index');
            })->name('index');
        });

        // Page Routes
        Route::prefix('pages')->name('pages.')->group(function () {
            Route::get('/', function () {
                return view('admin.pages.index');
            })->name('index');
        });

        // Finance Routes
        Route::prefix('finance')->name('finance.')->group(function () {

            // Dashboard
            Route::get('/', [FinanceDashboardController::class, 'index'])->name('dashboard');
            Route::get('/chart-data', [FinanceDashboardController::class, 'chartData'])->name('chart-data');

            // Chart of Accounts
            Route::resource('accounts', FinanceAccountController::class)->names([
                'index' => 'accounts.index',
                'create' => 'accounts.create',
                'store' => 'accounts.store',
                'show' => 'accounts.show',
                'edit' => 'accounts.edit',
                'update' => 'accounts.update',
                'destroy' => 'accounts.destroy',
            ]);
            Route::post('/accounts/{account}/toggle-status', [FinanceAccountController::class, 'toggleStatus'])->name('accounts.toggle-status');

            // Journal Entries
            Route::controller(FinanceJournalEntryController::class)->prefix('journal-entries')->name('journal-entries.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/', 'store')->name('store');
                Route::get('/{journal_entry}', 'show')->name('show');
                Route::get('/{journal_entry}/edit', 'edit')->name('edit');
                Route::put('/{journal_entry}', 'update')->name('update');
                Route::delete('/{journal_entry}', 'destroy')->name('destroy');
                Route::post('/{journal_entry}/post', 'post')->name('post');
                Route::post('/{journal_entry}/reverse', 'reverse')->name('reverse');
            });

            // Transactions
            Route::controller(FinanceTransactionController::class)->prefix('transactions')->name('transactions.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/{transaction}', 'show')->name('show');
                Route::get('/export/csv', 'exportCsv')->name('export.csv');
            });

            // Expenses
            Route::controller(FinanceExpenseController::class)->prefix('expenses')->name('expenses.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/', 'store')->name('store');
                Route::get('/{expense}', 'show')->name('show');
                Route::get('/{expense}/edit', 'edit')->name('edit');
                Route::put('/{expense}', 'update')->name('update');
                Route::delete('/{expense}', 'destroy')->name('destroy');
                Route::post('/{expense}/approve', 'approve')->name('approve');
                Route::post('/{expense}/cancel', 'cancel')->name('cancel');
                Route::get('/export/csv', 'exportCsv')->name('export.csv');
            });

            // Expense Categories
            Route::resource('expense-categories', FinanceExpenseCategoryController::class)
                ->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])
                ->names([
                    'index' => 'expense-categories.index',
                    'create' => 'expense-categories.create',
                    'store' => 'expense-categories.store',
                    'edit' => 'expense-categories.edit',
                    'update' => 'expense-categories.update',
                    'destroy' => 'expense-categories.destroy',
                ]);

            // Taxes
            Route::controller(FinanceTaxController::class)->prefix('taxes')->name('taxes.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('/groups', 'storeGroup')->name('groups.store');
                Route::put('/groups/{tax_group}', 'updateGroup')->name('groups.update');
                Route::delete('/groups/{tax_group}', 'destroyGroup')->name('groups.destroy');
                Route::post('/rates', 'storeRate')->name('rates.store');
                Route::put('/rates/{tax_rate}', 'updateRate')->name('rates.update');
                Route::delete('/rates/{tax_rate}', 'destroyRate')->name('rates.destroy');
            });

            // Budgets
            Route::controller(FinanceBudgetController::class)->prefix('budgets')->name('budgets.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/', 'store')->name('store');
                Route::get('/{budget}', 'show')->name('show');
                Route::delete('/{budget}', 'destroy')->name('destroy');
                Route::get('/report', 'report')->name('report');
            });

            // Reports
            Route::controller(FinanceReportController::class)->prefix('reports')->name('reports.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/profit-loss', 'profitLoss')->name('profit-loss');
                Route::get('/balance-sheet', 'balanceSheet')->name('balance-sheet');
                Route::get('/trial-balance', 'trialBalance')->name('trial-balance');
                Route::get('/cash-flow', 'cashFlow')->name('cash-flow');
                Route::get('/tax-summary', 'taxSummary')->name('tax-summary');
                Route::get('/accounts-payable', 'accountsPayable')->name('accounts-payable');
                Route::get('/accounts-receivable', 'accountsReceivable')->name('accounts-receivable');
            });

            // Finance Periods
            Route::controller(FinancePeriodController::class)->prefix('periods')->name('periods.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('/', 'store')->name('store');
                Route::post('/{finance_period}/close', 'close')->name('close');
                Route::post('/{finance_period}/lock', 'lock')->name('lock');
                Route::delete('/{finance_period}', 'destroy')->name('destroy');
            });

            // Recurring Expenses
            Route::controller(FinanceRecurringExpenseController::class)->prefix('recurring-expenses')->name('recurring-expenses.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/', 'store')->name('store');
                Route::get('/{recurring_expense}/edit', 'edit')->name('edit');
                Route::put('/{recurring_expense}', 'update')->name('update');
                Route::delete('/{recurring_expense}', 'destroy')->name('destroy');
                Route::post('/{recurring_expense}/toggle-status', 'toggleStatus')->name('toggle-status');
            });

            // Payment Methods
            Route::resource('payment-methods', FinancePaymentMethodController::class)
                ->only(['index', 'store', 'update', 'destroy'])
                ->names([
                    'index' => 'payment-methods.index',
                    'store' => 'payment-methods.store',
                    'update' => 'payment-methods.update',
                    'destroy' => 'payment-methods.destroy',
                ]);
        });

        // Inventory Routes
        Route::prefix('inventory')->name('inventories.')->group(function () {
            Route::get('/', [InventoryController::class, 'index'])->name('index');
            Route::get('/stock-in', [InventoryController::class, 'stockIn'])->name('stock-in');
            Route::post('/stock-in', [InventoryController::class, 'stockInStore'])->name('stock-in.store');
            Route::get('/stock-out', [InventoryController::class, 'stockOut'])->name('stock-out');
            Route::post('/stock-out', [InventoryController::class, 'stockOutStore'])->name('stock-out.store');
            Route::get('/low-stock', [InventoryController::class, 'lowStock'])->name('low-stock');
            Route::get('/history', [InventoryController::class, 'history'])->name('history');
            Route::get('/reports', [InventoryController::class, 'reports'])->name('reports');
            Route::get('/alerts', [InventoryController::class, 'alerts'])->name('alerts');
            Route::get('/get-products', [InventoryController::class, 'getProducts'])->name('get-products');
            Route::get('/barcode-lookup', [InventoryController::class, 'getProductByBarcode'])->name('barcode-lookup');
            Route::get('/dashboard-data', [InventoryController::class, 'dashboardData'])->name('dashboard-data');
            Route::get('/export/csv', [InventoryController::class, 'exportCsv'])->name('export.csv');
            Route::get('/export/excel', [InventoryController::class, 'exportExcel'])->name('export.excel');
        });
    });
});
