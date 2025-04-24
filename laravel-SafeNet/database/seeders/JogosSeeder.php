<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jogo;

class JogosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jogos = [
            [
                'xp' => 10,
                'estado' => true,
                'idGestor' => 6,
                'idTipo' => 1,
                'idUnidade' => 1,
            ],
            [
                'xp' => 20,
                'estado' => true,
                'idGestor' => 6,
                'idTipo' => 2,
                'idUnidade' => 1,
            ],
            [
                'xp' => 30,
                'estado' => false,
                'idGestor' => 6,
                'idTipo' => 3,
                'idUnidade' => 1,
            ],
            [
                'xp' => 40,
                'estado' => true,
                'idGestor' => 6,
                'idTipo' => 4,
                'idUnidade' => 2,
            ],
  
        ];

        foreach ($jogos as $jogo) {
            Jogo::create($jogo);
        }
    }
}
