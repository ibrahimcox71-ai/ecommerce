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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            
            // Basic Information
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sku')->unique();
            $table->string('barcode')->nullable()->unique();
            
            // Category Relations
            $table->foreignId('category_id')->index();
            $table->foreignId('sub_category_id')->nullable()->index();
            $table->foreignId('brand_id')->nullable()->index();
            
            // Descriptions
            $table->longText('description')->nullable();
            $table->text('short_description')->nullable();
            
            // Media
            $table->string('thumbnail')->nullable();
            $table->string('video_url')->nullable();
            
            // Pricing
            $table->decimal('price', 12, 2)->default(0);
            $table->decimal('discount', 12, 2)->nullable();
            $table->string('discount_type')->default('percentage'); // percentage, fixed
            $table->timestamp('discount_start')->nullable();
            $table->timestamp('discount_end')->nullable();
            $table->decimal('cost_price', 12, 2)->default(0);
            
            // Inventory
            $table->integer('stock')->default(0);
            $table->boolean('unlimited_stock')->default(false);
            $table->integer('low_stock_threshold')->default(10);
            
            // Product Flags
            $table->string('status')->default('draft'); // draft, active, inactive, archived
            $table->boolean('featured')->default(false);
            $table->boolean('trending')->default(false);
            $table->boolean('best_seller')->default(false);
            
            // SEO
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('canonical_url')->nullable();
            
            // Tags (stored as JSON)
            $table->json('tags')->nullable();
            
            // Specifications (stored as JSON - key-value pairs)
            $table->json('specifications')->nullable();
            
            // Dimensions & Weight
            $table->decimal('weight', 8, 2)->nullable();
            $table->string('weight_unit')->default('kg');
            $table->decimal('length', 8, 2)->nullable();
            $table->decimal('width', 8, 2)->nullable();
            $table->decimal('height', 8, 2)->nullable();
            $table->string('dimension_unit')->default('cm');
            
            // Warranty
            $table->string('warranty_type')->nullable(); // no_warranty, manufacturer, seller
            $table->integer('warranty_period')->nullable(); // in days
            
            // Additional Settings
            $table->boolean('is_virtual')->default(false); // Digital product
            $table->string('download_link')->nullable();
            $table->integer('min_order_quantity')->default(1);
            $table->integer('max_order_quantity')->nullable();
            
            // SEO Score
            $table->integer('seo_score')->nullable();
            
            // Sorting
            $table->integer('sort_order')->default(0);
            
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
            
            // Publish dates
            $table->timestamp('published_at')->nullable();
            
            // Indexes
            $table->index(['category_id', 'status']);
            $table->index(['brand_id', 'status']);
            $table->index(['status', 'featured']);
            $table->index(['status', 'trending']);
            $table->index(['status', 'best_seller']);
            $table->index('slug');
            $table->index('sku');
            $table->index('price');
            $table->index('published_at');
            $table->index(['status', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
