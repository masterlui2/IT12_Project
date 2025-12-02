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
        Schema::create('job_orders', function (Blueprint $table) {
            $table->id();

            // link quotation that generated this job order
            $table->foreignId('quotation_id')
                ->constrained()
                ->onDelete('cascade');

            // technician assigned
            $table->foreignId('technician_id')
                ->constrained()
                ->onDelete('cascade');

            // customer details
            $table->string('customer_name');
            $table->string('contact_number');
            $table->string('device_type')->nullable();
            $table->text('issue_description');
            
            // cost summary (copied or adjusted from quotation)
            $table->decimal('diagnostic_fee', 12, 2)->default(0);
            $table->decimal('materials_cost', 12, 2)->default(0);
            $table->decimal('professional_fee', 12, 2)->default(0);
            $table->decimal('downpayment', 12, 2)->default(0);
            $table->decimal('balance', 12, 2)->default(0);

            // work control fields
            $table->date('expected_finish_date')->nullable();
            $table->text('remarks')->nullable();
            $table->text('materials_specifications')->nullable();

            // workflow status
            $table->enum('status', ['scheduled', 'in_progress', 'completed', 'cancelled'])
                ->default('scheduled');

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_orders');
    }
};
