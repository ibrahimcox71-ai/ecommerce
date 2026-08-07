<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('warehouses', function (Blueprint $table) {
            $table->string('manager_name')->nullable()->after('name');
        });

        Schema::table('inventories', function (Blueprint $table) {
            $table->integer('incoming_stock')->default(0)->after('reserved_quantity');
            $table->integer('damaged_stock')->default(0)->after('incoming_stock');
            $table->integer('returned_stock')->default(0)->after('damaged_stock');
            $table->integer('minimum_stock')->default(0)->after('low_stock_threshold');
            $table->integer('maximum_stock')->default(0)->after('minimum_stock');
            $table->integer('reorder_level')->default(0)->after('maximum_stock');
        });
    }

    public function down(): void
    {
        Schema::table('warehouses', function (Blueprint $table) {
            $table->dropColumn('manager_name');
        });

        Schema::table('inventories', function (Blueprint $table) {
            $table->dropColumn(['incoming_stock', 'damaged_stock', 'returned_stock', 'minimum_stock', 'maximum_stock', 'reorder_level']);
        });
    }
};
