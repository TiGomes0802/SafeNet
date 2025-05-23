<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rank;
use App\Models\User;

class RankController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Obter todos os ranks para associar por XP
        $ranks = Rank::all();

        // Obter todos os utilizadores ordenados por XP
        $utilizadores = User::where('type', 'J')->orderByDesc('xp')->get();

        
        // Gerar mapa de posições
        $posicoes = $utilizadores->pluck('id')->values()->flip()->map(fn($index) => $index + 1);
        
        

        // Função para obter nome do rank por XP
        $getRank = function ($xp) use ($ranks) {
            return $ranks->first(fn($r) => $xp >= $r->minimo && $xp <= $r->maximo)?->nome ?? 'Sem Rank';
        };
        
        // 🌍 Ranking Mundial
        $mundial = $utilizadores->take(15)->map(function ($u) use ($posicoes, $getRank) {
            return [
                'posicao' => $posicoes[$u->id],
                'username' => $u->username,
                'rank' => $getRank($u->xp),
                'xp' => $u->xp,
            ];
        });

        // 🧑‍🤝‍🧑 Ranking dos Amigos
        $amigos = $user->todosAmigos();

        $rankingAmigos = collect($amigos)
            ->filter(fn($amigo) => $amigo->type === 'J' && isset($posicoes[$amigo->id]))
            ->map(function ($amigo) use ($posicoes, $getRank) {
                return [
                    'posicao' => $posicoes[$amigo->id],
                    'username' => $amigo->username,
                    'rank' => $getRank($amigo->xp),
                    'xp' => $amigo->xp,
                ];
            })
            ->sortBy('posicao')
            ->values();

        return response()->json([
            'mundial' => $mundial,
            'amigos' => $rankingAmigos,
        ]);
    }
}
