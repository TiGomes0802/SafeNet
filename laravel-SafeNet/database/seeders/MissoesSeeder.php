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
        $missoes = [
            // Conquistas
            [
                "tipo" => "conquista",
                "estado" => "true",
                "descricao" => "Topo da montanha - Chegar à divisão de mestre",
                "objetivo" => "2751",
                "modeas" => "50",
                "idTipoMissao" => "3",
            ],
            [
                "tipo" => "conquista",
                "estado" => "true",
                "descricao" => "Diamante - Chegar à divisão de diamante",
                "objetivo" => "2201",
                "modeas" => "40",
                "idTipoMissao" => "3",
            ],
            [
                "tipo" => "conquista",
                "estado" => "true",
                "descricao" => "Desbravador - Chegar à divisão de platina",
                "objetivo" => "1651",
                "modeas" => "30",
                "idTipoMissao" => "3",
            ],
            [
                "tipo" => "conquista",
                "estado" => "true",
                "descricao" => "Aventureiro - Chegar à divisão de ouro",
                "objetivo" => "1101",
                "modeas" => "20",
                "idTipoMissao" => "3",
            ],
            [
                "tipo" => "conquista",
                "estado" => "true",
                "descricao" => "Explorador - Chegar à divisão de prata",
                "objetivo" => "551",
                "modeas" => "10",
                "idTipoMissao" => "3",
            ],
            [
                "tipo" => "conquista",
                "estado" => "true",
                "descricao" => "Ano Novo - Conseguir um ano de streak",
                "objetivo" => "365",
                "modeas" => "5",
                "idTipoMissao" => "1",
            ],
            [
                "tipo" => "conquista",
                "estado" => "true",
                "descricao" => "100% - Conseguir 100 jogos sem errar nenhuma pergunta",
                "objetivo" => "100",
                "modeas" => "25",
                "idTipoMissao" => "4",
            ],
            [
                "tipo" => "conquista",
                "estado" => "true",
                "descricao" => "500 jogos - Jogar 500 jogos",
                "objetivo" => "500",
                "modeas" => "50",
                "idTipoMissao" => "5",
            ],
            [
                "tipo" => "conquista",
                "estado" => "true",
                "descricao" => "Amigos para sempre - Fazer 3 amigos",
                "objetivo" => "3",
                "modeas" => "20",
                "idTipoMissao" => "8",
            ],
            [
                "tipo" => "conquista",
                "estado" => "true",
                "descricao" => "Curso 1 - Terminar a curso 1",
                "objetivo" => "1",
                "modeas" => "10",
                "idTipoMissao" => "7",
            ],
            // Missoes
            [
                "tipo" => "missao",
                "estado" => "true",
                "descricao" => "Ganhar 20 de XP",
                "objetivo" => "5",
                "modeas" => "50",
                "idTipoMissao" => "3",
            ],
            [
                "tipo" => "missao",
                "estado" => "true",
                "descricao" => "Ganhar 50 de XP",
                "objetivo" => "10",
                "modeas" => "100",
                "idTipoMissao" => "3",
            ],
            [
                "tipo" => "missao",
                "estado" => "true",
                "descricao" => "Consiga 3 unidades perfeitas",
                "objetivo" => "3",
                "modeas" => "10",
                "idTipoMissao" => "6",
            ],
            [
                "tipo" => "missao",
                "estado" => "true",
                "descricao" => "Consiga 5 unidades perfeitas",
                "objetivo" => "5",
                "modeas" => "20",
                "idTipoMissao" => "6",
            ],
            [
                "tipo" => "missao",
                "estado" => "true",
                "descricao" => "Estude durante 10 minutos",
                "objetivo" => "10",
                "modeas" => "5",
                "idTipoMissao" => "3",
            ],
        ];

        foreach ($missoes as $missao) {
            Missao::create($missao);
        }


    }
}
