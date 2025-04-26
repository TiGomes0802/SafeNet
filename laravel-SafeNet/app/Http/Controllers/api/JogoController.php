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

        if ($validatedData['tipoJogo'] == 1 || $validatedData['tipoJogo'] == 2) {
            try {
                $respostaCertaData = $request->validate([
                    'respostaCerta' => 'required',
                ]);

                $respostas = [
                    'respostas' => $validatedData['respostas'],
                    'respostaCerta' => $respostaCertaData['respostaCerta'],
                    'idJogo' => $jogo->id,
                ];
            } catch (\Illuminate\Validation\ValidationException $e) {
                $jogo->delete();
                return response()->json(['error' => 'Resposta correta não fornecida'], 400);
            }
        }else{
            $respostas = [
                'respostas' => $validatedData['respostas'],
                'idJogo' => $jogo->id,
            ];
        }
  
        $respostaController = new RespostaController();

        if($validatedData['tipoJogo'] == 1){
            $respostaController->createRespostaVerdadeiroFalso($respostas);
        } elseif($validatedData['tipoJogo'] == 2){
            $respostaController->createRespostaMultiplaEscolha($respostas);
        } elseif($validatedData['tipoJogo'] == 4){
            $respostaController->createRespostasOrdernar($respostas);
        } else {
            return response()->json(['error' => 'Tipo de jogo inválido'], 400);
        }
   
        // Retorna o jogo criado com as respostas
        $jogo->load('respostas');
        return response()->json($jogo, 201);
    } 
}
