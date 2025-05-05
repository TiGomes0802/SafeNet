<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pagina;

class PaginasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      $paginas = [
        ["descricao" => "A engenharia social é uma técnica que explora o comportamento humano para obter acesso a informação confidencial.", "ordem" => 1, "idUnidade" => 1],
        ["descricao" => "Os ataques seguem normalmente 3 fases: recolha de dados, construção do engano e execução.", "ordem" => 2, "idUnidade" => 1],
        ["descricao" => "Exemplos comuns incluem emails de phishing, chamadas falsas ou tentativas de manipulação por confiança.", "ordem" => 3, "idUnidade" => 1],
        ["descricao" => "Phishing (email, SMS) e Vishing (chamadas) são formas de enganar as vítimas para obter dados sensíveis.", "ordem" => 1, "idUnidade" => 2],
        ["descricao" => "Pretexting é criar uma história falsa para enganar a vítima. Baiting envolve iscos físicos ou digitais.", "ordem" => 2, "idUnidade" => 2],
        ["descricao" => "Shoulder surfing e tailgating exploram distrações físicas para obter acesso não autorizado.", "ordem" => 3, "idUnidade" => 2],
        ["descricao" => "Desconfiar de urgências e verificar remetentes são boas práticas contra ataques de engenharia social.", "ordem" => 1, "idUnidade" => 3],
        ["descricao" => "Caso sejas alvo, deves evitar interagir, reportar à equipa certa e alertar os colegas.", "ordem" => 2, "idUnidade" => 3],
        ["descricao" => "Uma cultura de segurança inclui formação regular, comunicação e simulações de ataques.", "ordem" => 3, "idUnidade" => 3]
      ];

      foreach ($paginas as $pagina) {
        Pagina::create($pagina);
      }    
    }
}
