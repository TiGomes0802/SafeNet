<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            ['tipo' => 'Boost'],
            ['tipo' => 'Vidas'],
        ];

        foreach ($tiposProdutos as $tipoProduto) {
            TipoProduto::create([
                'tipo' => $tipoProduto['tipo'],
            ]);
        }
    }
}
