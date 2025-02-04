<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->decimal('income_tax_rate', 5, 2)->nullable();
            $table->boolean('use_real_time_conversion')->default(false);
            $table->timestamps();
            $table->softDeletes();
            
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
