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
                'pergunta' => 'Qual é a capital de Portugal?',
                'estado' => true,
                'idGestor' => 6,
                'idTipo' => 1,
                'idUnidade' => 1,
            ],
            [
                'xp' => 20,
                'pergunta' => 'Qual é a capital de Espanha?',
                'estado' => true,
                'idGestor' => 6,
                'idTipo' => 2,
                'idUnidade' => 1,
            ],
            [
                'xp' => 30,
                'pergunta' => 'Qual é a capital de França?',
                'estado' => false,
                'idGestor' => 6,
                'idTipo' => 3,
                'idUnidade' => 1,
            ],
            [
                'xp' => 40,
                'pergunta' => 'Qual é a capital de Itália?',
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
