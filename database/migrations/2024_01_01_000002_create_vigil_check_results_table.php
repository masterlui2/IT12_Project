<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vigil_check_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vigil_scan_id')
                ->constrained('vigil_scans')
                ->cascadeOnDelete();
            $table->string('check_id');
            $table->string('title');
            $table->string('category');
            $table->string('severity');
            $table->string('status');
            $table->text('message');
            $table->json('details')->nullable();
            $table->text('recommendation')->nullable();
            $table->timestamps();

            $table->index('check_id');
            $table->index('category');
            $table->index('severity');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vigil_check_results');
    }
};
