<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jogo;
use App\Models\Unidade;

class JogoController extends Controller
{
    public function getJogos($idUnidade)
    {
        // Verifica se a unidade existe
        $unidade = Unidade::find($idUnidade);
        if (!$unidade) {
            return response()->json(['error' => 'Unidade não encontrada'], 404);
        }

        // Obtém os jogos associados à unidade
        $jogos = Jogo::where('idUnidade', $idUnidade)->get();

        // Verifica se existem jogos associados à unidade
        if ($jogos->isEmpty()) {
            return response()->json(['message' => 'Nenhum jogo encontrado para esta unidade'], 404);
        }

        // Retorna os jogos em formato JSON
        return response()->json($jogos);
    }
}
