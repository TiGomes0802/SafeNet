<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Missao;
use App\Models\User;
use App\Models\UserMissao;
use App\Models\Unidade;
use Carbon\Carbon;

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


    public function alterarEstadoMissao(Request $request, $id)
    {
        $missao = Missao::find($id);
        if (!$missao) {
            return response()->json(['error' => 'Missão não encontrada'], 404);
        }

        $missao->estado = !$missao->estado; // Inverte o estado da missão
        $missao->save();

        return response()->json($missao, 200);
    }

    public function progressoMissao($missoes)
    {
        $user = auth()->user();

        $minhasMissoes = $user->userMissao()
            ->whereDate('data', Carbon::today())
            ->where('concluida', 0)
            ->whereHas('missao', function ($query) {
                $query->where('tipo', 'missao');
            })->get();
        
        $minhasConquistas = $user->userMissao()
            ->where('concluida', 0)
            ->whereHas('missao', function ($query) {
                $query->where('tipo', 'conquista');
            })->get();

        $userMissoes = array_merge($minhasMissoes->all(), $minhasConquistas->all());

        foreach($userMissoes as $missao){
            if($missao->missao->idTipoMissao == 1){
                // Streak
                $missao->progresso += $user->streak;
                if ($missao->progresso >= $missao->missao->objetivo) {
                    $missao->concluida = 1;
                    $missao->progresso = $missao->missao->objetivo;
                    $user->moedas += $missao->missao->moedas;
                }   
            } elseif($missao->missao->idTipoMissao == 2){
                // Tempo 
                $tempoEmMinutos = $missoes->tempo / 60;
                $missao->progresso += $tempoEmMinutos;
                if ($missao->progresso >= $missao->missao->objetivo) {
                    $missao->concluida = 1;
                    $missao->progresso = $missao->missao->objetivo;
                    $user->moedas += $missao->missao->moedas;
                }
            } elseif($missao->missao->idTipoMissao == 3){
                // XP
                $missao->progresso += $missoes->xp;
                if ($missao->progresso >= $missao->missao->objetivo) {
                    $missao->concluida = 1;
                    $missao->progresso = $missao->missao->objetivo;
                    $user->moedas += $missao->missao->moedas;
                }
            } elseif($missao->missao->idTipoMissao == 4){
                // JogoStreak
                foreach($missoes->jogo as $jogo){
                    if ($jogo == 1) {
                        $missao->progresso += 1;
                        if ($missao->progresso >= $missao->missao->objetivo) {
                            $missao->concluida = 1;
                            $missao->progresso = $missao->missao->objetivo;
                            $user->moedas += $missao->missao->moedas;
                            break;
                        }
                    } else {
                        $missao->progresso = 0;
                    }
                }
            } elseif($missao->missao->idTipoMissao == 5){
                // Jogo
                foreach($missoes->jogo as $jogo){
                    if ($jogo == 1) {
                        $missao->progresso += 1;
                        if ($missao->progresso >= $missao->missao->objetivo) {
                            $missao->concluida = 1;
                            $missao->progresso = $missao->missao->objetivo;
                            $user->moedas += $missao->missao->moedas;
                            break;
                        }
                    }
                }
            } elseif($missao->missao->idTipoMissao == 6){
                // Unidade
                if($missoes->taxaAcerto == 100){
                    $missao->progresso += 1;
                    if ($missao->progresso >= $missao->missao->objetivo) {
                        $missao->concluida = 1;
                        $missao->progresso = $missao->missao->objetivo;
                        $user->moedas += $missao->missao->moedas;
                    }
                } else {
                    $missao->progresso = 0;
                }

            } elseif($missao->missao->idTipoMissao == 7){
                // Curso
                $unidades = Unidade::where('idCurso', $missoes->unidade->idCurso)->where('estado', 1)->get();

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
                        $user->moedas += $missao->missao->moedas;
                    }
                }                
            } elseif($missao->missao->idTipoMissao == 8){
                $missao->progresso = $user->xp;
                if ($missao->progresso >= $missao->missao->objetivo) {
                    $missao->concluida = 1;
                    $missao->progresso = $missao->missao->objetivo;
                    $user->moedas += $missao->missao->moedas;
                }
            }
            $missao->save();

        }

        $user->save();
    }

    // progressaoMissaoDeAmigos
    public function progressoMissaoDeAmigos($user)
    {
        $missoes = $user->userMissao()
            ->whereDate('data', Carbon::today())
            ->where('concluida', 0)
            ->whereHas('missao', function ($query) {
                $query->where('tipo', 'missao');
            })
            ->whereHas('missao.tipoMissao', function ($query) {
                $query->where('id', '9');
            })
            ->get();
        
        $conquistas = $user->userMissao()
            ->where('concluida', 0)
            ->whereHas('missao', function ($query) {
                $query->where('tipo', 'conquista');
            })
            ->whereHas('missao.tipoMissao', function ($query) {
                $query->where('id', '9');
            })
            ->get();

        $minhasMissoes = array_merge($missoes->all(), $conquistas->all());
        
        foreach($minhasMissoes as $missao){
            $missao->progresso += 1;
            if ($missao->progresso >= $missao->missao->objetivo) {
                $missao->concluida = 1;
                $missao->progresso = $missao->missao->objetivo;
                $user->moedas += $missao->missao->moedas;
            }
            $missao->save();
        }
        $user->save();
    }
}
