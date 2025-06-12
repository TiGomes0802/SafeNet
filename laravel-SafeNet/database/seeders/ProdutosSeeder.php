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
                'descricao' => 'Congela a streak atual no dia atual caso não tenha sido concluída.',
                'estado' => 1,
                'idTipoProduto' => 1,
                'imagem' => 'gelo.png',
            ],
            [
                'nome' => '1 Vida Extra',
                'preco' => 10,
                'valor' => 1,
                'descricao' => 'O jogador ganha um vida extra.',
                'estado' => 1,
                'idTipoProduto' => 2,
                'imagem' => 'vida.png',
            ],
            [
                'nome' => '5 Vidas Extras',
                'preco' => 45,
                'valor' => 5,
                'descricao' => 'O jogador ganha 5 vidas extras.',
                'estado' => 1,
                'idTipoProduto' => 2,
                'imagem' => '5vidas.png',
            ],
            [
                'nome' => '10 Vidas Extras',
                'preco' => 90,
                'valor' => 10,
                'descricao' => 'O jogador ganha 10 vidas extras.',
                'estado' => 1,
                'idTipoProduto' => 2,
                'imagem' => '10vidas.png',
            ],
            [
                'nome' => 'Missão Extra',
                'preco' => 30,
                'valor' => 1,
                'descricao' => 'Permite ao jogador completar uma missão extra no dia atual.',
                'estado' => 1,
                'idTipoProduto' => 3,
                'imagem' => 'missao.png',
            ],
        ];

        foreach ($produtos as $produto) {
            Produto::create($produto);
        }
    }
}
