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
    Schema::create('inquiries', function (Blueprint $table) {
        $table->id();

        $table->unsignedBigInteger('customer_id')->nullable();
        $table->string('category')->nullable();
        $table->string('device_type')->nullable();
        $table->string('referral_source')->nullable(); // ADD THIS
        $table->unsignedBigInteger('assigned_technician_id')->nullable();

        $table->text('description')->nullable();

        $table->timestamps();
        $table->softDeletes();
    });
}

public function down(): void
{
    Schema::dropIfExists('inquiries');
}
};
