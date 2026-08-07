<?php

namespace Database\Seeders;

use App\Enums\PermissionGroup;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $this->createPermissions();
        $this->assignPermissionsToRoles();
    }

    private function createPermissions(): void
    {
        $permissionNames = [];

        foreach (PermissionGroup::cases() as $group) {
            foreach (PermissionGroup::permissionTypes() as $type) {
                $permissionNames[] = $group->value . '.' . $type;
            }
        }

        foreach ($permissionNames as $name) {
            Permission::firstOrCreate(
                ['name' => $name, 'guard_name' => 'admin'],
                ['name' => $name, 'guard_name' => 'admin']
            );
        }

        $this->command?->info('All permissions created successfully.');
    }

    private function assignPermissionsToRoles(): void
    {
        $superAdmin = Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'admin']);
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'admin']);
        $manager = Role::firstOrCreate(['name' => 'manager', 'guard_name' => 'admin']);
        $inventoryManager = Role::firstOrCreate(['name' => 'inventory-manager', 'guard_name' => 'admin']);
        $orderManager = Role::firstOrCreate(['name' => 'order-manager', 'guard_name' => 'admin']);
        $customerSupport = Role::firstOrCreate(['name' => 'customer-support', 'guard_name' => 'admin']);
        $marketingManager = Role::firstOrCreate(['name' => 'marketing-manager', 'guard_name' => 'admin']);
        $contentManager = Role::firstOrCreate(['name' => 'content-manager', 'guard_name' => 'admin']);
        $accountant = Role::firstOrCreate(['name' => 'accountant', 'guard_name' => 'admin']);
        $deliveryManager = Role::firstOrCreate(['name' => 'delivery-manager', 'guard_name' => 'admin']);
        $staff = Role::firstOrCreate(['name' => 'staff', 'guard_name' => 'admin']);
        $moderator = Role::firstOrCreate(['name' => 'moderator', 'guard_name' => 'admin']);
        $vendor = Role::firstOrCreate(['name' => 'vendor', 'guard_name' => 'admin']);
        $customer = Role::firstOrCreate(['name' => 'customer', 'guard_name' => 'web']);

        $superAdmin->syncPermissions(Permission::where('guard_name', 'admin')->get());

        $admin->syncPermissions(Permission::where('guard_name', 'admin')
            ->whereNotIn('name', [
                'permissions.manage', 'permissions.create', 'permissions.edit', 'permissions.delete',
                'roles.manage', 'roles.create', 'roles.edit', 'roles.delete',
                'users.manage', 'users.create', 'users.edit', 'users.delete',
                'settings.manage',
                'system-logs.view',
                'backup.manage',
            ])->pluck('name')->toArray());

        $manager->syncPermissions([
            'dashboard.view',
            'products.view', 'products.create', 'products.edit', 'products.delete',
            'categories.view', 'categories.create', 'categories.edit',
            'brands.view', 'brands.create', 'brands.edit',
            'orders.view', 'orders.create', 'orders.edit',
            'customers.view', 'customers.create', 'customers.edit',
            'reports.view',
            'profile.view', 'profile.edit',
        ]);

        $inventoryManager->syncPermissions([
            'dashboard.view',
            'products.view',
            'inventory.view', 'inventory.create', 'inventory.edit', 'inventory.manage',
            'warehouse.view', 'warehouse.create', 'warehouse.edit',
            'suppliers.view', 'suppliers.create', 'suppliers.edit',
            'reports.view',
            'profile.view', 'profile.edit',
        ]);

        $orderManager->syncPermissions([
            'dashboard.view',
            'orders.view', 'orders.create', 'orders.edit', 'orders.export',
            'shipping.view', 'shipping.edit',
            'payments.view',
            'customers.view',
            'reports.view',
            'profile.view', 'profile.edit',
        ]);

        $customerSupport->syncPermissions([
            'dashboard.view',
            'orders.view', 'orders.edit',
            'customers.view', 'customers.edit',
            'reviews.view', 'reviews.approve', 'reviews.reject',
            'profile.view', 'profile.edit',
        ]);

        $marketingManager->syncPermissions([
            'dashboard.view',
            'coupons.view', 'coupons.create', 'coupons.edit', 'coupons.delete',
            'flash-sales.view', 'flash-sales.create', 'flash-sales.edit',
            'banners.view', 'banners.create', 'banners.edit', 'banners.publish',
            'reports.view',
            'notifications.view', 'notifications.create',
            'profile.view', 'profile.edit',
        ]);

        $contentManager->syncPermissions([
            'dashboard.view',
            'cms.view', 'cms.create', 'cms.edit', 'cms.publish',
            'blog.view', 'blog.create', 'blog.edit', 'blog.publish', 'blog.delete',
            'media.view', 'media.create', 'media.delete',
            'menus.view', 'menus.edit',
            'profile.view', 'profile.edit',
        ]);

        $accountant->syncPermissions([
            'dashboard.view',
            'accounts.view', 'accounts.create', 'accounts.edit',
            'journals.view', 'journals.create', 'journals.edit', 'journals.approve',
            'expenses.view', 'expenses.create', 'expenses.edit', 'expenses.approve', 'expenses.export',
            'expense-categories.view', 'expense-categories.create', 'expense-categories.edit',
            'recurring-expenses.view', 'recurring-expenses.create', 'recurring-expenses.edit',
            'taxes.view', 'taxes.create', 'taxes.edit',
            'budgets.view', 'budgets.create', 'budgets.edit',
            'periods.view', 'periods.create', 'periods.approve',
            'payment-methods.view',
            'finance.view',
            'transactions.view', 'transactions.export',
            'payments.view', 'payments.approve', 'payments.reject',
            'reports.view', 'reports.export',
            'orders.view',
            'profile.view', 'profile.edit',
        ]);

        $deliveryManager->syncPermissions([
            'dashboard.view',
            'orders.view', 'orders.edit',
            'shipping.view', 'shipping.edit', 'shipping.manage',
            'profile.view', 'profile.edit',
        ]);

        $staff->syncPermissions([
            'dashboard.view',
            'products.view', 'products.create', 'products.edit',
            'orders.view', 'orders.create', 'orders.edit',
            'customers.view',
            'profile.view', 'profile.edit',
        ]);

        $moderator->syncPermissions([
            'dashboard.view',
            'reviews.view', 'reviews.approve', 'reviews.reject',
            'products.view',
            'customers.view',
            'profile.view', 'profile.edit',
        ]);

        $vendor->syncPermissions([
            'dashboard.view',
            'products.view', 'products.create', 'products.edit',
            'inventory.view',
            'orders.view',
            'reviews.view',
            'profile.view', 'profile.edit',
        ]);

        $this->command?->info('Permissions assigned to roles successfully.');
    }
}
