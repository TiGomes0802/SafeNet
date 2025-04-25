<?php

namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;
use App\Models\Resposta;

use Illuminate\Http\Request;

class RespostaController extends Controller
{
    // Método para criar uma nova resposta esta função é chamada no JogoController
    public function createResposta($respostaTexto, $idJogo, $respostaCerta)
    {
        $resposta = Resposta::create([
            'resposta' => $respostaTexto,
            'certa' => $respostaCerta,
            'idJogo' => $idJogo,
        ]);

        return $resposta;
    }
}
