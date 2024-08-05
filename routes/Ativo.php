<?php

use Illuminate\Support\Facades\Route;
use App\Http\Api\Controllers\AtivoController;

Route::prefix('ativos')->group(function () {
    Route::get('/', [AtivoController::class, 'index']);
    Route::post('/', [AtivoController::class, 'store']);
    Route::get('/{id}', [AtivoController::class, 'show']);
    Route::put('/{id}', [AtivoController::class, 'update']);
    Route::delete('/{id}', [AtivoController::class, 'destroy']);
});

