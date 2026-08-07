<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('cart_id')->nullable()->constrained('carts')->nullOnDelete();
            $table->foreignId('coupon_id')->nullable()->constrained('coupons')->nullOnDelete();
            $table->string('order_number', 50)->unique();
            $table->string('status', 30)->default('pending')->index();
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('coupon_discount', 12, 2)->default(0);
            $table->decimal('shipping_cost', 12, 2)->default(0);
            $table->decimal('tax_rate', 5, 2)->default(0);
            $table->decimal('tax_amount', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);
            $table->decimal('paid_amount', 12, 2)->default(0);
            $table->string('payment_status', 30)->default('pending');
            $table->string('shipping_method', 100)->nullable();
            $table->json('shipping_address')->nullable();
            $table->json('billing_address')->nullable();
            $table->text('notes')->nullable();
            $table->string('currency', 10)->default('USD');
            $table->string('invoice_number', 50)->nullable()->unique();
            $table->timestamp('invoice_at')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->text('cancel_reason')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['cart_id']);
            $table->dropForeign(['coupon_id']);
            $table->dropColumn([
                'user_id', 'cart_id', 'coupon_id', 'order_number', 'status',
                'subtotal', 'coupon_discount', 'shipping_cost', 'tax_rate', 'tax_amount',
                'total', 'paid_amount', 'payment_status', 'shipping_method',
                'shipping_address', 'billing_address', 'notes', 'currency',
                'invoice_number', 'invoice_at', 'paid_at', 'shipped_at',
                'delivered_at', 'cancelled_at', 'cancel_reason',
            ]);
        });
    }
};
