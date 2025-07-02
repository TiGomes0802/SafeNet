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
          # Region Unidade 1 -> 12 Questões
            [
              "xp" => 25,
              "pergunta" => "O que diferencia um ataque de engenharia social de um ataque técnico?",
              "estado" => true,
              "idGestor" => 6,
              "idTipo" => 1,
              "idUnidade" => 1
            ],
            [
              "xp" => 25,
              "pergunta" => "Qual é uma característica comum em ataques de engenharia social?",
              "estado" => true,
              "idGestor" => 6,
              "idTipo" => 1,
              "idUnidade" => 1
            ],
            [
              "xp" => 25,
              "pergunta" => "O que torna a engenharia social tão eficaz?",
              "estado" => true,
              "idGestor" => 6,
              "idTipo" => 1,
              "idUnidade" => 1
            ],
            [
              "xp" => 25,
              "pergunta" => "Qual é o principal objetivo de um ataque de engenharia social?",
              "estado" => true,
              "idGestor" => 6,
              "idTipo" => 1,
              "idUnidade" => 1
            ],
            [
              "xp" => 25,
              "pergunta" => "Quais tipos de dados são mais frequentemente visados em ataques de engenharia social?",
              "estado" => true,
              "idGestor" => 6,
              "idTipo" => 1,
              "idUnidade" => 1
            ],
            [
              "xp" => 25,
              "pergunta" => "O que pode ser considerado um ataque indireto de engenharia social?",
              "estado" => true,
              "idGestor" => 6,
              "idTipo" => 1,
              "idUnidade" => 1
            ],
            [
              "xp" => 25,
              "pergunta" => "Qual é a principal razão pela qual ataques de engenharia social são eficazes?",
              "estado" => true,
              "idGestor" => 6,
              "idTipo" => 1,
              "idUnidade" => 1
            ],
            [
              "xp" => 25,
              "pergunta" => "Quais são os dois principais tipos de ataque em engenharia social?",
              "estado" => true,
              "idGestor" => 6,
              "idTipo" => 1,
              "idUnidade" => 1
            ],
            [
              "xp" => 25,
              "pergunta" => "A engenharia social concentra-se principalmente em que tipo de vulnerabilidade?",
              "estado" => true,
              "idGestor" => 6,
              "idTipo" => 1,
              "idUnidade" => 1
            ],
            [
              "xp" => 25,
              "pergunta" => "O que é a engenharia social e como funciona para manipular pessoas e obter informações?",
              "estado" => true,
              "idGestor" => 6,
              "idTipo" => 2,
              "idUnidade" => 1
            ],
            [
              "xp" => 25,
              "pergunta" => "Como é possível prevenir ataques de engenharia social e quem está mais vulnerável aos mesmos?",
              "estado" => true,
              "idGestor" => 6,
              "idTipo" => 2,
              "idUnidade" => 1
            ],
            [
              "xp" => 25,
              "pergunta" => "Ordena as seguintes formas de ataque de engenharia social do mais genérico para o mais direcionado:",
              "estado" => true,
              "idGestor" => 6,
              "idTipo" => 3,
              "idUnidade" => 1
            ],
          # endregion

          # Region Unidade 2 -> 11 Questões
            [
              "xp" => 25,
              "pergunta" => 'Que princípio psicológico está relacionado ao desejo de parecer coerente com decisões anteriores?',
              "estado" => true,
              "idGestor" => 6,
              "idTipo" => 1,
              "idUnidade" => 2
            ],
            [
              "xp" => 25,
              "pergunta" => 'Um e-mail diz: "Esta promoção é só para os 10 primeiros!" – que gatilho foi usado?',
              "estado" => true,
              "idGestor" => 6,
              "idTipo" => 1,
              "idUnidade" => 2
            ],
            [
              "xp" => 25,
              "pergunta" => 'Qual dos seguintes sentimentos é comumente explorado em mensagens de engenharia social?',
              "estado" => true,
              "idGestor" => 6,
              "idTipo" => 1,
              "idUnidade" => 2
            ],
            [
              "xp" => 25,
              "pergunta" => 'O que é um "atalho mental" utilizado em ataques de engenharia social?',
              "estado" => true,
              "idGestor" => 6,
              "idTipo" => 1,
              "idUnidade" => 2
            ],
            [
              "xp" => 25,
              "pergunta" => 'Qual é o gatilho psicológico usado ao enviar uma mensagem de "última chance" para o destinatário?',
              "estado" => true,
              "idGestor" => 6,
              "idTipo" => 1,
              "idUnidade" => 2
            ],
            [
              "xp" => 25,
              "pergunta" => 'A técnica de criar um senso de urgência numa comunicação visa:',
              "estado" => true,
              "idGestor" => 6,
              "idTipo" => 1,
              "idUnidade" => 2
            ],
            [
              "xp" => 25,
              "pergunta" => 'A técnica de "reciprocidade" é um princípio psicológico que pode ser usado para:',
              "estado" => true,
              "idGestor" => 6,
              "idTipo" => 1,
              "idUnidade" => 2
            ],
            [
              "xp" => 25,
              "pergunta" => 'Qual é o fator psicológico mais frequentemente explorado quando um atacante tenta estabelecer uma conexão emocional com a vítima?',
              "estado" => true,
              "idGestor" => 6,
              "idTipo" => 1,
              "idUnidade" => 2
            ],
            [
              "xp" => 25,
              "pergunta" => 'Quando um ataque usa uma linguagem de urgência ou ameaça, qual é o gatilho psicológico que está a ser explorado?',
              "estado" => true,
              "idGestor" => 6,
              "idTipo" => 1,
              "idUnidade" => 2
            ],
            [
              "xp" => 25,
              "pergunta" => 'Quais são os mecanismos psicológicos mais comuns usados na manipulação e como funcionam?',
              "estado" => true,
              "idGestor" => 6,
              "idTipo" => 2,
              "idUnidade" => 2
            ],
            [
              "xp" => 25,
              "pergunta" => 'Quem está mais vulnerável à manipulação psicológica e porquê?',
              "estado" => true,
              "idGestor" => 6,
              "idTipo" => 2,
              "idUnidade" => 2
            ],
          # endregion

          # Region Unidade 3 -> 12 Questões
            [
              "xp" => 25,
              "pergunta" => 'O que diferencia spear phishing do phishing comum?',
              "estado" => true,
              "idGestor" => 6,
              "idTipo" => 1,
              "idUnidade" => 3
            ],
            [
              "xp" => 25,
              "pergunta" => 'Qual é o nome da técnica onde alguém entra atrás de um funcionário sem crachá?',
              "estado" => true,
              "idGestor" => 6,
              "idTipo" => 1,
              "idUnidade" => 3
            ],
            [
              "xp" => 25,
              "pergunta" => 'Um hacker deixa uma pen “achada” numa recepção. Que técnica está a ser utilizada?',
              "estado" => true,
              "idGestor" => 6,
              "idTipo" => 1,
              "idUnidade" => 3
            ],
            [
              "xp" => 25,
              "pergunta" => 'O que caracteriza a técnica de pretexting?',
              "estado" => true,
              "idGestor" => 6,
              "idTipo" => 1,
              "idUnidade" => 3
            ],
            [
              "xp" => 25,
              "pergunta" => 'Quando um ataque utiliza vishing, qual é o principal vetor do ataque?',
              "estado" => true,
              "idGestor" => 6,
              "idTipo" => 1,
              "idUnidade" => 3
            ],
            [
              "xp" => 25,
              "pergunta" => 'Qual é a diferença entre smishing e phishing?',
              "estado" => true,
              "idGestor" => 6,
              "idTipo" => 1,
              "idUnidade" => 3
            ],
            [
              "xp" => 25,
              "pergunta" => 'Qual é a principal característica do phishing?',
              "estado" => true,
              "idGestor" => 6,
              "idTipo" => 1,
              "idUnidade" => 3
            ],
            [
              'xp' => 25,
              'pergunta' => 'Num ataque de smishing, o atacante utiliza que meio para enganar a vítima?',
              'estado' => true,
              'idGestor' => 6,
              'idTipo' => 1,
              'idUnidade' => 3
            ],
            [
              'xp' => 25,
              'pergunta' => 'Quando um atacante tenta usar a técnica de deepfake num ataque de engenharia social, ele está a tentar:',
              'estado' => true,
              'idGestor' => 6,
              'idTipo' => 1,
              'idUnidade' => 3
            ],
            [
              'xp' => 25,
              'pergunta' => 'Quais são as principais técnicas utilizadas em ataques de engenharia social e como funcionam?',
              'estado' => true,
              'idGestor' => 6,
              'idTipo' => 2,
              'idUnidade' => 3
            ],
            [
              'xp' => 25,
              'pergunta' => 'Quais são os princípios e comportamentos comuns nos ataques de engenharia social?',
              'estado' => true,
              'idGestor' => 6,
              'idTipo' => 2,
              'idUnidade' => 3
            ],
            [
              'xp' => 25,
              'pergunta' => 'Ordena cronologicamente os passos típicos de um ataque de phishing.',
              'estado' => true,
              'idGestor' => 6,
              'idTipo' => 3,
              'idUnidade' => 3
            ],
          # endregion

          # Region Unidade 4 -> 12 Questões
            [
              'xp' => 25,
              'pergunta' => 'Que setor é geralmente alvo por possuir dados bancários e financeiros?',
              'estado' => true,
              'idGestor' => 6,
              'idTipo' => 1,
              'idUnidade' => 4
            ],
            [
              'xp' => 25,
              'pergunta' => 'A técnica “Business Email Compromise” normalmente simula:',
              'estado' => true,
              'idGestor' => 6,
              'idTipo' => 1,
              'idUnidade' => 4
            ],
            [
              'xp' => 25,
              'pergunta' => 'Uma prática recomendada para evitar ataques é:',
              'estado' => true,
              'idGestor' => 6,
              'idTipo' => 1,
              'idUnidade' => 4
            ],
            [
              'xp' => 25,
              'pergunta' => 'Qual a principal razão pela qual RH é um setor comumente visado por engenheiros sociais?',
              'estado' => true,
              'idGestor' => 6,
              'idTipo' => 1,
              'idUnidade' => 4
            ],
            [
              'xp' => 25,
              'pergunta' => 'O que caracteriza a técnica de "CEO Fraud" no ambiente corporativo?',
              'estado' => true,
              'idGestor' => 6,
              'idTipo' => 1,
              'idUnidade' => 4
            ],
            [
              'xp' => 25,
              'pergunta' => 'Num cenário corporativo, como é que a falta de conscientização sobre segurança pode ser um risco?',
              'estado' => true,
              'idGestor' => 6,
              'idTipo' => 1,
              'idUnidade' => 4
            ],
            [
              'xp' => 25,
              'pergunta' => 'Num ambiente corporativo, qual técnica de engenharia social visa enganar os funcionários de uma organização para que executem uma tarefa, como transferir fundos ou fornecer informações confidenciais?',
              'estado' => true,
              'idGestor' => 6,
              'idTipo' => 1,
              'idUnidade' => 4
            ],
            [
              'xp' => 25,
              'pergunta' => 'O que caracteriza o "whaling"?',
              'estado' => true,
              'idGestor' => 6,
              'idTipo' => 1,
              'idUnidade' => 4
            ],
            [
              'xp' => 25,
              'pergunta' => 'O que deve ser feito numa organização quando se identifica um ataque de engenharia social?',
              'estado' => true,
              'idGestor' => 6,
              'idTipo' => 1,
              'idUnidade' => 4
            ],
            [
              'xp' => 25,
              'pergunta' => 'Quais comportamentos e práticas internas aumentam o risco de ataques de engenharia social nas organizações?',
              'estado' => true,
              'idGestor' => 6,
              'idTipo' => 2,
              'idUnidade' => 4
            ],
            [
              'xp' => 25,
              'pergunta' => 'Que medidas e atitudes organizacionais ajudam a prevenir ataques de engenharia social?',
              'estado' => true,
              'idGestor' => 6,
              'idTipo' => 2,
              'idUnidade' => 4
            ],
            [
              'xp' => 25,
              'pergunta' => 'Ordena cronologicamente os passos típicos de um ataque de engenharia social no ambiente corporativo.',
              'estado' => true,
              'idGestor' => 6,
              'idTipo' => 3,
              'idUnidade' => 4
            ],
          # endregion

          # Region Unidade 5 -> 12 Questões
            [
              'xp' => 25,
              'pergunta' => 'Qual a atitude correta ao receber um e-mail suspeito?',
              'estado' => true,
              'idGestor' => 6,
              'idTipo' => 1,
              'idUnidade' => 5
            ],
            [
              'xp' => 25,
              'pergunta' => 'Qual ferramenta ajuda a verificar se o seu e-mail foi comprometido?',
              'estado' => true,
              'idGestor' => 6,
              'idTipo' => 1,
              'idUnidade' => 5
            ],
            [
              'xp' => 25,
              'pergunta' => 'Porque é que a cultura de segurança é importante numa empresa?',
              'estado' => true,
              'idGestor' => 6,
              'idTipo' => 1,
              'idUnidade' => 5
            ],
            [
              'xp' => 25,
              'pergunta' => 'Qual destas ações não é recomendada para prevenir um ataque de engenharia social?',
              'estado' => true,
              'idGestor' => 6,
              'idTipo' => 1,
              'idUnidade' => 5
            ],
            [
              'xp' => 25,
              'pergunta' => 'Que prática ajuda a prevenir ataques de Business Email Compromise (BEC)?',
              'estado' => true,
              'idGestor' => 6,
              'idTipo' => 1,
              'idUnidade' => 5
            ],
            [
              'xp' => 25,
              'pergunta' => 'O que é um exemplo de "autenticação de dois fatores" (2FA)?',
              'estado' => true,
              'idGestor' => 6,
              'idTipo' => 1,
              'idUnidade' => 5
            ],
            [
              'xp' => 25,
              'pergunta' => 'Qual é a principal vantagem de usar autenticação de dois fatores (2FA)?',
              'estado' => true,
              'idGestor' => 6,
              'idTipo' => 1,
              'idUnidade' => 5
            ],
            [
              'xp' => 25,
              'pergunta' => 'Em relação à segurança em e-mails corporativos, qual é a melhor prática?',
              'estado' => true,
              'idGestor' => 6,
              'idTipo' => 1,
              'idUnidade' => 5
            ],
            [
              'xp' => 25,
              'pergunta' => 'Uma política de segurança organizacional eficaz deve incluir:',
              'estado' => true,
              'idGestor' => 6,
              'idTipo' => 1,
              'idUnidade' => 5
            ],
            [
              'xp' => 25,
              'pergunta' => 'Que práticas e políticas internas reforçam a segurança e ajudam a prevenir ataques de engenharia social?',
              'estado' => true,
              'idGestor' => 6,
              'idTipo' => 2,
              'idUnidade' => 5
            ],
            [
              'xp' => 25,
              'pergunta' => 'Que ferramentas técnicas e medidas de resposta minimizam o impacto de ataques de engenharia social e protegem os ativos da empresa?',
              'estado' => true,
              'idGestor' => 6,
              'idTipo' => 2,
              'idUnidade' => 5
            ],
            [
              'xp' => 25,
              'pergunta' => 'Ordena os seguintes passos de defesa contra engenharia social, da primeira à última linha de defesa, segundo o texto.',
              'estado' => true,
              'idGestor' => 6,
              'idTipo' => 3,
              'idUnidade' => 5
            ],
          # endregion
        ];

        foreach ($jogos as $jogo) {
          Jogo::create($jogo);
        }
    }
}
