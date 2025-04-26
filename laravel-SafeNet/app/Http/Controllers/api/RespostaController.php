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

    public function createRespostaVerdadeiroFalso($respostas)
    {
        foreach ($respostas['respostas'] as $index => $resposta) {
            $this->createResposta($resposta, $respostas['idJogo'], $respostas['respostaCerta'][$index]);
        }

        return response()->json(['message' => 'Respostas criadas com sucesso'], 201);
    }

    public function createRespostaMultiplaEscolha($respostas)
    {
        foreach ($respostas['respostas'] as $resposta) {
            if ($resposta == $respostas['respostaCerta']) {
                $respostaCerta = 1;
            } else {
                $respostaCerta = 0;
            }
            
            $this->createResposta($resposta, $respostas['idJogo'], $respostaCerta);
        }

        return response()->json(['message' => 'Respostas criadas com sucesso'], 201);
    }

    public function createRespostasOrdernar($respostas)
    {
        foreach ($respostas['respostas'] as $index => $resposta) {
            $this->createResposta($resposta, $respostas['idJogo'], $index);
        }
        
        return response()->json(['message' => 'Respostas criadas com sucesso'], 201);
    }

}
