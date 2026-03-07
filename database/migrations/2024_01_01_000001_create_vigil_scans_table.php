<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vigil_scans', function (Blueprint $table) {
            $table->id();
            $table->timestamp('started_at');
            $table->timestamp('finished_at')->nullable();
            $table->integer('total_checks')->default(0);
            $table->integer('passed_count')->default(0);
            $table->integer('failed_count')->default(0);
            $table->integer('warning_count')->default(0);
            $table->integer('skipped_count')->default(0);
            $table->tinyInteger('security_score')->default(0);
            $table->timestamps();

            $table->index('started_at');
            $table->index('security_score');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vigil_scans');
    }
};
