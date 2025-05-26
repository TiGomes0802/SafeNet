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
            $this->info("Verificando streak do jogador: {$jogador->name} (ID: {$jogador->id}) - Streak: {$jogador->streak}, Streak Feita: {$jogador->streakFeita}");
            if ($jogador->streakFeita) {
                $jogador->streakFeita = false;
                $jogador->save();
                $this->info("Streak feita para o jogador {$jogador->name} (ID: {$jogador->id}) foi resetada.");
            }else if ($jogador->streak > 0) {   
                $congelar = $jogador->compra()
                    ->where('usado', false)
                    ->whereHas('produto.tipoProduto', function($query) {
                        $query->where('tipo', 'Gelo');
                    })
                    ->latest()
                    ->first();
                
                if ($congelar) { 
                    $congelar->usado = true;
                    $congelar->save();

                    $jogador->streakFeita = false;
                    $jogador->save();
                    $this->info("O jogador {$jogador->name} (ID: {$jogador->id}) possui um item de congelamento. Streak não será zerada. - Streak: {$jogador->streak}, Streak Feita: {$jogador->streakFeita}");
                    continue; 
                }
            
                $jogador->streak = 0;
                $jogador->save();

                $this->info("Streak do jogador {$jogador->name} (ID: {$jogador->id}) - Streak: {$jogador->streak}, Streak Feita: {$jogador->streakFeita}");
            }
        }
    }
}
