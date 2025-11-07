<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('appointments')) {
            Schema::create('appointments', function (Blueprint $table) {
                $table->id();
                $table->foreignId('patient_id')->constrained('patients')->cascadeOnDelete();
                $table->foreignId('doctor_id')->constrained('doctors')->cascadeOnDelete();
                $table->dateTime('scheduled_at');
                $table->enum('status', ['scheduled','completed','cancelled'])->default('scheduled');
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};