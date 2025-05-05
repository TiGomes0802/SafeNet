<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Unidade;

class UnidadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $unidades = [
            ['titulo' => 'Unidade 1', 'descricao' => 'Introdução à Engenharia Social', 'ordem' => 1, 'estado' => true, 'idCurso' => 1],
            ['titulo' => 'Unidade 2', 'descricao' => 'Técnicas Comuns de Engenharia Social', 'ordem' => 2, 'estado' => true, 'idCurso' => 1],
            ['titulo' => 'Unidade 3', 'descricao' => 'Prevenção e Resposta a Ataques', 'ordem' => 3, 'estado' => true, 'idCurso' => 1],
        ];

        foreach ($unidades as $unidade) {
            Unidade::create($unidade);
        }
    }
}
