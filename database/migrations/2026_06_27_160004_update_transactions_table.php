<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->foreignId('payment_id')->nullable()->constrained('payments')->nullOnDelete();
            $table->string('type', 30)->default('payment');
            $table->decimal('amount', 12, 2)->default(0);
            $table->string('status', 30)->default('pending');
            $table->string('reference', 100)->nullable();
            $table->json('gateway_response')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
            $table->dropForeign(['payment_id']);
            $table->dropColumn([
                'order_id', 'payment_id', 'type', 'amount',
                'status', 'reference', 'gateway_response',
            ]);
        });
    }
};
