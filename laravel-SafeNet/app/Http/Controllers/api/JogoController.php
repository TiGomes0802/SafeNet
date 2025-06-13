<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Jogo;
use App\Models\Unidade;
use Carbon\Carbon;

class JogoController extends Controller
{
    public function show($idJogo){
        // Verifica se o jogo existe
        $jogo = Jogo::find($idJogo);
        if (!$jogo) {
            return response()->json(['error' => 'Jogo não encontrado'], 404);
        }

        // Carrega as respostas associadas ao jogo
        $jogo->load('respostas');

        $jogo = [
                'id' => $jogo->id,
                'xp' => $jogo->xp,
                'pergunta' => $jogo->pergunta,
                'estado' => $jogo->estado,
                'gestor' => $jogo->gestor->nome,
                'tipoJogo' => $jogo->tipoJogo->tipo,
                'idTipoJogo' => $jogo->tipoJogo->id,
                'idUnidade' => $jogo->unidade->id,
                'respostas' => $jogo->respostas,
            ];

        // Retorna o jogo em formato JSON
        return response()->json($jogo);
    }

    public function index($idUnidade){
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
                'gestor' => $jogo->gestor->nome,
                'tipoJogo' => $jogo->tipoJogo->tipo,
                'idTipoJogo' => $jogo->tipoJogo->id,
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
            'estado' => false,
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
        } elseif($validatedData['tipoJogo'] == 3){
            $respostaController->createRespostasOrdernar($respostas);
        } else {
            return response()->json(['error' => 'Tipo de jogo inválido'], 400);
        }
   
        // Retorna o jogo criado com as respostas
        $jogo->load('respostas');
        return response()->json($jogo, 201);
    }

    public function updateJogo(Request $request, $idJogo){
        // Valida os dados da requisição
        $validatedData = $request->validate([
            'xp' => 'required|integer',
            'pergunta' => 'required|string',       
            'respostas' => 'required|array',
            'tipoJogo' => 'required|integer|exists:tipoJogos,id',
        ]);


        // Verifica se o jogo existe
        $jogo = Jogo::find($idJogo);
        if (!$jogo) {
            return response()->json(['error' => 'Jogo não encontrado'], 404);
        }

        // Atualiza os dados do jogo
        $jogo->update([
            'xp' => $validatedData['xp'],
            'pergunta' => $validatedData['pergunta'],
            'idTipo' => $validatedData['tipoJogo'],
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

        // apagar as respostas anteriores
        $jogo->respostas()->delete();

        if($validatedData['tipoJogo'] == 1){
            $respostaController->createRespostaVerdadeiroFalso($respostas);
        } elseif($validatedData['tipoJogo'] == 2){
            $respostaController->createRespostaMultiplaEscolha($respostas);
        } elseif($validatedData['tipoJogo'] == 3){
            $respostaController->createRespostasOrdernar($respostas);
        } else {
            return response()->json(['error' => 'Tipo de jogo inválido'], 400);
        }

        // Carrega as respostas associadas ao jogo
        $jogo->load('respostas');

        // Retorna o jogo atualizado
        return response()->json($jogo);
    }

    public function mudarEstadoJogo(Request $request, $idJogo){
        // Verifica se o jogo existe
        $jogo = Jogo::find($idJogo);
        if (!$jogo) {
            return response()->json(['error' => 'Jogo não encontrado'], 404);
        }

        // Altera o estado do jogo
        $jogo->estado = !$jogo->estado;
        $jogo->save();

        // Retorna o jogo atualizado
        return response()->json($jogo);
    }

    public function comecarJogo(Request $request, $idUnidade){
        // Verifica se a unidade existe
        $unidade = Unidade::find($idUnidade);
        if (!$unidade) {
            return response()->json(['error' => 'Unidade não encontrada'], 404);
        }

        $jogosCount = Jogo::where('idUnidade', $idUnidade)
                        ->where('estado', true)
                        ->count();

        if ($jogosCount < 5) {
            return response()->json(['error' => 'Não existem 5 jogos ativos associados a esta unidade'], 400);
        }

        $jogos = Jogo::where('idUnidade', $idUnidade)
                    ->where('estado', true)
                    ->inRandomOrder()
                    ->take(7)
                    ->get();
        
        // carrega as respostas associadas aos jogos
        $jogos->load(['respostas' => function ($query) {
            $query->inRandomOrder();
        }]);

        return response()->json($jogos);
    }

    public function processarJogosDoUsuario($user, $jogosData){
        $xpTotal = 0;
        $numJogosAcertados = 0;

        foreach ($jogosData as $jogoData) {
            $jogo = Jogo::find($jogoData['idJogo']);

            $xpGanho = $jogoData['acertou']
                ? $jogo->xp
                : intval($jogo->xp * 0.5);

            $xpTotal += $xpGanho;

            $numJogosAcertados += ($jogoData['acertou'] ? 1 : 0);

            $estatistica = $user->estatistica()->where('idJogo', $jogo->id)->first();

            if (!$estatistica) {
                $user->estatistica()->attach($jogo->id, [
                    'numVezes' => 0,
                    'numAcertos' => 0,
                ]);
                $estatistica = $user->estatistica()->where('idJogo', $jogo->id)->first();
            }

            $numVezes = $estatistica->pivot->numVezes + 1;
            $numAcertos = $estatistica->pivot->numAcertos + ($jogoData['acertou'] ? 1 : 0);

            $user->estatistica()->updateExistingPivot($jogo->id, [
                'numVezes' => $numVezes,
                'numAcertos' => $numAcertos,
            ]);
        }

        $taxaAcerto = round($numJogosAcertados / count($jogosData) * 100, 2);

        return [
            'xpTotal' => $xpTotal,
            'taxaAcerto' => $taxaAcerto,
        ];
    }

    public function processarMissoesStreakJogos($user, $unidade, $validatedJogos, $xpTotal, $tempo){
        $numJogosAcertados = 0;
        $jogosAcertados = [];

        foreach ($validatedJogos as $jogoData) {
            $numJogosAcertados += ($jogoData['acertou'] ? 1 : 0);
            $jogosAcertados[] = $jogoData['acertou'] ? 1 : 0;
        }

        $taxaAcerto = round($numJogosAcertados / count($validatedJogos) * 100, 2);

        $minhaMissoesAntesAtualizar = $user->userMissao()
            ->whereDate('data', Carbon::today('Europe/Lisbon'))
            ->whereHas('missao', function ($query) {
                $query->where('tipo', 'missao');
            })->get();

        $missoes = (object) [
            'unidade' => $unidade,
            'tempo' => $tempo,
            'jogo' => $jogosAcertados,
            'xp' => $xpTotal,
            'taxaAcerto' => $taxaAcerto,
        ];

        $missaoController = new MissaoController();
        $missaoController->progressoMissao($missoes);

        $minhaMissoesDepoisAtualizar = $user->userMissao()
            ->whereDate('data', Carbon::today('Europe/Lisbon'))
            ->whereHas('missao', function ($query) {
                $query->where('tipo', 'missao');
            })->get();

        return $minhaMissoesAntesAtualizar->map(function ($antes, $index) use ($minhaMissoesDepoisAtualizar) {
            $depois = $minhaMissoesDepoisAtualizar[$index];

            return [
                'descricao' => $depois->missao->descricao,
                'objetivo' => $depois->missao->objetivo ?? null,
                'moedas' => $depois->missao->moedas,
                'concluida' => $depois->concluida,
                'progresso_antes' => $antes->progresso,
                'progresso_depois' => $depois->progresso,
            ];
        });
    }
}
