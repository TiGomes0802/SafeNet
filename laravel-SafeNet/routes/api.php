<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\JogoController;
use App\Http\Controllers\api\CursoController;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::post('/auth/refreshtoken', [AuthController::class, 'refreshToken']);

    Route::get('/users/me', [UserController::class, 'showMe']);
    Route::get('/users/me/coins', [UserController::class, 'getCoins']);

    Route::get('/unidade/{idUnidade}/getJogos', [JogoController::class, 'getJogos']);
    Route::get('cursos', [CursoController::class, 'index']);
    Route::get('curso/{idCurso}', [CursoController::class, 'show']);
    Route::post('curso', [CursoController::class, 'createCurso']); 
    Route::put('curso/{idCurso}', [CursoController::class, 'update']);
});

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);
