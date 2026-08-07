<?php

namespace Database\Seeders;

use App\Models\Warehouse;
use Illuminate\Database\Seeder;

class WarehouseSeeder extends Seeder
{
    public function run(): void
    {
        $warehouses = [
            [
                'name' => 'Main Warehouse',
                'manager_name' => 'Ahmed Hassan',
                'code' => 'WH-MAIN',
                'address' => '123 Industrial Area',
                'city' => 'Cairo',
                'state' => 'Cairo Governorate',
                'country' => 'Egypt',
                'postal_code' => '11511',
                'phone' => '+20 2 1234 5678',
                'email' => 'main.warehouse@example.com',
                'is_default' => true,
                'status' => true,
                'sort_order' => 0,
            ],
            [
                'name' => 'Alexandria Warehouse',
                'manager_name' => 'Mona Said',
                'code' => 'WH-ALEX',
                'address' => '456 Port Street',
                'city' => 'Alexandria',
                'state' => 'Alexandria Governorate',
                'country' => 'Egypt',
                'postal_code' => '21511',
                'phone' => '+20 3 5678 9012',
                'email' => 'alex.warehouse@example.com',
                'is_default' => false,
                'status' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Giza Distribution Center',
                'manager_name' => 'Khaled Ibrahim',
                'code' => 'WH-GIZA',
                'address' => '789 Pyramids Road',
                'city' => 'Giza',
                'state' => 'Giza Governorate',
                'country' => 'Egypt',
                'postal_code' => '12511',
                'phone' => '+20 2 3456 7890',
                'email' => 'giza.warehouse@example.com',
                'is_default' => false,
                'status' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Returns & Damages Warehouse',
                'manager_name' => 'Sara Mostafa',
                'code' => 'WH-RETURN',
                'address' => '12 Logistics Zone',
                'city' => 'Cairo',
                'state' => 'Cairo Governorate',
                'country' => 'Egypt',
                'postal_code' => '11728',
                'phone' => '+20 2 7890 1234',
                'email' => 'returns.warehouse@example.com',
                'is_default' => false,
                'status' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Overflow Storage',
                'manager_name' => null,
                'code' => 'WH-OF',
                'address' => '500 Storage Way',
                'city' => 'Cairo',
                'state' => 'Cairo Governorate',
                'country' => 'Egypt',
                'postal_code' => '11835',
                'phone' => null,
                'email' => null,
                'is_default' => false,
                'status' => false,
                'sort_order' => 4,
            ],
        ];

        foreach ($warehouses as $warehouse) {
            Warehouse::create($warehouse);
        }

        $this->command?->info('Warehouses seeded successfully.');
    }
}
