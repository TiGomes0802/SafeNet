<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Curso;

class CursosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cursos = [
            ['nome' => 'Curso 1', 'estado'=> true],
            ['nome' => 'Curso 2', 'estado'=> true],
        ];

        foreach ($cursos as $curso) {
            Curso::create($curso);
        }
    }
}
