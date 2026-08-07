<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('site_name')->nullable()->after('id');
            $table->string('meta_title')->nullable()->after('site_name');
            $table->text('meta_description')->nullable()->after('meta_title');
            $table->text('meta_keywords')->nullable()->after('meta_description');
            $table->string('canonical_url')->nullable()->after('meta_keywords');
            $table->string('og_image')->nullable()->after('canonical_url');
            $table->string('og_type')->default('website')->after('og_image');
            $table->text('schema_markup')->nullable()->after('og_type');
            $table->string('robots')->default('index,follow')->after('schema_markup');
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'site_name', 'meta_title', 'meta_description', 'meta_keywords',
                'canonical_url', 'og_image', 'og_type', 'schema_markup', 'robots',
            ]);
        });
    }
};
