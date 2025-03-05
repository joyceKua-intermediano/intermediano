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
        Schema::create('msp_payrolls', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->decimal('fee', 15, 2)->default(0);
            $table->decimal('bank_fee', 15, 2)->default(0);
            $table->json('data')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('msp_payrolls');
    }
};
