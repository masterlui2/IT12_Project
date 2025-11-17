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
    $table->string('name')->after('user_id');
    $table->string('contact_number')->after('name');
    $table->dateTime('preferred_schedule')->nullable()->after('issue_description');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inquiries', function (Blueprint $table) {
            //
        });
    }
};
