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
        Schema::create('service_agreement', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("Quotation_ID");
            $table->unsignedBigInteger("Job_ID");
            $table->string("Customer_Signature");
            $table->date("Technician_Date");
            $table->date("Warranty_Period");
            $table->string("Terms_Notes");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_agreement');
    }
};
