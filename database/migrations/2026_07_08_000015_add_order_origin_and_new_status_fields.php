<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'order_origin')) {
                $table->string('order_origin', 30)->default('website')->after('id');
            }
            if (!Schema::hasColumn('orders', 'ready_to_ship_at')) {
                $table->timestamp('ready_to_ship_at')->nullable()->after('packing_at');
            }
            if (!Schema::hasColumn('orders', 'out_for_delivery_at')) {
                $table->timestamp('out_for_delivery_at')->nullable()->after('shipping_at');
            }
            if (!Schema::hasColumn('orders', 'completed_at')) {
                $table->timestamp('completed_at')->nullable()->after('delivered_at');
            }
            if (!Schema::hasColumn('orders', 'estimated_delivery')) {
                $table->date('estimated_delivery')->nullable()->after('carrier');
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'order_origin',
                'ready_to_ship_at',
                'out_for_delivery_at',
                'completed_at',
                'estimated_delivery',
            ]);
        });
    }
};
