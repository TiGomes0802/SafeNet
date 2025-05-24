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
            ['nome' => 'Engenharia Social', 'estado'=> true],
            ['nome' => 'Malware', 'estado'=> false],
            ['nome' => 'DEMO', 'estado'=> true],
        ];

        foreach ($cursos as $curso) {
            Curso::create($curso);
        }
    }
}
