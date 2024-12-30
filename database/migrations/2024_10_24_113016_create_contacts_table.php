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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->nullable()->constrained();
            $table->foreignId("company_id")->constrained()->cascadeOnDelete();
            $table->string("contact_name");
            $table->string("surname")->nullable();
            $table->string("email")->nullable();
            $table->string("linkedin")->nullable();
            $table->string("mobile")->nullable();
            $table->string("phone")->nullable();
            $table->string("position")->nullable();
            $table->string(column: "department")->nullable();
            $table->boolean("is_main_contact")->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
