<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Curso;
use App\Models\Unidade;
use App\Models\Jogo;
use App\Models\User;

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
        $unidade = Unidade::where('idCurso', $idCurso)->find($idUnidade);
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
            'ordem' => 'required|integer',
            'estado' => 'required|boolean',
        ]);

        $unidade = Unidade::create([
            'titulo' => $validatedData['titulo'],
            'descricao' => $validatedData['descricao'],
            'ordem' => $validatedData['ordem'],
            'estado' => $validatedData['estado'],
            'idCurso' => $idCurso,
        ]);

        return response()->json($unidade, 201);
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
    public function concluirUnidade(Request $request) {
        // return das estatisticas do user 7 da unidade 1
        
        $validatedData = $request->validate([
            'idUnidade' => 'required|integer',
            'jogos' => 'required|array',
            'jogos.*.idJogo' => 'required|integer|exists:jogos,id',
            'jogos.*.acertou' => 'required|boolean',
        ]);
    
        \DB::beginTransaction();
    
        try {
            $user = auth()->user();
            $xpTotal = 0;
            
            foreach ($validatedData['jogos'] as $jogoData) {
                // Garante que a ligação existe (ou cria)
                $jogo = Jogo::find($jogoData['idJogo']);
    
                $xpGanho = $jogoData['acertou']
                    ? $jogo->xp
                    : intval($jogo->xp * 0.5);
    
                $xpTotal += $xpGanho;

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
            $user->save();
    
            // Marca a unidade como concluída
            $user->unidade()->syncWithoutDetaching([
                $validatedData['idUnidade'] => ['status' => true],
            ]);
    
            \DB::commit();
    
            return response()->json([
                'message' => 'Unidade terminada com sucesso',
                'xpGanho' => $xpTotal,
            ]);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json(['error' => 'Erro ao terminar o jogo: ' . $e->getMessage()], 500);
        }
    }    
}