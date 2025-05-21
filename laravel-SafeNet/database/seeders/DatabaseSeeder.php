<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(TipoJogosSeeder::class);
        $this->call(TipoProdutoSeeder::class);
        $this->call(ProdutosSeeder::class);
        $this->call(CursosSeeder::class);
        $this->call(UnidadesSeeder::class);
        $this->call(PaginasSeeder::class);
        $this->call(JogosSeeder::class);
        $this->call(RespostasSeeder::class);
        $this->call(RankSeeder::class);
    }
}
