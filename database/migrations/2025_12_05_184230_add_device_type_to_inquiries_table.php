<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('inquiries')) {
            if (Schema::hasColumn('inquiries', 'device_type')) {
                // Ensure existing column is nullable for backward compatibility
                DB::statement('ALTER TABLE inquiries MODIFY device_type VARCHAR(255) NULL');
            } else {
                Schema::table('inquiries', function (Blueprint $table) {
                    $table->string('device_type')->nullable()->after('category');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('inquiries')) {
            Schema::table('inquiries', function (Blueprint $table) {
                if (Schema::hasColumn('inquiries', 'device_type')) {
                    $table->dropColumn('device_type');
                }
            });
        }
    }
};