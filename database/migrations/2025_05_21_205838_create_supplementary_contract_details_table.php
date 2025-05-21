<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('supplementary_contract_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contract_id')
                ->constrained('contracts')
                ->cascadeOnDelete();
            $table->string('standard_working_hours')->nullable();
            $table->string('shift_schedule')->nullable();
            $table->string('notice_period')->nullable();
            $table->string('payment_terms')->nullable();
            $table->string('billing_currency')->nullable();
            $table->string('payment_currency')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplementary_contract_details');
    }
};
