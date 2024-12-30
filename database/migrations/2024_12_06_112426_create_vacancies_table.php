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
        Schema::create('vacancies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable()->constrained();
            $table->foreignId('contact_id')->nullable()->constrained();
            $table->string("job_title");
            $table->integer('number_of_openings');
            $table->enum("work_type", ["On-Site", "Hybrid", "Home Office"])->nullable();
            $table->string("location")->nullable()->comment("Country/City");
            $table->integer("salary")->nullable();
            $table->enum("contract_model", ["Indefinite Period", "Temporary Contract"])->nullable();
            $table->text('work_schedule')->nullable();
            $table->date('target_start_date')->nullable();
            $table->text('summary')->nullable();
            $table->string("education")->nullable();
            $table->text('profile')->nullable();
            $table->text('other_info')->nullable();
            $table->enum("status", ["Open", "In Progress", "Waiting", "Cancelled", "Finalized"])->default("Open");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vacancies');
    }
};
