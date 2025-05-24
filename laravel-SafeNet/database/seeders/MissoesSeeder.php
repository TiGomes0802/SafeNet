<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Missao;

class MissoesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $conquistas = [
            [
                "tipo" => "conquista",
                "estado" => true,
                "descricao" => "Topo da montanha - Chegar à divisão de mestre",
                "objetivo" => "2751",
                "moedas" => "50",
                "idTipoMissao" => "8",
            ],
            [
                "tipo" => "conquista",
                "estado" => true,
                "descricao" => "Diamante - Chegar à divisão de diamante",
                "objetivo" => "2201",
                "moedas" => "40",
                "idTipoMissao" => "8",
            ],
            [
                "tipo" => "conquista",
                "estado" => true,
                "descricao" => "Desbravador - Chegar à divisão de platina",
                "objetivo" => "1651",
                "moedas" => "30",
                "idTipoMissao" => "8",
            ],
            [
                "tipo" => "conquista",
                "estado" => true,
                "descricao" => "Aventureiro - Chegar à divisão de ouro",
                "objetivo" => "1101",
                "moedas" => "20",
                "idTipoMissao" => "8",
            ],
            [
                "tipo" => "conquista",
                "estado" => true,
                "descricao" => "Explorador - Chegar à divisão de prata",
                "objetivo" => "551",
                "moedas" => "10",
                "idTipoMissao" => "8",
            ],
            [
                "tipo" => "conquista",
                "estado" => true,
                "descricao" => "Ano Novo - Conseguir um ano de streak",
                "objetivo" => "365",
                "moedas" => "5",
                "idTipoMissao" => "1",
            ],
            [
                "tipo" => "conquista",
                "estado" => true,
                "descricao" => "100% - Conseguir 100 jogos sem errar nenhuma pergunta",
                "objetivo" => "100",
                "moedas" => "25",
                "idTipoMissao" => "4",
            ],
            [
                "tipo" => "conquista",
                "estado" => true,
                "descricao" => "500 jogos - Jogar 500 jogos",
                "objetivo" => "500",
                "moedas" => "50",
                "idTipoMissao" => "5",
            ],
            [
                "tipo" => "conquista",
                "estado" => true,
                "descricao" => "Amigos para sempre - Fazer 3 amigos",
                "objetivo" => "3",
                "moedas" => "20",
                "idTipoMissao" => "9",
            ],
            [
                "tipo" => "conquista",
                "estado" => true,
                "descricao" => "Curso 1 - Terminar a curso 1",
                "objetivo" => "1",
                "moedas" => "10",
                "idTipoMissao" => "7",
            ],
            [
                "tipo" => "conquista",
                "estado" => true,
                "descricao" => "Estudioso - Estudar 500 horas",
                "objetivo" => "500",
                "moedas" => "50",
                "idTipoMissao" => "2",
            ],
        ];

        $missoes = [
            [
                "tipo" => "missao",
                "estado" => true,
                "descricao" => "Estuda durante 5 minutos",
                "objetivo" => "5",
                "moedas" => "3",
                "idTipoMissao" => "2",
            ],
            [
                "tipo" => "missao",
                "estado" => true,
                "descricao" => "Estude durante 10 minutos",
                "objetivo" => "10",
                "moedas" => "5",
                "idTipoMissao" => "2",
            ],
            [
                "tipo" => "missao",
                "estado" => true,
                "descricao" => "Ganhar 150 de XP",
                "objetivo" => "150",
                "moedas" => "5",
                "idTipoMissao" => "3",
            ],
            [
                "tipo" => "missao",
                "estado" => true,
                "descricao" => "Ganhar 250 de XP",
                "objetivo" => "250",
                "moedas" => "15",
                "idTipoMissao" => "3",
            ],
            [
                "tipo" => "missao",
                "estado" => true,
                "descricao" => "Ganhar 5 jogos sem errar nenhuma pergunta",
                "objetivo" => "5",
                "moedas" => "5",
                "idTipoMissao" => "4",
            ],
            [
                "tipo" => "missao",
                "estado" => true,
                "descricao" => "Ganhar 10 jogos sem errar nenhuma pergunta",
                "objetivo" => "10",
                "moedas" => "10",
                "idTipoMissao" => "4",
            ],
            [
                "tipo" => "missao",
                "estado" => true,
                "descricao" => "Ganhar 5 jogos",
                "objetivo" => "5",
                "moedas" => "5",
                "idTipoMissao" => "5",
            ],
            [
                "tipo" => "missao",
                "estado" => true,
                "descricao" => "Ganhar 10 jogos",
                "objetivo" => "10",
                "moedas" => "10",
                "idTipoMissao" => "5",
            ],
            [
                "tipo" => "missao",
                "estado" => true,
                "descricao" => "Consiga 1 unidade perfeita",
                "objetivo" => "1",
                "moedas" => "5",
                "idTipoMissao" => "6",
            ],
            [
                "tipo" => "missao",
                "estado" => true,
                "descricao" => "Consiga 3 unidades perfeitas",
                "objetivo" => "3",
                "moedas" => "15",
                "idTipoMissao" => "6",
            ],
        ];

        $missoes = array_merge($conquistas, $missoes);

        foreach ($missoes as $missao) {
            Missao::create($missao);
        }
    }
}
