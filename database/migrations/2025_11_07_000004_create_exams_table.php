<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('exams')) {
            Schema::create('exams', function (Blueprint $table) {
                $table->id();
                $table->foreignId('patient_id')->constrained('patients')->cascadeOnDelete();
                $table->foreignId('doctor_id')->nullable()->constrained('doctors')->nullOnDelete();
                $table->string('type');
                $table->date('scheduled_date')->nullable();
                $table->date('performed_date')->nullable();
                $table->enum('status', ['pending','scheduled','performed','cancelled'])->default('pending');
                $table->text('result')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};