<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        Brand::factory()->create([
            'name' => 'Nike',
            'slug' => 'nike',
            'brand_code' => 'BRN-0001',
            'status' => 'active',
            'featured' => true,
            'popular' => true,
            'country' => 'United States',
            'website' => 'https://www.nike.com',
        ]);

        Brand::factory()->create([
            'name' => 'Adidas',
            'slug' => 'adidas',
            'brand_code' => 'BRN-0002',
            'status' => 'active',
            'featured' => true,
            'popular' => true,
            'country' => 'Germany',
            'website' => 'https://www.adidas.com',
        ]);

        Brand::factory()->create([
            'name' => 'Apple',
            'slug' => 'apple',
            'brand_code' => 'BRN-0003',
            'status' => 'active',
            'featured' => true,
            'country' => 'United States',
            'website' => 'https://www.apple.com',
        ]);

        Brand::factory()->create([
            'name' => 'Samsung',
            'slug' => 'samsung',
            'brand_code' => 'BRN-0004',
            'status' => 'active',
            'country' => 'South Korea',
            'website' => 'https://www.samsung.com',
        ]);

        Brand::factory()->create([
            'name' => 'Sony',
            'slug' => 'sony',
            'brand_code' => 'BRN-0005',
            'status' => 'active',
            'country' => 'Japan',
            'website' => 'https://www.sony.com',
        ]);

        Brand::factory()->count(10)->create();
    }
}
