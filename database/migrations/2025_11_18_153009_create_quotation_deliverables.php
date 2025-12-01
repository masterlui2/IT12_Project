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

            // Foreign key MUST match quotations.id (bigint unsigned)
            $table->foreignId('quotation_id')
                  ->constrained('quotations')   // make sure the table is named "quotations"
                  ->onDelete('cascade');

            // Your other columns:
            // e.g.
            $table->string('item_name');
            $table->integer('quantity')->default(1);
            $table->decimal('price', 10, 2)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quotation_deliverables');
    }
};
