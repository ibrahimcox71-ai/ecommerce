<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->index();
            $table->foreignId('product_variant_id')->nullable()->index();
            $table->foreignId('from_warehouse_id')->nullable()->index();
            $table->foreignId('to_warehouse_id')->nullable()->index();

            $table->string('movement_type'); // stock_in, stock_out, adjustment, transfer, return, damage, lost
            $table->integer('quantity');
            $table->integer('quantity_before')->default(0);
            $table->integer('quantity_after')->default(0);
            $table->string('reference_number')->nullable()->unique();
            $table->string('reason')->nullable();
            $table->text('notes')->nullable();

            $table->string('causer_type')->nullable();
            $table->unsignedBigInteger('causer_id')->nullable();

            $table->timestamps();

            $table->index(['product_id', 'movement_type', 'created_at']);
            $table->index(['from_warehouse_id', 'movement_type']);
            $table->index(['to_warehouse_id', 'movement_type']);
            $table->index('reference_number');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};
