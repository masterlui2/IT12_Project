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
        Schema::create('quotation', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("Inquiry_ID");
            $table->unsignedBigInteger("Technician_ID");
            $table->decimal("Labor_Estimate", 2,0);
            $table->decimal("Parts_Estimate", 2,0);
            $table->decimal("Diagnostic_Fee", 2,0);
            $table->decimal("Grand_Total", 2,0);
            $table->string("Status");
            $table->string("Date_Issued");
            $table->unsignedBigInteger("Approved_By");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotation');
    }
};
