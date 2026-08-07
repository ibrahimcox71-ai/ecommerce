<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->index();
            $table->foreignId('product_variant_id')->nullable()->index();
            $table->foreignId('warehouse_id')->index();
            
            // Stock levels
            $table->integer('quantity')->default(0);
            $table->integer('reserved_quantity')->default(0); // Reserved for pending orders
            $table->integer('low_stock_threshold')->default(10);
            
            // Stock history tracking
            $table->string('last_stock_adjustment')->nullable();
            $table->timestamp('last_stock_update')->nullable();
            
            $table->timestamps();
            
            $table->unique(['product_id', 'product_variant_id', 'warehouse_id'], 'product_variant_warehouse_unique');
            $table->index(['product_id', 'warehouse_id']);
            $table->index(['warehouse_id', 'quantity']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
