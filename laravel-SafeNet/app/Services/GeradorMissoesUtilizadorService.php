<?php
// App\Services\GeradorMissoesUtilizadorService.php

namespace App\Services;

use App\Models\User;
use App\Models\Missao;
use App\Models\UserMissao;
use Carbon\Carbon;

class GeradorMissoesUtilizadorService
{
    public function gerarPara(User $user, int $quantidade = 3, bool $loja = false): void
    {
        info("Enviando missões para o utilizador {$user->username}");
        $hoje = Carbon::today();

        // Contar missões NÃO concluídas do utilizador
        $missoesNaoConcluidas = UserMissao::where('idUser', $user->id)
            ->where('concluida', false)
            ->count();

        // Limite máximo de missões em aberto
        $limiteMaximo = 5;

        if ($missoesNaoConcluidas >= $limiteMaximo) {
            info("Utilizador {$user->username} tem {$missoesNaoConcluidas} missões não concluídas. Não pode gerar mais (limite: {$limiteMaximo}).");
            return;
        }

        // Verifica se já tem missões de hoje
        $jaTemHoje = UserMissao::where('idUser', $user->id)
            ->whereDate('data', $hoje)
            ->exists();

        if ($jaTemHoje && !$loja) {
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
