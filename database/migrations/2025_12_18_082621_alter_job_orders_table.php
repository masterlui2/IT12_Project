<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('job_orders', function (Blueprint $table) {
            // Add price fields after technician_notes
            $table->decimal('subtotal', 10, 2)->default(0)->after('technician_notes');
            $table->decimal('downpayment', 10, 2)->default(0)->after('subtotal');
            $table->decimal('total_amount', 10, 2)->default(0)->after('downpayment');
            
            // Optional: Add discount fields if needed
            // $table->decimal('discount_amount', 10, 2)->default(0)->after('subtotal');
            // $table->string('discount_type')->nullable()->after('discount_amount'); // 'percentage' or 'fixed'
        });
    }

    public function down(): void
    {
        Schema::table('job_orders', function (Blueprint $table) {
            $table->dropColumn(['subtotal', 'downpayment', 'total_amount']);
            // $table->dropColumn(['discount_amount', 'discount_type']); // if you added these
        });
    }
};