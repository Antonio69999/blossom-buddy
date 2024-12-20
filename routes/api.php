<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlantController;
use App\Http\Controllers\UserPlantController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

Route::prefix('plant')->group(function () {
    Route::get('/', [PlantController::class, 'index']); //{{base_url}}/api/plant
    Route::post('/', [PlantController::class, 'store']); //POST{{base_url}}/api/plant/Rose
    Route::get('/{name}', [PlantController::class, 'show']); //{{base_url}}/api/plant/Rose
    Route::delete('/{id}', [PlantController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->prefix('user')->group(function () {
    Route::post('/plant', [UserPlantController::class, 'store']);
    Route::get('/plants', [UserPlantController::class, 'index']);
    Route::delete('/plant/{id}', [UserPlantController::class, 'destroy']);
});
