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
        Schema::create('product_variant_attribute_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_variant_id')->index();
            $table->foreignId('attribute_id')->index();
            $table->foreignId('attribute_value_id')->nullable()->index();
            $table->string('custom_value')->nullable(); // For custom text values
            
            $table->timestamps();
            
            $table->unique(['product_variant_id', 'attribute_id'], 'variant_attribute_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variant_attribute_values');
    }
};
