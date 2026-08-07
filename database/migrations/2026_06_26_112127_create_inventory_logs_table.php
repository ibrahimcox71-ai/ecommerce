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
        Schema::create('inventory_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->index();
            $table->foreignId('product_variant_id')->nullable()->index();
            $table->foreignId('warehouse_id')->index();
            
            // Reference
            $table->string('reference_type')->nullable(); // order, return, adjustment, transfer
            $table->unsignedBigInteger('reference_id')->nullable();
            
            // Change details
            $table->integer('quantity_before');
            $table->integer('quantity_after');
            $table->integer('quantity_change'); // positive or negative
            $table->string('reason')->nullable();
            $table->string('note')->nullable();
            
            // User who made the change
            $table->string('causer_type')->nullable();
            $table->unsignedBigInteger('causer_id')->nullable();
            
            $table->timestamps();
            
            $table->index(['product_id', 'created_at']);
            $table->index(['warehouse_id', 'created_at']);
            $table->index(['reference_type', 'reference_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_logs');
    }
};
