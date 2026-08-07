<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->string('brand_code')->nullable()->unique()->after('id');
            $table->string('logo')->nullable()->after('image');
            $table->string('banner')->nullable()->after('logo');
            $table->string('email')->nullable()->after('website');
            $table->string('phone')->nullable()->after('email');
            $table->string('country')->nullable()->after('phone');
            $table->boolean('featured')->default(false)->after('status');
            $table->boolean('popular')->default(false)->after('featured');
            $table->boolean('is_hidden')->default(false)->after('popular');
            $table->string('og_image')->nullable()->after('meta_keywords');
            $table->string('canonical_url')->nullable()->after('og_image');
        });

        Schema::table('brands', function (Blueprint $table) {
            $table->dropIndex(['status', 'sort_order']);
        });

        $driver = DB::getDriverName();

        if ($driver === 'sqlite') {
            Schema::table('brands', function (Blueprint $table) {
                $table->string('status_new', 20)->default('active');
            });
            DB::statement("UPDATE brands SET status_new = CASE WHEN CAST(status AS INTEGER) = 1 THEN 'active' WHEN status = 'active' THEN 'active' WHEN status = 'hidden' THEN 'hidden' ELSE 'inactive' END");
            DB::statement("UPDATE brands SET status_new = 'inactive' WHERE status_new NOT IN ('active', 'inactive', 'hidden')");
            Schema::table('brands', function (Blueprint $table) {
                $table->dropColumn('status');
            });
            Schema::table('brands', function (Blueprint $table) {
                $table->renameColumn('status_new', 'status');
            });
        } elseif ($driver === 'mysql') {
            DB::statement('ALTER TABLE brands MODIFY COLUMN status VARCHAR(20) NOT NULL DEFAULT "active"');
            DB::table('brands')->where('status', '1')->orWhere('status', true)->update(['status' => 'active']);
            DB::table('brands')->where('status', '0')->orWhere('status', false)->update(['status' => 'inactive']);
            DB::table('brands')->whereNotIn('status', ['active', 'inactive', 'hidden'])->update(['status' => 'inactive']);
        } elseif ($driver === 'pgsql') {
            DB::statement("ALTER TABLE brands ALTER COLUMN status TYPE VARCHAR(20) USING CASE WHEN status THEN 'active' ELSE 'inactive' END");
            DB::statement("ALTER TABLE brands ALTER COLUMN status SET DEFAULT 'active'");
        }

        Schema::table('brands', function (Blueprint $table) {
            $table->index(['status', 'sort_order']);
            $table->index('featured');
            $table->index('popular');
            $table->index('country');
        });
    }

    public function down(): void
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->dropIndex(['status', 'sort_order']);
            $table->dropIndex(['featured']);
            $table->dropIndex(['popular']);
            $table->dropIndex(['country']);
        });

        $driver = DB::getDriverName();

        if ($driver === 'sqlite') {
            Schema::table('brands', function (Blueprint $table) {
                $table->boolean('status_old')->default(true);
            });
            DB::statement("UPDATE brands SET status_old = CASE WHEN status IN ('active', '1', 1) THEN 1 ELSE 0 END");
            Schema::table('brands', function (Blueprint $table) {
                $table->dropColumn('status');
            });
            Schema::table('brands', function (Blueprint $table) {
                $table->renameColumn('status_old', 'status');
            });
        } elseif ($driver === 'mysql') {
            DB::statement("UPDATE brands SET status = '1' WHERE status IN ('active', '1')");
            DB::statement("UPDATE brands SET status = '0' WHERE status NOT IN ('active', '1')");
            DB::statement('ALTER TABLE brands MODIFY COLUMN status TINYINT(1) NOT NULL DEFAULT 1');
        } elseif ($driver === 'pgsql') {
            DB::statement("ALTER TABLE brands ALTER COLUMN status TYPE BOOLEAN USING CASE WHEN status = 'active' THEN true ELSE false END");
            DB::statement('ALTER TABLE brands ALTER COLUMN status SET DEFAULT true');
        }

        Schema::table('brands', function (Blueprint $table) {
            $table->dropColumn([
                'brand_code', 'logo', 'banner', 'email', 'phone', 'country',
                'featured', 'popular', 'is_hidden', 'og_image', 'canonical_url',
            ]);
        });

        Schema::table('brands', function (Blueprint $table) {
            $table->index(['status', 'sort_order']);
        });
    }
};
