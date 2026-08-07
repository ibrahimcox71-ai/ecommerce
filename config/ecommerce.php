<?php

return [

    'name' => env('APP_NAME', 'Ecommerce'),

    'currency' => env('ECOMMERCE_CURRENCY', 'USD'),

    'currency_symbol' => env('ECOMMERCE_CURRENCY_SYMBOL', '$'),

    'tax_rate' => env('ECOMMERCE_TAX_RATE', 0),

    'shipping' => [
        'free_threshold' => env('FREE_SHIPPING_THRESHOLD', 100),
        'flat_rate' => env('SHIPPING_FLAT_RATE', 10),
    ],

    'pagination' => [
        'per_page' => env('PAGINATION_PER_PAGE', 15),
        'admin_per_page' => env('ADMIN_PAGINATION_PER_PAGE', 20),
    ],

    'order' => [
        'prefix' => env('ORDER_PREFIX', 'ORD-'),
        'invoice_prefix' => env('INVOICE_PREFIX', 'INV-'),
        'auto_invoice' => env('ORDER_AUTO_INVOICE', true),
        'allow_guest_checkout' => env('ALLOW_GUEST_CHECKOUT', true),
        'auto_complete_days' => env('ORDER_AUTO_COMPLETE_DAYS', 7),
    ],

    'store_address' => env('STORE_ADDRESS', '123 Store Street, New York, NY 10001, United States'),
    'store_phone' => env('STORE_PHONE', '+1 (555) 123-4567'),
    'store_email' => env('STORE_EMAIL', 'store@example.com'),

    'review' => [
        'moderation' => env('REVIEW_MODERATION', true),
        'max_per_user' => env('REVIEW_MAX_PER_USER', 1),
    ],

    'image' => [
        'max_size' => env('IMAGE_MAX_SIZE', 2048),
        'quality' => env('IMAGE_QUALITY', 80),
        'thumbnail_width' => env('IMAGE_THUMBNAIL_WIDTH', 300),
        'thumbnail_height' => env('IMAGE_THUMBNAIL_HEIGHT', 300),
    ],

    'export' => [
        'chunk_size' => env('EXPORT_CHUNK_SIZE', 500),
        'csv_delimiter' => env('EXPORT_CSV_DELIMITER', ','),
    ],

    'cache' => [
        'product_ttl' => env('CACHE_PRODUCT_TTL', 3600),
        'category_ttl' => env('CACHE_CATEGORY_TTL', 3600),
    ],

    'inventory' => [
        'low_stock_threshold' => env('INVENTORY_LOW_STOCK_THRESHOLD', 10),
        'default_reorder_level' => env('INVENTORY_DEFAULT_REORDER_LEVEL', 20),
        'negative_stock_prevention' => env('INVENTORY_NEGATIVE_STOCK_PREVENTION', true),
        'auto_notify_low_stock' => env('INVENTORY_AUTO_NOTIFY_LOW_STOCK', true),
    ],

    'supplier' => [
        'code_prefix' => env('SUPPLIER_CODE_PREFIX', 'SUP'),
    ],

    'brand' => [
        'code_prefix' => env('BRAND_CODE_PREFIX', 'BRD'),
    ],

    'warehouse' => [
        'code_prefix' => env('WAREHOUSE_CODE_PREFIX', 'WH-'),
    ],

    'purchase' => [
        'po_prefix' => env('PO_PREFIX', 'PO'),
        'grn_prefix' => env('GRN_PREFIX', 'GRN'),
        'return_prefix' => env('PURCHASE_RETURN_PREFIX', 'PRN'),
        'auto_approve' => env('PURCHASE_AUTO_APPROVE', false),
    ],

    'finance' => [
        'currency' => env('FINANCE_CURRENCY', 'USD'),
        'currency_symbol' => env('FINANCE_CURRENCY_SYMBOL', '$'),
        'decimal_places' => env('FINANCE_DECIMAL_PLACES', 2),
        'default_tax_group' => env('FINANCE_DEFAULT_TAX_GROUP', null),
        'auto_generate_je_number' => env('FINANCE_AUTO_GENERATE_JE_NUMBER', true),
        'je_number_prefix' => env('FINANCE_JE_PREFIX', 'JE-'),
        'expense_prefix' => env('FINANCE_EXPENSE_PREFIX', 'EXP-'),
        'transaction_prefix' => env('FINANCE_TRANSACTION_PREFIX', 'TXN-'),
        'account_code_prefix' => env('FINANCE_ACCOUNT_CODE_PREFIX', ''),
        'enable_budget_alerts' => env('FINANCE_ENABLE_BUDGET_ALERTS', true),
        'budget_threshold_percentage' => env('FINANCE_BUDGET_THRESHOLD_PERCENTAGE', 80),
        'fiscal_year_start' => env('FINANCE_FISCAL_YEAR_START', '01-01'),
        'enable_recurring_expenses' => env('FINANCE_ENABLE_RECURRING_EXPENSES', true),
        'recurring_auto_create' => env('FINANCE_RECURRING_AUTO_CREATE', true),
        'recurring_check_interval' => env('FINANCE_RECURRING_CHECK_INTERVAL', 60),
        'default_payment_method' => env('FINANCE_DEFAULT_PAYMENT_METHOD', null),
        'require_approval' => env('FINANCE_REQUIRE_APPROVAL', true),
        'allow_partial_approval' => env('FINANCE_ALLOW_PARTIAL_APPROVAL', false),
    ],

];
