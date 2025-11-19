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
        Schema::create('quotation_cases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('scope_id')->constrained('quotation_scope')->onDelete('cascade');
            $table->string('case_title');
            $table->text('case_description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotation_cases');
    }
};
