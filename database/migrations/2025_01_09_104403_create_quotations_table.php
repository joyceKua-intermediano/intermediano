<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('country_id')->constrained()->cascadeOnDelete();
            $table->foreignId('consultant_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('currency_name');
            $table->decimal('exchange_rate', 10, 2);
            $table->string('exchange_acronym');
            $table->decimal('gross_salary', 15, 2);
            $table->decimal('fee', 15, 2);
            $table->decimal('bank_fee', 15, 2);
            $table->decimal('bonus', 15, 2)->default(0);
            $table->decimal('home_allowance', 15, 2)->default(0);
            $table->decimal('transport_allowance', 15, 2)->default(0);
            $table->decimal('medical_allowance', 15, 2)->default(0);
            $table->decimal('internet_allowance', 15, 2)->default(0);
            $table->decimal('legal_grafication', 15, 2)->default(0);
            $table->decimal('uvt_amount', 15, 2)->default(0);
            $table->decimal('capped_amount', 15, 2)->default(0);
            $table->boolean('dependent')->default(0);
            $table->boolean('is_payroll')->default(0);
            $table->boolean('is_integral')->default(0);
            $table->string('cluster_name');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};
