<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TipoMissao;

class TipoMissoesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos = [
            [
                "tipo" => "Streak",
            ],
            [
                "tipo" => "Tempo",
            ],
            [
                "tipo" => "XP",
            ],
            [
                "tipo" => "JogoStreek",
            ],
            [
                "tipo" => "Jogo",
            ],
            [
                "tipo" => "Unidade",
            ],
            [
                "tipo" => "Curso",
            ],
            [
                "tipo" => "Rank",
            ],
            [
                "tipo" => "Social",
            ],
        ];

        foreach ($tipos as $tipo) {
            TipoMissao::create($tipo);
        }
    }
}
