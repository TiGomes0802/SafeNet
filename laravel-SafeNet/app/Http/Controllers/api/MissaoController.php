<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Missao;
use App\Models\User;
use App\Models\UserMissao;

class MissaoController extends Controller
{
    public function index()
    {
        $missoes = Missao::where('tipo', 'missao')->get();

        $conquistas = Missao::where('tipo', 'conquista')->get();

        // Verifica se existem missoes
        if ($missoes->isEmpty()) {
            return response()->json(['error' => 'Nenhuma missão encontrada'], 404);
        }
        // Verifica se existem conquistas
        if ($conquistas->isEmpty()) {
            return response()->json(['error' => 'Nenhuma conquista encontrada'], 404);
        }

        $missoes = [
            'missoes' => $missoes,
            'conquistas' => $conquistas
        ];

        // Retorna as missoes
        return response()->json($missoes);
    }

    public function minhasMissoes()
    {
        $missoes = UserMissao::with('missao')
            ->where('idUser', auth()->user()->id)
            ->where('data', '>=', now()->toDateString())
            ->whereHas('missao', function ($query) {
                $query->where('tipo', 'missao');
            })
            ->get();

        if ($missoes->isEmpty()) {
            return response()->json(['error' => 'Nenhuma missão encontrada'], 404);
        }
        
        return response()->json($missoes);
    }


    public function minhasConquistas()
    {
        $conquistas = UserMissao::with('missao')
            ->where('idUser', auth()->user()->id)
            ->whereHas('missao', function ($query) {
                $query->where('tipo', 'conquista');
            })
            ->get();
        
        if ($conquistas->isEmpty()) {
            return response()->json(['error' => 'Nenhuma conquista encontrada'], 404);
        }
        
        return response()->json($conquistas);
    }


    public function progressoMissao(array $missoes)
    {
        $user = $auth->user();

        $Missoes = $user->userMissao()
            ->where('idMissao', $request->idMissao)
            ->where('date', now()->toDateString())
            ->where('concluida', 0)
            ->where('tipo', 'missao')
            ->first();

        $Conquistas = $user->userMissao()
            ->where('idMissao', $request->idMissao)
            ->where('concluida', 0)
            ->where('tipo', 'conquista')
            ->first();

        $userMissoes = array_merge($Missoes, $Conquistas);

        foreach($userMissoes as $missao){
            if($missao->idTipoMissao == 1){
                // Streak
                $missao->progresso += $user->streak;
                if ($missao->progresso >= $missao->missao->objetivo) {
                    $missao->concluida = 1;
                    $missao->progresso = $missao->missao->objetivo;
                }   
            } elseif($missao->idTipoMissao == 2){
                // Tempo 
                $tempoEmMinutos = $missoes->tempo / 60;
                if ($missao->progresso >= $missao->missao->objetivo) {
                    $missao->concluida = 1;
                    $missao->progresso = $missao->missao->objetivo;
                }
            } elseif($missao->idTipoMissao == 3){
                // XP
                $missao->progresso += $missoes->xp;
                if ($missao->progresso >= $missao->missao->objetivo) {
                    $missao->concluida = 1;
                    $missao->progresso = $missao->missao->objetivo;
                }
            } elseif($missao->idTipoMissao == 4){
                // JogoStreak
                foreach($missoes->jogo as $jogo){
                    if ($jogo == 1) {
                        $missao->progresso += 1;
                        if ($missao->progresso >= $missao->missao->objetivo) {
                            $missao->concluida = 1;
                            $missao->progresso = $missao->missao->objetivo;
                            break 2;
                        }
                    } else {
                        $missao->progresso = 0;
                    }
                }
            } elseif($missao->idTipoMissao == 5){
                // Jogo
                foreach($missoes->jogo as $jogo){
                    if ($jogo == 1) {
                        $missao->progresso += 1;
                        if ($missao->progresso >= $missao->missao->objetivo) {
                            $missao->concluida = 1;
                            $missao->progresso = $missao->missao->objetivo;
                            break 2;
                        }
                    }
                }
            } elseif($missao->idTipoMissao == 6){
                // Unidade
                if($missoes->taxaAcerto == 100){
                    $missao->progresso += 1;
                    if ($missao->progresso >= $missao->missao->objetivo) {
                        $missao->concluida = 1;
                        $missao->progresso = $missao->missao->objetivo;
                    }
                } else {
                    $missao->progresso = 0;
                }

            } elseif($missao->idTipoMissao == 7){
                // Curso
                $unidades = Unidade::where('idCurso', $missoes->unidade->idCurso)->where('ativo', 1)->get();

                foreach ($unidades as $unidade) {
                    $pivot = auth()->user()->unidade()->where('idUnidade', $unidade->id)->first();

                    if ($pivot && $pivot->pivot->status) {
                        $unidade->status = 1;
                    }else{
                        break 2;
                    }

                    $missao->progresso += 1;
                    if ($missao->progresso >= $missao->missao->objetivo) {
                        $missao->concluida = 1;
                        $missao->progresso = $missao->missao->objetivo;
                    }
                }                
            }

            $missao->save();
            $user->coins += $missao->moedas;
            $user->save();
        }
    }

    // progressaoMissaoDeAmigos
    public function progressoMissaoDeAmigos(request $request)
    {
        $request->validate([
            'idAmigo' => 'required|integer',
        ]);

        $user = $auth->user();

        $Missoes = $user->userMissao()
            ->where('idMissao', $request->idMissao)
            ->where('date', now()->toDateString())
            ->where('concluida', 0)
            ->where('tipo', 'missao')
            ->first();

        $Conquistas = $user->userMissao()
            ->where('idMissao', $request->idMissao)
            ->where('concluida', 0)
            ->where('tipo', 'conquista')
            ->first();

        $minhasMissoes = array_merge($Missoes, $Conquistas);

        $amigo = User::find($request->idAmigo);
        if (!$amigo) {
            return response()->json(['error' => 'Usuário não encontrado'], 404);
        }

        $Missoes = $amigo->userMissao()
            ->where('idMissao', $request->idMissao)
            ->where('date', now()->toDateString())
            ->where('concluida', 0)
            ->where('tipo', 'missao')
            ->first();

        $Conquistas = $amigo->userMissao()
            ->where('idMissao', $request->idMissao)
            ->where('concluida', 0)
            ->where('tipo', 'conquista')
            ->first();

        
        $amigoMissoes = array_merge($Missoes, $Conquistas);

        foreach($minhasMissoes as $missao){
            $missao->progresso += 1;
            if ($missao->progresso >= $missao->missao->objetivo) {
                $missao->concluida = 1;
                $missao->progresso = $missao->missao->objetivo;
            }
            $missao->save();
            $user->coins += $missao->moedas;
            $user->save();
        }

        foreach($amigoMissoes as $missao){
            $missao->progresso += 1;
            if ($missao->progresso >= $missao->missao->objetivo) {
                $missao->concluida = 1;
                $missao->progresso = $missao->missao->objetivo;
            }
            $missao->save();
            $amigo->coins += $missao->moedas;
            $amigo->save();
        }
    }
}
