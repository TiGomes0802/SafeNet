<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Missao;
use App\Models\UserMissao;

class UserSeeder extends Seeder
{

    public function run()
    {
        $imagens = collect(Storage::disk('public')->files('photos'))
            ->filter(fn($file) => preg_match('/\.(jpg|jpeg|png|webp)$/i', $file))
            ->map(fn($file) => basename($file)) // <-- só o nome do ficheiro
            ->values()
            ->toArray();

        $users = [
            #Region Clientes
                ['type' => 'J', 'nome' => 'João Silva', 'email' => 'cliente1@mail.com', 'username' => 'joao_silva', 'xp' => rand(1, 2751)],
                ['type' => 'J', 'nome' => 'Ana Silva', 'email' => 'ana.silva@mail.com', 'username' => 'ana_silva', 'xp' => rand(1, 2751)],
                ['type' => 'J', 'nome' => 'Bruno Costa', 'email' => 'bruno.costa@mail.com', 'username' => 'bruno_c', 'xp' => rand(1, 2751)],
                ['type' => 'J', 'nome' => 'Carla Mendes', 'email' => 'carla.mendes@mail.com', 'username' => 'carlam', 'xp' => rand(1, 2751)],
                ['type' => 'J', 'nome' => 'David Rocha', 'email' => 'david.rocha@mail.com', 'username' => 'david_r', 'xp' => rand(1, 2751)],
                ['type' => 'J', 'nome' => 'Carla Lopes', 'email' => 'Carla.lopes@mail.com', 'username' => 'carlalopes', 'xp' => rand(1, 2751)],
                ['type' => 'J', 'nome' => 'Filipe Moura', 'email' => 'filipe.moura@mail.com', 'username' => 'filipe_m', 'xp' => rand(1, 2751)],
                ['type' => 'J', 'nome' => 'Gabriela Nunes', 'email' => 'gabriela.nunes@mail.com', 'username' => 'gabinunes', 'xp' => rand(1, 2751)],
                ['type' => 'J', 'nome' => 'Henrique Dias', 'email' => 'henrique.dias@mail.com', 'username' => 'henrique_d', 'xp' => rand(1, 2751)],
                ['type' => 'J', 'nome' => 'Inês Pinto', 'email' => 'ines.pinto@mail.com', 'username' => 'ines_p', 'xp' => rand(1, 2751)],
                ['type' => 'J', 'nome' => 'João Almeida', 'email' => 'joao.almeida@mail.com', 'username' => 'joaoa', 'xp' => rand(1, 2751)],
                ['type' => 'J', 'nome' => 'Karina Ramos', 'email' => 'karina.ramos@mail.com', 'username' => 'karinar', 'xp' => rand(1, 2751)],
                ['type' => 'J', 'nome' => 'Luís Fonseca', 'email' => 'luis.fonseca@mail.com', 'username' => 'lfonseca', 'xp' => rand(1, 2751)],
                ['type' => 'J', 'nome' => 'Marta Carvalho', 'email' => 'marta.carvalho@mail.com', 'username' => 'martac', 'xp' => rand(1, 2751)],
                ['type' => 'J', 'nome' => 'Paulo Reis', 'email' => 'Paulo.reis@mail.com', 'username' => 'preis', 'xp' => rand(1, 2751)],
                ['type' => 'J', 'nome' => 'Olívia Teixeira', 'email' => 'olivia.teixeira@mail.com', 'username' => 'olivia_t', 'xp' => rand(1, 2751)],
                ['type' => 'J', 'nome' => 'Paulo Matos', 'email' => 'paulo.matos@mail.com', 'username' => 'paulom', 'xp' => rand(1, 2751)],
                ['type' => 'J', 'nome' => 'Quélia Tavares', 'email' => 'quelia.tavares@mail.com', 'username' => 'queliat', 'xp' => rand(1, 2751)],
                ['type' => 'J', 'nome' => 'Ricardo Vieira', 'email' => 'ricardo.vieira@mail.com', 'username' => 'ricardov', 'xp' => rand(1, 2751)],
                ['type' => 'J', 'nome' => 'Sara Monteiro', 'email' => 'sara.monteiro@mail.com', 'username' => 'saram', 'xp' => rand(1, 2751)],
                ['type' => 'J', 'nome' => 'Tiago Cruz', 'email' => 'tiago.cruz@mail.com', 'username' => 'tiagoc', 'xp' => rand(1, 2751)],
            #EndRegion

            #Region Gestores
                ['type' => 'G', 'nome' => 'Gestor1', 'email' => 'gestor1@mail.com', 'username' => 'gestor1'],
                ['type' => 'G', 'nome' => 'Gestor2', 'email' => 'gestor2@mail.com', 'username' => 'gestor2'],
            #EndRegion

            #Region Admins
                ['type' => 'A', 'nome' => 'Admin1', 'email' => 'admin1@mail.com', 'username' => 'admin1'],
                ['type' => 'A', 'nome' => 'Admin2', 'email' => 'admin2@mail.com', 'username' => 'admin2'],
            #EndRegion
        ];



        foreach ($users as $newUser) {
            $user = User::create([
                'nome' => $newUser['nome'],
                'email' => $newUser['email'],
                'username' => $newUser['username'],
                'foto' => $newUser['foto'] ?? null,
                'password' => Hash::make('123'),
                'type' => $newUser['type'],
                'xp' => $newUser['xp'] ?? 0,
                'foto' => $imagens[array_rand($imagens)],
            ]);

            if ($user->type === 'J') {
                $conquistas = Missao::where('tipo', 'conquista')->get();
                foreach ($conquistas as $conquista) {
                    UserMissao::create([
                        'idUser' => $user->id,
                        'idMissao' => $conquista->id,
                        'concluida' => false,
                        'data' => null,
                    ]);
                }
            }
        }
    }
}
