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
        Schema::create('social_security_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->foreignId('document_id')->constrained()->cascadeOnDelete();
            $table->string('health_fund')->nullable();
            $table->string('pension_fund')->nullable();
            $table->string('severance_fund')->nullable();
            $table->string('social_security_number')->nullable();
            $table->string('health_fund_file')->nullable();
            $table->string('pension_fund_file')->nullable();
            $table->string('severance_fund_file')->nullable();
            $table->string('social_security_file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_security_infos');
    }
};
