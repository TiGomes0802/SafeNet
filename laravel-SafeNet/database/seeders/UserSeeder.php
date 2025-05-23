<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Missao;
use App\Models\UserMissao;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            // Clientes
            ['type' => 'J', 'nome' => 'Cliente1', 'email' => 'cliente1@mail.com', 'username' => 'cliente1', 'xp' => rand(1, 2751)],
            ['type' => 'J', 'nome' => 'Cliente2', 'email' => 'cliente2@mail.com', 'username' => 'cliente2', 'xp' => rand(1, 2751)],
            ['type' => 'J', 'nome' => 'Cliente3', 'email' => 'cliente3@mail.com', 'username' => 'cliente3', 'xp' => rand(1, 2751)],
            ['type' => 'J', 'nome' => 'Cliente4', 'email' => 'cliente4@mail.com', 'username' => 'cliente4', 'xp' => rand(1, 2751)],
            ['type' => 'J', 'nome' => 'Cliente5', 'email' => 'cliente5@mail.com', 'username' => 'cliente5', 'xp' => rand(1, 2751)],
            ['type' => 'J', 'nome' => 'Cliente6', 'email' => 'cliente6@mail.com', 'username' => 'cliente6', 'xp' => rand(1, 2751)],
            ['type' => 'J', 'nome' => 'Cliente7', 'email' => 'cliente7@mail.com', 'username' => 'cliente7', 'xp' => rand(1, 2751)],
            ['type' => 'J', 'nome' => 'Cliente8', 'email' => 'cliente8@mail.com', 'username' => 'cliente8', 'xp' => rand(1, 2751)],
            ['type' => 'J', 'nome' => 'Cliente9', 'email' => 'cliente9@mail.com', 'username' => 'cliente9', 'xp' => rand(1, 2751)],
            ['type' => 'J', 'nome' => 'Cliente10', 'email' => 'cliente10@mail.com', 'username' => 'cliente10', 'xp' => rand(1, 2751)],

            // Gestores
            ['type' => 'G', 'nome' => 'Gestor1', 'email' => 'gestor1@mail.com', 'username' => 'gestor1'],
            ['type' => 'G', 'nome' => 'Gestor2', 'email' => 'gestor2@mail.com', 'username' => 'gestor2'],

            // Admins
            ['type' => 'A', 'nome' => 'Admin1', 'email' => 'admin1@mail.com', 'username' => 'admin1'],
            ['type' => 'A', 'nome' => 'Admin2', 'email' => 'admin2@mail.com', 'username' => 'admin2'],
        ];



        foreach ($users as $newUser) {
            $user = User::create([
                'nome' => $newUser['nome'],
                'email' => $newUser['email'],
                'username' => $newUser['username'],
                'password' => Hash::make('123'),
                'type' => $newUser['type'],
                'xp' => $newUser['xp'] ?? 0,
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