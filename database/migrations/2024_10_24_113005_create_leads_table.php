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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->nullable()->constrained();
            $table->foreignId("opportunity_owner")->nullable()->constrained("users");
            $table->foreignId("company_id")->nullable()->constrained();
            $table->string("lead");
            $table->string("opportunity_name");
            $table->string("country")->nullable();
            $table->string("opportunity_type")->nullable(); // MSP, CMO Global, CMO Regional, Other
            $table->boolean("a2t")->nullable(); 
            $table->string("contact_name")->nullable();
            $table->string("lead_source")->nullable(); // Self-Generated, Referral)
            $table->string("lead_status")->nullable(); // Presentation, Need Analysis, Pricing Submitted, Pricing Negotiation, Negotiation, MSA & Pricing Review, Closed – Won, Closed – Cancelled,  Closed – Lost
            $table->text("close_reason")->nullable();
            $table->integer("number_of_contractors")->nullable();
            $table->decimal("estimated_tender_value", 10, 2)->nullable();
            $table->date("estimated_close_date")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
