<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoJogo;

class TipoJogosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tiposDeJogos = [
            ['tipo' => 'Verdadeiro/Falso'],
            ['tipo' => 'Escolha Múltipla'],
            ['tipo' => 'Preencher os espaços em branco'],
            ['tipo' => 'Ordenar'],
            ['tipo' => 'Arrastar e Soltar'],
            ['tipo' => 'Completar a frase'],
        ];

        foreach ($tiposDeJogos as $tipoDeJogo) {
            TipoJogo::create([
                'tipo' => $tipoDeJogo['tipo'],
            ]);
        }
    }
}
// php artisan db:seed --class=TipoJogosSeeder