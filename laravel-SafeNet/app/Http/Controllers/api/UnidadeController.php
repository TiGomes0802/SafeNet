<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Curso;
use App\Models\Unidade;
use App\Models\Jogo;
use Carbon\Carbon;

class UnidadeController extends Controller
{

    public function index($idCurso)
    {
        $curso = Curso::find($idCurso);
        if (!$curso) {
            return response()->json(['error' => 'Curso não encontrado'], 404);
        }

        $unidades = $curso->unidades;
        return response()->json($unidades);
    }

    public function show($idUnidade)
    {
        // Encontra a unidade dentro do curso
        $unidade = Unidade::find($idUnidade);
        if (!$unidade) {
            return response()->json(['error' => 'Unidade não encontrada'], 404);
        }

        return response()->json($unidade);
    }

    public function createUnidade(Request $request, $idCurso)
    {
        $curso = Curso::find($idCurso);
        if (!$curso) {
            return response()->json(['error' => 'Curso não encontrado'], 404);
        }

        // Valida os dados recebidos
        $validatedData = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
        ]);

        // Verifica se o curso tem unidades
        $unidades = Unidade::where('idCurso', $idCurso)->get();
        if ($unidades->isEmpty()) {
            $ordem = 1;
        } else {
            // Ordena as unidades por ordem e pega a última
            $ultimaUnidade = $unidades->sortByDesc('ordem')->first();
            $ordem = $ultimaUnidade->ordem + 1;
        }

        $unidade = Unidade::create([
            'titulo' => $validatedData['titulo'],
            'descricao' => $validatedData['descricao'],
            'ordem' => $ordem,
            'estado' => false,
            'idCurso' => $idCurso,
        ]);

        return response()->json($unidade, 201);
    }

    public function atualizarOrdem(Request $request, Curso $curso)
    {
        $ordens = $request->input('ordem');

        foreach ($ordens as $item) {
            Unidade::where('id', $item['id'])
                ->where('idCurso', $curso->id)
                ->update(['ordem' => $item['ordem']]);
        }

        return response()->json([
            'message' => 'Ordem atualizada com sucesso',
            'unidades' => Unidade::where('idCurso', $curso->id)->orderBy('ordem')->get()
        ]);
    }



    public function update(Request $request, $idCurso, $idUnidade)
    {
        $curso = Curso::find($idCurso);
        if (!$curso) {
            return response()->json(['error' => 'Curso não encontrado'], 404);
        }

        $unidade = Unidade::where('idCurso', $idCurso)->find($idUnidade);
        if (!$unidade) {
            return response()->json(['error' => 'Unidade não encontrada'], 404);
        }

        // Valida os dados recebidos
        $validatedData = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'ordem' => 'required|integer',
            'estado' => 'required|boolean',
        ]);

        $unidade->update([
            'titulo' => $validatedData['titulo'],
            'descricao' => $validatedData['descricao'],
            'ordem' => $validatedData['ordem'],
            'estado' => $validatedData['estado'],
        ]);

        return response()->json($unidade);
    }

    /**
     * Uma função que recebe o xp ganho pelo utilizador, o id da unidade e os id's dos jogos e se foram respondidos corretamente ou não
     * soma o xp ao utilizador e atualiza
     * atualiza a tabela estatistica entre o id do utilizador e o id do jogo
     * e a user_unidade com o estado de terminado entre o user e a unidade
     * Se houver algum erro a meio do processo, a transação é revertida
     * @param Request $request
     * 
     */
    public function concluirUnidade(Request $request)
    {
        // return das estatisticas do user 7 da unidade 1

        $validatedData = $request->validate([
            'idUnidade' => 'required|integer',
            'jogos' => 'required|array',
            'jogos.*.idJogo' => 'required|integer|exists:jogos,id',
            'jogos.*.acertou' => 'required|boolean',
            'tempo' => 'required|integer',
        ]);

        \DB::beginTransaction();

        $unidade = Unidade::find($validatedData['idUnidade']);
        $idCurso = $unidade->idCurso;

        try {
            $user = auth()->user();
            $xpTotal = 0;

            $numJogosAcertados = 0;

            $jogosAcertados = [];

            foreach ($validatedData['jogos'] as $jogoData) {
                // Garante que a ligação existe (ou cria)
                $jogo = Jogo::find($jogoData['idJogo']);

                $xpGanho = $jogoData['acertou']
                    ? $jogo->xp
                    : intval($jogo->xp * 0.5);

                $xpTotal += $xpGanho;

                // calcula a taxa de acerto so dos jogos, do foreach
                $numJogosAcertados += ($jogoData['acertou'] ? 1 : 0);

                $jogosAcertados[] = $jogoData['acertou'] ? 1 : 0;

                // Verifica se já existe o registo pivot
                $estatistica = $user->estatistica()->where('idJogo', $jogo->id)->first();

                if (!$estatistica) {
                    // Só cria se não existir
                    $user->estatistica()->attach($jogo->id, [
                        'numVezes' => 0,
                        'numAcertos' => 0,
                    ]);

                    // Volta a ir buscar após criar
                    $estatistica = $user->estatistica()->where('idJogo', $jogo->id)->first();
                }

                // Atualiza os valores
                $numVezes = $estatistica->pivot->numVezes + 1;
                $numAcertos = $estatistica->pivot->numAcertos + ($jogoData['acertou'] ? 1 : 0);

                $user->estatistica()->updateExistingPivot($jogo->id, [
                    'numVezes' => $numVezes,
                    'numAcertos' => $numAcertos,
                ]);
            }

            // Atualiza XP
            $user->xp += $xpTotal;

            // Verificação da streak aqui

            $user->save();            

            // Marca a unidade como concluída
            $user->unidade()->syncWithoutDetaching([
                $validatedData['idUnidade'] => ['status' => true],
            ]);

            $taxaAcerto = round($numJogosAcertados / count($validatedData['jogos']) * 100, 2);
            
            $minhaMissoesAntesAtualizar = $user->userMissao()
                ->whereDate('data', Carbon::today())
                ->whereHas('missao', function ($query) {
                    $query->where('tipo', 'missao');
                })->get();

            $missoes = (object) [
                'unidade' => $unidade,
                'tempo' => $validatedData['tempo'],
                'jogo' => $jogosAcertados,
                'xp' => $xpTotal,
                'taxaAcerto' => $taxaAcerto,
            ];
                
            $missaoController = new MissaoController();
            $missaoController->progressoMissao($missoes);

            $minhaMissoesDepoisAtualizar = $user->userMissao()
                ->whereDate('data', Carbon::today())
                ->whereHas('missao', function ($query) {
                    $query->where('tipo', 'missao');
                })->get();
                
            $missoes = $minhaMissoesAntesAtualizar->map(function ($antes, $index) use ($minhaMissoesDepoisAtualizar) {
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

            \DB::commit();

            return response()->json([
                'message' => 'Unidade terminada com sucesso',
                'xpGanho' => $xpTotal,
                'idCurso' => $idCurso,
                'taxaAcerto' => $taxaAcerto,
                'missoes' => $missoes,
            ]);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json(['error' => 'Erro ao terminar o jogo: ' . $e->getMessage()], 500);
        }
    }
}
