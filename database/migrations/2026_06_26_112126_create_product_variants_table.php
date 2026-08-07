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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->index();
            $table->string('name'); // Variant name (e.g., "Red / Large")
            $table->string('sku')->unique();
            $table->string('barcode')->nullable()->unique();
            
            // Pricing (overrides product price if set)
            $table->decimal('price', 12, 2)->nullable();
            $table->decimal('discount', 12, 2)->nullable();
            $table->decimal('cost_price', 12, 2)->nullable();
            
            // Stock
            $table->integer('stock')->default(0);
            $table->boolean('unlimited_stock')->default(false);
            
            // Image
            $table->string('image')->nullable();
            
            // Status
            $table->boolean('status')->default(true);
            
            // Additional attributes specific to variant
            $table->decimal('weight', 8, 2)->nullable();
            
            // Sort order
            $table->integer('sort_order')->default(0);
            
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['product_id', 'status']);
            $table->index('sku');
            $table->index('barcode');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
