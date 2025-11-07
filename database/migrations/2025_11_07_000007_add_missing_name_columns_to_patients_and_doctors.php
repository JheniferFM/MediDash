<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('patients') && !Schema::hasColumn('patients', 'name')) {
            Schema::table('patients', function (Blueprint $table) {
                $table->string('name')->after('id');
            });
        }

        if (Schema::hasTable('doctors') && !Schema::hasColumn('doctors', 'name')) {
            Schema::table('doctors', function (Blueprint $table) {
                $table->string('name')->after('id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('patients') && Schema::hasColumn('patients', 'name')) {
            Schema::table('patients', function (Blueprint $table) {
                $table->dropColumn('name');
            });
        }

        if (Schema::hasTable('doctors') && Schema::hasColumn('doctors', 'name')) {
            Schema::table('doctors', function (Blueprint $table) {
                $table->dropColumn('name');
            });
        }
    }
};