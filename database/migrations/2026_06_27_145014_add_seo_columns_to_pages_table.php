<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->string('title')->nullable()->after('id');
            $table->string('slug')->unique()->nullable()->after('title');
            $table->longText('content')->nullable()->after('slug');
            $table->string('meta_title')->nullable()->after('content');
            $table->text('meta_description')->nullable()->after('meta_title');
            $table->text('meta_keywords')->nullable()->after('meta_description');
            $table->string('canonical_url')->nullable()->after('meta_keywords');
            $table->string('og_image')->nullable()->after('canonical_url');
            $table->text('schema_markup')->nullable()->after('og_image');
            $table->boolean('status')->default(true)->after('schema_markup');
        });
    }

    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn([
                'title', 'slug', 'content', 'meta_title', 'meta_description',
                'meta_keywords', 'canonical_url', 'og_image', 'schema_markup', 'status',
            ]);
        });
    }
};
