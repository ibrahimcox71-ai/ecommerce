<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Orders - payment status, fulfillment timestamps, creation date
        Schema::table('orders', function (Blueprint $table) {
            $table->index('payment_status');
            $table->index('created_at');
            $table->index('paid_at');
            $table->index('shipped_at');
            $table->index('delivered_at');
        });

        // Reviews - most queried for product display
        Schema::table('reviews', function (Blueprint $table) {
            $table->index(['product_id', 'status']);
            $table->index('rating');
            $table->index('created_at');
        });

        // Coupons - checkout validation
        Schema::table('coupons', function (Blueprint $table) {
            $table->index('is_active');
            $table->index(['starts_at', 'expires_at']);
        });

        // Addresses - user's address lookups by type
        Schema::table('addresses', function (Blueprint $table) {
            $table->index(['user_id', 'type']);
            $table->index('type');
        });

        // Notifications - unread notification queries
        Schema::table('notifications', function (Blueprint $table) {
            $table->index('read_at');
            $table->index(['notifiable_type', 'notifiable_id', 'read_at']);
        });

        // Activity logs - date range browsing
        Schema::table('activity_logs', function (Blueprint $table) {
            $table->index('created_at');
        });

        // Review images - ordered loading
        Schema::table('review_images', function (Blueprint $table) {
            $table->index(['review_id', 'sort_order']);
        });

        // Review replies - ordered loading
        Schema::table('review_replies', function (Blueprint $table) {
            $table->index(['review_id', 'created_at']);
        });

        // Carts - expired cart cleanup
        Schema::table('carts', function (Blueprint $table) {
            $table->index('expires_at');
        });

        // Cart items - composite for duplicate prevention
        Schema::table('cart_items', function (Blueprint $table) {
            $table->index(['cart_id', 'product_id']);
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex(['payment_status']);
            $table->dropIndex(['created_at']);
            $table->dropIndex(['paid_at']);
            $table->dropIndex(['shipped_at']);
            $table->dropIndex(['delivered_at']);
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->dropIndex(['product_id', 'status']);
            $table->dropIndex(['rating']);
            $table->dropIndex(['created_at']);
        });

        Schema::table('coupons', function (Blueprint $table) {
            $table->dropIndex(['is_active']);
            $table->dropIndex(['starts_at', 'expires_at']);
        });

        Schema::table('addresses', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'type']);
            $table->dropIndex(['type']);
        });

        Schema::table('notifications', function (Blueprint $table) {
            $table->dropIndex(['read_at']);
            $table->dropIndex(['notifiable_type', 'notifiable_id', 'read_at']);
        });

        Schema::table('activity_logs', function (Blueprint $table) {
            $table->dropIndex(['created_at']);
        });

        Schema::table('review_images', function (Blueprint $table) {
            $table->dropIndex(['review_id', 'sort_order']);
        });

        Schema::table('review_replies', function (Blueprint $table) {
            $table->dropIndex(['review_id', 'created_at']);
        });

        Schema::table('carts', function (Blueprint $table) {
            $table->dropIndex(['expires_at']);
        });

        Schema::table('cart_items', function (Blueprint $table) {
            $table->dropIndex(['cart_id', 'product_id']);
        });
    }
};
