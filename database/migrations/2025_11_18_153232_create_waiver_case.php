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
        Schema::create('waiver_cases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('waiver_id');
            $table->string('case_title');
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('waiver_id')
                ->references('id')->on('quotation_waivers')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waiver_cases');
    }
};
