<?php

use Illuminate\Support\Facades\Route;
use App\Http\Api\Controllers\FormulaController;

Route::prefix('formulas')->group(function () {
    Route::get('/',[FormulaController::class, 'index']);
    Route::post('/',[FormulaController::class, 'store']);
    Route::get('/{id}',[FormulaController::class, 'show']);
    Route::put('/{id}',[FormulaController::class, 'update']);
    Route::delete('/{id}',[FormulaController::class, 'destroy']);
});
