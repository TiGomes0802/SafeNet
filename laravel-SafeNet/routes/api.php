<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\JogoController;
use App\Http\Controllers\api\CursoController;
use App\Http\Controllers\api\UnidadeController;
use App\Http\Controllers\api\TipoJogoController;
use App\Http\Controllers\api\PaginaController;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::post('/auth/refreshtoken', [AuthController::class, 'refreshToken']);

    Route::get('/users/me', [UserController::class, 'showMe']);
    Route::get('/users/me/coins', [UserController::class, 'getCoins']);
    Route::post('/users/perderVida', [UserController::class, 'perderVida']);
    Route::post('/users/ganharVidas', [UserController::class, 'ganharVidas']);

    Route::get('/tipojogo/getTiposJogos', [TipoJogoController::class, 'getTiposJogos']);
    
    Route::get('/jogo/{idJogo}', [JogoController::class, 'getJogo']);
    Route::put('/jogo/{idJogo}/estado', [JogoController::class, 'mudarEstadoJogo']);
    Route::put('/jogo/{idJogo}', [JogoController::class, 'updateJogo']);
    Route::get('/unidade/{idUnidade}/getJogos', [JogoController::class, 'getJogos']);
  
    Route::get('cursos', [CursoController::class, 'index']);
    Route::get('cursos/{idCurso}', [CursoController::class, 'show']);
    Route::post('cursos', [CursoController::class, 'createCurso']);
    Route::put('cursos/{idCurso}', [CursoController::class, 'update']);

    Route::get('/unidades/{idCurso}', [UnidadeController::class, 'index']);
    Route::get('/unidades/{idCurso}/{idUnidade}', [UnidadeController::class, 'show']);
    Route::post('/unidades/{idCurso}', [UnidadeController::class, 'createUnidade']);
    Route::put('/unidade/{idCurso}/{idUnidade}', [UnidadeController::class, 'update']);
    Route::post('/unidade/{idUnidade}/jogo', [JogoController::class, 'createJogo']);
    Route::get('/unidade/{idUnidade}/jogo/start', [JogoController::class, 'comecarJogo']);

    Route::get('/unidade/{idUnidade}/getPaginas', [PaginaController::class, 'getPaginas']);
    Route::get('/pagina/{idPagina}', [PaginaController::class, 'getPagina']);
    Route::post('/unidade/{idUnidade}/pagina', [PaginaController::class, 'createPagina']);
    Route::put('/paginas/updatePaginas', [PaginaController::class, 'updatePaginas']);
});

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);


