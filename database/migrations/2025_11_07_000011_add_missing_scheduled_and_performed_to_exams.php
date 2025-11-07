<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('exams')) {
            Schema::table('exams', function (Blueprint $table) {
                if (!Schema::hasColumn('exams', 'scheduled_date')) {
                    $table->date('scheduled_date')->nullable();
                }
                if (!Schema::hasColumn('exams', 'performed_date')) {
                    $table->date('performed_date')->nullable();
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('exams')) {
            Schema::table('exams', function (Blueprint $table) {
                if (Schema::hasColumn('exams', 'scheduled_date')) {
                    $table->dropColumn('scheduled_date');
                }
                if (Schema::hasColumn('exams', 'performed_date')) {
                    $table->dropColumn('performed_date');
                }
            });
        }
    }
};