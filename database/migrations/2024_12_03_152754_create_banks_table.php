<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('banks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->constrained()->cascadeOnDelete();
            $table->string('bank_name')->nullable();
            $table->timestamps();
            $table->softDeletes();

        });
    }
    public function down(): void
    {
        Schema::dropIfExists('banks');
    }
};
