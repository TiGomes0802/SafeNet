<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Controller;
use App\Http\Controllers\api\RespostaController;
use App\Models\User;
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


        // Obtém os jogos associados à unidade e que estão ativos e todas as respostas(sem qualquer where) de cada jogo
        $jogos = Jogo::where('idUnidade', $idUnidade)
                    ->with('respostas') // Carrega as respostas associadas aos jogos
                    ->get();
        
        // Verifica se existem jogos associados à unidade
        if ($jogos->isEmpty()) {
            return response()->json(['message' => 'Nenhum jogo encontrado para esta unidade'], 404);
        }

        

        // Formata os jogos para incluir o nome da unidade (xp, idGestor para nome do gestor)
        $jogos = $jogos->map(function ($jogo) use ($unidade) {
            return [
                'id' => $jogo->id,
                'xp' => $jogo->xp,
                'pergunta' => $jogo->pergunta,
                'estado' => $jogo->estado,
                'respostaCerta' => $jogo->respostaCerta,
                'gestor' => $jogo->gestor->nome,
                'tipo' => $jogo->tipoJogo->tipo,
                'respostas' => $jogo->respostas
            ];
        }); 
        
        // Retorna os jogos em formato JSON
        return response()->json($jogos);
    }

    public function createJogo(Request $request, $idUnidade){
        // Valida os dados da requisição
        $validatedData = $request->validate([
            'xp' => 'required|integer',
            'pergunta' => 'required|string',
            'respostaCerta' => 'required|string',
            'respostas' => 'required|array',
            'tipoJogo' => 'required|integer|exists:tipoJogos,id',
        ]);

        // Verifica se a unidade existe
        $unidade = Unidade::find($idUnidade);
        if (!$unidade) {
            return response()->json(['error' => 'Unidade não encontrada'], 404);
        }

        // Cria o novo jogo
        $jogo = Jogo::create([
            'xp' => $validatedData['xp'],
            'pergunta' => $validatedData['pergunta'], 
            'estado' => true,
            'idGestor' => auth()->user()->id,
            'idTipo' => $validatedData['tipoJogo'],
            'idUnidade' => $idUnidade, 
        ]);

        // Cria as respostas associadas ao jogo tambem preciso do index da resposta certa
        // Verifica se a resposta certa está dentro do intervalo de respostas
        foreach ($validatedData['respostas'] as $index => $resposta) {
            if($validatedData['tipoJogo'] == 4){
                $respostaCerta = true;
            } else{
                if($resposta == $validatedData['respostaCerta']) {
                    $respostaCerta = true;
                } else {
                    $respostaCerta = false;
                }
            } 
            $respostaController = new RespostaController();
            $respostaController->createResposta($resposta, $jogo->id, $respostaCerta);
        }

        // Retorna o jogo criado com as respostas
        $jogo->load('respostas');
        return response()->json($jogo, 201);
    }

    
    
}
