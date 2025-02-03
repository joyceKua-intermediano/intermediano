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
        Schema::create('country_annual_setups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->constrained()->cascadeOnDelete();
            $table->string('year');
            $table->decimal('uvt_amount', 15, 2)->nullable();
            $table->decimal('capped_amount', 15, 2)->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->unique(['country_id', 'year'], 'country_year_unique');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('country_annual_setups');
    }
};
