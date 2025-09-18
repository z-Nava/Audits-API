<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductionLineController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/user', function (Request $request) {
    $user = "Soy Navarrete";
    return $response = [
        'status' => 'success',
        'data' => $user
    ];
});

Route::prefix('v1')->group(function () {
    Route::get('/lines', [ProductionLineController::class, 'index']);
    Route::post('/lines', [ProductionLineController::class, 'store']);
    Route::get('/lines/{line}', [ProductionLineController::class, 'show']);
    Route::put('/lines/{line}', [ProductionLineController::class, 'update']);
    Route::delete('/lines/{line}', [ProductionLineController::class, 'destroy']);
});
