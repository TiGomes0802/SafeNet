<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Rank;

class RankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ranks = [
            ['nome' => 'Bronze', 'minimo' => '0', 'maximo' => '550', 'imagem' => 'bronze.png'],
            ['nome' => 'Prata', 'minimo' => '551', 'maximo' => '1100', 'imagem' => 'prata.png'],
            ['nome' => 'Ouro', 'minimo' => '1101', 'maximo' => '1650', 'imagem' => 'ouro.png'],
            ['nome' => 'Platina', 'minimo' => '1651', 'maximo' => '2200', 'imagem' => 'platina.png'],
            ['nome' => 'Diamante', 'minimo' => '2201', 'maximo' => '2750', 'imagem' => 'diamante.png'],
            ['nome' => 'Mestre', 'minimo' => '2751', 'maximo' => '99999999', 'imagem' => 'mestre.png'],
        ];

        foreach ($ranks as $rank) {
            Rank::create([
                'nome' => $rank['nome'],
                'minimo' => $rank['minimo'],
                'maximo' => $rank['maximo'],
                'imagem' => $rank['imagem'],
            ]);
        }
    }
}
