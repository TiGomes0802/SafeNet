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
            ->where('data' , '>=', now())
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

    //progressoMissao
    public function progressoMissao(Request $request)
    {
        return true;
    }

}
