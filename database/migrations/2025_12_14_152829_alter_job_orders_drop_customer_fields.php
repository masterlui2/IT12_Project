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
    Schema::table('job_orders', function (Blueprint $table) {

        if (Schema::hasColumn('job_orders', 'customer_name')) {
            $table->dropColumn('customer_name');
        }

        if (Schema::hasColumn('job_orders', 'contact_number')) {
            $table->dropColumn('contact_number');
        }

        if (Schema::hasColumn('job_orders', 'device_type')) {
            $table->dropColumn('device_type');
        }

        if (Schema::hasColumn('job_orders', 'issue_description')) {
            $table->dropColumn('issue_description');
        }

        if (Schema::hasColumn('job_orders', 'diagnostic_fee')) {
            $table->dropColumn('diagnostic_fee');
        }

        if (Schema::hasColumn('job_orders', 'materials_cost')) {
            $table->dropColumn('materials_cost');
        }

        if (Schema::hasColumn('job_orders', 'professional_fee')) {
            $table->dropColumn('professional_fee');
        }

        if (Schema::hasColumn('job_orders', 'downpayment')) {
            $table->dropColumn('downpayment');
        }

        if (Schema::hasColumn('job_orders', 'balance')) {
            $table->dropColumn('balance');
        }
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
