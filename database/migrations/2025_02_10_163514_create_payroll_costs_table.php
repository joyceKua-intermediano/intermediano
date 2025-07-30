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
        Schema::create('payroll_costs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quotation_id')->constrained()->cascadeOnDelete();
            $table->decimal('medical_insurance', 15, 6)->default(0);
            $table->decimal('meal', 15, 6)->default(0);
            $table->decimal('transportation', 15, 6)->default(0);
            $table->decimal('uf_month', 15, 6)->default(0);
            $table->decimal('eps', 15, 6)->default(0);
            $table->decimal('notice', 15, 6)->default(0);
            $table->decimal('unemployment', 15, 6)->default(0);
            $table->decimal('operational_costs', 15, 6)->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payroll_costs');
    }
};
