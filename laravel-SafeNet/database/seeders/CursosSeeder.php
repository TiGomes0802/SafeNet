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
            ['nome' => 'Curso 1', 'status'=> true],
            ['nome' => 'Curso 2', 'status'=> true],
        ];

        foreach ($cursos as $curso) {
            Curso::create([
                'nome' => $curso['nome'],
                'status' => $curso['status'],
            ]);
        }
    }
}
