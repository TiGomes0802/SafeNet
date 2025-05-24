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
            #Region Clientes
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
                ['type' => 'J', 'nome' => 'Cliente11', 'email' => 'cliente11@mail.com', 'username' => 'cliente11', 'xp' => rand(1, 2751)],
                ['type' => 'J', 'nome' => 'Cliente12', 'email' => 'cliente12@mail.com', 'username' => 'cliente12', 'xp' => rand(1, 2751)],
                ['type' => 'J', 'nome' => 'Cliente13', 'email' => 'cliente13@mail.com', 'username' => 'cliente13', 'xp' => rand(1, 2751)],
                ['type' => 'J', 'nome' => 'Cliente14', 'email' => 'cliente14@mail.com', 'username' => 'cliente14', 'xp' => rand(1, 2751)],
                ['type' => 'J', 'nome' => 'Cliente15', 'email' => 'cliente15@mail.com', 'username' => 'cliente15', 'xp' => rand(1, 2751)],
                ['type' => 'J', 'nome' => 'Cliente16', 'email' => 'cliente16@mail.com', 'username' => 'cliente16', 'xp' => rand(1, 2751)],
                ['type' => 'J', 'nome' => 'Cliente17', 'email' => 'cliente17@mail.com', 'username' => 'cliente17', 'xp' => rand(1, 2751)],
                ['type' => 'J', 'nome' => 'Cliente18', 'email' => 'cliente18@mail.com', 'username' => 'cliente18', 'xp' => rand(1, 2751)],
                ['type' => 'J', 'nome' => 'Cliente19', 'email' => 'cliente19@mail.com', 'username' => 'cliente19', 'xp' => rand(1, 2751)],
                ['type' => 'J', 'nome' => 'Cliente20', 'email' => 'cliente20@mail.com', 'username' => 'cliente20', 'xp' => rand(1, 2751)],
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