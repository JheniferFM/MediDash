<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('patients')) {
            Schema::table('patients', function (Blueprint $table) {
                if (Schema::hasColumn('patients', 'first_name')) {
                    $table->dropColumn('first_name');
                }
                if (Schema::hasColumn('patients', 'last_name')) {
                    $table->dropColumn('last_name');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('patients')) {
            Schema::table('patients', function (Blueprint $table) {
                if (!Schema::hasColumn('patients', 'first_name')) {
                    $table->string('first_name')->nullable();
                }
                if (!Schema::hasColumn('patients', 'last_name')) {
                    $table->string('last_name')->nullable();
                }
            });
        }
    }
};