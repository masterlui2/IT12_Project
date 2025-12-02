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
        Schema::create('quotation_waivers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('quotation_id')
                  ->constrained('quotations')
                  ->onDelete('cascade');

            // 👇 match the seeder fields
            $table->string('waiver_title')->nullable();
            $table->text('waiver_description')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quotation_waivers');
    }
};