<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $this->safeIndex('customers', 'user_id');
        $this->safeIndex('customers', 'customer_group_id');
        $this->safeIndex('customers', 'status');
        $this->safeIndex('customers', 'customer_type');
        $this->safeIndex('stock_movements', ['causer_type', 'causer_id']);
        $this->safeIndex('activity_logs', ['subject_type', 'subject_id']);
        $this->safeIndex('activity_logs', 'log_name');
        $this->safeIndex('activity_logs', ['causer_type', 'causer_id']);
        $this->safeIndex('products', 'product_type');
        $this->safeIndex('reviews', ['user_id', 'product_id']);
        $this->safeIndex('purchases', 'status');
        $this->safeIndex('transactions', 'transaction_date');
        $this->safeIndex('finance_periods', ['start_date', 'end_date']);
    }

    private function safeIndex(string $table, string|array $columns): void
    {
        try {
            Schema::table($table, function (Blueprint $t) use ($columns) {
                $t->index($columns);
            });
        } catch (\Exception $e) {
            // Index already exists — skip
        }
    }

    public function down(): void
    {
    }
};
