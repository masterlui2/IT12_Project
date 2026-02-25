<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
{
    Schema::table('job_orders', function (Blueprint $table) {
        $table->foreign('quotation_id')
              ->references('id')
              ->on('quotations')
              ->nullOnDelete();
    });
}

  public function down(): void
{
    Schema::table('job_orders', function (Blueprint $table) {
        $table->dropForeign(['quotation_id']);
    });
}
};

