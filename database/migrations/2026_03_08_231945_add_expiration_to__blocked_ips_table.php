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
        Schema::table('blocked_ips', function (Blueprint $table) {
            $table->unsignedInteger('duration_minutes')->default(1440)->after('reason');
            $table->timestamp('expires_at')->nullable()->after('blocked_at');
            $table->index('expires_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blocked_ips', function (Blueprint $table) {
            $table->dropIndex(['expires_at']);
            $table->dropColumn(['duration_minutes', 'expires_at']);
        });
    }
};