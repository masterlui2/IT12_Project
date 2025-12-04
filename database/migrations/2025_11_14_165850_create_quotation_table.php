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
        Schema::create('quotations', function (Blueprint $table) {
            $table->engine = 'InnoDB';  
            $table->id();

            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('technician_id');
            $table->unsignedBigInteger('approved_by')->nullable(); // single manager (user with role='manager')
            $table->string('client_logo')->nullable();
            $table->string('client_name')->nullable();
            $table->string('client_address')->nullable();
            $table->string('project_title')->nullable();
            $table->date('date_issued')->nullable();
            $table->text('objective')->nullable();
            $table->integer('timeline_min_days')->nullable();
            $table->integer('timeline_max_days')->nullable();
            $table->text('terms_conditions')->nullable();
            
            $table->decimal('labor_estimate', 10, 2)->default(0);
            $table->decimal('parts_estimate', 10, 2)->default(0);
            $table->decimal('diagnostic_fee', 10, 2)->default(0);
            $table->decimal('grand_total', 12, 2)->default(0);

            $table->enum('status', ['draft', 'pending', 'approved', 'rejected'])->default('draft');
            $table->timestamps();

            // Foreign keys
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('technician_id')->references('id')->on('technicians')->onDelete('cascade');
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};
