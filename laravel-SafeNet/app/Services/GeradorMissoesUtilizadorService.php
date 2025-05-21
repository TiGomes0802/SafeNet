<?php
// App\Services\GeradorMissoesUtilizadorService.php

namespace App\Services;

use App\Models\User;
use App\Models\Missao;
use App\Models\UserMissao;
use Carbon\Carbon;

class GeradorMissoesUtilizadorService
{
    public function gerarPara(User $user, int $quantidade = 3): void
    {
        info("Enviando missões para o utilizador {$user->username}");
        $hoje = Carbon::today();

        // Verifica se já tem missões de hoje
        $jaTemHoje = UserMissao::where('idUser', $user->id)
            ->whereDate('created_at', $hoje)
            ->exists();

        if ($jaTemHoje) {
            info("Ja tem missões para o utilizador {$user->username} hoje");
            return;
        }

        $missoes = Missao::where('tipo', 'missao')
                    ->where('estado', true)
                    ->get()
                    ->shuffle()
                    ->unique('idTipoMissao')
                    ->take($quantidade);

        foreach ($missoes as $missao) {
            UserMissao::create([
                'idUser' => $user->id,
                'idMissao' => $missao->id,
                'concluida' => false,
                'data' => now()->toDateString(),
            ]);
        }
    }
}
