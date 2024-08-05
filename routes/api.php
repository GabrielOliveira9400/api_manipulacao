<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Api\Controllers\FormulaController;

Route::get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/solicitation', [FormulaController::class, 'store']);

require __DIR__.'/client.php';
require __DIR__.'/formula.php';
require __DIR__.'/ativo.php';
