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
        Schema::create('quotation_signatures', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quotation_id');
            $table->string('customer_name')->nullable();
            $table->string('customer_signature')->nullable(); // could be image path or drawn data
            $table->date('customer_date')->nullable();

            $table->string('provider_name')->nullable();
            $table->string('provider_signature')->nullable();
            $table->date('provider_date')->nullable();

            $table->timestamps();

            $table->foreign('quotation_id')
                ->references('id')->on('quotations')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotation_signatures');
    }
};
