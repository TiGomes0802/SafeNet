<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoProduto;

class TipoProdutoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tiposProdutos = [
            ['tipo' => 'Gelo'],
            ['tipo' => 'Vidas'],
            ['tipo' => 'Missao'],
        ];

        foreach ($tiposProdutos as $tipoProduto) {
            TipoProduto::create([
                'tipo' => $tipoProduto['tipo'],
            ]);
        }
    }
}
