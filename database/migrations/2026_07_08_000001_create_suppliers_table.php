<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();

            // Core Information
            $table->string('supplier_code')->unique();
            $table->string('name');
            $table->string('company_name')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('alternative_phone')->nullable();
            $table->string('website')->nullable();

            // Business Registration
            $table->string('trade_license_number')->nullable();
            $table->string('tax_vat_number')->nullable();

            // Address
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('postal_code')->nullable();
            $table->text('full_address')->nullable();

            // Additional
            $table->text('description')->nullable();
            $table->string('logo')->nullable();
            $table->string('status')->default('active');

            // Purchase Information
            $table->string('payment_terms')->nullable();
            $table->decimal('credit_limit', 15, 2)->nullable();
            $table->string('currency')->default('USD');
            $table->text('bank_information')->nullable();
            $table->decimal('outstanding_balance', 15, 2)->default(0);
            $table->timestamp('last_purchase_date')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
