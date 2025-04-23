<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            // Clientes
            ['type' => 'J', 'nome' => 'Cliente1', 'email' => 'cliente1@mail.com', 'username' => 'cliente1'],
            ['type' => 'J', 'nome' => 'Cliente2', 'email' => 'cliente2@mail.com', 'username' => 'cliente2'],
            ['type' => 'J', 'nome' => 'Cliente3', 'email' => 'cliente3@mail.com', 'username' => 'cliente3'],

            // Gestores
            ['type' => 'G', 'nome' => 'Gestor1', 'email' => 'gestor1@mail.com', 'username' => 'gestor1'],
            ['type' => 'G', 'nome' => 'Gestor2', 'email' => 'gestor2@mail.com', 'username' => 'gestor2'],

            // Admins
            ['type' => 'A', 'nome' => 'Admin1', 'email' => 'admin1@mail.com', 'username' => 'admin1'],
            ['type' => 'A', 'nome' => 'Admin2', 'email' => 'admin2@mail.com', 'username' => 'admin2'],
        ];

        foreach ($users as $user) {
            User::create([
                'type' => $user['type'],
                'nome' => $user['nome'],
                'email' => $user['email'],
                'username' => $user['username'],
                'password' => Hash::make('123'),
            ]);
        }
    }
}