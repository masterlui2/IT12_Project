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
        
        // Customer Information
        $table->unsignedBigInteger('customer_id')->nullable(); // nullable for guest inquiries
        $table->string('name');
        $table->string('contact_number', 20);
        $table->string('email');
        $table->text('service_location'); // changed to text for longer addresses
        
        // Service Details
        $table->string('category'); // Computer/Laptop, Networking, etc.
        $table->string('device_details')->nullable();
        $table->text('issue_description'); // changed to text for detailed descriptions
        $table->string('photo_path')->nullable(); // store uploaded photo path
        
        // Scheduling & Priority
        $table->enum('urgency', ['Normal', 'Urgent', 'Flexible'])->default('Normal');
        $table->dateTime('preferred_schedule')->nullable();
        
        // Tracking & Marketing
        $table->enum('status', [
            'Pending', 
            'Acknowledged', 
            'In Progress', 
            'Completed', 
            'Cancelled'
        ])->default('Pending');
        $table->string('referral_source')->nullable();
        
        // Admin Assignment (for later use)
        $table->unsignedBigInteger('assigned_technician_id')->nullable();
        $table->text('admin_notes')->nullable();
        
        // Timestamps
        $table->timestamps();
        $table->softDeletes(); // for archiving instead of hard delete
        
        // Foreign Keys
        $table->foreign('customer_id')
            ->references('id')
            ->on('users')
            ->onDelete('set null');
        
        $table->foreign('assigned_technician_id')
            ->references('id')
            ->on('users')
            ->onDelete('set null');
        
        // Indexes for better query performance
        $table->index('status');
        $table->index('urgency');
        $table->index('category');
        $table->index('created_at');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};
