<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\JogoController;
use App\Http\Controllers\api\CursoController;
use App\Http\Controllers\api\UnidadeController;
use App\Http\Controllers\api\TipoJogoController;
use App\Http\Controllers\api\PaginaController;
use App\Http\Controllers\api\ReportController;
use App\Http\Controllers\api\ProdutoController;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::post('/auth/refreshtoken', [AuthController::class, 'refreshToken']);

    Route::get('/users/me', [UserController::class, 'showMe']);
    Route::get('/users/me/coins', [UserController::class, 'getCoins']);
    Route::post('/users/perderVida', [UserController::class, 'perderVida']);
    Route::post('/users/ganharVidas', [UserController::class, 'ganharVidas']);
    Route::get('/users/getVidas', [UserController::class, 'getVidas']);

    Route::get('/tipojogo/getTiposJogos', [TipoJogoController::class, 'index']);
    
    Route::get('/unidade/{idUnidade}/getJogos', [JogoController::class, 'index']);
    Route::get('/jogo/{idJogo}', [JogoController::class, 'show']);
    Route::put('/jogo/{idJogo}/estado', [JogoController::class, 'mudarEstadoJogo']);
    Route::put('/jogo/{idJogo}', [JogoController::class, 'updateJogo']);
  
    Route::get('cursos', [CursoController::class, 'index']);
    Route::get('cursos/ativos', [CursoController::class, 'cursosAtivos']);
    Route::get('cursos/{idCurso}', [CursoController::class, 'show']);
    Route::post('cursos', [CursoController::class, 'createCurso']);
    Route::put('cursos/{idCurso}', [CursoController::class, 'update']);
    Route::put('/cursos/{id}/alterarEstado', [CursoController::class, 'alterarEstado']);


    Route::get('/cursos/{idCurso}/unidades', [UnidadeController::class, 'index']);
    Route::get('/unidades/{idUnidade}', [UnidadeController::class, 'show']);
    Route::post('/cursos/{idCurso}/unidades', [UnidadeController::class, 'createUnidade']);
    Route::put('/unidades/{idUnidade}', [UnidadeController::class, 'update']);
    Route::post('/cursos/{curso}/unidades/order', [UnidadeController::class, 'atualizarOrdem']);
    Route::post('/unidade/{idUnidade}/jogo', [JogoController::class, 'createJogo']);
    
    Route::get('/unidade/{idUnidade}/jogo/start', [JogoController::class, 'comecarJogo']);
    Route::post('/unidade/concluir', [UnidadeController::class, 'concluirUnidade']);

    Route::get('/unidade/{idUnidade}/getPaginas', [PaginaController::class, 'index']);
    Route::get('/pagina/{idPagina}', [PaginaController::class, 'show']);
    Route::post('/unidade/{idUnidade}/pagina', [PaginaController::class, 'createPagina']);
    Route::put('/paginas/updatePaginas', [PaginaController::class, 'updatePaginas']);

    Route::get('/reports', [ReportController::class, 'index']);
    Route::get('/report/{idUnidade}', [ReportController::class, 'show']);
    Route::post('/report', [ReportController::class, 'createReport']);
    Route::put('/report/{id}/estado', [ReportController::class, 'updateEstadoReport']);

    Route::get('/loja', [ProdutoController::class, 'index']);
    Route::post('/comprar/{produto}', [ProdutoController::class, 'comprar']);

});

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);


