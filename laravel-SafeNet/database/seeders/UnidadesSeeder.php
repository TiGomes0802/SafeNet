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
            ['titulo' => 'Unidade 1', 'descricao' => 'Descrição da Unidade 1','ordem' => 1 ,'status' => true ,'idCurso' => 1],
            ['titulo' => 'Unidade 2', 'descricao' => 'Descrição da Unidade 2','ordem' => 2 ,'status' => true ,'idCurso' => 1],
            ['titulo' => 'Unidade 1', 'descricao' => 'Descrição da Unidade 1','ordem' => 1 ,'status' => true ,'idCurso' => 2],
        ];

        foreach ($unidades as $unidade) {
            Unidade::create([
                'titulo' => $unidade['titulo'],
                'descricao' => $unidade['descricao'],
                'ordem' => $unidade['ordem'],
                'status' => $unidade['status'],
                'idCurso' => $unidade['idCurso'],
            ]);
        }
    }
}
