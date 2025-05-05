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
        ["descricao" => "<p><strong>Engenharia social</strong> é uma técnica que explora o comportamento humano para obter acesso a informação confidencial.</p>", "ordem" => 1, "idUnidade" => 1],
        ["descricao" => "<p>Os ataques seguem normalmente <strong>3 fases</strong>: <em>recolha de dados</em>, <em>construção do engano</em> e <em>execução</em>.</p>", "ordem" => 2, "idUnidade" => 1],
        ["descricao" => "<p>Exemplos comuns incluem <strong>emails de phishing</strong>, <strong>chamadas falsas</strong> ou <strong>tentativas de manipulação por confiança</strong>.</p>", "ordem" => 3, "idUnidade" => 1],
        ["descricao" => "<p><strong>Phishing</strong> (email, SMS) e <strong>Vishing</strong> (chamadas) são formas de enganar as vítimas para obter dados sensíveis.</p>", "ordem" => 1, "idUnidade" => 2],
        ["descricao" => "<p><strong>Pretexting</strong> é criar uma história falsa para enganar a vítima. <strong>Baiting</strong> envolve iscos físicos ou digitais.</p>", "ordem" => 2, "idUnidade" => 2],
        ["descricao" => "<p><strong>Shoulder surfing</strong> e <strong>tailgating</strong> exploram distrações físicas para obter acesso não autorizado.</p>", "ordem" => 3, "idUnidade" => 2],
        ["descricao" => "<p><strong>Desconfiar de urgências</strong> e <strong>verificar remetentes</strong> são boas práticas contra ataques de engenharia social.</p>", "ordem" => 1, "idUnidade" => 3],
        ["descricao" => "<p>Caso sejas alvo, deves <strong>evitar interagir</strong>, <strong>reportar à equipa certa</strong> e <strong>alertar os colegas</strong>.</p>", "ordem" => 2, "idUnidade" => 3],
        ["descricao" => "<p>Uma <strong>cultura de segurança</strong> inclui <em>formação regular</em>, <em>comunicação</em> e <em>simulações de ataques</em>.</p>", "ordem" => 3, "idUnidade" => 3]
    ];
    
      foreach ($paginas as $pagina) {
        Pagina::create($pagina);
      }    
    }
}
