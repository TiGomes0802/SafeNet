<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Services\GeradorMissoesUtilizadorService;

class GerarMissoesDiarias extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:gerar-missoes-diarias';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gerar missões diárias para todos os utilizadores';

    protected $geradorMissoes;

    // Injeção do serviço via construtor
    public function __construct(GeradorMissoesUtilizadorService $geradorMissoes)
    {
        parent::__construct();
        $this->geradorMissoes = $geradorMissoes;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {

        User::where('type', 'J')->chunk(100, function ($users) {
            foreach ($users as $user) {
                $this->geradorMissoes->gerarPara($user);
            }
        });
        \Log::info('Comando app:gerar-missoes-diarias executado às ' . now());
        $this->info('Missões diárias geradas para todos os utilizadores do tipo J.');
    }
}
