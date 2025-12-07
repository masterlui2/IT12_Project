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
        if (! Schema::hasTable('inquiries')) {
            return;
        }

        Schema::table('inquiries', function (Blueprint $table) {
            if (! Schema::hasColumn('inquiries', 'assigned_technician_id')) {
                $table->unsignedBigInteger('assigned_technician_id')->nullable()->after('referral_source');
                $table->foreign('assigned_technician_id')
                    ->references('id')
                    ->on('technicians')
                    ->nullOnDelete();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasTable('inquiries')) {
            return;
        }

        Schema::table('inquiries', function (Blueprint $table) {
            if (Schema::hasColumn('inquiries', 'assigned_technician_id')) {
                $table->dropForeign(['assigned_technician_id']);
                $table->dropColumn('assigned_technician_id');
            }
        });
    }
};