<?php

namespace App\View\Components\Admin;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;

class Sidebar extends Component
{
    public array $navigation;

    public function __construct()
    {
        $this->navigation = $this->buildNavigation();
    }

    public function render(): View|Closure|string
    {
        return view('partials.admin.sidebar');
    }

    private function buildNavigation(): array
    {
        $user = Auth::guard('admin')->user();

        return array_filter([
            $this->menuItem('Dashboard', 'admin.dashboard', 'bi bi-grid-1x2-fill'),
            $this->menuItem('Finance', 'admin.finance.dashboard', 'bi bi-calculator-fill', 'finance', [
                $this->menuItem('Dashboard', 'admin.finance.dashboard', 'bi bi-speedometer2'),
                $this->menuItem('Chart of Accounts', 'admin.finance.accounts.index', 'bi bi-journal-text'),
                $this->menuItem('Journal Entries', 'admin.finance.journal-entries.index', 'bi bi-journal-plus'),
                $this->menuItem('Transactions', 'admin.finance.transactions.index', 'bi bi-credit-card-2-front'),
                $this->menuItem('Expenses', 'admin.finance.expenses.index', 'bi bi-cash-stack'),
                $this->menuItem('Expense Categories', 'admin.finance.expense-categories.index', 'bi bi-tag'),
                $this->menuItem('Recurring Expenses', 'admin.finance.recurring-expenses.index', 'bi bi-arrow-repeat'),
                $this->menuItem('Taxes', 'admin.finance.taxes.index', 'bi bi-percent'),
                $this->menuItem('Budgets', 'admin.finance.budgets.index', 'bi bi-pie-chart'),
                $this->menuItem('Finance Periods', 'admin.finance.periods.index', 'bi bi-calendar-range'),
                $this->menuItem('Payment Methods', 'admin.finance.payment-methods.index', 'bi bi-credit-card'),
                $this->menuItem('Reports', 'admin.finance.reports.index', 'bi bi-bar-chart-line'),
            ]),
            $this->menuItem('Orders', 'admin.orders.index', 'bi bi-cart-fill', 'orders'),
            $this->menuItem('Products', 'admin.products.index', 'bi bi-box-seam-fill', 'products'),
            $this->menuItem('Inventory', 'admin.inventories.index', 'bi bi-boxes', 'inventory', [
                $this->menuItem('All Inventory', 'admin.inventories.index', 'bi bi-list'),
                $this->menuItem('Stock In', 'admin.inventories.stock-in', 'bi bi-plus-circle'),
                $this->menuItem('Stock Out', 'admin.inventories.stock-out', 'bi bi-dash-circle'),
                $this->menuItem('Stock Movements', 'admin.stock-movements.index', 'bi bi-arrow-left-right'),
                $this->menuItem('Low Stock', 'admin.inventories.low-stock', 'bi bi-exclamation-triangle'),
                $this->menuItem('History', 'admin.inventories.history', 'bi bi-clock-history'),
                $this->menuItem('Reports', 'admin.inventories.reports', 'bi bi-bar-chart'),
                $this->menuItem('Alerts', 'admin.inventories.alerts', 'bi bi-bell'),
            ]),
            $this->menuItem('Warehouses', 'admin.warehouses.index', 'bi bi-building', 'warehouse', [
                $this->menuItem('All Warehouses', 'admin.warehouses.index', 'bi bi-list'),
                $this->menuItem('Add Warehouse', 'admin.warehouses.create', 'bi bi-plus-circle'),
                $this->menuItem('Trashed', 'admin.warehouses.trashed', 'bi bi-trash'),
            ]),
            $this->menuItem('Brands', 'admin.brands.index', 'bi bi-tag-fill', 'brands'),
            $this->menuItem('Purchases', 'admin.purchases.index', 'bi bi-file-text', 'purchases', [
                $this->menuItem('All POs', 'admin.purchases.index', 'bi bi-list'),
                $this->menuItem('Create PO', 'admin.purchases.create', 'bi bi-plus-circle'),
                $this->menuItem('Reports', 'admin.purchases.reports', 'bi bi-bar-chart'),
            ]),
            $this->menuItem('Suppliers', 'admin.suppliers.index', 'bi bi-truck', 'suppliers'),
            $this->menuItem('Categories', 'admin.categories.index', 'bi bi-tags-fill', 'categories', [
                $this->menuItem('All Categories', 'admin.categories.index', 'bi bi-list'),
                $this->menuItem('Add Category', 'admin.categories.create', 'bi bi-plus-circle'),
                $this->menuItem('Category Tree', 'admin.categories.tree', 'bi bi-sitemap'),
                $this->menuItem('Trash', 'admin.categories.trashed', 'bi bi-trash'),
            ]),
            $this->menuItem('Coupons', 'admin.coupons.index', 'bi bi-ticket-perforated-fill', 'coupons'),
            $this->menuItem('Customers', 'admin.customers.index', 'bi bi-people-fill', 'customers', [
                $this->menuItem('All Customers', 'admin.customers.index', 'bi bi-list'),
                $this->menuItem('Add Customer', 'admin.customers.create', 'bi bi-plus-circle'),
                $this->menuItem('Groups', 'admin.customers.groups.index', 'bi bi-layer-group'),
                $this->menuItem('Reports', 'admin.customers.reports.index', 'bi bi-bar-chart'),
                $this->menuItem('Trashed', 'admin.customers.trashed', 'bi bi-trash'),
            ]),
            $this->menuItem('Reviews', 'admin.reviews.index', 'bi bi-star-fill', 'reviews'),
            $this->menuItem('Blog', 'admin.blog.index', 'bi bi-newspaper', 'blog'),
            $this->menuItem('Pages', 'admin.pages.index', 'bi bi-file-earmark', 'cms'),
            ['type' => 'divider'],
            $this->menuItem('Users', 'admin.users.index', 'bi bi-person-badge', 'users'),
            $this->menuItem('Roles', 'admin.roles.index', 'bi bi-shield-check', 'roles'),
            $this->menuItem('Permissions', 'admin.permissions.index', 'bi bi-lock', 'permissions'),
            ['type' => 'divider'],
            $this->menuItem('Settings', 'admin.settings.index', 'bi bi-gear-fill', 'settings'),
        ]);
    }

    private function menuItem(string $label, string $route, string $icon, ?string $permission = null, array $children = []): ?array
    {
        if ($permission && !empty($children)) {
            $user = Auth::guard('admin')->user();
            if ($user && !$user->can($permission . '.view') && !$user->can($permission . '.manage') && !$user->hasRole('super-admin')) {
                return null;
            }
        } elseif ($permission) {
            $user = Auth::guard('admin')->user();
            if ($user && !$user->can($permission . '.view') && !$user->can($permission . '.manage') && !$user->hasRole('super-admin')) {
                if (!in_array($permission, ['users', 'roles', 'permissions', 'settings'])) {
                    return null;
                }
                if (!$user->can($permission . '.view') && !$user->hasRole('super-admin')) {
                    return null;
                }
            }
        }

        return [
            'label' => $label,
            'route' => $route,
            'icon' => $icon,
            'children' => $children,
        ];
    }

    public function isActive(string $route): bool
    {
        return Route::currentRouteName() === $route;
    }
}
