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
        Schema::create('service_template_waiver_cases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('waiver_id')->constrained('service_template_waivers')->onDelete('cascade');
            $table->string('case_title');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_templates_waiver_cases');
    }
};
