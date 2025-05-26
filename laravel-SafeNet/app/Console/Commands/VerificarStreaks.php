<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class VerificarStreaks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:verificar-streaks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $this->info('Verificando streaks...');

        $jogadores = User::where('type', 'J')->get();
        foreach ($jogadores as $jogador) {
            // Verificar se o streak foi feito
            if ($jogador->streakFeita) {
                $jogador->streakFeita = false;
                $jogador->save();
            } if ($jogador->streak > 0) {   
                $congelar = $jogador->compra()
                    ->where('usado', false)
                    ->whereHas('produto.tipoProduto', function($query) {
                        $query->where('tipo', 'Gelo');
                    })
                    ->latest()
                    ->first();
                
                if ($congelar) { 
                    $congelar->estado = true;
                    $congelar->save();

                    $jogador->streakFeita = false;
                    $jogador->save();
                    continue; 
                }
                
                $jogador->streak = 0;
                $jogador->save();
            }
        }
    }
}
