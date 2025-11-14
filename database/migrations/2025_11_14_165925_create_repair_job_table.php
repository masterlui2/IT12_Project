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
        Schema::create('repair_job', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("Quotation_ID");
            $table->unsignedBigInteger("Technician_ID");
            $table->date("Start_Date");
            $table->date("Completion_Date");
            $table->string("Job_Status");
            $table->decimal("Total_Cost",2,0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repair_job');
    }
};
