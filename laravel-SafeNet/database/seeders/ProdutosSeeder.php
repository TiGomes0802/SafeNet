<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Produto;

class ProdutosSeeder extends Seeder
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
                'nome' => '1 Vida Extra',
                'preco' => 10,
                'valor' => 1,
                'idTipoProduto' => 2,
            ],
            [
                'nome' => '5 Vidas Extras',
                'preco' => 45,
                'valor' => 5,
                'idTipoProduto' => 2,
            ],
            [
                'nome' => '10 Vidas Extras',
                'preco' => 90,
                'valor' => 10,
                'idTipoProduto' => 2,
            ],
        ];

        foreach ($produtos as $produto) {
            Produto::create($produto);
        }
    }
}
