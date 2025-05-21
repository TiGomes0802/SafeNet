<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Unidade;

class UnidadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $unidades = [
            ['titulo' => 'Introdução à Engenharia Social', 'descricao' => 'Esta unidade apresenta o conceito de engenharia social, explicando como os atacantes exploram o fator humano para obter informações ou acessos. Através de exemplos reais e históricos, o objetivo é ajudar a reconhecer estas técnicas e perceber porque são tão eficazes.', 'ordem' => 1, 'estado' => true, 'idCurso' => 1],
            ['titulo' => 'Psicologia da Manipulação', 'descricao' => 'Através do estudo de princípios de persuasão, gatilhos emocionais e exemplos reais de ataques, esta unidade visa desenvolver a consciência crítica sobre as estratégias usadas em esquemas como phishing, vishing e smishing, promovendo uma maior capacidade para reconhecer e resistir a tentativas de manipulação.', 'ordem' => 2, 'estado' => true, 'idCurso' => 1],
            ['titulo' => 'Principais Técnicas de Engenharia Social', 'descricao' => 'Esta unidade apresenta as principais técnicas usadas por atacantes, como phishing, vishing, pretexting e baiting. Ao conhecer exemplos digitais, presenciais e mistos, o objetivo é ajudar os utilizadores a identificar estas abordagens e proteger-se de forma mais eficaz.', 'ordem' => 3, 'estado' => true, 'idCurso' => 1],
            ['titulo' => 'Engenharia Social no Ambiente Corporativo', 'descricao' => 'Focando no contexto empresarial, esta unidade mostra como a engenharia social afeta diferentes setores dentro das empresas, os impactos que pode causar e as técnicas mais usadas pelos atacantes. Visa reforçar a importância de políticas de segurança e da formação contínua nas organizações.', 'ordem' => 4, 'estado' => true, 'idCurso' => 1],
            ['titulo' => 'Prevenção e Defesa Contra Engenharia Social', 'descricao' => 'Esta unidade ensina a reconhecer sinais de manipulação, adotar boas práticas de segurança no dia a dia e reagir corretamente a tentativas de ataque. Também aborda como criar uma cultura de segurança que envolva toda a organização, promovendo comportamentos mais seguros.', 'ordem' => 5, 'estado' => true, 'idCurso' => 1],
        ];

        foreach ($unidades as $unidade) {
            Unidade::create($unidade);
        }
    }
}
