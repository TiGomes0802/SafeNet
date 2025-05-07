<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jogo;

class JogosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jogos = [
            [
              "xp" => 10,
              "pergunta" => "Qual destas opções representa um ataque de engenharia social?",
              "estado" => true,
              "idGestor" => 6,
              "idTipo" => 1,
              "idUnidade" => 1
            ],
            [
              "xp" => 10,
              "pergunta" => "Um colaborador recebe um email do \"chefe\" com um pedido urgente de dados.",
              "estado" => true,
              "idGestor" => 6,
              "idTipo" => 2,
              "idUnidade" => 1
            ],
            [
              "xp" => 10,
              "pergunta" => "Ordena as etapas de um ataque de engenharia social típico:",
              "estado" => true,
              "idGestor" => 6,
              "idTipo" => 3,
              "idUnidade" => 1
            ],
            [
              "xp" => 10,
              "pergunta" => "Qual destas opções NÃO é uma forma de engenharia social?",
              "estado" => true,
              "idGestor" => 6,
              "idTipo" => 1,
              "idUnidade" => 1
            ],
            [
              "xp" => 10,
              "pergunta" => "O atacante tenta ganhar a confiança da vítima antes de executar o ataque.",
              "estado" => true,
              "idGestor" => 6,
              "idTipo" => 2,
              "idUnidade" => 1
            ],
            [
              "xp" => 10,
              "pergunta" => "Ordena os seguintes passos de um ataque de phishing bem-sucedido:",
              "estado" => true,
              "idGestor" => 6,
              "idTipo" => 3,
              "idUnidade" => 1
            ],
            [
              "xp" => 10,
              "pergunta" => "Qual das seguintes é uma técnica de pretexting?",
              "estado" => true,
              "idGestor" => 6,
              "idTipo" => 1,
              "idUnidade" => 2
            ],
            [
              "xp" => 10,
              "pergunta" => "Alguém segue um funcionário através de uma porta com cartão de acesso.",
              "estado" => true,
              "idGestor" => 6,
              "idTipo" => 2,
              "idUnidade" => 2
            ],
            [
              "xp" => 10,
              "pergunta" => "Ordena os tipos de engenharia social do mais digital para o mais físico:",
              "estado" => true,
              "idGestor" => 6,
              "idTipo" => 3,
              "idUnidade" => 2
            ],
            [
              "xp" => 10,
              "pergunta" => "O que é \"baiting\" em engenharia social?",
              "estado" => true,
              "idGestor" => 6,
              "idTipo" => 1,
              "idUnidade" => 2
            ],
            [
              "xp" => 10,
              "pergunta" => "Phishing e Vishing têm como objectivo enganar a vítima.",
              "estado" => true,
              "idGestor" => 6,
              "idTipo" => 2,
              "idUnidade" => 2
            ],
            [
              "xp" => 10,
              "pergunta" => "Ordena os seguintes ataques do mais fácil ao mais complexo:",
              "estado" => true,
              "idGestor" => 6,
              "idTipo" => 3,
              "idUnidade" => 2
            ],
            [
              "xp" => 10,
              "pergunta" => "Qual é a primeira coisa que deves fazer ao suspeitar de um email de phishing?",
              "estado" => true,
              "idGestor" => 6,
              "idTipo" => 1,
              "idUnidade" => 3
            ],
            [
              "xp" => 10,
              "pergunta" => "A formação contínua pode reduzir ataques de engenharia social.",
              "estado" => true,
              "idGestor" => 6,
              "idTipo" => 2,
              "idUnidade" => 3
            ],
            [
              "xp" => 10,
              "pergunta" => "Ordena as acções a tomar após suspeita de ataque:",
              "estado" => true,
              "idGestor" => 6,
              "idTipo" => 3,
              "idUnidade" => 3
            ],
            [
              "xp" => 10,
              "pergunta" => "Qual das seguintes medidas ajuda a prevenir ataques sociais?",
              "estado" => true,
              "idGestor" => 6,
              "idTipo" => 1,
              "idUnidade" => 3
            ],
            [
              "xp" => 10,
              "pergunta" => "Recebes um SMS de uma entidade bancária com um link suspeito.",
              "estado" => true,
              "idGestor" => 6,
              "idTipo" => 2,
              "idUnidade" => 3
            ],
            [
              "xp" => 10,
              "pergunta" => "Ordena as boas práticas de segurança por prioridade:",
              "estado" => true,
              "idGestor" => 6,
              "idTipo" => 3,
              "idUnidade" => 3
            ]
        ];

        foreach ($jogos as $jogo) {
            Jogo::create($jogo);
        }
    }
}
