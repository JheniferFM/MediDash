<?php

use Illuminate\Support\Facades\Route;
use App\Infrastructure\Controllers\AuthController;
use App\Infrastructure\Controllers\PatientController;
use App\Infrastructure\Controllers\DoctorController;
use App\Infrastructure\Controllers\AppointmentController;
use App\Infrastructure\Controllers\ExamController;
use App\Infrastructure\Controllers\DashboardController;
use App\Infrastructure\Controllers\PrescriptionController;

// Public auth endpoints
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected API routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Dashboard summary
    Route::get('/dashboard', [DashboardController::class, 'summary']);

    Route::apiResource('patients', PatientController::class);
    Route::apiResource('doctors', DoctorController::class);
    Route::apiResource('appointments', AppointmentController::class);
    Route::apiResource('exams', ExamController::class);
    Route::apiResource('prescriptions', PrescriptionController::class);
});