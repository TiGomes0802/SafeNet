<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Amigo;

class AmigosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ids = range(1, 20);
        $amizades = [];

        foreach ($ids as $id1) {
            // Cada utilizador vai ter entre 2 e 4 amigos
            $numAmigos = rand(11, 15);
            $possiveis = array_diff($ids, [$id1]);

            shuffle($possiveis);
            $amigos = array_slice($possiveis, 0, $numAmigos);

            foreach ($amigos as $id2) {
                // Verifica se já existe a amizade inversa
                $existe = collect($amizades)->contains(function ($a) use ($id1, $id2) {
                    return ($a['idUser1'] === $id2 && $a['idUser2'] === $id1) ||
                           ($a['idUser1'] === $id1 && $a['idUser2'] === $id2);
                });

                if (!$existe) {
                    $amizades[] = [
                        'idUser1' => $id1,
                        'idUser2' => $id2,
                    ];
                }
            }
        }

        foreach ($amizades as $amizade) {
            Amigo::create([
                'idUser1' => $amizade['idUser1'],
                'idUser2' => $amizade['idUser2'],
                'status' => 1,
            ]);
        }
    }
}
