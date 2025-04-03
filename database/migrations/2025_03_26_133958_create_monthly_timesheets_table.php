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
        Schema::create('monthly_timesheets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained();
            $table->foreignId('company_id')->constrained();
            $table->integer('year');
            $table->integer('month');
            $table->json('days');
            $table->decimal('total_hours', 8, 2);
            $table->string('status')->default('pending');
            $table->string('comment')->nullable();
            $table->timestamps();
            
            $table->unique(['employee_id', 'year', 'month']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monthly_timesheets');
    }
};
