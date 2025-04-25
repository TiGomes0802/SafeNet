<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Controller;
use App\Models\TipoJogo;

class TipoJogoController extends Controller
{
    public function getTiposJogos()
    {
        // Obtém todos os tipos de jogo
        $tiposJogo = TipoJogo::all();

        // Verifica se existem tipos de jogo
        if ($tiposJogo->isEmpty()) {
            return response()->json(['message' => 'Nenhum tipo de jogo encontrado'], 404);
        }

        // Retorna os tipos de jogo em formato JSON
        return response()->json($tiposJogo);
    }
}
