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
            ['type' => 'J', 'nome' => 'João Silva', 'email' => 'cliente1@mail.com', 'username' => 'joao_silva', 'xp' => rand(1, 2751), 'foto' => '169_675422da5e01e.jpg'],
            ['type' => 'J', 'nome' => 'Ana Silva', 'email' => 'ana.silva@mail.com', 'username' => 'ana_silva', 'xp' => rand(1, 2751), 'foto' => '4_675422d974d6e.jpg'],
            ['type' => 'J', 'nome' => 'Bruno Costa', 'email' => 'bruno.costa@mail.com', 'username' => 'bruno_c', 'xp' => rand(1, 2751), 'foto' => '2_675422d96fa8e.jpg'],
            ['type' => 'J', 'nome' => 'Carla Mendes', 'email' => 'carla.mendes@mail.com', 'username' => 'carlam', 'xp' => rand(1, 2751), 'foto' => '6_675422d97b79a.jpg'],
            ['type' => 'J', 'nome' => 'David Rocha', 'email' => 'david.rocha@mail.com', 'username' => 'david_r', 'xp' => rand(1, 2751), 'foto' => '3_675422d972104.jpg'],
            ['type' => 'J', 'nome' => 'Eva Lopes', 'email' => 'eva.lopes@mail.com', 'username' => 'evalopes', 'xp' => rand(1, 2751), 'foto' => '23_675422d9e9e9c.jpg'],
            ['type' => 'J', 'nome' => 'Filipe Moura', 'email' => 'filipe.moura@mail.com', 'username' => 'filipe_m', 'xp' => rand(1, 2751), 'foto' => '15_675422d990620.jpg'],
            ['type' => 'J', 'nome' => 'Gabriela Nunes', 'email' => 'gabriela.nunes@mail.com', 'username' => 'gabinunes', 'xp' => rand(1, 2751), 'foto' => '14_675422d98e87f.jpg'],
            ['type' => 'J', 'nome' => 'Henrique Dias', 'email' => 'henrique.dias@mail.com', 'username' => 'henrique_d', 'xp' => rand(1, 2751), 'foto' => '30_675422dab406f.jpg'],
            ['type' => 'J', 'nome' => 'Inês Pinto', 'email' => 'ines.pinto@mail.com', 'username' => 'ines_p', 'xp' => rand(1, 2751), 'foto' => '16_675422d991db7.jpg'],
            ['type' => 'J', 'nome' => 'João Almeida', 'email' => 'joao.almeida@mail.com', 'username' => 'joaoa', 'xp' => rand(1, 2751), 'foto' => '38_675422da76f01.jpg'],
            ['type' => 'J', 'nome' => 'Karina Ramos', 'email' => 'karina.ramos@mail.com', 'username' => 'karinar', 'xp' => rand(1, 2751), 'foto' => '7_675422d97dfd2.jpg'],
            ['type' => 'J', 'nome' => 'Luís Fonseca', 'email' => 'luis.fonseca@mail.com', 'username' => 'lfonseca', 'xp' => rand(1, 2751), 'foto' => '5_675422d977e4e.jpg'],
            ['type' => 'J', 'nome' => 'Marta Carvalho', 'email' => 'marta.carvalho@mail.com', 'username' => 'martac', 'xp' => rand(1, 2751), 'foto' => '25_675422d9e7c4a.jpg'],
            ['type' => 'J', 'nome' => 'Nuno Reis', 'email' => 'nuno.reis@mail.com', 'username' => 'nreis', 'xp' => rand(1, 2751), 'foto' => '13_675422d98cbce.jpg'],
            ['type' => 'J', 'nome' => 'Olívia Teixeira', 'email' => 'olivia.teixeira@mail.com', 'username' => 'olivia_t', 'xp' => rand(1, 2751), 'foto' => '8_675422d980ad7.jpg'],
            ['type' => 'J', 'nome' => 'Paulo Matos', 'email' => 'paulo.matos@mail.com', 'username' => 'paulom', 'xp' => rand(1, 2751), 'foto' => '12_675422d98a36b.jpg'],
            ['type' => 'J', 'nome' => 'Quélia Tavares', 'email' => 'quelia.tavares@mail.com', 'username' => 'queliat', 'xp' => rand(1, 2751), 'foto' => '1_675422d96d11b.jpg'],
            ['type' => 'J', 'nome' => 'Ricardo Vieira', 'email' => 'ricardo.vieira@mail.com', 'username' => 'ricardov', 'xp' => rand(1, 2751), 'foto' => '11_675422d98863c.jpg'],
            ['type' => 'J', 'nome' => 'Sara Monteiro', 'email' => 'sara.monteiro@mail.com', 'username' => 'saram', 'xp' => rand(1, 2751), 'foto' => '9_675422d982f13.jpg'],
            ['type' => 'J', 'nome' => 'Tiago Cruz', 'email' => 'tiago.cruz@mail.com', 'username' => 'tiagoc', 'xp' => rand(1, 2751), 'foto' => '10_675422d9859ad.jpg'],
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
