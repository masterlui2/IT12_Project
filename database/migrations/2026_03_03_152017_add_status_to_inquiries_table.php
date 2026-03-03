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
        if (! Schema::hasColumn('inquiries', 'status')) {
            Schema::table('inquiries', function (Blueprint $table) {
                $table->string('status')->nullable()->after('assigned_technician_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('inquiries', 'status')) {
            Schema::table('inquiries', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }
    }
};
