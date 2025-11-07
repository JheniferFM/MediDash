<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('exams') && !Schema::hasColumn('exams', 'doctor_id')) {
            Schema::table('exams', function (Blueprint $table) {
                $table->foreignId('doctor_id')->nullable()->constrained('doctors')->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('exams') && Schema::hasColumn('exams', 'doctor_id')) {
            Schema::table('exams', function (Blueprint $table) {
                $table->dropConstrainedForeignId('doctor_id');
            });
        }
    }
};