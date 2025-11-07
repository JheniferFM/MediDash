<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('doctors')) {
            if (!Schema::hasColumn('doctors', 'crm')) {
                Schema::table('doctors', function (Blueprint $table) {
                    $table->string('crm')->nullable();
                });
            }
            if (!Schema::hasColumn('doctors', 'specialty')) {
                Schema::table('doctors', function (Blueprint $table) {
                    $table->string('specialty')->nullable();
                });
            }
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('doctors')) {
            if (Schema::hasColumn('doctors', 'crm')) {
                Schema::table('doctors', function (Blueprint $table) {
                    $table->dropColumn('crm');
                });
            }
            if (Schema::hasColumn('doctors', 'specialty')) {
                Schema::table('doctors', function (Blueprint $table) {
                    $table->dropColumn('specialty');
                });
            }
        }
    }
};