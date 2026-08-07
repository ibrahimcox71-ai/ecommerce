<?php

namespace App\Enums;

enum PermissionGroup: string
{
    case Dashboard = 'dashboard';
    case Products = 'products';
    case Categories = 'categories';
    case Brands = 'brands';
    case Inventory = 'inventory';
    case Warehouse = 'warehouse';
    case Suppliers = 'suppliers';
    case Purchases = 'purchases';
    case Orders = 'orders';
    case Customers = 'customers';
    case Reviews = 'reviews';
    case Coupons = 'coupons';
    case FlashSales = 'flash-sales';
    case Reports = 'reports';
    case Finance = 'finance';
    case Accounts = 'accounts';
    case Journals = 'journals';
    case Expenses = 'expenses';
    case ExpenseCategories = 'expense-categories';
    case RecurringExpenses = 'recurring-expenses';
    case Taxes = 'taxes';
    case Budgets = 'budgets';
    case Periods = 'periods';
    case PaymentMethods = 'payment-methods';
    case Transactions = 'transactions';
    case Payments = 'payments';
    case Shipping = 'shipping';
    case CMS = 'cms';
    case Blog = 'blog';
    case Media = 'media';
    case Banners = 'banners';
    case Menus = 'menus';
    case Users = 'users';
    case Roles = 'roles';
    case Permissions = 'permissions';
    case Settings = 'settings';
    case SystemLogs = 'system-logs';
    case Backup = 'backup';
    case Profile = 'profile';
    case Notifications = 'notifications';

    public function label(): string
    {
        return match ($this) {
            self::Dashboard => 'Dashboard',
            self::Products => 'Products',
            self::Categories => 'Categories',
            self::Brands => 'Brands',
            self::Inventory => 'Inventory',
            self::Warehouse => 'Warehouse',
            self::Suppliers => 'Suppliers',
            self::Purchases => 'Purchases',
            self::Orders => 'Orders',
            self::Customers => 'Customers',
            self::Reviews => 'Reviews',
            self::Coupons => 'Coupons',
            self::FlashSales => 'Flash Sales',
            self::Reports => 'Reports',
            self::Finance => 'Finance',
            self::Accounts => 'Chart of Accounts',
            self::Journals => 'Journal Entries',
            self::Expenses => 'Expenses',
            self::ExpenseCategories => 'Expense Categories',
            self::RecurringExpenses => 'Recurring Expenses',
            self::Taxes => 'Taxes',
            self::Budgets => 'Budgets',
            self::Periods => 'Finance Periods',
            self::PaymentMethods => 'Payment Methods',
            self::Transactions => 'Transactions',
            self::Payments => 'Payments',
            self::Shipping => 'Shipping',
            self::CMS => 'CMS',
            self::Blog => 'Blog',
            self::Media => 'Media',
            self::Banners => 'Banners',
            self::Menus => 'Menus',
            self::Users => 'Users',
            self::Roles => 'Roles',
            self::Permissions => 'Permissions',
            self::Settings => 'Settings',
            self::SystemLogs => 'System Logs',
            self::Backup => 'Backup',
            self::Profile => 'Profile',
            self::Notifications => 'Notifications',
        };
    }

    public static function permissionTypes(): array
    {
        return [
            'view', 'create', 'edit', 'delete', 'restore',
            'export', 'import', 'approve', 'reject',
            'publish', 'unpublish', 'manage',
        ];
    }
}
