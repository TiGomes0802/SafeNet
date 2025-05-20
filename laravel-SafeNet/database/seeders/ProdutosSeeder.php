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
                'nome' => 'Congelar streak',
                'preco' => 20,
                'valor' => 1,
                'imagem' => '/icons/boost2x.png',
                'tipo_produto_id' => 1,
            ],
            [
                'nome' => '5 Vidas Extras',
                'preco' => 50,
                'valor' => 5,
                'imagem' => '/icons/vida.png',
                'tipo_produto_id' => 2,
            ],
        ];

        foreach ($produtos as $produto) {
            Produto::create($produto);
        }
    }
}
