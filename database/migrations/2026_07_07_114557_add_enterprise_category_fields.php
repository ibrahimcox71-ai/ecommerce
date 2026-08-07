<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('categories')
            ->where('status', 1)
            ->orWhere('status', true)
            ->update(['status' => 'active']);

        DB::table('categories')
            ->where('status', 0)
            ->orWhere('status', false)
            ->update(['status' => 'inactive']);

        if (DB::getDriverName() !== 'sqlite') {
            DB::statement("ALTER TABLE categories MODIFY COLUMN status VARCHAR(20) NOT NULL DEFAULT 'active' AFTER sort_order");
        }

        Schema::table('categories', function (Blueprint $table) {
            $table->string('category_code', 50)->nullable()->after('slug');
            $table->text('short_description')->nullable()->after('description');
            $table->longText('full_description')->nullable()->after('short_description');
            $table->string('banner')->nullable()->after('icon');
            $table->string('thumbnail')->nullable()->after('banner');
            $table->string('seo_image')->nullable()->after('meta_keywords');
            $table->string('canonical_url')->nullable()->after('seo_image');
            $table->text('json_ld')->nullable()->after('canonical_url');
            $table->boolean('featured')->default(false)->after('status');
            $table->boolean('popular')->default(false)->after('featured');
            $table->boolean('show_on_homepage')->default(false)->after('popular');
            $table->boolean('show_in_mega_menu')->default(false)->after('show_on_homepage');
            $table->boolean('show_in_mobile_menu')->default(false)->after('show_in_mega_menu');
            $table->boolean('show_in_sidebar')->default(false)->after('show_in_mobile_menu');
            $table->index(['featured', 'popular', 'show_on_homepage']);
        });
    }

    public function down(): void
    {
        DB::table('categories')
            ->where('status', 'active')
            ->update(['status' => 1]);

        DB::table('categories')
            ->where('status', 'inactive')
            ->update(['status' => 0]);

        DB::table('categories')
            ->whereIn('status', ['draft', 'hidden'])
            ->update(['status' => 0]);

        DB::statement("ALTER TABLE categories MODIFY COLUMN status TINYINT(1) NOT NULL DEFAULT '1' AFTER sort_order");

        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn([
                'category_code', 'short_description', 'full_description',
                'banner', 'thumbnail', 'seo_image',
                'canonical_url', 'json_ld',
                'featured', 'popular',
                'show_on_homepage', 'show_in_mega_menu',
                'show_in_mobile_menu', 'show_in_sidebar',
            ]);
        });
    }
};
