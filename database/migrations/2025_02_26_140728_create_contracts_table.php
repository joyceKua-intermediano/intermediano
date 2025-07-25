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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('partner_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('intermediano_company_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->foreignId('quotation_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('country_work')->nullable();
            $table->string('job_title')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('gross_salary')->nullable();
            $table->string('contract_type')->nullable();
            $table->text('job_description')->nullable();
            $table->text('translated_job_description')->nullable();
            $table->string('cluster_name');
            $table->boolean('is_sent_to_employee')->default(0);
            $table->string('signature')->default('Pending Signature');
            $table->datetime('signed_contract')->nullable();
            $table->string('admin_signature')->default('Pending Signature');
            $table->datetime('admin_signed_contract')->nullable();
            $table->foreignId('admin_signed_by')->constrained('user')->cascadeOnDelete();

            $table->boolean('is_integral')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
