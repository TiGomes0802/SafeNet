<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Produto;

class ProdutoSeeder extends Seeder
{
    public function run(): void
    {
        $produtos = [
            [
                'nome' => 'Congelar Streak',
                'preco' => 20,
                'valor' => 1,
                'idTipoProduto' => 1,
            ],
            [
                'nome' => '5 Vidas Extras',
                'preco' => 50,
                'valor' => 5,
                'idTipoProduto' => 2,
            ],
        ];

        foreach ($produtos as $produto) {
            Produto::create($produto);
        }
    }
}
