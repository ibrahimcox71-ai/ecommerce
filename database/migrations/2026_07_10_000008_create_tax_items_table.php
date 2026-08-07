<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tax_items', function (Blueprint $table) {
            $table->id();
            $table->string('taxable_type');
            $table->unsignedBigInteger('taxable_id');
            $table->foreignId('tax_rate_id')->constrained('tax_rates')->restrictOnDelete();
            $table->decimal('amount', 15, 2);
            $table->decimal('rate', 5, 2);
            $table->string('region')->nullable();
            $table->timestamps();

            $table->index(['taxable_type', 'taxable_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tax_items');
    }
};
