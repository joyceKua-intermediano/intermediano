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
        Schema::create('payment_provisions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quotation_id')->constrained()->onDelete('cascade');
            $table->foreignId('provision_type_id')->constrained()->onDelete('cascade');
            $table->foreignId('country_id')->constrained()->onDelete('cascade');
            $table->string('cluster_name');
            $table->decimal('amount', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_provisions');
    }
};
