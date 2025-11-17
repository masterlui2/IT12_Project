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
    Schema::table('inquiries', function (Blueprint $table) {
        $table->dateTime('preferred_schedule')->nullable()->after('issue_description');
        // You can also add a 'status' column if you need it here:
        // $table->string('status')->default('new')->after('preferred_schedule');
    });
}

public function down(): void
{
    Schema::table('inquiries', function (Blueprint $table) {
        $table->dropColumn([ 'preferred_schedule']);
        // Drop 'status' here as well if you added it in up()
    });
}

};
