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
            ['tipo' => 'Gelo', 'imagem' => '/icons/gelo.png',],
            ['tipo' => 'Vidas', 'imagem' => '/icons/vida.png',],
        ];

        foreach ($tiposProdutos as $tipoProduto) {
            TipoProduto::create([
                'tipo' => $tipoProduto['tipo'],
                'imagem' => $tipoProduto['imagem'],
            ]);
        }
    }
}
