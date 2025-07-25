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
use App\Http\Controllers\api\MissaoController;
use App\Http\Controllers\api\AmigoController;
use App\Http\Controllers\api\CompraController;
use App\Http\Controllers\api\RankController;
use App\Http\Controllers\api\TipoProdutoController;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::post('/auth/refreshtoken', [AuthController::class, 'refreshToken']);
    Route::put('/auth/updateProfile', [AuthController::class, 'updateMe']);

    Route::get('/users/me', [UserController::class, 'showMe']);
    Route::get('/users/me/coins', [UserController::class, 'getCoins']);
    Route::post('/users/perderVida', [UserController::class, 'perderVida']);
    Route::post('/users/ganharVidas', [UserController::class, 'ganharVidas']);
    Route::get('/users/getVidas', [UserController::class, 'getVidas']);
    Route::get('/users/username/{username}', [UserController::class, 'getUserByUsername']);
    Route::get('/users/getAllGestoresAdmins', [UserController::class, 'getAllGestoresAdmins']);
    Route::put('/users/block', [UserController::class, 'block']);

    Route::get('/tipojogo/getTiposJogos', [TipoJogoController::class, 'index']);

    Route::get('/unidade/{idUnidade}/getJogos', [JogoController::class, 'index']);
    Route::get('/jogo/{idJogo}', [JogoController::class, 'show']);
    Route::put('/jogo/{idJogo}/estado', [JogoController::class, 'mudarEstadoJogo']);
    Route::put('/jogo/{idJogo}', [JogoController::class, 'updateJogo']);

    Route::get('cursos', [CursoController::class, 'index']);
    Route::get('cursos/{idCurso}', [CursoController::class, 'show']);
    Route::post('cursos', [CursoController::class, 'createCurso']);
    Route::put('cursos/{idCurso}', [CursoController::class, 'update']);
    Route::put('/cursos/{id}/alterarEstado', [CursoController::class, 'alterarEstado']);


    Route::get('/cursos/{idCurso}/unidades', [UnidadeController::class, 'index']);
    Route::get('/unidades/{idUnidade}', [UnidadeController::class, 'show']);
    Route::post('/cursos/{idCurso}/unidades', [UnidadeController::class, 'createUnidade']);
    Route::put('/unidades/{idUnidade}', [UnidadeController::class, 'edit']);

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
    Route::post('/comprar/{idProduto}', [CompraController::class, 'comprar']);
    Route::put('/loja/{id}/alterarEstado', [ProdutoController::class, 'alterarEstado']);
    Route::get('/tipos-produtos', [TipoProdutoController::class, 'index']);
    Route::post('/loja', [ProdutoController::class, 'create']);

    Route::get('/missoes', [MissaoController::class, 'index']);
    Route::get('/missoes/minhasMissoes', [MissaoController::class, 'minhasMissoes']);
    Route::get('/missoes/minhasConquistas', [MissaoController::class, 'minhasConquistas']);
    Route::post('/missoes/progresso', [MissaoController::class, 'progressoMissao']);
    Route::post('/missoes/alterarEstado/{id}', [MissaoController::class, 'alterarEstadoMissao']);

    Route::get('/rank', [RankController::class, 'index']);

    Route::get('/amigos', [AmigoController::class, 'getAmigos']);
    Route::get('/amigos/pedidos', [AmigoController::class, 'getPedidosAmizade']);
    Route::post('/amigos/pedido', [AmigoController::class, 'enviarPedidoAmizade']);
    Route::post('/amigos/responderPedido', [AmigoController::class, 'responderPedidoAmizade']);
    Route::delete('/amigos/removerAmigo', [AmigoController::class, 'removerAmigo']);
});

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);


