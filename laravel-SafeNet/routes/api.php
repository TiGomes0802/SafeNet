<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\JogoController;
use App\Http\Controllers\api\CursoController;
use App\Http\Controllers\api\UnidadeController;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::post('/auth/refreshtoken', [AuthController::class, 'refreshToken']);

    Route::get('/users/me', [UserController::class, 'showMe']);
    Route::get('/users/me/coins', [UserController::class, 'getCoins']);

    Route::get('/unidade/{idUnidade}/getJogos', [JogoController::class, 'getJogos']);
    Route::get('cursos', [CursoController::class, 'index']);
    Route::get('cursos/{idCurso}', [CursoController::class, 'show']);
    Route::post('cursos', [CursoController::class, 'createCurso']);
    Route::put('cursos/{idCurso}', [CursoController::class, 'update']);

    Route::get('/unidades/{idCurso}', [UnidadeController::class, 'index']);
    Route::get('/unidades/{idCurso}/{idUnidade}', [UnidadeController::class, 'show']);
    Route::post('/unidades/{idCurso}', [UnidadeController::class, 'createUnidade']);
    Route::put('/unidade/{idCurso}/{idUnidade}', [UnidadeController::class, 'update']);
});

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);


