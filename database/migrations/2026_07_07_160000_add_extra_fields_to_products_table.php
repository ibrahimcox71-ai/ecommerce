<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('product_type', 20)->default('simple')->index();
            $table->foreignId('child_category_id')->nullable()->constrained('sub_categories')->nullOnDelete();
            $table->decimal('tax', 5, 2)->default(0);
            $table->string('tax_type', 10)->default('exclusive');
            $table->string('currency', 3)->default('USD');
            $table->integer('min_stock')->default(0);
            $table->boolean('is_hidden')->default(false);
            $table->boolean('is_new_arrival')->default(false);
            $table->string('og_image')->nullable();
            $table->text('schema_markup')->nullable();

            $table->index('is_hidden');
            $table->index('is_new_arrival');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['product_type']);
            $table->dropIndex(['is_hidden']);
            $table->dropIndex(['is_new_arrival']);

            $table->dropForeign(['child_category_id']);
            $table->dropColumn([
                'product_type',
                'child_category_id',
                'tax',
                'tax_type',
                'currency',
                'min_stock',
                'is_hidden',
                'is_new_arrival',
                'og_image',
                'schema_markup',
            ]);
        });
    }
};
