<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_orders', function (Blueprint $table) {
            $table->id();

            // Link to quotation that generated this job order
            $table->foreignId('quotation_id')
                ->constrained()
                ->onDelete('cascade');

            // Technician assigned
            $table->foreignId('technician_id')
                ->constrained()
                ->onDelete('cascade');

            // Work control
            $table->date('start_date')->nullable();
            $table->date('expected_finish_date')->nullable();
            
            // Timeline estimate (actual days worked)
            $table->unsignedInteger('timeline_min_days')->nullable();
            $table->unsignedInteger('timeline_max_days')->nullable();

            // Technician work notes
            $table->text('technician_notes')->nullable();

            // Workflow status
            $table->enum('status', ['scheduled', 'in_progress', 'review', 'completed', 'cancelled'])
                ->default('scheduled');
            
            $table->timestamp('completed_at')->nullable();

            // Completion signatures

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_orders');
    }
};