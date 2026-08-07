<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'admin']);
        $customerRole = Role::firstOrCreate(['name' => 'customer', 'guard_name' => 'web']);

        $admin = Admin::firstOrCreate(
            ['email' => 'admin@ecommerce.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'phone' => '1234567890',
                'status' => true,
                'role' => 'super-admin',
            ]
        );
        $admin->assignRole($adminRole);

        $user = User::firstOrCreate(
            ['email' => 'customer@ecommerce.com'],
            [
                'name' => 'John Doe',
                'password' => Hash::make('password'),
                'phone' => '0987654321',
                'status' => true,
            ]
        );
        $user->assignRole($customerRole);
    }
}
