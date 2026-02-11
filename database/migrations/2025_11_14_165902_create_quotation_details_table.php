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
        Schema::create('quotation_details', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('quotation_id');
        $table->string('item_name')->nullable();
        $table->text('description')->nullable();
        $table->integer('quantity')->default(1);
        $table->decimal('unit_price', 10, 2)->default(0);
        $table->decimal('total', 12, 2)->default(0);
        $table->timestamps();

        $table->foreign('quotation_id')->references('id')->on('quotations')->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotation_details');
    }
};
