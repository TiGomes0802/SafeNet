<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Resposta;

class RespostasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $respotas = [
            ["resposta" => "Instalação de malware por um link automático", "certa" => 0, "idJogo" => 1],
            ["resposta" => "Ataque DDoS a um servidor", "certa" => 0, "idJogo" => 1],
            ["resposta" => "Email falso a pedir credenciais bancárias", "certa" => 1, "idJogo" => 1],
            ["resposta" => "Furto de um dispositivo físico", "certa" => 0, "idJogo" => 1],
            ["resposta" => "Pode ser uma tentativa de engenharia social.", "certa" => 1, "idJogo" => 2],
            ["resposta" => "É seguro responder se parecer importante.", "certa" => 0, "idJogo" => 2],
            ["resposta" => "Deve-se verificar a origem do email.", "certa" => 1, "idJogo" => 2],
            ["resposta" => "Recolha de informação", "certa" => 0, "idJogo" => 3],
            ["resposta" => "Engano elaborado", "certa" => 1, "idJogo" => 3],
            ["resposta" => "Execução do ataque", "certa" => 2, "idJogo" => 3],
            ["resposta" => "Phishing por email", "certa" => 0, "idJogo" => 4],
            ["resposta" => "Instalação de um antivírus", "certa" => 1, "idJogo" => 4],
            ["resposta" => "Chamada telefónica fraudulenta", "certa" => 0, "idJogo" => 4],
            ["resposta" => "Mensagem SMS a pedir dados pessoais", "certa" => 0, "idJogo" => 4],
            ["resposta" => "Isto é um comportamento típico em engenharia social.", "certa" => 1, "idJogo" => 5],
            ["resposta" => "É uma técnica exclusivamente técnica.", "certa" => 0, "idJogo" => 5],
            ["resposta" => "Não representa perigo se a pessoa for conhecida.", "certa" => 0, "idJogo" => 5],
            ["resposta" => "Envio do email de phishing", "certa" => 0, "idJogo" => 6],
            ["resposta" => "Clicar no link e inserir dados", "certa" => 1, "idJogo" => 6],
            ["resposta" => "Roubo das credenciais", "certa" => 2, "idJogo" => 6],
            ["resposta" => "Enviar um link para um website malicioso", "certa" => 0, "idJogo" => 7],
            ["resposta" => "Fingir ser um técnico de informática para pedir acesso", "certa" => 1, "idJogo" => 7],
            ["resposta" => "Observar alguém a escrever a palavra-passe", "certa" => 0, "idJogo" => 7],
            ["resposta" => "Deixar uma pen com malware num local público", "certa" => 0, "idJogo" => 7],
            ["resposta" => "Isto chama-se tailgating.", "certa" => 1, "idJogo" => 8],
            ["resposta" => "É um comportamento seguro e aceitável.", "certa" => 0, "idJogo" => 8],
            ["resposta" => "É irrelevante em termos de segurança.", "certa" => 0, "idJogo" => 8],
            ["resposta" => "Phishing", "certa" => 0, "idJogo" => 9],
            ["resposta" => "Vishing", "certa" => 1, "idJogo" => 9],
            ["resposta" => "Tailgating", "certa" => 2, "idJogo" => 9],
            ["resposta" => "Ameaçar alguém para obter informação", "certa" => 0, "idJogo" => 10],
            ["resposta" => "Deixar um objeto físico como isco para a vítima interagir", "certa" => 1, "idJogo" => 10],
            ["resposta" => "Observar discretamente uma password", "certa" => 0, "idJogo" => 10],
            ["resposta" => "Enganar alguém com um pedido falso", "certa" => 0, "idJogo" => 10],
            ["resposta" => "Ambas procuram enganar, mas usam meios diferentes.", "certa" => 1, "idJogo" => 11],
            ["resposta" => "Phishing é legal e seguro.", "certa" => 0, "idJogo" => 11],
            ["resposta" => "Vishing é apenas um erro de comunicação.", "certa" => 0, "idJogo" => 11],
            ["resposta" => "Phishing genérico", "certa" => 0, "idJogo" => 12],
            ["resposta" => "Phishing dirigido (spear phishing)", "certa" => 1, "idJogo" => 12],
            ["resposta" => "Pretexting com múltiplas interações", "certa" => 2, "idJogo" => 12],
            ["resposta" => "Responder ao remetente para confirmar", "certa" => 0, "idJogo" => 13],
            ["resposta" => "Clicar nos links para ver se são perigosos", "certa" => 0, "idJogo" => 13],
            ["resposta" => "Não interagir e reportar à equipa de segurança", "certa" => 1, "idJogo" => 13],
            ["resposta" => "Eliminar e esquecer o assunto", "certa" => 0, "idJogo" => 13],
            ["resposta" => "Sim, aumenta a consciencialização dos colaboradores.", "certa" => 1, "idJogo" => 14],
            ["resposta" => "Não tem qualquer efeito prático.", "certa" => 0, "idJogo" => 14],
            ["resposta" => "Só técnicos devem receber formação.", "certa" => 0, "idJogo" => 14],
            ["resposta" => "Evitar responder", "certa" => 0, "idJogo" => 15],
            ["resposta" => "Reportar à equipa responsável", "certa" => 1, "idJogo" => 15],
            ["resposta" => "Informar os colegas", "certa" => 2, "idJogo" => 15],
            ["resposta" => "Partilhar passwords entre colegas", "certa" => 0, "idJogo" => 16],
            ["resposta" => "Confirmar sempre identidades", "certa" => 1, "idJogo" => 16],
            ["resposta" => "Desligar a firewall", "certa" => 0, "idJogo" => 16],
            ["resposta" => "Evitar backups", "certa" => 0, "idJogo" => 16],
            ["resposta" => "É seguro clicar se o número parecer oficial.", "certa" => 0, "idJogo" => 17],
            ["resposta" => "Deves confirmar a mensagem por outro canal.", "certa" => 1, "idJogo" => 17],
            ["resposta" => "Ignorar completamente é sempre o melhor.", "certa" => 0, "idJogo" => 17],
            ["resposta" => "Desconfiar de urgências", "certa" => 0, "idJogo" => 18],
            ["resposta" => "Verificar remetentes", "certa" => 1, "idJogo" => 18],
            ["resposta" => "Reportar incidentes", "certa" => 2, "idJogo" => 18]
        ];

        foreach ($respotas as $resposta) {
            Resposta::create($resposta);
        }
    }
}
