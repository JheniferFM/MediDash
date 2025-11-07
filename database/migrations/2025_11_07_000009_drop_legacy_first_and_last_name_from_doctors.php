<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('doctors')) {
            Schema::table('doctors', function (Blueprint $table) {
                if (Schema::hasColumn('doctors', 'first_name')) {
                    $table->dropColumn('first_name');
                }
                if (Schema::hasColumn('doctors', 'last_name')) {
                    $table->dropColumn('last_name');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('doctors')) {
            Schema::table('doctors', function (Blueprint $table) {
                if (!Schema::hasColumn('doctors', 'first_name')) {
                    $table->string('first_name')->nullable();
                }
                if (!Schema::hasColumn('doctors', 'last_name')) {
                    $table->string('last_name')->nullable();
                }
            });
        }
    }
};