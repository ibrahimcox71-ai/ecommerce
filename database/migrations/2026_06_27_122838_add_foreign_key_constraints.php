<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // categories.parent_id → categories.id
        Schema::table('categories', function (Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on('categories')->nullOnDelete();
        });

        // sub_categories.category_id → categories.id
        Schema::table('sub_categories', function (Blueprint $table) {
            $table->foreign('category_id')->references('id')->on('categories')->cascadeOnDelete();
        });

        // products.category_id → categories.id
        Schema::table('products', function (Blueprint $table) {
            $table->foreign('category_id')->references('id')->on('categories')->cascadeOnDelete();
        });

        // products.sub_category_id → sub_categories.id
        Schema::table('products', function (Blueprint $table) {
            $table->foreign('sub_category_id')->references('id')->on('sub_categories')->nullOnDelete();
        });

        // products.brand_id → brands.id
        Schema::table('products', function (Blueprint $table) {
            $table->foreign('brand_id')->references('id')->on('brands')->nullOnDelete();
        });

        // product_variants.product_id → products.id
        Schema::table('product_variants', function (Blueprint $table) {
            $table->foreign('product_id')->references('id')->on('products')->cascadeOnDelete();
        });

        // product_images.product_id → products.id
        Schema::table('product_images', function (Blueprint $table) {
            $table->foreign('product_id')->references('id')->on('products')->cascadeOnDelete();
        });

        // attribute_values.attribute_id → attributes.id
        Schema::table('attribute_values', function (Blueprint $table) {
            $table->foreign('attribute_id')->references('id')->on('attributes')->cascadeOnDelete();
        });

        // product_variant_attribute_values.product_variant_id → product_variants.id
        Schema::table('product_variant_attribute_values', function (Blueprint $table) {
            $table->foreign('product_variant_id')->references('id')->on('product_variants')->cascadeOnDelete();
        });

        // product_variant_attribute_values.attribute_id → attributes.id
        Schema::table('product_variant_attribute_values', function (Blueprint $table) {
            $table->foreign('attribute_id')->references('id')->on('attributes')->cascadeOnDelete();
        });

        // product_variant_attribute_values.attribute_value_id → attribute_values.id
        Schema::table('product_variant_attribute_values', function (Blueprint $table) {
            $table->foreign('attribute_value_id')->references('id')->on('attribute_values')->nullOnDelete();
        });

        // inventories.product_id → products.id
        Schema::table('inventories', function (Blueprint $table) {
            $table->foreign('product_id')->references('id')->on('products')->cascadeOnDelete();
        });

        // inventories.product_variant_id → product_variants.id
        Schema::table('inventories', function (Blueprint $table) {
            $table->foreign('product_variant_id')->references('id')->on('product_variants')->cascadeOnDelete();
        });

        // inventories.warehouse_id → warehouses.id
        Schema::table('inventories', function (Blueprint $table) {
            $table->foreign('warehouse_id')->references('id')->on('warehouses')->cascadeOnDelete();
        });

        // inventory_logs.product_id → products.id
        Schema::table('inventory_logs', function (Blueprint $table) {
            $table->foreign('product_id')->references('id')->on('products')->cascadeOnDelete();
        });

        // inventory_logs.product_variant_id → product_variants.id
        Schema::table('inventory_logs', function (Blueprint $table) {
            $table->foreign('product_variant_id')->references('id')->on('product_variants')->cascadeOnDelete();
        });

        // inventory_logs.warehouse_id → warehouses.id
        Schema::table('inventory_logs', function (Blueprint $table) {
            $table->foreign('warehouse_id')->references('id')->on('warehouses')->cascadeOnDelete();
        });

        // product_warehouse.product_id → products.id
        Schema::table('product_warehouse', function (Blueprint $table) {
            $table->foreign('product_id')->references('id')->on('products')->cascadeOnDelete();
        });

        // product_warehouse.warehouse_id → warehouses.id
        Schema::table('product_warehouse', function (Blueprint $table) {
            $table->foreign('warehouse_id')->references('id')->on('warehouses')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('product_warehouse', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropForeign(['warehouse_id']);
        });

        Schema::table('inventory_logs', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropForeign(['product_variant_id']);
            $table->dropForeign(['warehouse_id']);
        });

        Schema::table('inventories', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropForeign(['product_variant_id']);
            $table->dropForeign(['warehouse_id']);
        });

        Schema::table('product_variant_attribute_values', function (Blueprint $table) {
            $table->dropForeign(['product_variant_id']);
            $table->dropForeign(['attribute_id']);
            $table->dropForeign(['attribute_value_id']);
        });

        Schema::table('attribute_values', function (Blueprint $table) {
            $table->dropForeign(['attribute_id']);
        });

        Schema::table('product_images', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
        });

        Schema::table('product_variants', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropForeign(['sub_category_id']);
            $table->dropForeign(['brand_id']);
        });

        Schema::table('sub_categories', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
        });
    }
};
