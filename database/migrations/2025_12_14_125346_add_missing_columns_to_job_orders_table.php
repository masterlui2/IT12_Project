<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('job_orders', function (Blueprint $table) {
            // If these columns already exist, remove them from this migration to avoid errors.

            if (!Schema::hasColumn('job_orders', 'quotation_id')) {
                $table->foreignId('quotation_id')
                    ->nullable()
                    ->after('technician_id')
                    ->constrained()
                    ->nullOnDelete();
            }

            if (!Schema::hasColumn('job_orders', 'start_date')) {
                $table->dateTime('start_date')->nullable()->after('quotation_id');
            }

            if (!Schema::hasColumn('job_orders', 'expected_finish_date')) {
                $table->dateTime('expected_finish_date')->nullable()->after('start_date');
            }

            if (!Schema::hasColumn('job_orders', 'timeline_min_days')) {
                $table->unsignedInteger('timeline_min_days')->nullable()->after('expected_finish_date');
            }

            if (!Schema::hasColumn('job_orders', 'timeline_max_days')) {
                $table->unsignedInteger('timeline_max_days')->nullable()->after('timeline_min_days');
            }

            if (!Schema::hasColumn('job_orders', 'technician_notes')) {
                $table->text('technician_notes')->nullable()->after('timeline_max_days');
            }

            if (!Schema::hasColumn('job_orders', 'status')) {
                $table->string('status')->default('scheduled')->after('technician_notes');
            }

            if (!Schema::hasColumn('job_orders', 'completed_at')) {
                $table->dateTime('completed_at')->nullable()->after('status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('job_orders', function (Blueprint $table) {
            // Drop FK first if it exists
            if (Schema::hasColumn('job_orders', 'quotation_id')) {
                $table->dropForeign(['quotation_id']);
                $table->dropColumn('quotation_id');
            }

            foreach ([
                'start_date',
                'expected_finish_date',
                'timeline_min_days',
                'timeline_max_days',
                'technician_notes',
                'status',
                'completed_at',
            ] as $col) {
                if (Schema::hasColumn('job_orders', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
