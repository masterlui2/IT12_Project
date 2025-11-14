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
        Schema::create('job_parts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("Job_ID");
            $table->unsignedBigInteger("Part_ID");
            $table->integer("Quantity_Used");
            $table->decimal("Subtotal",2,0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_parts');
    }
};
