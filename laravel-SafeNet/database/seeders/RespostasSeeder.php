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
            # Region Unidade 1 
                    //Pergunta 1
                        ["resposta" => "O uso de software malicioso", "certa" => 0, "idJogo" => 1],
                        ["resposta" => "A manipulação de sistemas operacionais", "certa" => 0, "idJogo" => 1],
                        ["resposta" => "A exploração do comportamento humano", "certa" => 1, "idJogo" => 1],
                        ["resposta" => "O uso de exploits em servidores", "certa" => 0, "idJogo" => 1],
                    //Pergunta 2
                        ["resposta" => "A instalação de antivírus", "certa" => 0, "idJogo" => 2],
                        ["resposta" => "A criação de um senso de urgência", "certa" => 1, "idJogo" => 2],
                        ["resposta" => "O uso de VPN", "certa" => 0, "idJogo" => 2],
                        ["resposta" => "A atualização de sistemas", "certa" => 0, "idJogo" => 2],
                    //Pergunta 3
                        ["resposta" => "A encriptação de dados sensíveis", "certa" => 0, "idJogo" => 3],
                        ["resposta" => "A tendência humana a confiar e agir por emoção", "certa" => 1, "idJogo" => 3],
                        ["resposta" => "A redundância de servidores", "certa" => 0, "idJogo" => 3],
                        ["resposta" => "A dificuldade em detectar softwares maliciosos", "certa" => 0, "idJogo" => 3],
                    //Pergunta 4
                        ["resposta" => "Subverter a infraestrutura de TI da vítima", "certa" => 0, "idJogo" => 4],
                        ["resposta" => "Roubar dados diretamente do banco de dados", "certa" => 0, "idJogo" => 4],
                        ["resposta" => "Manipular a vítima para que ela revele informações confidenciais", "certa" => 1, "idJogo" => 4],
                        ["resposta" => "Infectar o computador da vítima com malware", "certa" => 0, "idJogo" => 4],
                    //Pergunta 5
                        ["resposta" => "Dados de localização e preferências", "certa" => 0, "idJogo" => 5],
                        ["resposta" => "Dados financeiros e informações pessoais", "certa" => 0, "idJogo" => 5],
                        ["resposta" => "Dados de login e credenciais de acesso", "certa" => 1, "idJogo" => 5],
                        ["resposta" => "Dados de backup e logs do sistema", "certa" => 0, "idJogo" => 5],
                    //Pergunta 6
                        ["resposta" => "a) Invasão física de instalações", "certa" => 0, "idJogo" => 6],
                        ["resposta" => "b) Envio de um vírus por e-mail", "certa" => 0, "idJogo" => 6],
                        ["resposta" => "c) Coleta de informações através de interações sociais em redes", "certa" => 1, "idJogo" => 6],
                        ["resposta" => "d) Uso de vulnerabilidades de software", "certa" => 0, "idJogo" => 6],
                    //Pergunta 7
                        ["resposta" => "a) A presença de vulnerabilidades técnicas nos sistemas", "certa" => 0, "idJogo" => 7],
                        ["resposta" => "b) O uso de softwares de segurança mal configurados", "certa" => 0, "idJogo" => 7],
                        ["resposta" => "c) A exploração da confiança e emoções humanas", "certa" => 1, "idJogo" => 7],
                        ["resposta" => "d) O uso de senhas fracas", "certa" => 0, "idJogo" => 7],
                    //Pergunta 8
                        ["resposta" => "a) Phishing e Malware", "certa" => 0, "idJogo" => 8],
                        ["resposta" => "b) Pretexting e Phishing", "certa" => 1, "idJogo" => 8],
                        ["resposta" => "c) Vishing e Tailgating", "certa" => 0, "idJogo" => 8],
                        ["resposta" => "d) Baiting e Smishing", "certa" => 0, "idJogo" => 8],
                    //Pergunta 9
                        ["resposta" => "a) Falhas de segurança no software", "certa" => 0, "idJogo" => 9],
                        ["resposta" => "b) Erros humanos e psicológicos", "certa" => 1, "idJogo" => 9],
                        ["resposta" => "c) Falhas em sistemas operacionais", "certa" => 0, "idJogo" => 9],
                        ["resposta" => "d) Exploração de servidores", "certa" => 0, "idJogo" => 9],
                    //Pergunta 10
                        ["resposta" => "A engenharia social é uma técnica que utiliza falhas em sistemas de computador para invadir redes.", "certa" => 0, "idJogo" => 10],
                        ["resposta" => "Um dos principais objetivos da engenharia social é manipular pessoas para obter informações confidenciais.", "certa" => 1, "idJogo" => 10],
                        ["resposta" => "A engenharia social se baseia exclusivamente em ataques físicos, como roubo de dispositivos.", "certa" => 0, "idJogo" => 10],
                        ["resposta" => "Phishing é um exemplo comum de ataque de engenharia social.", "certa" => 1, "idJogo" => 10],
                        ["resposta" => "Engenheiros sociais costumam se passar por pessoas confiáveis para ganhar a confiança da vítima.", "certa" => 1, "idJogo" => 10],
                        ["resposta" => "A engenharia social explora vulnerabilidades técnicas de softwares e hardwares.", "certa" => 0, "idJogo" => 10],
                        ["resposta" => "A manipulação psicológica é uma ferramenta frequentemente usada em ataques de engenharia social.", "certa" => 1, "idJogo" => 10],
                        ["resposta" => "Engenharia social só ocorre em ambientes digitais, como e-mails ou redes sociais.", "certa" => 0, "idJogo" => 10],
                    //Pergunta 11
                        ["resposta" => "O treinamento de funcionários pode ajudar a prevenir ataques de engenharia social.", "certa" => 1, "idJogo" => 11],
                        ["resposta" => "Mesmo usuários bem treinados podem ser vítimas de engenharia social, caso não estejam atentos.", "certa" => 1, "idJogo" => 11],
                    //Pergunta 12
                        ["resposta" => "A. Smishing", "certa" => 1, "idJogo" => 12],
                        ["resposta" => "B. Spear Phishing", "certa" => 3, "idJogo" => 12],
                        ["resposta" => "C. Phishing", "certa" => 0, "idJogo" => 12],
                        ["resposta" => "D. Vishing", "certa" => 2, "idJogo" => 12],
            # endregion

            # Region Unidade 2
                    //Pergunta 1
                        ["resposta" => "Escassez", "certa" => 0, "idJogo" => 13],
                        ["resposta" => "Comprometimento e coerência", "certa" => 1, "idJogo" => 13],
                        ["resposta" => "Autoridade", "certa" => 0, "idJogo" => 13],
                        ["resposta" => "Afinidade", "certa" => 0, "idJogo" => 13],
                    //Pergunta 2
                        ["resposta" => "Medo", "certa" => 0, "idJogo" => 14],
                        ["resposta" => "Curiosidade", "certa" => 0, "idJogo" => 14],
                        ["resposta" => "Escassez", "certa" => 1, "idJogo" => 14],
                        ["resposta" => "Culpa", "certa" => 0, "idJogo" => 14],
                    //Pergunta 3
                        ["resposta" => "Alegria", "certa" => 0, "idJogo" => 15],
                        ["resposta" => "Indiferença", "certa" => 0, "idJogo" => 15],
                        ["resposta" => "Medo", "certa" => 1, "idJogo" => 15],
                        ["resposta" => "Tédio", "certa" => 0, "idJogo" => 15],
                    //Pergunta 4
                        ["resposta" => "Um programa malicioso que acelera os ataques", "certa" => 0, "idJogo" => 16],
                        ["resposta" => "Uma forma de simplificar decisões e manipular o comportamento da vítima", "certa" => 1, "idJogo" => 16],
                        ["resposta" => "Um software que identifica fraquezas em sistemas de segurança", "certa" => 0, "idJogo" => 16],
                        ["resposta" => "Uma técnica usada para hackear servidores diretamente", "certa" => 0, "idJogo" => 16],
                    //Pergunta 5
                        ["resposta" => "Aprovação social", "certa" => 0, "idJogo" => 17],
                        ["resposta" => "Reciprocidade", "certa" => 0, "idJogo" => 17],
                        ["resposta" => "Escassez", "certa" => 1, "idJogo" => 17],
                        ["resposta" => "Autoridade", "certa" => 0, "idJogo" => 17],
                    //Pergunta 6
                        ["resposta" => "Garantir que a vítima recupere seu acesso de forma segura", "certa" => 0, "idJogo" => 18],
                        ["resposta" => "Levar a vítima a agir rapidamente sem pensar nas consequências", "certa" => 1, "idJogo" => 18],
                        ["resposta" => "Fazer com que a vítima ignore a comunicação", "certa" => 0, "idJogo" => 18],
                        ["resposta" => "Oferecer uma solução detalhada para o problema", "certa" => 0, "idJogo" => 18],
                    //Pergunta 7
                        ["resposta" => "Criar um senso de escassez e urgência", "certa" => 0, "idJogo" => 19],
                        ["resposta" => "Fazer com que a vítima se sinta culpada por não ajudar", "certa" => 0, "idJogo" => 19],
                        ["resposta" => "Levar a vítima a retribuir um favor ou ação", "certa" => 1, "idJogo" => 19],
                        ["resposta" => "Gerar simpatia ao mostrar vulnerabilidade", "certa" => 0, "idJogo" => 19],
                    //Pergunta 8
                        ["resposta" => "Medo de consequências legais", "certa" => 0, "idJogo" => 20],
                        ["resposta" => "Empatia e simpatia", "certa" => 1, "idJogo" => 20],
                        ["resposta" => "Raciocínio lógico", "certa" => 0, "idJogo" => 20],
                        ["resposta" => "Curiosidade científica", "certa" => 0, "idJogo" => 20],
                    //Pergunta 9
                        ["resposta" => "Medo", "certa" => 1, "idJogo" => 21],
                        ["resposta" => "Reciprocidade", "certa" => 0, "idJogo" => 21],
                        ["resposta" => "Aprovação social", "certa" => 0, "idJogo" => 21],
                        ["resposta" => "Autoridade", "certa" => 0, "idJogo" => 21],
                    //Pergunta 10
                        ["resposta" => "Funcionários desatentos podem ser a principal porta de entrada para ataques de engenharia social em empresas.", "certa" => 1, "idJogo" => 22],
                        ["resposta" => "Apenas profissionais da área de TI precisam ser treinados contra ameaças de engenharia social.", "certa" => 0, "idJogo" => 22],
                        ["resposta" => "Senhas anotadas em papéis na mesa de trabalho são uma prática segura se o escritório for fechado.", "certa" => 0, "idJogo" => 22],
                        ["resposta" => "Se um e-mail parece vir do diretor da empresa, ele pode ser aberto e respondido sem preocupações.", "certa" => 0, "idJogo" => 22],
                        ["resposta" => "Backups e antivírus são suficientes para proteger uma empresa contra todos os ataques de engenharia social.", "certa" => 0, "idJogo" => 22],
                    //Pergunta 11
                        ["resposta" => "Visitantes não autorizados podem representar uma ameaça à segurança física de uma empresa.", "certa" => 1, "idJogo" => 23],
                        ["resposta" => "A política de segurança da informação deve ser conhecida e seguida por todos os colaboradores.", "certa" => 1, "idJogo" => 23],
                        ["resposta" => "Engenharia social pode ser usada para obter acesso físico a locais restritos dentro de uma empresa.", "certa" => 1, "idJogo" => 23],
                        ["resposta" => "A cultura organizacional influencia diretamente a eficácia da segurança contra engenharia social.", "certa" => 1, "idJogo" => 23],
                        ["resposta" => "Treinamentos regulares de conscientização são uma das melhores formas de prevenção contra engenharia social.", "certa" => 1, "idJogo" => 23],
            # endregion

            # Region Unidade 3
                    //Pergunta 1
                        ["resposta" => "É feito por telefone", "certa" => 0, "idJogo" => 24],
                        ["resposta" => "É direcionado e personalizado", "certa" => 1, "idJogo" => 24],
                        ["resposta" => "Usa deepfakes", "certa" => 0, "idJogo" => 24],
                        ["resposta" => "É sempre presencial", "certa" => 0, "idJogo" => 24],
                    //Pergunta 2
                        ["resposta" => "Smishing", "certa" => 0, "idJogo" => 25],
                        ["resposta" => "Pretexting", "certa" => 0, "idJogo" => 25],
                        ["resposta" => "Tailgating", "certa" => 1, "idJogo" => 25],
                        ["resposta" => "Vishing", "certa" => 0, "idJogo" => 25],
                    //Pergunta 3
                        ["resposta" => "Baiting", "certa" => 1, "idJogo" => 26],
                        ["resposta" => "Pretexting", "certa" => 0, "idJogo" => 26],
                        ["resposta" => "Vishing", "certa" => 0, "idJogo" => 26],
                        ["resposta" => "Deepfake", "certa" => 0, "idJogo" => 26],
                    //Pergunta 4
                        ["resposta" => "Envio de e-mails fraudulentos para ganhar dados bancários", "certa" => 0, "idJogo" => 27],
                        ["resposta" => "Criar uma falsa identidade para solicitar informações ou ações", "certa" => 1, "idJogo" => 27],
                        ["resposta" => "Usar uma ligação telefônica para enganar a vítima", "certa" => 0, "idJogo" => 27],
                        ["resposta" => "Manipular um funcionário para permitir o acesso a sistemas", "certa" => 0, "idJogo" => 27],
                    //Pergunta 5
                        ["resposta" => "Chamadas telefônicas fraudulentas", "certa" => 1, "idJogo" => 28],
                        ["resposta" => "E-mails falsificados", "certa" => 0, "idJogo" => 28],
                        ["resposta" => "Sites de phishing", "certa" => 0, "idJogo" => 28],
                        ["resposta" => "Mensagens em redes sociais", "certa" => 0, "idJogo" => 28],
                    //Pergunta 6
                        ["resposta" => "Smishing utiliza telefones fixos, enquanto phishing utiliza apenas e-mails", "certa" => 0, "idJogo" => 29],
                        ["resposta" => "Smishing usa mensagens de texto (SMS), enquanto phishing utiliza e-mails", "certa" => 1, "idJogo" => 29],
                        ["resposta" => "Smishing finge ser uma mensagem de um banco, enquanto phishing não", "certa" => 0, "idJogo" => 29],
                        ["resposta" => "Smishing é mais eficaz do que phishing por ser pessoal", "certa" => 0, "idJogo" => 29],
                    //Pergunta 7
                        ["resposta" => "Smishing é mais eficaz do que phishing por ser pessoal", "certa" => 0, "idJogo" => 30],
                        ["resposta" => "A vítima é induzida a baixar um arquivo malicioso", "certa" => 0, "idJogo" => 30],
                        ["resposta" => "A vítima é enganada por meio de um e-mail ou mensagem falsa", "certa" => 1, "idJogo" => 30],
                        ["resposta" => "O ataque ocorre exclusivamente em dispositivos móveis", "certa" => 0, "idJogo" => 30],
                    //Pergunta 8
                        ["resposta" => "E-mails falsificados", "certa" => 0, "idJogo" => 31],
                        ["resposta" => "Chamadas telefônicas fraudulentas", "certa" => 0, "idJogo" => 31],
                        ["resposta" => "Mensagens de texto (SMS)", "certa" => 1, "idJogo" => 31],
                        ["resposta" => "Links falsos em redes sociais", "certa" => 0, "idJogo" => 31],
                    //Pergunta 9
                        ["resposta" => "Links falsos em redes sociais", "certa" => 0, "idJogo" => 32],
                        ["resposta" => "Alterar a aparência de um site bancário", "certa" => 0, "idJogo" => 32],
                        ["resposta" => "Imitar a voz ou imagem de uma pessoa para enganar a vítima", "certa" => 1, "idJogo" => 32],
                        ["resposta" => "Criar um vídeo de phishing com uma marca famosa", "certa" => 0, "idJogo" => 32],
                    //Pergunta 10
                        ["resposta" => "O phishing é uma técnica de engenharia social que utiliza e-mails falsos para enganar as vítimas.", "certa" => 1, "idJogo" => 33],
                        ["resposta" => "Vishing é um ataque baseado em mensagens de texto falsas enviadas ao celular.", "certa" => 0, "idJogo" => 33],
                        ["resposta" => "O pretexting consiste em criar uma história ou identidade falsa para obter informações da vítima.", "certa" => 1, "idJogo" => 33],
                        ["resposta" => "O baiting oferece um “isco”, como um pen drive infectado, para que a vítima o utilize e permita o ataque.", "certa" => 1, "idJogo" => 33],
                        ["resposta" => "Shoulder surfing consiste em enviar links maliciosos por e-mail.", "certa" => 0, "idJogo" => 33],
                        ["resposta" => "O tailgating exige o uso de habilidades técnicas avançadas para invadir sistemas.", "certa" => 0, "idJogo" => 33],
                        ["resposta" => "O smishing utiliza mensagens de texto (SMS) para induzir a vítima a clicar em links fraudulentos.", "certa" => 1, "idJogo" => 33],
                    //Pergunta 11
                        ["resposta" => "Técnicas de engenharia social podem ocorrer tanto no mundo digital quanto presencialmente.", "certa" => 1, "idJogo" => 34],
                        ["resposta" => "Todas as técnicas de engenharia social exigem o uso de malware para funcionarem.", "certa" => 0, "idJogo" => 34],
                        ["resposta" => "Engenheiros sociais costumam explorar a curiosidade, medo ou senso de urgência da vítima.", "certa" => 1, "idJogo" => 34],
                    //Pergunta 12
                        ["resposta" => "a) A vítima clica num link ou fornece dados sensíveis.", "certa" => 1, "idJogo" => 35],
                        ["resposta" => "b) O atacante redireciona a vítima para um site falso.", "certa" => 2, "idJogo" => 35],
                        ["resposta" => "c) O atacante cria uma mensagem falsa que parece legítima.", "certa" => 0, "idJogo" => 35],
            # endregion

            # Region Unidade 4
                    //Pergunta 1
                        ["resposta" => "RH", "certa" => 0, "idJogo" => 36],
                        ["resposta" => "Financeiro", "certa" => 1, "idJogo" => 36],
                        ["resposta" => "Atendimento", "certa" => 0, "idJogo" => 36],
                        ["resposta" => "Marketing", "certa" => 0, "idJogo" => 36],
                    //Pergunta 2
                        ["resposta" => "Um superior hierárquico pedindo uma ação urgente", "certa" => 1, "idJogo" => 37],
                        ["resposta" => "Um técnico de suporte pedindo ajuda", "certa" => 0, "idJogo" => 37],
                        ["resposta" => "Um amigo da vítima", "certa" => 0, "idJogo" => 37],
                        ["resposta" => "Um fornecedor externo", "certa" => 0, "idJogo" => 37],
                    //Pergunta 3
                        ["resposta" => "Deixar senhas em papéis à vista", "certa" => 0, "idJogo" => 38],
                        ["resposta" => "Validar ordens sensíveis por mais de um canal", "certa" => 1, "idJogo" => 38],
                        ["resposta" => "Aceitar qualquer ligação de fora da empresa", "certa" => 0, "idJogo" => 38],
                        ["resposta" => "Ignorar e-mails estranhos sem reportar", "certa" => 0, "idJogo" => 38],
                    //Pergunta 4
                        ["resposta" => "Porque é o setor mais tecnológico da empresa", "certa" => 0, "idJogo" => 39],
                        ["resposta" => "Porque possui dados pessoais, financeiros e currículos dos funcionários", "certa" => 1, "idJogo" => 39],
                        ["resposta" => "Porque lida diretamente com clientes e fornecedores externos", "certa" => 0, "idJogo" => 39],
                        ["resposta" => "Porque tem acesso a sistemas de backup e armazenamento", "certa" => 0, "idJogo" => 39],
                    //Pergunta 5
                        ["resposta" => "Um hacker tenta comprometer a rede interna da empresa", "certa" => 0, "idJogo" => 40],
                        ["resposta" => "Um e-mail falsificado imita a comunicação de um alto executivo, pedindo uma transferência financeira", "certa" => 1, "idJogo" => 40],
                        ["resposta" => "Um funcionário é forçado a fornecer sua senha através de um link falso", "certa" => 0, "idJogo" => 40],
                        ["resposta" => "Um hacker finge ser um consultor externo da empresa", "certa" => 0, "idJogo" => 40],
                    //Pergunta 6
                        ["resposta" => "Impede que os funcionários acessem dados críticos da empresa", "certa" => 0, "idJogo" => 41],
                        ["resposta" => "Facilita o acesso físico a áreas protegidas", "certa" => 0, "idJogo" => 41],
                        ["resposta" => "Torna mais fácil para os atacantes manipularem os funcionários e obterem informações confidenciais", "certa" => 1, "idJogo" => 41],
                        ["resposta" => "Dificulta a implementação de novos softwares de segurança", "certa" => 0, "idJogo" => 41],
                    //Pergunta 7
                        ["resposta" => "Tailgating", "certa" => 0, "idJogo" => 42],
                        ["resposta" => "Pretexting", "certa" => 0, "idJogo" => 42],
                        ["resposta" => "CEO Fraud", "certa" => 1, "idJogo" => 42],
                        ["resposta" => "Baiting", "certa" => 0, "idJogo" => 42],
                    //Pergunta 8
                        ["resposta" => "Um ataque direcionado a pequenas empresas", "certa" => 0, "idJogo" => 43],
                        ["resposta" => "Um ataque que foca em altos executivos, como CEOs e CFOs", "certa" => 1, "idJogo" => 43],
                        ["resposta" => "O uso de software de segurança para bloquear ataques", "certa" => 0, "idJogo" => 43],
                        ["resposta" => "A coleta de informações por meio de redes sociais", "certa" => 0, "idJogo" => 43],
                    //Pergunta 9
                        ["resposta" => "Ignorar o incidente, já que ele não afeta a segurança da rede", "certa" => 0, "idJogo" => 44],
                        ["resposta" => "Permitir que o funcionário que foi vítima tome as providências", "certa" => 0, "idJogo" => 44],
                        ["resposta" => "Reportar imediatamente à equipe de segurança ou TI e coletar evidências", "certa" => 1, "idJogo" => 44],
                        ["resposta" => "Enviar um aviso para os clientes", "certa" => 0, "idJogo" => 44],
                    //Pergunta 10
                        ["resposta" => "Funcionários desatentos podem ser a principal porta de entrada para ataques de engenharia social em empresas.", "certa" => 1, "idJogo" => 45],
                        ["resposta" => "Apenas profissionais da área de TI precisam ser treinados contra ameaças de engenharia social.", "certa" => 0, "idJogo" => 45],
                        ["resposta" => "Senhas anotadas em papéis na mesa de trabalho são uma prática segura se o escritório for fechado.", "certa" => 0, "idJogo" => 45],
                        ["resposta" => "Se um e-mail parece vir do diretor da empresa, ele pode ser aberto e respondido sem preocupações.", "certa" => 0, "idJogo" => 45],
                        ["resposta" => "Backups e antivírus são suficientes para proteger uma empresa contra todos os ataques de engenharia social.", "certa" => 0, "idJogo" => 45],
                    //Pergunta 11
                        ["resposta" => "Visitantes não autorizados podem representar uma ameaça à segurança física de uma empresa.", "certa" => 1, "idJogo" => 46],
                        ["resposta" => "A política de segurança da informação deve ser conhecida e seguida por todos os colaboradores.", "certa" => 1, "idJogo" => 46],
                        ["resposta" => "Engenharia social pode ser usada para obter acesso físico a locais restritos dentro de uma empresa.", "certa" => 1, "idJogo" => 46],
                        ["resposta" => "A cultura organizacional influencia diretamente a eficácia da segurança contra engenharia social.", "certa" => 1, "idJogo" => 46],
                        ["resposta" => "Treinamentos regulares de conscientização são uma das melhores formas de prevenção contra engenharia social.", "certa" => 1, "idJogo" => 46],   
                    //Pergunta 12
                        ["resposta" => "O atacante recolhe informações sobre a empresa e as potenciais vítimas.", "certa" => 0, "idJogo" => 47],
                        ["resposta" => "O atacante contacta a vítima, utilizando uma identidade falsa ou uma situação fabricada.", "certa" => 1, "idJogo" => 47],
                        ["resposta" => "A vítima é manipulada e fornece informações confidenciais ou realiza uma acção.", "certa" => 2, "idJogo" => 47],
                        ["resposta" => "O atacante utiliza os dados obtidos para aceder a sistemas ou comprometer a organização.", "certa" => 3, "idJogo" => 47],
            # endregion

            # Region Unidade 5
                    //Pergunta 1
                        ["resposta" => "Clicar para confirmar se é falso", "certa" => 0, "idJogo" => 48],
                        ["resposta" => "Não interagir e relatar ao setor responsável", "certa" => 1, "idJogo" => 48],
                        ["resposta" => "Encaminhar para outros colegas", "certa" => 0, "idJogo" => 48],
                        ["resposta" => "Responder pedindo mais informações", "certa" => 0, "idJogo" => 48],
                    //Pergunta 2
                        ["resposta" => "Google Drive", "certa" => 0, "idJogo" => 49],
                        ["resposta" => "HaveIBeenPwned", "certa" => 1, "idJogo" => 49],
                        ["resposta" => "VPN", "certa" => 0, "idJogo" => 49],
                        ["resposta" => "LastPass", "certa" => 0, "idJogo" => 49],
                    //Pergunta 3
                        ["resposta" => "Para evitar auditorias", "certa" => 0, "idJogo" => 50],
                        ["resposta" => "Porque todos têm responsabilidade na proteção de dados", "certa" => 1, "idJogo" => 50],
                        ["resposta" => "Para centralizar as decisões em TI", "certa" => 0, "idJogo" => 50],
                        ["resposta" => "Para reduzir o uso de tecnologia", "certa" => 0, "idJogo" => 50],
                    //Pergunta 4
                        ["resposta" => "Verificar a identidade de qualquer pessoa que solicite informações sensíveis", "certa" => 0, "idJogo" => 51],
                        ["resposta" => "Usar senhas fortes e diferentes para cada serviço", "certa" => 0, "idJogo" => 51],
                        ["resposta" => "Compartilhar dados pessoais para criar empatia em interações online", "certa" => 1, "idJogo" => 51],
                        ["resposta" => "Reportar imediatamente qualquer tentativa de ataque", "certa" => 0, "idJogo" => 51],
                    //Pergunta 5
                        ["resposta" => "Permitir que todos os funcionários acessem os e-mails corporativos sem restrições", "certa" => 0, "idJogo" => 52],
                        ["resposta" => "Responder rapidamente a qualquer e-mail solicitando informações de pagamento", "certa" => 0, "idJogo" => 52],
                        ["resposta" => "Validar ordens de pagamento e solicitações financeiras diretamente com a pessoa envolvida", "certa" => 1, "idJogo" => 52],
                        ["resposta" => "Enviar e-mails criptografados para todos os fornecedores", "certa" => 0, "idJogo" => 52],
                    //Pergunta 6
                        ["resposta" => "Criar senhas complexas e guardá-las em um cofre de dados", "certa" => 0, "idJogo" => 53],
                        ["resposta" => "Usar uma senha junto com um código enviado para o celular do usuário", "certa" => 1, "idJogo" => 53],
                        ["resposta" => "Pedir a confirmação de um endereço de e-mail para login", "certa" => 0, "idJogo" => 53],
                        ["resposta" => "Redefinir a senha a cada 24 horas para evitar ataques", "certa" => 0, "idJogo" => 53],
                    //Pergunta 7
                        ["resposta" => "Aumenta a complexidade das senhas", "certa" => 0, "idJogo" => 54],
                        ["resposta" => "Adiciona uma camada extra de segurança, dificultando o acesso de atacantes", "certa" => 1, "idJogo" => 54],
                        ["resposta" => "Elimina a necessidade de criar senhas fortes", "certa" => 0, "idJogo" => 54],
                        ["resposta" => "Facilita o uso de senhas em todos os dispositivos", "certa" => 0, "idJogo" => 54],
                    //Pergunta 8
                        ["resposta" => "Ignorar e-mails de desconhecidos, sem verificações adicionais", "certa" => 0, "idJogo" => 55],
                        ["resposta" => "Verificar sempre a autenticidade do remetente e a URL do link", "certa" => 1, "idJogo" => 55],
                        ["resposta" => "Responder rapidamente a solicitações urgentes de e-mails", "certa" => 0, "idJogo" => 55],
                        ["resposta" => "Deixar o filtro de spam desativado para não perder e-mails importantes", "certa" => 0, "idJogo" => 55],
                    //Pergunta 9
                        ["resposta" => "Permitir que os funcionários escolham suas próprias ferramentas de segurança", "certa" => 0, "idJogo" => 56],
                        ["resposta" => "Garantir que os funcionários apenas usem dispositivos móveis pessoais", "certa" => 0, "idJogo" => 56],
                        ["resposta" => "Treinamentos contínuos, medidas de prevenção e uma cultura de segurança", "certa" => 1, "idJogo" => 56],
                        ["resposta" => "Acesso irrestrito aos sistemas corporativos para todos os funcionários", "certa" => 0, "idJogo" => 56],
                    //Pergunta 10
                        ["resposta" => "Conscientização dos colaboradores é uma das formas mais eficazes de prevenir ataques de engenharia social.", "certa" => 1, "idJogo" => 57],
                        ["resposta" => "Softwares de antivírus e firewalls são suficientes para evitar qualquer tipo de ataque de engenharia social.", "certa" => 0, "idJogo" => 57],
                        ["resposta" => "Políticas de segurança da informação devem ser atualizadas e comunicadas regularmente aos funcionários.", "certa" => 1, "idJogo" => 57],
                        ["resposta" => "Se uma pessoa parece confiável, não há necessidade de verificar sua identidade em um ambiente corporativo.", "certa" => 0, "idJogo" => 57],
                        ["resposta" => "Simulações de ataques, como campanhas de phishing interno, ajudam a testar e reforçar a conscientização dos funcionários.", "certa" => 1, "idJogo" => 57],
                    //Pergunta 11
                        ["resposta" => "O uso de autenticação de dois fatores (2FA) dificulta o acesso indevido a contas corporativas.", "certa" => 1, "idJogo" => 58],
                        ["resposta" => "Somente empresas grandes precisam se preocupar com engenharia social.", "certa" => 0, "idJogo" => 58],
                        ["resposta" => "Manter sigilo sobre informações internas da empresa nas redes sociais é uma prática de defesa importante.", "certa" => 1, "idJogo" => 58],
                        ["resposta" => "Treinamentos sobre segurança devem ser oferecidos apenas uma vez, durante a integração dos novos funcionários.", "certa" => 0, "idJogo" => 58],
                        ["resposta" => "Uma resposta rápida a incidentes pode minimizar os danos causados por um ataque de engenharia social.", "certa" => 1, "idJogo" => 58],
                    //Pergunta 12
                        ["resposta" => "Utilização de ferramentas de segurança como filtros de e-mail e antivírus", "certa" => 3, "idJogo" => 59],
                        ["resposta" => "Promoção de uma cultura organizacional de segurança", "certa" => 4, "idJogo" => 59],
                        ["resposta" => "Treinamento contínuo dos funcionários", "certa" => 0, "idJogo" => 59],
                        ["resposta" => "Implementação de políticas e procedimentos de segurança", "certa" => 1, "idJogo" => 59],
                        ["resposta" => "Validação rigorosa de solicitações de informações sensíveis", "certa" => 2, "idJogo" => 59],
            # endregion            
        ];

        foreach ($respotas as $resposta) {
            Resposta::create($resposta);
        }
    }
}
