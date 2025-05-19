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
                'nome' => 'Boost x2',
                'preco' => 20,
                'imagem' => '/icons/boost2x.png',
                'tipo_produto_id' => 1,
            ],
            [
                'nome' => 'Vida Extra',
                'preco' => 50,
                'imagem' => '/icons/vida.png',
                'tipo_produto_id' => 2,
            ],
        ];

        foreach ($produtos as $produto) {
            Produto::create($produto);
        }
    }
}
