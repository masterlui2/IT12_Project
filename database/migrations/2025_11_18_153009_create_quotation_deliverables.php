<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quotation_deliverables', function (Blueprint $table) {
            $table->id();

            // Link to quotations table
            $table->foreignId('quotation_id')
                  ->constrained('quotations')
                  ->onDelete('cascade');

            // 👇 This is what your model and controller use
            $table->string('deliverable_detail');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quotation_deliverables');
    }
};
