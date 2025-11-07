<?php

use Illuminate\Support\Facades\Route;
use App\Infrastructure\Controllers\DashboardController;

Route::get('/', function () {
    return view('app');
});

// Endpoint de resumo do dashboard exposto na web para o frontend
Route::get('/dashboard', [DashboardController::class, 'summary']);

// SPA fallback: envia qualquer rota desconhecida para a view raiz
Route::view('/{any}', 'app')->where('any', '.*');
