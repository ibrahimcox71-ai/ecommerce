<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $superAdmin = Admin::firstOrCreate(
            ['email' => 'admin@ecommerce.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'phone' => '1234567890',
                'status' => true,
                'role' => 'super-admin',
            ]
        );
        $superAdmin->assignRole('super-admin');

        $adminUser = Admin::firstOrCreate(
            ['email' => 'manager@ecommerce.com'],
            [
                'name' => 'Store Manager',
                'password' => Hash::make('password'),
                'phone' => '0987654321',
                'status' => true,
                'role' => 'manager',
            ]
        );
        $adminUser->assignRole('manager');

        $this->command?->info('Admin users created successfully.');
    }
}
