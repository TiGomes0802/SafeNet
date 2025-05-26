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

            // Marca a unidade como concluída
            $user->unidade()->syncWithoutDetaching([
                $validatedData['idUnidade'] => ['status' => true],
            ]);

            // Chama método do controlador dos jogos para processar os jogos
            $jogoController = new JogoController();
            $resultadoJogos = $jogoController->processarJogosDoUsuario($user, $validatedData['jogos']);

            // Atualiza XP e streak
            $user->xp += $resultadoJogos['xpTotal'];

            if (!$user->streakFeita) {
                $user->streak += 1;
                $user->streakFeita = true;
            }

            $user->save();

            // Processa missões (streak, jogos, etc)
            $missoes = $jogoController->processarMissoesStreakJogos(
                $user,
                $unidade,
                $validatedData['jogos'],
                $resultadoJogos['xpTotal'],
                $validatedData['tempo']
            );

            \DB::commit();

            return response()->json([
                'message' => 'Unidade terminada com sucesso',
                'xpGanho' => $resultadoJogos['xpTotal'],
                'idCurso' => $idCurso,
                'taxaAcerto' => $resultadoJogos['taxaAcerto'],
                'missoes' => $missoes,
            ]);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json(['error' => 'Erro ao terminar o jogo: ' . $e->getMessage()], 500);
        }
    }
}
