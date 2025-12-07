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
            if (! Schema::hasColumn('inquiries', 'deleted_at')) {
                $table->softDeletes();
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
            if (Schema::hasColumn('inquiries', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });
    }
};