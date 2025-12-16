<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('job_orders', function (Blueprint $table) {
        $table->dropColumn([
            'customer_name',
            'contact_number',
            'device_type',
            'issue_description',
            'diagnostic_fee',
            'materials_cost',
            'professional_fee',
            'downpayment',
            'balance',
        ]);
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
