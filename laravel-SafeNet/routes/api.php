<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\JogoController;
use App\Http\Controllers\api\TipoJogoController;
use App\Http\Controllers\api\PaginaController;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::post('/auth/refreshtoken', [AuthController::class, 'refreshToken']);

    Route::get('/users/me', [UserController::class, 'showMe']);

    Route::get('/tipojogo/getTiposJogos', [TipoJogoController::class, 'getTiposJogos']);
    
    Route::get('/jogo/{idJogo}', [JogoController::class, 'getJogo']);
    Route::put('/jogo/{idJogo}/estado', [JogoController::class, 'mudarEstadoJogo']);
    Route::put('/jogo/{idJogo}', [JogoController::class, 'updateJogo']);
    Route::get('/unidade/{idUnidade}/getJogos', [JogoController::class, 'getJogos']);
    Route::post('/unidade/{idUnidade}/jogo', [JogoController::class, 'createJogo']);

    Route::get('/unidade/{idUnidade}/getPaginas', [PaginaController::class, 'getPaginas']);
    Route::get('/pagina/{idPagina}', [PaginaController::class, 'getPagina']);
    Route::post('/unidade/{idUnidade}/pagina', [PaginaController::class, 'createPagina']);
    Route::put('/paginas/updatePaginas', [PaginaController::class, 'updatePaginas']);
});

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);
